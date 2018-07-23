<?php

$flag = "NO";
$sql = "show tables from yagajaDB";
$result = mysqli_query($con, $sql) or die("실패원인11:".mysqli_error($con));
while($row=mysqli_fetch_row($result)){
    if($row[0]==="flight_one_way"){
        $flag ="OK";
        break;
    }
}
if($flag!=="OK"){
    $sql= "create table flight_one_way (
      flightNum int not null auto_increment primary key,
      flight_price int not null,           
      flight_start char(30) not null,     
      flight_back char(30) not null,       
      flght_ap_num char(10) not null,      
      fly_start_date char(20) not null,    
      fly_start_time char(10) not null,    
      fly_back_time char(10) not null,    
      fly_time char(10) not null,
      recordNum int not null        
      )";
    if(mysqli_query($con,$sql)){
        echo "<script>alert('flight_one_way 테이블이 생성되었습니다.')</script>";
    }else{
        echo "실패원인22:".mysqli_error($con);
    }
}
?>