<section class="offer">
	<h2 class="offer__title"><?= $data['title'] ?></h2>
	<h3 class="offer__title-above"><?= $data['title2'] ?></h3>
	<!-- OFFER_FORM -->
	<form class="o-form" action="" method="post">

		<div class="o-form__stroke">
			<label for="gender" class="o-form-label o-form-label_size-1-6">
				<p class="o-form-label__name">Anrede*:</p>
				<select name="edc_anrede" id="gender" class="o-form-label__select" disabled="disabled">
					<option value="Herr" <?= $data["customer"]["anrede"] == 'mr' ? ' selected="selected"' : '' ?>>
						Herr
					</option>
					<option value="Frau" <?= $data["customer"]["anrede"] == 'ms' ? ' selected="selected"' : '' ?>>
						Frau
					</option>
				</select>
			</label>
			<label for="surname" class="o-form-label o-form-label_size-2-6">
				<p class="o-form-label__name">Vorname*:</p>
				<input type="text" value="<?= $data["customer"]["name"] ?>" required pattern="[a-zA-Z0-9\s]+"
					   name="edc_first_name" id="surname" disabled="disabled" class="o-form-label__input">
			</label>
			<label for="name" class="o-form-label o-form-label_size-2-6">
				<p class="o-form-label__name">Name*:</p>
				<input required name="edc_name" id="name"
					   value="<?= $data["customer"]["surname"] ?>" disabled="disabled" required pattern="[a-zA-Z0-9\s]+"
					   type="text" id="name" class="o-form-label__input">
			</label>
			<label for="birthday" class="o-form-label o-form-label_size-1-6">
				<p class="o-form-label__name">Geburtsdatum:</p>
				<input type="text" id="birthday" name="edc_date_of_birth"
					   value="<?= $data["customer"]["birthday"] ?>" disabled="disabled" class="datepicker o-form-label__input">
			</label>
		</div>

		<div class="o-form__stroke">
			<label for="street" class="o-form-label o-form-label_size-1-2">
				<p class="o-form-label__name">Straße*:</p>
				<input type="text" value="<?= $data["customer"]["street"] ?>" required
					   name="edc_street" id="street" disabled="disabled" class="o-form-label__input">
			</label>
			<label for="house" class="o-form-label o-form-label_size-1-2">
				<p class="o-form-label__name">Hausnummer*:</p>
				<input type="text" required name="edc_house"
					   value="<?= $data["customer"]["house"] ?>"
					   id="house" disabled="disabled" class="o-form-label__input">
			</label>
		</div>

		<div class="o-form__stroke">
			<!-- this fields completed by calculator values -->
			<label for="zip" class="o-form-label o-form-label_size-1-2">
				<p class="o-form-label__name">PLZ*:</p>
				<input type="text" id="zip" name="edc_zip_code" class="o-form-label__input"
					   value="<?= $data["customer"]["plz"] ?>" disabled>
			</label>
			<label for="city" class="o-form-label o-form-label_size-1-2">
				<p class="o-form-label__name">Ort*:</p>
				<input type="text" id="city" class="o-form-label__input" name="edc_zip_code_subarea"
					   value="<?= $data["customer"]["ort"] ?>" disabled>
			</label>
		</div>


		<div class="o-form__stroke">
			<label for="phone" class="o-form-label o-form-label_size-2-6">
				<p class="o-form-label__name">Telefon:</p>
				<input type="text" name="phone" id="phone" value="<?=$data["customer"]["phone"]?>" disabled class="o-form-label__input">
			</label>
			<label for="email" class="o-form-label o-form-label_size-2-3">
				<p class="o-form-label__name">E-mail*:</p>
				<input type="text" id="email" required
					   name="edc_email" value="<?=$data["customer"]["email"]?>" disabled class="o-form-label__input">
			</label>
		</div>


		<div class="o-form__stroke o-form__stroke_left">
			<div class="o-form-checkbox">
				<input type="checkbox" id="debit" name="edc_sepa_direct_debit" disabled <?=($data["SERA"]["value"] == "true") ? "checked" : ""?>
					   class="o-form-checkbox__input">
				<label for="debit" class="o-form-checkbox__label">SEPA-Lastschriftmandat</label>
			</div>
			<div class="o-form-checkbox">
				<input type="checkbox" id="transfer" name="edc_key_transfer_on" disabled <?=($data["SERA"]["transfer"] == "true") ? "checked" : ""?>
					   class="o-form-checkbox__input">
				<label for="transfer" class="o-form-checkbox__label">Überweisung</label>
			</div>
			<div class="o-form-radio">
				<p class="o-form-radio__name">Kunde*:</p>
				<input type="radio" required="" id="g_private" name="edc_tariff_type" value="" class="o-form-radio__input" <?=($data['customer']['kunde'] == 0 ) ? "checked" : ""?>>
				<label for="g_private" class="o-form-radio__label">Privatkunde</label>

				<input type="radio" required="" id="g_busines" name="edc_tariff_type" value="" class="o-form-radio__input"  <?=($data['customer']['kunde'] == 1 ) ? "checked" : ""?>>
				<label for="g_busines" class="o-form-radio__label">Geschäftskunde</label>
			</div>
		</div>

		<?php
		if ($data["SERA"]["value"]) :?>

		<fieldset id="debitForm" style="margin-bottom:20px;">
			<div class="o-form__stroke">
				<label for="holder" class="o-form-label o-form-label_size-1-1">
					<p class="o-form-label__name">Kontoinhaber (Vor-/Nachname):</p>
					<input type="text" disabled value="<?=$data["SERA"]["owner"]?>" id="holder" name="edc_holder" class="o-form-label__input">
				</label>
			</div>

			<div class="o-form__stroke">
				<label for="streetDebit" class="o-form-label o-form-label_size-1-2">
					<p class="o-form-label__name">Straße:</p>
					<input type="text" disabled value="<?=$data["SERA"]["street"]?>" id="streetDebit" name="edc_streetDebit" class="o-form-label__input">
				</label>
				<label for="houseDebit" class="o-form-label o-form-label_size-1-2">
					<p class="o-form-label__name">Hausnummer:</p>
					<input type="text" disabled value="<?=$data["SERA"]["house"]?>" id="houseDebit" name="edc_houseDebit" class="o-form-label__input">
				</label>
			</div>

			<div class="o-form__stroke">
				<label for="zipDebit" class="o-form-label o-form-label_size-1-2">
					<p class="o-form-label__name">PLZ:</p>
					<input type="text" id="zipDebit" disabled value="<?=$data["SERA"]["plz"]?>" name="edc_zipDebit" class="o-form-label__input">
				</label>
				<label for="cityDebit" class="o-form-label o-form-label_size-1-2">
					<p class="o-form-label__name">Ort:</p>
					<input type="text" id="cityDebit" name="edc_cityDebit" disabled value="<?=$data["SERA"]["ort"]?>" class="o-form-label__input">
				</label>
			</div>

			<div class="o-form__stroke">
				<label for="credit" class="o-form-label o-form-label_size-1-1">
					<p class="o-form-label__name">Kreditinstitut:</p>
					<input type="text" disabled value="<?=$data["SERA"]["credit"]?>" id="credit" name="edc_credit" class="o-form-label__input">
				</label>
			</div>

			<section class="one-symbol-input">
				<div class="o-form__stroke">
					<label for="i1" class="o-form-label o-form-label_size-1-1">
						<p class="o-form-label__name">IBAN:</p>
						<input type="text" id="i1" name="edc_IBAN[]"  disabled value="<?=$data["SERA"]["IBAN"][0]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i2" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][1]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i3" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][2]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i4" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][3]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i5" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][4]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i6" name="edc_IBAN[]"disabled value="<?=$data["SERA"]["IBAN"][5]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i7" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][6]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i8" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][7]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i9" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][8]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i10" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][9]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i11" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][10]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i12" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][11]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i13" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][12]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i14" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][13]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i15" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][14]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i16" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][15]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i17" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][16]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i18" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][17]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i19" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][18]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i20" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][19]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="i21" name="edc_IBAN[]" disabled value="<?=$data["SERA"]["IBAN"][20]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
					</label>
				</div>

				<div class="o-form__stroke">
					<label for="b1" class="o-form-label o-form-label_size-1-1">
						<p class="o-form-label__name">BIC:</p>
						<input type="text" id="b1" name="edc_BIC[]" disabled value="<?=$data["SERA"]["BIC"][0]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="b2" name="edc_BIC[]" disabled value="<?=$data["SERA"]["BIC"][1]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="b3" name="edc_BIC[]" disabled value="<?=$data["SERA"]["BIC"][2]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="b4" name="edc_BIC[]" disabled value="<?=$data["SERA"]["BIC"][3]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="b5" name="edc_BIC[]" disabled value="<?=$data["SERA"]["BIC"][4]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="b6" name="edc_BIC[]" disabled value="<?=$data["SERA"]["BIC"][5]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="b7" name="edc_BIC[]" disabled value="<?=$data["SERA"]["BIC"][6]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="b8" name="edc_BIC[]" disabled value="<?=$data["SERA"]["BIC"][7]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="b9" name="edc_BIC[]" disabled value="<?=$data["SERA"]["BIC"][8]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
						<input type="text" id="b10" name="edc_BIC[]" disabled value="<?=$data["SERA"]["BIC"][9]?>"
							   class="o-form-label__input o-form-label__input-square" maxlength="1">
					</label>
				</div>
			</section>
		</fieldset>

		<?php endif; ?>

		<div class="o-form__stroke">
			<div class="o-form-checkbox" style="margin: 0 0 20px;">
				<input type="checkbox" id="etc" name="edc_other_debit" disabled
					<?=($data["different_billing_address"]["value"]) ? "checked" : ""?>
					   class="o-form-checkbox__input">
				<label for="etc" class="o-form-checkbox__label">Abweichende Rechnungsanschrift</label>
			</div>
		</div>

		<?php if ($data["different_billing_address"]["value"]) :?>

		<fieldset id="etcForm">
			<div class="o-form__stroke">
				<label for="genderEtc" class="o-form-label o-form-label_size-2-6">
					<p class="o-form-label__name">Anrede*:</p>
					<select name="gender" id="genderEtc" disabled class="o-form-label__select">
						<option <?= $data["different_billing_address"]["anrede"] == 'herr' ? ' selected="selected"' : '' ?> value="herr">Herr</option>
						<option <?= $data["different_billing_address"]["anrede"] == 'frau' ? ' selected="selected"' : '' ?> value="frau">Frau</option>
					</select>
				</label>
				<label for="surnameEtc" class="o-form-label o-form-label_size-2-6">
					<p class="o-form-label__name">Vorname*:</p>
					<input type="text" disabled value="<?=$data["different_billing_address"]["name"]?>" name="surnameEtc" id="surnameEtc" class="o-form-label__input">
				</label>
				<label for="nameEtc" class="o-form-label o-form-label_size-2-6">
					<p class="o-form-label__name">Name*:</p>
					<input type="text" disabled value="<?=$data["different_billing_address"]["surname"]?>" name="nameEtc" id="nameEtc" class="o-form-label__input">
				</label>
			</div>

			<div class="o-form__stroke">
				<label for="streetEtc" class="o-form-label o-form-label_size-1-2">
					<p class="o-form-label__name">Straße*:</p>
					<input type="text" disabled value="<?=$data["different_billing_address"]["street"]?>" name="streetEtc" id="streetEtc" class="o-form-label__input">
				</label>
				<label for="houseEtc" class="o-form-label o-form-label_size-1-2">
					<p class="o-form-label__name">Hausnummer*:</p>
					<input type="text" disabled value="<?=$data["different_billing_address"]["house"]?>" name="houseEtc" id="houseEtc" class="o-form-label__input">
				</label>
			</div>

			<div class="o-form__stroke">
				<label for="zipEtc" class="o-form-label o-form-label_size-1-2">
					<p class="o-form-label__name">PLZ*:</p>
					<input type="text" disabled value="<?=$data["different_billing_address"]["plz"]?>" name="zipEtc" id="zipEtc" class="o-form-label__input">
				</label>
				<label for="cityEtc" class="o-form-label o-form-label_size-1-2">
					<p class="o-form-label__name">Ort*:</p>
					<input type="text" disabled value="<?=$data["different_billing_address"]["ort"]?>" name="cityEtc" id="cityEtc" class="o-form-label__input">
				</label>
			</div>
		</fieldset>

		<?php endif; ?>

		<h3 class="o-form__title">Angaben zur derzeitigen Versorgung und zum Zählerstand</h3>

		<div class="o-form__stroke">
			<label for="provider" class="o-form-label o-form-label_size-1-1">
				<p class="o-form-label__name">Derzeitiger Lieferant (nur bei Versorgerwechsel erforderlich)</p>
				<input type="text" disabled value="<?=$data["current_information"]["supplier"]?>" name="provider" id="provider" class="o-form-label__input">
			</label>
		</div>

		<div class="o-form__stroke">
			<label for="contract" class="o-form-label o-form-label_size-1-2">
				<p class="o-form-label__name">Kunden-oder Vertragskontonummer:</p>
				<input type="text" disabled value="<?=$data["current_information"]["account"]?>" name="contract" id="contract" class="o-form-label__input">
			</label>
			<label for="electriсValue" class="o-form-label o-form-label_size-1-2">
				<p class="o-form-label__name">Zählerstand:</p>
				<input type="text" disabled value="<?=$data["current_information"]["kWh"]?>" name="electriсValue" id="electriсValue" class="o-form-label__input">
			</label>
		</div>

		<div class="o-form__stroke">
			<label for="electriс" class="o-form-label o-form-label_size-1-2">
				<p class="o-form-label__name">Zählernummer*:</p>
				<input type="text" disabled value="<?=$data["current_information"]["el_number"]?>" name="electriс" id="electriс" class="o-form-label__input">
			</label>
			<label for="previous" class="o-form-label o-form-label_size-1-2">
				<p class="o-form-label__name">Vorjahresverbrauch (kWh):</p>
				<input type="text" disabled value="<?=$data["current_information"]["kWh2"]?>" name="previous" id="previous" class="o-form-label__input">
			</label>
		</div>

		<div class="o-form__stroke">
			<label for="key" class="o-form-label o-form-label_size-1-1">
				<p class="o-form-label__name">Datum der Ablesung bei Einzug/Schlüsselübergabe</p>
				<input type="text" disabled value="<?=$data["current_information"]["date2"]?>" name="reade_date" id="key" class="datepicker o-form-label__input">
			</label>
		</div>

		<p><strong>Preis und Lieferbeginn</strong></p>

		<div class="o-form__stroke">
			<label for="key" class="o-form-label o-form-label_size-1-2">
				<p class="o-form-label__name">Grundpreis (EUR/Jahr)</p>
				<input type="text" disabled value="<?=$data["gp"]?>" name="grundpreis" id="grundpreis" class="o-form-label__input">
			</label>
			<label for="key" class="o-form-label o-form-label_size-1-2">
				<p class="o-form-label__name">Arbeitspreis (ct/kWh)</p>
				<input type="text" disabled value="<?=$data["ap"]?>" name="arbeitspreis" id="arbeitspreis" class="o-form-label__input">
			</label>
		</div>

		<div class="o-form__stroke">
			<label for="key" class="o-form-label o-form-label_size-1-1">
				<p class="o-form-label__name">Gewünschter Lieferbeginn</p>
				<input type="text" disabled value="<?=$data["current_information"]["date"]?>" name="edc_electriсDate" id="edc_electriсDate" class="datepicker o-form-label__input">
			</label>
		</div>
		<?php if($data["current_information"]["edc_tariff_dop_tax"]==1) : ?>
		<div class="o-form-checkbox">
			<input type="checkbox" id="edc_tariff_dop_tax" name="edc_tariff_dop_tax" disabled checked class="o-form-checkbox__input">
			<label for="debit" class="o-form-checkbox__label">
					<p>Isernhagen Bonus: Mit 1,00 Euro brutto (0,84 Euro netto) mehr pro 
						Monat unterstützen Sie soziale, kulturelle, ökologische oder
						sportliche Projekte in der Gemeinde Isernhagen und Umgebung.</p></label>
		</div>
		<?php endif; ?>
		<?php if($data["current_information"]["discount"]==1) : ?>
		<div class="o-form-checkbox">
			<input type="checkbox" id="discount" name="discount" disabled checked class="o-form-checkbox__input">
			<label for="debit" class="o-form-checkbox__label">
					<p>Vertragslaufzeit bis jeweils 31.12. eines Jahres: Sie erhalten einen Nachlass in Höhe von 5,00 Euro brutto (4,20 Euro netto) pro Jahr. DerVertrag beginnt mit Beginn des Monats, in dem die Rücksendung des vom Kunden unterzeichneten Auftrages erfolgt – maßgeblich ist das Datum des Posteingangs bei der EWI – und endet am
									31.12.2019. Er verlängert sich um jeweils ein Jahr, sofern er nicht
									von einer Partei mit einer Frist von 3 Monaten vor Ablauf in Textform
									gekündigt wird.</p></label>
		</div>
		<?php endif; ?>
		<?php if($data["current_information"]["invoice"]==1) : ?>
		<div class="o-form-checkbox">
			<input type="checkbox" id="invoice" name="invoice" disabled checked class="o-form-checkbox__input">
			<label for="debit" class="o-form-checkbox__label">
					<p>Sie erhalten einen Nachlass in Höhe von 3,00 Euro brutto (2,52 Euro netto) pro Jahr, wenn wir Ihnen Ihre Jahresabrechnungen anstatt per Post per E-Mail zustellen."
									Euro gross (2,52 Euro net) per year, if we send you your annual accounts
									instead of sending it by mail by e-mail.</p></label>
		</div>
		<?php endif; ?>
	</form>
</section>