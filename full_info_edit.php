<?php 
	include 'settings/connect.php';
	if(session_id() == '') { page_protect(); } // START SESSIONS
	
	$err = array();
		if(isset($_POST) && array_key_exists('Update',$_POST)){
			foreach($_POST as $key => $value) {
				$data[$key] = filter($value);
			}
			
			$studentID = $data['student_ID'];
			$recordID = $data['record_ID'];
			
			//Get DOB
			if ($data['mdob'] < 10) { $monthdata = '0'.$data['mdob']; }else{ $monthdata = $data['mdob']; }
			$dob = ($data['ydob'].'-'.$monthdata.'-'.$data['ddob']);
				
			// Validate all required Fields
	
			if (!isEmail($data['email'])) { $err[] = "ERROR - Invalid email address."; } // Validate Email
			
			//Validate Email
			$useremail = $data['email'];
			$emailduplicate = mysqli_query($link, "SELECT count(*) AS total FROM ".DB_PREFIX."system_users WHERE email='$useremail' AND user_ID!='".$recordID."'") or die(mysqli_error());
			list($total) = mysqli_fetch_row($emailduplicate);
					
			if ($total > 0){
				$err[] = "ERROR - Email already exists. Please try again with different email.";
			}
			
			IF(Student()){
			
				if($data['question'] == "null") {$err[] = "ERROR - Please select security question";}
				if(empty($data['answer']) || strlen($data['answer']) < 2) { $err[] = "ERROR - Please enter atleast 2 or more characters to your answer";}
			
			}ELSEIF(Admin()){

				if(empty($data['student_ID']) || strlen($data['student_ID']) < 2) { $err[] = "ERROR - Invalid student ID. Please enter atleast 2 or more characters";}
				if(empty($data['fname']) || strlen($data['fname']) < 2) { $err[] = "ERROR - Invalid first name. Please enter atleast 2 or more characters";}
				if(empty($data['mname']) || strlen($data['mname']) < 1) { $err[] = "ERROR - Invalid middle name. Please enter atleast 2 or more characters";}
				if(empty($data['lname']) || strlen($data['lname']) < 2) { $err[] = "ERROR - Invalid last name. Please enter atleast 2 or more characters";}
				if($data['gender'] == "null") {$err[] = "ERROR - Please select gender";}
				if(!isset($data['mdob']) || $data['mdob'] == "") {$err[] = "ERROR - Please select Birth Month";}
				if(!isset($data['ddob']) || $data['ddob'] == "") {$err[] = "ERROR - Please select Birth Date";}
				if(!isset($data['ydob']) || $data['ydob'] == "") {$err[] = "ERROR - Please select Year of Birth";}
				
			
			}

			// Validate Student ID
			$IDduplicate = mysqli_query($link, "SELECT count(*) AS totalID FROM ".DB_PREFIX."system_users WHERE ID_number='$studentID' AND user_ID!='$recordID'") or die(mysqli_error());
			list($totalID) = mysqli_fetch_row($IDduplicate);

			if ($totalID > 0){
				$err[] = "ERROR - Can't update ID, used by another student.";
			}

			
			IF(Admin()):
				// Validate Student Name
				$firstn = $data['fname']; $middlen = $data['mname']; $lastn = $data['lname'];
				$recordduplicate = mysqli_query($link, "SELECT count(*) AS totalrecords FROM ".DB_PREFIX."system_users WHERE first_name='$firstn' AND middle_name='$middlen' AND last_name='$lastn' AND birthdate='$dob' AND user_ID!='$recordID'") or die(mysqli_error());
				list($total_records) = mysqli_fetch_row($recordduplicate);
				
				if ($total_records > 0){
					$err[] = "ERROR - The student already exists.";
				}
			ENDIF;

			//All required form has been validated
			if(empty($err)) {
				
				
				IF(Admin()):
				
					$passwrd = $data['student_ID'];
					$sha1pass = PwdHash($passwrd); // stores sha1 of password

					$sql_insert = "UPDATE ".DB_PREFIX."system_users SET `ID_number`='$studentID', `first_name`='$data[fname]', `middle_name` = '$data[mname]', `last_name` = '$data[lname]', `suffix` = '$data[suffix]', `email` = '$useremail', `scholarship` = '$data[scholarship]', `college` = '$data[college]', `birthdate` = '$dob', `gender` = '$data[gender]', `password` = '$sha1pass' WHERE `user_ID` = $recordID";
					mysqli_query($link, $sql_insert) or die("Update Failed:" . mysqli_error());
					
				ELSEIF(Student()):
				
					$sql_insert = "UPDATE ".DB_PREFIX."system_users SET `email` = '$useremail', `question` = '$data[question]', `answer` = '$data[answer]' WHERE `user_ID` = $recordID";
					mysqli_query($link, $sql_insert) or die("Update Failed:" . mysqli_error());
					
				ENDIF;

				$_SESSION['msg'] = "Record has been updated.";
				unset($_SESSION['oldID']);
				header("Location: full_info_edit.php?refer=".$studentID);
				exit();
			} // No Error
			else{
				$_SESSION['errors'] = $err;
				header("Location: full_info_edit.php?refer=".$_SESSION['oldID']);
				exit();
			}
		} // Submitted
	foreach($_GET as $key => $value) { $data[$key] = filter($value); } // Filter Get data
	$_SESSION['currentSID'] = $data['refer'];
	$studentID = $data['refer'];
	$_SESSION['oldID'] = $data['refer'];
