<?php
date_default_timezone_set("Asia/Seoul");
$DBflag = "NO";
$con =mysqli_connect("localhost","root","123456","") or die("MySQL 접속실패!");
$sql = "show databases";
$result = mysqli_query($con, $sql) or die("실패원인:".mysqli_error($con));

while($row=mysqli_fetch_row($result)){
    if($row[0] == "yagaja_DB"){
        $DBflag = "OK";
        break;
    }
}
if($DBflag !== "OK"){
    $sql = "create database yagaja_DB";
    if(mysqli_query($con,$sql)){
        echo "<script>alert('yagaja_DB 생성완료!')</script>";
    }
}
$con = mysqli_connect("localhost","root","123456","yagajaDB") or die("yagajaDB 접속실패!");//yagajaDB  접속
?>