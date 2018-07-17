<?php
session_start();
include '../../common_lib/createLink_db.php';
include './create_gallery.php';
include './create_gallery_ripple.php';

$continent = "Asia";
$table = "gallery";


if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}
if (isset($_GET['continent'])) {
    $continent = $_GET['continent'];
}
if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
    $search = $_POST['search'];
    $find = $_POST['find'];
}
$no = $_GET['no'];

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="../css/gallery.css?ver=2" type="text/css"
	media="all">
<link rel="stylesheet" href="../../common_css/index_css3.css?ver=2"
	type="text/css" media="all">
    <?php
    if ($mode == "search") {
        if (empty($search)) {
            echo ("
				<script>
				 window.alert('검색할 단어를 입력해 주세요!');
			     history.go(-1);
				</script>
			");
            exit();
        }
        $sql = "select * from $table where $find like '%$search%' and continent = '$continent' order by num desc";
    }else{
        $sql = "select * from $table where continent = '$continent' order by num desc";
    }
    
    ?>
    
    <?php
     
      
      $sql = "select * from gallery order by num desc";
      $result3 = mysqli_query($con, $sql) or die(mysqli_error($con));
      $total_record = mysqli_num_rows($result3);
      

      $rows_scale=9;
      $pages_scale=5;
      
      // 전체 페이지 수 ($total_page) 계산
      $total_pages= ceil($total_record/$rows_scale);
      
      if(empty($_GET['page'])){
          $page=1;
      }else{
          $page = $_GET['page'];
      }
      
      
      // 현재 페이지 시작 위치 = (페이지 당 글 수 * (현재페이지 -1))  [[ EX) 현재 페이지 2일 때 => 3*(2-1) = 3 ]]
      $start_row= $rows_scale * ($page -1) ;
      
      // 이전 페이지 = 현재 페이지가 1일 경우. null값.
      $pre_page= $page>1 ? $page-1 : NULL;
      
      // 다음 페이지 = 현재페이지가 전체페이지 수와 같을 때  null값.
      $next_page= $page < $total_pages ? $page+1 : NULL;
      
      // 현재 블럭의 시작 페이지 = (ceil(현재페이지/블럭당 페이지 제한 수)-1) * 블럭당 페이지 제한 수 +1  [[  EX) 현재 페이지 5일 때 => ceil(5/3)-1 * 3  +1 =  (2-1)*3 +1 = 4 ]]
      $start_page= (ceil($page / $pages_scale ) -1 ) * $pages_scale +1 ;
      
      // 현재 블럭 마지막 페이지
      $end_page= ($total_pages >= ($start_page + $pages_scale)) ? $start_page + $pages_scale-1 : $total_pages;
      
      $number=$total_record- $start_row;
      
      
    /* $sql = "select * from gallery";
    $result3 = mysqli_query($con, $sql);
    $num_table = mysqli_num_rows($result3); */
                   
    ?>
   
    </head>
<body>
	<header>
      <?php include '../../common_lib/top_login2.php'; ?>
    </header>
	<nav id="top">
      <?php include '../../common_lib/main_menu2.php'; ?>
    </nav>

	<section>
		<aside id="left_menu">
      	<?php include '../../common_lib/left_menu2.php'; ?>
		</aside>
		<article class="main">
			<div id="head">

				<h1>Gallery</h1>
				

			</div>
			<hr>
			<?php 
			
			$sql = "select * from gallery order by $item_hit desc";
			$result2 = mysqli_query($con, $sql);
			
			
			for($j = 0; $j < 3; $j++){
			   // 가져올 레코드 위치 이동
			   mysqli_data_seek($result2, $j);
			   
			   // 하나 레코드 가져오기
			   $row = mysqli_fetch_array($result2);
			   
			   $good_num = $row["num"];
			   $good_id = $row["id"];
			   $good_name = $row["name"];
			   
			   $good_hit = $row["hit"];
			   $good_date = $row["regist_day"];
			   $good_date = substr($item_date, 0, 10);
			   $good_subject = str_replace(" ", "&nbsp;", $row["subject"]);
			   
			   ?>
			   
			   <div style="border: 1px solid blue; width: 250px; height: 140px; float: left; margin-left: 50px; ">
			   <a href="gallery_view.php?table=<?=$table?>&num=<?=$good_num ?>&page=<?=$page?>&continent=<?=$continent?>"><img src="../img/asd.jpg" style="width: 250px; height: 140px;">
			    <?=$good_subject ?></a>
			   </div>
			  
			  <?php  
			     }
			  ?>
		
			
			<div style="clear: both;"></div>

										<div id="menu">
				<form name="board_form"
					action="gallery_list.php?table=<?=$table?>&mode=search"
					method="post">
					<div id="form_1">
						<div id="form_2">
							<div id="form_total1"> <?=$continent?></div>
				<div id="form_search2">
				
								<input type="image" src="../img/list_search_button.gif">
							</div>
							<div id="form_search1">
								<input type="text" name="search">
							</div>

							<div id="form_select">
								<select name="find">
									<option value="subject">제목</option>
									<option value="name">이름</option>
									<option value="content">내용</option>
								</select>
							</div>							
						<div style="text-align: center;" id="list_search1">▷ 총 <?= $total_record ?> 개의 게시물이 있습니다.  </div>
					</div>

				</div>
			
			</div>

			</form>
			<div class="clear"></div>
			
			<?php


			for ($i=$start_row; ($i<$start_row+$rows_scale) && ($i< $total_record); $i++){
             // 가져올 레코드 위치 이동
             mysqli_data_seek($result3, $i);
        
             // 하나 레코드 가져오기
                $row = mysqli_fetch_array($result3);
        
                $item_num = $row["num"];
                $item_id = $row["id"];
                $item_name = $row["name"];
        
                $img_copy_name0 = $row['file_copy_0'];
                $img_copy_name1 = $row['file_copy_1'];
                $img_copy_name2 = $row['file_copy_2'];
                
                $item_hit = $row["hit"];
                $item_date = $row["regist_day"];
                $item_date = substr($item_date, 0, 10);
                $item_subject = str_replace(" ", "&nbsp;", $row["subject"]);
        
                
                
                
                if(!empty($img_copy_name0)){ // 첫번째 이미지 파일이 있으면 1번 이미지를 보여줌
                    $main_img = $img_copy_name0;
                 
                }else if(empty($img_copy_name0) && !empty($img_copy_name1)){ // 첫번째 이미지 파일이 없고 두번째 이미지 파일이 있으면 2번 이미지 보여줌
                    $main_img = $img_copy_name1;
                 
                }else if(empty($img_copy_name0) && empty($img_copy_name1) && !empty($img_copy_name2)){ // 첫번째, 두번째 없고 세번째 있으면  3번 이미지 보여줌  
                    $main_img = $img_copy_name2;
                 
                }
                
                
                ?>
	




			<div style="border: 1px solid red; width: 250px; height: 140px; float: left; margin-left: 50px; margin-top: 50px;">
			   <a href="gallery_view.php?table=<?=$table?>&num=<?=$item_num?>&page=<?=$page?>&continent=<?=$continent?>">
			   <img src="../data/<?=$main_img?>" style="width: 250px; height: 140px;">
			    <div style="font-size: 13px;">제목 : <?=$item_subject ?></div><div style="font-size: 13px;">조회수 : <?=$item_hit ?></div></a>
 	 </div> 
 			  
      <!-- <div id="list0" style="display: inline; "> -->

			<div class="clear"></div>
			
     <?php
        $number --;
        
    }
 
    ?>
     
	  <div style="clear: both;"></div>   
      <div id='page_box' style="text-align: center; margin-top: 55px;">
      
  <?php
  #----------------이전블럭 존재시 링크------------------#
  if($start_page > $pages_scale){
      $go_page= $start_page - $pages_scale;
      echo "<a id='before_block' href='gallery_list.php?mode=$mode&page=$go_page&continent=$continent'> << </a>";
  }
  #----------------이전페이지 존재시 링크------------------#
  if($pre_page){
      echo "<a id='before_page' href='gallery_list.php?mode=$mode&page=$pre_page&continent=$continent'> < </a>";
  }
  #--------------바로이동하는 페이지를 나열---------------#
  for($dest_page=$start_page;$dest_page <= $end_page;$dest_page++){
      if($dest_page == $page){
          echo( "&nbsp;<b id='present_page'>$dest_page</b>&nbsp" );
      }else{
          echo "<a id='move_page' href='gallery_list.php?mode=$mode&page=$dest_page&continent=$continent'> $dest_page </a>";
      }
  }
  #----------------이전페이지 존재시 링크------------------#
  if($next_page){
      echo "<a id='next_page' href='gallery_list.php?mode=$mode&page=$next_page&continent=$continent'> > </a>";
  }
  #---------------다음페이지를 링크------------------#
  if($total_pages >= $start_page+ $pages_scale){
      $go_page= $start_page+ $pages_scale;
      echo "<a id='next_block' href='gallery_list.php?mode=$mode&page=$go_page&continent=$continent'> >> </a>";
  }
    ?>
     

 	
     
     </div>
	
      		<div id="list_id">
				<a href="gallery_list.php?table=<?=$table?>&page=<?=$page?>"><img
					src="../img/list.png" style="float: right;"></a>
      
      <?php
    if (isset($id)) {
        
        ?>
      
		<a href="gallery_write_form.php?table=<?=$table?>&page=<?=$page?>&continent=<?=$continent?>"><img
					src="../img/write.png" style="float: right; padding-right: 15px;"></a>
      
      <?php
    }
    ?>
      </div>
		</article>

	</section>
	
	<footer>
       <?php include "../../common_lib/footer2.php"; ?> 
    </footer> 
</body>
</html>