<meta charset="UTF-8">
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
include_once '../../shopping_lib/create_table_shop_goods.php';

$sql= "select * from shop_goods where shop_type='화장품' order by regist_day desc";
$result= mysqli_query($con, $sql);
$total_record= mysqli_num_rows($result);

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

$number=$total_record- $start_row;

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>야! 몰</title>
  <link rel="stylesheet" href="../../common_css/shop_index_css3.css?ver=24">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../shopping/css/shopping3.css?ver=34">
  <link rel="stylesheet" href="../css/cart.css?ver=44">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <header style="border:1px solid black;">
   		<?php include_once '../../shopping_lib/top_login3.php';?>
    </header>
    <nav id="shop_aside">
    	<?php include_once '../../shopping_lib/shop_main_menu2.php';?>  	
    </nav>
	<div class="shop_section">
    	<section>
    		<div class="new_arrivals1"><b>BEST ITEMS</b></div>
    	</section>
    	<section>    
            <?php 
                $sql = "select * from shop_goods where shop_type='화장품' order by hit desc";
                $result = mysqli_query($con, $sql) or die(mysqli_error($con));
        
                for($i=1;$i<=3;$i++){
                    $row= mysqli_fetch_array($result);
                    $no= $row['shop_no'];
                    $name1=$row['shop_name'];
                    $price=$row['shop_price'];
                    $image=$row['shop_image_change_name1'];
//                     $image=$row['shop_image_change_name2'];
//                     $image=$row['shop_image_change_name3'];
//                     $image=$row['shop_image_change_name4'];
                    
//                     for($j=1; $j<5; $j++){
//                         if(!empty($image[$j])){ // 첫번째 이미지 파일이 있으면 1번 이미지를 보여줌
//                             $image = $image[$j];
//                             break;
//                         }
//                    }
            ?>
            	<a href="./view.php?no=<?=$no?>" id="product_a"> 
            	   	<div class="product">
            			<div class="product_img"><img src="../../input/upload_image/<?=$image?>" alt="../../input/upload_image/<?=$image?>" width="350px" height="400px"></div>
            			<div class="product_name"><b><?=$name1?></b></div><br>
            			<div class="product_price"><em>￦<?=$price?></em></div>
            		</div>
        		</a>
            <?php 
        
                }
            ?>
			<hr style="border: 2px solid lightgray; width: 1160px;">
  	    	<div style="height: 70px;"></div> 
            <?php 
                $sql = "select * from shop_goods where shop_type='화장품' order by regist_day desc";
                $result = mysqli_query($con, $sql) or die(mysqli_error($con));
                $total_record=mysqli_num_rows($result);
                if($total_record){
                    $page_per_record = 12;
                    $total_pages = ceil($total_record/$page_per_record);
                    $page_per_start = $page_per_record * ($page - 1);
                    for($i=$page_per_start; $i<$page_per_start+$page_per_record && $i<$total_record; $i++){
                        mysqli_data_seek($result,$i);
                        $row= mysqli_fetch_array($result);
                        $no= $row['shop_no'];
                        $name1=$row['shop_name'];
                        $price=$row['shop_price'];
                        $image=$row['shop_image_change_name1'];
        
            ?>
            	<a href="./view.php?no=<?=$no?>" id="product_a"> 
            	   	<div class="product">
            			<div class="product_img"><img src="../../input/upload_image/<?=$image?>" width="350px" height="400px"></div>
            			<div class="product_name"><b><?=$name1?></b></div><br>
            			<div class="product_price"><em>￦<?=$price?></em></div>
            		</div>
        		</a>
        		
            
            <?php 
                    }
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
                          echo( "<a href='./shop_cosmetics.php?page=$go_page'> << </a>" );
                      }else{
                          echo( " << " );
                      }
                    ?>
                    	</td>
                		<td width="30">
                	<?PHP 
                      #----------------이전페이지 존재시 링크------------------#
                      if( $pre_page ){
                          echo( "<a href='./shop_cosmetics.php?page=$pre_page'> < </a>" );
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
                          echo( "<a href='./shop_cosmetics.php?page=$dest_page'>$dest_page</a>" );
                          echo "</td>";
                      }
                      ?>
                		<td width="30">
                	<?PHP 
                      #----------------이전페이지 존재시 링크------------------#
                      if( $next_page ){
                          echo( "<a href='./shop_cosmetics.php?page=$next_page'> > </a>" );
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
                          echo( "<a href='./shop_cosmetics.php?page=$go_page'> >> </a>" );
                      }else{
                          echo( " >> " );
                      }
                    ?>
                    	</td>
                    </tr>
                </table>
                
    		</div>
    	</section> 
	</div>
	
    <div class="clear"></div>
	<footer style="border:1px solid black;">
 		<?php include_once '../../common_lib/footer2.php';?>
  	</footer>
</body>
</html>	
