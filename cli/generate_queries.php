<?php
require_once __DIR__ . '/common.inc';

function write_query_update($queries_out, $table_name, $mssql_connection) {
	static $skipped_tables = array(
		'CON_LOG', 
		'CON_LOG_ID'
	);
	
	static $special_tables = array();
	if (in_array($table_name, $skipped_tables)) {
		return false;
	}
	
	static $skipped_columns = array(
		'K5_CALC',
		'K5_CALC_TAV',
		'K5_CALC_AANHEF',
		'REC_CREATIE_DATUM',
		'REC_CREATIE_USER',
		'REC_LAATSTE_WIJZIG_DATUM',
		'REC_LAATSTE_WIJZIG_USER'
	);
	static $custom_fk_items = array();
	
	$columns_query = mssql_query("exec sp_columns {$table_name}", $mssql_connection);
	
	$dummy_column;
	$identity_column;
	while ($column = mssql_fetch_assoc($columns_query)) {
		if (in_array($column['COLUMN_NAME'], $skipped_columns)) {
		
		} elseif (stripos($column['TYPE_NAME'], 'IDENTITY') !== false) {
			$identifier_item_query = mssql_query("
				SELECT TOP 1 
					{$column['COLUMN_NAME']} AS ID,
					'{$column['COLUMN_NAME']}' AS ID_COLUMN_NAME
				FROM [{$table_name}]
			", $mssql_connection);
			if (mssql_num_rows($identifier_item_query) > 0) {
				$identifier_item = mssql_fetch_assoc($identifier_item_query);
			}
		} elseif (!isset($dummy_column)) {
			$dummy_column = $column;
		}
	}
	
	if (!isset($dummy_column)) {
		exit(PHP_EOL . "no dummy column for {$table_name} available?");
	}
	
	fwrite($queries_out, PHP_EOL);
	if (array_key_exists($table_name, $special_tables)) {
		fwrite($queries_out, PHP_EOL . $special_tables[$table_name]);
	} elseif (isset($identifier_item)) {
		fwrite($queries_out, 
			PHP_EOL . "UPDATE {$table_name}" . 
			PHP_EOL . chr(9) . "SET " . 
			PHP_EOL . chr(9) . chr(9) . $dummy_column['COLUMN_NAME'] . " = " . $dummy_column['COLUMN_NAME'] . 
			PHP_EOL . chr(9) . "WHERE" . 
			PHP_EOL . chr(9) . chr(9) . $identifier_item['ID_COLUMN_NAME'] . " = " . $identifier_item['ID'] . ";"
		);
	} else {
		fwrite($queries_out, 
			PHP_EOL . "UPDATE {$table_name}" . 
			PHP_EOL . chr(9) . "SET " . 
			PHP_EOL . chr(9) . chr(9) . $dummy_column['COLUMN_NAME'] . " = " . $dummy_column['COLUMN_NAME'] . ";"
		);
	}
	
	$skipped_tables[] = $table_name;
	
	return true;
}

function write_query_insert($queries_out, $table_name, $mssql_connection) {
	static $skipped_tables = array(
		'CON_LOG', 
		'CON_LOG_ID'
	);
	
	static $special_tables = array(
		// delete an entry first
		'EVA_EVALUATIE_PERSKOPPELT' => "
DELETE FROM EVA_EVALUATIE_PERSKOPPELT WHERE CODE = 'CP';
INSERT INTO EVA_EVALUATIE_PERSKOPPELT
		([CODE]
		,[INACTIEF]
		,[OMSCHRIJVING]
		,[VOLGNR])
	VALUES
		('CP'
		,'F'
		,'4faa761b88105'
		,86);
		",
		'CHE_KOPPELTYPE' => "
DELETE FROM CHE_KOPPELTYPE WHERE CODE = 'PRON';
INSERT INTO CHE_KOPPELTYPE
		([CODE]
		,[INACTIEF]
		,[OMSCHRIJVING]
		,[VOLGNR])
	VALUES
		('PRON'
		,'F'
		,'4faa761b45256'
		,88);
		",
		'BAS_LICENTIE' => "
DELETE FROM BAS_LICENTIE WHERE LICENTIENUMMER = 1;
INSERT INTO BAS_LICENTIE
		([KLANTNAAM]
		,[LICENTIENUMMER]
		,[MODULEN]
		,[NETWERK_NO]
		,[SERIAL_NO])
	VALUES
		('Railinfra Opleidingen'
		,1
		,'AAN  ACQ  BAS  BET  BEV  BEZ  BRF  CAT  CHE  COM  CYF  DC  DOC  EM  EVA  EX  FAC  IC  IMP  K5M  KCR  KEX  KWO  KXL  MAI  OFF  OI  OPL  PRO  RAP  REL  ROO  SQL  TFA  VFA  M06  '
		,50
		,-337499008);
		",
		'OPL_VAK_DOCENTGROEP' => "/* problems with cursi cursor in trigger?
		INSERT INTO OPL_VAK_DOCENTGROEP
		([VAK_ID]
		,[DOCENTGROEP_CODE])
	VALUES
		((
						SELECT TOP 1 ID
						FROM [OPL_VAK]
					)
		,'ADM');
		*/",
		'OPL_VAK_HULPMIDDELGROEP' => "/* problems with cursi cursor in trigger?
INSERT INTO OPL_VAK_HULPMIDDELGROEP
		([VAK_ID]
		,[HULPMIDDELGROEP_CODE])
	VALUES
		((
						SELECT TOP 1 ID
						FROM [OPL_VAK]
					)
		,'AMFBEAM');
		*/",
		'OPL_VAK_LOKATIEGROEP' => "/* problems with cursi cursor in trigger?
INSERT INTO OPL_VAK_LOKATIEGROEP
		([VAK_ID]
		,[LOKATIEGROEP_CODE])
	VALUES
		((
						SELECT TOP 1 ID
						FROM [OPL_VAK]
					)
		,'AMFGROOT');
		*/",
		'REL_GESLACHT' => "
/* cannot delete M or insert something else
DELETE FROM REL_GESLACHT WHERE CODE = 'M';
INSERT INTO REL_GESLACHT
		([CODE]
		,[OMSCHRIJVING]
		,[VOLGNR])
	VALUES
		('M'
		,'4faa83052badc'
		,41);*/
		"

//		'ROO_BIJEENKOMST_HULPMIDDE',
//		'ROO_BIJEENKOMST_DOCENT',
//		'ROO_BIJEENKOMST_LOKATIE',
	);
	if (in_array($table_name, $skipped_tables)) {
		return false;
	}
	
	static $skipped_columns = array(
		'K5_CALC',
		'REC_CREATIE_DATUM',
		'REC_CREATIE_USER',
		'REC_LAATSTE_WIJZIG_DATUM',
		'REC_LAATSTE_WIJZIG_USER'
	);
	static $fixed_values = array(
		'AFGEHANDELD' => "'F'",
		'FACTUUR_NAAR' => "'B'",
		'GEREED' => "'F'",
		'ID' => 999999,
		'INACTIEF' => "'F'",
		'INLOGGEN' => "'F'",
		'KOPPELTYPE' => "NULL",
		'LICENTIENUMMER' => 1,
		'MELDING_STOP' => "'F'",
		'MELDING_VOORWAARDE' => "'A'",
		'NAAR_ALLES' => "'F'",
		'PUBLICEREN' => "'F'",
		'QUERY_MODE' => "'O'",
		'RECHTEN' => 5,
		'TELT_ALS_AANWEZIG' => "'F'",
		'TELT_ALS_AUTOM_MODULE_INSCHR' => "'F'",
		'TELT_ALS_BOEKING_BLOKKADE' => "'F'",
		'TELT_ALS_CERTIFICAAT' => "'F'",
		'TELT_ALS_CIJFER_BLOKKADE' => "'F'",
		'TELT_ALS_DEELNEMER' => "'F'",
		'TELT_ALS_DEFINITIEF' => "'F'",
		'Telt_Als_Dubbelcontrole' => "'F'",
		'TELT_ALS_EXAMEN_WACHTLIJST' => "'F'",
		'TELT_ALS_FACTUUR_F' => "'F'",
		'TELT_ALS_FACTUUR_N' => "'F'",
		'TELT_ALS_FACTUUR_P' => "'F'",
		'TELT_ALS_GESLAAGD' => "'F'",
		'TELT_ALS_INGESCHREVEN' => "'F'",
		'TELT_ALS_INSCHR_BLOKKADE' => "'F'",
		'TELT_ALS_KANDIDAAT' => "'F'",
		'TELT_ALS_KEUZE_MODULE' => "'F'",
		'TELT_ALS_KEUZE_OND' => "'F'",
		'TELT_ALS_KOSTEN' => "'F'",
		'TELT_ALS_LICENTIEMODULE' => "'F'",
		'TELT_ALS_MATERIAAL' => "'F'",
		'TELT_ALS_OPTIE' => "'F'",
		'TELT_ALS_OVERBOEKING' => "'F'",
		'TELT_ALS_POTENTIELE_CURSI' => "'F'",
		'TELT_ALS_RAPPORTMENU' => "'F'",
		'TELT_ALS_STAGIAIR' => "'F'",
		'TELT_ALS_UREN' => "'F'",
		'TELT_ALS_UREN_SALDO' => "'F'",
		'TELT_ALS_VASTE_MODULE' => "'F'",
		'TELT_ALS_VAST_OND' => "'F'",
		'TELT_ALS_VRIJSTELLING' => "'F'",
		'TELT_ALS_WACHTLIJST' => "'F'",
		'TIJD' => "'9:00'",
		'USR_MODE' => "'V'",
		'VAN_ALLES' => "'F'",
		
		'BAS_GEBRUIKER.MTW_M06_RI_EN_NSO' => "'F'",
		'BAS_INGELOGD.GEBRUIKER_CODE' => "(SELECT TOP 1 CODE FROM BAS_GEBRUIKER WHERE CODE NOT IN (SELECT GEBRUIKER_CODE FROM BAS_INGELOGD))",
		'BAS_USERVELD.SOORT' => "'None'",
		'BEV_GROEP_MODULE.GROEP_CODE' => "(SELECT TOP 1 CODE FROM BEV_GROEP WHERE CODE NOT IN (SELECT GROEP_CODE FROM BEV_GROEP_MODULE))",
		'BR_BEZOEKRAPPORT.TIJD' => "'09:00'",
		'BR_BEZOEKRAPPORT_PROCES.MELDING_VOORWAARDE' => "'A'",
		'BR_BEZOEKRAPPORT_PROCES.MELDING_STOP' => "'F'",
		'CHE_CHECKLIST.KOPPELTYPE' => "NULL",
		'CHE_CHECKLIST.OI_UITVOERING_ID' => "NULL",
		'CHE_CHECKLIST.IC_UITVOERING_ID' => "NULL",
		'CHE_CHECKLIST.EX_UITVOERING_ID' => "NULL",
		'CHE_CHECKLIST.OPL_UITVOERING_ID' => "NULL",
		'CHE_CHECKLIST.PRO_PROJECT_ID' => "NULL",
		'CHE_CHECKLIST.PRO_ONDERDEEL_ID' => "NULL",
		'CHE_CHECKLIST.OFF_OFFERTE_ID' => "NULL",		
		'CHE_KOPPELTYPE.CODE' => "'OU'",
		'CYF_OIIC_BEOORDELING.KOPPELTYPE' => "'IC'",
		'CYF_OIIC_BEOORDELING.CERTIFICAATDATUM' => "'2012-05-08 00:00:00'",
		'CYF_OIIC_BEOORDELING.CERTIFICAATGELDIGTOT' => "'2012-05-09 00:00:00'",
		'DOC_DOCUMENT_BESTAND.IS_BLOB' => "'F'",
		'DOC_DOCUMENT_BESTAND.STORAGE_PATH' => "'C:\\temp.log'",
		'DOC_DOCUMENT_BESTAND.FILE_CONTENTS' => "NULL",
		'EM_EMAIL.CENTRAAL' => "'F'",
		'EM_EMAIL_BIJLAGE.PATH' => "'C:\\temp.log'",
		'EM_EMAIL_BIJLAGE.DOC_DOCUMENT_ID' => "NULL",
		'EM_STD_EMAIL.CENTRAAL' => "'F'",
		'EM_STD_EMAIL.SAMENVOEGEN' => "'F'",
		'EM_STD_EMAIL_BIJLAGE.PATH' => "'C:\\temp.log'",
		'EM_STD_EMAIL_BIJLAGE.DOC_DOCUMENT_ID' => "NULL",
		'EM_EMAIL_ADRES.TYPE' => "'TO'",
		'EVA_EVALUATIE.KOPPELTYPE' => "'EXU'",
		'EVA_EVALUATIE.EX_UITVOERING_ID' => 26498,
		'EVA_EVALUATIE.OI_UITVOERING_ID' => "NULL",
		'EVA_EVALUATIE.IC_UITVOERING_ID' => "NULL",
		'EVA_EVALUATIE.OPL_UITVOERING_ID' => "NULL",
		'EVA_EVALUATIE.IND_TRAJECT_ID' => "NULL",
		'EVA_EVALUATIE.PERSOONKOPPELTYPE' => "NULL",
		'EVA_EVALUATIE.BAS_DOCENT_CODE' => "NULL",
		'EVA_EVALUATIE.BEDRIJF_ID' => "NULL",
		'EVA_EVALUATIE.CONTACTPERSOON' => "NULL",
		'EVA_EVALUATIE.DEELNEMER_PERSOON_ID' => "NULL",
		'EVA_EVALUATIE.PERSOONOVERIGID' => "NULL",
		'EVA_EVALUATIE_KOPPELTYPE.CODE' => "'TRA'",
		'EVA_EVALUATIE_PERSKOPPELT.CODE' => "'DE'",
		'EVA_EVALUATIE_VRAAG.VRAAGSOORT' => "'O'",
		'EVA_STND_EVALUATIE_VRAAG.ANTWOORDGROEP_CODE' => "NULL",
		'EVA_STND_EVALUATIE_VRAAG.VRAAGSOORT' => "'O'",
		'EX_UITVOERING.TIJD_VAN' => "'09:00'",
		'EX_UITVOERING.TIJD_TOT' => "'16:00'",
		'EX_UITVOERING.MIN_DEELNEMERS' => 10,
		'EX_UITVOERING.MAX_DEELNEMERS' => 30,
		'EX_UITVOERING_OND.TIJD_VAN' => "'09:00'",
		'EX_UITVOERING_OND.TIJD_TOT' => "'16:00'",
		'EX_UITVOERING_OND.MIN_DEELNEMERS' => 10,
		'EX_UITVOERING_OND.MAX_DEELNEMERS' => 30,
		'EX_VOORTGANG.DIPLOMA' => "'F'",
		'EX_VOORTGANG_OND.CERTIFICAAT' => "'F'",
		'EX_VOORTGANG_OND.GESLAAGD' => "'F'",
		'EX_VOORTGANG_OND.VRIJSTELLING' => "'F'",
		'EX_EXAMEN_OMSCHRIJVING.HTML' => "'F'",
		'FAC_BTW_TABEL.INEX' => "'I'",
		'FAC_FACTUUR_REGEL.PRIJS_INOFEX_BTW' => "'I'",
		'FAC_FACTUUR.BETAALD' => "'F'",
		'IC_UITVOERING.BEGINTIJD' => "'09:00'",
		'IC_UITVOERING.EINDTIJD' => "'16:00'",
		'INT_INTAKE.TIJD_VAN' => "'09:00'",
		'INT_INTAKE.TIJD_TOT' => "'16:00'",
		'INT_INTAKE_VRAAG.ANTWOORD_GROEP' => "NULL",
		'INT_INTAKE_VRAAG.SOORT' => "'O'",
		'INT_STANDAARD_INTAKE_VRAAG.ANTWOORD_GROEP' => "NULL",
		'INT_STANDAARD_INTAKE_VRAAG.SOORT' => "'O'",
		'IND_ONDERDEEL.GEFACTUREERD' => "'F'",
		'MAI_MAILING.GENEREER_SQL' => "'F'",
		'MAI_MAILING.SELECT_PERSOON' => "'F'",
		'MAI_SELECTIE.SELECT_PERSOON' => "'F'",
		'MAI_MAILING_SELECTIE.USE_AND' => "'F'",
		'MAI_MAILING_SELECTIE.USE_NOT' => "'F'",
		'MAI_STD_MAILING_SELECTIE.USE_AND' => "'F'",
		'MAI_STD_MAILING_SELECTIE.USE_NOT' => "'F'",
		'MTW_M06_TIJDTABEL_REGEL.TIJD_VAN' => "'09:00'",
		'MTW_M06_TIJDTABEL_REGEL.TIJD_TOT' => "'16:00'",
		'MTW_M06_VOORSTEL_FACTUUR.ACCOORD' => "'F'",
		'OFF_OFFERTE.KOPPELTYPE' => "'PO'",
		'OFF_OFFERTE.PRO_ONDERDEEL_ID' => 9,
		'OFF_OFFERTE.OI_UITVOERING_ID' => "NULL",
		'OFF_OFFERTE.IC_UITVOERING_ID' => "NULL",
		'OI_INSCHRIJVING.AFGEROND' => "'F'",
		'OI_INSCHRIJVING_PROCES.INDIEN_COMBI' => "'A'",
		'OI_UITVOERING.STARTTIJD' => "'09:00'",
		'OI_UITVOERING.BEGINTIJD' => "'09:00'",
		'OI_UITVOERING.EINDTIJD' => "'16:00'",
		'OI_UITVOERING.STARTDATUM' => "'2012-05-08'",
		'OI_UITVOERING.EINDDATUM' => "'2012-05-09'",
		'OI_UITVOERING.MIN_INSCHRIJVING' => 1,
		'OI_UITVOERING.MAX_INSCHRIJVING' => 10,
		'OPL_MODULE.MIN_INSCHRIJVING' => 1,
		'OPL_MODULE.MAX_INSCHRIJVING' => 10,
		'OPL_MODULE_OMSCHRIJVING.HTML' => "'F'",
		'OPL_UITVOERING.MIN_INSCHRIJVING' => 10,
		'OPL_UITVOERING.MAX_INSCHRIJVING' => 20,
		'OPL_OPLEIDING_OMSCHRIJVING.HTML' => "'F'",
		'PRO_BOEKING.DEFINITIEF' => "'F'",
		'PRO_BOEKING.TIJD_VAN' => "'09:00'",
		'PRO_BOEKING.TIJD_TOT' => "'16:00'",
		'RBV_CRITERIA.MULTI' => "'F'",
		'RBV_CRITERIA.SOORT' => 0,
		'RBV_CRITERIA.TYPE' => 0,
		'RBV_GEBR_GRP_CRITERIA.TOEVOEGEN' => "'F'",
		'RBV_GEBR_GRP_CRITERIA.WIJZIGEN' => "'F'",
		'RBV_GEBR_GRP_CRITERIA.VERWIJDEREN' => "'F'",
		'REL_ACTIE.TIJD' => "'09:00'",
		'REL_ACTIE.TODO_AFGEHANDELD' => "'F'",
		'REL_ACTIE.TODO_TIJD' => "'09:00'",
		'REL_GESLACHT.CODE' => "'M'",
		'REL_LAND.VOLGNR' => 1,
		'ROO_BIJEENKOMST.TIJD_VAN' => "'09:00'",
		'ROO_BIJEENKOMST.TIJD_TOT' => "'16:00'",
		'ROO_CATERING_ACTIE.TIJD' => "'09:00'",
		'ROO_DOCENT_WEEKUREN.START_TIJD' => "'09:00'",
		'ROO_DOCENT_WEEKUREN.EIND_TIJD' => "'16:00'",
		'ROO_HULPMIDDEL_WEEKUREN.START_TIJD' => "'09:00'",
		'ROO_HULPMIDDEL_WEEKUREN.EIND_TIJD' => "'16:00'",
		'ROO_LOKATIE_WEEKUREN.START_TIJD' => "'09:00'",
		'ROO_LOKATIE_WEEKUREN.EIND_TIJD' => "'16:00'",
		'ROO_NB_DOCENT_PERIODE.TIJD_VAN' => "'09:00'",
		'ROO_NB_DOCENT_PERIODE.TIJD_TOT' => "'16:00'",
		'ROO_NB_HULPMIDDEL_PERIODE.TIJD_VAN' => "'09:00'",
		'ROO_NB_HULPMIDDEL_PERIODE.TIJD_TOT' => "'16:00'",
		'ROO_NB_LOKATIE_PERIODE.TIJD_VAN' => "'09:00'",
		'ROO_NB_LOKATIE_PERIODE.TIJD_TOT' => "'16:00'",
		'ROO_TIJDTABEL_REGEL.TIJD_VAN' => "'09:00'",
		'ROO_TIJDTABEL_REGEL.TIJD_TOT' => "'16:00'",
		'ROO_VAKANTIE.TIJD_VAN' => "'09:00'",
		'ROO_VAKANTIE.TIJD_TOT' => "'16:00'",
		'ROO_VAKANTIE.DATUM_VAN' => "'2012-05-08'",
		'ROO_VAKANTIE.DATUM_TOT' => "'2012-05-09'",
		'STA_AFSPRAAK.IS_AFGEHANDELD' => "'F'",
		'STA_AFSPRAAK.TIJD_AFSPRAAK' => "'16:00'",
		'STA_WERKSTAAT.DATUM_VAN' => "'2012-05-08'",
		'STA_WERKSTAAT.DATUM_TOT' => "'2012-05-09'",
		'SYS_DATUM.WEEKEND' => "'F'",
		'PLANBORD_SCHEMES.ACTIEF' => "'F'",
		'PRO_BOEKING.DECLARABEL' => "'F'"
	);
	static $custom_fk_items = array();
	
	$columns_query = mssql_query("exec sp_columns {$table_name}", $mssql_connection);
	$fks_query = mssql_query("exec sp_fkeys @fktable_name = {$table_name}", $mssql_connection);
	
	$foreign_keys = array();
	while ($foreign_key = mssql_fetch_assoc($fks_query)) {
		$foreign_keys[$foreign_key['FKCOLUMN_NAME']] = $foreign_key;
	}
	
	switch ($table_name) {
		case 'ROO_BIJEENKOMST_HULPMIDDE':
		case 'ROO_BIJEENKOMST_DOCENT':
		case 'ROO_BIJEENKOMST_LOKATIE':
			$foreign_keys['ROO_BIJEENKOMST_ID'] = array(
				'PKTABLE_NAME' => 'ROO_BIJEENKOMST',
				'PKCOLUMN_NAME' => 'ID',
				'FKTABLE_NAME' => $table_name,
				'FK_NAME' => uniqid(),
			);
			break;
			
		case 'ROO_CATERING_ACTIE':
			$foreign_keys['BIJEENKOMST_ID'] = array(
				'PKTABLE_NAME' => 'ROO_BIJEENKOMST',
				'PKCOLUMN_NAME' => 'ID',
				'FKTABLE_NAME' => $table_name,
				'FK_NAME' => uniqid(),
			);
			break;
			
		case 'FAC_FACTUUR_REGEL':
			$foreign_keys['FACTUUR_ID'] = array(
				'PKTABLE_NAME' => 'FAC_FACTUUR',
				'PKCOLUMN_NAME' => 'ID',
				'FKTABLE_NAME' => $table_name,
				'FK_NAME' => uniqid(),
			);
			break;
			
		case 'IA_INFOAANVRAAGREGEL':
			$foreign_keys['IA_INFOAANVRAAG_ID'] = array(
				'PKTABLE_NAME' => 'IA_INFOAANVRAAG',
				'PKCOLUMN_NAME' => 'ID',
				'FKTABLE_NAME' => $table_name,
				'FK_NAME' => uniqid(),
			);
			break;
	}
	
	$identity = false;
	$changes = array();
	while ($column = mssql_fetch_assoc($columns_query)) {
		if (in_array($column['COLUMN_NAME'], $skipped_columns)) {
			continue;
		}
		
		if (stripos($column['TYPE_NAME'], 'IDENTITY') !== false) {
			$identity = true;
			list($type,  $identity_identifier) = explode(" ", $column['TYPE_NAME']);
		} else {
			$type = $column['TYPE_NAME'];
		}
		
		if (array_key_exists($table_name . '.' . $column['COLUMN_NAME'], $fixed_values)) {
			$changes[$column['COLUMN_NAME']] = $fixed_values[$table_name . '.' . $column['COLUMN_NAME']];
			
		} elseif (array_key_exists($column['COLUMN_NAME'], $fixed_values)) {
			$changes[$column['COLUMN_NAME']] = $fixed_values[$column['COLUMN_NAME']];
			
		} elseif (isset($foreign_keys[$column['COLUMN_NAME']])) {
			$foreign_key = $foreign_keys[$column['COLUMN_NAME']];

			$random_item_query = mssql_query("
				SELECT TOP 1 {$foreign_key['PKCOLUMN_NAME']} AS ID
				FROM [{$foreign_key['PKTABLE_NAME']}]
			", $mssql_connection);
			if (mssql_num_rows($random_item_query) === 0) {
				$fk_variable = "@{$foreign_key['FKTABLE_NAME']}_" . $foreign_key['FK_NAME'] . "_ID";
				if (isset($custom_fk_items[$fk_variable])) {
				} elseif (write_query_insert($queries_out, $foreign_key['PKTABLE_NAME'], $mssql_connection) === false) {
					// assume item to be created during this transaction
					$changes[$column['COLUMN_NAME']] = "(
						SELECT TOP 1 {$foreign_key['PKCOLUMN_NAME']}
						FROM [{$foreign_key['PKTABLE_NAME']}]
					)";
					continue;
				} else {
					switch ($type) {
						case 'nvarchar':
						case 'varchar':
						case 'char':
							fwrite($queries_out, PHP_EOL . "DECLARE $fk_variable $type({$column['LENGTH']});");
							break;

						case 'smallint':
						case 'int':
						case 'bigint':
							fwrite($queries_out, PHP_EOL . "DECLARE $fk_variable $type;");
							break;

						default:
							error("unsupported column type {$table_name}.{$column['COLUMN_NAME']} (FK) " . $type);

					}
					fwrite($queries_out, PHP_EOL . "SET $fk_variable = (
						SELECT TOP 1 {$foreign_key['PKCOLUMN_NAME']}
						FROM [{$foreign_key['PKTABLE_NAME']}]
					);");
					$custom_fk_items[$fk_variable] = true;
				}
				
				$changes[$column['COLUMN_NAME']] = $fk_variable;
			} else {
				$random_item = mssql_fetch_assoc($random_item_query);

				switch ($type) {
					case 'nvarchar':
					case 'varchar':
					case 'char':
						$changes[$column['COLUMN_NAME']] = "'" . $random_item['ID'] . "'";
						break;

					case 'smallint':
					case 'int':
					case 'bigint':
						$changes[$column['COLUMN_NAME']] = $random_item['ID'];
						break;

					default:
						error("unsupported column type {$table_name}.{$column['COLUMN_NAME']} (FK) " . $type);

				}
			}
		} else {
		
			switch ($type) {
				case 'nvarchar':
				case 'varchar':
					$changes[$column['COLUMN_NAME']] = "'" . substr(uniqid(), 0, $column['LENGTH']) . "'";
					break;

				case 'char':
					$changes[$column['COLUMN_NAME']] = "'" . substr(uniqid(), 0, $column['LENGTH']) . "'";
					break;

				case 'varbinary':
				case 'image':
					$changes[$column['COLUMN_NAME']] = "CAST( 123456 AS BINARY(2) )";
					break;

				case 'text':
					$changes[$column['COLUMN_NAME']] = "'" . uniqid() . "'";
					break;

				case 'xml':
					$changes[$column['COLUMN_NAME']] = "'<root></root>'";
					break;

				case 'bit':
					$changes[$column['COLUMN_NAME']] = rand(0, 1);
					break;

				case 'smallint':
				case 'int':
				case 'bigint':
					$changes[$column['COLUMN_NAME']] = rand(1, 100);
					break;

				case 'float':
					$changes[$column['COLUMN_NAME']] = rand(1, 100)/3;
					break;

				case 'datetime':
					$changes[$column['COLUMN_NAME']] = 'GETDATE()';
					break;

				case 'timestamp':
					$changes[$column['COLUMN_NAME']] = 'DEFAULT';
					break;

				default:
					error("unsupported column type {$table_name}.{$column['COLUMN_NAME']} " . $type);

			}
		}
	}
	
	if (empty($changes)) {
		exit(PHP_EOL . "no changes for {$table_name}?");
	}
	
	fwrite($queries_out, PHP_EOL);
	if (array_key_exists($table_name, $special_tables)) {
		fwrite($queries_out, PHP_EOL . $special_tables[$table_name]);
	} elseif ($identity === true) {
		fwrite($queries_out, PHP_EOL . "SET IDENTITY_INSERT [{$table_name}] ON;");
		fwrite($queries_out, PHP_EOL . "INSERT INTO {$table_name}" . PHP_EOL . chr(9) . chr(9) . "([" . join("]" . PHP_EOL . chr(9) . chr(9) . ",[", array_keys($changes)) . "])" . PHP_EOL . chr(9) . "VALUES" . PHP_EOL . chr(9) . chr(9) . "(" . join(PHP_EOL . chr(9) . chr(9) . ",", $changes) . ");");
		fwrite($queries_out, PHP_EOL . "SET IDENTITY_INSERT [{$table_name}] OFF;");
	} else {
		fwrite($queries_out, PHP_EOL . "INSERT INTO {$table_name}" . PHP_EOL . chr(9) . chr(9) . "([" . join("]" . PHP_EOL . chr(9) . chr(9) . ",[", array_keys($changes)) . "])" . PHP_EOL . chr(9) . "VALUES" . PHP_EOL . chr(9) . chr(9) . "(" . join(PHP_EOL . chr(9) . chr(9) . ",", $changes) . ");");
	}
	
	$skipped_tables[] = $table_name;
	
	return true;
}

if (!isset($_SERVER['argv'][2])) {
	exit('arg #2 missing: please supply queries file');
} elseif (!isset($_SERVER['argv'][1])) {
	exit('arg #1 missing: please supply mode (insert|update)');
}


$queries_out = fopen($_SERVER['argv'][2], 'w');

$rio_live_770_connection = mssql_connect('LOCALHOST\sql2008', 'sysdba', 'masterkey');
mssql_select_db('RIO_LIVE_770', $rio_live_770_connection);

if ($rio_live_770_connection === false) {
	error('connection failed');
}

$tables_query = mssql_query("
	exec sp_tables 
		@table_type = \"'TABLE'\",
		@table_owner = 'dbo'", $rio_live_770_connection);
if ($tables_query === false) {
	error('tables query failed');
}

$query_progressor = create_progressor('generating queries...', mssql_num_rows($tables_query));
fwrite($queries_out, PHP_EOL . "BEGIN TRANSACTION T1;");
while ($table = mssql_fetch_assoc($tables_query)) {
	switch ($_SERVER['argv'][1]) {
		case "insert":
			if (write_query_insert($queries_out, $table['TABLE_NAME'], $rio_live_770_connection) === true) {
				$query_progressor($table['TABLE_NAME']);
			}
			break;
			
		case "update":
			if (write_query_update($queries_out, $table['TABLE_NAME'], $rio_live_770_connection) === true) {
				$query_progressor($table['TABLE_NAME']);
			}
			break;
	}

}
fwrite($queries_out, PHP_EOL . "COMMIT TRANSACTION T1;");
mssql_close($rio_live_770_connection);
line('done');