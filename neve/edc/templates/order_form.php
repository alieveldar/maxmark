<?php
/**
 * $result
 */

/*$nds = 1;
$selectEnergy = edc_v2_get_count_energy_per_year();*/
$edc=EDC::getInstance();
if(!$edc || !$edc->is_order_step) return '';
?>
<script type="text/javascript">
	function showHideSepa(el){
		if(el.checked){
			document.body.querySelector('#sepa_fields').style.display='block';
			if(document.querySelector('#transfer').checked) document.querySelector('#transfer_label').click();	
		}else{
			document.body.querySelector('#sepa_fields').style.display='none';		
		}
	}
	function transferChanged(el){
		if(el.checked && document.querySelector('#debit').checked){
			document.querySelector('#sepa_label').click();
		}
	}
	function showHideETC(el){
		if(el.checked){
			document.body.querySelector('#etcForm').style.display='block';
		}else{
			document.body.querySelector('#etcForm').style.display='none';		
		}
	}
	window.addEventListener('load',function(){
		$('.one-symbol-input input').on('keypress', function(){
			$(this).val('').next().focus();
		});
		 
	});
</script>
<?=EDCH::loadTemplate('result')?>
<div class="edc_order_form elementor-section elementor-section-boxed type-<?=$edc->tariff->type?>">
    <section class="offer elementor-container">
        <?php
        ?>		
        <form class="o-form order" name="order_form" action="" method="post">
            <div class="o-form__stroke">
                <label for="gender" class="o-form-label o-form-label_size-1-6">
                    <p class="o-form-label__name"><?=__('Anrede','edc')?>*:</p>
                    <select name="edc_anrede" id="gender" class="o-form-label__select">
                        <option value="mr"><?=__('Herr','edc')?></option>
                        <option value="ms"><?=__('Frau')?></option>
                    </select>
                </label>
                <label for="surname" class="o-form-label o-form-label_size-2-6">
                    <p class="o-form-label__name"><?=__('Vorname','edc')?>*:</p>
                    <input type="text" value="" required pattern="[a-zA-Z0-9\s]+" name="edc_second_name" id="surname" class="o-form-label__input">
                </label>
                <label for="name" class="o-form-label o-form-label_size-2-6">
                    <p class="o-form-label__name"><?=__('Vorname','edc')?>*:</p>
                    <input required name="edc_name" id="name" value="" required pattern="[a-zA-Z0-9\s]+" type="text" id="name" class="o-form-label__input">
                </label>
                <label for="birthday" class="o-form-label o-form-label_size-1-6">
                    <p class="o-form-label__name"><?=__('Gebursdatum','edc')?>:</p>
                    <input type="text" id="birthday" name="edc_date_of_birth" value="" class="datepicker o-form-label__input">
                </label>
            </div>
            <div class="o-form__stroke">
                <label for="street" class="o-form-label o-form-label_size-1-2">
                    <p class="o-form-label__name"><?=__('Straße','edc')?>*:</p>
                    <input type="text" value="<?=$edc->first_step_data['street']?>" required name="edc_street" id="street" class="o-form-label__input">
                </label>
                <label for="house" class="o-form-label o-form-label_size-1-2">
                    <p class="o-form-label__name"><?=__('Hausnummer','edc')?>*:</p>
                    <input type="text" required name="edc_house" value="<?=$edc->first_step_data['house']?>" id="house" class="o-form-label__input">
                </label>
            </div>
            <div class="o-form__stroke">
                <label for="zip" class="o-form-label o-form-label_size-1-2">
                    <p class="o-form-label__name"><?=__('Postleitzahl','edc')?>*:</p>
                    <input type="text" id="zip" name="edc_zip_code" class="o-form-label__input" value="<?=$edc->first_step_data['postcode']?>" disabled>
                </label>
                <label for="city" class="o-form-label o-form-label_size-1-2">
                    <p class="o-form-label__name"><?=__('Place','edc')?>*:</p>
                    <input type="text" id="city" class="o-form-label__input" name="edc_zip_code_subarea" value="<?=$edc->first_step_data['district']?>" disabled>
                </label>
            </div>
            <div class="o-form__stroke">
                <label for="phone" class="o-form-label o-form-label_size-2-6">
                    <p class="o-form-label__name"><?=__('Phone','edc')?>:</p>
                    <input type="text" name="edc_phone" id="phone" class="o-form-label__input">
                </label>
                <label for="email" class="o-form-label o-form-label_size-2-6">
                    <p class="o-form-label__name"><?=__('E-mail','edc')?>*:</p>
                    <input type="text" id="email" required
                           name="edc_email" class="o-form-label__input">
                </label>
                <label for="emailCopy" class="o-form-label o-form-label_size-2-6">
                    <p class="o-form-label__name"><?=__('E-mail wiederholen','edc')?>*:</p>
                    <input type="text" id="emailCopy" required name="edc_email_confirm" class="o-form-label__input">
                </label>
            </div>
            <div class="o-form__stroke o-form__stroke_left">
                <div class="o-form-checkbox">
                    <input type="checkbox" id="debit" name="edc_sepa_direct_debit" value="sepa" onchange="showHideSepa(this);" class="o-form-checkbox__input">
                    <label for="debit" id="sepa_label" class="o-form-checkbox__label"><?=__('SEPA-Lastschriftmandat','edc')?></label>
                </div>
                <div class="o-form-checkbox">
                    <input type="checkbox" id="transfer" name="edc_key_transfer_on" value="transfer" onchange="transferChanged(this);" class="o-form-checkbox__input">
                    <label for="transfer" id="transfer_label" class="o-form-checkbox__label"><?=__('Überweisung','edc')?></label>
                </div>
                <label for="deliveryDate" class="o-form-label o-form-label_size-2-3">
                    <p class="o-form-label__name"><?=__('Gewünschter Lieferbeginn / bei Einzug: Datum der Schlüsselübergabe','edc')?></p>
                    <input type="text" id="deliveryDate" name="edc_electriсDate" class="datepicker o-form-label__input hasDatepicker">
                </label>
            </div>

            <fieldset id="sepa_fields" style="display:none;padding: 20px 0; border-top: 2px solid rgb(91,155,213);border-bottom: 2px solid rgb(91,155,213);">
				<h2>SEPA Lastschriftmandat</h2>
				<h3>Mandats-Referenznummer</h3>
				<p>Diese wird Ihnen separat in einer schriftlichen Bestätigung mitgeteilt.</p>
				<h3>Zahlungsempfänger</h3>
				<p>
				<b>Gläubiger:</b> 					KBG Kraftstrom-Bezugsgenossenschaft Homberg eG
				<b>Gläubiger-Identifikationsnummer:</b> 	DE00 XXX 0000000 0000
				</p>
				<p>
				Ich ermächtige den Gläubiger, die KBG Kraftstrom-Bezugsgenossenschaft Homberg eG, Zahlungen von meinem Konto mittels Lastschrift einzuziehen. Zugleich weise ich mein Kreditinstitut an, die von dem Gläubiger, der KBG Kraftstrom-Bezugsgenossenschaft Homberg eG, auf mein Konto gezogenen Lastschriften einzulösen. 
				</p>
				<p>
				<b>Hinweis:</b> Ich kann innerhalb von acht Wochen, beginnend mit dem Belastungsdatum, die Erstattung des belasteten Betrages verlangen. Es gelten dabei die mit meinem Kreditinstitut vereinbarten Bedingungen.
				</p>
                <div class="o-form__stroke">
                    <label for="holder" class="o-form-label o-form-label_size-1-1">
                        <p class="o-form-label__name">Kontoinhaber (Vor-/Nachname):</p>
                        <input type="text" id="holder" name="edc_holder" class="o-form-label__input">
                    </label>
                </div>

                <div class="o-form__stroke">
                    <label for="streetDebit" class="o-form-label o-form-label_size-1-2">
                        <p class="o-form-label__name">Straße:</p>
                        <input type="text" id="streetDebit" name="edc_streetDebit" class="o-form-label__input">
                    </label>
                    <label for="houseDebit" class="o-form-label o-form-label_size-1-2">
                        <p class="o-form-label__name">Hausnummer:</p>
                        <input type="text" id="houseDebit" name="edc_houseDebit" class="o-form-label__input">
                    </label>
                </div>

                <div class="o-form__stroke">
                    <label for="zipDebit" class="o-form-label o-form-label_size-1-2">
                        <p class="o-form-label__name">PLZ:</p>
                        <input type="text" id="zipDebit" name="edc_zipDebit" class="o-form-label__input">
                    </label>
                    <label for="cityDebit" class="o-form-label o-form-label_size-1-2">
                        <p class="o-form-label__name">Ort:</p>
                        <input type="text" id="cityDebit" name="edc_cityDebit" class="o-form-label__input">
                    </label>
                </div>

                <div class="o-form__stroke">
                    <label for="credit" class="o-form-label o-form-label_size-1-1">
                        <p class="o-form-label__name">Kreditinstitut:</p>
                        <input type="text" id="credit" name="edc_credit" class="o-form-label__input">
                    </label>
                </div>

                <section class="one-symbol-input">
                    <div class="o-form__stroke">
                        <label for="i1" class="o-form-label o-form-label_size-1-1">
                            <p class="o-form-label__name">IBAN:</p>
                            <input type="text" id="i1" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i2" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i3" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i4" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i5" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i6" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i7" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i8" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i9" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i10" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i11" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i12" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i13" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i14" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i15" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i16" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i17" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i18" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i19" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i20" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i21" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="i22" name="edc_IBAN[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                        </label>
                    </div>

                    <div class="o-form__stroke">
                        <label for="b1" class="o-form-label o-form-label_size-1-1">
                            <p class="o-form-label__name">BIC:</p>
                            <input type="text" id="b1" name="edc_BIC[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="b2" name="edc_BIC[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="b3" name="edc_BIC[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="b4" name="edc_BIC[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="b5" name="edc_BIC[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="b6" name="edc_BIC[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="b7" name="edc_BIC[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="b8" name="edc_BIC[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="b9" name="edc_BIC[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="b10" name="edc_BIC[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                            <input type="text" id="b11" name="edc_BIC[]"
                                   class="o-form-label__input o-form-label__input-square" maxlength="1">
                        </label>
                    </div>
                </section>
            </fieldset>
            <div class="o-form__stroke">
                <div class="o-form-checkbox">
                    <input type="checkbox" id="etc" name="edc_other_debit" value="edc_other_debit" onchange="showHideETC(this);" class="o-form-checkbox__input">
                    <label for="etc" class="o-form-checkbox__label"><?=__('Abweichende Rechnungsanschrift','edc')?></label>
                </div>
            </div>
            <fieldset id="etcForm" style="display:none;">
                <div class="o-form__stroke">
                    <label for="genderEtc" class="o-form-label o-form-label_size-2-6">
                        <p class="o-form-label__name"><?=__('Anrede','edc')?>*:</p>
                        <select name="edc_etc_gender" id="genderEtc" class="o-form-label__select">
                            <option value="mr"><?=__('Herr','edc')?></option>
                            <option value="ms"><?=__('Frau','edc')?></option>
                        </select>
                    </label>
                    <label for="surnameEtc" class="o-form-label o-form-label_size-2-6">
                        <p class="o-form-label__name"><?=__('Vorname','edc')?>*:</p>
                        <input type="text" name="edc_etc_surname" value="" id="surnameEtc" class="o-form-label__input">
                    </label>
                    <label for="nameEtc" class="o-form-label o-form-label_size-2-6">
                        <p class="o-form-label__name"><?=__('Vorname','edc')?>*:</p>
                        <input type="text" name="edc_etc_name" id="nameEtc" class="o-form-label__input">
                    </label>
                </div>

                <div class="o-form__stroke">
                    <label for="streetEtc" class="o-form-label o-form-label_size-1-2">
                        <p class="o-form-label__name"><?=__('Straße','edc')?>*:</p>
                        <input type="text" name="edc_etc_street" id="streetEtc" class="o-form-label__input">
                    </label>
                    <label for="houseEtc" class="o-form-label o-form-label_size-1-2">
                        <p class="o-form-label__name"><?=__('Hausnummer','edc')?>*:</p>
                        <input type="text" name="edc_etc_house" id="houseEtc" class="o-form-label__input">
                    </label>
                </div>

                <div class="o-form__stroke">
                    <label for="zipEtc" class="o-form-label o-form-label_size-1-2">
                        <p class="o-form-label__name"><?=__('Postleizahl','edc')?>*:</p>
                        <input type="text" name="edc_etc_zip" id="zipEtc" class="o-form-label__input">
                    </label>
                    <label for="cityEtc" class="o-form-label o-form-label_size-1-2">
                        <p class="o-form-label__name"><?=__('Place','edc')?>*:</p>
                        <input type="text" name="edc_etc_city" id="cityEtc" class="o-form-label__input">
                    </label>
                </div>
            </fieldset>

            <h3 class="o-form__title"><?__('Information on current supply and meter reading','edc')?></h3>

            <div class="o-form__stroke">
                <label for="provider" class="o-form-label o-form-label_size-1-1">
                    <p class="o-form-label__name"><?=__('Derzeitiger Lieferant (nur bei Versorgerwechsel erforderlich)','edc')?></p>
                    <input type="text" name="edc_provider" id="provider" class="o-form-label__input">
                </label>
            </div>

            <div class="o-form__stroke">
                <label for="contract" class="o-form-label o-form-label_size-1-2">
                    <p class="o-form-label__name"><?=__('Kuden- oder Vertrtagsnummer')?>:</p>
                    <input type="text" name="edc_contract" id="contract" class="o-form-label__input">
                </label>
                <label for="electriсValue" class="o-form-label o-form-label_size-1-2">
                    <p class="o-form-label__name"><?=__('Zählestand')?>:</p>
                    <input type="text" name="edc_electriсValue" id="electriсValue" class="o-form-label__input">
                </label>
            </div>

            <div class="o-form__stroke">
                <label for="electriс" class="o-form-label o-form-label_size-1-2">
                    <p class="o-form-label__name"><?=__('Zählernummer','edc')?>*:</p>
                    <input type="text" name="edc_electriс" required id="electriс" class="o-form-label__input">
                </label>
                <label for="previous" class="o-form-label o-form-label_size-1-2">
                    <p class="o-form-label__name"><?=__('Vorjahresverbrauch (kWh)','edc')?></p>
                    <input type="text" name="edc_previous" id="previous" class="o-form-label__input">
                </label>
            </div>

            <div class="o-form__stroke">
                <label for="key" class="o-form-label o-form-label_size-1-1">
                    <p class="o-form-label__name"><?=__('Datum der Zählerablesung / bei Einzug: Datum der Schlüsselübergabe','edc')?></p>
                    <input type="text" name="edc_reade_date" id="key" class="datepicker o-form-label__input">
                </label>
            </div>			
           
            <?php if($edc->tariff->options['tariff_description']): ?>
                <div class="o-form-checkbox rel" style="height: auto; margin-bottom: 33px;">
                    <div class="policy__text" style="font-size:14px;letter-spacing:-0.1px;line-height:23.8px;display:inline-block;font-weight:normal;"><?=$edc->tariff->options['tariff_descriotion']?></div>
                </div>
            <?php endif; ?>
			<div class="o-form-checkbox rel" style="height: auto; margin-bottom: 33px;">
				<input type="checkbox" id="policy_2" name="confirm_tariff" value="1" class="o-form-checkbox__input">
				<label for="policy_2" class="o-form-checkbox__label policy">
					<p class="policy__text">Die Allgemeinen Stromlieferbedingungen / Gaslieferbedingungen sind Bestandteil des Vertrages. Diese habe ich zur Kenntnis genommen und erkläre mich mit deren Geltung einverstanden.</p>
				</label>
				<div style="clear: both"></div>
				<div class="confirm_tariff alert_er" style="display: none">Sie haben vergessen dieses Feld zu zu
					befüllen
				</div>
			</div>
			<div class="o-form-checkbox rel" style="height: auto; margin-bottom: 33px;">
				<input type="checkbox" id="policy_3" name="confirm_tariff2" value="1" class="o-form-checkbox__input">
				<label for="policy_3" class="o-form-checkbox__label policy">
					<p class="policy__text">Ich habe die Widerrufsbelehrung zur Kenntnis genommen und akzeptiere diese.</p>
				</label>
				<div style="clear: both"></div>
				<div class="confirm_tariff2 alert_er" style="display: none">Sie haben vergessen dieses Feld zu zu
					befüllen
				</div>
			</div>
			<div class="o-form-checkbox rel" style="height: auto; margin-bottom: 33px;">
				<input type="checkbox" id="policy_4" name="confirm_tariff3" value="1" class="o-form-checkbox__input">
				<label for="policy_4" class="o-form-checkbox__label policy">
					<p class="policy__text">Ich habe die Datenschutzinformationen nach Art. 13, 14 DSGVO zur Kenntnis genommen und bin mit der dort beschriebenen Verwendung meiner Daten einverstanden.</p>
				</label>
				<div style="clear: both"></div>
				<div class="confirm_tariff3 alert_er" style="display: none">Sie haben vergessen dieses Feld zu zu
					befüllen
				</div>
			</div>

            <input type="submit" name="edc_send_order_pdf" value="<?=__('kostenpflichtig bestellen','edc')?>" class="trf-btn trf-btn_orange trf-btn_in-offer"  onclick="edc.submit(this,{'callback':'edcTariffProcess'});">
			<input type="hidden" name="edc_processing" value="1">
			<input type="hidden" name="validate" value="1">
			<input type="hidden" name="first_step_data" value="<?=htmlspecialchars(json_encode($edc->first_step_data))?>">
			<input type="hidden" name="second_step_data" value="<?=htmlspecialchars(json_encode($edc->second_step_data))?>">
			<input type="hidden" name="step_3" value="1">
			<input type="hidden" name="id_tariff" value=<?=$edc->tariff->id?>>
        </form>
    </section>
</div>