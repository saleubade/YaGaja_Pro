<meta charset="UTF-8">
<?php
$flag = "NO";
$sql = "show tables from yagajaDB";
$result = mysqli_query($con, $sql) or die("실패원인:".mysqli_error($con));
while($row=mysqli_fetch_row($result)){
    if($row[0]==="shop_goods"){
        $flag = "OK";
        break;
    }
}
if($flag !=="OK"){
    $sql = "create table shop_goods(
      shop_no int not null auto_increment,
      shop_name varchar(100) not null,
      shop_amount varchar(50) not null,
      shop_price varchar(50) not null,
      shop_type char(10) not null,
      shop_sizeS int,
      shop_sizeM int,
      shop_sizeL int,
      shop_sizeXL int,
      shop_image_name1 char(40),
      shop_image_name2 char(40),
      shop_image_name3 char(40),
      shop_image_name4 char(40),
      shop_image_change_name1 char(40),
      shop_image_change_name2 char(40),
      shop_image_change_name3 char(40),
      shop_image_change_name4 char(40),
      shop_introduce text,
      regist_day char(20),
      hit int,
      primary key(shop_no)
    )";
    if(mysqli_query($con, $sql)){
        echo "<script>
                alert('shop 테이블 생성성공!');
              </script>";
    }else{
        echo "<script>
                alert('shop 테이블 생성실패');
              </script>";
    }
}
?>