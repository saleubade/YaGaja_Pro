<?php
$flag = "NO";
$sql = "show tables from yagajadb";
$result = mysqli_query($con, $sql) or die("선택DB테이블확인 실패원인:".mysqli_error($con));
while($row=mysqli_fetch_row($result)){
    if($row[0]==="community"){
        $flag ="OK";
        break;
    }
}

if($flag!=="OK"){
    $sql= "create table community (
                 num int not null auto_increment,
                 id char(15) not null,
                 name char(10) not null,
                 continent char(15) not null,
                 subject char(100) not null,
                 content text not null,
                 regist_day char(20),
                 hit int,
                 file_name_0 char(40),
                 file_name_1 char(40),
                 file_copied_0 char(30),
                 file_copied_1 char(30),
                 primary key(num)
                )";
    
    if(mysqli_query($con,$sql)){
        echo "<script>alert('community 테이블이 생성되었습니다.')</script>";
    }else{
        echo "테이블 생성 실패원인:2".mysqli_error($con);
    }
}

?>