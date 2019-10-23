<?php
/**
 * Neve functions.php file
 *
 * Author:          Andrei Baicus <andrei@themeisle.com>
 * Created on:      17/08/2018
 *
 * @package Neve
 */

define( 'NEVE_VERSION', '2.3.12' );
define( 'NEVE_INC_DIR', trailingslashit( get_template_directory() ) . 'inc/' );
define( 'NEVE_ASSETS_URL', trailingslashit( get_template_directory_uri() ) . 'assets/' );

if ( ! defined( 'NEVE_DEBUG' ) ) {
	define( 'NEVE_DEBUG', false );
}

/**
 * Themeisle SDK filter.
 *
 * @param array $products products array.
 *
 * @return array
 */
function neve_filter_sdk( $products ) {
	$products[] = get_template_directory() . '/style.css';

	return $products;
}

add_filter( 'themeisle_sdk_products', 'neve_filter_sdk' );

add_filter( 'themeisle_onboarding_phprequired_text', 'neve_get_php_notice_text' );

/**
 * Get php version notice text.
 *
 * @return string
 */
function neve_get_php_notice_text() {
	$message = sprintf(
		/* translators: %s message to upgrade PHP to the latest version */
		__( "Hey, we've noticed that you're running an outdated version of PHP which is no longer supported. Make sure your site is fast and secure, by %s. Neve's minimal requirement is PHP 5.4.0.", 'neve' ),
		sprintf(
			/* translators: %s message to upgrade PHP to the latest version */
			'<a href="https://wordpress.org/support/upgrade-php/">%s</a>',
			__( 'upgrading PHP to the latest version', 'neve' )
		)
	);

	return wp_kses_post( $message );
}

/**
 * Adds notice for PHP < 5.3.29 hosts.
 */
function neve_php_support() {
	printf( '<div class="error"><p>%1$s</p></div>', neve_get_php_notice_text() ); // WPCS: XSS OK.
}

if ( version_compare( PHP_VERSION, '5.3.29' ) <= 0 ) {
	/**
	 * Add notice for PHP upgrade.
	 */
	add_filter( 'template_include', '__return_null', 99 );
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'neve_php_support' );

	return;
}

require_once get_template_directory() . '/start.php';

require_once 'globals/utilities.php';
require_once 'globals/hooks.php';
require_once 'globals/sanitize-functions.php';

require_once get_template_directory() . '/header-footer-grid/loader.php';

