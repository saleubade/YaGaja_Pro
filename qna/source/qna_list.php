<?php
/*
 *  QnA 테이블을 만듬.
 *  검색기능이있다.
 *  리플이 있을 시 
 *   
 *   */
session_start();
include_once "../../common_lib/createLink_db.php";
include_once "./create_qna.php";


if(isset($_GET['mode']) && $_GET['mode']=="search"){
    $find= $_GET['find'];
    $search= $_GET['search'];
    $sql= "select * from qna where $find like '%$search%' order by num desc";
}else{
    $sql= "select * from qna order by gno desc, depth asc";
}

$result3= mysqli_query($con, $sql) or die(mysqli_error($con));
$total_record=mysqli_num_rows($result3);

// 페이지 당 글수, 블럭당 페이지 수
$rows_scale=5;
$pages_scale=5;

// 전체 페이지 수 ($total_page) 계산
$total_pages= ceil($total_record/$rows_scale);

if(empty($_GET['page'])){
    $page = 1;
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

//제목 길이를 줌.
$row_length=30;

?>

<html>
<head>
	<meta charset=utf-8>
	<title>야 ~ 가자!</title>
	<link rel="stylesheet" href="../css/qna.css?ver=2" type="text/css">
    <link rel="stylesheet" href="../../common_css/index_css3.css">
  
	<script>
		function check_search(){
			if(!document.search_form.search.value){
				alert("검색어를 입력하세요");
				return ;
			}
			document.search_form.submit();
		}

	</script>
</head>
<body>
	<header>
		<?php include "../../common_lib/top_login2.php"; ?>
	</header>
	<nav id='top'>
		<?php include "../../common_lib/main_menu2.php"; ?>
	</nav>
	<section id="section">
		<article class="main">
			<div id="head" >
    			<div style="text-align: left;"><h1>Q & A</h1></div>
    			
    			<form id="search_area" name="search_form" method="get" action="qna_list.php">
    				<input type="hidden" name="mode" value="search">
    				<div style="text-align: right;">
    				<select name="find">
    					<option value="subject" <?php if(isset($find) && $find==="subject") echo "selected";?>>제목</option>
    					<option value="id" <?php if(isset($find) && $find==="id") echo "selected";?>>글쓴이</option>
    					<option value="content" <?php if(isset($find) && $find==="content") echo "selected";?>>내용</option>
    				</select> 
    				<input type="text" name="search" size="12"  autofocus <?php if(isset($search)) echo "value='$search'";?>>
    				<a href="#"><img src="../../community/img/list_search_button.gif" style="vertical-align: middle; float: right;" width="50" onclick="check_search()"></a>
    			</div>
    			</form>
    			<div class="clear"></div>
			</div>
			<hr>

    			<table id="qna_table" border="0" cellspacing="2" cellpadding="1">
    				<tr align="center" bgcolor="#d6e3ce">
    					<th width="70">번호</th>
    					<th height="30" colspan="3" width="640">제목</th>
    					<th width="150">글쓴이</th>
    					<th width="150">게시일</th>
    					<th width="50">조회수</th>
    				</tr>
    				<?php 
    				if($total_record==0){
    				    echo "
                        <tr><td colspan='6' align='center' height='50'> 게시물이 없습니다. </td></tr>
                            ";
    				}else{
        				for($i=$start_row; ($i<$start_row+$rows_scale) && ($i< $total_record); $i++){
        				    mysqli_data_seek($result3, $i);
        				    
        				    $row= mysqli_fetch_array($result3);
        				    
        				    $num= $row['num'];
        				    $subject= $row['subject'];
        				    if ( strlen( $subject ) > $row_length ){
        				        $subject = substr( $subject, 0, $row_length )."...";
        				    }
        				    $item_id= $row['id'];
        				    $regist_day= substr($row['regist_day'], 0, 10);
        				    $hit= $row['hit'];
        				    $depth= $row['depth'];
        				    $rep="";
        				    if(strlen($depth)>1){
            				    for($j=0; $j < strlen($depth)-1; $j++){
            				        $rep.="&nbsp;&nbsp;&nbsp;";
            				    }
            				    $rep.="└ ";
        				    }
        				    echo "
                    <tr>
                        <td align='center'>$number</td>
                            ";
        				    if(($id!==$item_id && $id!=="admin") && $row['secret_ok']==="y"){
            				        echo "
                        <td width='40'><td>
                        <td height='50' width='600'>$rep <img src='../img/lock.png' width=15 height=15> 비공개 글입니다.</a></td>
                                    ";
        				    }else{
        				        echo "
                        <td width='40'><td>
                        <td height='50' width='600'><a href='qna_view.php?num=$num&page=$page'>$rep $subject</a></td>
                                ";
        				    }
        				    echo "
                        <td align='center' width='150'>$item_id</td>
                        <td align='center' width='150'>$regist_day</td>
                        <td align='center' width='50'>$hit</td>
                    </tr>
                    <tr bgcolor='#cccccc'>
                        <td colspan='7'></td>
                    </tr>
                            ";
        				    $number--;
        				}
    				}
    				?>
				</table>
				<form name="page_form" method="get" action="qna_list.php">
								<table id="page_link_table" border="0">
					<tr>
						<td width="30">
					<?PHP 
                      #----------------이전블럭 존재시 링크------------------#
                      if( $start_page > $pages_scale ){
                          $go_page= $start_page - $pages_scale;
                          if(isset($_GET['mode']) && $_GET['mode']=="search"){
                            echo( "<a href='qna_list.php?mode=search&find=$find&search=$search&page=$go_page'> << </a>" );
                          }else{
                            echo "<a href='qna_list.php?page=$go_page'> << </a>";
                          }
                      }
                    ?>
                    	</td>
						<td width="20">
					<?PHP 
                      #----------------이전페이지 존재시 링크------------------#
                      if( $pre_page ){
                          if(isset($_GET['mode']) && $_GET['mode']=="search"){
                            echo( "<a href='qna_list.php?mode=search&find=$find&search=$search&page=$pre_page'> < </a>" );
                          }else{
                              echo "<a href='qna_list.php?page=$pre_page'> < </a>";
                          }
                      }
                    ?>
                    	</td>
                    <?php 
                      #--------------바로이동하는 페이지를 나열---------------#
                      echo "<td>";
                      for( $dest_page = $start_page; $dest_page <= $end_page; $dest_page++ )
                        if ( $dest_page == $page ){
                          echo( "&nbsp;$dest_page&nbsp" );
                        }else{
                            if(isset($_GET['mode']) && $_GET['mode']=="search"){
                                echo( "<a href='qna_list.php?mode=search&find=$find&search=$search&page=$dest_page'>[$dest_page]</a>" );
                            }else{
                                echo "<a href='qna_list.php?page=$dest_page'>[$dest_page]</a>";
                            }
                        }
                      echo "</td>";
                      ?>
						<td width="20">
					<?PHP 
                      #----------------이전페이지 존재시 링크------------------#
                      if( $next_page ){
                          if(isset($_GET['mode']) && $_GET['mode']=="search"){
                              echo( "<a href='qna_list.php?mode=search&find=$find&search=$search&page=$next_page'> > </a>" );
                          }else{
                              echo "<a href='qna_list.php?page=$next_page'> > </a>";
                          }
                      }
                    ?>
                    	</td>
                      	<td width="30">
                      <?php
                      #---------------다음페이지를 링크------------------#
                      if( $total_pages >= $start_page+ $pages_scale){
                          $go_page= $start_page+ $pages_scale;
                          if(isset($_GET['mode']) && $_GET['mode']=="search"){
                              echo( "<a href='qna_list.php?mode=search&find=$find&search=$search&page=$go_page'> >> </a>" );
                          }else{
                              echo "<a href='qna_list.php?page=$go_page'> >> </a>";
                          }
                      }
                    ?>
                    	</td>
                    </tr>
				</table>
				</form>
				<div id="buttons">
					<div id="write"><a href="qna_input_form.php?page=<?=$page?>"><img src="../img/write.png"></a></div>
				<div id="list"><a href="qna_list.php"><img src="../img/list.png" style="width: 57px; height: 27px;"></a></div>
					<div class="clear"></div>
				</div>
				<br>
		</article>
	</section>
    <footer>
      <?php include "../../common_lib/footer2.php"; ?>
    </footer>
</body>
</html>