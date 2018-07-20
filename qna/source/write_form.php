<?php
session_start();
include "../../common_lib/createLink_db.php";

/*  글쓰기
 *  제목 내용 이미지 파일 등록insert.php?table=<?=$table?>&page=<?=$page?>
 *  
 *  수정시
 *  insert.php?mode=modify&num=<?=$num?>&page=<?=$page?>&table=<?=$table?>
 * 
 *   
 *   */


if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
}

    $mode = $_GET['mode'];
    $num = $_GET["num"];
    $table = $_GET["table"];
    $page = $_GET["page"];
    

//수정 시.
if(isset($mode) && $mode == "modify"){
    $sql = "select * from $table where num='$num'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    
    $item_subject = $row['subject'];
    $item_content = $row['content'];
    $item_file0 = $row['file_name_0'];
    $item_file1 = $row['file_name_1'];
    $copied_file_0=$row['file_copied_0'];
    $copied_file_1=$row['file_copied_1'];
}else{
    $item_subject = null;
    $item_content = null;
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
   <link rel="stylesheet" href="../../common_css/index_css3.css">
   <link rel="stylesheet" href="../css/content1.css">
  <script>
      function check_input(){
         if(!document.board_form.subject.value){
            alert("제목을 입력하세요!");
            document.board_form.subject.focus();
            return;
         }
         if(!document.board_form.content.value){
            alert("내용을 입력하세요!");
            document.board_form.content.focus();
            return;
         }
         document.board_form.submit();
      }
 
  </script> 
  </head>
  <body onload="hide_file();">
  <header>
      <?php include "../../common_lib/top_login2.php"; ?>
    </header>
    <nav id="top">
      <?php include "../../common_lib/main_menu2.php"; ?>
    </nav>
        <section id="section">
      <article class="main">
        <div id="head">
          <h1>글쓰기</h1>
        </div>
        <hr>
  <?php 
  if(isset($mode) && $mode === "modify"){
      
  ?>
  <form name="board_form" action="insert.php?mode=modify&num=<?=$num?>&page=<?=$page?>&table=<?=$table?>" method="post" enctype="multipart/form-data">
  
  <?php 
  }else{
  
  ?>
      <form name="board_form" action="insert.php?table=<?=$table?>&page=<?=$page?>" method="post" enctype="multipart/form-data">
 <?php 
  }
 ?>

  <div id="write_form_1">
   
 <div class="write_form"></div>
  <div id="write_1">
  <div class="write_1_1">제목</div>
  <div class="write_1_2"><input type="text" name="subject" value="<?=$item_subject?>"></div>
  </div>
  
  <div class="write_form"></div>
  <div id="write_2">
  <div class="write_1_1">내용</div>
  <div class="write_1_2"><textarea name="content" rows="14" cols="75"><?=$item_content?></textarea></div>
  </div>
  
  <div class="write_form"></div>
  <div id="write_3">
  <div class="write_1_1">이미지파일1</div>
  <div class="write_1_2">
  
    <?php 
  if((isset($mode) && $mode==="modify") && $item_file0){
  ?>
  <div class="delete_ok">
  <?=$item_file0?>파일이 등록되어 있습니다.
  <input type="checkbox" name="del_file[]" value="0">삭제</div>
  <div id="hide_file1"><input type='file' name='upfile[]'></div> 
    <div class="clear"></div>
    </div>
  <?php 
  }else{
 echo "<input type='file' name='upfile[]'> </div>";
      
  }
  ?>
  
  </div>
  

  
  <div class="write_form"></div>
  <div id="write_4">
  <div class="write_1_1"> 이미지파일2 </div>
  <div class="write_1_2">
  
  
  
  
  <?php 
  if((isset($mode) && $mode==="modify") && $item_file1){
  ?>
  <div class="delete_ok">
  <?=$item_file1?>파일이 등록되어 있습니다.
  <input type="checkbox" name="del_file[]" value="1">삭제</div>
  <div id="hide_file2"><input type='file' name='upfile[]'></div>
  <div class="clear"></div>
  
  <?php 
  } else{
      echo "<input type='file' name='upfile[]'></div>";
  } 
  ?>
  </div>
  <div class="write_form"></div>
  <div class="clear"></div>
</div>
<div id="write_button">

<a href="#"><img src="../img/ok.png" onclick="check_input()"></a>&nbsp;
<a href="exhibit.php?table=<?=$table?>&page=<?=$page?>"><img src="../img/list.png"></a>
</div>

    </div>
    </form>
      </article>
    </section>
     <footer>
      <?php include "../../common_lib/footer2.php"; ?>
    </footer>
  </body>
</html>
    