//////// CALCULATOR EXTENSION	
if(!is_admin()){
	class EDC_Extension extends EDC{	
		public function getInstance(){
			global $edc_obj;
			if(!$edc_obj){
				$edc_obj=new EDC_Extension();
			}
			return $edc_obj;
		}
		public function inst(){
			return self::getInstance();
		}
		public function __construct(){
			parent::__construct();
			wp_enqueue_style('edc_ext_style', get_stylesheet_directory_uri() . '/edc/css/edc.css');
			add_shortcode('EDCalculator_tariff',array('EDC_Extension','singleTariffShortocode'));
		}
		protected function requestProcessing(){
			parent::requestProcessing();
			if(isset($_POST['get_postcodes_options'])) die($this->getPostCodesList($_POST['get_postcodes_options'],$_POST['type']));
			if(isset($_POST['edc_processing'])){
				if(isset($_POST['step_1']) && isset($_POST['validate'])) die($this->validateFirstStep($_POST));
				if(isset($_POST['step_1'])) $this->processFirstStep($_POST);
				if(isset($_POST['step_2']) && isset($_POST['validate'])) die($this->validateSecondStep($_POST));
				if(isset($_POST['step_2'])) $this->processSecondStep($_POST);
				if(isset($_POST['step_3']) && isset($_POST['validate'])) die($this->validateThirdStep($_POST));
				if(isset($_POST['step_3'])) $this->processThirdStep($_POST);
			}
		}
		protected function getPostCodesList($zip='',$type){
			$options='<option value="">'.__('Ort wählen','edc').'</option>';
			if($zip=='') return $options;
			list($codes,$total)=EDCH::getPostcodes(array('code'=>$zip,'type'=>$type));
			foreach($codes as $c) $options.='<option value="'.$c->name.'">'.$c->name.'</option>';
			return $options;
		}
		protected function validateFirstStep($data=array()){
			EDCH::trimArray($data);
			if(!isset(EDCH::$types[$data['type']])) return $this->ajaxResult('error',__('An error occured, please try again later.','edc'));
			if($data['zip']=='' || $data['region']==''/* || $data['street']=='' || $data['house']==''*/ || $data['annual_consumption']=='') return $this->ajaxResult('error',__('Bitte füllen Sie alle Pflichtfelder aus.','edc'));
			list($zip,$total)=EDCH::getPostcodes(array('code'=>$data['zip'],'type'=>$data['type'],'name'=>$data['region']));
			if($total==0 || sizeOf($zip)==0) return $this->ajaxResult('error',__('Bitte wenden sie sich an unser Kundenzentrum. Telefon 05681 9909-0.','edc'));
			return $this->ajaxResult('success','');
		}
		protected function processFirstStep($data=array()){		
			$this->is_tariffs_step=true;
			$postcodes=array();
			list($zips,$total)=EDCH::getPostcodes(array('code'=>$data['zip'],'type'=>$data['type'],'name'=>$data['region']));
			foreach($zips as $zip) $postcodes[]=$zip->id;
			list($tariffs,$total)=EDCH::getTariffs(array('type'=>$data['type'],'postcodes'=>$postcodes,'annual_consumption'=>$data['annual_consumption']));
			$this->tariffs=$tariffs;
			$this->first_step_data=array(
				'postcode'=>$data['zip'],
				'district'=>$data['region'],
				/*'street'=>$data['street'],
				'house'=>$data['house'],*/
				'annual_consumption'=>$data['annual_consumption'],
			);
			if($data['square']) $this->first_step_data['square']=$data['square'];
			if($data['people']) $this->first_step_data['people']=$data['people'];
		}
		protected function validateSecondStep($data=array()){
			EDCH::trimArray($data);
			$data['first_step_data']=stripslashes($data['first_step_data']);
			$fsd=json_decode($data['first_step_data'],true);
			if(!EDCH::tariffExists($data['id_tariff']) || !is_array($fsd) || sizeOf($fsd)==0) return $this->ajaxResult('error',__('Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später erneut','edc'));
			//if($fsd['postcode']=='' || $fsd['district']=='' || $fsd['street']=='' || $fsd['house']=='' || $fsd['annual_consumption']=='') return $this->ajaxResult('error',__('Error occured, please try again later','edc'));
			return $this->ajaxResult('success','');
		}
		protected function processSecondStep($data=array()){		
			$this->is_order_step=true;
			list($tariffs,$total)=EDCH::getTariffs(array('id'=>$data['id_tariff']));
			$this->tariff=$tariffs[0];
			$data['first_step_data']=stripslashes($data['first_step_data']);
			$fsd=json_decode($data['first_step_data'],true);
			$this->first_step_data=$fsd;
			$this->second_step_data=array('edc_green_electricity'=>$data['edc_green_electricity'],'edc_price_guarantee'=>$data['edc_price_guarantee']);
		}
		protected function validateThirdStep($data=array()){
			EDCH::trimArray($data);
			$data['first_step_data']=stripslashes($data['first_step_data']);
			$fsd=json_decode($data['first_step_data'],true);
			if(!EDCH::tariffExists($data['id_tariff']) || !is_array($fsd) || sizeOf($fsd)==0) return $this->ajaxResult('error',__('Error occured, please try again later','edc'));
			if($fsd['postcode']=='' || $fsd['district']=='' /*|| $fsd['street']=='' || $fsd['house']==''*/ || $fsd['annual_consumption']=='') return $this->ajaxResult('error',__('Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später erneut','edc'));
			$required=array('edc_second_name','edc_name','edc_street','edc_house','edc_email','edc_email_confirm','edc_electriс');
			foreach($required as $k) if(!$data[$k] || $data[$k]=='') return $this->ajaxResult('error',__('Mit markierte <span style="color:red">*</span> Felder sind Pflichtfelder!','edc'));
			if(isset($data['edc_electriсValue']) && $data['edc_electriсValue']!='' && !is_numeric($data['edc_electriсValue'])) return $this->ajaxResult('error',__('Mit markierte <span style="color:red">*</span> Felder sind Pflichtfelder!','edc'));
			if($data['confirm_tariff']!=1 || $data['confirm_tariff2']!=1 || $data['confirm_tariff3']!=1) return $this->ajaxResult('error',__('Bitte bestätigen Sie die erforderlichen Pflichtfelder','edc'));
			return $this->ajaxResult('success','');
		}
		protected function processThirdStep($data=array()){		
			$this->is_result_step=true;
			list($tariffs,$total)=EDCH::getTariffs(array('id'=>$data['id_tariff']));
			$this->tariff=$tariffs[0];
			$data['first_step_data']=stripslashes($data['first_step_data']);
			$data['second_step_data']=stripslashes($data['second_step_data']);
			$fsd=json_decode($data['first_step_data'],true);
			$this->first_step_data=$fsd;
			$this->second_step_data=json_decode($data['second_step_data'],true);
			$this->sendPDF($data);
		}
		private function sendPDF($data){	
			$img=get_attached_file($this->tariff->tariff_image);
			$args=[
				"title" => $this->tariff->title,
				"title2" => $this->options['subtitle'],
				"img" => $img,
				"gp" => $this->tariff->price_per_year,
				"ap" => number_format($this->tariff->price_per_kwh,2,',',' '),
				"customer" => [
					"anrede" => $data["edc_anrede"],
					"name" => $data["edc_name"],
					"surname" => $data["edc_second_name"],
					"birthday" => $data["edc_date_of_birth"],
					"street" => $data["edc_street"],
					"house" => $data["edc_house"],
					"plz" => $this->first_step_data['postcode'],
					"ort" =>  $this->first_step_data['district'],
					"phone" => $data["edc_phone"],
					"email" => $data["edc_email"],
				],
				"SERA" => [
					"value" => !empty($data["edc_sepa_direct_debit"]),
					"transfer" => !empty($data["edc_key_transfer_on"]),
					"owner" => $data["edc_holder"],
					"street" => $data["edc_streetDebit"],
					"house" => $data["edc_houseDebit"],
					"plz" => $data["edc_zipDebit"],
					"ort" => $data["edc_cityDebit"],
					"credit" => $data["edc_credit"],
					"IBAN" => $data["edc_IBAN"],
					"BIC" => $data["edc_BIC"],
				],
				"different_billing_address" => [
					"value" => !empty($data["edc_other_debit"]),
					"anrede" => $data["edc_etc_gender"],
					"name" => $data["edc_etc_surname"],
					"surname" => $data["edc_etc_name"],
					"street" => $data["edc_etc_street"],
					"house" => $data["edc_etc_house"],
					"plz" => $data["edc_etc_zip"],
					"ort" => $data["edc_etc_city"],
				],
				"current_information" => [
					"supplier" => $data["edc_provider"],
					"account" => $data["edc_contract"],
					"kWh" => $data["edc_electriсValue"],
					"el_number" => $data["edc_electriс"],
					"kWh2" => $data["edc_previous"],
					"date" => $data["edc_electriсDate"],
					"date2" => $data["edc_reade_date"],
				]
			];
			if($this->second_step_data["edc_green_electricity"]==1) $args['gp']+=($this->first_step_data['annual_consumption']*0.01)/12;
			$args['gp']=number_format($args['gp'],2,',',' ');
			$pdf=EDCH::loadTemplate('pdf',$args);
			$path=EDCH::createPDF($pdf);
			$html_path=EDC_PLUGIN_PATH.'/orders/';
			$html_name=wp_generate_password(mt_rand(30,50),false).'.html';
			while(file_exists($html_path.$html_name)) $html_name=wp_generate_password(mt_rand(30,50),false).'.html';
			$res=file_put_contents($html_path.$html_name,EDCH::loadTemplate('html',$args));
			$oid=EDCH::addOrder(array(
				'id_tariff'=>$this->tariff->id,
				'price_per_year'=>$this->tariff->price_per_year,
				'price_per_kwh'=>$this->tariff->price_per_kwh,
				'pdf_path'=>$path,
				'html_path'=>'',
				'html_name'=>$html_name,
			));
			$subject=EDCH::getOption('edc_mail_subject','settings');
			$from=EDCH::getOption('edc_mail_from','settings');
			$to=EDCH::getOption('edc_mail_to','settings');
			$mailto=$data['edc_email'];
			$message="Zusammenfassung Ihrer Bestellung bei den KBG Kraftstrom-Bezugsgenossenschaft Homberg eG.";
			$new_fname=preg_replace('/(.*)\.pdf/','Bestellung vom '.date('d.m.Y - H-i').'.pdf',basename($path));
			$new_path=str_replace(basename($path),$new_fname,$path);
			copy($path,$new_path);
			$attachments=array($new_path);
			$pdf=$this->tariff->terms_and_conditions;
			if(is_numeric($pdf)){
				$pdf=get_attached_file($pdf);
				if($pdf && !is_wp_error($pdf)) $attachments[]=$pdf;
			}
			$headers=[];
			if(is_email($from)) $headers[]='From: '.$from.'<'.$from.'>';
			$result=wp_mail($mailto,$subject,$message,$headers,$attachments);			
			if(is_email($to)){
				$result=wp_mail($to,'New order on the site','',$headers,$attachments);				
			}
		}
		public function singleTariffShortocode($args,$cont){
			list($tariff,$total)=EDCH::getTariffs(array('id'=>$args['tid']));
			if(sizeOf($tariff)!=1 || $total!=1) return '';
			return EDCH::loadTemplate('single_tariff',array('tariff'=>$tariff[0],'is_shortcode'=>true));
		}
	}
}
function addNewTariffOptions($options){
	$options[]=array(
		'key'=>'tariff_green_electricity',
		'name'=>__('Ökostrom erwünscht','edc'),
		'type'=>'checkbox',
	);
	$options[]=array(
		'key'=>'tariff_extended_price_guarantee',
		'name'=>__('Extended price guarantee desired','edc'),
		'type'=>'checkbox',
	);
	$options[]=array(
		'key'=>'tariff_unser_tip',
		'name'=>__('Unser Tipp','edc'),
		'type'=>'checkbox',
	);
	$options[]=array(
		'key'=>'tariff_network_operator',
		'name'=>__('Netzbetreiber','edc'),
		'type'=>'text',
	);
	$options[]=array(
		'key'=>'tariff_supplier',
		'name'=>__('Lieferant','edc'),
		'type'=>'text',
	);
	return $options;
}
add_filter('edc_tariff_options','addNewTariffOptions');
if(is_admin()){
	function addNewEDCSettingsFields(){
		$data['edc_result_banner']=EDCH::getOption('edc_result_banner','settings');
		$data['edc_result_banner_url']=is_numeric($data['edc_result_banner']) ? wp_get_attachment_image_url($data['edc_result_banner']) : '';
		if(!$data['edc_result_banner_url'] || is_wp_error($data['edc_result_banner_url'])) $data['edc_result_banner_url']=EDC_PLUGIN_URL . '/admin/images/no-image.jpg';
		ob_start(); ?>
		<div class="label">
			<div class="name"><?=__('Lieferant','edc')?></div>
			<div class="field">
				<input type="text" name="edc_lieferant" value="<?=EDCH::getOption('edc_lieferant','settings')?>">
			</div>
		</div>
		<div class="label">
			<div class="name"><?=__('Netzbetreiber','edc')?></div>
			<div class="field">
				<input type="text" name="edc_netzbetreiber" value="<?=EDCH::getOption('edc_netzbetreiber','settings')?>">
			</div>
		</div>
		<div class="label">
			<div class="name"><?=__('Result banner','edc')?></div>
			<div class="attachment_holder" style="background-image:url('<?=htmlspecialchars($data['edc_result_banner_url'])?>')" data-empty="<?=EDC_PLUGIN_URL . '/admin/images/no-image.jpg'?>"></div>
			<div class="field">
				<button type="button" class="button edc_media_loader" data-field="edc_result_banner"><?=__('Attach image','edc')?></button>
				<button type="button" class="button edc_media_remover" data-field="edc_result_banner">&times;</button>
			</div>
			<input type="hidden" name="edc_result_banner" value="<?=$data['edc_result_banner']?>">
		</div>
	<?php 
	echo ob_get_clean();
	}
	add_action('edc_before_main_settings','addNewEDCSettingsFields');
	function addNewEDCSettingsOptions($arr){
		$arr[]='edc_lieferant';
		$arr[]='edc_netzbetreiber';
		$arr[]='edc_result_banner';
		return $arr;
	}
	add_filter('edc_main_options','addNewEDCSettingsOptions');
}
if(is_admin() && isset($_GET['download_pdf'])){
	EDCH::downLoadOrdersPDF($_GET['download_pdf']);
	die();
}