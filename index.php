<?php 
	include 'settings/connect.php';

	
	if(session_id() == '') { session_start(); } // START SESSIONS
	
	//Unset reset session variable
	unset($_SESSION['resetID']);
	unset($_SESSION['resetuname']);
	
	IF(isset($_SESSION['currentSID'])): unset($_SESSION['currentSID']); ENDIF;
	
	// Delete Permanently (Individual Record)
	if(isset($_POST) && array_key_exists('delete',$_POST)){
		foreach($_POST as $key => $value) {
			$data[$key] = filter($value);
		}

		mysqli_query($link, "INSERT INTO ".DB_PREFIX."deletedsystem_users SELECT * FROM system_users WHERE `user_ID`='".$data['recordid']."'") or die(mysqli_error());
			mysqli_query($link, "DELETE FROM ".DB_PREFIX."system_users WHERE `user_ID`='".$data['recordid']."'") or die(mysqli_error());
			$msg = "Student record has been deleted";
	}
	
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
		
		IF(isset($data['arange']) && ($data['arange'] == "Name_Ascending" || $data['arange'] == "Name_Descending")): unset($_SESSION['isortting']); $sorts = $_SESSION['nsortting'];
		ELSEIF(isset($data['arange']) && ($data['arange'] == "ID_Ascending" || $data['arange'] == "ID_Descending")): unset($_SESSION['nsortting']); $sorts = $_SESSION['isortting']; ENDIF;
		
?>
<!DOCTYPE HTML>
<html>
	<head>
		<?php include("includes/headtag"); ?> <!--nandito mga bootstrap defs and other css-->
	</head>
	<body>

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
				
				 <?php include("includes/header"); ?> <!--NAV BAR -->
				<!-- Main Body -->
					<div id="main" class="row">
						<div id="container">
						<!-- Student Profile Section -->
						<section id="profile" class="main special">
							<header class="major">
								<?php IF(isset($_SESSION['user_id'])): // Logged out ?>
								<h2>Notifications</h2>
								<?php		
								
								ELSE:?>
							<?php		
								ENDIF;
								
								?>
							</header>
								<p>
								<?php // Display message 
									if(!empty($msg)) {
										echo "<div class=\"msg\">"; 
											echo $msg; 
										echo "</div>"; 
									} 
								?>
								</p>
								
							<div class="col-sm-3">
								<?php IF(!isset($_SESSION['user_id'])): // Logged out ?>
								<?php include('includes/login.php'); ?>
								
								<img src ="images/0225 (1).PNG" width = "720" height = "200"/>
								<img src ="images/0225 (2).PNG" width = "720" height = "400"/>
								
							
							

							<?php		ELSE:

							$xunit = $_SESSION['uni'];
						$xunit_type = $_SESSION['unit_type'];
						$notif = "SELECT * FROM ".DB_PREFIX."templates WHERE temp_status=1 && unit_type IN (2, '$xunit_type') && unit LIKE   '%".$xunit."%'   order by start_date desc  ";
						$not = mysqli_query($link,$notif);
						$con=mysqli_num_rows($not);
						

						if($con > 0 ){
						
								
							while ($r=mysqli_fetch_array($not)){
								echo    $r['start_date']. " - Submission posted: ".$r['temp_name']."<br><br>";
								} }

						else {
							echo " No notifications at the moment ";
						
						} ?>
										
								 
	 
								<?php		
									ENDIF;
								?>

							</div>
						
						</div>
						</div>
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
			<script src="assets/js/bootstrap-dropdown.js"></script>
			<script src="assets/js/bootstrap.min.js"></script>
			<script src="assets/js/bootstrap.js"></script>

	</body>
</html>