<?php
session_start();
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    $cname = $_SESSION['name'];
}else{
    $id=null;
}
if(isset($_GET['no'])){
    $no=$_GET['no'];
}
if(isset($_GET['size'])){
    $size=$_GET['size'];
}
if(isset($_GET['value'])){
    $value=$_GET['value'];
}
if(isset($_GET['mode'])){
    $mode=$_GET['mode'];
}
if(isset($_GET['table'])){
    $table=$_GET['table'];
}


include_once '../../common_lib/createLink_db.php';
include_once '../../shopping_lib/create_table_buy.php';
if($mode == "allorder"){
    $sql= "select * from cart_goods where cart_id='$id'";
}else{
    $sql= "select * from shop_goods where shop_no='$no'";
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
  <link rel="stylesheet" href="../../shopping/css/shopping3.css?ver=5">
  <link rel="stylesheet" href="../css/cart.css?ver=5">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="../css/member.css?ver=3" rel="stylesheet">
  <script type="text/javascript">
	function all_check(){
		if($("#checkall").is(':checked')){
		      $("input[name='buy_list_check[]']").prop("checked",true);
		   }else{
		      $("input[name='buy_list_check[]']").prop("checked",false);
		}
	}
	function choice_delete(){
		var res = confirm('삭제하시겠습니까?');
		   if(res){
		   for(i=0 ; i<$("buy_list_check").length ; i++){
		      if($("buy_list_check")[i].checked == false){
		         $("buy_list_check")[i].disabled = true;
		      }
		   }
		   document.buy.action="../../shopping_cart/source/shopping_cart_delete.php?mode=choice&id='<?=$id?>'&buy=y";
		   document.buy.submit();
		   }
	}
	function check_email(){
		window.open("check_email.php", "IDEmail", "left=200, top=200, width=420, height=350, scrollbars=no, resizable=yes");
	}
	function check_exp(elem, exp, msg){
		if(!elem.value.match(exp)){
			alert(msg);
			return true;
		}
	}
	function check_input(){
		if(!document.buy.id.value){
			alert("보내시는분을 입력해주세요");
			document.buy.id.focus();
			return ;
		}
		if(!document.buy.zip.value){
			alert("주소를 선택해주세요");
			document.buy.zip.focus();
			return ;
		}
		
		if(!document.buy.address1.value){
			alert("주소를 입력해주세요");
			document.buy.address1.focus();
			return ;
		}
		if(!document.buy.address2.value){
			alert("주소를 입력해주세요");
			document.buy.address2.focus();
			return ;
		}
		// 연락처 검사
		var exp_hp1= /^0[1-9][0-9]?$/;
		var exp_hp2= /^[0-9]{4}$/;
		if(!document.buy.hp1.value){
			alert("연락처를 입력해주세요");
			document.buy.hp1.focus();
			return ;
		}			
		if(!document.buy.hp2.value){
			alert("연락처를 입력해주세요");
			document.buy.hp2.focus();
			return ;
		}			
		if(!document.buy.hp3.value){
			alert("연락처를 입력해주세요");
			document.buy.hp3.focus();
			return ;
		}
		if(check_exp(document.buy.hp1, exp_hp1, "연락처를 정확히 입력해주세요!")){
			document.buy.hp1.focus();
			document.buy.hp1.select();
			return ;
		}
		if(check_exp(document.buy.hp2, exp_hp2, "연락처를 정확히 입력해주세요!")){
			document.buy.hp2.focus();
			document.buy.hp2.select();
			return ;
		}
		if(check_exp(document.buy.hp3, exp_hp2, "연락처를 정확히 입력해주세요!")){
			document.buy.hp3.focus();
			document.buy.hp3.select();
			return ;
		}
		if(!$(pay_check).is(":checked")){
			alert("구매동의를 해주세요");
			return ;
		}else{
			var mode = '<?=$mode?>';
			if(mode == "order"){
				document.buy.action="./shopping_buy_insert.php?no="+'<?=$no?>'+"&value="+'<?=$value?>'+"&mode="+'<?=$mode?>'+"&size="+'<?=$size?>';
    			document.buy.submit();
			}else{
				document.buy.action="./shopping_buy_insert.php?mode="+'<?=$mode?>';
    			document.buy.submit();
			}
		}
	}
	
  </script>
  	<!-- 우편번호 검색API -->
	<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
	<script>
        function execDaumPostcode() {
            new daum.Postcode({
                oncomplete: function(data) {
                    // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
    
                    // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                    // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                    var fullAddr = ''; // 최종 주소 변수
                    var extraAddr = ''; // 조합형 주소 변수
    
                    // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                    if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                        fullAddr = data.roadAddress;
    
                    } else { // 사용자가 지번 주소를 선택했을 경우(J)
                        fullAddr = data.jibunAddress;
                    }
    
                    // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
                    if(data.userSelectedType === 'R'){
                        //법정동명이 있을 경우 추가한다.
                        if(data.bname !== ''){
                            extraAddr += data.bname;
                        }
                        // 건물명이 있을 경우 추가한다.
                        if(data.buildingName !== ''){
                            extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                        }
                        // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                        fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                    }
    
                    // 우편번호와 주소 정보를 해당 필드에 넣는다.
                    document.getElementById('postcode').value = data.zonecode; //5자리 새우편번호 사용
                    document.getElementById('address1').value = fullAddr;
    
                    // 커서를 상세주소 필드로 이동한다.
                    document.getElementById('address2').focus();
                }
            }).open();
        }
    </script>
	<!-- end of 우편번호 검색API -->
</head>
<body>
    <header style="border:1px solid black;">
   		<?php include_once '../../shopping_lib/top_login3.php';?>
    </header>
    <nav id="shop_aside">
    	<?php include_once '../../shopping_lib/shop_main_menu.php';?>  	
    </nav>
    <section>
    	<div id="wish_list_section">주문서 작성
    		<div id="wish_list_section2"></div>
    	</div>
    </section>
    <section>
    	<div id="buy_section">
    		<form method="post" name="buy">
        		<table id="buy_list_table">
        			<tr>
        				<td class="prod_check_box"><input type="checkbox" onclick="all_check()" id="checkall"></td>
        				<td class="prod_image">이미지</td>
        				<td class="prod_info">상품정보</td>
        				<td class="prod_price">판매가</td>
        				<td class="prod_baesong">배송비</td>
        				<td class="prod_total">합계</td>
        			</tr>
        	
        			<?php 
        			if($total_record){
        			    $page_per_record = 5;
        			    $total_pages = ceil($total_record/$page_per_record);
        			    $page_per_start = $page_per_record * ($page - 1);
        			    for($i=0;  $i<$total_record; $i++){
        			        mysqli_data_seek($result,$i);
        			        $row=mysqli_fetch_array($result);
        			        $num=$row[''.$table.'_num'];
        			        $no=$row[''.$table.'_no'];
                            $name2=$row[''.$table.'_name'];        
                            $price=$row[''.$table.'_price'];        
                            $type=$row[''.$table.'_type'];
                            if ($row[''.$table.'_size']){
                                $size=$row[''.$table.'_size'];
                            }
        			        if($table == 'cart'){
                                $image=$row[''.$table.'_image_name'];
                                $value=$row[''.$table.'_amount'];
                                $total=$row[''.$table.'_total'];        
                                $all_total= $all_total + $total;
        			        }else{
                                $image=$row[''.$table.'_image_change_name1'];
                                $total = $price * $value;
                                $all_total=$total;
        			        }
                            
                    ?>
        			<tr>
        				<td class="prod_check_box"><input type="checkbox" name="buy_list_check[]" id="buy_list_check[]" value="<?=$num?>"></td>
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
        				<td class="prod_baesong">유료<br></td>
        				<td class="prod_total"><?=$total?>,000원</td>
        			</tr>
        			<?php 
                        }
        			}
        			?>
        		</table>
    		
        		<div id="buy_button">
        			<button id="choice_del" onclick="choice_delete()">선택삭제</button>
        			<div id="order_total">상품구매금액 <?=$all_total?>,000원 + 배송비 3000원 (유료) = 합계 : <b id="total_value"><?=$all_total + 3?>,000원</b></div>
        		</div>
        		<hr width="1200px" border="3px solid black">
        		<?php 
        		  $sql="select * from membership where id='$id'";
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
                    			<a href="#"><img src="../image/btn_jusogo.gif" onclick="execDaumPostcode()" style="margin-left: 8px; vertical-align: middle;" ></a>
                    		</td>
                    	</tr>
                    	<tr>
                    		<td class="col1" rowspan="2"> <font color="red"><b>*</b></font> 주소 </td>
                    		<td class="col2"> <input type="text" id="address1" name="address1" placeholder="주소" value="<?=$address1?>"> <span id=must>* 기본주소</span></td> 
                    	</tr>
                    	<tr>
                    		<td class="col2"><input type="text" id="address2" name="address2" placeholder="나머지 주소" value="<?=$address2?>"> <span id=must>* 나머지 주소</span> </td>
                    	<tr>
                        <!--  -->
                    	
                    	<tr>
                    		<td class="col1"> <font color="red"><b>*</b></font> 연락처 </td>
                    		<td class="col2"> <input type="text" name="hp1" size="2" value="<?=$phone1?>"> - 
                    						<input type="text" name="hp2" size="3" value="<?=$phone2?>"> - 
                    						<input type="text" name="hp3" size="3" value="<?=$phone3?>">
                    			<span id="must">* 전화번호 또는 휴대전화번호 중 하나를 입력하셔야 합니다.</span>
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
                    		<td class="col2"><textarea rows="10" cols="70" name="message"></textarea></td>
                    	</tr>	
                	</table>
            		<div id="order_list_pay">
            			<span>최종결제 금액</span><br><br><br>
            			<span id="pay_value">￦</span>
            			<span id="pay_value2"><?=$all_total + 3?>,000</span><br><br><br><br>
            			<input type="checkbox" name="pay_check" id="pay_check">&nbsp;<span id="pay_check2">결제정보를 확인하였으며, 구매진행에 <br>동의합니다.</span><br><br><br> 
            			<button id="pay_button" onclick="check_input()">결제하기</button>
            		</div>
        		</div>
    		</form>	
    	</div>
    </section>
    <div class="clear"></div>
	<footer style="border:1px solid black;">
 		<?php include_once '../../common_lib/footer2.php';?>
  	</footer>
</body>
</html>    