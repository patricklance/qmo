<?php 
	include 'settings/connect.php';
	if(session_id() == '') { session_start(); } // START SESSIONS
	 $xunit = $_SESSION['uni'];
		$xunit_type = $_SESSION['unit_type'];
	// select event
	if(isset($_POST) && array_key_exists('selecteventbutton',$_POST)){
		foreach($_POST as $key => $value) {
			$data[$key] = filter($value);
		}
		$get_event_data = mysqli_query($link, "SELECT * FROM ".DB_PREFIX."templates WHERE `ID`='".$data['eventID']."'");
		$event_details = mysqli_fetch_array($get_event_data);
		$_SESSION['selecttempID'] = $event_details['ID'];
		$_SESSION['tempName'] = $event_details['temp_name'];
		$_SESSION['tempType'] = $event_details['unit_type'];
		$_SESSION['tempUnit'] = $event_details['unit'];
		$_SESSION['tempStart'] = $event_details['start_date'];
		$_SESSION['tempEnd'] = $event_details['end_date'];
		//submit date
		$today = getdate();
		IF($today['mon'] < 10) { $smonthdata = '0'.$today['mon']; }else{ $smonthdata = $today['mon']; }
		IF($today['mday'] < 10) { $sday = '0'.$today['mday']; }else{ $sday = $today['mday']; }		 
		$stime = $today['hours'].":".$today['minutes'];
		$starttime = date("G:i", strtotime($stime));							
		$sdate = $today['year']."-".$smonthdata."-".$sday." ".$starttime .":". $today['seconds'];
		$_SESSION['date'] = $sdate;
	}
	 
?>
<!DOCTYPE HTML>
<html>
	<head>
		<?php include('includes/headtag'); ?>
		<script type="text/javascript">
			var popupWindow=null;
			function child_open(){ 
				popupWindow =window.open('attendance_list.php',"_blank","directories=no, status=no, menubar=no, scrollbars=yes, resizable=no");
			}
		</script>
	</head>
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
								<h2>Reports</h2>
							</header>
								<div class="table-wrapper" id="eventlist">
									<form name="select_event" id="select_event" method="post" action="reports.php">
										<div style="float:left;">
											<select name="eventID" id="eventID" style="width:300px;height:2em;margin-right:10px;">
												<option value="null">-Select Template-</option>
												<?php

												$events = mysqli_query($link, "SELECT * FROM ".DB_PREFIX."templates WHERE temp_status=1 && unit_type IN (2, '$xunit_type') && unit LIKE   '%".$xunit."%'    ");
												$events_cat = mysqli_num_rows($events);
												IF($events_cat <= 0):
													echo "<h3>No Record Found!</h3>";
												ELSE:
													WHILE($eventName = mysqli_fetch_array($events)): ?>
													<option value="<?php echo $eventName['ID']; ?>" <?php IF(isset($_SESSION['selecttempID']) && $_SESSION['selecttempID'] == $eventName['ID']): echo "selected"; ENDIF; ?>><?php echo $eventName['temp_name']; ?></option>
													<?php ENDWHILE;
												ENDIF;
												?>
											</select>
										</div>
										<div style="text-align:left;float:left;width:30%;">
											<button type="submit" value="Select Template" style="width:1.75em" class="special" name="selecteventbutton" id="selecteventbutton">Select Template</button>
										</div>
									</form>
								</div>
							<?php							
								IF (isset($_SESSION['selecttempID'])):
							?>
								<div class="table-wrapper" id="eventlist">
									
									<!-- <?php 
										$student_profile_list = mysqli_query($link, "SELECT COUNT(student_ID) AS total_attendee FROM ".DB_PREFIX."event_attendance WHERE `event_ID`='".$_SESSION['selecttempID']."' AND `status`='1'");
										$S_list = mysqli_fetch_array($student_profile_list);
									?>	 -->	
									<br><br>									
									<div class="table-wrapper">
										<table style="text-align:center; ">
											<thead>
												<tr>
													<th>Template Name</th>
													<th>Start Date</th>
													<!-- <th>No. of Attending</th> -->
													<th>End Date</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?php echo $_SESSION['tempName']; ?></td>
													<td><?php echo $_SESSION['tempStart']; ?></td>
													<td><?php echo $_SESSION['tempEnd']; ?></td>
													<!-- <td style="text-align:center;">
														<a href="javascript:void(0)" onclick="javascript:child_open()">
															<button style="width:30px;font-size:small;float:left" type="button"><?php echo $S_list['total_attendee']; ?></button>
														</a>
													</td> -->
													<td>
														<nav>						
															<a href="manage_report.php"><span style="color:#0000FF;">Manage Reports</span></a>  
															<!-- <a href="attendance_list.php" target="_blank"><span style="color:#0000FF;">VIEW REPORT</span></a>  -->
														</nav>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							<?php	
								ELSE:
							?>
							<br /> 
							<br /> 
								<div class="table-wrapper" id="eventlist">
									<h2>  No Template Selected</h2>
								</div>
							<?php
								ENDIF;
							?>
						</section>
					</div>

				<!-- Footer -->
					<?php include("includes/footer"); ?>
			</div>
			<?php include('includes/footertag'); ?>

	</body>
</html>