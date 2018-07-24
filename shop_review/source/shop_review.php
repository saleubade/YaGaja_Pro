<?php
session_start();
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    $cname = $_SESSION['name'];
}else{
    $id=null;
}
include_once '../../common_lib/createLink_db.php';
include_once '../../shopping_lib/create_table_review.php';
if(!empty($_POST["review_text"])){
    $search =$_POST["review_text"];
}
if(!empty($_POST["review_select"])){
    $find =$_POST["review_select"];
}
if(!empty($_GET['mode'])){
    $mode = $_GET['mode'];
}

if ($mode=="search"){
    $search=trim($search);//공백 제거
    if(!$search){
        echo("
				<script>
				 window.alert('검색할 단어를 입력해 주세요!');
			     location.href = 'shop_review.php';
				</script>
			");
        exit;
    }
    $sql = "select * from shop_review where $find like '%$search%' order by review_no desc";
}
else{
    $sql= "select * from shop_review order by review_no desc";
}
$result= mysqli_query($con, $sql);
$total_record= mysqli_num_rows($result);
$row=mysqli_fetch_array($result);
$no=$row['review_no'];
$subject=$row['review_subject'];
$nick=$row['review_nick'];
$regist_day=$row['regist_day'];
$file_copied_0=$row['file_copied_0'];
$regist_day=substr($regist_day,0,10);
// 페이지 당 글수, 블럭당 페이지 수
$rows_scale=12;
$pages_scale=5;

// 전체 페이지 수 ($total_page) 계산
$total_pages= ceil($total_record/$rows_scale);

if(empty($page)){
    $page=1;
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

//리스트에 뿌려질 테이블 번호
$number=$total_record - ($page-1) * $rows_scale;
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>야! 몰</title>
  <link rel="stylesheet" href="../css/review.css?ver=3">
  <link rel="stylesheet" href="../../common_css/shop_index_css3.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../shopping/css/shopping3.css?ver=4">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
   		<?php include_once '../../shopping_lib/top_login3.php';?>
    </header>
    <nav id="shop_aside">
    	<?php include_once '../../shopping_lib/shop_main_menu.php';?>  	
    </nav>
    <section>
    	<div id="review">Review</div>
    </section>
    <section>
    	<div id="review_section">
    		<div id="review_kind">    	
        		<form  name="board_form" method="post" action="./shop_review.php?mode=search">		
    				<select name="review_select" id="review_select">
        				<option value="null">선택</option>
        				<option value="review_subject">제목</option>
        				<option value="review_nick">닉네임</option>
        				<option value="review_content">내용</option>
        			</select>
        			<input type="text" id="review_text" name="review_text">
                	<button id="kind_search">검색</button>
                </form>
    		</div>
    		<div id="review_section2">
    		<?php 
        			if($total_record){
        			    $page_per_record = 12;
        			    $total_pages = ceil($total_record/$page_per_record);
        			    $page_per_start = $page_per_record * ($page - 1);
        			    for($i=$page_per_start; $i<$page_per_start+$page_per_record && $i<$total_record; $i++){
        			        mysqli_data_seek($result,$i);
        			        $row=mysqli_fetch_array($result);
        			        $no=$row['review_no'];
        			        $subject=$row['review_subject'];
        			        $nick=$row['review_nick'];
        			        $file_copied_0=$row['file_copied_0'];
        			        $regist_day=$row['regist_day'];
        			       
        			 ?>
    			 	<a href="./view.php?no=<?=$no?>">
    			 		<div class="review_box">
            				<img src="../upload_image/<?=$file_copied_0?>" class="review_box_img">
            				<div class="review_box_product"><b><?=$subject?></b></div>
            				<div class="review_box_regist"><?=$regist_day?></div>
            			</div>
        			</a>
        			<?php 
        			       $number--;
        			    }
        			}
        			?>
            <br><br>
        </div>    			
            <div id="write_form">
    			<a href="./review_write_form.php?"><button class="review_write">글쓰기</button></a>
        	</div>
        		
        <br>		
    	<div id="page_link">
    			<table id="page_link_table">
                	<tr>
                		<td width="30">
                	<?PHP 
                      #----------------이전블럭 존재시 링크------------------#
                      if( $start_page > $pages_scale ){
                          $go_page= $start_page - $pages_scale;
                          echo( "<a href='./shop_review.php?page=$go_page'&mode=$mode> << </a>" );
                      }else{
                          echo( " << " );
                      }
                    ?>
                    	</td>
                		<td width="30">
                	<?PHP 
                      #----------------이전페이지 존재시 링크------------------#
                      if( $pre_page ){
                          echo( "<a href='./shop_review.php?page=$pre_page&mode=$mode'> < </a>" );
                      }else{
                          echo( " < " );
                      }
                    ?>
                    	</td>
                    <?php 
                      #--------------바로이동하는 페이지를 나열---------------#
                    for( $dest_page = $start_page; $dest_page <= $end_page; $dest_page++ )
                      if ( $dest_page == $page ){
                          echo "<td width='30' id='now_bluck'>";
                          echo( "&nbsp;<b>$dest_page</b>&nbsp" );
                          echo "</td>";
                    }else if(isset($end_page)){
                          echo "<td width='30'>";
                          echo( "<a href='./shop_review.php?page=$dest_page&mode=$mode'>$dest_page</a>" );
                          echo "</td>";
                      }
                      ?>
                		<td width="30">
                	<?PHP 
                      #----------------이전페이지 존재시 링크------------------#
                      if( $next_page ){
                          echo( "<a href='./shop_review.php?page=$next_page&mode=$mode'> > </a>" );
                      }else{
                          echo( " > " );
                      }
                    ?>
                    	</td>
                      	<td width="30">
                      <?php
                      #---------------다음페이지를 링크------------------#
                      if( $total_pages >= $start_page+ $pages_scale){
                          $go_page= $start_page+ $pages_scale;
                          echo( "<a href='./shop_review.php?page=$go_page&mode=$mode'> >> </a>" );
                      }else{
                          echo( " >> " );
                      }
                    ?>
                    	</td>
                    </tr>
                </table>
    		</div>
    	</div>
    </section>
    
    
	<div class="clear"></div><div class="clear"></div><div class="clear"></div>
	<footer style="border-top:2px solid black;">
 		<?php include_once '../../common_lib/footer2.php';?>
  	</footer>
</body>
</html>  