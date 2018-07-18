<meta charset="UTF-8">
<?php
session_start();
include "../../common_lib/createLink_db.php";

$flag = "NO";
$sql = "show tables from yagajaDB";
$result = mysqli_query($con, $sql) or die("실패원인:".mysqli_error($con));
while($row=mysqli_fetch_row($result)){
    if($row[0]==="shop_goods"){
        $flag = "OK";
        break;
    }
}
if($flag !=="OK"){
    $sql = "create table shop_goods(
      shop_no int not null auto_increment,
      shop_name varchar(100) not null,
      shop_amount varchar(50) not null,
      shop_price varchar(50) not null,
      shop_type char(10) not null,
      shop_sizeS int,
      shop_sizeM int,
      shop_sizeL int,
      shop_sizeXL int,
      shop_image_name1 char(40),
      shop_image_name2 char(40),
      shop_image_name3 char(40),
      shop_image_name4 char(40),
      shop_image_change_name1 char(40),
      shop_image_change_name2 char(40),
      shop_image_change_name3 char(40),
      shop_image_change_name4 char(40),
      shop_introduce text,
      regist_day char(20),
      primary key(shop_no)
    )";
    if(mysqli_query($con, $sql)){
        echo "<script>
                alert('shop 테이블 생성성공!');
              </script>";
    }else{
        echo "<script>
                alert('shop 테이블 생성실패');
              </script>";
    }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>상품등록</title>
    <link rel="stylesheet" href="../../common_css/shop_index_css3.css">
    <link rel="stylesheet" href="../../shopping/css/shopping3.css?ver=11">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/input.css">
    <script>
      function check_input(){
        if(document.input_form.shop_type=="없음"){
          alert('상품타입을 선택하세요!');
          return;
        } 
        if(!document.input_form.shop_name.value){
          alert('상품명을 입력하세요!');
          document.input_form.shop_name.focus();
          return;
        }
        if(!document.input_form.shop_price.value){
          alert('가격을 입력하세요!');
          document.input_form.shop_price.focus();
          return;
        }
        if(document.input_form.shop_type.value == "의류"){
        	console.log(document.input_form.shop_type.value);
            document.input_form.submit();
        }else{
            if(!document.input_form.shop_amount.value){
              alert('개수를 입력하세요!');
              document.input_form.shop_amount.focus();
              return;
            }
            document.input_form.submit();
        }
       
      }

     	 $(document).ready(function(){     	   
     	   $("#shop_type").click(function(){
     	      
     	      var type = $("#shop_type").val();
     	      if(type){
     	         $.ajax({
         	        	type : "post",
        				url : "./shop_type_ajax1.php",
        				data : "type="+type,
    				success : function(data){
    					$("#size").html(data);
 	                }
     	         });
     	      }
     	   });
     	   
     	   $("#shop_type").click(function(){
     	      
     	      var type = $("#shop_type").val();
     	      if(type){
     	         $.ajax({
         	        	type : "post",
        				url : "./shop_type_ajax2.php",
        				data : "type="+type,
    				success : function(data){
    					$("#amount").html(data);
 	                }
     	         });
     	      }
     	   });
     	   
     	}); 

    	  
    </script>
  </head>
  <body>
    <header style="border:1px solid black;">
        <!-- 로그인  -->
   		<?php include_once '../../shopping_lib/top_login3.php';?>
    </header>
    <!-- 메뉴 -->
    <nav id="shop_aside">
    	<?php include_once '../../shopping_lib/shop_main_menu.php';?>  	
    </nav>
 <section id="shop_input_goods">
      <article class="main">
        <h1>상품등록</h1>
        <hr>
<form name="input_form" action="./input_db.php" method="post" enctype="multipart/form-data">
        <table style="border: 1px solid black;">
          <tr>
            <td class="label"><label for="shop_type">상품타입</label></td>
            <td>
              <select name="shop_type" id="shop_type">
                <option value="없음" selected>선택</option>
                <option value="화장품">화장품</option>
                <option value="악세서리">악세서리</option>
                <option value="의류">의류</option>
                <option value="여행용품">여행용품</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="label"><label for="shop_name1">상품명</label></td>
            <td><input  class="content" type="text" name="shop_name" id="shop_name1" size="5"></td>
          </tr>
          <tr>
            <td class="label"><label for="shop_price">가격</label></td>
            <td><input   class="content" type="text" name="shop_price" id="shop_price" size="5"></td>
          </tr>
          <tr>
          	<td class="label"><label for="shop_amount"><div id="amount">수량</div></label></td>
          	<td><div id="size"><input   class="content" type="text" id="shop_amount" name="shop_amount" size="3"></div></td>
          </tr>
          <tr>
            <td class="label"><label for="shop_image">이미지</label></td>
            <td>
            	<input   class="content" type="file" name="shop_image_name1" value="1">
            	<input   class="content" type="file" name="shop_image_name2">
            	<input   class="content" type="file" name="shop_image_name3">
            	<input   class="content" type="file" name="shop_image_name4">
            </td>
          </tr>
          <tr>
            <td  class="label"><label for="shop_introduce">상품소개</label></td>
            <td><textarea name="shop_introduce" rows="16" cols="127"></textarea></td>
          </tr>          
          <tr>
          	<td></td>
            <td style="text-align: right;"><a href="#"><img src="../image/ok.png" onclick="check_input()"></a></td>
          </tr>
        </table><br>


</form>
      </article>
    </section>
    <footer>
      <?php include "../../common_lib/footer2.php"; ?>
    </footer>
  </body>
</html>