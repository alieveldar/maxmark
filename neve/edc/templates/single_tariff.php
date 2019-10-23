<?php
$edc=EDC::getInstance();
if(!$edc || (!$edc->is_tariffs_step && !$data['is_shortcode'])) return '';
$per_month=round($data['tariff']->price_per_year,2);
$per_year=$per_month*12;
?>
<div class="tarif-sets theme-<?=$data['tariff']->type?>">
	<form method="POST" action="<?=EDCH::getOrderFormURL()?>">
		<?php if($data['tariff']->options['tariff_unser_tip']==1) : ?> <div class="tip"><?=__('Our tip','edc')?></div><?php endif; ?>
		<div class="title-wrapper" style="background-image: url('<?=wp_get_attachment_image_url($data['tariff']->tariff_image)?>')">
			<div class="badges">
				<div class="badge"><?=__('Preis&shy;garantie','edc')?><img src="<?=EDC_PLUGIN_URL?>/images/shield.png" alt="shield"></div>
				<div class="badge"><?=__('Lieferzeit&shy;raum','edc')?><img src="<?=EDC_PLUGIN_URL?>/images/circle-arrow.png" alt="circle-arrow"></div>
				<div class="badge green"><?=__('Öko-Option','edc')?><img src="<?=EDC_PLUGIN_URL?>/images/ecology.png" alt="ecology"></div>
			</div>
			<div class="title"><?=$data['tariff']->title?></div>
		</div>
		<div class="text-wrapper">
			<div class="price"><span class="price_per_month"><?=number_format($per_month,2,',','.')?></span> € <div class="price-details"><?=__('pro Abschlag (11 x pro Jahr)','edc')?></div></div>
			<br><div class="price-details">Jahrespreis <span class="price_per_year"><?=number_format($per_year,2,',','.')?></span> €</div>
			<button type="submit" class="btn-submit" onclick="edc.submit(this,{'callback':'edcTariffProcess'});">Jetzt bestellen</button>
		</div>
		<div class="subtitle"><?=__('Vorteile','edc')?></div>
		<div class="text-wrapper">
            <p class="checkbox"><?=__('Günstigster Tarif (wenn Ihr Verbauch 2.500 kWh übersteigt)','edc')?></p>
            <p class="checkbox"><?=__('Vertragslaufzeit von 1 Monat','edc')?></p>
            <p class="checkbox"><?=__('Verlängerungszeitraum von nur 1 Monat','edc')?></p>
            <p class="checkbox"><?=__('Kündigungsfrist 1 Monat zum Monatsende','edc')?></p>
		</div>
		<div class="subtitle"><?=__('Preisdetails','edc')?></div>
		<div class="text-wrapper">
			<table>
				<tr>
					<td><?=__('Arbeitspreis pro kWh','edc')?>:</td>
					<td><span class="price_per_kwh"><?=number_format($data['tariff']->price_per_kwh,2,',','.')?></span> <?=__('Cent','edc')?> (<?=__('brutto','edc')?>)</td>
				</tr>
				<tr>
					<td><?=__('Grundpreis pro Monat','edc')?>:</td>
					<td><?=number_format($per_month,2,',','.')?> &euro; (<?=__('brutto','edc')?>)</td>
				</tr>
				<?php if($data['tariff']->options['tariff_green_electricity']==1) : ?>
				<tr class="tariff_green_row" style="display:none;">
					<td><?=__('Option Öko-Strom, Aufpreis/kWh:','edc')?>: </td>
					<td><?=__('1 Cent (brutto)','edc')?></td>
				</tr>
				<?php endif; ?>
				<tr>
					<td><?=__('Umfang Preisgarantie','edc')?>: </td>
					<td><?=__('Energiepreis','edc')?></td>
				</tr>
				<tr>
					<td><?=__('Laufzeit Preisgarantie','edc')?>:</td>
					<td><?=$data['tariff']->work_term?></td>
				</tr>
			</table>
		</div>
		<div class="text-wrapper">
			<div class="price"><span class="price_per_month"><?=number_format($per_month,2,',','.')?></span> € <div class="price-details"><?=__('pro Abschlag (11 x pro Jahr)','edc')?></div></div>
			<br><div class="price-details">Jahrespreis <span class="price_per_year"><?=number_format($per_year,2,',','.')?></span> €</div>
		</div>
		<div class="edc_order_form">
		<?php if($data['tariff']->options['tariff_green_electricity']==1) : ?>
			<div class="o-form-checkbox">
				<input type="checkbox" id="green_electricity" name="edc_green_electricity" value="1" class="o-form-checkbox__input" onchange="recalculatePrice(this);">
				<label for="green_electricity" class="o-form-checkbox__label"><?=__('Ökostrom erwünscht','edc')?></label>
			</div>
		<?php endif; ?>
		<?php if($data['tariff']->options['tariff_extended_price_guarantee']==1) : ?>
			<div class="o-form-checkbox">
				<input type="checkbox" id="edc_price_guarantee" name="edc_price_guarantee" value="1" class="o-form-checkbox__input">
				<label for="edc_price_guarantee" class="o-form-checkbox__label"><?=__('Extended price guarantee desired','edc')?></label>
			</div>
		<?php endif; ?>
		</div>
		<button type="submit" class="btn-details">Tarifdetails</button>
		<button type="submit" class="btn-submit" onclick="edc.submit(this,{'callback':'edcTariffProcess'});">Jetzt bestellen</button>
		<input type="hidden" name="edc_processing" value="1">
		<input type="hidden" name="validate" value="1">
		<input type="hidden" name="first_step_data" value="<?=htmlspecialchars(json_encode($edc->first_step_data))?>">
		<input type="hidden" name="step_2" value="1">
		<input type="hidden" name="id_tariff" value=<?=$data['tariff']->id?>>
	</form>
</div>