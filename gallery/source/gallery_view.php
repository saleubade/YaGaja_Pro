<?php
/* 관리자 = 게시글 쓰기, 수정, 삭제, 댓글쓰기, 삭제등 모두 가능
 * 사용자 = 게시글 쓰기, 수정 , 삭제, 댓글쓰기, 삭제등 본인이 쓴 글에 한해서 상태에서 가능(제한된 상태에서만 가능)
 * */

session_start();

include "../../common_lib/createLink_db.php";

if (! empty($_GET['table'])) {
    $table = $_GET['table'];
}
if (! empty($_GET['num'])) {
    $num = $_GET['num'];
}
if (! empty($_GET['page'])) {
    $page = $_GET['page'];
}
if (! empty($_GET["continent"])) {
    $continent = $_GET["continent"];
}




$sql = "select * from $table where num=$num";
$result = mysqli_query($con, $sql) or die("실패원인 1: " . mysqli_error($con));

$row = mysqli_fetch_array($result);
// 하나의 레코드 가져오기

$item_num = $row["num"];
$item_id = $row["id"];
$item_name = $row["name"];
$item_hit = $row["hit"];
$item_regist_day = $row["regist_day"];


$image_name[0] = $row['file_name_0'];
$image_name[1] = $row['file_name_1'];
$image_name[2] = $row['file_name_2'];

$image_copy[0] = $row['file_copy_0'];
$image_copy[1] = $row['file_copy_1'];
$image_copy[2] = $row['file_copy_2'];

$item_date = $row['regist_day'];
$item_subject = str_replace(" ", "&nbsp;", $row[subject]);
$item_content = $row['content'];

// echo $item_content;
// exit();


// 첨부이미지가 3개 이므로 배열로 저장하며 3번 반복
for ($i = 0; $i < 3; $i ++) {
    if (! empty($image_copy[$i])) {
        
        // 이미지 사이즈를 정해주는 함수를 사용하여 저장
        $imageinfo = GetImageSize("../data/" . $image_copy[$i]);
        
        $image_width[$i] = $imageinfo[0];
        $image_height[$i] = $imageinfo[1];
        $image_type[$i] = $imageinfo[2];
        
        if ($image_width[$i] > 785) {
            $image_width[$i] = 785;
        }
    } else {
        $image_width[$i] = "";
        $image_height[$i] = "";
        $image_type[$i] = "";
    }
}


// 조회수를  증가시키기 위하여 새로운 변수값에 저장
$new_hit = $item_hit + 1;

