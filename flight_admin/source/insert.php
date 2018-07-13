<?php
include '../../common_lib/createLink_db.php';    

session_start();

if(!empty($_SESSION['id'])){
    $id = $_SESSION['id'];
}else{
    $id = "?";
}
//--------------------------------------
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
if(!empty($_POST['flight_ap_num'])){
    $apnum = $_POST['flight_ap_num'];
}else{
    $apnum = "";
}
if(!empty($_POST['start_day'])){
    $start_day = $_POST['start_day'];
}else{
    $start_day = "";
}
if(!empty($_POST['fly_start_time'])){
    $start_time = $_POST['fly_start_time'];
}else{
    $start_time = "";
}
if(!empty($_POST['fly_back_time'])){
    $back_time = $_POST['fly_back_time'];
}else{
    $back_time = "";
}
if(!empty($_POST['fly_time'])){
    $time = $_POST['fly_time'];
}else{
    $time = "";
}
if(!empty($_POST['flight_price'])){
    $price = $_POST['flight_price'];
}else{
    $price = "";
}
if(!empty($_POST['recordnum'])){
    $keynum = $_POST['recordnum'];
}else{
    $keynum = "";
}
//----------------------------------------------------
    $sql= "insert into flight_one_way (flight_price, flight_start, flight_back, flght_ap_num, fly_start_date, fly_start_time, fly_back_time, fly_time, recordNum) ";
    $sql.= "values ('$price', '$start', '$back', '$apnum', '$start_day', '$start_time', '$back_time', '$time', '$keynum')";

    mysqli_query($con, $sql) or die(mysqli_error($con));


mysqli_close($con);

echo "<script>alert('항공권이 등록되었습니다.')</script>";
echo "<script> location.href='../../index.php'; </script>";

?>