<?php
include '../../common_lib/createLink_db.php';
session_start();

if(!empty($_SESSION['id'])){
    $id = $_SESSION['id'];
}else{
    $id = "?";
}

if(!empty($_GET['rs_num'])){
    $reservation_number = $_GET['rs_num'];
}else{
    $reservation_number = "?";
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

if(!empty($_GET['anum'])){
    $adult_num = $_GET['anum'];
}else{
    $adult_num = "0";
}
if(!empty($_GET['bnum'])){
    $baby_num = $_GET['bnum'];
}else{
    $baby_num = "0";
}
if(!empty($_GET['cnum'])){
    $child_num = $_GET['cnum'];
}else{
    $child_num = "0";
}

if(!empty($_GET['fly'])){
    $fly = $_GET['fly'];
}else{
    $fly = "";
} 
if(!empty($_GET['total_price'])){
    $total_price = $_GET['total_price'];
}else{
    $total_price = "";
} 
$current_date = date("Y-m-d");


if($fly == 'round'){    ////왕복
    
    if($start_check == "low_price_start" && $back_check == "low_price_back"){
        //최저가 티켓
        $sql = "select * from flight_one_way where flight_price =
(select min(flight_price) from flight_one_way where flight_start = '$start' and flight_back = '$back')";
        $result1 = mysqli_query($con,$sql) or die("실패원인1 : ".mysqli_error($con));
        $row = mysqli_fetch_array($result1);
    
        $start_flight_ap_num = $row[flght_ap_num];
        
        $sql = "select * from flight_one_way where flight_price =
(select min(flight_price) from flight_one_way where flight_start = '$back' and flight_back = '$start')";
        $result2 = mysqli_query($con,$sql) or die("실패원인2 : ".mysqli_error($con));
        $row = mysqli_fetch_array($result2);
   
        $back_flight_ap_num = $row[flght_ap_num];
    }else if($start_check == "low_price_start" && $back_check != "low_price_back"){
        //최저가 티켓
        $sql = "select * from flight_one_way where flight_price =
(select min(flight_price) from flight_one_way where flight_start = '$start' and flight_back = '$back')";
        $result1 = mysqli_query($con,$sql) or die("실패원인3 : ".mysqli_error($con));
        $row = mysqli_fetch_array($result1);
      
        $start_flight_ap_num = $row[flght_ap_num];
        //-----------------------------------------------------------------
        $back_recordnum = substr($back_check, 4);      //귀국편 선택한 티켓 번호
        
        $sql = "select * from flight_one_way where flight_start = '$back' and flight_back = '$start' and recordNum = '$back_recordnum' ";
        
        $result2 = mysqli_query($con,$sql) or die("실패원인4: ".mysqli_error($con));
        $row = mysqli_fetch_array($result2);
        
        $back_flight_ap_num = $row[flght_ap_num];
    }else if($start_check != "low_price_start" && $back_check == "low_price_back"){
        $start_recordnum = substr($start_check, 5);      //출국편 선택한 티켓 번호
        
        $sql = "select * from flight_one_way where flight_start= '$start' and flight_back='$back' and recordNum = '$start_recordnum' ";
        
        $result1 = mysqli_query($con,$sql) or die("실패원인5: ".mysqli_error($con));
        
        $row = mysqli_fetch_array($result1);
       
        $start_flight_ap_num = $row[flght_ap_num];
        //-----------------------------------------------------------------
        $sql = "select * from flight_one_way where flight_price =
(select min(flight_price) from flight_one_way where flight_start = '$back' and flight_back = '$start')";
        $result2 = mysqli_query($con,$sql) or die("실패원인6 : ".mysqli_error($con));
        $row = mysqli_fetch_array($result2);
        
        $back_flight_ap_num = $row[flght_ap_num];
        
    }else{
        $start_recordnum = substr($start_check, 5);      //출국편 선택한 티켓 번호
        
        $sql = "select * from flight_one_way where flight_start= '$start' and flight_back='$back' and recordNum = '$start_recordnum' ";
        
        $result1 = mysqli_query($con,$sql) or die("실패원인7: ".mysqli_error($con));
        
        $row = mysqli_fetch_array($result1);
 
        $start_flight_ap_num = $row[flght_ap_num];
        
        $back_recordnum = substr($back_check, 4);      //귀국편 선택한 티켓 번호
        
        $sql = "select * from flight_one_way where flight_start = '$back' and flight_back = '$start' and recordNum = '$back_recordnum' ";
        
        $result2 = mysqli_query($con,$sql) or die("실패원인8: ".mysqli_error($con));
        $row = mysqli_fetch_array($result2);
  
        $back_flight_ap_num = $row[flght_ap_num];
    }
}else{      //편도
    
    if($start_check == "low_price_start"){
        //최저가 티켓
        $sql = "select * from flight_one_way where flight_price =
(select min(flight_price) from flight_one_way where flight_start = '$start' and flight_back = '$back')";
        $result1 = mysqli_query($con,$sql) or die("실패원인1 : ".mysqli_error($con));
        $row = mysqli_fetch_array($result1);
      
        $start_flight_ap_num = $row[flght_ap_num];
        
    }else{
        $start_recordnum = substr($start_check, 5);      //출국편 선택한 티켓 번호
        
        $sql = "select * from flight_one_way where flight_start= '$start' and flight_back='$back' and recordNum = '$start_recordnum' ";
        
        $result1 = mysqli_query($con,$sql) or die("실패원인7: ".mysqli_error($con));
        
        $row = mysqli_fetch_array($result1);
    
        $start_flight_ap_num = $row[flght_ap_num];
    }
    
}
/* var_dump($id);
var_dump($start_flight_ap_num);
var_dump($back_flight_ap_num);
var_dump($adult_num);
var_dump($child_num);
var_dump($baby_num);
var_dump($total_price);
var_dump($reservation_number); */



if($fly== "round"){
    $sql = "insert into reserve_info (id, start_apnum, adult_num, chlid_num, baby_num, reserve_num, payment_price, payment_date) values
    ('$id','$start_flight_ap_num','$adult_num','$child_num' ,'$baby_num','$reservation_number', '$total_price', '$current_date')";
    
    mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
    
    $sql = "insert into reserve_info (id, back_apnum, adult_num, chlid_num, baby_num, reserve_num, payment_price, payment_date) values
    ('$id','$back_flight_ap_num','$adult_num','$child_num' ,'$baby_num','$reservation_number', '$total_price', '$current_date')";
    
    
    mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
    
}else{
    $sql = "insert into reserve_info (id, start_apnum, adult_num, chlid_num, baby_num, reserve_num, payment_price, payment_date) values
    ('$id','$start_flight_ap_num','$adult_num','$child_num' ,'$baby_num','$reservation_number', '$total_price', '$current_date')";
    
    mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
}
$num = $adult_num+$child_num+$baby_num;
echo "<script>location.href ='../../flight_reserve/source/flight_seat.php?fly=$fly&num=$num&sapnum=$start_flight_ap_num&bapnum=$back_flight_ap_num';
</script>";


?>
