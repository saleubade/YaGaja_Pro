<?php
include '../../common_lib/createLink_db.php';

if(isset($_GET['no'])){
    $no=$_GET['no'];
}

$sql="select * from shop_review where review_no=$no";
$result=mysqli_query($con, $sql);
$row=mysqli_fetch_array($result);


for($i=0; $i<3; $i++){
    $image[$i]=$row['file_copied_'.$i];
    $deletePath[$i] = "../upload_data/".$image[$i];
    unlink($deletePath[$i]);
    echo "<br>".$deletePath[$i];
}
$sql="delete from shop_review where review_no=$no";
if(mysqli_query($con, $sql)){
    echo "<script>alert('삭제되었습니다.');location.href='./shop_review.php?page=1';</script>";
}else{
    echo "<script>alert('삭제 실패')</script>";
}


?>

