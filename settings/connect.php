<?php

//CONNECT TO DB
define ("DB_HOST", "localhost"); 	// HOST NAME
define ("DB_USER", "root"); 	// DATABASE USER
define ("DB_PASS",""); 	// DATABASE PASSWORD
define ("DB_NAME","qms");	// DATABASE NAME
define ("DB_PREFIX",""); // DATABASE PREFIX

	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$db_name = DB_NAME;
	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

	date_default_timezone_set("Asia/Manila");
		
	define("COOKIE_TIME_OUT", 10); //specify cookie timeout in days (default is 10 days)
	define('SALT_LENGTH', 9); // salt for password
	
	/* Specify user levels */
	define ("ADMIN_LEVEL", 2);
	define ("STUDENT_LEVEL", 1);
	define ("GUEST_LEVEL", 0);

	// DEFINE INCLUDE DIRECTORY
	define("ROOT",$_SERVER["DOCUMENT_ROOT"]);
	define("PAGE",ROOT."/paging/");
	define("SETTING",ROOT."/settings/");

	/*************** reCAPTCHA KEYS****************/
	$publickey = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"; // get your key at http://www.google.com/recaptcha/whyrecaptcha
	$privatekey = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"; // get your key at http://www.google.com/recaptcha/whyrecaptcha

