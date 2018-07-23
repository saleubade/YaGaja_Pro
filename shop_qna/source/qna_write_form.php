<?php
session_start();
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    $cname = $_SESSION['name'];
}
if(isset($_GET['mode'])){
    $mode = $_GET['mode'];
    $no = $_GET["no"];

}

include_once '../../common_lib/createLink_db.php';
include_once '../../shopping_lib/create_table_qna.php';

if($mode=="modify" || $mode == "response"){
    $sql= "select * from shop_qna where qna_no=$no";
    $result= mysqli_query($con, $sql);
    $row=mysqli_fetch_array($result);
    
    $nick=$row['qna_nick'];
    $subject=$row['subject'];
    $content=$row['content'];
    $regist_day=$row['regist_day'];
    $file_copied[0]=$row['file_copied_0'];

    if($mode == "response"){
        $subject="&nbsp;&nbsp;&nbsp;&nbsp;[문의]".$subject;
    }
    
}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>야! 몰</title>
  <link rel="stylesheet" href="../css/qna.css?ver=6">
  <link rel="stylesheet" href="../../shopping/css/cart.css?ver=6">
  <link rel="stylesheet" href="../../common_css/shop_index_css3.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../shopping/css/shopping3.css?ver=6">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript">
	function check_input(){
		if(!document.qna_form.subject.value){
          alert('제목을 입력하세요!');
          document.qna_form.subject.focus();
          return;
	    } 
        if(!document.qna_form.content.value){
          alert('내용을 입력하세요!');
          document.qna_form.content.focus();
          return;
        }
        document.qna_form.submit();
	}
  </script>
</head>
<body>
    <header>
   		<?php include_once '../../shopping_lib/top_login3.php';?>
    </header>
    <nav id="shop_aside">
    	<?php include_once '../../shopping_lib/shop_main_menu.php';?>  	
    </nav>
    <section>
    	<div id="qna">Q&A</div>
    </section>
  <?php 
  if($mode == "modify"){
  ?>
  	  <form name="qna_form" action="./insert.php?mode=modify&no=<?=$no?>" method="post" enctype="multipart/form-data">
  <?php
	}elseif($mode == "response"){
  ?>
	  <form  name="qna_form" method="post" action="./insert.php?mode=response&no=<?=$no?>" enctype="multipart/form-data"> 	  
  <?php 
  }else{
  ?>
      <form name="qna_form" action="./insert.php?" method="post" enctype="multipart/form-data">
  <?php 
  }
  ?>
            <section>
            	<div class="qna_section">
            		<table class="qna_section_table">
            			<tr>
            				<td class="qna_write_subject">제목</td>
        				    <?php 
        				    if($mode == "modify" || $mode == "response"){
                            ?>
                            <td class="qna_write_content"><input id="qna_input_subject" type="text" name="subject" value="<?=$subject?>"></td>
            				<?php 
                            }else{
            				?>
            				<td class="qna_write_content"><input id="qna_input_subject" type="text" name="subject"></td>
            				<?php 
                            }
            				?>
            			</tr>
            			<tr>
            				<td class="qna_write_subject">내용</td>
            				<td class="qna_write_content_text">
            				<?php 
        						if($mode == "modify"){
        					?>
            					<textarea id="qna_input_content" rows="10" cols="100" name="content" value="<?=$content?>"></textarea>
            				<?php 
        						}else{
        					?>
        						<textarea id="qna_input_content" rows="10" cols="100" name="content"></textarea>
        					<?php 
        						}
        					?>
            				</td>
            			</tr>
            			<tr>
            				<td class="qna_write_subject">이미지파일</td>
            				<td class="qna_write_content">
            					<input class="qna_input_image" type="file" name="upfile[]" value="0">
            					<div style="float: left;">
            					<?php 
            						if($mode == "modify"){
            					?>
									이미지:<?=$file_copied[0]?>&nbsp;<input type="checkbox" name="del_file[]" value="0">삭제
								<?php 
            						}else{
            					?>
            					<?php 
            						}
            					?>
            					</div>
            				</td>
            			</tr>

            		</table>
        </form>
        </section>
		<div id="qna_write_form">
			<input type="button" class="qna_write" onclick="check_input()" value="완료">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="./shop_qna.php?page=1"><button class="qna_write">취소</button></a>
		</div>
	</div>    
            
	<div class="clear"></div><div class="clear"></div><div class="clear"></div>
	<footer style="border-top:2px solid black;">
 		<?php include_once '../../common_lib/footer2.php';?>
  	</footer>
</body>
</html>  