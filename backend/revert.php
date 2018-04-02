<?php 
	include '../settings/connect.php';
	IF(session_id() == '') { page_protect(); } // Session start with redirection to login section
	if(isset($_SESSION['user_id'])):if(Student()):logout(); endif; endif;
	IF (Admin()) {
	 
			IF(empty($err)) {
 
				$tempv = mysqli_query($link, "SELECT ID, temp_name, start_date, end_date, unit_type,unit, temp_status,upload,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q11,q12,q13,q14,q15	 FROM ".DB_PREFIX."tempver WHERE ID='".$_SESSION['tempID']."'" );
				$tempver = mysqli_fetch_array($tempv);
  
				$sql_insert2 = "UPDATE ".DB_PREFIX."templates SET `temp_name` = '".$tempver['temp_name']."', `start_date` = '".$tempver['start_date']."', `end_date` = '".$tempver['end_date']."', `unit` = '".$tempver['unit']."',`unit_type` = '".$tempver['unit_type']."',
				`q1` = '".$tempver['q1']."',
				`q2` = '".$tempver['q2']."',
				`q3` = '".$tempver['q3']."',
				`q4` = '".$tempver['q4']."', 
				`q5` = '".$tempver['q5']."',
				`q6` = '".$tempver['q6']."',
				`q7` = '".$tempver['q7']."',
				`q8` = '".$tempver['q8']."',
				`q9` = '".$tempver['q9']."',
				`q10` = '".$tempver['q10']."',
				`q11` = '".$tempver['q11']."',
				`q12` = '".$tempver['q12']."',
				`q13` = '".$tempver['q13']."',
				`q14` = '".$tempver['q14']."',
				`q15` = '".$tempver['q15']."',
				`temp_status` = '".$tempver['temp_status']."',
				`upload` = '".$tempver['upload']."'  WHERE `ID` = ".$_SESSION['tempID']."";	
				mysqli_query($link, $sql_insert2) or die("Insertion Failed:" . mysqli_error());


				$_SESSION['msg'] = "The template has been reverted to its last version.";
				$_SESSION['temptab'] = "managetemps";
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
		
	 
?>
