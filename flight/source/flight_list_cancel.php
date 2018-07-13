<?php
include '../../common_lib/createLink_db.php';
session_start();

if(!empty($_SESSION['id'])){
    $id = $_SESSION['id'];
}else{
    $id = "";
}
if(!empty($_POST['start_check'])){
    $start_check = $_POST['start_check'];
}else{
    $start_check = "";
}
if(!empty($_POST['back_check'])){
    $back_check = $_POST['back_check'];
}else{
    $back_check = "";
}

$start_check = substr($start_check,6,7);
var_dump($start_check);
$back_check = substr($back_check,5,6);
var_dump($back_check);


if($start_check && $back_check){       //있냐없냐
    $sql = "delete from reserve_info where no = '$start_check' or no = '$back_check'";
    mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
    
}else if($start_check && !$back_check){ //출국만 삭제
    $sql = "delete from reserve_info where no = '$start_check'";
    mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
}else if(!$start_check && $back_check){ //귀국만 삭제
    $sql = "delete from reserve_info where no = '$back_check'";
    mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
}



echo "<script>
     history.go(-1);
 alert('예약취소 되었습니다.');
    </script>";
    
   
    
    

?>
