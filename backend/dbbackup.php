<?php
    include '../settings/connect.php';
    if(session_id() == '') { page_protect(); } // START SESSIONS
    if(isset($_SESSION['user_id'])):if(Student()):logout(); endif; endif;
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
                <?php include('includes/header'); ?>
                
                <!-- Main Body -->
                    <div id="main">
                        <!-- Events Section -->
                        <section id="events" class="main special">
                            <h2>Backup & Restore Database</h2>
                            <form action="upload.php" method="post" enctype="multipart/form-data">
                                <input type="file" name="fileToUpload" />
                                <button type="submit" name="doUpload" onclick="return confirm('Uploading the SQL file will override the existing data. Are you sure you want to continue?')">Upload</button>
                            </form>
                            
                            <?php
                                if(isset($_GET['success']))
                                {
                                    ?>
                                    <label>Database Restored Successfully! </label>
                                    <?php
                                }
                                else if(isset($_GET['fail']))
                                {
                                    ?>
                                    <label>Restoration Failed! Please upload the SQL File.</label>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <label>Upload the SQL File</label>
                                    <?php
                                }
                            ?><br>or<br><br>

                            <input class="special" type="button" value="Backup Database" onclick="window.location.href='dbdownload.php'" /> 

                        </section>
                    </div>
 
                
                
            </div>
            <?php include('includes/footer'); ?>
    </body>
</html>