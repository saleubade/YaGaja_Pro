<?php
include_once '../../common_lib/createLink_db.php';

$num = $_GET['item_num'];

$sql = "delete from message where num = '$num'";
mysqli_query($con, $sql);

mysqli_close($con);

echo "<script> alert('삭제 되었습니다.'); window.close(); 
       window.opener.location.reload(true);
      </script>";

?>
