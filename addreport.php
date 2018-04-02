<?php 
	include 'settings/connect.php';
	IF(session_id() == '') { page_protect(); } // Session start with redirection to login section
	// if(isset($_SESSION['user_id'])):if(Student()):logout(); endif; endif;
	IF (STUDENT()) {
	
		$err = array();
		IF(isset($_POST) && array_key_exists('addtemp',$_POST)){
			// foreach($_POST as $key => $value) {
			// 	$_POST[$key] = filter($value);
			// }
			
			 

			// Validate all required Fields
			// IF(empty($_POST['tempname']) || strlen($_POST['tempname']) < 2) { $err[] = "ERROR - Invalid template name. Please enter at least 2 or more characters";}
			// IF(!isset($_POST['smonth']) || $_POST['smonth'] == "") {$err[] = "ERROR - Please select start month";}
			// IF(!isset($_POST['sdate']) || $_POST['sdate'] == "") {$err[] = "ERROR - Please select start date";}
			// IF(!isset($_POST['syear']) || $_POST['syear'] == "") {$err[] = "ERROR - Please select start year";}
			// IF(!isset($_POST['shour']) || $_POST['shour'] == "") {$err[] = "ERROR - Please select start time";}

			// IF(!isset($_POST['emonth']) || $_POST['emonth'] == "") {$err[] = "ERROR - Please select end month";}
			// IF(!isset($_POST['edate']) || $_POST['edate'] == "") {$err[] = "ERROR - Please select end date";}
			// IF(!isset($_POST['eyear']) || $_POST['eyear'] == "") {$err[] = "ERROR - Please select end year";}
			// IF(!isset($_POST['ehour']) || $_POST['ehour'] == "") {$err[] = "ERROR - Please select end time";}
			// IF(!isset($_POST['unit_type']) || $_POST['unit_type'] == "") {$err[] = "ERROR - Please select unit type";}
			// IF(!isset($_POST['unit']) || $_POST['unit'] == "") {$err[] = "ERROR - Please select unit";}
			 
			// IF(empty($_POST['q1']) || strlen($_POST['q1']) < 2) { $err[] = "ERROR - Invalid question. Please enter at least 2 or more characters";}
			// // IF(empty($_POST['q2']) || strlen($_POST['q2']) < 2) { $err[] = "ERROR - Invalid question. Please enter at least 2 or more characters";}
			// // IF(empty($_POST['q3']) || strlen($_POST['q3']) < 2) { $err[] = "ERROR - Invalid question. Please enter at least 2 or more characters";}
			// IF(isset($_POST['publish'])){ $publish = 1; }ELSE{ $publish = 0; }
						
			//All required form has been validated
			IF(empty($err)) {

// $woe = $_POST['unit'];
// $commaList = implode(', ', $woe);
//   echo $commaList."<br>";
				 $name = $_FILES['file']['name'];
 $target_dir = "images/";
 $target_file = $target_dir . basename($_FILES["file"]["name"]);

 // Select file type
 $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

 // Valid file extensions
 $extensions_arr = array("jpg","jpeg","png","gif");

 // Check extension
 if( in_array($imageFileType,$extensions_arr) ){
 
  // Convert to base64 
  $image_base64 = base64_encode(file_get_contents($_FILES['file']['tmp_name']) );
  $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
  // Insert record
  $query = "insert into reports(`image`) values ('".$image."')";
  mysqli_query($link,$query);
  
  // Upload file
  move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name);
 }
 

				$sql_insert = "INSERT into ".DB_PREFIX."reports (`user_id`,`temp_id`, `date`, `q1`,`q2`,`q3`,`q4`,`q5`,`q6`,`q7`,`q8`,`q9`,`q10`,`q11`,`q12`,`q13`,`q14`,`q15`, `image` )
				VALUES ( $_SESSION[user_id],$_SESSION[selecttempID],'$_SESSION[date]','$_POST[q1]','$_POST[q2]','$_POST[q3]','$_POST[q4]','$_POST[q5]','$_POST[q6]','$_POST[q7]','$_POST[q8]','$_POST[q9]','$_POST[q10]','$_POST[q11]','$_POST[q12]','$_POST[q13]','$_POST[q14]','$_POST[q15]', '$image' )";
				
				mysqli_query($link, $sql_insert) or die("Insertion Failed:" . mysqli_error());
				$user_id = mysqli_insert_id($link);
				$_SESSION['msg'] = "New report has been added.";
				$_SESSION['temptab'] = "managetemps";

				 
 

 
 



				header("Location: manage_report.php");
				exit();

				


			} // NO ERROR
				ELSE {
				$_SESSION['errors'] = $err;
				$_SESSION['temptab'] = "addnewtemp";
				$_SESSION['post'] = $_POST;
				header("Location: manage_report.php");
				exit();
			}
		} // Submitted	
		
	}
?>
