<?php
session_start();
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    $cname = $_SESSION['name'];
}else{
    $id=null;
}
if(isset($_GET['no'])){
    $no=$_GET['no'];
}
include_once '../../common_lib/createLink_db.php';
include_once '../../shopping_lib/create_table_notice.php';

$sql= "select * from shop_notice where notice_no=$no";
$result= mysqli_query($con, $sql);
$row=mysqli_fetch_array($result);

$nick=$row['notice_nick'];
$subject=$row['notice_subject'];
$content=$row['notice_content'];
$regist_day=$row['regist_day'];
$file_copied[0]=$row['file_copied_0'];
$file_copied[1]=$row['file_copied_1'];

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>야! 몰</title>
  <link rel="stylesheet" href="../css/notice.css?ver=2">
  <link rel="stylesheet" href="../../shopping/css/cart.css?ver=1">
  <link rel="stylesheet" href="../../common_css/shop_index_css3.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/shopping3.css?ver=4">
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
    	<div id="notice_section">
    		<table id="notice_table3">
    			<tr id="notice_table_tr">
    				<td class="notice_view_table_td1">SUBJECT</td>
    				<td class="notice_view_table_td2"><?=$subject?></td>
    			</tr>
    			<tr id="notice_table_tr">
    				<td class="notice_view_table_td1">WRITER</td>
    				<td class="notice_view_table_td2"><?=$nick?></td>
    			</tr>
    			<tr id="notice_table_tr2">
    				<td id="notice_view_date1"></td>
    				<td id="notice_view_date2"><b>DATE</b>&nbsp;&nbsp;&nbsp;<?=$regist_day?></td>
    		</table>
    		<div id="notice_content_view">
    			<?php 
    			for($i=0; $i<2; $i++){
    			    if($file_copied[$i]){
    			?>
    					<img src="../upload_image/<?=$file_copied[$i]?>"><br>
    			<?php 		
    			    }
    			}
    			?>
    			<?=$content?>
    		</div><br><br>
    		<table id="notice_table4">
    			<tr id="notice_table4_tr">
    				<td id="notice_table4_tr_td">
    					<a href="./shop_notice.php?page=1"><input type="button" value="목록" class="notice_view_button"></a>
    					<a href="./notice_write_form.php?no=<?=$no?>&mode=modify"><input type="button" value="수정" class="notice_view_button"></a>
    					<a href="./notice_delete.php?no=<?=$no?>"><input type="button" value="삭제" class="notice_view_button"></a>
    				</td>
    			</tr>
    		</table>
    	</div>
    </section>
    <div class="clear"></div><div class="clear"></div><div class="clear"></div>
	<footer>
 		<?php include_once '../../common_lib/footer2.php';?>
  	</footer>
</body>
</html>
