<?php

require __DIR__ . '/../secrets.php';

function trello_getCardCallChecklists() {
	$url = 'https://api.trello.com/1/boards/' . TRELLO_BOARD_ID . '/checklists?key=' . urlencode(TRELLO_KEY) . '&token=' . urlencode(TRELLO_TOKEN);
	$trello_Checklists =  json_decode(file_get_contents($url), true);
	
	$trello_CallChecklists = array();
	foreach ($trello_Checklists as $trello_Checklist) {
		if ($trello_Checklist['name'] === TRELLO_CHECKLIST_ID) {
			$trello_CallChecklists[] = $trello_Checklist;
		}
		
	}
	return $trello_CallChecklists;
}

function trello_getCardCallChecklist($idCard) {
	$url = 'https://api.trello.com/1/cards/' . $idCard . '/checklists?key=' . urlencode(TRELLO_KEY) . '&token=' . urlencode(TRELLO_TOKEN);
	$trello_Checklists =  json_decode(file_get_contents($url), true);
	
	foreach ($trello_Checklists as $trello_Checklist) {
		if ($trello_Checklist['name'] === TRELLO_CHECKLIST_ID) {
			return $trello_Checklist;
		}
		
	}
	return false;
}

function trello_deleteCardCallChecklist($idCard) {
	$checklist = trello_getCardCallChecklist($idCard);
	if ($checklist === false) {
		return true;
	}
	
	$url = 'https://api.trello.com/1/checklists/' . $checklist['id'] . '?key=' . urlencode(TRELLO_KEY) . '&token=' . urlencode(TRELLO_TOKEN);
	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array()));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return true; // eval response?
}

function trello_addChecklist($name, $idCard) {
	$url = 'https://api.trello.com/1/checklists/?name=' . urlencode($name) . '&idBoard=' . TRELLO_BOARD_ID . '&idCard=' . urlencode($idCard) . '&key=' . urlencode(TRELLO_KEY) . '&token=' . urlencode(TRELLO_TOKEN);
	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array()));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);
}

function trello_checklist_addItem($idChecklist, $name, $checked) {
	$url = 'https://api.trello.com/1/checklists/' . $idChecklist . '/checkItems?name=' . urlencode($name) . '&checked=' . ($checked ? 'true' : 'false') . '&key=' . urlencode(TRELLO_KEY) . '&token=' . urlencode(TRELLO_TOKEN);
	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array()));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);
}
function trello_checklist_deleteItem($idChecklist, $idChecklistItem) {
	$url = 'https://api.trello.com/1/checklists/' . $idChecklist . '/checkItems/' . $idChecklistItem . '?key=' . urlencode(TRELLO_KEY) . '&token=' . urlencode(TRELLO_TOKEN);
	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array()));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	return true;
}

function trello_getCards() {
	$url = 'https://api.trello.com/1/boards/' . TRELLO_BOARD_ID . '/cards?key=' . urlencode(TRELLO_KEY) . '&token=' . urlencode(TRELLO_TOKEN);
	return json_decode(file_get_contents($url), true);
}

function callsys_getCalls($username, $password) {
	$url = 'http://callsys.saa.lan/callsys/index.php?mod=call&md=1';
	
	$ch = curl_init($url);

	curl_setopt($ch, CURLAUTH_BASIC, 1);
	curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_COOKIEFILE, "cookiefile");
	curl_setopt($ch, CURLOPT_COOKIEJAR, "cookiefile");
	curl_setopt($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 


	curl_exec($ch);
	
	curl_setopt($ch, CURLOPT_URL, 'http://callsys.saa.lan/callsys/index.php?mod=call&md=1&ac=DESC&sort=agendadatum&zoeksubmit=zoek&callnummer=&text_value=&status_id=&afdeling_id=3&admin=&prioriteit=&categorie_id=6&gebruikersnaam=&gebruiker_kantoor=&gebruiker_afdeling=&agendadatum=');
	
	
	$response = curl_exec($ch);
	
	curl_close($ch);

	if (empty($response)) {
		return array();
	}
	
	ini_set('xdebug.scream', 0);
	$doc = new DOMDocument();
	$doc->strictErrorChecking = FALSE;
	@$doc->loadHTML($response);
	$xml = simplexml_import_dom($doc);
	ini_set('xdebug.scream', 1);
	
	$calls = array();
	foreach ($xml->xpath("//table[@class='overzicht']/tr[@class='list'] | //table[@class='overzicht']/tr[@class='listswitch']") as $call_row) {
		$title = (string)$call_row->td[2]->a;
		if (preg_match('/^\[?\#(?P<shortIdCard>\d+)\]?\s*(?P<titleReal>.*)$/', $title, $matches) === 1) {
			$calls[(string)$call_row->td[0]->a] = array(
				'shortIdCard' => $matches['shortIdCard'],
				'status' => (string)$call_row->td[1]->a,
				'title' => $matches['titleReal'],
				'prioriteit' => (string)$call_row->td[3]->a,
				'agenda-datum' => (string)$call_row->td[5]->a,
				'behandelaar' => (string)$call_row->td[6]->a
			);
		}
	}
	return $calls;
}

