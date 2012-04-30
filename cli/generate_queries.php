<?php
require_once __DIR__ . '/common.inc';

function write_query($queries_out, $table_name, $mssql_connection) {
	static $skipped_tables = array(
		'CON_LOG', 
		'CON_LOG_ID'
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
		'ID' => 999999,
		'INACTIEF' => "'F'",
		'AFGEHANDELD' => "'F'",
		'NAAR_ALLES' => "'F'",
		'VAN_ALLES' => "'F'",
		'INLOGGEN' => "'F'",
		'PUBLICEREN' => "'F'",
		'TELT_ALS_WACHTLIJST' => "'F'",
		'TELT_ALS_AUTOM_MODULE_INSCHR' => "'F'",
		'TELT_ALS_STAGIAIR' => "'F'",
		'TELT_ALS_KANDIDAAT' => "'F'",
		'TELT_ALS_STAGIAIR' => "'F'",
		'TELT_ALS_VRIJSTELLING' => "'F'",
		'TELT_ALS_UREN_SALDO' => "'F'",
		'TELT_ALS_CERTIFICAAT' => "'F'",
		'TELT_ALS_DEELNEMER' => "'F'",
		'TELT_ALS_GESLAAGD' => "'F'",
		'TELT_ALS_POTENTIELE_CURSI' => "'F'",
		'TELT_ALS_OVERBOEKING' => "'F'",
		'FACTUUR_NAAR' => "'B'",
		'KOPPELTYPE' => "NULL",
		'TIJD' => "'9:00'",
		'RECHTEN' => 5,
		'LICENTIENUMMER' => 1,
		'BAS_USERVELD.SOORT' => "'None'",
		'CHE_KOPPELTYPE.CODE' => "'OU'",
		'BR_BEZOEKRAPPORT.TIJD' => "'09:00'",
		'BR_BEZOEKRAPPORT_PROCES.MELDING_VOORWAARDE' => "'A'",
		'BR_BEZOEKRAPPORT_PROCES.MELDING_STOP' => "'F'",
		'BAS_GEBRUIKER.MTW_M06_RI_EN_NSO' => "'F'",
		'OPL_MODULE.MIN_INSCHRIJVING' => 1,
		'OPL_MODULE.MAX_INSCHRIJVING' => 10
		
	);
	static $custom_fk_items = array();
	
	$columns_query = mssql_query("exec sp_columns {$table_name}", $mssql_connection);
	$fks_query = mssql_query("exec sp_fkeys @fktable_name = {$table_name}", $mssql_connection);
	
	$foreign_keys = array();
	while ($foreign_key = mssql_fetch_assoc($fks_query)) {
		$foreign_keys[$foreign_key['FKCOLUMN_NAME']] = $foreign_key;
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
		
		if (isset($fixed_values[$table_name . '.' . $column['COLUMN_NAME']])) {
			$changes[$column['COLUMN_NAME']] = $fixed_values[$table_name . '.' . $column['COLUMN_NAME']];
			
		} elseif (isset($fixed_values[$column['COLUMN_NAME']])) {
			$changes[$column['COLUMN_NAME']] = $fixed_values[$column['COLUMN_NAME']];
			
		} elseif (isset($foreign_keys[$column['COLUMN_NAME']])) {
			$foreign_key = $foreign_keys[$column['COLUMN_NAME']];

			$random_item_query = mssql_query("
				SELECT TOP 1 {$foreign_key['PKCOLUMN_NAME']} AS ID
				FROM [{$foreign_key['PKTABLE_QUALIFIER']}].[{$foreign_key['PKTABLE_OWNER']}].[{$foreign_key['PKTABLE_NAME']}]
			");
			if (mssql_num_rows($random_item_query) === 0) {
				$fk_variable = "@{$foreign_key['FKTABLE_NAME']}_" . $foreign_key['FK_NAME'] . "_ID";
				if (!isset($custom_fk_items[$fk_variable])) {
					if (write_query($queries_out, $foreign_key['PKTABLE_NAME'], $mssql_connection) === false) {
						continue;
					}
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
					fwrite($queries_out, PHP_EOL . "SET $fk_variable = @@IDENTITY;");
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
	
	fwrite($queries_out, PHP_EOL);
	if ($identity === true) {
		fwrite($queries_out, PHP_EOL . "SET IDENTITY_INSERT [{$table_name}] ON;");
		fwrite($queries_out, PHP_EOL . "INSERT INTO {$table_name}" . PHP_EOL . chr(9) . chr(9) . "([" . join("]" . PHP_EOL . chr(9) . chr(9) . ",[", array_keys($changes)) . "])" . PHP_EOL . chr(9) . "VALUES" . PHP_EOL . chr(9) . chr(9) . "(" . join(PHP_EOL . chr(9) . chr(9) . ",", $changes) . ");");
		fwrite($queries_out, PHP_EOL . "SET IDENTITY_INSERT [{$table_name}] OFF;");
	} else {
		fwrite($queries_out, PHP_EOL . "INSERT INTO {$table_name}" . PHP_EOL . chr(9) . chr(9) . "([" . join("]" . PHP_EOL . chr(9) . chr(9) . ",[", array_keys($changes)) . "])" . PHP_EOL . chr(9) . "VALUES" . PHP_EOL . chr(9) . chr(9) . "(" . join(PHP_EOL . chr(9) . chr(9) . ",", $changes) . ");");
	}
	
	return true;
}

$queries_out = fopen(__DIR__ . '/queries.sql', 'w');

$rio_live_772_connection = mssql_connect('LOCALHOST\sql2008', 'sysdba', 'masterkey');
mssql_select_db('RIO_LIVE_772', $rio_live_772_connection);

if ($rio_live_772_connection === false) {
	error('connection failed');
}

$tables_query = mssql_query("
	exec sp_tables 
		@table_type = \"'TABLE'\",
		@table_owner = 'dbo'", $rio_live_772_connection);
if ($tables_query === false) {
	error('tables query failed');
}

$query_progressor = create_progressor('generating queries...', mssql_num_rows($tables_query));

while ($table = mssql_fetch_assoc($tables_query)) {
	if (write_query($queries_out, $table['TABLE_NAME'], $rio_live_772_connection) === true) {
		$query_progressor($table['TABLE_NAME']);
	}
}
mssql_close($rio_live_772_connection);
line('done');