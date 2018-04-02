<?php 
	include '../settings/connect.php';
	if(session_id() == '') { page_protect(); } // START SESSIONS
?>
<!DOCTYPE HTML>
<html>
	<head>
		<?php include('includes/headtag'); ?>
	</head>
	<body bgcolor="#dedede">
		<!-- Wrapper -->
			<div id="wrapper">
				<br />
				<div id="gendoc">
				<?php 

				$head = mysqli_query($link, "SELECT * FROM ".DB_PREFIX."templates WHERE `ID`='".$_SESSION['selecttempID']."' "); 
				$headr  =mysqli_fetch_array($head);

				$event_list = mysqli_query($link, "SELECT * FROM ".DB_PREFIX."reports WHERE `temp_ID`='".$_SESSION['selecttempID']."' "); 
				$sum_list = mysqli_query($link, "SELECT temp_ID,user_id, count(user_id) as coun FROM ".DB_PREFIX."reports WHERE `temp_ID`='".$_SESSION['selecttempID']."' group by user_id "); 
				$count = mysqli_num_rows($event_list);
				 

				$sql="SELECT name FROM ".DB_PREFIX."colleges_category WHERE `ID` IN (".$_SESSION['tempUnit'].")";
										$res=mysqli_query($link,$sql);
										 $ress = array();
										while($row=mysqli_fetch_array($res)){ 
						 
											$ress[]  = $row['name'];
										}
										$ids = implode("\n",$ress);
										$upd = implode(",",$ress);

										IF($_SESSION['tempType']=="1"): $type = "Academic"; ELSEIF($_SESSION['tempType']=="2"): $type = "All"; ELSE: $type="Non Academic";ENDIF;

				?>
					<div class="table-wrapper" id="studentlist">
						<!-- <h2><?php echo $_SESSION['tempName'];?></h2> -->
						<table style="text-align:left;" class='CSSTableGenerator'>
							<tr> 
								<td>Title</td>
								<td>Unit Type</td>
								<td>Units</td>
								<td>Start Date</td>
								<td>End Date</td>
								<td>No. of Submissions</td>
							</tr>
							<tr>
								<td style="padding: 0 0.75em"><?php echo $_SESSION['tempName'];?></td>
								<td style="padding: 0 0.75em"><?php echo $type; ?></td>
								<td style="padding: 0 0.75em"><?php echo $upd; ?></td>
								<td style="padding: 0 0.75em"><?php $phpdate = strtotime( $_SESSION['tempStart'] ); $eventdate = date( 'Y-m-d H:i:s', $phpdate ); echo date("M d Y H:i A", strtotime($eventdate)); ?></td>
								<td style="padding: 0 0.75em"><?php $phpdate = strtotime( $_SESSION['tempEnd'] ); $eventdates = date( 'Y-m-d H:i:s', $phpdate ); echo date("M d Y H:i A", strtotime($eventdates)); ?></td>
								<td style="padding: 0 0.75em"><?php echo $count; ?></td>
							</tr>
						</table>
						<br />
						<table style="text-align:left;" class='CSSTableGenerator'>
							<tr> 
								<td>Submitted Units</td>
								<td>Submission Count</td>
								
							</tr>
							<?php 
							WHILE($S_list = mysqli_fetch_array($sum_list)){
								$rep = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM ".DB_PREFIX."templates WHERE `ID`='".$S_list['temp_ID']."'"));
											//get profile
											$profile =  mysqli_query($link, "SELECT * FROM ".DB_PREFIX."system_users WHERE user_ID = '$S_list[user_id]'  ");
											$prof  = mysqli_fetch_array($profile);
											//get unit
											$u =  mysqli_query($link, "SELECT * FROM ".DB_PREFIX."colleges_category WHERE ID = '$prof[unit]'  ");
											$un  = mysqli_fetch_array($u);

							?>
							<tr>
								<td style="padding: 0 0.75em"><?php echo $un['name'] ;?></td>
								<td style="padding: 0 0.75em"><?php echo $S_list['coun']; ?></td>
								 <?php } ?>
							</tr>
						</table>
						<br />
						  <table style="text-align:left;" class='CSSTableGenerator'>
							<tr>
								<td>ID</td>
								<td>Unit</td>
								<td>Date Submitted</td>
					 
								<?php IF($headr['q1'] != null){echo "<td>". $headr['q1']. "</td>"  ;} ?>
								<?php IF($headr['q2'] != null){echo "<td>". $headr['q2']. "</td>"  ;} ?> 
								<?php IF($headr['q3'] != null){echo "<td>". $headr['q3']. "</td>"  ;} ?>
								<?php IF($headr['q4'] != null){echo "<td>". $headr['q4']. "</td>"  ;} ?>
								<?php IF($headr['q5'] != null){echo "<td>". $headr['q5']. "</td>"  ;} ?>
								<?php IF($headr['q6'] != null){echo "<td>". $headr['q6']. "</td>"  ;} ?>
								<?php IF($headr['q7'] != null){echo "<td>". $headr['q7']. "</td>"  ;} ?>
								<?php IF($headr['q8'] != null){echo "<td>". $headr['q8']. "</td>"  ;} ?>
								<?php IF($headr['q9'] != null){echo "<td>". $headr['q9']. "</td>"  ;} ?>
								<?php IF($headr['q10'] != null){echo "<td>". $headr['q10']. "</td>"  ;} ?>
								<?php IF($headr['q11'] != null){echo "<td>". $headr['q11']. "</td>"  ;} ?>
								<?php IF($headr['q12'] != null){echo "<td>". $headr['q12']. "</td>"  ;} ?>
								<?php IF($headr['q13'] != null){echo "<td>". $headr['q13']. "</td>"  ;} ?>
								<?php IF($headr['q14'] != null){echo "<td>". $headr['q14']. "</td>"  ;} ?>
								<?php IF($headr['q15'] != null){echo "<td>". $headr['q15']. "</td>"  ;} ?>
								<?php IF($headr['upload'] == 1){echo "<td> Image</td>"  ;} ?>
								 
							</tr>
							<?php 
							WHILE($E_list = mysqli_fetch_array($event_list)){
								$rep = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM ".DB_PREFIX."templates WHERE `ID`='".$E_list['temp_ID']."'"));
											//get profile
											$profile =  mysqli_query($link, "SELECT * FROM ".DB_PREFIX."system_users WHERE user_ID = '$E_list[user_id]'  ");
											$prof  = mysqli_fetch_array($profile);
											//get unit
											$u =  mysqli_query($link, "SELECT * FROM ".DB_PREFIX."colleges_category WHERE ID = '$prof[unit]'  ");
											$un  = mysqli_fetch_array($u);

							?>
							<tr>
								<td style="padding: 0 0.75em"><?php echo $E_list['ID'] ;?></td>
								<td style="padding: 0 0.75em"><?php echo $un['name'] ;?></td>
								<td style="padding: 0 0.75em"><?php $phpdate = strtotime( $E_list['date'] ); $eventdate = date( 'Y-m-d H:i:s', $phpdate ); echo date("M d Y H:i A", strtotime($eventdate)); ?></td>
							<!-- 	<td style="padding: 0 0.75em"><?php echo $E_list['q1'] ;?></td>
								<td style="padding: 0 0.75em"><?php echo $E_list['q2'] ;?></td>
								<td style="padding: 0 0.75em"><?php echo $E_list['q3'] ;?></td>
								<td style="padding: 0 0.75em"><?php echo $E_list['q4'] ;?></td>
								<td style="padding: 0 0.75em"><?php echo $E_list['q5'] ;?></td>
								<td style="padding: 0 0.75em"><?php echo $E_list['q6'] ;?></td>
								<td style="padding: 0 0.75em"><?php echo $E_list['q7'] ;?></td>
								<td style="padding: 0 0.75em"><?php echo $E_list['q8'] ;?></td>
								<td style="padding: 0 0.75em"><?php echo $E_list['q9'] ;?></td>
								<td style="padding: 0 0.75em"><?php echo $E_list['q10'] ;?></td>
								<td style="padding: 0 0.75em"><?php echo $E_list['q11'] ;?></td>
								<td style="padding: 0 0.75em"><?php echo $E_list['q12'] ;?></td>
								<td style="padding: 0 0.75em"><?php echo $E_list['q13'] ;?></td>
								<td style="padding: 0 0.75em"><?php echo $E_list['q14'] ;?></td>
								<td style="padding: 0 0.75em"><?php echo $E_list['q15'] ;?></td> -->

								<?php IF($headr['q1'] != null){echo "<td style='padding: 0 0.75em'>". $E_list['q1']. "</td>"  ;} ?>
								<?php IF($headr['q2'] != null){echo "<td style='padding: 0 0.75em'>". $E_list['q2']. "</td>"  ;} ?> 
								<?php IF($headr['q3'] != null){echo "<td style='padding: 0 0.75em'>". $E_list['q3']. "</td>"  ;} ?>
								<?php IF($headr['q4'] != null){echo "<td style='padding: 0 0.75em'>". $E_list['q4']. "</td>"  ;} ?>
								<?php IF($headr['q5'] != null){echo "<td style='padding: 0 0.75em'>". $E_list['q5']. "</td>"  ;} ?>
								<?php IF($headr['q6'] != null){echo "<td style='padding: 0 0.75em'>". $E_list['q6']. "</td>"  ;} ?>
								<?php IF($headr['q7'] != null){echo "<td style='padding: 0 0.75em'>". $E_list['q7']. "</td>"  ;} ?>
								<?php IF($headr['q8'] != null){echo "<td style='padding: 0 0.75em'>". $E_list['q8']. "</td>"  ;} ?>
								<?php IF($headr['q9'] != null){echo "<td style='padding: 0 0.75em'>". $E_list['q9']. "</td>"  ;} ?>
								<?php IF($headr['q10'] != null){echo "<td style='padding: 0 0.75em'>". $E_list['q10']. "</td>"  ;} ?>
								<?php IF($headr['q11'] != null){echo "<td style='padding: 0 0.75em'>". $E_list['q11']. "</td>"  ;} ?>
								<?php IF($headr['q12'] != null){echo "<td style='padding: 0 0.75em'>". $E_list['q12']. "</td>"  ;} ?>
								<?php IF($headr['q13'] != null){echo "<td style='padding: 0 0.75em'>". $E_list['q13']. "</td>"  ;} ?>
								<?php IF($headr['q14'] != null){echo "<td style='padding: 0 0.75em'>". $E_list['q14']. "</td>"  ;} ?>
								<?php IF($headr['q15'] != null){echo "<td style='padding: 0 0.75em'>". $E_list['q15']. "</td>"  ;} ?>
								<?php IF($headr['upload'] == 1){echo "<td  ><img src='" . $E_list['image'] . "' height='200' width='200' > </td>"  ;} ?>
								<!-- <td><img src='<?php echo $E_list['image']; ?>' > </td> -->


							</tr>
							<?php } ?>
						</table>  
					</div>
					<br />
				</div>

				<nav style="text-align:left;">
					<a href="javascript:void(0)" onclick="javascript:window.print()">Print</a><span style="color:#330022;font-weight:bold">  |  </span>
					<a href="javascript:void(0)" onclick="window.location.href='excel.php'">Generate Excel Report</a>
					 <!-- <input class="special" type="button" value="Backup Database" onclick="window.location.href='dbdownload.php'" />  -->
				</nav>

			</div>
	</body>
</html>
<?php // unset($_SESSION['eventID']); ?>