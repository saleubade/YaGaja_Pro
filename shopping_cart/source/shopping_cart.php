<?php
session_start();
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    $cname = $_SESSION['name'];
}else{
    $id=null;
}
include_once '../../common_lib/createLink_db.php';
include_once '../../shopping_lib/create_table_cart.php';


$sql= "select * from cart_goods where cart_id='$id'";
$result= mysqli_query($con, $sql);
$total_record= mysqli_num_rows($result);

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

$number=$total_record- $start_row;

$row_length=87;

    
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
<script type="text/javascript">
	function all_check(){
		if($("#checkall").is(':checked')){
		      $("input[name='cart_list_check[]']").prop("checked",true);
		   }else{
		      $("input[name='cart_list_check[]']").prop("checked",false);
		}
	}
	function choice_delete(){
		var res = confirm('삭제하시겠습니까?');
		   if(res){
		   for(i=0 ; i<$("cart_list_check").length ; i++){
		      if($("cart_list_check")[i].checked == false){
		         $("cart_list_check")[i].disabled = true;
		      }
		   }
		   document.cart_choice_delete.action="./shopping_cart_delete.php?mode=choice&id=<?=$id?>";
		   document.cart_choice_delete.submit();
		   }
	}
	function all_delete() {
		document.cart_choice_delete.action="shopping_cart_delete.php?mode=all&id=<?=$id?>";
		document.cart_choice_delete.submit();
	}
	function single_delete(s) {
		document.cart_choice_delete.action="shopping_cart_delete.php?mode=single&id=<?=$id?>&cart_num="+s;
		document.cart_choice_delete.submit();
	}
	function order(){
		var res = confirm('구매하시겠습니까?');
		if(res){
			document.cart_choice_delete.action="../../shopping_buy/source/shopping_buy.php?mode=allorder&table=cart";
			document.cart_choice_delete.submit();
		}
	}
</script>
</head>
<body>
    <header>
   		<?php include_once '../../shopping_lib/top_login3.php';?>
    </header>
    <nav id="shop_aside">
    	<?php include_once '../../shopping_lib/shop_main_menu.php';?>  	
    </nav>
    <section>
    	<div id="wish_list_section">WISH LIST
    		<div id="wish_list_section2">관심상품</div>
    	</div>
    </section>
    <section>
    	<div id="cart_section">
    		<form method="post" name="cart_choice_delete">
        		<table id="cart_list_table">
        			<tr>
        				<td class="prod_check_box"><input type="checkbox" onclick="all_check()" id="checkall"></td>
        				<td class="prod_image">이미지</td>
        				<td class="prod_info">상품정보</td>
        				<td class="prod_price">판매가</td>
        				<td class="prod_baesong">배송비</td>
        				<td class="prod_total">합계</td>
        				<td class="prod)choice">선택</td>
        			</tr>
        	
        			<?php 
        			if($total_record){
        			    $page_per_record = 5;
        			    $total_pages = ceil($total_record/$page_per_record);
        			    $page_per_start = $page_per_record * ($page - 1);
        			    for($i=$page_per_start; $i<$page_per_start+$page_per_record && $i<$total_record; $i++){
        			        mysqli_data_seek($result,$i);
        			        $row=mysqli_fetch_array($result);
        			        $cart_num=$row['cart_num'];
        			        $cart_no=$row['cart_no'];
                            $cart_image=$row['cart_image_name'];        
                            $cart_name=$row['cart_name'];        
                            $cart_price=$row['cart_price'];        
                            $cart_amount=$row['cart_amount'];    
                            $cart_type=$row['cart_type'];
                            $cart_total=$row['cart_total'];        
                            $cart_size=$row['cart_size'];
                            $cart_total = $cart_total + 3;
                            
                    ?>
        			<tr>
        				<td class="prod_check_box"><input type="checkbox" name="cart_list_check[]" id="cart_list_check[]" value="<?=$cart_num?>"></td>
        				<td class="prod_image"><a href="../../shopping/source/view.php?no=<?=$cart_no?>"><img class="prod_image2" src="../../input/upload_image/<?=$cart_image?>"></a></td>
        				<td class="prod_info"><a href="../../shopping/source/view.php?no=<?=$cart_no?>"><b><?=$cart_name?></b><br>[옵션 : 
        				<?php 
        				if($cart_type == 'clothe')
        				{
        				?>(<?=$cart_size?>)/
        				<?php 
        				}
        				?><?=$cart_amount?>개]</a></td>
        				<td class="prod_price"><?=$cart_price?></td>
        				<td class="prod_baesong">배송비<br>3000원</td>
        				<td class="prod_total"><?=$cart_total?>,000원</td>
        				<td class="prod_choice">
        					<button id="cart_delete" onclick="single_delete(<?=$cart_num?>)">삭제하기</button>
        				</td>
        			</tr>
        			<?php 
                        }
        			}
        			?>
        		</table>
    		
    		<div id="cart_button">
    			<button id="choice_del" onclick="choice_delete()">선택삭제</button>
    			<button id="all_order" onclick="order()">전체상품주문</button>
    			<button id="all_del" onclick="all_delete()"">장바구니비우기</button>
    		</div>
    	</form>	
    		<div id="page_link">
    			<table id="page_link_table">
                	<tr>
                		<td width="30">
                    	<?PHP 
                          #----------------이전블럭 존재시 링크------------------#
                          if( $start_page > $pages_scale ){
                              $go_page= $start_page - $pages_scale;
                              echo( "<a href='./shopping_cart.php?page=$go_page'> << </a>" );
                          }else{
                              echo( " << " );
                          }
                        ?>
                        	</td>
                    		<td width="30">
                    	<?PHP 
                          #----------------이전페이지 존재시 링크------------------#
                          if( $pre_page ){
                              echo( "<a href='./shopping_cart.php?page=$pre_page'> < </a>" );
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
                              echo( "<a href='./shopping_cart.php?page=$dest_page'>$dest_page</a>" );
                              echo "</td>";
                          }
                          ?>
                    		<td width="30">
                    	<?PHP 
                          #----------------이전페이지 존재시 링크------------------#
                          if( $next_page ){
                              echo( "<a href='./shopping_cart.php?page=$next_page'> > </a>" );
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
                              echo( "<a href='./shopping_cart.php?page=$go_page'> >> </a>" );
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