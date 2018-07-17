<?php
include '../../common_lib/createLink_db.php';
session_start();

if(!empty($_POST['start'])){
    $start = $_POST['start'];
}else{
    $start = "";
}
if(!empty($_POST['back'])){
    $back = $_POST['back'];
}else{
    $back = "";
}
if(!empty($_POST['start_flight_ap_num'])){
    $start_flight_ap_num = $_POST['start_flight_ap_num'];
}else{
    $start_flight_ap_num = "";
}
if(!empty($_POST['fly_start_date'])){
    $fly_start_date = $_POST['fly_start_date'];
}else{
    $fly_start_date = "";
}
if(!empty($_POST['fly_start_time'])){
    $fly_start_time = $_POST['fly_start_time'];
}else{
    $fly_start_time = "";
}
if(!empty($_POST['fly_back_time'])){
    $fly_back_time = $_POST['fly_back_time'];
}else{
    $fly_back_time = "";
}
if(!empty($_POST['fly_time'])){
    $fly_time = $_POST['fly_time'];
}else{
    $fly_time = "";
}
if(!empty($_POST['flight_price'])){
    $flight_price = $_POST['flight_price'];
}else{
    $flight_price = "";
}


$sql="update flight_one_way set flight_start='$start',";
$sql .="flight_back='$back', fly_start_date='$fly_start_date',fly_start_time='$fly_start_time',";
$sql .="fly_back_time='$fly_back_time', fly_time='$fly_time',flight_price='$flight_price' where flght_ap_num='$start_flight_ap_num' ";

/* $sql= "update flight_one_way set (flight_start, flight_back, fly_start_date, fly_start_time, fly_back_time, fly_time, flight_price) values ('$start', '$back', '$fly_start_date', '$fly_start_time', '$fly_back_time', '$fly_time','$flight_price') where flght_ap_num = '$start_flight_ap_num' "; */

mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));


echo "<script>
        alert('항공권 정보가 변경되었습니다.')
        </script>";

echo"<script>location.href='admin_flight_list.php';</script>";

?>