?>
<!DOCTYPE HTML>
<html>
	<head>
		<?php include("includes/headtag"); ?>
	</head>
	<body>

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header" class="alt">
						<h1>Becarios de Santo Tomas</h1>
						<p>The Sole Scholars Organization of the University of Santo Tomas<br />
					</header>

				<!-- Navigations -->
					<nav id="nav">
						<ul>
							<li><a href="index.php">Home</a></li>
							<li><a href="events.php">Events</a></li>
							<?php if(isset($_SESSION['user_id'])): ?> 
							<li><a href="logout.php">Logout</a></li>
							<?php if(Admin()): ?>
							<li><a href="backend/index.php">Administration</a></li>
							<?php endif; endif; ?>
						</ul>
					</nav>

				<!-- Main Body -->
					<div id="main">
						<!-- Student Profile Section -->
						<section id="profile" class="main special">
							<header class="major">
								<h2>Student Profile</h2>
							</header>
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
								<p>
								
									<?php // Display error message 
										if(!empty($_SESSION['messages'])) { 
											echo "<div class=\"msg\">"; 
												echo $_SESSION['messages']; 
											echo "</div>";
											unset($_SESSION['messages']); 
										}  
									
									// Display message 
										if(!empty($_SESSION['msg'])) {
											echo "<div class=\"msg\">"; 
												echo $_SESSION['msg']; 
											echo "</div>"; 
										} 
										unset($_SESSION['msg']);  
									?>
								</p>
								<br />
							<?php
							IF(!isset($_SESSION['user_id'])): // Logged out ?>
								<h3>Please login in order to view your profile</h3>
							<?php include('includes/login.php');
								ELSE:
										$userID = $_SESSION['user_id'];
										$student_profile = mysqli_query($link, "SELECT user_ID, ID_number, first_name, middle_name, last_name, suffix, email, scholarship, college, birthdate, gender, barcode, photo, question, answer FROM ".DB_PREFIX."system_users WHERE `ID_number`='".$studentID."' AND user_level!=2");
										$studentprofile = mysqli_num_rows($student_profile);
										IF($studentprofile <= 0):
											echo "<h3>No Record Found</h3>";
										ELSE:
										$profile = mysqli_fetch_array($student_profile);
										$datestring = $profile['birthdate'];
										$college_ID = $profile['college'];
										$question_ID = $profile['question'];
										$answers = $profile['answer'];
										$college = mysqli_fetch_array(mysqli_query($link, "SELECT name FROM ".DB_PREFIX."colleges_category WHERE `ID`='".$college_ID."'"));
										$question = mysqli_fetch_array(mysqli_query($link, "SELECT question FROM ".DB_PREFIX."security_question WHERE `ID`='".$question_ID."'"));
										
								?>
									<div>
										<div class="6u 12u$(medium)" style="text-align:left;float:left;width: 82%;">
											<h3>Basic Details</h3>
											<dl class="alt">
											<form action="full_info_edit.php" method="post" name="RegForm" id="RegForm" >
												<input type="text" style="display:none" name="record_ID" id="record_ID" value="<?php echo $profile['user_ID']; ?>"/>
												<table>
													<tr>
														<td>ID No.</td>
														<td><input type="text" <?php IF(Student()): echo 'readonly'; ENDIF; ?> name="student_ID" id="student_ID" placeholder="Student ID" style="float:left;width:170px;height:30px" value="<?php echo $profile['ID_number']; ?>"/></td>
													</tr>
													<tr>
														<td>Name</td>
														<td> 
															<input type="text" <?php IF(Student()): echo 'readonly'; ENDIF; ?> name="fname" id="fname" placeholder="First Name" style="float:left;width:178px;height:30px;margin-right:5px;" value="<?php echo $profile['first_name']; ?>"/>
															<input type="text" <?php IF(Student()): echo 'readonly'; ENDIF; ?> name="mname" id="mname" placeholder="Middle Name" style="float:left;width:178px;height:30px;margin-right:5px;" value="<?php echo $profile['middle_name']; ?>"/>
															<input type="text" <?php IF(Student()): echo 'readonly'; ENDIF; ?> name="lname" id="lname" placeholder="Last Name" style="float:left;width:178px;height:30px;margin-right:5px;" value="<?php echo $profile['last_name']; ?>"/>
															<select <?php IF(Student()): echo 'disabled'; ENDIF; ?> name="suffix" id="suffix" style="float:left;width:80px;height:29px" >
																<option value="" <?php IF ($profile['suffix'] == "") : echo "selected"; ENDIF; ?>>ex. Jr.</option>
																<option value="Sr" <?php IF ($profile['suffix'] == "Sr") : echo "selected"; ENDIF; ?>>Sr</option>
																<option value="Jr" <?php IF ($profile['suffix'] == "Jr") : echo "selected"; ENDIF; ?>>Jr</option>
																<option value="III" <?php IF ($profile['suffix'] == "III") : echo "selected"; ENDIF; ?>>III</option>
															</select>
														</td>
													</tr>
													<tr>
														<td>Birthdate</td>
														<td>
															<select <?php IF(Student()): echo 'disabled'; ENDIF; ?> id="mdob" name="mdob" style="width:100px;float:left;margin-right:5px;height:30px">
																<?php
																	$d = date_parse_from_format("Y-m-d", $datestring);
																	$month = $d["month"];
																	$dateObj   = DateTime::createFromFormat('!m', $month);
																	$monthName = $dateObj->format('F');
																?>
																<option value="<?php echo $month; ?>" selected="selected"><?php echo $monthName; ?></option>										
																<?php for( $m=1 ; $m<=12 ; $m++): echo '<option value="'.$m.'">'.date("F", mktime(0, 0, 0, $m, 10)).'</option>'; endfor; ?>
															</select>
															<select <?php IF(Student()): echo 'disabled'; ENDIF; ?> id="ddob" name="ddob" style="width:90px;float:left;margin-right:5px;height:30px">
																<?php
																	$date = DateTime::createFromFormat("Y-m-d", $datestring);
																	$bdate = $date->format("d");
																?>
																<option value="<?php echo $bdate; ?>" selected="selected"><?php echo $bdate; ?></option>
																<?php for( $i=1 ; $i<32 ; $i++): ?> 
																<option value="<?php if ($i < '10'){ echo ('0'.$i); } else { echo $i; } ?>"><?php if ($i < '10'){ echo ('0'.$i); } else { echo $i; } ?></option>
																<?php endfor;?>
															</select>
															<select <?php IF(Student()): echo 'disabled'; ENDIF; ?> id="ydob" name="ydob" style="width:90px;float:left;margin-right:5px;height:30px">
																<?php $year = strtok($datestring, '-'); echo $year; ?>
																<option value="<?php echo $year; ?>" selected="selected"><?php echo $year; ?></option>
																<?php $curYear = date('Y'); $oldYear = $curYear - 75; for( $i=$oldYear ; $i<=$curYear ; $i++): echo '<option value="'.$i.'">'.$i.'</option>'; endfor; ?>
															</select>
														</td>
													</tr>
													<tr>
														<td>Gender</td>
														<td>
															<select <?php IF(Student()): echo 'disabled'; ENDIF; ?> name="gender" id="gender" style="width:100px;float:left;margin-right:5px;height:30px">
																<option value="null">-Gender-</option>
																<option value="1" <?php IF($profile['gender']==1): echo "selected"; ENDIF; ?>>Male</option>
																<option value="0" <?php IF($profile['gender']==0): echo "selected"; ENDIF; ?>>Female</option>
															</select>
														</td>
													</tr>
													<tr>
														<td>Email</td>
														<td><input type="text" name="email" id="email" style="width:300px;float:left;margin-right:5px;height:30px;<?php IF(Student()): echo 'color:#0000BB;'; ENDIF; ?>" value="<?php echo $profile['email']; ?>" placeholder="email" /></td>
													</tr>
													<tr>
														<td>Scholarship</td>
														<td>
															<select <?php IF(Student()): echo 'disabled'; ENDIF; ?> name="scholarship" id="scholarship" style="float:left;margin-right:5px;height:30px">
																<option value="<?php echo $profile['scholarship']; ?>"><?php echo $profile['scholarship']; ?></option>
																<?php
																$scholarship_cat = mysqli_query($link, "SELECT ID, name FROM ".DB_PREFIX."scholarship_category");
																$displayscholarship_cat = mysqli_num_rows($scholarship_cat);
																IF($displayscholarship_cat <= 0):
																	echo "<h3>No Record Found!</h3>";
																ELSE:
																	WHILE($scholarship = mysqli_fetch_array($scholarship_cat)): ?>
																	<option value="<?php echo $scholarship['name']; ?>"><?php echo $scholarship['name']; ?></option>
																	<?php ENDWHILE;
																ENDIF;
																?>
															</select>
														</td>
													</tr>
													<tr>
														<td>College</td>
														<td>
															<select <?php IF(Student()): echo 'disabled'; ENDIF; ?> name="college" id="college" style="float:left;margin-right:5px;height:30px">
																<option value="<?php echo $college_ID; ?>"><?php echo $college['name']; ?></option>
																<?php
																$college_cat = mysqli_query($link, "SELECT ID, name FROM ".DB_PREFIX."colleges_category");
																$display_cat = mysqli_num_rows($college_cat);
																IF($display_cat <= 0):
																	echo "<h3>No Record Found!</h3>";
																ELSE:
																	WHILE($college = mysqli_fetch_array($college_cat)): ?>
																	<option value="<?php echo $college['ID']; ?>"><?php echo $college['name']; ?></option>
																	<?php ENDWHILE;
																ENDIF;
																?>
															</select>
														</td>
													</tr>
													<?php IF(Student()): ?>
														<td>Security Question</td>
														<td>
															<select name="question" id="question" style="float:left;margin-right:5px;height:30px;<?php IF(Student()): echo 'color:#0000BB;'; ENDIF; ?>">
																<option value="<?php echo $question_ID; ?>"><?php echo $question['question']; ?></option>
																<?php
																$question_cat = mysqli_query($link, "SELECT ID, question FROM ".DB_PREFIX."security_question");
																$question_item = mysqli_num_rows($question_cat);
																IF($question_item <= 0):
																	echo "<h3>No Record Found!</h3>";
																ELSE:
																	WHILE($question1 = mysqli_fetch_array($question_cat)): ?>
																	<option value="<?php echo $question1['ID']; ?>"><?php echo $question1['question']; ?></option>
																	<?php ENDWHILE;
																ENDIF;
																?>
															</select>
														</td>
													</tr>
													
													<tr>
														<td>Answer</td>
														<td><input type="text" name="answer" id="answer" placeholder="Answer" style="float:left;width:178px;height:30px;<?php IF(Student()): echo 'color:#0000BB;'; ENDIF; ?>" value="<?php echo $profile['answer']; ?>"/></td>
													</tr><?php ENDIF; ?>
												</table>
												<button type="submit" value="Update" class="special" name="Update" id="Update">Update</button>
											</form>
											<a href="index.php"><button type="button">Back to student list</button></a>
										</div>
										<div class="6u 12u$(medium)" style="text-align:left;float:left;width: 18%;"> 									
											<h3>Photo</h3>
											<?php
												$photo = $profile['photo'];
												$barcode = $profile['barcode'];
												IF ($photo == "") : $photo = "student.jpg"; ELSE: $photo = $profile['user_ID']."/".$photo; ENDIF;
											?>
											<div class="profile_pic" style="background-image: url(images/users/<?php echo $photo; ?>);"></div>
											<nav style="text-align:center;">
												<a href="photo_upload.php">Change/Upload Photo</a>
											</nav>
											<br />
											<?php include 'includes/code_128.php'; ?>
											<div class="barcodepane"><?php echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" height="90" width="190"/>'; ?></div>
											<span style="text-align:center;line-height:0.5em">
												<h2 style="line-height:0.5em"><?php echo $studentID; ?></h2>
												<h6 style="line-height:0em">This barcode is auto generated.</h6>
											</span>
										</div>
									</div>
									<div style="clear:both"></div>
								<?php ENDIF; 
								ENDIF; ?>
						</section>
					</div>

				<!-- Footer -->
					<?php include("includes/footer"); ?>
			</div>
		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>