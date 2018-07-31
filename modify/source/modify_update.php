<?php
session_start();
$id = $_SESSION['id'];

include_once '../../common_lib/createLink_db.php';            // dbconn.php 파일을 불러옴

$pass= $_POST['pass'];
$gender= $_POST['gender'];
$zip= $_POST['zip'];
$address1= $_POST['address1'];
$address2= $_POST['address2'];
$email1= $_POST['email1'];
$email2= $_POST['email2'];
$hp1= $_POST['hp1'];
$hp2= $_POST['hp2'];
$hp3= $_POST['hp3'];



$phone=$hp1."-".$hp2."-".$hp3;

$address=$address1." ".$address2;

$email=$email1."@".$email2;

$regist_day=date("y-m-d(h:i)");



$sql="update membership set pass='$pass', gender='$gender', zip='$zip', address1='$address1', address2='$address2',";
$sql .=" phone='$phone', email='$email' ";
$sql .=" where id='$id' ";

mysqli_query($con, $sql)or die(mysqli_error($con));


mysqli_close($con);
echo "<script>alert('회원님의 정보가 변경되었습니다.')</script>";
echo"<script>location.href='../../index.php';</script>";


?>