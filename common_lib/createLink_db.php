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
<<<<<<< HEAD
        echo "<script>alert('yagajaDB 생성완료!')</script>";
=======
        echo "<script>alert('yagaja_DB 생성완료!')</script>";
>>>>>>> 5600cc23c605e18970a4c2d76846714ac16e5951
    }
}
$con = mysqli_connect("localhost","root","123456","yagaja_DB") or die("yagaja_DB 접속실패!");//yagajaDB  접속
?>