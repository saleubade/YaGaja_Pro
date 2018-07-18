<?php
session_start();
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    $cname = $_SESSION['name'];
}else{
    $id=null;
}
include_once '../../common_lib/createLink_db.php';
include_once '../../common_lib/create_table_notice.php';


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>야! 몰</title>
  <link rel="stylesheet" href="../css/notice.css?ver=44">
  <link rel="stylesheet" href="../../shopping/css/cart.css?ver=1">
  <link rel="stylesheet" href="../../common_css/shop_index_css3.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../shopping/css/shopping3.css?ver=3">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <header style="border:1px solid black;">
   		<?php include_once '../../shopping_lib/top_login3.php';?>
    </header>
    <nav id="shop_aside">
    	<?php include_once '../../shopping_lib/shop_main_menu.php';?>  	
    </nav>
    <section>
    	<div id="notice">NOTICE</div>
    </section>
    <section>
    	<div class="notice_section">
    		<table class="notice_section_table">
    			<tr>
    				<td class="notice_write_subject">제목</td>
    				<td class="notice_write_content"><input id="notice_input_subject" type="text"></td>
    			</tr>
    			<tr>
    				<td class="notice_write_subject">내용</td>
    				<td class="notice_write_content_text"><input id="notice_input_content" type="text" rows="10" cols="30"></td>
    			</tr>
    			<tr>
    				<td class="notice_write_subject">이미지파일1</td>
    				<td class="notice_write_content"><input class="notice_input_image" type="file"></td>
    			</tr>
    			<tr>
    				<td class="notice_write_subject">이미지파일2</td>
    				<td class="notice_write_content"><input class="notice_input_image" type="file"></td>
    			</tr>
    		</table>
    		<div id="notice_write_form">
    			<a><button class="notice_write">완료</button></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    			<a><button class="notice_write">취소</button></a>
    		</div>
		</div>    
    </section>

	<div class="clear"></div><div class="clear"></div><div class="clear"></div>
	<footer style="border:1px solid black;">
 		<?php include_once '../../common_lib/footer2.php';?>
  	</footer>
</body>
</html>  