echo PHP_EOL . 'retrieving calls from callsys...';
$found = 0;
$callsys_cards_by_trello_card = array();
foreach (callsys_getCalls(CALLSYS_USERNAME, CALLSYS_PASSWORD) as $call_identifier => $call) {
	$found++;
	if (!isset($callsys_cards_by_trello_card[$call['shortIdCard']])) {
		$callsys_cards_by_trello_card[$call['shortIdCard']] = array();
	}
	$callsys_cards_by_trello_card[$call['shortIdCard']][$call_identifier] = $call;
}
echo $found . ' found';

if (empty($callsys_cards_by_trello_card)) {
	echo PHP_EOL . 'no calls linked to trello cards or unable to reach callsys...';
	
} else {
	echo PHP_EOL . 'adding calls to trello cards...';
	foreach (trello_getCards() as $trello_card) {
		if (!isset($callsys_cards_by_trello_card[$trello_card['idShort']])) {
			echo PHP_EOL . 'no items for card #' . $trello_card['idShort'] . ' (' . $trello_card['name'] .'), removing any CallSys-checklist...';
			trello_deleteCardCallChecklist($trello_card['id']);
			continue;
		}
		
		$trello_CardChecklist =  trello_getCardCallChecklist($trello_card['id']);
		if ($trello_CardChecklist === false) {
			echo PHP_EOL . 'no calls checklist for card #' . $trello_card['idShort'] . ' (' . $trello_card['name'] .'), adding checklist...';
			$trello_CardChecklist = trello_addChecklist(TRELLO_CHECKLIST_ID, $trello_card['id']);
		}

		foreach ($callsys_cards_by_trello_card[$trello_card['idShort']] as $callsys_card_identifier => $callsys_card) {
			switch ($callsys_card['status']) {
				case 'Lopend':
				case 'Behandelen':
					$checklistItemState = '';
					$checklistItemChecked = false;
					break;
				
				case 'Open':
					$checklistItemState = '*'; // new
					$checklistItemChecked = false;
					break;
				
				case 'Gesloten':
					$checklistItemState = '';
					$checklistItemChecked = true;
					break;
				
				default:
					$checklistItemState = '#'; // on-hold
					$checklistItemChecked = false;
					break;
			}
			
			$checklistItemName = '[' . $callsys_card_identifier . '] ' . (!empty($checklistItemState) ? $checklistItemState . ' ' : '') . $callsys_card['title'] . ' (' . $callsys_card['behandelaar'] . ')';
			
			echo PHP_EOL . 'is call ' . $callsys_card_identifier . ' already on any card?...';
			$found = array();
			foreach (trello_getCardCallChecklists() as $trello_Checklist) {
				foreach ($trello_Checklist['checkItems'] as $trello_Checklist_Checkitem) {
					if (preg_match('/^\[' . $callsys_card_identifier . '\]/', $trello_Checklist_Checkitem['name'], $matches) === 1) {
						$found[] = array(
							'item' => $trello_Checklist_Checkitem,
							'checklist' => $trello_Checklist
						);
					}
				}
				
			}
			
			$changed = false;
			if (empty($found)) {
				echo PHP_EOL . 'no, adding call ' . $callsys_card_identifier . ' to card #' . $trello_card['idShort'] . ' (' . $trello_card['name'] .')...';
				$changed = true;

			} else {
				foreach ($found as $found_Checklist) {
					if ($found_Checklist['checklist']['id'] !== $trello_CardChecklist['id']) {
						echo PHP_EOL . 'yes, "moving" call ' . $callsys_card_identifier . ' to card #' . $trello_card['idShort'] . ' (' . $trello_card['name'] .')...';
						trello_checklist_deleteItem($found_Checklist['checklist']['id'], $found_Checklist['item']['id']);
						$changed = true;
						
					} elseif ($found_Checklist['item']['name'] !== $checklistItemName) {
						echo PHP_EOL . 'yes, "updating" call ' . $callsys_card_identifier . ' on card #' . $trello_card['idShort'] . ' (' . $trello_card['name'] .')...';
						trello_checklist_deleteItem($found_Checklist['checklist']['id'], $found_Checklist['item']['id']);
						$changed = true;
						
					} elseif (($found_Checklist['item']['state'] !== 'incomplete') !== $checklistItemChecked) {
						echo PHP_EOL . 'yes, "updating" call ' . $callsys_card_identifier . ' on card #' . $trello_card['idShort'] . ' (' . $trello_card['name'] .')...';
						trello_checklist_deleteItem($found_Checklist['checklist']['id'], $found_Checklist['item']['id']);
						$changed = true;
						
					} else {
						echo PHP_EOL . 'yes, but no change is required...';
						
					}
				}
			}

			if ($changed) {
				trello_checklist_addItem($trello_CardChecklist['id'], $checklistItemName, $checklistItemChecked);
			}
			
		}

	}
}

echo PHP_EOL . 'done';
echo PHP_EOL;