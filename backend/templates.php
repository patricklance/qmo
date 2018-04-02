<?php 
	include '../settings/connect.php';
	if(session_id() == '') { page_protect(); } // START SESSIONS
	if(isset($_SESSION['user_id'])):if(Student()):logout(); endif; endif;
if(isset($_POST) && array_key_exists('delete',$_POST)){
		foreach($_POST as $key => $value) {
			$data[$key] = filter($value);
		}

		mysqli_query($link, "INSERT INTO ".DB_PREFIX."deletedtemplates SELECT * FROM templates WHERE `ID`='".$data['recordid']."'") or die(mysqli_error());
		mysqli_query($link, "DELETE FROM ".DB_PREFIX."templates WHERE `ID`='".$data['recordid']."'") or die(mysqli_error());
		
		$msg = "Event has been deleted and all attendance under it.";
	}
	//unpublish finished events
$currenttemp = mysqli_query($link, "SELECT * FROM ".DB_PREFIX."templates where end_date < CURDATE()");
$templates_one = mysqli_fetch_array($currenttemp);
mysqli_query($link, "UPDATE ".DB_PREFIX."templates SET temp_status=0 WHERE end_date < CURDATE()") or die(mysqli_error());
	
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
		<a href="https://bluemix.net/deploy?repository=https://git.ng.bluemix.net/idsorg/sample-java-cloudant"
    target="_blank"><img src="http://bluemix.net/deploy/button.png" alt="Bluemix button"/></a>

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
				<?php include('includes/header'); ?>

				<!-- Main Body -->
					<div id="main">
						<!-- Events Section -->
						<section id="events" class="main special">
							<header class="major">
								<h2>Templates</h2>
							</header>

							<nav id="tab_view">
								<a id="managetemp" onclick='$("#addtemps").hide();$("#templist").show("slow")' href="javascript:void(0)">Manage Templates</a> <span style="color:#FF0000;font-weight:bold">|</span> 
								<a id="addtemp" onclick='$("#templist").hide();$("#addtemps").show("slow")' href="javascript:void(0)">Add Template</a>
							</nav>

							<?php
							if (empty($_SESSION['errors']))    {
								  $_SESSION['temptab'] = 'managetemps';
							}else{
								$_SESSION['temptab'] = 'addnewtemp';
							}
							// $_SESSION['temptab'] = ( ! empty($_POST['temp_display']) && in_array($_POST['temp_display'], array('addnewtemp', 'managetemps'))) ? $_POST['temp_display'] : 'managetemps';
								// $unit = implode(',', $_POST['ary']);
								$current_temp = mysqli_query($link, "SELECT ID, temp_name, start_date, end_date, unit, unit_type, temp_status FROM ".DB_PREFIX."templates");
								$display_temp = mysqli_num_rows($current_temp);
								
								// count total number of appropriate listings: --- Pagination
								$tcount = mysqli_num_rows($current_temp);
										
								// count number of pages:
								$tpages = ($tcount) ? ceil($tcount/$rpp) : 1; // total pages, last page number
										
								$count = 0;
								$i = ($page-1)*$rpp;

								IF($display_temp <= 0):
									echo "<h3>No templates at the moment</h3>";
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
												<th>Published</th>
												<th>Name</th>
												<th>Start Date</th>
												<th>End Date</th>
												<th>Unit Type</th>
												<th>Unit</th>
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
											$student_profile_list = mysqli_query($link, "SELECT COUNT(student_ID) AS total_attendee FROM ".DB_PREFIX."event_attendance WHERE `event_ID`='".$templates['ID']."'");
											$S_list = mysqli_fetch_array($student_profile_list);
											IF($templates['unit_type']=="1"): $type = "Academic"; ELSEIF($templates['unit_type']=="2"): $type = "All"; ELSE: $type="Non Academic";ENDIF;
											?>
											<tr>
												<td style="text-align:center;">
													<?php IF($templates['temp_status'] == 1): echo "<span style='color:#00FF00;'>Yes</span>"; ELSE: echo "<span style='color:#FF0000;'>No</span>"; ENDIF; ?></span>
												</td>
												<td><?php echo $templates['temp_name']; ?></td>
												<td><?php echo $templates['start_date']; ?></td>
												<td><?php echo $templates['end_date']; ?></td>
												<td><?php echo $type; ?></td>
												<!-- <td><?php echo $templates['unit']; ?></td> -->
											<!-- 	<td><?php echo $templates['q1']; ?></td>
												<td><?php echo $templates['q2']; ?></td>
												<td><?php echo $templates['q3']; ?></td> -->
												<!-- <td style="text-align:center;<?php IF($S_list['total_attendee'] <= 0): echo 'color:#FF0000;'; ELSE: echo 'color:#00FF00;'; ENDIF; ?>"><?php echo $S_list['total_attendee']; ?></td> -->
												<td>
													<nav>
														<a href="edit_temp.php?activityID=<?php echo $templates['ID']; ?>"><span style="color:#00FF00;">EDIT</span></a> |
														<a href="javascript:void(0)" onclick="$('#confirm<?php echo $templates['ID']; ?>').show('slow')"><span style="color:#FF0000;">DELETE</span></a>
													</nav>
													<div id="confirm<?php echo $templates['ID']; ?>" style="display:none;padding:6px;">
														<span style="color:#FF0000;font-weight:bold">Delete this template permanently?</span><br>
														<form name="deleterestore2" id="deleterestore2" action="templates.php" method="post">
															<input type="text" style="display:none" name="recordid" value="<?php echo $templates['ID']; ?>">
															<button style="width:60px;font-size:small;float:left;margin-right:10px" type="submit" class="clean-gray" name="delete" id="delete" value="Delete">
															<span style="color:#FF0000">Yes</span></button>
															<button style="width:60px;font-size:small;float:left" type="button" onclick="$('#confirm<?php echo $templates['ID']; ?>').hide()">No</button>
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
										include("../includes/pagination.php");
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

										<h2>Add New Template</h2>

										<form action="addtemp.php" method="post" name="newEventForm" id="newEventForm" >
											<!-- <h4>Templates Name</h4> -->
											<div class="6u 12u$">
												<input name="tempname" type="text" id="tempname" value="<?php if(isset($_SESSION['post']['tempname'])) { echo $_SESSION['post']['tempname']; }?>" PLACEHOLDER="Template Name" style="margin-right:10px;float:left">
											</div>
											<br />
											<br />
											<br />
											<div class="6u 12u$">
												<h4>Start Date</h4>
												<div style="text-align:left;float:left;color:#003399">
													<select id="smonth" name="smonth" style="width:100px;float:left;margin-right:10px">
														<option value="" selected="selected">Month</option>										
														<?php for( $m=1 ; $m<=12 ; $m++): echo '<option value="'.$m.'">'.date("F", mktime(0, 0, 0, $m, 10)).'</option>'; endfor; ?>
													</select>
													<select id="sdate" name="sdate" style="width:90px;float:left;margin-right:10px">
														<option value="" selected="selected">Date</option>
														<?php for( $i=1 ; $i<32 ; $i++): ?> 
														<option value="<?php if ($i < '10'){ echo ('0'.$i); } else { echo $i; } ?>"><?php if ($i < '10'){ echo ('0'.$i); } else { echo $i; } ?></option>
														<?php endfor;?>
													</select>
													<select id="syear" name="syear" style="width:90px;float:left;margin-right:10px">
														<option value="" selected="selected">Year</option>
														<?php $curYear = date('Y'); $oldYear = $curYear + 10; for( $i=$oldYear ; $i>=$curYear ; $i--): echo '<option value="'.$i.'">'.$i.'</option>'; endfor; ?>
													</select>

													<select id="shour" name="shour" style="width:90px;float:left;margin-right:10px">
														<option value="" selected="selected">Hour</option>
														<?php $etime = 1; for( $i=$etime ; $i<=12; $i++): echo '<option value="'.$i.'">'.$i.'</option>'; endfor; ?>
													</select>

													<select id="sminute" name="sminute" style="width:90px;float:left;margin-right:10px">
														<option value="" selected="selected">Minute</option>
														<?php $emin = 0; for( $i=$emin ; $i<=60 ; $i++): echo '<option value="'.$i.'">'.$i.'</option>'; endfor; ?>
													</select>

													<select id="sAMPM" name="sAMPM" style="width:90px;float:left;margin-right:10px">
														<option value="1" selected="selected">AM</option>
														<option value="2">PM</option>
													</select>
												</div>
												<br />
												<br />
												<br />

												<h4>End Date</h4>
												<div style="text-align:left;float:left;color:#003399">
													<select id="emonth" name="emonth" style="width:100px;float:left;margin-right:10px">
														<option value="" selected="selected">Month</option>										
														<?php for( $m=1 ; $m<=12 ; $m++): echo '<option value="'.$m.'">'.date("F", mktime(0, 0, 0, $m, 10)).'</option>'; endfor; ?>
													</select>
													<select id="edate" name="edate" style="width:90px;float:left;margin-right:10px">
														<option value="" selected="selected">Date</option>
														<?php for( $i=1 ; $i<32 ; $i++): ?> 
														<option value="<?php if ($i < '10'){ echo ('0'.$i); } else { echo $i; } ?>"><?php if ($i < '10'){ echo ('0'.$i); } else { echo $i; } ?></option>
														<?php endfor;?>
													</select>
													<select id="eyear" name="eyear" style="width:90px;float:left;margin-right:10px">
														<option value="" selected="selected">Year</option>
														<?php $curYear = date('Y'); $oldYear = $curYear + 10; for( $i=$oldYear ; $i>=$curYear ; $i--): echo '<option value="'.$i.'">'.$i.'</option>'; endfor; ?>
													</select>

													<select id="ehour" name="ehour" style="width:90px;float:left;margin-right:10px">
														<option value="" selected="selected">Hour</option>
														<?php $etime = 1; for( $i=$etime ; $i<=12; $i++): echo '<option value="'.$i.'">'.$i.'</option>'; endfor; ?>
													</select>

													<select id="eminute" name="eminute" style="width:90px;float:left;margin-right:10px">
														<option value="" selected="selected">Minute</option>
														<?php $emin = 0; for( $i=$emin ; $i<=60 ; $i++): echo '<option value="'.$i.'">'.$i.'</option>'; endfor; ?>
													</select>

													<select id="eAMPM" name="eAMPM" style="width:90px;float:left;margin-right:10px">
														<option value="1" selected="selected">AM</option>
														<option value="2">PM</option>
													</select>
												</div>

											</div>
											<br />
											<br />
											<h4>Unit Type</h4>
											<div class="6u 12u$">
												<select name="unit_type" id="unit_type" style="width:130px">
													<option value="2">All</option>
													<option value="1">Academic</option>
													<option value="0">Non-Academic</option>
												</select>
											</div><br>

									

											<!-- <h4>Unit</h4>
											<div class="6u 12u$">
												<select name="unit[]" multiple="multiple" style="height:200px">
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
											</div> -->

											<h4>Unit</h4>
											<!-- <div class="6u 12u$"> -->
												<DIV class="6u 12u$" style="OVERFLOW-Y:scroll;  HEIGHT:200px">
												
												    <?php
										$college_cat = mysqli_query($link, "SELECT ID, name FROM ".DB_PREFIX."colleges_category");
										$display_cat = mysqli_num_rows($college_cat);
										IF($display_cat <= 0):
											echo "<h3>No Record Found!</h3>";
										ELSE:
											WHILE($college = mysqli_fetch_array($college_cat)): ?>
											<!-- <option value="<?php echo $college['ID']; ?>"><?php echo $college['name']; ?></option> -->
											<input type="checkbox" name="check_list[]" value="<?php echo $college['ID']; ?>"><?php echo $college['name']; ?><br>
											<?php ENDWHILE;
										ENDIF;
										?>
											    </select>
											</div> 
<!-- 
											<input type="checkbox" name="check_list[]" value="value 1">
											<input type="checkbox" name="check_list[]" value="value 2">
											<input type="checkbox" name="check_list[]" value="value 3">
											<input type="checkbox" name="check_list[]" value="value 4">
											<input type="checkbox" name="check_list[]" value="value 5">-->
											<br /> 
											

											<h4>Template Question</h4>
											<div class="6u 12u$" id="question">
												<input type="text" name="q1" id="q1" placeholder="" value="<?php if(isset($_SESSION['post']['q1'])) { echo $_SESSION['post']['q1']; }?>" />
												
												
											</div>
											<br />


											<div class="6u 12u$">
												<input type="button" value="Add Question" onClick="textBoxCreate()"><br>
												<input type="checkbox" id="publish" name="publish" value="1">Publish
												<br>
												<input type="checkbox" id="upload" name="upload" value="1">Attachment
											</div>
											<br />

											<div class="12u$">
												<ul class="actions">

													<li><button type="submit" value="Add Template" class="special" name="addtemp" id="addtemp">Add Template</button></li>
												</ul>
											</div>
										</form>

									</div>
								</div>

						</section>
					</div>

				<!-- Footer -->
					<?php include("includes/footer"); ?>
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
