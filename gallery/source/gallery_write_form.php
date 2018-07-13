<?php
    session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
   <link href="../../common_css/index_css4.css" rel="stylesheet"
	type="text/css" media="all">
   <link rel="stylesheet" href="../css/write_form.css?ver=1">
  <script>
      function check_insert(){
    	 if(!document.board_form.select_from.value){
            alert("유형을 선택해주세요!");
            document.board_form.select_from.focus();
            return;
         }
    	 if(!document.board_form.subject.value){
            alert("제목을 입력해주세요!");
            document.board_form.subject.focus();
            return;
         }
         if(!document.board_form.content.value){
            alert("내용을 입력해주세요!");
            document.board_form.content.focus();
            return;
         }
         
       
         
         document.board_form.submit();
      }
 
  </script> 

  </head>
  <body onload="hide_file();">
  <header>
      <?php include_once '../../common_lib/top_login2.php'; ?>
    </header>
    <nav id="top">
      <?php include_once '../../common_lib/main_menu2.php'; ?>
    </nav>
        <section id="section">
      <article class="main">
        <div id="head">
          <h1>게시글 작성</h1>
        <hr size="3px" color="black">
        </div>
        
  <?php 
  if(isset($mode) && $mode === "modify"){
      
  ?>
  <form name="board_form" action="gallery_insert.php?mode=modify&num=<?=$num?>&page=<?=$page?>&table=<?=$table?>" method="post" enctype="multipart/form-data">
  
  <?php 
  }else{
  
  ?>
      <form name="board_form" action="gallery_insert.php?page=<?=$page?>" method="post" enctype="multipart/form-data">
 <?php 
  }
 ?>

  <div id="write_form_1">
  

  <table border="1" id="table_good" >
  <tr>
	<th style="background-color: gray;">유 형</th>
	<td style="text-align: center;"><input type="radio" id="select_from" name="radio_from" class="1"/>Asia
	<input type="radio" id="select_from" name="radio_from" class="1"/>Europe
	<input type="radio" id="select_from" name="radio_from" class="1"/>America
	<input type="radio" id="select_from" name="radio_from" class="1"/>Afreeca
	<input type="radio" id="select_from" name="radio_from" class="1"/>Oceania
	</td>
  </tr>
  <tr>
  	<th style="background-color: gray;">제 목</th>
  	<td><input type="text" name="subject" value="<?=$item_subject?>" size="100"></td>
  </tr>
  <tr>
	<th style="background-color: gray;">내용</th>  
  	<td><textarea name="content" rows="25" cols="100"></textarea></td>
  </tr>
  <tr>
	<th style="background-color: gray;">이미지 파일 1</th>  
  	<td><input type="file" name="upfile[]" ></td>
  </tr>
  <tr>
	<th style="background-color: gray;">이미지 파일 2</th>  
  	<td><input type="file" name="upfile[]"></td>
  </tr>
  <tr>
	<th style="background-color: gray;">이미지 파일 3</th>  
  	<td><input type="file" name="upfile[]"></td>
  </tr>
  </table>  

  
  
   
<!--  <div class="write_form"></div> -->
<!--   <div id="write_1"> -->
<!--   <div class="write_1_1">제목</div> -->
  <!--<div class="write_1_2"><input type="text" name="subject" value="<?=$item_subject?>"></div> -->
<!--   </div> -->
  
<!--   <div class="write_form"></div> -->
<!--   <div id="write_2"> -->
<!--   <div class="write_1_1">내용</div> -->
  <!-- <div class="write_1_2"><textarea name="content" rows="14" cols="75"><?=$item_content?></textarea></div> --> 
<!--   </div> -->
  
  <div class="write_form"></div>
  <div id="write_3">
 <!--  <div class="write_1_1">이미지파일1</div>
  <div class="write_1_2"> -->
  
    <?php 
//   if((isset($mode) && $mode==="modify") && $item_file0){    // 글쓰기 수정시1
//   ?>
<!--   <div class="delete_ok"> -->
  <!-- <?=$item_file0?>파일이 등록되어 있습니다. -->
<!--   <input type="checkbox" name="del_file[]" value="0">삭제</div> -->
  <!-- <div id="hide_file1"><input type='file' name='upfile[]'></div> -->
<!--     <div class="clear"></div> -->
<!--     </div> -->
  <?php 
//   }else{
//  echo "<input type='file' name='upfile[]'> </div>";
      
//   }
//   ?>
  
  </div>
  

  
  <div class="write_form"></div>
  <div id="write_4">
  <!-- <div class="write_1_1"> 이미지파일2 </div>
  <div class="write_1_2"> -->
  
  
  
  
  <?php 
//   if((isset($mode) && $mode==="modify") && $item_file1){    // 글쓰기 수정시2
//   ?>
<!--   <div class="delete_ok"> -->
<!-- <?=$item_file1?>파일이 등록되어 있습니다. -->  
<!--   <input type="checkbox" name="del_file[]" value="1">삭제</div> -->
<!--   <div id="hide_file2"><input type='file' name='upfile[]'></div> -->
<!--   <div class="clear"></div> -->
  
  <?php 
//   } else{
//       echo "<input type='file' name='upfile[]'></div>";
//   } 
//   ?>
  </div>
  <div class="write_form"></div>
  <div class="clear"></div>
</div>
<div id="write_button">

<a href="#"><img src="../img/ok.png" onclick="check_insert()"></a>&nbsp;

<a href="gallery_list.php?table=<?=$table?>&page=<?=$page?>"><img src="../img/list.png"></a>
</div>
    </div>
    </form>
      </article>
    </section>
     <footer>
       <?php include_once '../../common_lib/footer2.php';?>
    </footer>
     
  </body>
 
</html>
    

