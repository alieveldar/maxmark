<html>
	<body style="margin: auto">
		<div>
			<div style="height: 130px; width: 100%;">
				<div colspan="6" width="50%"><img style="float: left; height: 100%;" src="<?=$data["img"]?>"/></div>
			</div>
			<div>
				<div colspan="12" style="font-size: 15px; margin-bottom: 10px;">
					<p style="margin-bottom: 15px;"><strong>Auftrag an die KBG Kraftstrom-Bezugsgenossenschaft Homberg eG von <span style="color: #1c94ff;"><?=$data["title"]?></span></strong></p>
				</div>
			</div>
			<div style="position:relative; height: 170px">
				<div style="width: 48%; position: absolute; left: 0; top: 0" colspan="6">
					<div style="font-size: 13px;">
						<strong>Kunde / Lieferanschrift</strong>
					</div>
					<div>
						<div>
							<div style="font-size: 13px;"><?= $data["customer"]["name"] ?>&nbsp;&nbsp;&nbsp;<?= $data["customer"]["surname"] ?></div>
							<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">Vor- und Nachname
							</div>
						</div>
					</div>
					<div>
						<div>
							<div style="font-size: 15px;"><?=$data["customer"]["street"]?>&nbsp;&nbsp;&nbsp;<?= $data["customer"]["house"] ?></div>
							<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">Anschrift (Straße,
								Hausnummer)
							</div>
						</div>
					</div>
					<div>
						<div style="width: 20%; float: left; height: 30px;">
							<div style="font-size: 13px; height: 15px;"><?= $data["customer"]["plz"] ?></div>
							<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">PLZ</div>
						</div>
						<div style="width: 100%;">
							<div style="font-size: 13px; height: 15px;"><?= $data["customer"]["ort"] ?></div>
							<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">Ort</div>
						</div>
					</div>
					<div>
						<div>
							<div style="font-size: 13px;"><?= $data["customer"]["email"] ?></div>
							<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">E-mail</div>
						</div>
					</div>
				</div>
				<div colspan="6" style="width: 48%; position: absolute; right: 0; top: 0; clear: both;">
					<div style="margin-bottom: 5px; font-size: 13px; margin-top: -5px;">
						<strong>Rechnungsanschrift, wenn abweichend von Lieferanschrift</strong>
					</div>
					<div>
						<div>
							<div style="font-size: 13px; height: 15px;"><?=$data["different_billing_address"]["name"]?>&nbsp;&nbsp;&nbsp;<?=$data["different_billing_address"]["surname"]?></div>
							<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">Vor- und Nachname
							</div>
						</div>
					</div>
					<div>
						<div>
							<div style="font-size: 13px; height: 15px;"><?=$data["different_billing_address"]["street"]?>&nbsp;&nbsp;&nbsp;<?=$data["different_billing_address"]["house"]?></div>
							<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">Anschrift (Straße,
								Hausnummer)
							</div>
						</div>
					</div>
					<div style="display: flex;">
						<div style="width: 20%; float: left; height: 30px;">
							<div style="font-size: 13px; height: 15px;"><?=$data["different_billing_address"]["plz"]?></div>
							<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">PLZ</div>
						</div>
						<div style="width: 100%;">
							<div style="font-size: 13px; height: 15px;"><?=$data["different_billing_address"]["ort"]?></div>
							<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">Ort</div>
						</div>
					</div>
					<div>
						<div>
							<div style="font-size: 13px;"><?= $data["customer"]["phone"] ?>&nbsp;</div>
							<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">Telefon</div>
						</div>
					</div>
				</div>
			</div>
			<?php if( $data["SERA"]["transfer"] ) : ?>
				<div>
					<div colspan="12">
						<p style="margin-bottom: 15px;margin-top: 20px;">
							<strong>Überweisung</strong>
						</p>
					</div>
				</div>
			<?php endif; ?>
			<?php if( $data["SERA"]["value"] ) : ?>
				<div>
					<div colspan="12">
						<p style="margin-bottom: 15px;margin-top: 20px;">
							<strong>SEPA-Lastschriftmandat</strong>
						</p>
					</div>
				</div>
				<div style="position:relative; height: 90px">
					<div style="width: 48%; position: absolute; left: 0; top: 0" colspan="6">
						<div>
							<div>
								<div style="font-size: 13px;"><?= $data["SERA"]["owner"] ?></div>
								<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">Kontoinhaber
								</div>
							</div>
						</div>
						<div>
							<div style="width: 100%;">
								<div style="font-size: 13px;"><?= implode('&nbsp;', $data["SERA"]["IBAN"]) ?></div>
								<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">IBAN</div>
							</div>
						</div>
					</div>
					<div style="width: 48%; position: absolute; right: 0; top: 0" colspan="6">
						<div>
							<div>
								<div style="font-size: 15px;"><?=$data["SERA"]["credit"]?></div>
								<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">Kreditinstitut
								</div>
							</div>
						</div>
						<div>
							<div style="width: 100%;">
								<div style="font-size: 13px;"><?= implode('&nbsp;', $data["SERA"]["BIC"]) ?></div>
								<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">BIC</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<div>
				<div colspan="12">
					<p style="margin-bottom: 15px;margin-top: 20px;">
						<strong>Angaben zur derzeitigen Versorgung und zum Zählerstand</strong>
					</p>
				</div>
			</div>
			<div style="position: relative; height: 150px;">
				<div style="position: absolute; left: 0; top: 0; width: 65%;">
					<div>
						<div style="width: 47%; float: left">
							<div style="font-size: 13px; height: 14px;"><?=$data["current_information"]["supplier"]?></div>
							<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">derzeitiger
								Lieferant
							</div>
						</div>
						<div style="width: 100%;">
							<div style="font-size: 13px; height: 14px;"><?=$data["current_information"]["account"]?></div>
							<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">Kunden- oder
								Vertragskontonummer
							</div>
						</div>
					</div>
					<div style="clear: both;">
						<div style="width: 47%; float: left">
							<div style="font-size: 13px; height: 14px;"><?=$data["current_information"]["el_number"]?></div>
							<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">Zählernummer</div>
						</div>
						<div style="width: 100%;">
							<div style="font-size: 13px; height: 14px;"><?=$data["current_information"]["kWh2"]?> <span style="float: right;">in kWh</span></div>
							<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">Vorjahresverbrauch
							</div>
						</div>
					</div>
					<div style="clear: both;">
						<div style="width: 47%; float: left">
							<div style="font-size: 13px; height: 14px;"><?=$data["current_information"]["kWh"]?></div>
							<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">Zählerstand</div>
						</div>
						<div style="width: 100%;">
							<div style="font-size: 13px; height: 14px;"><?=$data["current_information"]["date2"]?></div>
							<div style="border-top: 2px solid #000; font-size: 11px; margin-bottom: 15px;">Datum der
								Zählerablesung
							</div>
						</div>
					</div>
				</div>
				<div colspan="4" style="clear: both; vertical-align: top; width: 30%; position: absolute; right: 0; top: 0;">
					<div style="margin-top: -30px; margin-bottom: 5px;">
						<strong>Preis und Lieferbeginn</strong>
					</div>
					<div style="line-height: 40px; font-size: 13px;">
						<b style="color: #1c94ff">Grundpreis <?=$data["gp"]?> EUR/Jahr*</b>
					</div>
					<div>
						<b style="color: #1c94ff; font-size: 13px;">Arbeitspreis <?=$data["ap"]?> ct/kWh*</b>
					</div>
					<div style="line-height: 20px; padding-top: 20px; font-size: 13px;">
						Der von Ihnen gewünschte Lieferbeginn
						ist der <b style="color: #1c94ff"><?=$data["current_information"]["date"]?>.</b>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>