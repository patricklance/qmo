<?php 
	include '../settings/connect.php';
	IF(session_id() == '') { page_protect(); } // Session start with redirection to login section
	if(isset($_SESSION['user_id'])):if(Student()):logout(); endif; endif;
	IF (Admin()) {
	
		$err = array();
		IF(isset($_POST) && array_key_exists('addtemp',$_POST)){
			// foreach($_POST as $key => $value) {
			// 	$_POST[$key] = filter($value);
			// }
			
			//Get START and END DATE
			IF($_POST['smonth'] < 10) { $smonthdata = '0'.$_POST['smonth']; }else{ $smonthdata = $_POST['smonth']; }
			IF($_POST['emonth'] < 10) { $emonthdata = '0'.$_POST['emonth']; }else{ $emonthdata = $_POST['emonth']; }
			
			IF($_POST['sAMPM'] == 1) { $sAMPM = "AM"; }ELSE{ $sAMPM = "PM"; } 
			IF($_POST['eAMPM'] == 1) { $eAMPM = "AM"; }ELSE{ $eAMPM = "PM"; } 
			
			$stime = $_POST['shour'].":".$_POST['sminute']." ".$sAMPM;
			$starttime = date("G:i", strtotime($stime));
			
			$etime = $_POST['ehour'].":".$_POST['eminute']." ".$eAMPM;
			$endtime = date("G:i", strtotime($etime));
			
			$sdate = $_POST['syear']."-".$smonthdata."-".$_POST['sdate']." ".$starttime;
			$edate = $_POST['eyear']."-".$emonthdata."-".$_POST['edate']." ".$endtime;

			// Validate all required Fields
			IF(empty($_POST['tempname']) || strlen($_POST['tempname']) < 2) { $err[] = "ERROR - Invalid template name. Please enter at least 2 or more characters";}
			IF(!isset($_POST['smonth']) || $_POST['smonth'] == "") {$err[] = "ERROR - Please select start month";}
			IF(!isset($_POST['sdate']) || $_POST['sdate'] == "") {$err[] = "ERROR - Please select start date";}
			IF(!isset($_POST['syear']) || $_POST['syear'] == "") {$err[] = "ERROR - Please select start year";}
			IF(!isset($_POST['shour']) || $_POST['shour'] == "") {$err[] = "ERROR - Please select start time";}

			IF(!isset($_POST['emonth']) || $_POST['emonth'] == "") {$err[] = "ERROR - Please select end month";}
			IF(!isset($_POST['edate']) || $_POST['edate'] == "") {$err[] = "ERROR - Please select end date";}
			IF(!isset($_POST['eyear']) || $_POST['eyear'] == "") {$err[] = "ERROR - Please select end year";}
			IF(!isset($_POST['ehour']) || $_POST['ehour'] == "") {$err[] = "ERROR - Please select end time";}
			IF(!isset($_POST['unit_type']) || $_POST['unit_type'] == "") {$err[] = "ERROR - Please select unit type";}
			// IF(!isset($_POST['unit']) || $_POST['unit'] == "") {$err[] = "ERROR - Please select unit";}
			 
			IF(empty($_POST['q1']) || strlen($_POST['q1']) < 2) { $err[] = "ERROR - Invalid question. Please enter at least 2 or more characters";}
			// IF(empty($_POST['q2']) || strlen($_POST['q2']) < 2) { $err[] = "ERROR - Invalid question. Please enter at least 2 or more characters";}
			// IF(empty($_POST['q3']) || strlen($_POST['q3']) < 2) { $err[] = "ERROR - Invalid question. Please enter at least 2 or more characters";}
			IF(isset($_POST['publish'])){ $publish = 1; }ELSE{ $publish = 0; }
			IF(isset($_POST['upload'])){ $upload = 1; }ELSE{ $upload = 0; }
						
			//All required form has been validated
			IF(empty($err)) {
//GET unit list
$woe = $_POST['check_list'];
$commaList = implode(', ', $woe);
//   echo $commaList."<br>";



				$sql_insert = "INSERT into ".DB_PREFIX."templates (`temp_name`,`start_date`,`end_date`,`unit_type`,`unit`,`q1`,`q2`,`q3`,`q4`,`q5`,`q6`,`q7`,`q8`,`q9`,`q10`,`q11`,`q12`,`q13`,`q14`,`q15`,`temp_status`,`upload`)
				VALUES ('$_POST[tempname]','$sdate','$edate','$_POST[unit_type]','$commaList','$_POST[q1]','$_POST[q2]','$_POST[q3]','$_POST[q4]','$_POST[q5]','$_POST[q6]','$_POST[q7]','$_POST[q8]','$_POST[q9]','$_POST[q10]','$_POST[q11]','$_POST[q12]','$_POST[q13]','$_POST[q14]','$_POST[q15]','$publish','$upload')";
				
				mysqli_query($link, $sql_insert) or die("Insertion Failed:" . mysqli_error());


				$sql_insert2 = "INSERT into ".DB_PREFIX."tempver (`temp_name`,`start_date`,`end_date`,`unit_type`,`unit`,`q1`,`q2`,`q3`,`q4`,`q5`,`q6`,`q7`,`q8`,`q9`,`q10`,`q11`,`q12`,`q13`,`q14`,`q15`,`temp_status`,`upload`)
				VALUES ('$_POST[tempname]','$sdate','$edate','$_POST[unit_type]','$commaList','$_POST[q1]','$_POST[q2]','$_POST[q3]','$_POST[q4]','$_POST[q5]','$_POST[q6]','$_POST[q7]','$_POST[q8]','$_POST[q9]','$_POST[q10]','$_POST[q11]','$_POST[q12]','$_POST[q13]','$_POST[q14]','$_POST[q15]','$publish','$upload')";
				
				mysqli_query($link, $sql_insert2) or die("Insertion Failed:" . mysqli_error());



				$user_id = mysqli_insert_id($link);
				$_SESSION['msg'] = "New template has been added.";
				$_SESSION['temptab'] = "managetemps";

				//notification
				$q = "INSERT into ".DB_PREFIX."notification (`name`,`units`,`status`)
				VALUES ('$_POST[tempname]','$commaList','u' )  ";
					mysqli_query($link, $q) or die("Insertion Failed:" . mysqli_error());

				header("Location: templates.php");
				exit();

			} // NO ERROR
				ELSE {
				$_SESSION['errors'] = $err;
				$_SESSION['temptab'] = "addnewtemp";
				$_SESSION['post'] = $_POST;
				header("Location: templates.php");
				exit();
			}
		} // Submitted	
		
	}
?>
