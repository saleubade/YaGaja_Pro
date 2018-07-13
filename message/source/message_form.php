<?php
session_start();
$id = $_SESSION['id'];
$name = $_SESSION['name'];



?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<link rel="stylesheet" href="../css/message.css?ver=1">

</head>
<body>
  <div id="head">
    <h1>Message Send</h1>
  </div>
  <hr>

<form action="./check_receive.php" method="Post">
<div style="margin: 8px; text-align: left;">
<b>보내는 메세지</b> <br> <textarea name="message_content" rows="10" cols="57"></textarea>
</div>
<div style="margin: 5px; text-align: right;">
<b>상대방 아이디</b> : <input type="text" size="12px;" name="receive_id">
</div>
<br>


<div style="text-align: center;">
<button type="img" style="border: 0px; width: 150px; padding: 0px; height: 30px;"><img src="../img/message.png" width="200px;" style="margin: 0px;"></button>
</div>
</form>

</body>
</html>