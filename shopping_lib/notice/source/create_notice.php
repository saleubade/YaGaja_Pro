<?php
$flag ="NO";
$sql = "show tables from yagajaDB";
$result = mysqli_query($con, $sql) or die("실패원인:".mysqli_error($connect));

while($row = mysqli_fetch_row($result)){
    if($row[0] === "notice"){
        $flag = "OK";
        break;
    }
}
if($flag !== "OK"){
    $sql = "create table notice(
    num int not null auto_increment,
    id varchar(15) not null,
    name varchar(20) not null,
    subject varchar(100) not null,
    content text not null,
    regist_day char(20),
    hit int,
    file_name_0 varchar(40),
    file_name_1 varchar(45),
    file_name_2 varchar(45),
    file_copied_0 varchar(40),
    file_copied_1 varchar(40),
    file_copied_2 varchar(40),
        
    primary key(num)
)";
    if(mysqli_query($con, $sql)){
        echo "<script>
                alert('notice 테이블이 생성되었습니다.')
              </script>";
    }else{
        echo "실패원인:".mysqli_error($con);
    }
}
?>