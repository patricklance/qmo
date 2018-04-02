<?php 
	include 'settings/connect.php';
	if(session_id() == '') { page_protect(); } // START SESSIONS
	// if(isset($_SESSION['user_id'])):if(Student()):logout(); endif; endif;
if(isset($_POST) && array_key_exists('delete',$_POST)){
		foreach($_POST as $key => $value) {
			$data[$key] = filter($value);
		}

		mysqli_query($link, "INSERT INTO ".DB_PREFIX."deletedreports SELECT * FROM reports WHERE `ID`='".$data['recordid']."'") or die(mysqli_error());
		mysqli_query($link, "DELETE FROM ".DB_PREFIX."reports WHERE `ID`='".$data['recordid']."'") or die(mysqli_error());
		
		$msg = "Report has been deleted  .";
	}
	//unpublish finished events
// $currenttemp = mysqli_query($link, "SELECT * FROM ".DB_PREFIX."templates where end_date < CURDATE()");
// $templates_one = mysqli_fetch_array($currenttemp);
// mysqli_query($link, "UPDATE ".DB_PREFIX."templates SET temp_status=0 WHERE end_date < CURDATE()")or die(mysqli_error());
	
	// PAGINATION
		$page = 0;
		foreach($_GET as $key => $value) { $data[$key] = filter($value); } // Filter Get data
		
		$rpp = 20; // results per page
		$adjacents = 4;
		
		IF(isset($data["page"])):
			$page = intval($data["page"]);
			if($page<=0) $page = 1;
		ENDIF;

		$reload = $_SERVER['PHP_SELF'];
	
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
						<!-- Events Section -->
						<section id="events" class="main special">
							<header class="major">
								<!-- <?php

 $sql = "select image from reports where ID = 37";
 $result = mysqli_query($link,$sql);
 $row = mysqli_fetch_array($result);

 $image_src2 = $row['image'];
 
