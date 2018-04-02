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

	if(isset($_POST) && array_key_exists('search',$_POST)){
			if(preg_match("/^[a-zA-Z0-9]+$/", $_POST['squery'])){ 
				$squery=$_POST['squery'];
				
				$sql="SELECT ID FROM ".DB_PREFIX."templates WHERE (temp_name LIKE '%" . $squery ."%') "; 
				$result=mysqli_query($link, $sql); 
				
				$ID_list = mysqli_num_rows($result);
				IF($ID_list < 0):
					$s_err[] = "No record found!";
				ELSE:
					$results = array();
					while($row=mysqli_fetch_array($result)){ 
						$s_result = "Search Result for <b>".$squery."</b>";
						$results[]  = $row['ID'];
					}
				ENDIF;
			}else{ 
				$s_err[] = "Please enter a search query"; 
			}
		} 

	//unpublish finished events
// $currenttemp = mysqli_query($link, "SELECT * FROM ".DB_PREFIX."templates where end_date < CURDATE()");
// $templates_one = mysqli_fetch_array($currenttemp);
// mysqli_query($link, "UPDATE ".DB_PREFIX."templates SET temp_status=0 WHERE end_date < CURDATE()")or die(mysqli_error());
	
//unit list
$x = '';
$as = mysqli_query($link, "SELECT unit FROM ".DB_PREFIX."templates");
	while ($a = mysqli_fetch_array($as)){
			$x .=  implode(", ", $a);
			$x .= ", ";
	}

	// PAGINATION
		$page = 0;
		foreach($_GET as $key => $value) { $data[$key] = filter($value); } // Filter Get data
		
		IF(!empty($results) || !empty($data['arange'])): 
			$rpp = 100; // search result per page
								 
							ELSE:
								 $rpp = 20; // normal results per page
							ENDIF;

		$adjacents = 4;
		
		IF(isset($data["page"])):
			$page = intval($data["page"]);
			if($page<=0) $page = 1;
		ENDIF;

		$reload = $_SERVER['PHP_SELF'];
	
		IF(isset($data['arange']) && ($data['arange'] == "Name_Ascending" || $data['arange'] == "Name_Descending")): unset($_SESSION['isortting']); $sorts = $_SESSION['nsortting'];
		ELSEIF(isset($data['arange']) && ($data['arange'] == "ID_Ascending" || $data['arange'] == "ID_Descending")): unset($_SESSION['nsortting']); $sorts = $_SESSION['isortting']; 
		ELSEIF(isset($data['arange']) && ($data['arange'] == "T_Ascending" || $data['arange'] == "T_Descending")): unset($_SESSION['isortting']); $sorts = $_SESSION['tsortting'];ENDIF;
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
								<h2>Monitor Submissions</h2>
							</header>
 

							<?php
							 IF(empty($sorts)): $sorts = ""; ENDIF;
							 IF(!empty($results)): 
								$ids = join(",",$results);
								$current_temp = mysqli_query($link, "SELECT DATEDIFF(b.end_date,curdate()) AS days, (CASE WHEN a.user_ID IN (select user_id from reports where temp_ID IN (b.id)) THEN '1' ELSE '2' END ) as sub ,a.user_ID, b.temp_name, a.unit, b.id,b.end_date FROM ".DB_PREFIX."system_users as a, (select * from templates) as b WHERE a.unit in (".$x."0)  AND  b.ID in (".$ids.") ".$sorts."");
							ELSE:
								$current_temp = mysqli_query($link, "SELECT DATEDIFF(b.end_date,curdate()) AS days, (CASE WHEN a.user_ID IN (select user_id from reports where temp_ID IN (b.id)) THEN '1' ELSE '2' END ) as sub ,a.user_ID, b.temp_name, a.unit, b.id,b.end_date FROM ".DB_PREFIX."system_users as a, (select * from templates) as b WHERE a.unit in (".$x."0) ".$sorts."");

							ENDIF; 

							// $current_temp = mysqli_query($link, "SELECT DATEDIFF(b.end_date,curdate()) AS days, (CASE WHEN a.user_ID IN (select user_id from reports where temp_ID IN (b.id)) THEN '1' ELSE '2' END ) as sub ,a.user_ID, b.temp_name, a.unit, b.id,b.end_date FROM ".DB_PREFIX."system_users as a, (select * from templates) as b WHERE a.unit in (".$x."0) order by sub");

								IF(!empty($s_err)) {
						?>
						<h3><?php if(!empty($s_err)) { echo "<div class=\"msg\">"; foreach ($s_err as $e) { echo "$e <br>"; } echo "</div>"; }  // Display error message  ?></h3>
						<a href="monitor.php"><span  ">Return</span></a> 
						<?php 
							}ELSE{
// 								 


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
						<form name="searchform" action="monitor.php" method="post">
							<table style="text-align:left;">
								<tbody>
									<tr>
										<td style="text-align:right">
											<input type="text" name="squery" id="squery" placeholder="Search by Template Name">
										</td>
										<td style="text-align:left"><input class="special" name="search" type="submit" value="Search" /></td>
									</tr>
								</tbody>
							</table>				
						</form> 
										<table style="text-align:left;">
										<thead>
											<tr>
												<th>Submitted
												<nav id="lname_sort_view">
													<a id="asort" href="monitor.php?arange=Name_Ascending">&#x25B2;</a> 
													<a id="dsort" href="monitor.php?arange=Name_Descending">&#x25BC;</a>
												</nav>
												</th>
												<th>Template Name
												<nav id="T_sort_view">
													<a id="Tasort" href="monitor.php?arange=T_Ascending">&#x25B2;</a> 
													<a id="Tdsort" href="monitor.php?arange=T_Descending">&#x25BC;</a>
												</nav></th>
												<th>Unit
													<nav id="ID_sort_view">
													<a id="Iasort" href="monitor.php?arange=ID_Ascending">&#x25B2;</a> 
													<a id="Idsort" href="monitor.php?arange=ID_Descending">&#x25BC;</a>
												</nav></th>
												<th>Deadline</th>
												<th>Days Remaining</th>
												<th>Actions</th>
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
											// echo DATEDIFF($templates['end_date'], CURDATE());
											$end = strtotime( $templates['end_date'] ); $en = date( 'Y-m-d H:i:s', $end );  
											$endD = date("M d Y H:i A", strtotime($en));
											 
									
											$idz = mysqli_query($link, "SELECT * FROM ".DB_PREFIX."reports WHERE user_id = $templates[user_ID]");
											$id = mysqli_fetch_array($idz);

											if($id['temp_ID'] != null){
												$l = $id['temp_ID'];
											}
											else{$l = '0';}
											$tempz = mysqli_query($link, "SELECT * FROM ".DB_PREFIX."templates WHERE ID = ".$l);
											$temp = mysqli_fetch_array($tempz);
											$unitz = mysqli_query($link, "SELECT * FROM ".DB_PREFIX."colleges_category WHERE ID = $templates[unit]");
											$unit = mysqli_fetch_array($unitz);
											?>
											<tr>
											 	<td style="text-align:center;">
													<?php IF($templates['sub'] == 1): echo "<span style='color:#00FF00;'>Yes</span>"; ELSE: echo "<span style='color:#FF0000;'>No</span>"; ENDIF; ?></span>
												</td>    
										 
												<td><?php echo $templates['temp_name']; ?></td>
												<td><?php echo $unit['name']; ?></td>
												 
												<td><?php echo $endD; ?></td>
												<td><?php echo $templates['days']; ?></td>
											 
												<td>
													<nav>
														<a href="edit_temp.php?activityID=<?php echo $templates['ID']; ?>"><span style="color:#00FF00;">Notify</span></a> |
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
									
								  

										  

				<!-- Footer -->
					<?php }include("includes/footer"); ?>
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
}
//NAME SORT
				$('#lname_sort_view a').click(function(e) {
					var type = $(this).attr('id');
					var view = (type === 'asort') ? 'ORDER BY SUB ASC' : 'ORDER BY SUB DESC';
					$.post('library/fx.behaviour.php', { slname_display: view });
				});
				
				//ID SORT
				$('#ID_sort_view a').click(function(e) {
					var type = $(this).attr('id');
					var view = (type === 'Iasort') ? 'ORDER BY a.unit ASC' : 'ORDER BY a.unit DESC';
					$.post('library/fx.behaviour.php', { sID_display: view });
				});

				//TSORT
				$('#T_sort_view a').click(function(e) {
					var type = $(this).attr('id');
					var view = (type === 'Tasort') ? 'ORDER BYb.temp_name ASC' : 'ORDER BY b.temp_name DESC';
					$.post('library/fx.behaviour.php', { sT_display: view });
				});
				</script>

	</body>
</html>
