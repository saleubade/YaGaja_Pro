<?php
if(isset($_GET['mode'])){
    $mode=$_GET['mode'];
}
if(isset($_GET['id'])){
    $id=$_GET['id'];
}
if(isset($_GET['cart_num'])){
    $num=$_GET['cart_num'];
}
include '../../common_lib/createLink_db.php';

if($mode=='all'){
    $sql="delete from cart_goods where cart_id='$id'";
    if(mysqli_query($con, $sql)){
        echo "<script> alert('삭제되었습니다.'); history.back(); </script>";
    }else{
        echo mysqli_error($con);
    }
}else if($mode=='single'){
    $sql="delete from cart_goods where cart_id='$id' && cart_num=$num";
    if(mysqli_query($con, $sql)){
        echo "<script> alert('삭제되었습니다.'); location.href='shopping_cart.php?page=1'; </script>";
    }else{
        echo mysqli_error($con);
    }
}



