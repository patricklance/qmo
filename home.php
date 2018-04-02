<?php 
	include 'settings/connect.php';
	if(session_id() == '') { session_start(); } // START SESSIONS
	$reload = $_SERVER['PHP_SELF'];
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
				
					<?php include("includes/header"); ?>
				
			
				<!-- Navigations -->
					<nav id="nav">
						<ul>
							<?php if(!isset($_SESSION['user_id'])):?> <li><a href="home.php" class="active" >Home</a></li><?php endif; ?>
							<li><a href="index.php" >Login</a></li>
							<?php if(isset($_SESSION['user_id'])): ?> 
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</nav>
				<!-- Main Body -->
					<div id="main">
						<!-- Events Section -->
						<section id="events" class="main special">
							<header class="major">
								<h2>Welcome, Scholar!</h2>
							</header>
							<nav id="tab_view">
								<a id="homepage" onclick='$("#contact").hide();$("#home").show("slow")' href="javascript:void(0)">About Us</a> <span style="color:#FF0000;font-weight:bold">|</span> 
								<a id="contactus" onclick='$("#home").hide();$("#contact").show("slow")' href="javascript:void(0)">Contact Us</a>
								<br><br>
							</nav>
									<div class="table-wrapper" id="home"  style="display:<?php IF($_SESSION['hometab'] == "homepages"): echo "block"; ELSE: echo "none"; ENDIF; ?>">
									 <img src="assets/css/images/logo.png" alt="" height="150px" width="150px"  />
										<h2>Becarios De Santo Tomas</h2>
									
									<h3><b>Becarios de Santo Tomas</b>, The Sole Thomasian Scholars Association, is a university wide, sole scholars organization 
									of the University of Santo Tomas, composed of over 800 members duly recognized 
									by the university, under the guidance of the Office for Student Affairs.

										<br><br>Becarios de Santo Tomas has been bringing pride and honour to the university for 
										20 years, countless years of giving service not only to the scholars but to the whole 
										Thomasian community and more selfless years to give back to our beloved university.</h3>
										
										
										</div>
								
										<div class="table-wrapper" id="contact"  style="display:none">
										<h2>Contact Us</h2>
										<a href="https://www.facebook.com/ustbecarios/" target="_blank"><img src="assets/css/images/fb.png" style="width:50px;height:50px; margin:10px 15px 5px 15px;"></a>
										<a href="http://twitter.com/ustbecarios" target="_blank"><img src="assets/css/images/twitter.png" style="width:50px;height:50px;margin:10px 15px 5px 15px;"></a>
										<br><br>
										<h3> Address: Room 3H, 3rd Floor, Tan Yan Kee Student Center, University of Santo Tomas </h3>
										<hr>
										<h2>Affiliations</h2>
										<h3><a href="http://ust.edu.ph" target="_blank"> University of Santo Tomas </a></h3>
										<h3><a href="http://osa.ust.edu.ph/" target="_blank"> Office for Student Affairs </a></h3>
										</div>
								
						</section>
						</div>
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
			<script type="text/javascript">
				//TAB VIEW
				$('#tab_view a').click(function(e) {
					var type = $(this).attr('id');
					var view = (type === 'homepage') ? 'homepages' : 'contactus';
					$.post('backend/library/fx.behaviour.php', { event_display: view });
				});
			</script>

	</body>
</html>