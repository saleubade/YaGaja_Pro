<?php
session_start();
include "../../common_lib/createLink_db.php";

    
$num=$_GET['num'];

$table=$_GET["table"];


$sql="delete from $table where num=$num";
$result = mysqli_query($con,$sql);
if(!$result){
    echo "오류원인 : ".mysqli_error($con);
}
mysqli_close($con);


echo "<script>
    location.href='exhibit.php';
  </script>";
?>













