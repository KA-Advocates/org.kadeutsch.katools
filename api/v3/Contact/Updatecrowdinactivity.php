<?php


/**
 * Contact.Updatecrowdinactivity API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_contact_Updatecrowdinactivity_spec(&$spec) {
  //$spec['magicword']['api.required'] = 1;
}

// loadt the Crowdin Activity Data from JSON into database table
function loadCrowdinActivity($conn, $date_to="") {
        #Now loading the activities
        $activityURL = "https://crowdin.com/project_actions/activity_stream?project_id=10880&language_id=11&show_activity=";
		if ($date_to <> "") {
			$activityURL .= "&date_to=" . urlencode($date_to);
		}
		$str = file_get_contents($activityURL);
		$json = json_decode($str, true);
		
		$date_to = $json['date_to'];
		
		foreach ( $json['activity'] as $activity) {
			$id = $activity['id'];
			$userId = $activity['user_id'];
			$datetime = $activity['datetime'];
			$act = $activity['type'];
			$count = $activity['count'];
		
			$msg = $activity['message'];
			$tmp = strstr($msg,">");
            $username = strstr(substr($tmp,1),'<',1);
			
			
			//print $username . "\n";
			//print(date("F j, Y, g:i a", $ts)."\n");
		
			// first try to find a matching user account and set the crowdin UserID and LastActivity Fields
			$sql = "SELECT * from civicrm_value_crowdin_5 where crowdin_username_1 = '$username'";
			if ( $result = $conn->query($sql) ) {
				$row = $result->fetch_row();

				if ($row[3] <> $userId ) {
					$sql = "UPDATE civicrm_value_crowdin_5 SET crowdinid_53=$userId where crowdin_username_1 = '$username'";
					$conn->query($sql);
				}
			
				$lastAct = $row[5] + $count;
				if ($row[4] < $datetime ) {
					$sql = "UPDATE civicrm_value_crowdin_5 SET last_activity_54='$datetime', activity_30_days_55=$lastAct where crowdin_username_1 = '$username'";
					$conn->query($sql);
				}
			
				
			} else {
				print( "Error: " . $sql . "\n" . $conn->error . '\n');
			}					
			
			// import all fields into the database
			$sql = "SELECT * from civicrm_crowdin_activity where civicrm_crowdin_activity.id = $id";

			//import activity only once, ignore subsequent activiyIDs
			if ( $result = $conn->query($sql)) {
				if ( $result->num_rows == 0 ) {				
					$sql = "INSERT INTO civicrm_crowdin_activity (id, userID, datetime, activity, count) VALUES ($id, $userId, '$datetime', '$act', $count)";
					if ($conn->query($sql) === TRUE) {
					} else {
						echo "Error: " . $sql . "<br>" . $conn->error;
					}
				} else {
				}
			} 
			
		}
		return $date_to;
}

// Update the Custom Fields in CiviCRM
function updateCrowdinActivityStat($conn) {
	
	//First need to reset the activity fields to 0
	$sql = "UPDATE civicrm_value_crowdin_5 SET activity_30_days_55=0, activity_3_month_57=0";
	$result = $conn->query($sql);
	
	// Select / Aggregate activity from the last 30 days
	$sql = "SELECT userID, SUM(count) as act FROM `civicrm_crowdin_activity` WHERE activity='phrase_suggested' AND datetime >= DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH) group by userID";
	if ( $result = $conn->query($sql)) {
		while($row = $result->fetch_assoc()) {
			$act = $row['act'];
			$userID = $row['userID'];
			$sql = "UPDATE civicrm_value_crowdin_5 SET activity_30_days_55=$act where crowdinid_53 = '$userID'";
			$result1 = $conn->query($sql);
		}
	}
	
	// Select / Aggregate activity from the last 3 month
	$sql = "SELECT userID, SUM(count) as act FROM `civicrm_crowdin_activity` WHERE activity='phrase_suggested' AND datetime >= DATE_SUB(CURRENT_DATE, INTERVAL 3 MONTH) group by userID";
	if ( $result = $conn->query($sql)) {
		while($row = $result->fetch_assoc()) {
			$act = $row['act'];
			$userID = $row['userID'];
			$sql = "UPDATE civicrm_value_crowdin_5 SET activity_3_month_57=$act where crowdinid_53 = '$userID'";
			$result1 = $conn->query($sql);
		}
	}	
}

// Update the Custom Fields in CiviCRM
function updateUTActivityStat($conn, $log) {

	$bl = array(
		"backlogURL" => 'https://docs.google.com/spreadsheets/d/1-1rM_MyfxXuX7aT1k8D4HLQ_IwFgMDGXIbCH-3zUIMQ/pub?gid=1144837871&single=true&output=csv',  // this is the link to the backlog tab in UT Backlog
		"teamURL" => 'https://docs.google.com/spreadsheets/d/1-1rM_MyfxXuX7aT1k8D4HLQ_IwFgMDGXIbCH-3zUIMQ/pub?gid=52742320&single=true&output=csv',
		"fields" => array( "contact" => 0, "nickname" => 3, "assignedNickname" => 8, "status" => 12, "reviewNickname" => 10, "reviewStatus" => 12, "date" => 9, "duration" => 6,
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
	);

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
		// Crowdin Contact ID
		$cid = $contact[ $cfg["contact"]];
		$nickname = $contact[ $cfg["nickname"] ];		
		fwrite($log, "doing " . $nickname . "\n");
		
		$num30 = 0;
		$num90 = 0;
		$dur30 = 0;
		$dur90 = 0;
		
		foreach($backlog as $video) {
			
			// Select all Videos where nickname matches
			if ( $video[ $cfg["assignedNickname"]] == $nickname && strlen($video[ $cfg["date"] ]) > 0 ) {

				// Turn the Date into a Time Variable				
				$now = new DateTime("now");
				$vdate = new DateTime($video[ $cfg["date"] ]);
				$diff = $now->diff($vdate);
				
				//calculate duration of video
				$dur = split(":",$video[ $cfg["duration"] ]);
				$duration = 0;
				if ( count($dur) >=3 ) {
					$duration = $dur[1]*60 + $dur[2];
				}
				
				if ( $diff->days <= 30 ) {
					$num30 = $num30 + 1;
					$dur30 = $dur30 + $duration;
					
				}
				
				if ( $diff->days <= 90 ) {
					$num90 = $num90 + 1;
					$dur90 = $dur90 + $duration;
				}
			}
		}
			
			
		// SQL Statement für die Aktualsierung
		
		$dur30s = sprintf('%02d:%02d:%02d', ($dur30/3600),($dur30/60%60), $dur30%60);
		$dur90s = sprintf('%02d:%02d:%02d', ($dur90/3600),($dur90/60%60), $dur90%60);
				fwrite($log, "$nickname has done $num30 / $dur30s and $num90 / $dur90s \n" );

		$sql = "UPDATE civicrm_value_crowdin_5 SET ut_activity_30_days_59=$num30, ut_activity_3_month_60=$num90, ut_duration_30_days_61='$dur30s', ut_duration_3_month_62='$dur90s' where entity_id = '$cid'";
		$result1 = $conn->query($sql);			
			
		#$sql = "UPDATE civicrm_value_crowdin_5 SET ut_activity_3_month_60=$num90 where entity_id = '$cid'";
		#$result1 = $conn->query($sql);		
		
	}
	
}

/**
 * Contact.Updatecrowdinactivity API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_contact_Updatecrowdinactivity($params) {
	global $crowdinLog, $db_host, $db, $pw; 
	
	$error = 0;
  
	$crowdinLog = fopen("/tmp/crowdinlog.txt", "a");
	fwrite($crowdinLog, "Running Crowdin ActivityLog\n\n");
	require_once 'credentials.php';
  
	$conn = new mysqli($ka_db_host, $ka_db, $ka_pw);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$conn->select_db("kadeutsch_civicrm");	  
  
	$date_to="";
	$date_to = loadCrowdinActivity($conn, $date_to); 
	updateCrowdinActivityStat($conn);
	updateUTActivityStat($conn, $crowdinLog);
		
	fwrite($crowdinLog, "Crowdin ActivityLog finished\n\n");
	fclose($crowdinLog);
	
	$returnValues = 1;
	return civicrm_api3_create_success($returnValues, $params, 'Contact', 'UpdateCrowdinActivity');  
	if ($error > 0) {
		// Spec: civicrm_api3_create_success($values = 1, $params = array(), $entity = NULL, $action = NULL)
		return civicrm_api3_create_success($returnValues, $params, 'Contact', 'Updatecrowdinactivity');
	} else {
		throw new API_Exception(/*errorMessage*/ 'Everyone knows that the magicword is "sesame"', /*errorCode*/ 1234);
	}
}

