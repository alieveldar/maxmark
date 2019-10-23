<?php
	global $edc_admin;
	if(!$edc_admin) die('Plugin corrupted'); ?>
<div class="wrap edc_admin_page orders_page">
	<div class="page_title"><?=__('EDCalculator Orders','edc')?></div>
	<div class="edc_filter">
		<form method="GET" action="">
			<?=$data['hidden_fields']?>
			<div class="label">
				<div class="field"><input type="text" placeholder="<?=__('Keyword','edc')?>" name="keyword" value="<?=$data['get_keyword']?>"></div>
			</div>
			<div class="label">
				<div class="field col_2">
					<div><input type="text" name="date_from" placeholder="<?=__('Date from','edc')?>" class="with_calendar" value="<?=$data['get_date_from']?>"></div>
					<div><input type="text" name="date_to" placeholder="<?=__('Date to','edc')?>" class="with_calendar" value="<?=$data['get_date_to']?>"></div>
				</div>
			</div>
			<div class="submit_group">
				<div class="field"><button type="submit" class="edc_submit"><?=__('Submit','edc')?></button></div>
			</div>
		</form>
	</div>
	<?php if(!is_array($data['orders']) || sizeOf($data['orders'])==0) :?>
	<div class="b i m30"><?=__('No orders have been made yet','edc')?></div>
	<?php else : ?>	
		<?php if(is_numeric($_GET['oid'])) : ?>
			<style>				
				/* offer block */
				.offer {
				  margin-top: 10px;
				  border: none;
				  display: -webkit-box;
				  display: -ms-flexbox;
				  display: flex;
				  -webkit-box-orient: vertical;
				  -webkit-box-direction: normal;
				  -ms-flex-direction: column;
				  flex-direction: column;
				  -webkit-box-align: center;
				  -ms-flex-align: center;
				  align-items: center;
				  text-align: center;
				}
				.o-form {
				  width: 100%;
				  padding: 30px 65px;
				  color: #4d606f;
				  font-size: 24px;
				}
				.o-form__stroke {
				  width: 100%;
				  display: -webkit-box;
				  display: -ms-flexbox;
				  display: flex;
				  -webkit-box-pack: justify;
				  -ms-flex-pack: justify;
				  justify-content: space-between;
				}
				.o-form__stroke_left {
					justify-content: flex-start;
				}
				.o-form__title {
				  text-align: left;
				  font-size: 22px;
				  margin-top: 40px;
				}
				.o-form__contract-text {
				  font-size: 20px;
				  margin-top: 20px;
				}
				.o-form-label {
				  font-weight: normal;
				}
				.o-form-label__name {
				  text-align: left;
				  margin-top: 15px;
				  margin-bottom: 5px;
				  font-size: 0.7em;
				  color: #666;
				}
				.o-form-label__input {
				  width: 100%;
				  height: 43px;
				  border-radius: 3px;
				  border: 1px solid #dbdfe2;
				  padding: 0 10px;
				}
				.o-form-label__input-square {
				  width: 43px !important;
				  float: left;
				  margin-right: 5px;
				  text-align: center;
				  margin-bottom: 5px;
				}
				.o-form-label__select {
				  width: 100%;
				  height: 43px;
				  border-radius: 3px;
				  border: 1px solid #dbdfe2;
				}
				.o-form-label_size-1-1 {
				  width: 100%;
				}
				.o-form-label_size-1-2 {
				  width: 48.5%;
				}
				.o-form-label_size-1-6 {
				  width: 15%;
				}
				.o-form-label_size-2-6 {
				  width: 30%;
				}
				.o-form-label_size-2-3 {
				  width: 66.7%;
				}
				.o-form-label .ui-selectmenu-button.ui-button {
				  width: 100%;
				  height: 43px;
				  border: 1px solid #dbdfe2;
				  background-color: #fff;
				  font-size: 24px;
				  padding: 5px 10px;
				}
				.o-form-label .ui-selectmenu-text {
				  font-size: 24px !important;
				}
				.ui-menu-item {
				  font-size: 18px;
				}
				.ui-button .ui-icon {
				  width: 1px;
				  height: 1px;
				  margin-top: 10px;
				  border-width: 5px;
				  border-style: solid;
				  border-color: transparent;
				  border-top-color: #333;
				}
				.o-form-radio__name {
				  margin-top: 15px;
				  margin-bottom: 5px;
				  text-align: left;
				}
				.o-form-radio__input {
				  display: none !important;
				}
				.o-form-radio__input:checked + .o-form-radio__label:after {
				  display: block;
				}
				.o-form-radio__label {
				  font-weight: normal;
				  position: relative;
				  margin-top: 10px;
				  margin-bottom: 25px;
				  padding-left: 30px;
				  cursor: pointer;
				}
				.o-form-radio__label:before {
				  position: absolute;
				  content: '';
				  top: 3px;
				  left: 0;
				  height: 26px;
				  width: 26px;
				  border: 2px solid #dbdfe2;
				  border-radius: 50%;
				}
				.o-form-radio__label:after {
				  position: absolute;
				  content: '';
				  left: 7px;
				  top: 10px;
				  height: 12px;
				  width: 12px;
				  border-radius: 50%;
				  background-color: #a2a6aa;
				  display: none;
				}
				.o-form-checkbox {
				  margin-top: 55px;
				  height: 50px;
				}
				.o-form-checkbox_top {
				  margin-top: 20px;
				}
				.o-form-checkbox__input {
				  display: none !important;
				}
				.o-form-checkbox__input:checked + .o-form-checkbox__label:after {
				  display: block;
				}
				.o-form-checkbox__label {
				  font-weight: normal;
				  position: relative;
				  padding-left: 30px;
				  cursor: pointer;
					margin-right: 30px;
					font-size: 0.7em !important;
				}
				.policy.o-form-checkbox__label:after {
					font-size: 24px;
				}
				.o-form-checkbox__label:before {
				  position: absolute;
				  content: '';
				  top: 3px;
				  left: 0;
				  height: 26px;
				  width: 26px;
				  border: 2px solid #dbdfe2;
				}
				.o-form-checkbox__label:after {
				  position: absolute;
				  content: '✓';
				  left: 5px;
				  top: 0;
				  display: none;
				}
				.policy {
				  font-size: 16px;
				  font-weight: normal;
				  display: inline-block;
				}
				.policy__input {
				  display: inline-block;
				  width: 20px;
				  height: 20px;
				}
				.policy__text {
				  width: auto;
				  display: inline;
				}
				.policy a {
				  width: auto;
				  display: inline;
				}
				/* offer block END */

				.trf-btn {
				  text-align: center;
				  display: inline-block;
				  border-radius: 3px;
				  -webkit-box-shadow: 0 15px 27px 0 #547999;
				  box-shadow: 0 15px 27px 0 #547999;
				  line-height: 40px;
				  font-size: 24px;
				  padding: 0 20px;
				  -webkit-box-shadow: 0 15px 27px 0 rgba(173, 189, 204, 0.4);
				  box-shadow: 0 15px 27px 0 rgba(173, 189, 204, 0.4);
				}
				.trf-btn_orange {
				  background-color: #ea7022;
				  border: 1px solid #ea7022;
				  color: #fff;
				}
				.trf-btn_orange:hover {
				  background-color: #fff;
				  color: #ea7022;
				}

				/* adapive styles */
				@media (max-width: 970px) {
				  .o-form-label .ui-selectmenu-button.ui-button {
					padding: 10px;
				  }
				  .o-form-label .ui-selectmenu-text {
					font-size: 20px;
				  }
				  .ui-menu-item {
					font-size: 16px;
				  }
				  .o-form {
					padding: 15px 20px;
				  }
				  .o-form-label_size-1-2,
				  .o-form-label_size-2-6,
				  .o-form-label_size-1-6 {
					width: 100%;
				  }
				  .o-form__stroke {
					-ms-flex-wrap: wrap;
					flex-wrap: wrap;
				  }
				  .o-form {
					font-size: 18px;
				  }
				  .policy {
					font-size: 10px;
				  }
				  .policy__input {
					width: 15px;
					height: 15px;
				  }
				}
				/* adapive styles END */

			</style>
			<?php
				$ord=null;
				foreach($data['orders'] as $order){ if($order->id==$_GET['oid']){ $ord=$order; break; }}
				if($ord) echo file_get_contents(EDC_PLUGIN_PATH.'/orders/'.$ord->html_name);
			?>
		<?php else : ?>
			<table class="wp-list-table widefat fixed striped pages"><thead>
				<tr>
					<th class="manage-column column-cb" style="width:3%;">#</th>
					<th class="manage-column"><?=__('Order info','edc')?></th>
					<th class="manage-column"><?=__('Date and time','edc')?></th>
					<th class="manage-column"><?=__('Tariff','edc')?></th>
				</tr>
			</thead><tbody>
			<?php $i=0; foreach($data['orders'] as $order) : ?>
				<tr>
					<td style="width:3%;"><?=(++$i)?></td>
					<td>
						<?=$order->title?>						
						<div class="row-actions">
							<span class="download">
								<a href="<?=add_query_arg('oid',$order->id)?>" aria-label="<?=__('Order info','edc')?>"><?=__('Order info','edc')?></a> | 
							</span>
							<span class="download">
								<a href="<?=add_query_arg('download_pdf',$order->id)?>" aria-label="<?=__('Download PDF','edc')?>"><?=__('Download PDF','edc')?></a> | 
							</span>
						</div>
					</td>
					<td><?=EDCH::dateToHum($order->date)?></td>
					<td><?=$order->tariff_name?></td>
				</tr>
			<?php endforeach; ?>
			</tbody></table>		
			<?=$data['pagination']?>
		<?php endif; ?>
	<?php endif; ?>
</div>
<?php
?>