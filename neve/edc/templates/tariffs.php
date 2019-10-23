<?php
$edc=EDC::getInstance();
if(!$edc || !$edc->is_tariffs_step) return '';
if(is_array($edc->tariffs) && sizeOf($edc->tariffs)>0) : ?>
<script type="text/javascript">
	function recalculatePrice(el){
		var f=$(el).parents('form').get(0);
		var fsd=f['first_step_data'].value;
		fsd=JSON.parse(fsd);
		var inc=parseInt(fsd.annual_consumption);
		inc=(inc*0.01)/12;
		var par=$(el).parents('.tarif-sets').get(0);
		var per_year=$(par).find('.price_per_year').get(0);
		var per_month=$(par).find('.price_per_month').get(0);
		var gr=$(par).find('.tariff_green_row').get(0);
		var per_kwh=$(par).find('.price_per_kwh').get(0);
		per_kwh_val=parseFloat(per_kwh.innerHTML.toString().replace('.','').replace(',','.'),2);
		var price=parseFloat(per_year.innerHTML.replace('.','').replace(',','.'));
		let per_years=par.querySelectorAll('.price_per_year');
		let per_months=par.querySelectorAll('.price_per_month');
		if(el.checked){
			price+=inc;
			ppm=price/12;
			var dec=price==Math.round(price) ? 0 : 2;
			/*per_year.innerHTML=price.toFixed(dec).toString().replace('.',',');
			per_month.innerHTML=ppm.toFixed(2).toString().replace('.',',');*/
			for(let i=0;i<per_years.length;++i){
				per_years[i].innerHTML=price.toFixed(dec).toString().replace('.',',');
			}
			for(let i=0;i<per_months.length;++i){
				per_months[i].innerHTML=ppm.toFixed(2).toString().replace('.',',');
			}
			gr.style.display='table-row';
			per_kwh.innerHTML=(per_kwh_val+1).toFixed(2).toString().replace('.',',');
		}else{
			price-=inc;
			ppm=price/12;
			var dec=price==Math.round(price) ? 0 : 2;
			//per_year.innerHTML=price.toFixed(dec).toString().replace('.',',');
			//per_month.innerHTML=ppm.toFixed(2).toString().replace('.',',');
			for(let i=0;i<per_years.length;++i){
				per_years[i].innerHTML=price.toFixed(dec).toString().replace('.',',');
			}
			for(let i=0;i<per_months.length;++i){
				per_months[i].innerHTML=ppm.toFixed(2).toString().replace('.',',');
			}
			per_kwh.innerHTML=(per_kwh_val-1).toFixed(2).toString().replace('.',',');
			gr.style.display='none';
		}
	}
</script>

	<?=EDCH::loadTemplate('result',array('tariff_data'=>false))?>
	<div class="edc_tariffs_list">
		<?php foreach($edc->tariffs as $tariff) : ?>
			<?=EDCH::loadTemplate('single_tariff',array('tariff'=>$tariff))?>
		<?php endforeach; ?>
	</div>
<?php else : ?>

<?php endif; ?>