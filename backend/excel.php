<?php 
include('../settings/connect.php');
if(session_id() == '') { page_protect(); }
if(isset($_SESSION['user_id'])):if(Student()):logout(); endif; endif;

//convert str to time

$start = strtotime( $_SESSION['tempStart'] ); $st = date( 'Y-m-d H:i:s', $start );  
$startD = date("M d Y H:i A", strtotime($st));
 

$end = strtotime( $_SESSION['tempEnd'] ); $en = date( 'Y-m-d H:i:s', $end );  
$endD = date("M d Y H:i A", strtotime($en));

//list reports

$event_list = mysqli_query($link, "SELECT * FROM ".DB_PREFIX."reports WHERE `temp_ID`='".$_SESSION['selecttempID']."' "); 
$count = mysqli_num_rows($event_list);

// add template details

$details = '';
$details .="Report Name:" . "\t" . $_SESSION['tempName'];
$details .="\n";
$details .="Start Date:" . "\t" . $startD;
$details .="\n";
$details .="End Date:" . "\t" . $endD;
$details .="\n";
$details .="Total Submissions:" . "\t" . $count;
$details .="\n";

// query reports

 $sql_insert = "SELECT q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q11,q12,q13,q14,q15 FROM templates WHERE ID = $_SESSION[selecttempID]";
             $query=   mysqli_query($link, $sql_insert)  ;

    $xrec = mysqli_fetch_row($query);
 $xrowData = ''; 

foreach ($xrec as $xvalue) {  
        $xvalue = '"' . $xvalue . '"' . "\t";  
        $xrowData .= $xvalue;  
    }  
    $columnHeader =  "Report ID" . "\t" . "Date Submitted" . "\t";
 $columnHeader.= trim($xrowData) . "\n";  

 

$setSql = "SELECT  ID,date,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q11,q12,q13,q14,q15 FROM `reports` where temp_ID = $_SESSION[selecttempID]";  
$setRec = mysqli_query($link, $setSql);  
  
$setData = '';  

  
while ($rec = mysqli_fetch_row($setRec)) {  
    $rowData = "";   
     
    foreach ($rec as $value) {  
        $value = '"' . $value . '"' . "\t";  
        $rowData .= $value;  
    }  
    $setData .= trim($rowData) . "\n";  
}  
  
  
header("Content-type: application/octet-stream");  
header("Content-Disposition: attachment; filename=$_SESSION[tempName].xls");  
header("Pragma: no-cache");  
header("Expires: 0");  

//print
  
echo $details . "\n" .ucwords($columnHeader) . "\n" . $setData . "\n";  
?>