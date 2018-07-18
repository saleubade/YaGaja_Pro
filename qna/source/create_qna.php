<?php
$flag = "NO";
$sql = "show tables from yagaja_DB";
$result = mysqli_query($con, $sql) or die("실패원인:".mysqli_error($con));
while($row=mysqli_fetch_row($result)){
    if($row[0]==="qna"){
        $flag ="OK";
        break;
    }
}
if($flag!=="OK"){
    $sql= "create table qna (
      num int not null auto_increment primary key,
      gno int,
      depth char(10) default 'A',
      id char(12) not null,
      name char(5) not null,
      subject char(50) not null,
      content text not null,
      regist_day char(20),
      hit int default 0,
      secret_ok char(1)
      )";
    
    if(mysqli_query($con,$sql)){
        echo "<script>alert('qna 테이블이 생성되었습니다.')</script>";
    }else{
        echo "실패원인:".mysqli_error($con);
    }
}
?>