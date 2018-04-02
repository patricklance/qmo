<?php 
	include '../settings/connect.php';
	if(session_id() == '') { page_protect(); } // START SESSIONS
	if(isset($_SESSION['user_id'])):if(Student()):logout(); endif; endif;
	$err = array();
		if(isset($_POST) && array_key_exists('Update',$_POST)){
			foreach($_POST as $key => $value) {
				$data[$key] = filter($value);
			}
			
			$studentID = $data['student_ID'];
			$recordID = $data['record_ID'];
				
			// Validate all required Fields
	
			if (!isEmail($data['email'])) { $err[] = "ERROR - Invalid email address."; } // Validate Email
			if (!isEmail($data['alt_email'])) { $err[] = "ERROR - Invalid alternate email address."; } 
			//Validate Email
			$useremail = $data['email'];
			$emailduplicate = mysqli_query($link, "SELECT count(*) AS total FROM ".DB_PREFIX."system_users WHERE email='$useremail' AND user_ID!='".$recordID."'") or die(mysqli_error());
			list($total) = mysqli_fetch_row($emailduplicate);
					
			if ($total > 0){
				$err[] = "ERROR - Email already exists. Please try again with different email.";
			}

			// if(empty($data['student_ID']) || strlen($data['student_ID']) < 2) { $err[] = "ERROR - Invalid User ID. Please enter atleast 2 or more characters";}
			if(empty($data['fname']) || strlen($data['fname']) < 2) { $err[] = "ERROR - Invalid first name. Please enter atleast 2 or more characters";}
			if(empty($data['mname']) || strlen($data['mname']) < 1) { $err[] = "ERROR - Invalid middle name. Please enter atleast 2 or more characters";}
			if(empty($data['lname']) || strlen($data['lname']) < 2) { $err[] = "ERROR - Invalid last name. Please enter atleast 2 or more characters";}
			// if(empty($data['email']) ) { $err[] = "ERROR - Invalid email. Please enter atleast 2 or more characters";}
			if(empty($data['position']) ) { $err[] = "ERROR - Invalid position. Please enter atleast 2 or more characters";}
			// if(empty($data['alt_email']) ) { $err[] = "ERROR - Invalid alternate email. Please enter atleast 2 or more characters";}
			if( $data['gender'] == 2 ) { $err[] = "ERROR - Invalid gender. Please select gender";}
			if( $data['unit_type'] == 2 ) { $err[] = "ERROR - Invalid unit type. Please select unit type";}
			// if( $data['unit'] == 2 ) { $err[] = "ERROR - Invalid unit. Please select unit";}
			// if( $data['priv'] == 0 ) { $err[] = "ERROR - Invalid privilege. Please select privilege";}
			

			// Validate Student ID
			// $IDduplicate = mysqli_query($link, "SELECT count(*) AS totalID FROM ".DB_PREFIX."system_users WHERE ID_number='$studentID' AND user_ID!='$recordID'") or die(mysqli_error());
			// list($totalID) = mysqli_fetch_row($IDduplicate);

			// if ($totalID > 0){
			// 	$err[] = "ERROR - Can't update ID, used by another user.";
			// }

			// Validate Student Name
			$firstn = $data['fname']; $middlen = $data['mname']; $lastn = $data['lname'];
			$recordduplicate = mysqli_query($link, "SELECT count(*) AS totalrecords FROM ".DB_PREFIX."system_users WHERE first_name='$firstn' AND middle_name='$middlen' AND last_name='$lastn'  AND user_ID!='$recordID'") or die(mysqli_error());
			list($total_records) = mysqli_fetch_row($recordduplicate);
			
			if ($total_records > 0){
				$err[] = "ERROR - The user already exists.";
			}
			IF(isset($_POST['active'])){ $active = 1; }ELSE{ $active = 0; }
			//All required form has been validated
			if(empty($err)) {

				$sql_insert = "UPDATE ".DB_PREFIX."system_users SET   `first_name`='$data[fname]', `middle_name` = '$data[mname]', `last_name` = '$data[lname]', `suffix` = '$data[suffix]', `email` = '$useremail', `alt_email` = '$data[alt_email]',`unit_type` = '$data[unit_type]',`unit` = '$data[unit]', `position` = '$data[position]',`gender` = '$data[gender]', `approval` = '$active' WHERE `user_ID` = $recordID";
				mysqli_query($link, $sql_insert) or die("Update Failed:" . mysqli_error());

				$_SESSION['msg'] = "Record has been updated.";
				header("Location: user_edit.php?refer=".$_SESSION['oldID']);
				exit();
			} // No Error
			else{
				$_SESSION['errors'] = $err;
				header("Location: user_edit.php?refer=".$_SESSION['oldID']);
				exit();
			}
		} // Submitted
	foreach($_GET as $key => $value) { $data[$key] = filter($value); } // Filter Get data
	$studentID = $data['refer'];
	$_SESSION['oldID'] = $data['refer'];
