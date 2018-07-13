<?php
session_start();
include "../../common_lib/createLink_db.php";
$table = $_GET["table"];
$num = $_GET["num"];
$ripple_num = $_GET["ripple_num"];
$page = $_GET["page"];

$sql = "delete from community_ripple where num=$ripple_num";

if(!mysqli_query($con, $sql)){
    echo "실패원인 : ".mysqli_errno($con);
}
mysqli_close($con);



 echo ("
    <script>
    location.href='view.php?table=$table&page=$page&num=$num';
    </script>
");  
?>