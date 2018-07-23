<meta charset="utf-8">
<?php
if(isset($_GET['mode'])){
    $mode=$_GET['mode'];
}
if(isset($_GET['id'])){
    $id=$_GET['id'];
}
if(isset($_GET['buy'])){
    $buy=$_GET['buy'];
}
if(isset($_GET['cart_num'])){
    $num=$_GET['cart_num'];
}
if(isset($_GET['cart_no'])){
    $no=$_GET['cart_no'];
    echo $no;
}
if(isset($_POST['cart_list_check'])){
    $del_table_num=$_POST['cart_list_check'];
}


include '../../common_lib/createLink_db.php';

if($mode=='all'){
    $sql="delete from cart_goods where cart_id='$id'";
    if(mysqli_query($con, $sql)){
        echo "<script> alert('삭제되었습니다.'); location.href='shopping_cart.php?page=1'; </script>";
    }else{
        echo mysqli_error($con);
    }
}else if($mode=='single'){
    $sql="delete from cart_goods where cart_id='$id' and cart_num=$num";
    if(mysqli_query($con, $sql)){
        echo "<script> alert('삭제되었습니다.'); location.href='shopping_cart.php?page=1'; </script>";
    }else{
        echo mysqli_error($con);
    }
}else if($mode == 'choice'){
    $count = count($del_table_num);
    for($i=0;$i<$count;$i++){
        $sql="delete from cart_goods where cart_id='$id' and cart_num= '$del_table_num[$i]'";
        mysqli_query($con, $sql);
    }
    if($buy =='y')
        echo "<script> alert('삭제되었습니다.'); location.href='../../shopping_buy/source/shopping_buy.php?mode=allorder&table=cart'; </script>";
    else   
        echo "<script> alert('삭제되었습니다.'); location.href='shopping_cart.php?page=1'; </script>";
}