$sql = "update $table set hit=$new_hit where num=$num"; // 글 조회수 증가시킴
mysqli_query($con, $sql) or die("실패원인2 : " . mysqli_error($con));

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>야 ~ 가자!</title>
    <link rel="stylesheet" href="../../common_css/index_css3.css?ver=1">
    <link rel="stylesheet" href="../css/view4.css?ver=3">
   	<script>
   	function check_input(){
   		
   		if(!document.ripple_form.ripple_content.value){
   			alert("내용을 입력해주세요!");
   			document.ripple_form.ripple_content.focue();
   			return;
   		}
   		
   		 document.ripple_form.submit(); 
   	}
    function del(href){
        if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n 정말 삭제하시겠습니까?")){
          document.location.href=href;
        }
      }
   	</script>
   	
   	</head>
  <body>
    <header>
      <?php include "../../common_lib/top_login2.php"; ?>
    </header>
    <nav id="top">
      <?php include "../../common_lib/main_menu2.php"; ?>
    </nav>
    <section id="section">
    	<aside id="left_menu">
      <?php include "../../common_lib/left_menu2.php"; ?>
	</aside>
      <article class="main" >
        <div id="head">
          <h1>View</h1>
        </div>
        <hr>
          	<table  id="table_11"><tr>
          	
      <div id="view_title2"><td id="td_1"><b><?=$item_subject?></b></td> <td id="td_2"> | <?=$item_regist_day?></td><td id="td_3">| 조회 : <?=$item_hit?> | </td> <td id="td_4">아이디 : <?=$item_id ?> | </td></div>
      <div id="view_content">
      <div id="ititit"></div></div></tr>
      </table>
   
      <br>
      <div id="view_ti">
      <table id="table_12">
      <tr>
      <td>
      <?php 
      
      // write_form 에서 업로드 시킨 첨부파일3개를 
      for($i=0;$i<3;$i++){
          if($image_copy[$i]){
              $img_name = $image_copy[$i];
              $img_name = "../data/".$img_name;
              $img_width = $image_width[$i];
              
              echo "<img src='$img_name' width='$img_width'>"."<br><br>";
              
          }
      }
      echo $item_content;
     
      ?>
      </td>
      </tr>
      </table>
     </div>
      <?php 
      
      // 댓글 관련 쿼리 로직
      $sql = "select * from gallery_ripple where parent='$item_num'";
      $result3 = mysqli_query($con, $sql);
      
      while($row_result3 = mysqli_fetch_array($result3)){
          $result3_num=$row_result3['num'];
          $result3_id=$row_result3['id'];
          $result3_name=$row_result3['name'];
          $ripple_content=str_replace("\n","<br>",$row_result3['content']);
          $ripple_content=str_replace(" ","&nbsp;",$ripple_content);
          $result3_date=$row_result3['regist_day'];
      ?>
      <div id="result3_3">
      
      <table cellspacing="0">
      
      </div>
      
      <!-- 리플을 달았을때 보여지는 공간 -->
      <tr><td><div id="result3_0">
      <ul id="table_1">
      <li><?=$result3_name."님"?></li>
      <li><?="(".$result3_id.")"?></li>
      <li id="result3_1"><?=$result3_date?></li>
      <li>
      
      <?php
      
      // 사용자가 접속한 아이디 이거나 아이디가 관리자일때 댓글 삭제 가능
      if($id == $result3_id || $id === "admin"){
      
          echo "<a href='gallery_delete_ripple.php?table=$table&page=$page&num=$item_num&ripple_num=$result3_num'>[삭제]</a>";
          
      }
      ?>
      </li>
      </ul>
      
      <div id="rippele_r"><?=$ripple_content?></div>
      </div>
      </td>
      </tr>
      </table>
      
      <?php 
      }
      ?>
      <br>
      <form name="ripple_form" action="gallery_insert_ripple.php?table=<?=$table?>&num=<?=$num?>&page=<?=$page?>&continent=<?=$continent?>" method="post">
      <div id="box">
      <div id="box_1"><textarea name="ripple_content" rows="5" col="65"></textarea></div>
     
      <div id="box_2"><a href="#"><img src="../img/ok_ripple.gif" onclick="check_input()"></a></div>
      
      </div>
      
      <div id="clear"></div>
      </form>
      </div>
      <div id="view_button">
      
      <a href="gallery_list.php?table=<?=$table?>&page=<?=$page?>"><img src="../img/list.png"></a>&nbsp;
      <?php 
      
      // 사용자가 접속한 아이디 이거나 아이디가 관리자일때 게시글 삭제 가능
      if($id == $item_id || $id === "admin"){
      ?>
      <a href="gallery_write_form.php?table=<?=$table?>&mode=modify&num=<?=$num?>&page=<?=$page?>&continent=<?=$continent?>"><img src="../img/modify.png"></a>&nbsp;
      <a href="javascript:del('gallery_delete.php?table=<?=$table?>&num=<?=$num?>&page=<?=$page?>')"><img src="../img/delete.png"></a>&nbsp;
      <?php 
      }
      ?>
     
       <div id="clear"></div>
      </div>
      	</article>
      	</section>
<footer>
      <?php include "../../common_lib/footer2.php"; ?>
	</footer>
</body>
</html>
   	