?>
<!DOCTYPE HTML>
<html>
	<head>
		<?php include('includes/headtag'); ?>
	</head>
	<body>

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
				<?php include('includes/header'); ?>

				<!-- Main Body -->
					<div id="main">
						<!-- Student Profile Section -->
						<section id="profile" class="main special">
							<header class="major">
								<h2>User Profile</h2>
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
									<?php // Display message 
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
										$user_profile = mysqli_query($link, "SELECT user_ID, ID_number, first_name, middle_name, last_name, suffix, username, email,alt_email,unit_type,unit,gender,position,approval FROM ".DB_PREFIX."system_users WHERE `ID_number`='".$studentID."'");
										$userprofile = mysqli_num_rows($user_profile);
										IF($userprofile <= 0):
											echo "<h3>No Record Found</h3>";
										ELSE:
										$profile = mysqli_fetch_array($user_profile);
										$unit_ID = $profile['unit'];
										$college = mysqli_fetch_array(mysqli_query($link, "SELECT name FROM ".DB_PREFIX."colleges_category WHERE `ID`='".$unit_ID."'"));
									
								?>
									<div>
										<div class="6u 12u$(medium)" style="text-align:left;float:left;width: 78%;">
											<h3>Basic Details</h3>
											<dl class="alt">
											<form action="user_edit.php" method="post" name="RegForm" id="RegForm" >
												<input type="text" style="display:none" name="record_ID" id="record_ID" value="<?php echo $profile['user_ID']; ?>"/>
												<table>
													<tr>
														<td>ID No.</td>
														<td><input disabled type="text" name="student_ID" id="student_ID" placeholder="Student ID" style="float:left;width:178px;height:30px" value="<?php echo $profile['ID_number']; ?>"/></td>
													</tr>
													<tr>
														<td>Name</td>
														<td> 
															<input type="text" name="fname" id="fname" placeholder="First Name" style="float:left;width:178px;height:30px;margin-right:5px;" value="<?php echo $profile['first_name']; ?>"/>
															<input type="text" name="mname" id="mname" placeholder="Middle Name" style="float:left;width:178px;height:30px;margin-right:5px;" value="<?php echo $profile['middle_name']; ?>"/>
															<input type="text" name="lname" id="lname" placeholder="Last Name" style="float:left;width:178px;height:30px;margin-right:5px;" value="<?php echo $profile['last_name']; ?>"/>
															<select name="suffix" id="suffix" style="float:left;width:70px;height:29px" >
																<option value="" <?php IF ($profile['suffix'] == "") : echo "selected"; ENDIF; ?>>ex. Jr.</option>
																<option value="Sr." <?php IF ($profile['suffix'] == "Sr") : echo "selected"; ENDIF; ?>>Sr.</option>
																<option value="Jr." <?php IF ($profile['suffix'] == "Jr") : echo "selected"; ENDIF; ?>>Jr.</option>
																<option value="III" <?php IF ($profile['suffix'] == "III") : echo "selected"; ENDIF; ?>>III</option>
															</select>
														</td>
													</tr>
													<tr>
														<td>Gender</td>
														<td>
															<select name="gender" id="gender" style="width:100px;float:left;margin-right:5px;height:30px">
																<option value="null">-Gender-</option>
																<option value="1" <?php IF($profile['gender']==1): echo "selected"; ENDIF; ?>>Male</option>
																<option value="0" <?php IF($profile['gender']==0): echo "selected"; ENDIF; ?>>Female</option>
															</select>
														</td>
													</tr>
													<tr>
														<td>Email</td>
														<td><input type="text" name="email" id="email" style="width:300px;float:left;margin-right:5px;height:30px" value="<?php echo $profile['email']; ?>" placeholder="email" /></td>
													</tr>
													<tr>
														<td>Alternate Email</td>
														<td><input type="text" name="alt_email" id="alt_email" style="width:300px;float:left;margin-right:5px;height:30px" value="<?php echo $profile['alt_email']; ?>" placeholder="alt_email" /></td>
													</tr>
													<tr>
														<td>Unit Type</td>
														<td>
															<select name="unit_type" id="unit_type" style="width:300px;float:left;margin-right:5px;height:30px">
																<option value="null">-Unit Type-</option>
																<option value="1" <?php IF($profile['unit_type']==1): echo "selected"; ENDIF; ?>>Academic</option>
																<option value="0" <?php IF($profile['unit_type']==0): echo "selected"; ENDIF; ?>>Non Academic</option>
															</select>
														</td>
													</tr>
													<!-- <tr>
														<td>Unit</td>
														<td><input type="text" name="unit" id="unit" style="width:300px;float:left;margin-right:5px;height:30px" value="<?php echo $profile['unit']; ?>" placeholder="Unit" /></td>
													</tr> -->
													<tr>
														<td>Unit</td>
														<td>
															<select name="unit" id="unit" style="float:left;margin-right:5px;height:30px">
															<option value="<?php echo $unit_id; ?>"><?php echo $college['name']; ?></option>
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
													<tr>
														<td>Position</td>
														<td><input type="text" name="position" id="position" style="width:300px;float:left;margin-right:5px;height:30px" value="<?php echo $profile['position']; ?>" placeholder="position" />

														<br><br>
															Active <input type="checkbox" align = "left" id="active" name="active" value="1" <?php IF($profile['approval'] == 1): echo "checked"; ENDIF; ?>>

														</td>

													</tr>
													
													
												</table>
												<button type="submit" value="Update" class="special" name="Update" id="Update">Update</button>
											
											<a href="index.php"><button type="button" class="special" name="Back" id="Back">Back</button></a>
										</div>
										
									<div style="clear:both"></div></form>
								<?php ENDIF; 
								ENDIF; ?>
						</section>
					</div>

				<!-- Footer -->
					<footer id="footer">
						<p class="copyright">&copy; QMS : <a href="your link here"></a>.</p>
					</footer>
			</div>
			<?php include('includes/footertag'); ?>

	</body>
</html>