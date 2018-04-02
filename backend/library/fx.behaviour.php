<?php 
session_start(); // if not called already

// STUDENT MANAGEMENT
$_SESSION['addstudenttab'] = ( ! empty($_POST['display']) && in_array($_POST['display'], array('addstudent', 'managestudent'))) ? $_POST['display'] : 'managestudent';

// ATTENDANCE MANAGEMENT
$_SESSION['managestudenttab'] = ( ! empty($_POST['attend_display']) && in_array($_POST['attend_display'], array('addstudent', 'removestudent'))) ? $_POST['attend_display'] : 'removestudent';

// EVENT MANAGEMENT
$_SESSION['temptab'] = ( ! empty($_POST['temp_display']) && in_array($_POST['temp_display'], array('addnewtemp', 'managetemps'))) ? $_POST['temp_display'] : 'managetemps';

// USER MANAGEMENT
$_SESSION['addusertab'] = ( ! empty($_POST['userdisplay']) && in_array($_POST['userdisplay'], array('addusers', 'manageusers'))) ? $_POST['userdisplay'] : 'manageusers';

// INVENTORY MANAGEMENT
$_SESSION['inventorytab'] = ( ! empty($_POST['inventdisplay']) && in_array($_POST['inventdisplay'], array('manageinvent', 'managesale'))) ? $_POST['inventdisplay'] : 'manageinvent';

// ADD 
// RECORD SORT BY NAME
$_SESSION['nsortting'] = ( ! empty($_POST['slname_display']) && in_array($_POST['slname_display'], array('ORDER BY SUB ASC', 'ORDER BY SUB DESC'))) ? $_POST['slname_display'] : 'ORDER BY SUB ASC';

// RECORD SORT BY ID
$_SESSION['isortting'] = ( ! empty($_POST['sID_display']) && in_array($_POST['sID_display'], array("ORDER BY a.unit ASC", "ORDER BY a.unit DESC"))) ? $_POST['sID_display'] : 'ORDER BY a.unit ASC';

// RECORD SORT BY T
$_SESSION['tsortting'] = ( ! empty($_POST['sT_display']) && in_array($_POST['sT_display'], array("ORDER BY b.temp_name ASC", "ORDER BY b.temp_name DESC"))) ? $_POST['sT_display'] : 'ORDER BY b.temp_name ASC';

// REMOVE
// RECORD SORT BY NAME
$_SESSION['tsortting1'] = ( ! empty($_POST['sT_display1']) && in_array($_POST['sT_display1'], array('ORDER BY b.temp_name ASC', 'ORDER BY b.temp_name DESC'))) ? $_POST['T_display1'] : 'ORDER BY b.temp_name ASC';

 
// RECORD SORT BY NAME
$_SESSION['nsortting1'] = ( ! empty($_POST['slname_display1']) && in_array($_POST['slname_display1'], array('ORDER BY SUB ASC', 'ORDER BY SUB DESC'))) ? $_POST['slname_display1'] : 'ORDER BY SUB ASC';

// RECORD SORT BY ID
$_SESSION['isortting1'] = ( ! empty($_POST['sID_display1']) && in_array($_POST['sID_display1'], array("ORDER BY a.unit ASC", "ORDER BY a.unit DESC"))) ? $_POST['sID_display1'] : 'ORDER BY a.unit ASC';
?>