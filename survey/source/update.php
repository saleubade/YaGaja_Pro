<?php
   
    $composer = $_GET['composer'];
    
    include_once "../../common_lib/createLink_db.php";
    
   $sql = "update survey set $composer = $composer+1";
   mysqli_query($con, $sql)or die(mysqli_error($con));

   mysqli_close($con);

    Header("location:result.php");
?>

