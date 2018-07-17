<meta charset="UTF-8">
<script>
  function popup(){
	var popupX = (window.screen.width/2)-(1200/2);
    var popupY = (window.screen.height/2)-(600/2);
    window.open('../../login/source/login.php','','left='+popupX+',top='+popupY+', width=1200, height=600, status=no, scrollbars=no');
  }
</script>
<div id="topmenu">
<a href="../../index.php"><img src="../../common_img/logo.png" style="width: 200px"></a>
<ul id="login">
<?php
session_start();
  if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    $cname = $_SESSION['name'];
  }else{
    $id=null;
  }
  if(!$id){ 
?>
  <li> <a href="../../membership/source/join_form.php">회원가입 </a>&nbsp; </li>
  <li> <a href="#" onclick="popup()">로그인</a> &nbsp;&nbsp;&nbsp;|</li>
<?php }elseif(isset($id)&&$id==="admin"){?>
  <li><a href="../">주문리스트 </a>&nbsp; |</li>
  <li> <a href="../">상품정보수정 </a>&nbsp; |</li>
  <li><a href="../../input/source/shop_input_form.php">상품등록 </a>&nbsp; |</li>
  <li>관리자 님 <a href="../../login/source/logout.php">(로그아웃)</a> | </li>
<?php }elseif($id){ ?>
  <li> <a href="../">회원정보수정 </a>&nbsp; </li>
  <li> <a href="../../">구매내역 </a>&nbsp; |</li>
  <li> <a href="../../shopping_cart/source/shopping_cart.php?11">장바구니 </a>&nbsp; |</li>
  <li> <?=$cname?> 님<a href="../../login/source/logout.php">(로그아웃)</a> | </li>
<?php } ?>
</ul>
</div>
