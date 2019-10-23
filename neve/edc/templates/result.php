<?php
	$edc=EDC_Extension::getInstance();
	if(!$edc) return '';
	$img=wp_get_attachment_image_url(EDCH::getOption('edc_result_banner','settings'));
?>
<div class="elementor-section elementor-section-boxed">
	<div class="elementor-container tarif-results theme-<?=$edc->tariff->type?>">
		<?php if($img && !is_wp_error($img)) : ?>
		<div class="column image_column">
			<div class="tariff_image"><img src="<?=$img?>"></div>
		</div>
		<?php endif; ?>
		<div class="column">
			<table>
				<tr>
					<td><?=__('Jährlicher Verbrauch in kWh','edc')?></td>
					<td><?=$edc->first_step_data['annual_consumption']?></td>
				</tr>
				<tr>
					<td><?=__('Personen im Haushalt','edc')?></td>
					<td><?=$edc->first_step_data['people']?></td>
				</tr>
				<?php if($data['tariff_data']!==false) : ?>
				<tr>
					<td><?=__('Ökostrom erwünscht','edc')?></td>
					<td class="<?php echo ($edc->tariff->options['tariff_green_electricity']==1 && $edc->second_step_data['edc_green_electricity']==1 ? 'green' : 'red');?>">
						<?php echo ($edc->tariff->options['tariff_green_electricity']==1 && $edc->second_step_data['edc_green_electricity']==1 ? __('Ja','edc') : __('Nein','edc'));?>
					</td>
				</tr>
				<tr>
					<td><?=__('Verlängerte Preisgarantie gewünscht','edc')?></td>
					<td class="<?php echo ($edc->tariff->options['tariff_extended_price_guarantee']==1 && $edc->second_step_data['edc_price_guarantee']==1 ? 'green' : 'red');?>">
						<?php echo ($edc->tariff->options['tariff_extended_price_guarantee']==1 && $edc->second_step_data['edc_price_guarantee']==1 ? __('Ja','edc') : __('Nein','edc'));?>
					</td>
				</tr>
				<?php endif; ?>
			</table>
		</div>
		<div class="column">
			<table>
				<tr>
					<td><?=__('Type','edc')?></td>
					<td><?php echo ($edc->tariff->type==1 ? __('Gas','edc') : __('Electricity','edc'))?></td>
				</tr>
				<tr>
					<td><?=__('Postleitzahl','edc')?></td>
					<td><?=$edc->first_step_data['postcode']?></td>
				</tr>
				<tr>
					<td><?=__('Place','edc')?></td>
					<td><?=$edc->first_step_data['district']?></td>
				</tr>
				<tr>
					<td><?=__('Lieferant','edc')?></td>
					<td><?=EDCH::getOption('edc_lieferant','settings')?></td>
				</tr>
				<tr>
					<td><?=__('Netzbetreiber','edc')?></td>
					<td><?=EDCH::getOption('edc_netzbetreiber','settings')?></td>
				</tr>
			</table>
		</div>
	</div>
</div>

