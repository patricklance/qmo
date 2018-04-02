<?php 
	include '../settings/connect.php';
	if(session_id() == '') { session_start(); } // START SESSIONS
	// if(isset($_SESSION['user_id'])):if(Student()):logout(); endif; endif;
	$err = array();
		IF(isset($_POST) && array_key_exists('EditTemp',$_POST)){
			// foreach($_POST as $key => $value) {
			// 	$_POST[$key] = filter($value);
			// }
			

			// $recordID = $_POST['activityID'];
			 

			// Validate all required Fields
			// IF(empty($_POST['tempname']) || strlen($_POST['tempname']) < 2) { $err[] = "ERROR - Invalid template name. Please enter atleast 2 or more characters";}
			// IF(!isset($_POST['smonth']) || $_POST['smonth'] == "") {$err[] = "ERROR - Please select start month";}
			// IF(!isset($_POST['sdate']) || $_POST['sdate'] == "") {$err[] = "ERROR - Please select start date";}
			// IF(!isset($_POST['syear']) || $_POST['syear'] == "") {$err[] = "ERROR - Please select start year";}
			// IF(!isset($_POST['shour']) || $_POST['shour'] == "") {$err[] = "ERROR - Please select start time";}

			// IF(!isset($_POST['emonth']) || $_POST['emonth'] == "") {$err[] = "ERROR - Please select end month";}
			// IF(!isset($_POST['edate']) || $_POST['edate'] == "") {$err[] = "ERROR - Please select end date";}
			// IF(!isset($_POST['eyear']) || $_POST['eyear'] == "") {$err[] = "ERROR - Please select end year";}
			// IF(!isset($_POST['ehour']) || $_POST['ehour'] == "") {$err[] = "ERROR - Please select end time";}
			// // IF(!isset($_POST['unit']) || $_POST['unit'] == "") {$err[] = "ERROR - Please select unit";}
			
			// // IF(empty($_POST['unit_type']) || strlen($_POST['unit_type']) == "") { $err[] = "ERROR - Please select unit type";}
			// IF(isset($_POST['publish'])){ $publish = 1; }ELSE{ $publish = 0; }
			// IF(empty($_POST['q1']) || strlen($_POST['q1']) < 2) { $err[] = "ERROR - Invalid question. Please enter atleast 2 or more characters";}
				
			//All required form has been validated
			IF(empty($err)) {
				// $woe = $_POST['unit'];
				// $commaList = implode(', ', $woe);
	// 			if(isset($commaList)) 
	// {
				$sql_insert = "UPDATE ".DB_PREFIX."reports SET  
				`q1` = '".$_POST['q1']."',
				`q2` = '".$_POST['q2']."',
				`q3` = '".$_POST['q3']."',
				`q4` = '".$_POST['q4']."', 
				`q5` = '".$_POST['q5']."',
				`q6` = '".$_POST['q6']."',
				`q7` = '".$_POST['q7']."',
				`q8` = '".$_POST['q8']."',
				`q9` = '".$_POST['q9']."',
				`q10` = '".$_POST['q10']."',
				`q11` = '".$_POST['q11']."',
				`q12` = '".$_POST['q12']."',
				`q13` = '".$_POST['q13']."',
				`q14` = '".$_POST['q14']."',
				`q15` = '".$_POST['q15']."' 
				WHERE `ID` = ".$_SESSION['tempID']." ";	
				mysqli_query($link, $sql_insert) or die("Insertion Failed:" . mysqli_error());
				$user_id = mysqli_insert_id($link);
			// }
			// else {
			// 	$sql_insert = "UPDATE ".DB_PREFIX."templates SET `temp_name` = '".$_POST['tempname']."', `start_date` = '".$sdate."', `end_date` = '".$edate."', `unit_type` = '".$_POST['unit_type']."',
			// 	`q1` = '".$_POST['q1']."',
			// 	`q2` = '".$_POST['q2']."',
			// 	`q3` = '".$_POST['q3']."',
			// 	`q4` = '".$_POST['q4']."', 
			// 	`q5` = '".$_POST['q5']."',
			// 	`q6` = '".$_POST['q6']."',
			// 	`q7` = '".$_POST['q7']."',
			// 	`q8` = '".$_POST['q8']."',
			// 	`q9` = '".$_POST['q9']."',
			// 	`q10` = '".$_POST['q10']."',
			// 	`q11` = '".$_POST['q11']."',
			// 	`q12` = '".$_POST['q12']."',
			// 	`q13` = '".$_POST['q13']."',
			// 	`q14` = '".$_POST['q14']."',
			// 	`q15` = '".$_POST['q15']."',`temp_status` = '".$publish."' WHERE `ID` = ".$recordID."";	
			// 	mysqli_query($link, $sql_insert) or die("Insertion Failed:" . mysqli_error());
			// 	$user_id = mysqli_insert_id($link);
			// }
				
				$_SESSION['msg'] = "Submission has been updated.";
				$_SESSION['temptab'] = "managetemps";
				
				header("Location: manage_sub.php");
				exit();

			} // NO ERROR
				ELSE {
				$_SESSION['errors'] = $err;
				header("Location: edit_sub.php?activityID=".$_SESSION['tempID']);
				exit();
			}
		} // Submitted	
	
	foreach($_GET as $key => $value) { $_POST[$key] = filter($value); } // Filter Get data
	$tempID = $_POST['activityID'];
	$_SESSION['tempID'] = $_POST['activityID'];
	
	// $userID = $_SESSION['user_id'];
										
