<?php
include '../../common_lib/createLink_db.php';
session_start();

if(!empty($_SESSION['id'])){
    $id = $_SESSION['id'];
}else{
    $id = "?";
}

if(!empty($_GET['seat'])){
    $seat = $_GET['seat'];
}else{
    $seat = "?";
}

if(!empty($_POST['seat'])){
    $seat2 = $_POST['seat'];
}else{
    $seat2 = "?";
}
//B777-302

$seat = substr($seat,4);
echo $seat;     //get 으로 좌석 한개값만 가져오기
$regist_time= $current_time = date("Y-m-d H:i:s",mktime());
 $sql = "insert into seat_state (flght_ap_num, seat_no, id, seat_state, regist_time)
 values ('$flght_ap_num','$seat', '$id', 'reverse','$regist_time')";
 mysqli_query($con,$sql) or die ("실패원인:".mysqli_error($con));

//기본값 세팅 b777 302항공편

$sql = "select * from flight_one_way a inner join seat_state b on a.flght_ap_num = b.flght_ap_num";
mysqli_query($con,$sql) or die ("실패원인:".mysqli_error($con));



    
    

?>







