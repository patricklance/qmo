<div class = "left-login">
	<form action="loginprocess.php" method="post" name="logForm" id="logForm" >
		<?php // Display error message
			if(!empty($_SESSION['error_msg']))  { echo "<p style=\"color:#FF0000; font-size: 14px; \" id=\"message\">".$_SESSION['error_msg']."</p>"; }
			unset($_SESSION['error_msg']);
		?>

		<h5 class="header-label-panel">
			<div class = "header-label-panel">
			<!--LOGIN-->
			</div>
		</h5>
		<br>
		<br>
			<div class="unamebutton" align="left">
				<div class="6u 12u$" style="margin:0 auto" >
					
					Username<input type="text" name="username" id="username" placeholder="Username" />
				</div>
		</br>

				<div class="6u 12u$" style="margin:0 auto">
					Password<input type="password" name="password" id="password" placeholder="Password"/>
				</div>
			</div>
		
		<!--<div class="right-login-1">-->
			<br>
		<div class="6u 12u$" style="margin:0 auto" align ="center">
			<input type="checkbox" id="remember" name="remember" value="1">Remember me
		</div>

		<br>

		<!--<div class="right-login-2">-->
		<div class="12u$">
			<ul class="actions">
				<!--<li><input type="submit" value="Login" class="special" name="Login" id="Login"/></li>-->
				<input type="submit" value="Login" class="btn btn-warning btn-block btn-sm" name="Login" id="Login"/>
			</ul>
		</div>
		<br>
	</form>
</div>