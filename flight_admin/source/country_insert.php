<?php
include '../../common_lib/createLink_db.php';    

session_start();

if(!empty($_SESSION['id'])){
    $id = $_SESSION['id'];
}else{
    $id = "?";
}
//--------------------------------------
if(!empty($_POST['area'])){
    $area = $_POST['area'];
}else{
    $area = "";
}
if(!empty($_POST['city'])){
    $city = $_POST['city'];
}else{
    $city = "";
}

//----------------------------------------------------
    $sql= "insert into country (area, city)";
    $sql.= "values ('$area', '$city')";

    mysqli_query($con, $sql) or die(mysqli_error($con));

    mysqli_close($con);

echo "<script>alert('취항지가 등록되었습니다.')</script>";
echo "<script>location.href='admin_country_insert.php'; </script>";

?>