<script>
  function popup(){
    var popupX = (window.screen.width/2)-(1200/2);
    var popupY = (window.screen.height/2)-(600/2);
    window.open('../../login/source/login.php','','left='+popupX+',top='+popupY+', width=1200, height=600, status=no, scrollbars=no');
  }
  function message(){
	    var popupX = (window.screen.width/2)-(800/2);
	    var popupY = (window.screen.height/2)-(500/2);
	    window.open('../../message/source/receive_message.php','','left='+popupX+',top='+popupY+', width=700, height=500, status=no, scrollbars=no');
	  }
</script>
<div id="topmenu">
<a href="../../index.php"><img src="../../common_img/logo.png" style="width: 200px"></a>
<ul id="login">
<?php

include_once './common_lib/createLink_db.php';

session_start();
  if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    $name = $_SESSION['name'];
    
    $sql = "select * from message where recv_id = '$id' and recv_read = 'N' ";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    $not_read_num = mysqli_num_rows($result);
    
  }else{
    $id=null;
  }
  if(!$id){ 
?>
  <li> <a href="../../membership/source/join_form.php">회원가입 </a>&nbsp; </li>
  <li> <a href="#" onclick="popup()">로그인</a> &nbsp;&nbsp;&nbsp;|</li>
<?php }elseif(isset($id)&&$id==="admin"){?>
  <li><a href="../">항공권 관리 </a>&nbsp; </li>
  <li> <a href="../">항공권 등록 </a>&nbsp; |</li>
  <li> <a href="../">회원관리 </a>&nbsp; |</li>
  <li><a href="../">회원리스트 </a>&nbsp; |</li>
  <li><a href="#" onclick="message()">쪽지(&nbsp; <?= $not_read_num ?> &nbsp;) </a>&nbsp; |</li>
  <li>관리자 님 <a href="../../login/source/logout.php">(로그아웃)</a> | </li>
<?php }elseif($id){ ?>
  <li> <a href="../">회원정보수정 </a>&nbsp; </li>
  <li> <a href="../">장바구니 </a>&nbsp; |</li>
  <li> <a href="../">구매내역 </a>&nbsp; |</li>
  <li> <a href="#" onclick="message()">쪽지(&nbsp; <?= $not_read_num ?> &nbsp;) </a>&nbsp; |</li>
  <li> <?=$name?> 님<a href="../../login/source/logout.php">(로그아웃)</a> | </li>
<?php } ?>
</ul>
</div>
