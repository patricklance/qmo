<?php 
	include '../settings/connect.php';
	if(session_id() == '') { session_start(); } // START SESSIONS
	if(isset($_SESSION['user_id'])):if(Student()):logout(); endif; endif;
	$err = array();
		IF(isset($_POST) && array_key_exists('EditTemp',$_POST)){
			// foreach($_POST as $key => $value) {
			// 	$_POST[$key] = filter($value);
			// }
			
			$recordID = $_POST['record_ID'];
			
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
			IF(empty($_POST['tempname']) || strlen($_POST['tempname']) < 2) { $err[] = "ERROR - Invalid template name. Please enter atleast 2 or more characters";}
			IF(!isset($_POST['smonth']) || $_POST['smonth'] == "") {$err[] = "ERROR - Please select start month";}
			IF(!isset($_POST['sdate']) || $_POST['sdate'] == "") {$err[] = "ERROR - Please select start date";}
			IF(!isset($_POST['syear']) || $_POST['syear'] == "") {$err[] = "ERROR - Please select start year";}
			IF(!isset($_POST['shour']) || $_POST['shour'] == "") {$err[] = "ERROR - Please select start time";}

			IF(!isset($_POST['emonth']) || $_POST['emonth'] == "") {$err[] = "ERROR - Please select end month";}
			IF(!isset($_POST['edate']) || $_POST['edate'] == "") {$err[] = "ERROR - Please select end date";}
			IF(!isset($_POST['eyear']) || $_POST['eyear'] == "") {$err[] = "ERROR - Please select end year";}
			IF(!isset($_POST['ehour']) || $_POST['ehour'] == "") {$err[] = "ERROR - Please select end time";}
			// IF(!isset($_POST['unit']) || $_POST['unit'] == "") {$err[] = "ERROR - Please select unit";}
			
			// IF(empty($_POST['unit_type']) || strlen($_POST['unit_type']) == "") { $err[] = "ERROR - Please select unit type";}
			IF(isset($_POST['publish'])){ $publish = 1; }ELSE{ $publish = 0; }
			IF(isset($_POST['upload'])){ $upload = 1; }ELSE{ $upload = 0; }
			IF(empty($_POST['q1']) || strlen($_POST['q1']) < 2) { $err[] = "ERROR - Invalid question. Please enter atleast 2 or more characters";}
				
			//All required form has been validated
			IF(empty($err)) {
				//get unit list
				$woe = $_POST['unit'];
				$commaList = implode(', ', $woe);

				$tempv = mysqli_query($link, "SELECT ID, temp_name, start_date, end_date, unit_type,unit, temp_status,upload,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q11,q12,q13,q14,q15	 FROM ".DB_PREFIX."templates WHERE ID='".$_SESSION['tempID']."'" );
				$tempver = mysqli_fetch_array($tempv);


				if(isset($commaList)) 
	{
				 
				$sql_insert2 = "UPDATE ".DB_PREFIX."tempver SET `temp_name` = '".$tempver['temp_name']."', `start_date` = '".$tempver['start_date']."', `end_date` = '".$tempver['end_date']."', `unit` = '".$tempver['unit']."',`unit_type` = '".$tempver['unit_type']."',
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

				$sql_insert = "UPDATE ".DB_PREFIX."templates SET `temp_name` = '".$_POST['tempname']."', `start_date` = '".$sdate."', `end_date` = '".$edate."', `unit` = '".$commaList."',`unit_type` = '".$_POST['unit_type']."',
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
				`q15` = '".$_POST['q15']."',
				`temp_status` = '".$publish."',
				`upload` = '".$upload."'  WHERE `ID` = ".$recordID."";	
				mysqli_query($link, $sql_insert) or die("Insertion Failed:" . mysqli_error());
				$user_id = mysqli_insert_id($link);
			}
			else {
				$sql_insert2 = "UPDATE ".DB_PREFIX."tempver SET `temp_name` = '".$tempver['temp_name']."', `start_date` = '".$tempver['start_date']."', `end_date` = '".$tempver['end_date']."', `unit` = '".$tempver['unit']."',`unit_type` = '".$tempver['unit_type']."',
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

				$sql_insert = "UPDATE ".DB_PREFIX."templates SET `temp_name` = '".$_POST['tempname']."', `start_date` = '".$sdate."', `end_date` = '".$edate."', `unit_type` = '".$_POST['unit_type']."',
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
				`q15` = '".$_POST['q15']."',
				`temp_status` = '".$publish."',
				`upload` = '".$upload."' WHERE `ID` = ".$recordID."";	
				mysqli_query($link, $sql_insert) or die("Insertion Failed:" . mysqli_error());
				$user_id = mysqli_insert_id($link);
			}
				
				$_SESSION['msg'] = "Template has been updated.";
				$_SESSION['temptab'] = "managetemps";
				
				header("Location: templates.php");
				exit();

			} // NOV ERROR
				ELSE {
				$_SESSION['errors'] = $err;
				header("Location: edit_temp.php?activityID=".$_SESSION['tempID']);
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


<script language="javascript">
	var i = 2;
//create text box function

 function textBoxCreate(){
 	 var div1 = document.getElementById('question');
      var div1Paras = div1.getElementsByTagName('input');
      var num = div1Paras.length;
var y = document.createElement("INPUT");
var woe =  document.querySelectorAll('input[type=text]');
var num = woe.length-2;
      num++;
y.setAttribute("type", "text");
y.setAttribute("Placeholder",  "column " + num);
y.setAttribute("Name", "q" + num);
document.getElementById("question").appendChild(y);
i++;

}


// $("div input").length
</script>

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
								<h2>Edit Templates</h2>
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

										 	
											$current_temp = mysqli_query($link, "SELECT ID, temp_name, start_date, end_date, unit_type,unit, temp_status,upload,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q11,q12,q13,q14,q15	 FROM ".DB_PREFIX."templates WHERE ID='".$tempID."'" );
											$display_temps = mysqli_num_rows($current_temp);
											IF($display_temps <= 0):
												echo "<h3>Template does not exist.</h3>";
											ELSE:
												$temps = mysqli_fetch_array($current_temp);

												//convert str to date
												
												$sdatestring = $temps['start_date'];
												list($sdate, $stime) = explode(' ', $sdatestring);
												list($shour, $sminute, $ssec) = explode(':', $stime);
												
												$edatestring = $temps['end_date'];
												list($edate, $etime) = explode(' ', $edatestring);
												list($ehour, $eminute, $esec) = explode(':', $etime);
												
												$user_profile = mysqli_query($link, "SELECT * FROM ".DB_PREFIX."templates WHERE `ID`='".$tempID."'");
										$userprofile = mysqli_num_rows($user_profile);
									 
										$profile = mysqli_fetch_array($user_profile);
										$unit_ID = $profile['ID'];
										$woe = $temps['unit'];

										//get unit name
										 
										$sql="SELECT name FROM ".DB_PREFIX."colleges_category WHERE `ID` IN(".$woe.")";
										$res=mysqli_query($link,$sql);
										 $ress = array();
										while($row=mysqli_fetch_array($res)){ 
						 
											$ress[]  = $row['name'];
										}
										$ids = implode("\n",$ress);
										$upd = implode(",",$ress);

	 
										?>
										
										<div class="6u 12u$(medium)">

											<form action="edit_temp.php" method="post" name="newEventForm" id="EditTempForm" >
												<h4>Template Name </h4>
												<div class="6u 12u$">
													<input type="text" style="display:none" name="record_ID" id="record_ID" value="<?php echo $temps['ID']; ?>"/>
													<input name="tempname" type="text" id="tempname" value="<?php echo $temps['temp_name']; ?>" PLACEHOLDER="Template Name" style="margin-right:10px;float:left">
												</div>
												<br />
												<br />
												<br />

				
												<div class="6u 12u$">
													<h4>Start Date</h4>
													<div style="text-align:left;float:left;color:#003399">
														<select id="smonth" name="smonth" style="width:110px;float:left;margin-right:10px">
															<?php
																$sd = date_parse_from_format("Y-m-d H:s:i", $sdatestring);
																$smonth = $sd["month"];
																$sdateObj   = DateTime::createFromFormat('!m', $smonth);
																$smonthName = $sdateObj->format('F');
															?>
															<option value="<?php echo $smonth; ?>" selected="selected"><?php echo $smonthName; ?></option>										
															<?php for( $m=1 ; $m<=12 ; $m++): echo '<option value="'.$m.'">'.date("F", mktime(0, 0, 0, $m, 10)).'</option>'; endfor; ?>
														</select>
														<select id="sdate" name="sdate" style="width:110px;float:left;margin-right:10px">
															<?php
																$sdate = DateTime::createFromFormat("Y-m-d H:s:i", $sdatestring);
																$scdate = $sdate->format("d");
															?>
															<option value="<?php echo $scdate; ?>" selected="selected"><?php echo $scdate; ?></option>
															<?php for( $i=1 ; $i<32 ; $i++): ?> 
															<option value="<?php if ($i < '10'){ echo ('0'.$i); } else { echo $i; } ?>"><?php if ($i < '10'){ echo ('0'.$i); } else { echo $i; } ?></option>
															<?php endfor;?>
														</select>
														<select id="syear" name="syear" style="width:110px;float:left;margin-right:10px">
															<?php $syear = strtok($sdatestring, '-'); echo $syear; ?>
															<option value="<?php echo $syear; ?>" selected="selected"><?php echo $syear; ?></option>
															<?php $curYear = date('Y'); $oldYear = $curYear + 10; for( $i=$oldYear ; $i>=$curYear ; $i--): echo '<option value="'.$i.'">'.$i.'</option>'; endfor; ?>
														</select>

														<select id="shour" name="shour" style="width:110px;float:left;margin-right:10px">
															<option value="<?php echo $shour; ?>" selected="selected"><?php echo $shour; ?></option>
															<?php $etime = 1; for( $i=$etime ; $i<=12; $i++): echo '<option value="'.$i.'">'.$i.'</option>'; endfor; ?>
														</select>

														<select id="sminute" name="sminute" style="width:110px;float:left;margin-right:10px">
															<option value="<?php echo $sminute; ?>" selected="selected"><?php echo $sminute; ?></option>
															<?php $emin = 0; for( $i=$emin ; $i<=60 ; $i++): echo '<option value="'.$i.'">'.$i.'</option>'; endfor; ?>
														</select>

														<select id="sAMPM" name="sAMPM" style="width:110px;float:left;margin-right:10px">
															
															<option value="1" selected="selected">AM</option>
															<option value="2">PM</option>
														</select>
													</div>
													<br />
													<br />
													<br />

													<h4>End Date</h4>
													<div style="text-align:left;float:left;color:#003399">
														<select id="emonth" name="emonth" style="width:110px;float:left;margin-right:10px">
															<?php
																$ed = date_parse_from_format("Y-m-d H:s:i", $edatestring);
																$emonth = $ed["month"];
																$edateObj   = DateTime::createFromFormat('!m', $emonth);
																$emonthName = $edateObj->format('F');
															?>
															<option value="<?php echo $emonth; ?>" selected="selected"><?php echo $emonthName; ?></option>										
															<?php for( $m=1 ; $m<=12 ; $m++): echo '<option value="'.$m.'">'.date("F", mktime(0, 0, 0, $m, 10)).'</option>'; endfor; ?>
														</select>
														<select id="edate" name="edate" style="width:110px;float:left;margin-right:10px">
															<?php
																$edate = DateTime::createFromFormat("Y-m-d H:s:i", $edatestring);
																$ecdate = $edate->format("d");
															?>
															<option value="<?php echo $ecdate; ?>" selected="selected"><?php echo $ecdate; ?></option>
															<?php for( $i=1 ; $i<32 ; $i++): ?> 
															<option value="<?php if ($i < '10'){ echo ('0'.$i); } else { echo $i; } ?>"><?php if ($i < '10'){ echo ('0'.$i); } else { echo $i; } ?></option>
															<?php endfor;?>
														</select>
														<select id="eyear" name="eyear" style="width:110px;float:left;margin-right:10px">
															<?php $eyear = strtok($edatestring, '-'); echo $eyear; ?>
															<option value="<?php echo $eyear; ?>" selected="selected"><?php echo $eyear; ?></option>
															<?php $curYear = date('Y'); $oldYear = $curYear + 10; for( $i=$oldYear ; $i>=$curYear ; $i--): echo '<option value="'.$i.'">'.$i.'</option>'; endfor; ?>
														</select>

														<select id="ehour" name="ehour" style="width:110px;float:left;margin-right:10px">
															<option value="<?php echo $ehour; ?>" selected="selected"><?php echo $ehour; ?></option>
															<?php $etime = 1; for( $i=$etime ; $i<=12; $i++): echo '<option value="'.$i.'">'.$i.'</option>'; endfor; ?>
														</select>

														<select id="eminute" name="eminute" style="width:110px;float:left;margin-right:10px">
															<option value="<?php echo $eminute; ?>" selected="selected"><?php echo $eminute; ?></option>
															<?php $emin = 0; for( $i=$emin ; $i<=60 ; $i++): echo '<option value="'.$i.'">'.$i.'</option>'; endfor; ?>
														</select>

														<select id="eAMPM" name="eAMPM" style="width:110px;float:left;margin-right:10px">
															<option value="1" selected="selected">AM</option>
															<option value="2">PM</option>
														</select>
													</div>

												</div>
												<br />
												<br />
												<br />

												<h4>Unit Type</h4>
												<div class="6u 12u$">
												<select name="unit_type" id="unit_type" style="width:100px">
													<!-- <option value="">-Unit Type-</option> -->
													<option value="2" <?php IF($temps['unit_type']==2): echo "selected"; ENDIF; ?>>All</option>
													<option value="1" <?php IF($temps['unit_type']==1): echo "selected"; ENDIF; ?>>Academic</option>
													<option value="0" <?php IF($temps['unit_type']==0): echo "selected"; ENDIF; ?>>Non-Academic</option>
												</select>
											</div><br>

											<h4>Unit</h4>
											<!-- <div class="6u 12u$"> -->

												   <h5>Current Units:</h5>
											    <textarea disabled style="float:left;margin-right:5px;height:150px;width:500px"><?php echo $ids  ; ?></textarea>
											    
											<br />
											<br />
											<br />
											<br />	
											<br />	
											<br />	
											<br />	
											<br />	
											    <h5>Edit Units:</h5>
												<div class="6u 12u$" style="OVERFLOW-Y:scroll; HEIGHT:150px; width: 300px">
												
												    <?php
										$college_cat = mysqli_query($link, "SELECT ID, name FROM ".DB_PREFIX."colleges_category");
										$display_cat = mysqli_num_rows($college_cat);
										IF($display_cat <= 0):
											echo "<h3>No Record Found!</h3>";
										ELSE:
											WHILE($college = mysqli_fetch_array($college_cat)): ?>
											<!-- <option value="<?php echo $college['ID']; ?>"><?php echo $college['name']; ?></option> -->
											<input type="checkbox" name="unit[]" value="<?php echo $college['ID']; ?>"><?php echo $college['name']; ?><br>
											<?php ENDWHILE;
										ENDIF;
										?>
											     
											</div> 

											<!-- <h4>Unit</h4>
											<div class="6u 12u$"> -->
											 
											  <!--   <h6>Current Units:</h6>
											    <textarea disabled style="float:left;margin-right:5px;height:100px;width:300px"><?php echo $ids  ; ?></textarea>
											    
											    <br />
											<br />
											<br />
											<br />									   

											    <h6>Edit Units:</h6>
											    <select name="unit[]" multiple="multiple" id="unit" style="float:left;margin-right:5px;height:150px;width:300px">

															<option value="" ; ?></option>
																	<?php
																	//list units
										$college_cat = mysqli_query($link, "SELECT ID, name FROM ".DB_PREFIX."colleges_category");
										$display_cat = mysqli_num_rows($college_cat);
										IF($display_cat <= 0):
											echo "<h3>No Record Found!</h3>";
										ELSE:
											WHILE($college = mysqli_fetch_array($college_cat)): ?>
											<option value="<?php echo $college['ID']; ?>"><?php echo $college['name']; ?></option>
											<?php ENDWHILE;
										ENDIF;
										?></select>
													

											</div> -->
											<br />

												<h4>Template Column</h4>
												<div class="6u 12u$" id="question">
													<input type="text" name="q1" id="q1" value="<?php echo $temps['q1']; ?>" placeholder="column" />
													<!--  hide if null  -->
													<input type="<?php echo (	$temps['q2'] != null) ? 'text' : 'hidden'; ?>" name="q2" id="q2" value="<?php echo $temps['q2']; ?>" placeholder="column"  />
													<input type="<?php echo (	$temps['q3'] != null) ? 'text' : 'hidden'; ?>" name="q3" id="q3" value="<?php echo $temps['q3']; ?>" placeholder="column"  />
													<input type="<?php echo (	$temps['q4'] != null) ? 'text' : 'hidden'; ?>" name="q4" id="q4" value="<?php echo $temps['q4']; ?>" placeholder="column"  />
													<input type="<?php echo (	$temps['q5'] != null) ? 'text' : 'hidden'; ?>" name="q5" id="q5" value="<?php echo $temps['q5']; ?>" placeholder="column"  />
													<input type="<?php echo (	$temps['q6'] != null) ? 'text' : 'hidden'; ?>" name="q6" id="q6" value="<?php echo $temps['q6']; ?>" placeholder="column"  />
													<input type="<?php echo (	$temps['q7'] != null) ? 'text' : 'hidden'; ?>" name="q7" id="q7" value="<?php echo $temps['q7']; ?>" placeholder="column"  />
													<input type="<?php echo (	$temps['q8'] != null) ? 'text' : 'hidden'; ?>" name="q8" id="q8" value="<?php echo $temps['q8']; ?>" placeholder="column"  />
													<input type="<?php echo (	$temps['q9'] != null) ? 'text' : 'hidden'; ?>" name="q9" id="q9" value="<?php echo $temps['q9']; ?>" placeholder="column"  />
													<input type="<?php echo (	$temps['q10'] != null) ? 'text' : 'hidden'; ?>" name="q10" id="q10" value="<?php echo $temps['q10']; ?>" placeholder="column"  />
													<input type="<?php echo (	$temps['q11'] != null) ? 'text' : 'hidden'; ?>" name="q11" id="q11" value="<?php echo $temps['q11']; ?>" placeholder="column"  />
													<input type="<?php echo (	$temps['q12'] != null) ? 'text' : 'hidden'; ?>" name="q12" id="q12" value="<?php echo $temps['q12']; ?>" placeholder="column"  />
													<input type="<?php echo (	$temps['q13'] != null) ? 'text' : 'hidden'; ?>" name="q13" id="q13" value="<?php echo $temps['q13']; ?>" placeholder="column"  />
													<input type="<?php echo (	$temps['q14'] != null) ? 'text' : 'hidden'; ?>" name="q14" id="q14" value="<?php echo $temps['q14']; ?>" placeholder="column"  />
													<input type="<?php echo (	$temps['q15'] != null) ? 'text' : 'hidden'; ?>" name="q15" id="q15" value="<?php echo $temps['q15']; ?>" placeholder="column"  />
												</div>
												<br />
												
												<div class="6u 12u$" >
													<input type="button" value="Add Question" onClick="textBoxCreate()">
													<br>
													<input type="checkbox" id="publish" name="publish" value="1" <?php IF($temps['temp_status'] == 1): echo "checked"; ENDIF; ?>>Publish
													<br>
													<input type="checkbox" id="upload" name="upload" value="1" <?php IF($temps['upload'] == 1): echo "checked"; ENDIF; ?>>Attachment

												</div>
												<br />

												<div class="12u$" 	 >
													<ul class="actions">
														<li><button type="submit" value="Add Template" class="special" name="EditTemp" id="EditTemp">Update Template</button>
															<a href="revert.php"><button type="button" class="special" name="Back" id="Back">Revert</button></a>
															<a href="templates.php"><button type="button" class="special" name="Back" id="Back">Back</button></a>
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

						</section>
					</div>

				
			</div>
				<?php include("includes/footer"); ?>
	</body>
</html>

