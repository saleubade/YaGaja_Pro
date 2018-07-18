<?php
session_start();
$id = $_SESSION['id'];
$name = $_SESSION['name'];

include_once "../../common_lib/createLink_db.php";

$num = $_GET['item_num'];

$sql = "select * from message where num = '$num'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);

$send_id=$row["send_id"];
$send_name=$row["name"];

$message_cont=$row["message"];



$sql = "update message SET recv_read = 'Y' where num = '$num'";
mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Ya! Gaja~</title>
<link rel="stylesheet" href="../css/message.css?ver=1">
<script type="text/javascript">
function receive_message_close(){
	window.close();
	window.opener.location.reload(true);
}
</script>
</head>
<body>
  <div id="head">
    <h1>Receive Message</h1>
  </div>
  <hr>

<div style="margin: 8px; text-align: left;">
<?=$send_name."님"?>&nbsp<?="( ".$send_id." ) 이 보낸 메세지 "?> <br> <textarea name="message_content" rows="10" cols="57" readonly style="margin-top: 5px;"><?= $message_cont?></textarea>
</div>
<div style="text-align: right;">
<a href="./message_from.php?send_id=<?= $send_id?>">[답장 보내기]</a> 
</div>
<br>
<div style="text-align: center;">
<a href="#" onclick="receive_message_close()">[확인]</a>
<a href="./delete_message.php?item_num=<?=$num ?>">[삭제]</a>
</div>

</body>
</html>