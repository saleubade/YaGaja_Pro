<?php
session_start();
include_once "../../common_lib/createLink_db.php";

$num=$_GET['num'];
$table=$_GET["table"];


$sql="delete from $table where num=$num";
$result = mysqli_query($con,$sql) or die ("실패원인1 : " . mysqli_error($con));

$sql="delete from gallery_ripple where parent=$num";
$result = mysqli_query($con,$sql) or die ("실패원인2 : " . mysqli_error($con));;

if(!$result){
    echo "오류원인 : ".mysqli_error($con);
}
mysqli_close($con);


echo "<script>
    location.href='gallery_list.php';
  </script>";
?>













