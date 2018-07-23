<?php
include '../../common_lib/createLink_db.php';
session_start();

if(!empty($_GET['city'])){
    $city = $_GET['city'];
}else{
    $city = "";
}

$sql="delete from country where city ='$city' ";
$result=mysqli_query($con, $sql) or die("실패원인 : ".mysqli_error($con));

echo"
    <script>
    alert('취항지 삭제 완료');
    location.href='admin_country_insert.php';
</script>
";

mysqli_close($con);
?>