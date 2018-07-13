<?php
$flag = "NO";
$sql = "show tables from yagajaDB";
$result = mysqli_query($con, $sql) or die("실패원인:".mysqli_error($con));
while($row=mysqli_fetch_row($result)){
    if($row[0]==="cart_goods"){
        $flag = "OK";
        break;
    }
}
if($flag !=="OK"){
    $sql = "create table cart_goods(
      cart_no int not null,
      cart_name varchar(100) not null,
      cart_amount varchar(50) not null,
      cart_price varchar(50) not null,
      cart_total varchar(50) not null,
      cart_type char(10) not null,
      cart_size char(10) not null,
      cart_image_name char(40),
      cart_check char(5),  
      regist_day char(20),
      primary key(cart_no)
    )";
    if(mysqli_query($con, $sql)){
        echo "<script>
                alert('cart 테이블 생성성공!');
              </script>";
    }else{
        echo "<script>
                alert('cart 테이블 생성실패');
              </script>";
    }
}
?>