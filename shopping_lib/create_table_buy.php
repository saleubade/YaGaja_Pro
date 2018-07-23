<meta charset="UTF-8">
<?php
$flag = "NO";
$sql = "show tables from yagaja_DB";
$result = mysqli_query($con, $sql) or die("실패원인:".mysqli_error($con));
while($row=mysqli_fetch_row($result)){
    if($row[0]==="buy_goods"){
        $flag = "OK";
        break;
    }
}
if($flag !=="OK"){
    $sql = "create table buy_goods(
      buy_num int not null auto_increment,
      buy_no int not null,
      buy_id char(20),
      buy_name varchar(100) not null,
      buy_amount varchar(50) not null,
      buy_price varchar(50) not null,
      buy_total varchar(50) not null,
      buy_type char(10) not null,
      buy_size char(10),
      buy_image_name char(40),
      buy_check char(5),
      buy_zip varchar(7) not null,
      buy_address varchar(50) not null,
      buy_phone varchar(13) not null,
      buy_email varchar(30) not null,
      buy_state varchar(30),
      message text,
      regist_day varchar(20),
      primary key(buy_num)
    )";
    if(mysqli_query($con, $sql)){
        echo "<script>
                alert('buy 테이블 생성성공!');
              </script>";
    }else{
        echo mysqli_error($con);
        echo "<script>
                alert('buy 테이블 생성실패');
              </script>";
    }
}
?>