?>
<!DOCTYPE HTML>
<html>
	<head>
		<?php include('includes/headtag'); ?>
	</head>
	<!-- 
		var i = 4;
		function changeIt()
		{
		i++
		question.innerHTML = question.innerHTML +"<input type='text' name='q' placeholder='q'+1"+i+">"
		
		}
	</script>


 -->	
<!-- <script language="javascript">
	var i = 2;

 function textBoxCreate(){
 	 var div1 = document.getElementById('question');
      var div1Paras = div1.getElementsByTagName('input');
      var num = div1Paras.length;
var y = document.createElement("INPUT");
var woe =  document.querySelectorAll('input[type=text]');
var num = woe.length-2;
      num++;
y.setAttribute("type", "text");
y.setAttribute("Placeholder",   num);
y.setAttribute("Name", "q" + num);
document.getElementById("question").appendChild(y);
i++;

}


// $("div input").length
</script> -->

<body>
 
		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
				<?php include('includes/header'); ?>

				<!-- Main Body -->
					<div id="main">
						<!-- Events Section -->
						<section id="events" class="main special">
							<header class="major">
								<h2>Edit Reports</h2>
							</header>
	
								<div class="table-wrapper" id="EditTemps">
									<div class="12u$" style="text-align:left">
									
									<p>
										<?php // Display error message 
											if(!empty($_SESSION['errors'])) { 
												echo "<div class=\"msg\">"; 
													foreach ($_SESSION['errors'] as $e) { 
														echo "$e <br>"; 
													} 
												echo "</div>";
												unset($_SESSION['errors']); 
											}
										?>
									</p>
										<?php 
										 
											$current_temp = mysqli_query($link, "SELECT ID,user_id,temp_id,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q11,q12,q13,q14,q15	 FROM ".DB_PREFIX."reports WHERE ID='".$tempID."'" );
											$display_temps = mysqli_num_rows($current_temp);

											$xcurrent_temp = mysqli_query($link, "SELECT *	 FROM ".DB_PREFIX."templates WHERE ID='".$_SESSION['selecttempID']."'" );
											$xdisplay_temps = mysqli_num_rows($xcurrent_temp);

											IF($display_temps <= 0):
												echo "<h3>Report does not exist.</h3>";
											ELSE:
												$xtemplates = mysqli_fetch_array($current_temp);
												$templates = mysqli_fetch_array($xcurrent_temp);
												 
												
										 
										// $college = mysqli_fetch_array(mysqli_query($link, "SELECT name FROM ".DB_PREFIX."colleges_category WHERE `ID` IN (1,2,3)"));
 
	
										// $woez = $college ;
										// $units = implode(', ', $woez);
										?>
										
										<div class="6u 12u$(medium)" style="text-align:left;float:left;width: 65%;">

											<form action="edit_sub.php" method="post" name="newEventForm" id="EditTempForm" >
												 <?php echo "Report ID: ".$tempID;?>  
												<div class="6u 12u$"><br>
													<h4><?php echo (	$templates['q1'] != null) ? $templates['q1'] : ''; ?></h4>	
													<input type="<?php echo (	$templates['q1'] != null) ? 'text' : 'hidden'; ?>" name="q1" id="q1" value="<?php echo $xtemplates['q1']; ?>" placeholder="unit"  />
													<h4><?php echo (	$templates['q2'] != null) ? $templates['q2'] : ''; ?></h4>
													<input type="<?php echo (	$templates['q2'] != null) ? 'text' : 'hidden'; ?>" name="q2" id="q2" value="<?php echo $xtemplates['q2']; ?>" placeholder="unit"  />
													<h4><?php echo (	$templates['q3'] != null) ? $templates['q3'] : ''; ?></h4>
													<input type="<?php echo (	$templates['q3'] != null) ? 'text' : 'hidden'; ?>" name="q3" id="q3" value="<?php echo $xtemplates['q3']; ?>" placeholder="unit"  />
													<h4><?php echo (	$templates['q4'] != null) ? $templates['q4'] : ''; ?></h4>
													<input type="<?php echo (	$templates['q4'] != null) ? 'text' : 'hidden'; ?>" name="q4" id="q4" value="<?php echo $xtemplates['q4']; ?>" placeholder="unit"  />
													<h4><?php echo (	$templates['q5'] != null) ? $templates['q5'] : ''; ?></h4>
													<input type="<?php echo (	$templates['q5'] != null) ? 'text' : 'hidden'; ?>" name="q5" id="q5" value="<?php echo $xtemplates['q5']; ?>" placeholder="unit"  />
													<h4><?php echo (	$templates['q6'] != null) ? $templates['q6'] : ''; ?></h4>
													<input type="<?php echo (	$templates['q6'] != null) ? 'text' : 'hidden'; ?>" name="q6" id="q6" value="<?php echo $xtemplates['q6']; ?>" placeholder="unit"  />
													<h4><?php echo (	$templates['q7'] != null) ? $templates['q7'] : ''; ?></h4>
													<input type="<?php echo (	$templates['q7'] != null) ? 'text' : 'hidden'; ?>" name="q7" id="q7" value="<?php echo $xtemplates['q7']; ?>" placeholder="unit"  />
													<h4><?php echo (	$templates['q8'] != null) ? $templates['q8'] : ''; ?></h4>
													<input type="<?php echo (	$templates['q8'] != null) ? 'text' : 'hidden'; ?>" name="q8" id="q8" value="<?php echo $xtemplates['q8']; ?>" placeholder="unit"  />
													<h4><?php echo (	$templates['q9'] != null) ? $templates['q9'] : ''; ?></h4>
													<input type="<?php echo (	$templates['q9'] != null) ? 'text' : 'hidden'; ?>" name="q9" id="q9" value="<?php echo $xtemplates['q9']; ?>" placeholder="unit"  />
													<h4><?php echo (	$templates['q10'] != null) ? $templates['q10'] : ''; ?></h4>
													<input type="<?php echo (	$templates['q10'] != null) ? 'text' : 'hidden'; ?>" name="q10" id="q10" value="<?php echo $xtemplates['q10']; ?>" placeholder="unit"  />
													<h4><?php echo (	$templates['q11'] != null) ? $templates['q11'] : ''; ?></h4>
													<input type="<?php echo (	$templates['q11'] != null) ? 'text' : 'hidden'; ?>" name="q11" id="q11" value="<?php echo $xtemplates['q11']; ?>" placeholder="unit"  />
													<h4><?php echo (	$templates['q12'] != null) ? $templates['q12'] : ''; ?></h4>
													<input type="<?php echo (	$templates['q12'] != null) ? 'text' : 'hidden'; ?>" name="q12" id="q12" value="<?php echo $xtemplates['q12']; ?>" placeholder="unit"  />
													<h4><?php echo (	$templates['q13'] != null) ? $templates['q13'] : ''; ?></h4>
													<input type="<?php echo (	$templates['q13'] != null) ? 'text' : 'hidden'; ?>" name="q13" id="q13" value="<?php echo $xtemplates['q13']; ?>" placeholder="unit"  />
													<h4><?php echo (	$templates['q14'] != null) ? $templates['q14'] : ''; ?></h4>
													<input type="<?php echo (	$templates['q14'] != null) ? 'text' : 'hidden'; ?>" name="q14" id="q14" value="<?php echo $xtemplates['q14']; ?>" placeholder="unit"  />
													<h4><?php echo (	$templates['q15'] != null) ? $templates['q15'] : ''; ?></h4>
													<input type="<?php echo (	$templates['q15'] != null) ? 'text' : 'hidden'; ?>" name="q15" id="q15" value="<?php echo $xtemplates['q15']; ?>" placeholder="unit"  />
											</div>

												<div class="12u$" 	 >
													<ul class="actions">
														<li><button type="submit" value="Add Template" class="special" name="EditTemp" id="EditTemp">Update Template</button>
															<a href="manage_sub.php"><button type="button" class="special" name="Back" id="Back">Back</button></a>
														</li>
													</ul>
												</div>
											</form>
										</div>
										<!-- <div class="6u 12u$(medium)" style="text-align:left;float:left;width: 35%;">
										<h3>Event Poster</h3>
											<?php
												$poster = $temps['poster'];
												IF ($poster == "") : $poster = "poster.jpg"; ELSE: $poster = $temps['ID']."/".$poster; ENDIF;
											?>
											<div class="poster_pic" style="background-image: url(../images/events/<?php echo $poster; ?>);"></div>
											<nav style="text-align:center;">
												<a href="poster_upload.php">Change/Upload Poster</a>
											</nav>
										</div> -->
										<?php ENDIF; ?>

									</div>
								</div>
 

				<!-- Footer -->
					<!-- <footer id="footer">
						<p class="copyright">&copy; Attendance, Event and Store Inventory System : <a href="your link here">your link here</a>.</p>
					</footer> -->
			</div>
			<?php include('includes/footertag'); ?>
	</body>
</html>

