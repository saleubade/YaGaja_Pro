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
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>야! 몰</title>
  <link rel="stylesheet" href="../../common_css/shop_index_css3.css?ver=2">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../shopping/css/shopping3.css?ver=3">
  <link rel="stylesheet" href="../css/cart.css?ver=5">
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
    		<div id="new_arrivals"><b>BEST ITEMS</b></div>
    	</section>
    	<section>    
            <?php 
                $sql = "select * from shop_goods order by hit desc";
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
    	</section><hr width="1160px" style="height: 30px;">
    	<section><br><br>    
    <?php 
        $sql = "select * from shop_goods order by regist_day desc";
        $result = mysqli_query($con, $sql) or die(mysqli_error($con));


        for($i=1;$i<13;$i++){
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
    ?>
    	</section>
	</div>
    <div class="clear"></div>
	<footer style="border:1px solid black;">
 		<?php include_once '../../common_lib/footer2.php';?>
  	</footer>
</body>
</html>	