?>
<img src='<?php echo $image_src2; ?>' > -->
								 <h2>Manage Reports</h2>
                                <h3><?php echo $_SESSION['tempName']; ?></h3>
							</header>

							<nav id="tab_view">
								<a id="managetemp" onclick='$("#addtemps").hide();$("#templist").show("slow")' href="javascript:void(0)">Manage Reports</a> <span style="color:#FF0000;font-weight:bold">|</span> 
								<a id="addtemp" onclick='$("#templist").hide();$("#addtemps").show("slow")' href="javascript:void(0)">Add Reports</a>
							</nav>

							<?php
							if (empty($_SESSION['errors']))    {
								  $_SESSION['temptab'] = 'managetemps';
							}else{
								$_SESSION['temptab'] = 'addnewtemp';
							}
							// $_SESSION['temptab'] = ( ! empty($_POST['temp_display']) && in_array($_POST['temp_display'], array('addnewtemp', 'managetemps'))) ? $_POST['temp_display'] : 'managetemps';
								// $unit = implode(',', $_POST['ary']);
								$current_temp = mysqli_query($link, "SELECT * FROM ".DB_PREFIX."reports WHERE temp_ID = '$_SESSION[selecttempID]' && user_id = '$_SESSION[user_id]'");
								$display_temp = mysqli_num_rows($current_temp);
								
								// count total number of appropriate listings: --- Pagination
								$tcount = mysqli_num_rows($current_temp);
										
								// count number of pages:
								$tpages = ($tcount) ? ceil($tcount/$rpp) : 1; // total pages, last page number
										
								$count = 0;
								$i = ($page-1)*$rpp;

								$xcurrent_temp = mysqli_query($link, "SELECT ID, temp_name, start_date, end_date, unit, unit_type, temp_status,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q10,q11,q12,q13,q14,q15,upload FROM ".DB_PREFIX."templates where ID = '$_SESSION[selecttempID]'");
								// $xdisplay_temp = mysqli_num_rows($xcurrent_temp);
								$xtemplates = mysqli_fetch_array($xcurrent_temp);
								IF($display_temp <= 0):
									echo "<h3>No Reports at the moment</h3>";
								ELSE:

							?>
								
								<div class="table-wrapper" id="templist" style="display:<?php IF($_SESSION['temptab'] == "managetemps"): echo "block"; ELSE: echo "none"; ENDIF; ?>">
									
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

									<table style="text-align:left;">
										<thead>
											<tr>
												<th>ID</th>
												<!-- <th><?php echo $xtemplates['q1'] ?></th> -->
												<th>Submission Date</th>
												<th><?php echo $xtemplates['q1'] ?></th>
												<th><?php echo $xtemplates['q2'] ?></th>
												<th><?php echo $xtemplates['q3'] ?></th>
												<th><?php echo $xtemplates['q4'] ?></th>
												<th>Action</th>
												<!-- <th># of Attendee</th> -->
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php 
											
											IF($tcount <= $rpp): $rpp = $tcount; ENDIF;
											WHILE(($count<$rpp) && ($i<$tcount)) {
											mysqli_data_seek($current_temp,$i);
											$templates = mysqli_fetch_array($current_temp);
											// $student_profile_list = mysqli_query($link, "SELECT COUNT(student_ID) AS total_attendee FROM ".DB_PREFIX."event_attendance WHERE `event_ID`='".$templates['ID']."'");
											// $S_list = mysqli_fetch_array($student_profile_list);
											// IF($templates['unit_type']=="1"): $type = "Academic"; ELSE: $type="Non Academic";ENDIF;
											?>
											<tr>
												<!-- <td style="text-align:center;">
													<?php IF($templates['temp_status'] == 1): echo "<span style='color:#00FF00;'>Yes</span>"; ELSE: echo "<span style='color:#FF0000;'>No</span>"; ENDIF; ?></span>
												</td> -->
												<td><?php echo $templates['ID']; ?></td>
												<td><?php echo $templates['date']; ?></td>
												<td><?php echo $templates['q1']; ?></td>
												<td><?php echo $templates['q2']; ?></td>
												<td><?php echo $templates['q3']; ?></td>
												<td><?php echo $templates['q4']; ?></td>
												<!-- <td><?php echo $templates['unit']; ?></td> -->
											<!-- 	<td><?php echo $templates['q1']; ?></td>
												<td><?php echo $templates['q2']; ?></td>
												<td><?php echo $templates['q3']; ?></td> -->
												<!-- <td style="text-align:center;<?php IF($S_list['total_attendee'] <= 0): echo 'color:#FF0000;'; ELSE: echo 'color:#00FF00;'; ENDIF; ?>"><?php echo $S_list['total_attendee']; ?></td> -->

												<td>
													<nav>
														<a href="edit_report.php?activityID=<?php echo $templates['ID']; ?>"><span style="color:#00FF00;">EDIT</span></a> |
														<a href="javascript:void(0)" onclick="$('#confirm<?php echo $templates['ID']; ?>').show('slow')"><span style="color:#FF0000;">DELETE</span></a>
													</nav>
													<div id="confirm<?php echo $templates['ID']; ?>" style="display:none;padding:6px;">
														<span style="color:#FF0000;font-weight:bold">Delete this report permanently?</span><br>
														<form name="deleterestore2" id="deleterestore2" action="manage_report.php" method="post">
															<input type="text" style="display:none" name="recordid" value="<?php echo $templates['ID']; ?>">
															<button style="width:60px;font-size:xx-small;float:left;margin-right:10px" type="submit" class="clean-gray" name="delete" id="delete" value="Delete">
															<span style="color:#FF0000">Yes</span></button>
															<button style="width:60px;font-size:xx-small;float:left" type="button" onclick="$('#confirm<?php echo $templates['ID']; ?>').hide()">No</button>
														</form>
													</div>
												</td>
											</tr>
											<?php 
												$i++;
												$count++;
												} 
											?>
										</tbody>
									</table>
									<?php
										// call pagination function from the appropriate file: pagination1.php, pagination2.php or pagination3.php
										include("includes/pagination.php");
										echo paginate_three($reload, $page, $tpages, $adjacents);
									?>
								</div>
							<?php ENDIF; ?>
	
								<div class="table-wrapper" id="addtemps" style="display:<?php IF($_SESSION['temptab'] == "addnewtemp"): echo "block"; ELSE: echo "none"; ENDIF; ?>">
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
									<br />


										<h2>Add New Report</h2>

										<form action="addreport.php" method="post" name="newEventForm" id="newEventForm" enctype='multipart/form-data'>
											<!-- <h4><?php echo $xtemplates['q1']; ?></h4> -->
											<div class="6u 12u$">
													<input type="<?php echo (	$xtemplates['q1'] != null) ? 'text' : 'hidden'; ?>" name="q1" id="q1" placeholder="<?php echo $xtemplates['q1']; ?>"   />
													<input type="<?php echo (	$xtemplates['q2'] != null) ? 'text' : 'hidden'; ?>" name="q2" id="q2" placeholder="<?php echo $xtemplates['q2']; ?>"   />
													<input type="<?php echo (	$xtemplates['q3'] != null) ? 'text' : 'hidden'; ?>" name="q3" id="q3" placeholder="<?php echo $xtemplates['q3']; ?>"   />
													<input type="<?php echo (	$xtemplates['q4'] != null) ? 'text' : 'hidden'; ?>" name="q4" id="q4" placeholder="<?php echo $xtemplates['q4']; ?>"   />
													<input type="<?php echo (	$xtemplates['q5'] != null) ? 'text' : 'hidden'; ?>" name="q5" id="q5" placeholder="<?php echo $xtemplates['q5']; ?>"   />
													<input type="<?php echo (	$xtemplates['q6'] != null) ? 'text' : 'hidden'; ?>" name="q6" id="q6" placeholder="<?php echo $xtemplates['q6']; ?>"   />
													<input type="<?php echo (	$xtemplates['q7'] != null) ? 'text' : 'hidden'; ?>" name="q7" id="q7" placeholder="<?php echo $xtemplates['q7']; ?>"   />
													<input type="<?php echo (	$xtemplates['q8'] != null) ? 'text' : 'hidden'; ?>" name="q8" id="q8" placeholder="<?php echo $xtemplates['q8']; ?>"   />
													<input type="<?php echo (	$xtemplates['q9'] != null) ? 'text' : 'hidden'; ?>" name="q9" id="q9" placeholder="<?php echo $xtemplates['q9']; ?>"   />
													<input type="<?php echo (	$xtemplates['q10'] != null) ? 'text' : 'hidden'; ?>" name="q10" id="q10" placeholder="<?php echo $xtemplates['q10']; ?>"   />
													<input type="<?php echo (	$xtemplates['q11'] != null) ? 'text' : 'hidden'; ?>" name="q11" id="q11" placeholder="<?php echo $xtemplates['q11']; ?>"   />
													<input type="<?php echo (	$xtemplates['q12'] != null) ? 'text' : 'hidden'; ?>" name="q12" id="q12" placeholder="<?php echo $xtemplates['q12']; ?>"   />
													<input type="<?php echo (	$xtemplates['q13'] != null) ? 'text' : 'hidden'; ?>" name="q13" id="q13" placeholder="<?php echo $xtemplates['q13']; ?>"   />
													<input type="<?php echo (	$xtemplates['q14'] != null) ? 'text' : 'hidden'; ?>" name="q14" id="q14" placeholder="<?php echo $xtemplates['q14']; ?>"   />
													<input type="<?php echo (	$xtemplates['q15'] != null) ? 'text' : 'hidden'; ?>" name="q15" id="q15" placeholder="<?php echo $xtemplates['q15']; ?>"   />
												<?php if($xtemplates['upload'] == 1){ ?>	<input type="file" name="file" id="file"  /><?php }?>
											</div>
											<br />
											<br />

											<div class="12u$">
												<ul class="actions">
													 
													<li><button type="submit" value="Add Report" class="special" name="addtemp" id="addtemp">Add Report</button></li>
												</ul>
											</div>

											
										</form>

									</div>
								</div>
 <div class="12u$" style="text-align:left">
                                    <nav>                       
                                        <a href="reports.php"><span style="color:#FF0000;">Back to report list</span></a>
                                    </nav>
                                </div>
						</section>
					</div>

				<!-- Footer -->
					<?php include("backend/includes/footer"); ?>
			</div>
			<?php include('includes/footertag'); ?>
			<script type="text/javascript">
				//TAB VIEW
				$('#tab_view a').click(function(e) {
					var type = $(this).attr('id');
					var view = (type === 'managetemp') ? 'managetemps' : 'addnewtemp';
					$.post('library/fx.behaviour.php', { temp_display: view });
				});
			</script>
			<script language="javascript">
	var i = 2;
 function textBoxCreate(){
var y = document.createElement("INPUT");
y.setAttribute("type", "text");
y.setAttribute("Placeholder", "q" + i);
y.setAttribute("Name", "q" + i);
y.setAttribute("Value", "");
document.getElementById("question").appendChild(y);
i++;
}</script>

	</body>
</html>
