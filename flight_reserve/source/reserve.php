<?php
include '../../common_lib/createLink_db.php';
session_start();

if(!empty($_SESSION['id'])){
    $id = $_SESSION['id'];
}else{
    $id = "";
}
if(!empty($_GET['num'])){
    $num = $_GET['num'];
}else{
    $num = "?";
}
if(!empty($_GET['start'])){
    $start = $_GET['start'];
}else{
    $start = "?";
}
if(!empty($_GET['back'])){
    $back = $_GET['back'];
}else{
    $back = "?";
}

if(!empty($_GET['start_check'])){
    $start_check = $_GET['start_check'];
}else{
    $start_check = "?";
}

if(!empty($_GET['back_check'])){
    $back_check = $_GET['back_check'];
}else{
    $back_check = "?";
}

if(!empty($_GET['fly'])){
    $fly = $_GET['fly'];
}else{
    $fly = "";
} 


if(!empty($_GET['sapnum'])){
    $sapnum = $_GET['sapnum'];
}else{
    $sapnum = "";
}

if(!empty($_GET['bapnum'])){
    $bapnum = $_GET['bapnum'];
}else{
    $bapnum = "";
}

if(!empty($_POST['choice_seat'])){
    $choice_seat = $_POST['choice_seat'];
}else{
    $choice_seat = "";
}


foreach($choice_seat as $value) {
 $seat = $seat."/".$value;
}
$result = substr_count($seat, "/");        // "/" 의 개수를 구하는 함수

if($result != $num){   
    echo "<script>alert('인원 수만큼 좌석을 선택해주세요')</script>";
    echo "<script> history.go(-1);</script>";
}else{
    $sql= "insert into seat_state (id, flght_ap_num, choice_seat)";
    $sql.= "values ('$id','$sapnum','$seat')";
    
    mysqli_query($con, $sql) or die(mysqli_error($con));
    
    mysqli_close($con);
    
    echo "<script>alert('좌석 예매되었습니다.')</script>";
    echo "<script> location.href='../../index.php'; </script>";
}





?>