// BEGIN FUNCTIONS SECTION	
	

	//GET URL function
	function url(){
	  return sprintf(
	    "%s://%s%s",
	    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
	    $_SERVER['HTTP_HOST'],
	    $_SERVER['REQUEST_URI']
	  );
	}
	
	$path = $_SERVER['DOCUMENT_ROOT'];
	
	// Base URL Function
	function baseurl($url) {
	  $result = parse_url($url);
	  return $result['scheme']."://".$result['host'];
	}
	
	$urllink = url();
	define('SERVER_PATH', dirname(url()));
	
	// get url address function
	function getAddress() {
	    $protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
	    return $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}
	

	/**** PAGE PROTECT CODE  ********************************
	This code protects pages to only logged in users. If users have not logged in then it will redirect to login page.
	If you want to add a new page and want to login protect, COPY this from this to END marker.
	Remember this code must be placed on very top of any html or php page.
	********************************************************/

	function page_protect() {
		session_start();
		global $link; 

		/* Secure against Session Hijacking by checking user agent */
		if (isset($_SESSION['HTTP_USER_AGENT'])) {
			if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'])) {
				logout();
				exit;
			}
		}

		// Need to check authentication key - ckey and ctime stored in database before allowing sessions
		/* If session not set, check for cookies set by Remember me */
		if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_name']) ) {
			if(isset($_COOKIE['user_id']) && isset($_COOKIE['user_key'])) {
				
				/* Double check cookie expiry time against stored in database */
				$cookie_user_id  = filter($_COOKIE['user_id']);
				$rs_ctime = mysqli_query($link, "select `ckey`,`ctime` from `".DB_PREFIX."system_users` WHERE `user_ID` ='$cookie_user_id'") or die(mysqli_error());
				list($ckey,$ctime) = mysqli_fetch_row($rs_ctime);
				// coookie expiry
				if( (time() - $ctime) > 60*60*24*COOKIE_TIME_OUT) {
					logout();
				}
				/* Security check with untrusted cookies - dont trust value stored in cookie. 		
				/* Also do authentication check of the `ckey` stored in cookie matches that stored in database during login*/

				if( !empty($ckey) && is_numeric($_COOKIE['user_id']) && isUserID($_COOKIE['user_name']) && $_COOKIE['user_key'] == sha1($ckey)  ) {
					session_regenerate_id(); //against session fixation attacks.
					$_SESSION['user_id'] = $_COOKIE['user_id'];
					$_SESSION['user_name'] = $_COOKIE['user_name'];
					/* query user level from database instead of storing in cookies */	
					list($user_level) = mysqli_fetch_row(mysqli_query($link, "select userlevel from ".DB_PREFIX."system_users where user_ID='$_SESSION[user_id]'"));
					
					$_SESSION['user_level'] = $user_level;
					$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']); 
				}else{
					logout();
				}
			}else{
				header("Location: index.php");
				exit();
			}
		}
	}
	// End page protect function

	// Data filtering function
	function filter($data) {
		global $link;

		$data = trim(htmlentities(strip_tags($data)));
	
		if (get_magic_quotes_gpc()) 
			$data = stripslashes($data);
			$data = mysqli_real_escape_string($link, $data);
			return $data;
	}

	function EncodeURL($url) {
		$new = strtolower(ereg_replace(' ','_',$url));
		return($new);
	}
	
	function DecodeURL($url) {
		$new = ucwords(ereg_replace('_',' ',$url));
		return($new);
	}

	function ChopStr($str, $len){
		if (strlen($str) < $len)
	        return $str;
    		$str = substr($str,0,$len);
    	if ($spc_pos = strrpos($str," "))
            $str = substr($str,0,$spc_pos);
		    return $str . "...";
	}	

	// Email Validation function
	function isEmail($email){ return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE; }
	
	// Username Validation Faunction
	function isUserID($username) { 	if (preg_match('/^[a-z\d_]{5,20}$/i', $username)) { return true; } else { return false;	}  }	
 
	// URL Validation Function
	function isURL($url) {
		if (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) {
			return true;
		}else{
			return false;
		}
	} 

	
	//add http to URL
	function addhttp($url) {
		if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
			$url = "http://" . $url;
		}
		return $url;
	}

	// Password Checker function
	function checkPwd($x,$y) {
		if(empty($x) || empty($y) ) { return false; }
		if (strlen($x) < 8 || strlen($y) < 8) { return false; }
		if (strcmp($x,$y) != 0) {
			return false;
		} 
		return true;
	}

	// Password Generator function
	function GenPwd($length = 7) {
		$password = "";
		$possible = "0123456789bcdfghjkmnpqrstvwxyz"; //no vowels  
		$i = 0;    
		while ($i < $length) {     
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);     
			if (!strstr($password, $char)) { 
				$password .= $char;
				$i++;
    		}
		}
		return $password;
	}

	// Key Generator or use Password Generator as alternative function
	function GenKey($length = 7)
	{
		$password = "";
		$possible = "0123456789abcdefghijkmnopqrstuvwxyz";   
		$i = 0;     
		while ($i < $length)
		{ 
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
			if (!strstr($password, $char))
			{ 
				$password .= $char;
				$i++;
			}
		}
		return $password;
	}

	// Logout Function
	function logout()
	{
		global $link;
		session_start();
		$rdirect = baseurl(url()).$_SESSION['oldURL'];
		if(isset($_SESSION['user_id']) || isset($_COOKIE['user_id']))
		{
			mysqli_query($link, "update `".DB_PREFIX."system_users` SET `ckey`= '', `ctime`= ''  WHERE `user_ID`='$_SESSION[user_id]' OR  `user_ID` = '$_COOKIE[user_id]'") or die(mysqli_error());
		}			

		/************ Delete the sessions****************/
		unset($_SESSION['user_id']);
		unset($_SESSION['user_name']);
		unset($_SESSION['user_level']);
		unset($_SESSION['HTTP_USER_AGENT']);
		session_unset();
		session_destroy();
		
		/* Delete the cookies*******************/
		setcookie("user_id", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
		setcookie("user_name", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
		setcookie("user_key", '', time()-60*60*24*COOKIE_TIME_OUT, "/");

		if(isset($rdirect)){ header('Location: index.php'); }
		else { header('Location: index.php'); }
	}

	// Password and salt generation (password encryption)
	function PwdHash($pwd, $salt = null)
	{
		if ($salt === null)
		{
			$salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
		}
		else
		{
			$salt = substr($salt, 0, SALT_LENGTH);
		}
		return $salt . sha1($pwd . $salt);
	}
	
	// Check User Levels
	function Admin()
	{ // Administrator
		if($_SESSION['user_level'] == ADMIN_LEVEL) { return 1; }else{ return 0 ; }
	}

	function Student()
	{ // student
		if($_SESSION['user_level'] == STUDENT_LEVEL) { return 1; }else{ return 0 ; }
	}
	
	function Guest()
	{ // guest
		if($_SESSION['user_level'] == GUEST_LEVEL) { return 1; }else{ return 0 ; }
	}
	
	

	
// END FUNCTION SECTION	
?>