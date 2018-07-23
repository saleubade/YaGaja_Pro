<?php
session_start();
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    $cname = $_SESSION['name'];
}else{
    $id=null;
}
if(isset($_GET['num'])){
    $num=$_GET['num'];
}


include_once '../../common_lib/createLink_db.php';
include_once '../../shopping_lib/create_table_buy.php';

$sql= "select * from buy_goods where buy_num='$num'";
$result= mysqli_query($con, $sql);
$total_record=mysqli_num_rows($result);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>야! 몰</title>
  <link rel="stylesheet" href="../../common_css/shop_index_css3.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../shopping/css/shopping3.css?ver=6">
  <link rel="stylesheet" href="../css/cart.css?ver=7">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="../css/member.css?ver=3" rel="stylesheet">
  <script type="text/javascript">
	function submit(){
		document.buy.action="insert.php?mode=modify&num=<?=$num?>";
		document.buy.submit();
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
    	<div id="wish_list_section">주문리스트
    		<div id="wish_list_section2"></div>
    	</div>
    </section>
    <section>
    	<div id="buy_section">
    		<form method="post" name="buy">
        		<table id="buy_list_table">
        			<tr>
        				<td class="prod_image">이미지</td>
        				<td class="prod_info">상품정보</td>
        				<td class="prod_price">판매가</td>
        				<td class="prod_baesong">배송비</td>
        				<td class="prod_total">합계</td>
        			</tr>
        	
        			<?php 
        			if($total_record){
        			    for($i=0; $i<$total_record; $i++){
        			        mysqli_data_seek($result,$i);
        			        $row=mysqli_fetch_array($result);
        			        $num=$row['buy_num'];
        			        $no=$row['buy_no'];
        			        $buy_id=$row['buy_id'];
        			        $name2=$row['buy_name'];
        			        $price=$row['buy_price'];
        			        $type=$row['buy_type'];
        			        $size=$row['buy_size'];
        			        $image=$row['buy_image_name'];
        			        $value=$row['buy_amount'];
        			        $total=$row['buy_total'];
        			        $state=$row['buy_state'];
        			        $message=$row['message'];
        			        $all_total= $all_total + $total;
        			        $total = $price * $value;
        			        $all_total=$total;
                            
                    ?>
        			<tr>
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
        				<td class="prod_baesong">
        					<select name="baesong">
        						<option value="ready">배송준비중</option>
        						<option value="during">배송중</option>
        						<option value="clear">배송완료</option>
        					</select>
        				</td>
        				<td class="prod_total"><?=$total?>,000원</td>
        			</tr>
        			<?php 
                        }
        			}
        			?>
        		</table>
    		
        		<hr width="1200px" border="3px solid black">
        		<?php 
        		  $sql="select * from membership where id='$buy_id'";
        		  $result=mysqli_query($con, $sql);
        		  $row=mysqli_fetch_array($result);
        		  $nick=$row['name'];
        		  $email=$row['email'];
        		  $zip=$row['zip'];
        		  
        		  $phone=$row['phone'];
        		  $phone=explode("-", $phone);
        		  $phone1=$phone[0];
        		  $phone2=$phone[1];
        		  $phone3=$phone[2];
        		  
        		  $address=$row['address'];
        		  $address=explode("/", $address);
        		  $address1=$address[0];
        		  $address2=$address[1];
        		  
        		  $email=explode("@", $email);
        		  $email_e=$email[0];
        		  $email_mail=$email[1];
        		?>
        	
               <div id="order_list">
                   	<table id="join_form_content" border=0 cellpadding=5 cellspacing=0 style="float: left;">
                    	<caption>
                    		<div id="join_form_title1"><b>주문정보</b></div>
                    	</caption>
                    	<tr>
                    		<td class="col1"> <font color="red"><b>*</b></font> 주문하시는분 </td>
                    		<td class="col2"> <input type="text" name="id" size="15" value="<?=$cname?>" >
                    		</td>
                    	</tr>
                    	<tr>
                    		<td class="col1"> <font color="red"><b>*</b></font> 우편번호</td>
                    		<td class="col2"> <input type="text" id="postcode" name="zip" placeholder="우편번호" value="<?=$zip?>">
                    		</td>
                    	</tr>
                    	<tr>
                    		<td class="col1" rowspan="2"> <font color="red"><b>*</b></font> 주소 </td>
                    		<td class="col2"> <input type="text" id="address1" name="address1" placeholder="주소" value="<?=$address1?>"></td> 
                    	</tr>
                    	<tr>
                    		<td class="col2"><input type="text" id="address2" name="address2" placeholder="나머지 주소" value="<?=$address2?>"></td>
                    	<tr>
                        <!--  -->
                    	
                    	<tr>
                    		<td class="col1"> <font color="red"><b>*</b></font> 연락처 </td>
                    		<td class="col2"> <input type="text" name="hp1" size="2" value="<?=$phone1?>"> - 
                    						<input type="text" name="hp2" size="3" value="<?=$phone2?>"> - 
                    						<input type="text" name="hp3" size="3" value="<?=$phone3?>">
                    		</td>
                    	</tr>
                    	<tr>
                    		<td class="col1"> <font color="red"><b>*</b></font> 이메일주소 </td>
                    		<td class="col2">
                    			<input type="text" name="email1" size="10"  value="<?=$email_e?>"> @ 
                    			<input type="text" name="email2" size="10"  value="<?=$email_mail?>"> 
                    		</td>
                    	</tr>
                    	<tr>
                    		<td class="col1">배송메세지</td>
                    		<td class="col2"><div><?=$message?></div></td>
                    	</tr>	
                	</table>
        		</div>
    		</form>	
    		<button onclick="submit()">완료</button>
    	</div>
    </section>
    <div class="clear"></div>
	<footer style="border-top:2px solid black;">
 		<?php include_once '../../common_lib/footer2.php';?>
  	</footer>
</body>
</html>    