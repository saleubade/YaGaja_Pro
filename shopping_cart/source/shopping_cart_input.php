<?php
session_start();
include "../../common_lib/createLink_db.php";
include "../../shopping_lib/create_table_cart.php";

if(isset($_GET['no'])){
    $no = $_GET['no'];
}
else{
    $no = "";
}
if(isset($_GET['size'])){
    $size = $_GET['size'];
}
else {
    $size = "";
}
if(isset($_GET['value'])){
    $value = $_GET['value'];
}
if(isset($_GET['value2'])){
    $value = $_GET['value2'];
}



$sql="select * from shop_goods where shop_no=$no";
$result=mysqli_query($con,$sql);
$row=mysqli_fetch_array($result);

$shop_name=$row['shop_name'];
$shop_price=$row['shop_price'];
$shop_type=$row['shop_type'];
$shop_image=$row['shop_image_change_name1'];
$regist_day = date("Y-m-d (H:i)");

$total= $shop_price * value;

$sql="insert into cart_goods (cart_no, cart_name, cart_amount, cart_price, cart_total,
                              cart_type, cart_size, cart_image_name, cart_check, regist_day) ";
$sql.="values('$no', '$shop_name' ,'$value' ,'$shop_price' ,'$total',
              '$shop_type' , '$size' ,'$shop_image' ,'null' ,'$regist_day' )";
echo $sql;
?>