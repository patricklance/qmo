<?php
	include '../settings/connect.php';
	if(session_id() == '') { page_protect(); } // START SESSIONS
	if(isset($_SESSION['user_id'])):if(Student()):logout(); endif; endif;
		/*$student_ID = $_SESSION['currentSID'];
		$getID = mysqli_fetch_array(mysqli_query($link, "SELECT user_ID, last_name FROM ".DB_PREFIX."system_users WHERE ID_number='".$student_ID."'" ));*/
		 
		 
		
$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
       // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
      //  echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    //echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "ico" && $imageFileType != "jpeg"
&& $imageFileType != "sql" ) {
    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
   ?>
					<script>
					alert('Restore error! Invalid file format');
					window.location.href='dbbackup.php?fail';
					</script>
				<?php
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {


     //   echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
      //  echo "Sorry, there was an error uploading your file.";
    }
    //delete table
    $result = mysqli_query($link, "SHOW TABLES IN `$db_name`"); 
while ($table = mysqli_fetch_array($result)) {
    $tableName = $table[0];
    mysqli_query($link, "TRUNCATE TABLE `$db_name`.`$tableName`");

   // if (mysqli_errno($link)) echo mysqli_errno($link) . ' ' . mysqli_error($link);
  //  else echo "$tableName was cleared<br>";
}
}



//insert tables
$filename = "$target_file";
$handle = fopen($filename,'r+');
$contents = fread($handle,filesize($filename));

$sql = explode(';',$contents);
foreach($sql as $query){
    $result = mysqli_query($link,$query);
}?>
<script>
					alert('Restore Success!');
					window.location.href='dbbackup.php';
					</script> <?

fclose($handle);
//echo "Successfully imported";
exit;

?>


	
	
