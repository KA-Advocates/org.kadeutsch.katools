<?php

require_once 'katools.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function katools_civicrm_config(&$config) {
  _katools_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param array $files
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function katools_civicrm_xmlMenu(&$files) {
  _katools_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function katools_civicrm_install() {
  _katools_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function katools_civicrm_uninstall() {
  _katools_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function katools_civicrm_enable() {
  _katools_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function katools_civicrm_disable() {
  _katools_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function katools_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _katools_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function katools_civicrm_managed(&$entities) {
  _katools_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * @param array $caseTypes
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function katools_civicrm_caseTypes(&$caseTypes) {
  _katools_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function katools_civicrm_angularModules(&$angularModules) {
_katools_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function katools_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _katools_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function katools_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function katools_civicrm_navigationMenu(&$menu) {
  _katools_civix_insert_navigation_menu($menu, NULL, array(
    'label' => ts('The Page', array('domain' => 'org.kadeutsch.katools')),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _katools_civix_navigationMenu($menu);
} // */


function getInnerHTML( $node ) { 
    $innerHTML= ''; 
    $children = $node->childNodes; 
    foreach ($children as $child) { 
        $innerHTML .= $child->ownerDocument->saveXML( $child ); 
    } 

    return $innerHTML; 
} 	

// Functions to corectly extract the content of the Mail
function parseMailPart( $part )
  {
      if ( $part instanceof ezcMail )
          return parseMailPart( $part );
  
      if ( $part instanceof ezcMailText )
          return parseMailText( $part );

      if ( $part instanceof ezcMailRfc822Digest )
          return parseMailRfc822Digest( $part );
  
      if ( $part instanceof ezcMailMultiPart )
          return parseMailMultipart( $part );

	die( "No clue about the ". get_class( $part ) . "\n" );

}

function parseMailMultipart( $part )
 {
     if ( $part instanceof ezcMailMultiPartAlternative )
		return parseMailMultipartAlternative( $part );

	if ( $part instanceof ezcMailMultiPartDigest )
		return parseMailMultipartDigest( $part );

	if ( $part instanceof ezcMailMultiPartRelated )
		return parseMailMultipartRelated( $part );

	if ( $part instanceof ezcMailMultiPartMixed )
		return parseMailMultipartMixed( $part );

	die( "No clue about the ". get_class( $part ) . "\n" );
}

function parseMailMultipartMixed( $part ) {
	$t = '';
	foreach ( $part->getParts() as $key => $alternativePart ){
		$t .= parseMailPart( $alternativePart );
	}
	return $t;
}

function parseMailMultipartRelated( $part )
{
	$t = '';
	$t .= parseMailPart( $part->getMainPart() );
	foreach ( $part->getRelatedParts() as $key => $alternativePart ){
		$t .= parseMailPart( $alternativePart );
	}
	return $t;
}

function formatMailMultipartDigest( $part ) {
	$t = '';
	foreach ( $part->getParts() as $key => $alternativePart )
	{
		$t .= parseMailPart( $alternativePart );
	}
	
	return $t;
}

function parseMailRfc822Digest( $part )
{
	$t = '';
	$t .= parseMailpart( $part->mail );
	return $t;
}

function parseMailMultipartAlternative( $part ) {
	$t = '';
	foreach ( $part->getParts() as $key => $alternativePart ) {
		$t .= parseMailPart( $alternativePart );
	}
	return $t;
}

function parseMailText( $part ) {
	if ($part->subType == "html")
		return parseWUFOOMail($part->text);
	else
		return "";
 }
 
 
//Function called by ezcMail Magic	
function parseWUFOOMail($html) {
	global $wufooLog;
	
	
	
	$email = "";
	$firstname = "";
	$lastname = "";
	$country = "";
	$intro = "";
	$sunday = "";
	$expertise = "";
	$expertiseDetails = "";
	$newsletter = "";
	$username = "";

	$dom = new domDocument;
	@$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
	
	$dom->preserveWhiteSpace = false;
	$tables = $dom->getElementsByTagName('table');


	$rows = $tables->item(0)->getElementsByTagName('tr');

	$i=0;
	$offset=0;

	foreach ($rows as $row) {
		$labels = $row->getElementsByTagName('th');	
        $cols = $row->getElementsByTagName('td');
			
				if ( ! is_null($labels->item(0) ) ) {
					
					$label = $labels->item(0)->nodeValue;
					
					if (strstr($label, "Native Language") ) {
						
					} else if (strstr($label, "If Other, please specify") ) {
						
					} else if (strstr($label, "Email") ) {
						$email = trim($cols[0]->nodeValue);
					} else if (strstr($label, "Name") ) {
						$parts = preg_split('#\s+#', trim($cols[0]->nodeValue), null, PREG_SPLIT_NO_EMPTY);
						$firstname = trim($parts[0]);
						$lastname = trim($parts[1]);						
					} else if (strstr($label, "Where are you located") ) {
						$country = trim($cols[0]->nodeValue);
					} else if (strstr($label, "Tell us about yourself") ) {
						if ( $cols->length > 0 ) {
							$intro = trim($cols[0]->nodeValue);	
						} else {
							$intro = trim($rows->item($i+1)->getElementsByTagName('td')[0]->nodeValue);
							$i++;							
						}						
					} else if (strstr($label, "describe your ideal Sunday") ) {
						
						if ( $cols->length > 0 ) {
							$sunday = trim($cols[0]->nodeValue);	
						} else {
							$sunday = trim($rows->item($i+1)->getElementsByTagName('td')[0]->nodeValue);
							$i++;							
						}
					} else if (strstr($label, "Do you have any specific areas of expertise?") ) {
						
						if ( $cols->length > 0 ) {
							$expertise = preg_replace('#\n+#',',',trim($cols[0]->nodeValue));

							
						} else {
							$expertise = preg_replace('#\n+#',',',trim($rows->item($i+1)->getElementsByTagName('td')[0]->nodeValue));
							$i++;							
						}
					} else if (strstr($label, "If applicable, please tell us more about your area") ) {
						
						if ( $cols->length > 0 ) {
							$expertiseDetails = trim($cols[0]->nodeValue);	
						} else {
							$expertiseDetails = trim($rows->item($i+1)->getElementsByTagName('td')[0]->nodeValue);
							$i++;							
						}
					} else if (strstr($label, "account on Khan Academy") ) {
						$KAAccount = trim($cols[0]->nodeValue);
					}  else if (strstr($label, "account on Amara or Crowdin") ) {
						$crowdinAccount = trim($cols[0]->nodeValue); 
					}   else if (strstr($label, "email updates") ) {
						$newsletter = trim($cols[0]->nodeValue); 
					}
				}
		$i++;
	}

	fwrite($wufooLog, "\nWUFOO from $firstname $lastname ($email) from $country\n");
	fwrite($wufooLog, "\nintro: $intro");
	fwrite($wufooLog, "\nexpertise : $expertiseDetails");
	fwrite($wufooLog, "\nSunday : $sunday");
	fwrite($wufooLog, "\ncrowdin: $crowdinAccount");
	fwrite($wufooLog, "\nNews : $newsletter\n");
	
	require_once("/var/www/vhosts/kadeutsch.org/wp-content/plugins/civicrm/civicrm/api/class.api.php");
	$api = new civicrm_api3();

	// First lets check if this contact does already exist
	$params = array(
		'email' => $email,
	);

	// now we can create the contact
		$contactParams = array(
			'first_name' => $firstname,
			'last_name' => $lastname,
			'email' => $email,
			'contact_type' => 'Individual',
			'preferred_mail_format' => 'Both',
			'custom_46' => $intro,  // motivation
			'custom_47' => $sunday,  // sunday
			'custom_48' => $expertise . "\n" . $expertiseDetails,  // expertise
			'custom_2' => $KAAccount,  // KA Username
			'custom_1' => $crowdinAccount,  // Crowind Username
		);				

		if ($newsletter == "No, thanks!") {
			$contactParams["is_opt_out"] = 1;
			// Add to Group Newsletter
			$contactParams['api.GroupContact.create'] = array(
				'0' => array('group_id' => 'Interessenten_24')
			);			
		} else {
			// Add to Group Newsletter
			$contactParams['api.GroupContact.create'] = array(
				'0' => array('group_id' => 'Newsletter_7'),
				'1' => array('group_id' => 'Interessenten_24')
			);
		}
		
		$contactParams['api.EntityTag.create'] = array( 'tag_id' => 6);  // Add tag interessent
		
		// Country needs to be mapped
		switch ( $country) {
			case "Germany":
				$contactParams["country"] = "Deutschland";
				break;
			case "Switzerland":
				$contactParams["country"] = "Schweiz";
				break;
			case "Austria":
				$contactParams["country"] = "Österreich";
				break;
			
				
		}
		
		
	// Tags need to be chained : "entity_table": "civicrm_contact",  "entity_id": "81", "tag_id": "15"
	if ($api->Contact->Get($params)) {
		if ($api->count > 0 ) {
			// update existing contact
			$contactParams["contact_id"] = $api->values[0]->contact_id;
		}
		
		if (! $api->Contact->Create($contactParams)) {
			fwrite($wufooLog, $api->errorMsg());
		} else {
			fwrite($wufooLog, "successfully updated\n");
		}
		
	} else {
		fwrite($wufooLog, $api->errorMsg());
	}
	
	
}
 
// CiviCRM Hook to be invoked after processing each Mail
function katools_civicrm_emailProcessor( $type, &$params, $mail, &$result, $action = null ) {
	global $wufooLog;
	
	if (strstr($mail->subject, "Khan Academy German Volunteer Application") ) {
		$wufooLog = fopen("/tmp/wufoolog.txt", "a");
		fwrite($wufooLog, date("d.m.Y") . "Processing WUFOO Email : $mail->subject\n\n");
		// Parse the Email
		parseMailPart($mail->body);
		fwrite($wufooLog, date("d.m.Y") . "WUFOO Email finished\n\n");
		fclose($wufooLog);
	}
}

// Add a Tabset to Display Crowdin Data
function katools_civicrm_tabset( $tabsetName, &$tabs, $context ) {
	if ($tabsetName == 'civicrm/contact/view') {
		$contactId = $context['contact_id'];
		// let's add a new "contribution" tab with a different name and put it last
		// this is just a demo, in the real world, you would create a url which would
		// return an html snippet etc.
		$url = CRM_Utils_System::url( 'civicrm/contact/view/contribution',
									  "reset=1&snippet=1&force=1&cid=$contactID" );
		// $url should return in 4.4 and prior an HTML snippet e.g. '<div><p>....';
		// in 4.5 and higher this needs to be encoded in json. E.g. json_encode(array('content' => <html form snippet as previously provided>));
		// or CRM_Core_Page_AJAX::returnJsonResponse($content) where $content is the html code
		// in the first cases you need to echo the return and then exit, if you use CRM_Core_Page method you do not need to worry about this.
		$tabs[] = array( 'id'    => 'mySupercoolTab',
		  'url'   => $url,
		  'title' => 'Crowdin Contributions',
		  'weight' => 300,
		);		
	}
}

function katools_civicrm_tokens(&$tokens) {
    $tokens['contact'] = array(
        'contact.untertitel_tasks' => 'persoehnliche Pendenzen Untertitel-Team',
    );
	
  $tokens['date'] = array(
    'date.date_month' => 'Aktueller Monat',
    'date.date_week' => 'Aktuelle Woche: WW/yyyy',
    'date.date_long' => 'Heutiges Datum: Month dth, yyyy',
  );	
}

// Function to convert CSV into associative array
function csvToArray($file, $delimiter) {
  if (($handle = fopen($file, 'r')) !== FALSE) { 
    $i = 0; 
    while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) { 
      for ($j = 0; $j < count($lineArray); $j++) { 
        $arr[$i][$j] = $lineArray[$j]; 
      } 
      $i++; 
    } 
    fclose($handle); 
  } 
  return $arr; 
}

function subst($str, $dict){
    return preg_replace(array_map(create_function('$a', 'return "/%\\($a\\)s/";'), array_keys($dict)), array_values($dict), $str);
 }

//#Function to process a Backlog-File
function processBacklog(&$strings, $cids, $bl, $log) {
	
	fwrite($log, "loading CSV Array from Google Spreadsheet\n\n");
	//load the Field Configuration
	$cfg = $bl["fields"];
	
	// load date from Web
	$backlog = csvToArray($bl["backlogURL"], ',');
	$team = csvToArray($bl["teamURL"], ',');
	
	//Use first row for names
	$backLogLabels = array_shift($backlog);
	$teamLabels = array_shift($team);
	
	foreach ($team as &$contact) {

		$cid = $contact[ $cfg["contact"]];
		if ( in_array( $contact[ $cfg["contact"] ], $cids) ) {
			//fwrite($log, "contact matched " . $video[8] . "\n");
			
			$nickname = $contact[ $cfg["nickname"] ];
			
			// Initialize array to return assigned tasks
			if ( !array_key_exists($cid, $strings ) ) {
				$strings[ $cid  ]  = array(
					"assigned" => array(),
					"review" => array(),
				);
			}				
			
			foreach($backlog as $video) {
					
				// check for item matching nickname and status column --> assigned workitems
				if ( $video[ $cfg["assignedNickname"]] == $nickname && in_array($video[ $cfg["status"] ], $cfg["assignedStatus"] ) ) {
					
					//$strings[$cid]["assigned"][] = '<li>Bitte übersetze : <a href="https://www.youtube.com/timedtext_video?v=' . $video[4] . '">' . $video[5] . ", Dauer : " . $video[6] . "</a></li>\n";
					$str = str_replace("{URL}",  $cfg["editURL"]($video), $cfg["assignedStr"] );
					$strings[$cid]["assigned"][] =  subst( $str, $video );
				}
				// check for item matching nickname and status column --> assigned reviewitems				
				if ( $video[$cfg["reviewNickname"]] == $nickname && in_array( $video[$cfg["status"]], $cfg["reviewStatus"]) ) {
					
					//$str = str_replace("{URL}", urlencode(subst( $cfg["reviewUrl"], $video)), $cfg["reviewStr"]);
					$str = str_replace("{URL}",  $cfg["reviewURL"]($video), $cfg["reviewStr"] );
					$strings[$cid]["review"][] = subst( $str, $video) ;
				}
					
			}

			
			
		}
	}	
}

// Hook to process 
function katools_civicrm_tokenValues(&$values, $cids, $job = null, $tokens = array(), $context = null) {
    // Define the Backlog CSV Files to be parsed
	$backlogs = array(
		array(
		"backlogURL" => 'https://docs.google.com/spreadsheets/d/1-1rM_MyfxXuX7aT1k8D4HLQ_IwFgMDGXIbCH-3zUIMQ/pub?gid=1144837871&single=true&output=csv',  // this is the link to the backlog tab in UT Backlog
		"teamURL" => 'https://docs.google.com/spreadsheets/d/1-1rM_MyfxXuX7aT1k8D4HLQ_IwFgMDGXIbCH-3zUIMQ/pub?gid=52742320&single=true&output=csv',
		"fields" => array( "contact" => 0, "nickname" => 3, "assignedNickname" => 8, "status" => 12, "reviewNickname" => 10, "reviewStatus" => 12,
					"assignedStatus" => array( "Zugewiesen", "in Arbeit", "Zurueckgewiesen"),
					"assignedStr" => '<li>Bitte übersetze den Untertitel : <a href="{URL}">%(5)s, Dauer : %(6)s</a></li>',
					"editURL" => function($data) {
						return "https://www.youtube.com/timedtext_video?v=" . $data[4];
					},
					"reviewStatus" => array("Uebersetzt"),
					"reviewStr" => '<li>%(8)s wartet seit dem %(9)s auf dein Review von <a href="{URL}">%(5)s</a></li>',
					"reviewURL" => function($data) {
						return 'https://docs.google.com/forms/d/1lxKLZinyitDQb-tSGmRNWGtsPDQG2iGXZRlyuvcxrLA/viewform?entry.675763289='.$data[5].'&entry.643804832='.$data[4].'&entry.1356226264='.$data[10].'&entry.1511908839='.$data[8];
					},
					),
		),
		array(
		"backlogURL" => 'https://docs.google.com/spreadsheets/d/10tYCC84PonnH69cOX2j8dADDRZzAl65-Ou6jXlts_do/pub?gid=1144837871&single=true&output=csv',  // this is the link to the backlog tab in Crowdin Backlog
		"teamURL" => 'https://docs.google.com/spreadsheets/d/10tYCC84PonnH69cOX2j8dADDRZzAl65-Ou6jXlts_do/pub?gid=52742320&single=true&output=csv',
		"fields" => array(
					"contact" => 0, "nickname" => 3, "assignedNickname" => 14, "status" => 10, "reviewNickname" => 16, "reviewStatus" => 10,
					"assignedStatus" => array( "TODO"),
					"assignedStr" => '<li>Bitte übersetze : <a href="{URL}">%(3)s: %(5)s, %(6)s Wörter</a></li>',
					'editURL' => function($data) {
						  if ($data[3] == "Article")
							return "https://translate.khanacademy.org/a/".$data[4];
						  else
							return "https://de.khanacademy.org/translations/edit/de/e/" . $data[4];
					},
					"reviewStatus" => array("Translated"),
					"reviewStr" => '<li>%(14)s wartet seit dem %(15)s auf dein Approval von <a href="{URL}">%(3)s: %(5)s</a></li>',
					"reviewURL" => function($data) {
						return "https://crowdin.com/proofread/khanacademy/all/enus-de#q=". $data[4];
					},					
					),
		),		
	);

    $tokens += array(
    'contact' => array(),
    );
    $log = fopen("/tmp/utTaskMaillog.txt", "a");
    
	// Process the Mail Merge Tag untertitel_tasks --> should be changed to kadeutsch_tasks
    if (in_array('untertitel_tasks', $tokens['contact'])) {
		
		$strings = array( );
		
		foreach( $backlogs as $backlog ) {
			processBackLog( $strings, $cids, $backlog, $log);
		}

		
		foreach( $strings as $cid => $string ) {
			$assigned = $string["assigned"];
			$review = $string["review"];		
			
			$backlogURL1 = "https://docs.google.com/spreadsheets/d/1-1rM_MyfxXuX7aT1k8D4HLQ_IwFgMDGXIbCH-3zUIMQ/edit?pli=1#gid=1144837871";
			$backlogURL2 = "https://docs.google.com/spreadsheets/d/10tYCC84PonnH69cOX2j8dADDRZzAl65-Ou6jXlts_do/edit#gid=1144837871";
			if ( count($assigned) > 0 or count($review) > 0 ) {
				$msg = "\nDu hast momentan folgende pendente Aufgaben zum Übersetzen oder Review:";
				$msg .= "<ul>" . implode($assigned) . implode($review) . "</ul>Bitte erledige diese und aktualisiere dann das Backlog. </ul>";
				
				$msg .= "Backlog URLs:<br/><ul><li><a href='".$backlogURL1."'>Untertitel-Backlog</a></li><li><a href='".$backlogURL2."'>Crowdin-Backlog</a></li>.";
			} else {
				$msg = "\nDu hast momentan keine pendenten Aufgaben zum Übersetzen oder Review, such dir im Backlog ein paar freie Aufgaben aus!<br/>\n";
			}

			fwrite($log, $msg);

			$values[$cid]['contact.untertitel_tasks'] = $msg;
		}
    }
	
		// Date tokens
		if (!empty($tokens['date'])) {
		$date = array(
			'date.date_month' => date('F'),
			'date.date_week' => date('W/Y'),
			'date.date_long' => date('F jS, Y'),
    );
		foreach ($cids as $cid) {
			$values[$cid] = empty($values[$cid]) ? $date : $values[$cid] + $date;
		}
	}
    
    fwrite($log, date("d.m.Y") . "tokenValue finished\n\n");
	fclose($log);
}

function katools_civicrm_pageRun(&$page) {
  $pageName = $page->getVar('_name');
	$log = fopen("/tmp/pagerun.txt", "a");
    
  
  
  if ($pageName == 'CRM_Contact_Page_View_UserDashBoard') { 
    /*
     * retrieve all tag enhanced data and put in array with tag_id as index
     */

	 fwrite($log, print_r($page,true));
	 
	 
  }
  fwrite($log, date("d.m.Y") . " $pageName pagerun finished\n\n");
  	fclose($log);

}
