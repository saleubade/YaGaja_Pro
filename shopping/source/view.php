<?php
session_start();
include_once '../../common_lib/createLink_db.php';
if(isset($_GET['no']))
{
    $no=$_GET['no'];
}
else 
{
    $no="";
    echo "<script>alert('실패');</script>";
}


$sql = "select * from shop_goods where shop_no=$no";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);

$shop_name = $row['shop_name'];
$price = $row['shop_price'];
$type=$row['shop_type'];
$image = $row['shop_image_change_name1'];
$sizeS = $row['sizeS'];
$sizeM = $row['sizeM'];
$sizeL = $row['sizeL'];
$sizeXL = $row['sizeXL'];

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
  <title>야! 가자~</title>
  <link rel="stylesheet" href="../../common_css/shop_index_css3.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/shopping3.css?ver=133">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="js/set_action.js"></script>
  <script>
  	 function check_input(e){
  		var e1 = e;
        var type = '<?=$type?>';  
        var size = $("#choice").val();
        var value2 = $("#value2").val();
        var value = $("#value").val();
        if(type== "의류"){
        	if(size=="없음"){
                alert('상품사이즈를 선택하세요!');
                return;
            } 
        	if(!value2){
                alert('개수를 입력하세요!');
                return;
            }
            if(e == "카트")
            {
                if(confirm("장바구니에 추가 하시겠습니까??"))
                {   
                	location.href="../../shopping_cart/source/shopping_cart_input.php?no=<?=$no?>&size="+size+"&value2="+value2;                	
                }
                else
                {
                    return;
                }
            }
            else
            {
            	if(confirm("구매하시겠습니까??"))
                {   
            		location.href="../../shopping_buy/source/shopping_buy.php?no=<?=$no?>&size="+size+"&value2="+value2;
                }
                else
                {
                    return;
                }
            }
        }else{
            if(!value){
              alert('개수를 입력하세요!');
              return;
            }
            if(e == "카트")
            {
                if(confirm("장바구니에 추가 하시겠습니까??"))
                {   
                	location.href="../../shopping_cart/source/shopping_cart_input.php?no=<?=$no?>&value="+value;
                }
                else
                {
                    return;
                }
            }
            else
            {
            	if(confirm("구매하시겠습니까??"))
                {   
            		location.href="../../shopping_buy/source/shopping_buy.php?no=<?=$no?>&value="+value;
                }
                else
                {
                    return;
                }
            }
        }
      }
  </script>
  </head>
<body>
    <header style="border:1px solid red;">
   		<?php include_once '../../shopping_lib/top_login3.php';?>
    </header>
    <nav id="shop_aside">
    	<?php include_once '../../shopping_lib/shop_main_menu.php';?>  	
    </nav>
    <div class="shop_section">
        <form id="myForm" method="post" name="input_form">
            <section>
            	<div id="view_img"><img src="../../input/upload_image/<?=$image?>" class="img"></div>
            </section>
            <section>
            	<div id="view_section">
            		<div id="view_name"><b><?=$shop_name?></b></div><br><br>
            		<div id="view_price">판매가&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;￦<?=$price?></div>
        		<?php
            		if($type == "의류")
            		{
        		?>
            		<div id="view_size">size&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            			<select name="choice" id="choice">
            				<option value="없음" selected>--필수--</option>
            				<option value="s">S</option>
            				<option value="m">M</option>
            				<option value="l">L</option>
            				<option value="xl">XL</option>
            			</select>	
            		</div>
        		<?php 
            		}
            		else 
            		{
        		?>
            		<div id="view_amount">수량&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            			<input type="number" min="1" name="value" id="value" class="number_value">
            		</div><br><br><br>
            		<?php 
            		}
            		?>
            		
            		<div id="view_table">
            			<table border="1">
            				<tr>
            					<td class="td1"><b>Product Name</b></td>
            					<td class="td2"><b>Amount</b></td>
            					<td class="td3"><b>Total</b></td>
            				</tr>
            				<?php 
            				if($type != "의류")
            				{
            				?>
            				
            				<tr>
            					<td class="td4"><div id="product1"></div></td>
            					<td class="td5"><div id="product2"></div></td>
            					<td class="td6"><div id="product3"></div></td>
            				</tr>
            				<?php 
            				}
            			    else 
            			    {
            				?>
            				<tr>
    							<td class='td4'><div class='product4'></div></td>
             					<td class='td5'>
             						<div class='product5'>
             							<input type="number" min="1" name="value2" id="value2" value="1" class="number_value">
             						</div>
             					</td>
             					<td class='td6'><div class='product6'></div></td>
            				</tr>
            				<?php
            				}
            				?>
            				<tr>
            					<td></td>
            					<td></td>
            					<td><b><em>TOTAL</em> ￦<span id="product_total">0</span>원</b></td>
            				</tr>
            			</table>
            			<script>
    
                         		 $(document).ready(function(){
                         			$(".product4").hide();
    								$(".product5").hide();
    								$(".product6").hide(); 
    
    								/* 의류가 아닌 상품 개수를 설정했을때 */
                        			$("#value").click(function(){
                        				var name = '<?=$shop_name?>';
                        				var value = $("#value").val();	
                        				var price = parseInt('<?=$price?>');
                        				var total =  price * value;
                        				var total = total + ",000";
                        				$("#product1").html(name);
                        				$("#product2").html(value);
                        				$("#product3").html(total);
                        				$("#product_total").html(total);
                        			});
    
                        			/* 의류인 상품 개수를 설정했을때 */
                        			$("#value2").click(function(){
                        				var size = $("#choice").val();
                        				var name = '<?=$shop_name?>'+"("+size+")";
                        				var value2 = $("#value2").val();
                        				var price = parseInt('<?=$price?>');
                        				var total =  price * value2;
                        				var total = total + ",000";
                        				$(".product4").html(name);
    									$(".product6").html(total);
    									$("#product_total").html(total);
                            		});
    
                        			/* 의류인 상품 사이즈를 클릭했을때*/
                        			$("#choice").click(function(){
    									var size = $("#choice").val();
    									var name = '<?=$shop_name?>'+"("+size+")";
    									var price = parseInt('<?=$price?>');
    									var value2 = $("#value2").val();
                        				var total =  price * value2;
                        				var total = total + ",000";
    									$(".product4").show();
    									$(".product5").show();
    									$(".product6").show();
    									$(".product4").html(name);
    									$(".product6").html(price+",000");
    									$("#product_total").html(total);
                        			});
    
                        		});
                        	
                       	</script>
            		</div>
                        <section>
                        <input type="button" value="WISH LIST" id="cart_input" onclick="check_input('카트')">
                        	<div class="clear"></div>
                        	<input type="button" value="BUY NOW" id="product_buy" onclick="check_input('구매')">
                        </section>	
            	</div>
            </section>
        </form>
    </div>
    
    <div class="clear"></div>
    <div class="clear"></div>
	<footer style="border:1px solid black;">
 		<?php include_once '../../common_lib/footer2.php';?>
  	</footer>
</body>
</html>    