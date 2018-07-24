<meta charset="UTF-8">
<?php
session_start();
include "../../common_lib/createLink_db.php";
include "../../shopping_lib/create_table_cart.php";

if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
}
if(isset($_SESSION['name'])){
    $cname = $_SESSION['name'];
}

if(isset($_GET['no'])){
    $no = $_GET['no'];
}
if(isset($_GET['size'])){
    $size = $_GET['size'];
}
if(isset($_GET['value'])){
    $value = $_GET['value'];
    echo $value;
}
if(isset($_GET['value2'])){
    $value = $_GET['value2'];
    echo $value;
}



$sql="select * from shop_goods where shop_no=$no";
$result=mysqli_query($con,$sql);
$row=mysqli_fetch_array($result);

$shop_name=$row['shop_name'];
$shop_price=$row['shop_price'];
$shop_type=$row['shop_type'];
$shop_image=$row['shop_image_change_name1'];
$regist_day = date("Y-m-d (H:i)");

$total= $shop_price * $value;

$sql="insert into cart_goods (cart_no, cart_id, cart_name, cart_amount, cart_price, cart_total,
                              cart_type, cart_size, cart_image_name, cart_check, regist_day) ";
$sql.="values('$no', '$id', '$shop_name' ,'$value' ,'$shop_price' ,'$total',
              '$shop_type' , '$size' ,'$shop_image' ,'null' ,'$regist_day' )";
if(!mysqli_query($con,$sql)){
    echo "no DB: ".mysqli_error($con);
}else{
    echo "<script>location.href='./shopping_cart.php';</script>";
} 

?>