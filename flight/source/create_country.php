<?php

$flag = "NO";
$sql = "show tables from yagaja_DB";
$result = mysqli_query($con, $sql) or die("실패원인:".mysqli_error($con));
while($row=mysqli_fetch_row($result)){
    if($row[0]==="country"){
        $flag ="OK";
        break;
    }
}
if($flag!=="OK"){
    $sql= "create table country (
      countryNum int not null auto_increment primary key,
      area char(15) not null,
      city char(30) not null
      )";
    if(mysqli_query($con,$sql)){
        echo "<script>alert('country 테이블이 생성되었습니다.')</script>";
    }else{
        echo "실패원인:".mysqli_query($con);
    }
}