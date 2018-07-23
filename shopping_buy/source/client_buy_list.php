<?php
session_start();

include_once '../../common_lib/createLink_db.php';
include_once '../../shopping_lib/create_table_buy.php';
if(!empty($_POST["review_select"])){
    $find =$_POST["review_select"];
}
if(!empty($_POST["review_text"])){
    $search =$_POST["review_text"];
}
if ($mode=="search"){
    $search=trim($search);//공백 제거
    if(!$search){
        echo("
				<script>
				 window.alert('검색할 단어를 입력해 주세요!');
			     location.href = 'client_buy_list.php';
				</script>
			");
        exit;
    }
    $sql = "select * from buy_goods where $find like '%$search%' order by regist_day desc";
}
else{
    $sql= "select * from buy_goods where buy_id='$id' order by regist_day desc";
}
$result= mysqli_query($con, $sql);
$total_record=mysqli_num_rows($result);

// 페이지 당 글수, 블럭당 페이지 수
$rows_scale=5;
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

$number=$total_record - ($page-1) * $rows_scale;



?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>야! 몰</title>
  <link rel="stylesheet" href="../../common_css/shop_index_css3.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../shopping/css/shopping3.css?ver=6">
  <link rel="stylesheet" href="../css/cart.css?ver=6">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="../css/member.css?ver=3" rel="stylesheet">
</head>
<body>
    <header>
   		<?php include_once '../../shopping_lib/top_login3.php';?>
    </header>
    <nav id="shop_aside">
    	<?php include_once '../../shopping_lib/shop_main_menu.php';?>  	
    </nav>
    <section>
    	<div id="wish_list_section">구매내역
    		<div id="wish_list_section2"></div>
    	</div>
    </section>
    <section>
    	<div id="buy_section">
    		<div id="review_kind">    	
        		<form  name="board_form" method="post" action="./client_buy_list.php?mode=search">		
    				<select name="review_select" id="review_select">
        				<option value="null">선택</option>
        				<option value="buy_name">상품명</option>
        				<option value="buy_id">닉네임</option>
        				<option value="buy_state">배송상태</option>
        			</select>
        			<input type="text" id="review_text" name="review_text">
                	<button id="kind_search">검색</button>
                </form>
    		</div>
        		<table id="buy_list_table">
        			<tr>
        				<td class="prod_check_box">no</td>
        				<td class="prod_image">이미지</td>
        				<td class="prod_info">상품정보</td>
        				<td class="prod_price">판매가</td>
        				<td class="prod_baesong">배송상태</td>
        				<td class="prod_total">합계</td>
        			</tr>
        			<?php 
        			if($total_record){
        			    $page_per_record = 5;
        			    $total_pages = ceil($total_record/$page_per_record);
        			    $page_per_start = $page_per_record * ($page - 1);
        			    for($i=$page_per_start; $i<$page_per_start+$page_per_record && $i<$total_record; $i++){
        			        mysqli_data_seek($result,$i);
        			        $row=mysqli_fetch_array($result);
        			        $no=$row['buy_no'];
                            $name2=$row['buy_name'];        
                            $price=$row['buy_price'];        
                            $type=$row['buy_type'];
                            $size=$row['buy_size'];
                            $image=$row['buy_image_name'];
                            $value=$row['buy_amount'];
                            $total=$row['buy_total'];        
                            $state=$row['buy_state'];        
                            $all_total= $all_total + $total;
                            $total = $price * $value;
                            $all_total=$total;
                            
                    ?>
        			<tr>
        				<td class="prod_check_box"><?=$number?></td>
        				<td class="prod_image"><a href="../../shopping/source/view.php?no=<?=$no?>"><img class="prod_image2" src="../../input/upload_image/<?=$image?>"></a></td>
        				<td class="prod_info"><a href="../../shopping/source/view.php?no=<?=$no?>"><b><?=$name2?></b><br>[옵션 : 
        				<?php 
        				if($type == 'clothe')
        				{
        				?>(<?=$size?>)/
        				<?php 
        				}
        				?><?=$value?>개]</a></td>
        				<td class="prod_price"><?=$price?>원</td>
    					<?php 
    					if($state == "ready"){
    					?>
        				<td class="prod_baesong">배송준비중<br>	</td>
        				<?php 
    					}else if($state == "during"){
        				?>
        				<td class="prod_baesong">배송중<br></td>
        				<?php 
    					}else{
        				?>
        				<td class="prod_baesong">배송완료<br>	<a href="../../shop_review/source/shop_review.php"><button id="review">구매후기</button></a></td>
        				<?php 
    					}
        				?>		
        				<td class="prod_total"><?=$total?>,000원</td>
        			</tr>
        			<?php 
        			    $number--;
                        }
        			}
        			?>
        		</table>  
        		<div id="page_link">
    			<table id="page_link_table">
                	<tr>
                		<td width="30">
                    	<?PHP 
                          #----------------이전블럭 존재시 링크------------------#
                          if( $start_page > $pages_scale ){
                              $go_page= $start_page - $pages_scale;
                              echo( "<a href='./client_buy_list.php?page=$go_page'> << </a>" );
                          }else{
                              echo( " << " );
                          }
                        ?>
                        	</td>
                    		<td width="30">
                    	<?PHP 
                          #----------------이전페이지 존재시 링크------------------#
                          if( $pre_page ){
                              echo( "<a href='./client_buy_list.php?page=$pre_page'> < </a>" );
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
                              echo( "<a href='./client_buy_list.php?page=$dest_page'>$dest_page</a>" );
                              echo "</td>";
                          }
                          ?>
                    		<td width="30">
                    	<?PHP 
                          #----------------이전페이지 존재시 링크------------------#
                          if( $next_page ){
                              echo( "<a href='./client_buy_list.php?page=$next_page'> > </a>" );
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
                              echo( "<a href='./client_buy_list.php?page=$go_page'> >> </a>" );
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