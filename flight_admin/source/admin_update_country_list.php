<?php
include '../../common_lib/createLink_db.php';
session_start();

if(!empty($_POST['area'])){
    $area = $_POST['area'];
}else{
    $area = "";
}
if(!empty($_POST['city'])){
    $city = $_POST['city'];
}else{
    $city = "";
}
if(!empty($_POST['city2'])){
    $city2 = $_POST['city2'];
}else{
    $city2 = "";
}


$sql="update country set area ='$area', city ='$city' where city='$city2' ";


mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));


echo "<script>
        alert('취항지 정보가 변경되었습니다.')
        </script>";

echo"<script>location.href='admin_country_insert.php';</script>";

?>