<?php

$flag = "NO";
$sql = "show tables from yagajaDB";
$result = mysqli_query($con, $sql) or die("실패원인11:".mysqli_error($con));
while($row=mysqli_fetch_row($result)){
    if($row[0]==="seat_state"){
        $flag ="OK";
        break;
    }
}
if($flag!=="OK"){
    $sql = "create table seat_state(
      no int not null auto_increment,
      id char(15) not null,
      flght_ap_num char(15) not null,
      choice_seat varchar(100) null,
      primary key(no)
      )";
    if(mysqli_query($con,$sql)){
        echo "<script>alert('seat_state 테이블이 생성되었습니다.')</script>";
    }else{
        echo "실패원인22:".mysqli_error($con);
    }
}
?>