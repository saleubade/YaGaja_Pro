<?php
session_start();
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    $cname = $_SESSION['name'];
}else{
    $id=null;
}
if($_GET['mode']){
    $mode=$_GET['mode'];
}
if($_GET['no']){
    $no=$_GET['no'];
}
if($_GET['num']){
    $num=$_GET['num'];
}
if($_GET['value']){
    $value=$_GET['value'];
}
if(isset($_GET['size'])){
    $size=$_GET['size'];
}
if($_POST['id']){
    $nick = $_POST['id'];
    $zip = $_POST['zip'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $hp1 = $_POST['hp1'];
    $hp2 = $_POST['hp2'];
    $hp3 = $_POST['hp3'];
    $email1 = $_POST['email1'];
    $email2 = $_POST['email2'];
    $message = $_POST['message'];
}
$baesong = $_POST['baesong'];
$address = $address1."/".$address2;
$hp=$hp1."-".$hp2."-".$hp3;
$email=$email1."@".$email2;

include_once '../../common_lib/createLink_db.php';
include_once '../../shopping_lib/create_table_buy.php';
if($mode == "order"){
    $sql= "select * from shop_goods where shop_no='$no'";
    $table="shop";
}else{
    $sql= "select * from cart_goods where cart_id='$id'";
    $table="cart";
}
$result=mysqli_query($con, $sql);
$total_record=mysqli_num_rows($result);

$regist_day = date("Y-m-d (H:i)");
if($mode == "modify"){
    $sql3="update buy_goods set buy_state='$baesong' where buy_num='$num'";
    mysqli_query($con, $sql3);
    echo "<script>alert('수정이 완료됐습니다.');location.href='../../shopping/source/shopmain.php?';</script>";
}else{
    for($i=0; $i<$total_record; $i++){
        mysqli_data_seek($result,$i);
        $row=mysqli_fetch_array($result);
        $num=$row[''.$table.'_num'];
        $no=$row[''.$table.'_no'];
        $name2=$row[''.$table.'_name'];
        $price=$row[''.$table.'_price'];
        $type=$row[''.$table.'_type'];
        if ($mode != "order"){
            $size=$row[''.$table.'_size'];
        }else if($type != "clothe"){
            $size="";
        }
        if($table == 'cart'){
            $image=$row[''.$table.'_image_name'];
            $value=$row[''.$table.'_amount'];
            $total=$row[''.$table.'_total'];
            $all_total= $all_total + $total;
        }else{
            $image=$row[''.$table.'_image_change_name1'];
            $total = $price * $value;
            $all_total=$total;
        }
        $sql="insert into buy_goods( buy_no, buy_id, buy_name, buy_amount, buy_price,
                                    buy_total, buy_type, buy_size, buy_image_name, buy_check, buy_zip,
                                    buy_address, buy_phone, buy_email, buy_state, message, regist_day) ";
        $sql.=" values('$no', '$id', '$name2', '$value', '$price',
                       '$total', '$type', '$size', '$image', 'null', '$zip',
                       '$address', '$hp', '$email', 'ready', '$message', '$regist_day')";
        mysqli_query($con, $sql);
        if($mode=="order"){
            $sql2="update shop_goods set shop_amount=shop_amount - $value where shop_no=$no";
        }
        else{
            $sql2="update shop_goods set shop_amount=shop_amount - $value where shop_no=$no";
        }
        mysqli_query($con, $sql2) or die(mysqli_error($con));
        
    }
    if($table === "cart"){
        $sql="delete from cart_goods where cart_id='$id'";
        mysqli_query($con, $sql);
    }
    echo "<script>alert('주문이 완료됐습니다.');location.href='../../shopping/source/shopmain.php?';</script>";
}
