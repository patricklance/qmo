<?php 
	include '../settings/connect.php';
	if(session_id() == '') { page_protect(); } // START SESSIONS


$x = '';
$as = mysqli_query($link, "SELECT unit FROM ".DB_PREFIX."templates");
while ($a = mysqli_fetch_array($as)){

$x .=  implode(", ", $a);
$x .= ", ";

}
echo $x;

$zzz = '1, 2, 3,	';
$currenttemp = mysqli_query($link, "SELECT user_ID FROM ".DB_PREFIX."system_users WHERE unit in (".$x."0)");
 while( $templates_one = mysqli_fetch_array($currenttemp)){


echo '<pre>'; print_r($templates_one); echo '</pre>';}

// while($zz = mysqli_fetch_array($currenttemp)){

// foreach($zz as $woe ){
// echo $woe."<br>";
// }
// 	}


	?>
