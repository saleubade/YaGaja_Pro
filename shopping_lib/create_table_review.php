<meta charset="UTF-8">
<?php
$flag = "NO";
$sql = "show tables from yagaja_DB";
$result = mysqli_query($con, $sql) or die("실패원인:".mysqli_error($con));
while($row=mysqli_fetch_row($result)){
    if($row[0]==="shop_review"){
        $flag = "OK";
        break;
    }
}
if($flag !=="OK"){
    $sql = "create table shop_review(
      review_no int not null auto_increment,
      review_id char(20) not null,
      review_nick varchar(100) not null,
      review_subject varchar(50) not null,
      review_content text not null,  
      regist_day char(20),
      hit int,
      file_name_0 varchar(40),
      file_copied_0 varchar(40),
      primary key(review_no)
    )CHARSET UTF8";
    if(mysqli_query($con, $sql)){
        echo "<script>
                alert('shop_review 테이블 생성성공!');
              </script>";
    }else{
        echo "<script>
                alert('shop_review 테이블 생성실패');
              </script>";
    }
}
?>