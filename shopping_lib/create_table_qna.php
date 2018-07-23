<?php
$flag="NO";
$sql = "show tables from yagaja_db";
$result = mysqli_query($con, $sql) or die("실패원인1:".mysqli_error($con));
while($row=mysqli_fetch_row($result)){
    if($row[0]===shop_qna){
        $flag ="OK";
        break;
    }
}
if($flag !=="OK"){
    $sql= "create table shop_qna (
                qna_no int not null auto_increment,
                qna_group_num int not null,
                qna_depth int not null,
                qna_ord int not null,
                qna_id char(15) not null,
                qna_nick char(10) not null,
                subject char(100) not null,
                content text not null,
                file_name_0 varchar(40),
                file_copied_0 varchar(40),
                regist_day char(20),
                hit int,
                primary key(qna_no)
               )";
    
    if(mysqli_query($con,$sql)){
        echo "<script>alert('qna 테이블이 생성되었습니다.')</script>";
    }else{
        echo "실패원인2:".mysqli_query($con);
    }
}
?>