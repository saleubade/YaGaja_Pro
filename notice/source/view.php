<?php
/*  제목을 눌렀을 시.
 *  관리자 로그인 시 수정 삭제 가능
 *  관리자 or 로그인 자 덧글 쓰기 가능.(자기자신 댓글은 삭제 가능)
 *  댓글 쓰기 insert_ripple.php?table=<?=$table?>&num=<?=$num?>&page=<?=$page?>
 *   */
session_start();
include "../../common_lib/createLink_db.php";

$num = $_GET["num"];
$page = $_GET["page"];
$table = $_GET["table"];

if(isset($_SESSION["id"])){
    $id=$_SESSION['id'];
    
    $name=$_SESSION['name'];
}
$sql="select * from $table where num=$num";

$result=mysqli_query($con, $sql);
$row=mysqli_fetch_array($result);

$item_num=$row["num"];
$item_id=$row["id"];
$item_name=$row["name"];
$item_hit=$row["hit"];
$item_regist_day = $row["regist_day"];

$file_name[0]=$row['file_name_0'];
$file_name[1]=$row['file_name_1'];

$file_copied[0]=$row['file_copied_0'];
$file_copied[1]=$row['file_copied_1'];

$item_date=$row['regist_day'];
$item_subject=str_replace(" ","&nbsp;",$row["subject"]);
$item_content=str_replace(" ","&nbsp;",$row["content"]);
$item_content=str_replace("\n","<br>",$item_content);

for($i=0 ; $i<2 ; $i++){
    if($file_copied[$i]){
        $imageinfo = getimagesize("../data/".$file_copied[$i]);
        $image_width[$i] = $imageinfo[0];
        $image_height[$i] = $imageinfo[1];
        
        if($image_width[$i]>785){
            $image_width[$i] = 785;
        }else{
            $image_width[$i]=400;
        }
    }else{
        $image_width[$i]="";
        $image_height[$i]="";
    }
}
$new_hit=$item_hit+1;

$sql="update $table set hit=$new_hit where num=$num";
mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../common_css/index_css3.css">
    <link rel="stylesheet" href="../css/view.css?ver=1">
   	<script>
   	function check_input(){
   		
   		if(!document.ripple_form.ripple_content.value){
   			alert("내용을 입력하세요!");
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
      <article class="main">
        <div id="head">
          <h1>Notice View</h1>
        </div>
        <hr>
          	<table  id="table_11"><tr>
      <div id="view_title2"><td id="td_1"><b><?=$item_subject?></b></td> <td id="td_2"> | <?=$item_regist_day?> | </td> <td id="td_3"> | 조회 : <?=$item_hit?> | </td></div>
      <div id="view_content">
      <div id="ititit"></div></div></tr>
      </table>
      <?php 
      for($i=0;$i<2;$i++){
          if($file_copied[$i]){
             $img_name = $file_copied[$i];
             $img_name = "../data/".$img_name;
             $img_width = $image_width[$i];
              
             echo "<img src='$img_name' width='$img_width'>"."<br><br>";
          
              
          }
      }
      
      ?>
      <br>
      <div id="view_ti">
      <table id="table_12">
      <tr>
      <td>
      <?php 
        echo $item_content;
      ?>
      </td>
      </tr>
      </table>
     </div>
     
      
      <div id="view_button">
      
      <a href="exhibit.php?table=<?=$table?>&page=<?=$page?>"><img src="../img/list.png"></a>&nbsp;
      <?php 
      if(isset($id) && ($id==="admin")){
      ?>
      <a href="write_form.php?table=<?=$table?>&mode=modify&num=<?=$num?>&page=<?=$page?>"><img src="../img/modify.png"></a>&nbsp;
      <a href="javascript:del('delete.php?table=<?=$table?>&num=<?=$num?>&page=<?=$page?>')"><img src="../img/delete.png"></a>&nbsp;
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





























