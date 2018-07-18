<?php
    session_start();
    
    if(isset($_SESSION['id'])){
        $id=$_SESSION['id'];
    }
    if(isset($_GET['mode'])){
        $mode = $_GET['mode'];
        $num = $_GET['num'];
        $page = $_GET['page'];
        $table = $_GET['table'];
    }

    
    if (isset($mode) && $mode == "modify"){
        $sql = "select * from $table where num=$num";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_array($result);
        
        $item_subject = $row['subject'];
        $item_content = $row['content'];
        $item_continent = $row['continent'];
        
        $item_file_name_0 = $row['file_name_0'];
        $item_file_name_1 = $row['file_name_1'];
        $item_file_name_2 = $row['file_name_2'];
        
        $item_copy_file_0 = $row['file_copy_0'];
        $item_copy_file_1 = $row['file_copy_1'];
        $item_copy_file_2 = $row['file_copy_2'];
    }
    
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
   <link href="../../common_css/index_css3.css?ver=1" rel="stylesheet"
	type="text/css" media="all">
   <link rel="stylesheet" href="../css/write_form.css?ver=1">
  <script>
      function check_insert(){

    	 if(!document.board_form.radio_from.value){
            alert("유형을 선택해주세요!");
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
    	 
    	 if(!document.board_form.fil1_0.value && !document.board_form.fil1_1.value && !document.board_form.fil1_2.value){
             alert("이미지를 꼭 첨부해주세요!");
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
  <!-- 모드가 수정일때 -->
  <?php 
  }else{
  
  ?>
  <form name="board_form" action="gallery_insert.php?page=<?=$page?>" method="post" enctype="multipart/form-data">
  <!-- 모드가 수정이 아닌 일반 글쓰기일때 -->     
  <?php 
  }
  ?>

  <div id="write_form_1">
  

  <table border="1" id="table_good" >
  <tr>
	<th style="background-color: gray; text-align: center;">유 형</th>
	<td style="text-align: center;">
	<input type="radio" id="select_from" name="radio_from" value="Asia"/>Asia
	<input type="radio" id="select_from" name="radio_from" value="Europe"/>Europe
	<input type="radio" id="select_from" name="radio_from" value="America"/>America
	<input type="radio" id="select_from" name="radio_from" value="Afreeca"/>Afreeca
	<input type="radio" id="select_from" name="radio_from" value="Oceania"/>Oceania
	</td>
  </tr>
  <tr>
  	<th style="background-color: gray; text-align: center;">제 목</th>
  	<td><input type="text" name="subject" value="<?=$item_subject ?>" size="100" ></td>
  </tr>
  <tr>
	<th style="background-color: gray; text-align: center;">내용</th>  
  	<td><textarea name="content" value="<?=$item_content ?>" rows="25" cols="100"></textarea></td>
  </tr>
  <tr>
	<th style="background-color: gray; text-align: center;">이미지 파일 1</th>  
  	<td><input id="fil1_0" type="file" name="upfile[]" ></td>
  </tr>
  <tr>
	<th style="background-color: gray; text-align: center;">이미지 파일 2</th>  
  	<td><input id="fil1_1" type="file" name="upfile[]" ></td>
  </tr>
  <tr>
	<th style="background-color: gray; text-align: center;">이미지 파일 3</th>  
  	<td><input id="fil1_2" type="file" name="upfile[]" ></td>
  </tr>
  </table>  



   

  
    <?php 
    if($mode == "modify" && isset($item_file_name_0)) {    // 글쓰기 수정시1
   ?>
   <table border="1" id="table_good" >
  <tr>
	<th style="background-color: gray; text-align: center;">유 형</th>
	<td style="text-align: center;">
	<input type="radio" id="select_from" name="radio_from" >
	</td>
  </tr>
  <tr>
  	<th style="background-color: gray; text-align: center;">제 목</th>
  	<td><input type="text" name="subject" value=<?=$item_subject ?> size="100" ></td>
  </tr>
  <tr>
	<th style="background-color: gray; text-align: center;">내용</th>  
  	<td><textarea name="content"  rows="25" cols="100" value=<?=$item_content ?>></textarea></td>
  </tr>
  <tr>
	<th style="background-color: gray;">이미지 파일 1</th>  
  	<td><input type="file" name="upfile[]" value="0"><?=$item_file_name_0?>파일이 등록되어 있습니다.<input type="checkbox" name="del_file[]" value="0">삭제 </td>  
  </tr>
   </table>

  <?php 
   }else{

  /* echo "<input type='file' name='upfile[]'> </div>"; */
      
   }
   ?>
  
  </div>
  

  
 
  
  
  
  <?php 
  if((isset($mode) && $mode==="modify") && $item_file_name_1){    // 글쓰기 수정시2
   ?>
   <div class="delete_ok"> 
 <?=$item_file_name_1?>파일이 등록되어 있습니다.  
   <input type="checkbox" name="del_file[]" value="1">삭제</div> 
   <div id="hide_file2"><input type='file' name='upfile[]'></div> 
   <div class="clear"></div> -->
  
  <?php 
   } else{
      /*  echo "<input type='file' name='upfile[]'></div>"; */
   } 
   ?>
  </div>
  
  
  
  
  
  
  
  <?php 
  if((isset($mode) && $mode==="modify") && $item_file_name_2){    // 글쓰기 수정시3
   ?>
   <div class="delete_ok"> -->
 <?=$item_file_name_2?>파일이 등록되어 있습니다. -->  
   <input type="checkbox" name="del_file[]" value="1">삭제</div> -->
   <div id="hide_file2"><input type='file' name='upfile[]'></div> -->
   <div class="clear"></div> -->
  
  <?php 
   } else{
       /* echo "<input type='file' name='upfile[]'></div>"; */
   } 
   ?>
 
 
<div id="write_button"><a href="#"><img src="../img/ok.png" onclick="check_insert()"></a>
<a href="gallery_list.php?table=<?=$table?>&page=<?=$page?>&continent=<?=$continent ?>"><img src="../img/list.png"></a></div>
 
    </form>
      </article>
    </section>
     <footer>
       <?php include_once '../../common_lib/footer2.php';?>
    </footer>
     
  </body>
 
</html>
    

