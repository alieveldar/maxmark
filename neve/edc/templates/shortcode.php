<?php
	global $edc_counter;
	$edc_counter=is_numeric($edc_counter) ? ++$edc_counter : 0;
?>
<script type="text/javascript">
	
function showHideRegion(el){
	var reg=el.parentNode.querySelector('select[name="region"]');
	if(!reg) return false;
	if(el.value.length<3){
		$(reg).addClass('hidden');
	}else{
		$.ajax({
			url: window.location,
			type: 'post',
			data: {'get_postcodes_options':el.value,'type':el.form['type'].value},
			success: function (data){
				reg.innerHTML=data;
				$(reg).removeClass('hidden');
			},
			error: function(data){},
		});	
	}
}
function setAnnual(el){
	if(!el) return false;
	var f=$(el).parents('form').get(0);
	if(!f || !f['annual_consumption']) return false
	f['annual_consumption'].value=el.dataset.value;
	squaresChange(el);
}
function squaresChange(el){
	if(!el) return false;
	let f=$(el).parents('form').get(0);
	if(!f || !f['annual_consumption']) return false
	let els=f.querySelectorAll('.button-square');
	for(let i=0;i<els.length;++i){
		if(parseInt(els[i].dataset.value)<=parseInt(f['annual_consumption'].value)){
			$(els[i]).addClass('active');
		}else $(els[i]).removeClass('active');
	}
}
</script>
<div class="tarif-calc edc_tabs <?=isset($data['dop_class']) ? $data['dop_class'] : ''?>" id="edcalculator_<?=$edc_counter?>" data-tab="<?=isset($data['active']) ? $data['active'] : ''?>">
    <ul class="navigation">
        <li data-class="gas-theme"><a href="<?=EDCH::getGasPageURL()?>"><?=__('Gas','edc')?><img src="<?=EDC_PLUGIN_URL.'/images/gas_icon.png'?>" alt="gas_icon"></a></li>
        <li data-class="strom-theme" ><a href="<?=EDCH::getElectricityPageURL()?>"><?=__('Electricity','edc')?><img src="<?=EDC_PLUGIN_URL.'/images/strom_icon.png'?>" alt="strom_icon"></a></li>
    </ul>
    <div class="items tab-content">
        <form class="edc_tab" action="<?=EDCH::getTariffsPageURL()?>" method="POST">
                <div class="form-column">
                    <label for="tc_g_zip"><?=__('Adresse','edc')?></label>
                    <input oninput="showHideRegion(this);" type="text" name="zip" placeholder="<?=__('Postleitzahl','edc')?>">
                    <select name="region" class="hidden"></select>
                </div>
                <div class="form-column">
                    <label for="square"><?=__('Anzahl m² im Haushalt','edc')?></label>
                    <input type="range" min="1" max="500" step="1" data-rangeslider>
                    <div class="square-block">
                        <img src="<?=EDC_PLUGIN_URL.'/images/house.png'?>" alt="house">
                        <div><input type="number" min="1" max="500" name="square" class="range-slider-value"><span><?=__('m²','edc')?></span></div>
                        <img src="<?=EDC_PLUGIN_URL.'/images/house.png'?>" alt="house">
                    </div>
                </div>
                <div class="form-column">
                    <label for="tc_g_ac"><?=__('Jährlicher Verbrauch in kWh','edc')?></label>
                    <input type="text" name="annual_consumption" placeholder="">
                </div>
                <button type="submit" onclick="edc.submit(this,{'callback':'edcTariffProcess'});">Gaspreis berechnen</button>
            <div class="badge"><?=__('Einfacher Anbieter&shy;wechsel!','edc')?></div>
			<input type="hidden" name="edc_processing" value="1">
			<input type="hidden" name="validate" value="1">
			<input type="hidden" name="step_1" value="1">
			<input type="hidden" name="type" value="gas">
        </form>
        <form class="edc_tab" action="<?=EDCH::getTariffsPageURL()?>" method="POST">
            <div class="form-column">
                    <label for="tc_s_zip"><?=__('Adresse','edc')?></label>
                    <input oninput="showHideRegion(this);" type="text" name="zip" placeholder="<?=__('Postleitzahl','edc')?>">
                    <select name="region" class="hidden"></select>
                </div>
                <div class="form-column">
                    <label><?=__('Personen im Haushalt','edc')?></label>
                    <input type="range" min="1" max="4" step="1" data-rangeslider>
                    <div class="square-block">
                        <input type="hidden" name="people" class="range-slider-value">
                        <button type="button" class="button-square" value="1" data-value="<?=EDCH::getOption('edc_per_year_1_electricity','settings')?>" onclick="setAnnual(this);"><img src="<?=EDC_PLUGIN_URL."/images/people1.png";?>" alt="people"></button>
                        <button type="button" class="button-square" value="2" data-value="<?=EDCH::getOption('edc_per_year_2_electricity','settings')?>" onclick="setAnnual(this);"><img src="<?=EDC_PLUGIN_URL."/images/people2.png";?>" alt="people"></button>
                        <button type="button" class="button-square" value="3" data-value="<?=EDCH::getOption('edc_per_year_3_electricity','settings')?>" onclick="setAnnual(this);"><img src="<?=EDC_PLUGIN_URL."/images/people3.png";?>" alt="people"></button>
                        <button type="button" class="button-square" value="4" data-value="<?=EDCH::getOption('edc_per_year_4_electricity','settings')?>" onclick="setAnnual(this);"><img src="<?=EDC_PLUGIN_URL."/images/people4.png";?>" alt="people"></button>
<!--                        <img src="--><?//=EDC_PLUGIN_URL."/images/people5.png";?><!--" alt="people">-->
                    </div>
                </div>
                <div class="form-column">
                    <label for="tc_s_ac"><?=__('Jährlicher Verbrauch','edc')?></label>
                    <input type="text" name="annual_consumption" placeholder="" oninput="squaresChange(this);">
                </div>
                <button type="submit" onclick="edc.submit(this,{'callback':'edcTariffProcess'});"><?=__('Strompreis berechnen','edc')?></button>
            <div class="badge"><?=__('Einfacher Anbieter&shy;wechsel!','edc')?></div>
			<input type="hidden" name="edc_processing" value="1">
			<input type="hidden" name="validate" value="1">
			<input type="hidden" name="step_1" value="1">
			<input type="hidden" name="type" value="electricity">
        </form>
    </div>
</div>
<script type="text/javascript">
	window.addEventListener('load',function(){
		<?php if(EDCH::getTabsType()=='tabs') :?>
			edc.initializeTabs(document.querySelector('#edcalculator_<?=$edc_counter?>'),document.querySelector('#edcalculator_<?=$edc_counter?>').dataset.tab);
		<?php endif; ?>
	});
</script>