<?php
session_start();

include '../../common_lib/createLink_db.php';

$num=$_GET['num'];
$page=$_GET['page'];
$sql= "delete from qna where num=$num";
$result= mysqli_query($con, $sql) or die(mysqli_error($con));

mysqli_close($con);

echo "<script> alert('삭제 되었습니다.'); location.href='qna_list.php?page=$page'; </script>";

?>