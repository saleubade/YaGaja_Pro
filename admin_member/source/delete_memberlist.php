<?php

include_once "../../common_lib/createLink_db.php";

$id = $_GET['id'];

$sql="delete from membership where id='$id' ";
$result=mysqli_query($con, $sql) or die("실패원인 : ".mysqli_error($con));

echo"
    <script>
        alert('회원 강제 탈퇴  완료');
        location.href='member_list.php';
    </script>
";


mysqli_close($con);
?>