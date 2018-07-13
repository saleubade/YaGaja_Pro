<?php
include_once '../../common_lib/createLink_db.php';

$flag = "NO";
$sql = "show tables from yagajaDB";
$result = mysqli_query($con, $sql) or die("실패원인:".mysqli_error($con));
while($row=mysqli_fetch_row($result)){
    if($row[0]==="membership"){
        $flag ="OK";
        break;
    }
}
if($flag!=="OK"){
    $sql= "create table membership (
      id char(12) not null primary key,
      pass char(16) not null,
      name char(5) not null,
      birth char(10) not null,
      gender char(5) not null,
      zip char(7) not null,
      address char(50) not null,
      phone char(13) not null,
      email char(30) not null
      )";
    if(mysqli_query($con,$sql)){
        echo "<script>alert('membership 테이블이 생성되었습니다.')</script>";
    }else{
        echo "실패원인:".mysqli_query($con);
    }
}


?>