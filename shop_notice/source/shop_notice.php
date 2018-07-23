<?php
session_start();
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    $cname = $_SESSION['name'];
}else{
    $id=null;
}
include_once '../../common_lib/createLink_db.php';
include_once '../../shopping_lib/create_table_notice.php';
if(!empty($_POST["notice_text"])){
    $search =$_POST["notice_text"];
}
if(!empty($_POST["notice_select"])){
    $find =$_POST["notice_select"];
}
if ($mode=="search"){
    $search=trim($search);//공백 제거
    if(!$search){
        echo("
				<script>
				 window.alert('검색할 단어를 입력해 주세요!');
			     location.href = 'shop_notice.php';
				</script>
			");
        exit;
    }
    $sql = "select * from shop_notice where $find like '%$search%' order by notice_no desc";
}
else{
    $sql= "select * from shop_notice order by notice_no desc";
}
$result= mysqli_query($con, $sql);
$total_record= mysqli_num_rows($result);

// 페이지 당 글수, 블럭당 페이지 수
$rows_scale=10;
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
  <link rel="stylesheet" href="../css/notice.css?ver=1">
  <link rel="stylesheet" href="../../shopping/css/cart.css?ver=1">
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
    	<div id="notice">NOTICE</div>
    </section>
    <section>
    	<div id="notice_section">
    		<div id="notice_kind">    	
        		<form  name="board_form" method="post" action="./shop_notice.php?mode=search">		
    				<select name="notice_select" id="notice_select">
        				<option value="null">선택</option>
        				<option value="notice_subject">제목</option>
        				<option value="notice_nick">닉네임</option>
        				<option value="notice_content">내용</option>
        			</select>
        			<input type="text" id="notice_text" name="notice_text">
                	<button id="kind_search">검색</button>
                </form>
    		</div>
    		<div id="notice_table">
    			<table id="notice_table2">
    				<tr id="notice_table_tr">
    					<td class="notice_table_no">No</td>
    					<td class="notice_table_subject2">Subject</td>
    					<td class="notice_table_writer">Writer</td>
    					<td class="notice_table_date">Date</td>
    				</tr>
    				<?php 
        			if($total_record){
        			    $page_per_record = 10;
        			    $total_pages = ceil($total_record/$page_per_record);
        			    $page_per_start = $page_per_record * ($page - 1);
        			    for($i=$page_per_start; $i<$page_per_start+$page_per_record && $i<$total_record; $i++){
        			        mysqli_data_seek($result,$i);
        			        $row=mysqli_fetch_array($result);
        			        $no=$row['notice_no'];
        			        $subject=$row['notice_subject'];
        			        $nick=$row['notice_nick'];
        			        $regist_day=$row['regist_day'];
        			        $regist_day=substr($regist_day,0,10);
        			       
        			 ?>
        			 <tr class="notice_table_tr">
    					<td class="notice_table_no"><a href="./view.php?no=<?=$no?>"><?=$number?></a></td>
    					<td class="notice_table_subject"><a href="./view.php?no=<?=$no?>"><?=$subject?></a></td>
    					<td class="notice_table_writer"><?=$nick?></td>
    					<td class="notice_table_date"><?=$regist_day?></td>
    				</tr>	
        			<?php 
        			       $number--;
        			    }
        			}
        			?>
    			</table>
    		</div>
    		<?php 
    		if(isset($id)&&$id==="admin"){
    		?>
    		<div id="write_form">
    			<a href="./notice_write_form.php?"><button class="notice_write">글쓰기</button></a>
    		</div>
    		<?php 
    		}
    		?>
    		<div id="page_link">
    			<table id="page_link_table">
                	<tr>
                		<td width="30">
                	<?PHP 
                      #----------------이전블럭 존재시 링크------------------#
                      if( $start_page > $pages_scale ){
                          $go_page= $start_page - $pages_scale;
                          echo( "<a href='./shop_notice.php?page=$go_page'> << </a>" );
                      }else{
                          echo( " << " );
                      }
                    ?>
                    	</td>
                		<td width="30">
                	<?PHP 
                      #----------------이전페이지 존재시 링크------------------#
                      if( $pre_page ){
                          echo( "<a href='./shop_notice.php?page=$pre_page'> < </a>" );
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
                          echo( "<a href='./shop_notice.php?page=$dest_page'>$dest_page</a>" );
                          echo "</td>";
                      }
                      ?>
                		<td width="30">
                	<?PHP 
                      #----------------이전페이지 존재시 링크------------------#
                      if( $next_page ){
                          echo( "<a href='./shop_notice.php?page=$next_page'> > </a>" );
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
                          echo( "<a href='./shop_notice.php?page=$go_page'> >> </a>" );
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