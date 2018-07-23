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
  <link rel="stylesheet" href="../../common_css/shop_index_css3.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/shopping3.css?ver=3">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 700%;
      height : 550px;
      margin: auto;
  }
  </style>
  <script type="text/javascript">
  $(document).ready(function(){ 
	  $("#travel").click(function(){ 
		var type = 'travel';
	      if(type){
	         $.ajax({
   	        	type : "post",
  				url : "./image_view.php,"
  				data : "type="+type,
				success : function(data){
					$("#weekly_item_list").html(data);
               }
	         });
	      }
	   }
	});
 }	
  </script>
</head>
<body>
    <header style="border:1px solid black;">
   		<?php include_once '../../shopping_lib/top_login3.php';?>
    </header>
    <nav id="shop_aside">
    	<?php include_once '../../shopping_lib/shop_main_menu.php';?>  	
    </nav>
	
	<div class="shop_section">
	
    	<!-- 메인 슬라이드이미지 -->
    	<section>
    	 <div class="container">    
              <br>
              <div id="myCarousel" class="carousel slide" data-ride="carousel">
            
                <!-- Indicators -->
                <ol class="carousel-indicators">
                  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                  <li data-target="#myCarousel" data-slide-to="1"></li>
                </ol>
            
                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                  <div class="item active">
                    <img src="../../common_img/untitled.png" width="460" height="345">
                    <div class="carousel-caption"></div>
                  </div>
            
                  <div class="item">
                    <img src="../../common_img/untitled1.png" width="460" height="345">
                    <div class="carousel-caption"></div>
                  </div>
         
              
                </div>
            
                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
    	</section>

	<!-- 베스트아이템  -->
<!--  	<section id="weekly_item"> 
 		<div id="weekly_item1">weekly best item
 			<ul id="weekly_item_ul">
 				<li><a href="#" id="travel">&nbsp;&nbsp;TRAVEL&nbsp;&nbsp;</a></li>
 				<li onclick="view('acc')"><a id="acc">&nbsp;&nbsp;ACC&nbsp;&nbsp;</a></li>
 				<li onclick="view('clothe')"><a id="tb">&nbsp;&nbsp;TOP/BOTTOM&nbsp;&nbsp;</a></li>
 				<li onclick="view('cosmetics')"><a href="#" id="cosmetics">&nbsp;&nbsp;COSMETICS&nbsp;&nbsp;</a></li>
 			</ul>
 			<div id="weekly_item_list">
 				<div class="weekly_img">
 					<img src="">
 				</div>
 				<div class="weekly_img"></div>
 				<div class="weekly_img"></div>
 				<div class="weekly_img"></div>
 				<div class="weekly_img"></div>
 				<div class="weekly_img"></div>
 			</div>
 		</div>
 	</section>-->
	
	<!-- 보드판  -->
<!--  	<section id="board_item">  
 		<div id="board_item1">BOARD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 			<ul id="board_item_ul">
 				<li><a>&nbsp;&nbsp;QNA&nbsp;&nbsp;</a></li>
 				<li><a>&nbsp;&nbsp;REVIEW&nbsp;&nbsp;</a></li> 
 				<li><a>&nbsp;&nbsp;NOTICE&nbsp;&nbsp;</a></li> 
 			</ul> 
 		</div> 
 		<div id="board_table"></div> 
 	</section>-->
    <br><br> 
    <!-- 신상품 목록 -->
    
        <section>
		    <div id="new_arrivals">NEW ARRIVALS</div>
		</section>
		<section>    
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