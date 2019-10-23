<?php
class EDCTARIFFS extends EDCH{
	static $statuses=array('removed'=>0,'active'=>1);
	static function exists($tid){
		if(!is_numeric($tid)) return false;
		global $wpdb;
		$query="SELECT `id` FROM `".self::$_prefix."tariffs` WHERE `id`='".$wpdb->escape($tid)."' LIMIT 1";			
		$ex=$wpdb->get_results($query);
		//var_dump($query);
		if($ex && !is_wp_error($ex) && sizeOf($ex)==1) return $ex[0]->id;
		return false;
	}
	static function add($data,$options){
		$t_res=self::proceedType($data['type']);
		if($t_res===false) return false;
		global $wpdb;
		$arr=array();
		$arr['title']=$data['title'];
		$arr['type']=$data['type'];
		$arr['active']=$data['active']==1 ? 1 : 0;
		$arr['code']=$data['code'];
		$arr['price_per_year']=$data['price_per_year'];
		$arr['price_per_kwh']=$data['price_per_kwh'];
		$arr['delivery_price']=$data['delivery_price'];
		$arr['valid_from']=$data['valid_from'];
		$arr['valid_to']=$data['valid_to'];
		$arr['linked_tariff']=$data['linked_tariff'];
		$arr['tariff_image']=is_numeric($data['tariff_image']) ? $data['tariff_image'] : 0;
		$arr['legal_terms']=$data['legal_terms'];
		$arr['work_term']=$data['work_term'];
		$arr['notice_period']=$data['notice_period'];
		$arr['terms_and_conditions']=is_numeric($data['terms_and_conditions']) ? $data['terms_and_conditions'] : 0;
		$arr['status']=isset($data['status']) ? $data['status'] : self::$statuses['active'];
		$tid=$wpdb->insert(self::$_prefix.'tariffs',$arr);
		if($tid===false) return false;
		$tid=$wpdb->insert_id;
		$res=self::addTariffPostcodes($tid,$data['postcodes']);
		if($res===false) return false;
		$res=self::updateTariffOptions($tid,$arr['type'],$options);
		if($res===false) return false;
		return $tid;
	}
	static function update($tid,$data,$options){
		if(self::exists($tid)===false) return false;
		if(isset($data['type'])){
			$t_res=self::proceedType($data['type']);
			if($t_res===false) return false;
		}
		global $wpdb;
		$arr=array();
		if(isset($data['title'])) $arr['title']=$data['title'];
		if(isset($data['type'])) $arr['type']=$data['type'];
		if(isset($data['active'])) $arr['active']=$data['active']==1 ? 1 : 0;
		if(isset($data['code'])) $arr['code']=$data['code'];
		if(isset($data['price_per_year'])) $arr['price_per_year']=$data['price_per_year'];
		if(isset($data['price_per_kwh'])) $arr['price_per_kwh']=$data['price_per_kwh'];
		if(isset($data['delivery_price'])) $arr['delivery_price']=$data['delivery_price'];
		if(isset($data['valid_from'])) $arr['valid_from']=$data['valid_from'];
		if(isset($data['valid_to'])) $arr['valid_to']=$data['valid_to'];
		if(isset($data['linked_tariff'])) $arr['linked_tariff']=$data['linked_tariff'];
		if(isset($data['tariff_image'])) $arr['tariff_image']=$data['tariff_image'];
		if(isset($data['legal_terms'])) $arr['legal_terms']=$data['legal_terms'];
		if(isset($data['work_term'])) $arr['work_term']=$data['work_term'];
		if(isset($data['notice_period'])) $arr['notice_period']=$data['notice_period'];
		if(isset($data['terms_and_conditions'])) $arr['terms_and_conditions']=$data['terms_and_conditions'];
		$res=$wpdb->update(self::$_prefix.'tariffs',$arr,array('id'=>$tid));
		if($res===false) return false;
		$res=self::addTariffPostcodes($tid,$data['postcodes']);
		if($res===false) return false;
		$res=self::updateTariffOptions($tid,$arr['type'],$options);
		if($res===false) return false;
		return $tid;
	}
	static function remove($id){
		$ex=self::exists($id);
		if(!is_numeric($ex)) return false;
		global $wpdb;
		$res=$wpdb->update(self::$_prefix.'tariffs',array('status'=>0),array('id'=>$ex));
		if($result===false) return false;
		return $result;
	}
	static function addTariffPostcodes($tid,$postcodes){
		if(!is_numeric($tid)) return false;
		global $wpdb;
		$wpdb->delete(self::$_prefix.'tariff_postcodes',array('id_tariff'=>$tid));
		$res=true;
		$arr=array('id_tariff'=>$tid);
		if(is_array($postcodes)) foreach($postcodes as $p){
			$arr['id_postcode']=$p;
			$res=$wpdb->insert(self::$_prefix.'tariff_postcodes',$arr);
			if($res===false) break;
		}
		return $res;
	}
	static function updateTariffOptions($tid,$type,$options){
		if(!is_numeric($tid)) return false;
		global $wpdb;
		$tariff_options=self::getOptions($type);
		$res=true;
		foreach($tariff_options as $o){
			if($o['type']=='checkbox' && !$options[$o['key']]) $options[$o['key']]='';
			if(isset($options[$o['key']])){
				$res=self::updateOpt($tid,self::getOptionID($o['key'],'tariff'),$options[$o['key']]);
				if($res===false) break;
			}
		}
		return $res;
	}
	static function addOpt($tid,$oid,$val){		
		if(!is_numeric($tid) || !is_numeric($oid)) return false;
		global $wpdb;
		$arr=array();
		$arr['id_tariff']=$tid;
		$arr['id_option']=$oid;
		$arr['value']=$val;
		$res=$wpdb->insert(self::$_prefix.'tariff_options',$arr);
		return $res;
	}
	static function updateOpt($tid,$oid,$val){
		if(!is_numeric($tid) || !is_numeric($oid)) return false;
		global $wpdb;
		$ex=$wpdb->get_results("SELECT * FROM `".self::$_prefix."tariff_options` WHERE `id_tariff`='".$wpdb->escape($tid)."' and `id_option`='".$wpdb->escape($oid)."' LIMIT 1");
		if(sizeOf($ex)!=1) return self::addOpt($tid,$oid,$val);
		$arr=array();
		$arr['value']=$val;
		$res=$wpdb->update(self::$_prefix.'tariff_options',$arr,array('id_tariff'=>$tid,'id_option'=>$oid));
		return $res;
	}
	static function getList($params=array()){		
		self::trimArray($params);
		global $wpdb;
		$cond=array();
		$join=array();
		if(is_numeric($params['id'])) $cond[]="t.`id`='".$wpdb->escape($params['id'])."'";
		self::proceedType($params['type']);
		if($params['type']) $cond[]="t.`type`='".$wpdb->escape($params['type'])."'";
		if($params['removed']!==true) $cond[]="t.`status`<>'".self::$statuses['removed']."'";
		if($params['search']!='') $cond[]="(t.`title` LIKE '%".$params['search']."%' or t.`code` LIKE '%".$params['search']."%' or t.`title` LIKE '%".$params['search']."%' or t.`notice_period` LIKE '%".$params['search']."%')";
		if(is_numeric($params['annual_consumption'])){
			$name1=$params['type']==self::$types['electricity'] ? 'max_electricity_delivery_per_year' : 'max_gas_delivery_per_year';
			$name2=$params['type']==self::$types['electricity'] ? 'min_electricity_delivery_per_year' : 'min_gas_delivery_per_year';
			$join[]="LEFT JOIN `".self::$_prefix."tariff_options` tomx ON (
				tomx.`id_tariff`=t.`id` and tomx.`id_option`=(
					SELECT `id` FROM `".self::$_prefix."options` o WHERE o.`type`='".EDC_OPTIONS::$types['tariff']."' and o.`name`='".$name1."' LIMIT 1
				)			
			) ";
			$cond[]="(tomx.`value`>=(".$params['annual_consumption']."+0) or tomx.`value`='')";
			$join[]="LEFT JOIN `".self::$_prefix."tariff_options` tomn ON (
				tomn.`id_tariff`=t.`id` and tomn.`id_option`=(
					SELECT `id` FROM `".self::$_prefix."options` o WHERE o.`type`='".EDC_OPTIONS::$types['tariff']."' and o.`name`='".$name2."' LIMIT 1
				)			
			) ";
			$cond[]="tomn.`value`<=(".$params['annual_consumption']."+0 or tomn.`value`='')";
			//var_dump($join);
		}
		if(isset($params['postcodes'])){
			if(!is_array($params['postcodes'])) $params['postcodes']=array($params['postcodes']);
			foreach($params['postcodes'] as $k=>$v) if(!is_numeric($v)) unset($params['postcodes'][$k]);
			if(sizeOf($params['postcodes'])>0){
				$cond[]=" (
					(SELECT COUNT(*) FROM `".self::$_prefix."tariff_postcodes` WHERE `id_tariff`=t.`id`)=0 
					or 
					(SELECT COUNT(*) FROM `".self::$_prefix."tariff_postcodes` WHERE `id_tariff`=t.`id` and `id_postcode` in (".implode(',',$params['postcodes'])."))>0
				)";
			}
		}
		$sort_by='t.`title`';
		$sort_order=' ASC';
		if(isset($params['sort_by'])){
			$sort_by=$params['sort_by'];
			$sort_order='';
		}
		$limit='';
		if(is_numeric($params['per_page'])){
			$per_page=$params['per_page'];
			$page=is_numeric($params['page']) ? $params['page'] : 1;
			$limit='LIMIT '.(($params['page']-1)*$per_page).','.$per_page;
		}
		$query="SELECT t.* FROM `".self::$_prefix."tariffs` t".(sizeOf($join)>0 ? " ".implode(" ",$join) : '')." WHERE 1 ".(sizeOf($cond)==0 ? '' : ' and '.implode(' and ',$cond))." ORDER BY ".$sort_by.$sort_order.' '.$limit;
		//var_dump($query);
		$result=$wpdb->get_results($query);
		if($params['get_options']!==false || $params['get_postcodes']!==false) foreach($result as $k=>$res){
			if($params['get_options']!==false) $result[$k]->options=self::getTariffOptions($res->id);
			if($params['get_postcodes']!==false) $result[$k]->postcodes=self::getTariffPostCodes($res->id);
		}
		if($limit!=''){
			$query_count="SELECT COUNT(*) as `cnt` FROM `".self::$_prefix."tariffs` t WHERE 1 ".(sizeOf($cond)==0 ? '' : ' and '.implode(' and ',$cond))."";
			$total=$wpdb->get_results($query_count);
			$total=$total[0]->cnt;
		}else $total=sizeOf($result);
		
		return array($result,$total);
	}
	static function getOptions($type){
		$options=array();
		$options[]=array(
			'key'=>'tariff_subtitle',
			'name'=>__('Subtitle','edc'),
			'type'=>'text',
		);
		if($type==1){
			$options[]=array(
				'key'=>'min_gas_delivery_per_year',
				'name'=>__('Min. power','edc'),
				'type'=>'text',
				'placeholder'=>'',
			);
			$options[]=array(
				'key'=>'max_gas_delivery_per_year',
				'name'=>__('Max. power','edc'),
				'type'=>'text',
				'placeholder'=>'',
			);
			
			apply_filters('edc_gas_tariff_options',$options);
		}elseif($type==2){
			$options[]=array(
				'key'=>'min_electricity_delivery_per_year',
				'name'=>__('Min. power','edc'),
				'type'=>'text',
				'placeholder'=>'',
			);
			$options[]=array(
				'key'=>'max_electricity_delivery_per_year',
				'name'=>__('Max. power','edc'),
				'type'=>'text',
				'placeholder'=>'',
			);
			
			apply_filters('edc_gas_tariff_options',$options);
		}
		
		$options[]=array(
			'key'=>'tariff_description',
			'name'=>__('Description','edc'),
			'type'=>'textarea',
		);
		$options[]=array(
			'key'=>'tariff_clients_type',
			'name'=>__('For clients','edc'),
			'type'=>'radio',
			'items'=>array(
				array('value'=>1,'name'=>__('Private','edc')),
				array('value'=>2,'name'=>__('Business','edc')),
			),
			'default'=>1,
		);
		
		$options[]=array(
			'key'=>'tariff_monthly',
			'name'=>__('Monthly cost','edc'),
			'type'=>'text',
		);
		$options=apply_filters('edc_tariff_options',$options);
		return $options;
	}
	static function getTariffOptions($tid=''){
		if(!is_numeric($tid)) return false;
		global $wpdb;
		$items=$wpdb->get_results("SELECT `o`.`name`, `to`.`value` FROM `".self::$_prefix."options` as `o`,`".self::$_prefix."tariff_options` as `to` WHERE `to`.`id_tariff`='".$wpdb->escape($tid)."' and `o`.`id`=`to`.`id_option` and `o`.`type`='1'");
		$result=array();
		foreach($items as $item) $result[$item->name]=$item->value;
		return $result;
	}
	static function getTariffPostCodes($tid=''){
		if(!is_numeric($tid)) return false;
		global $wpdb;
		$items=$wpdb->get_results("SELECT `id_postcode` FROM `".self::$_prefix."tariff_postcodes` WHERE `id_tariff`='".$wpdb->escape($tid)."'");
		$result=array();
		foreach($items as $item) $result[]=$item->id_postcode;
		return $result;
	}
}
?>