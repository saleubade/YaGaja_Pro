<?php

$flag = "NO";
$sql = "show tables from yagajaDB";
$result = mysqli_query($con, $sql) or die("실패원인11:".mysqli_error($con));
while($row=mysqli_fetch_row($result)){
    if($row[0]==="reserve_info"){
        $flag ="OK";
        break;
    }
}
if($flag!=="OK"){
    $sql= "create table reserve_info (
      no int not null auto_increment primary key,
      id char(12) not null,           
      start_flight_ap_num char(10) null,
      back_flight_ap_num char(10) null,     
      adult_num int null,
      chlid_num int null,
      baby_num int null,
      total_price int(11) null,
      reserve_num char(9) null
      )";
    if(mysqli_query($con,$sql)){
        echo "<script>alert('reserve_info 테이블이 생성되었습니다.')</script>";
    }else{
        echo "실패원인22:".mysqli_error($con);
    }
}
?>