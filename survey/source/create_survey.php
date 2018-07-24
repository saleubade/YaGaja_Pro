<?php
$flag = "NO";
$sql = "show tables from yagaja_DB";
$result = mysqli_query($con, $sql) or die("선택DB테이블확인 실패원인:".mysqli_error($con));
while($row=mysqli_fetch_row($result)){
    if($row[0]==="survey"){
        $flag ="OK";
        break;
    }
}
    
    if($flag!=="OK"){
        $sql= "create table survey (
                ans1 int,
                ans2 int,
                ans3 int,
                ans4 int,
                ans5 int
                   )";
               
        if(mysqli_query($con,$sql)){
            echo "<script>alert('survey 테이블이 생성되었습니다.')</script>";
        }else{
            echo "테이블 생성 실패원인:2".mysqli_error($con);
        }
        $sql = "insert into survey values(0,0,0,0,0)";
        mysqli_query($con,$sql);
    }

    
?>