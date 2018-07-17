<?php
$flag = "NO";
$sql = "show tables from yagaja_DB";
$result = mysqli_query($con, $sql) or die("선택DB테이블확인 실패원인:".mysqli_error($con));
while($row=mysqli_fetch_row($result)){
    if($row[0]==="message"){
        $flag ="OK";
        break;
    }
}

if($flag!=="OK"){
    $sql= "create table message (
                 num int not null auto_increment,
                 gn int not null,
                 recv_id varchar(15) not null,
                 send_id varchar(15) not null,
                 name char(10) not null,
                 message text not null,
                 recv_read char(2) not null default 'N',
                 regist_day char(20),
                 primary key(num)
                )";
    
    if(mysqli_query($con,$sql)){
        echo "<script>alert('message 테이블이 생성되었습니다.')</script>";
    }else{
        echo "테이블 생성 실패원인:1".mysqli_error($con);
    }
}

?>