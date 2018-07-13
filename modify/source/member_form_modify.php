<?php
session_start(); //세션은 내 사이트에서 전역변수 역활을 할 수 있다. 로그인값을 세션값에 부여해서 모든페이지에 회원인지 아닌지 구별하고 페이지를 보여준다.

?>

<html>
<head>
<meta charset=utf-8> <!-- 웹문서 파일이 웹브라우저에서 표시되는 과정에서 인코딩할때 지정된 문자코드로 인코딩해라 라는 의미-->
<link rel="stylesheet" href="../../common_css/index_css3.css"><!-- 뒤에 경로에 있는 파일을 연결 시켜준다. -->
<link rel="stylesheet" href="../css/modify1.css">

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
<script>

function check_exp(elem, exp, msg){
	if(!elem.value.match(exp)){
		alert(msg);
		return true;
	}
}

function check_input(){

	// 암호 검사
				var exp_pass= /^[0-9a-zA-Z~!@#$%^&*()]{10,16}$/;
				if(!document.join_form.pass.value){ 
					//밑에 form안에 name을 pass라 준 value가 아니면 경고창을 주고 포커스를 맞춰준다
					alert("암호를 입력해주세요"); 
					document.join_form.pass.focus();
					return ;
				}			
				if(check_exp(document.join_form.pass, exp_pass, "암호는 6~12자리 영문 또는 숫자만 입력해주세요!")){
					//위에 check_exp함수 실행 form안에 name이 pass 이고 exp_pass유효성 검사를 통해 검사에 맞게 입력을 안하면 경고창을준다
					document.join_form.pass.focus(); //pass에 포커스 맞춰줌
					document.join_form.pass.select();//pass에 드래그 상태
					return ;
				}
				
				
				if(!document.join_form.zip.value){ //form안에 name이 zip 값이 없으면 
					alert("주소를 선택해주세요");
					document.join_form.zip.focus();
					return ;
				}
				
				if(!document.join_form.address1.value){ //form안에 name이 address1 값이 없으면
					alert("주소를 입력해주세요");
					document.join_form.address1.focus();
					return ;
				}
				
				// 연락처 검사
				var exp_hp1= /^0[1-9][0-9]?$/; //첫번째자리
				var exp_hp2= /^[0-9]{4}$/; //두번째자리
				var exp_hp3= /^[0-9]{4}$/; //세번째자리
				
				if(!document.join_form.hp1.value){ //form안에 name이 hp1 값이 없으면
					alert("연락처를 입력해주세요");
					document.join_form.hp1.focus();
					return ;
				}			
				if(!document.join_form.hp2.value){ //form안에 name이 hp2 값이 없으면
					alert("연락처를 입력해주세요");
					document.join_form.hp2.focus();
					return ;
				}			
				if(!document.join_form.hp3.value){ //form안에 name이 hp3 값이 없으면
					alert("연락처를 입력해주세요");
					document.join_form.hp3.focus();
					return ;
				}
				// 연락처 유효성 검사
				if(check_exp(document.join_form.hp1, exp_hp1, "연락처를 정확히 입력해주세요!")){
					document.join_form.hp1.focus();
					document.join_form.hp1.select();
					return ;
				}
				if(check_exp(document.join_form.hp2, exp_hp2, "연락처를 정확히 입력해주세요!")){
					document.join_form.hp2.focus();
					document.join_form.hp2.select();
					return ;
				}
				if(check_exp(document.join_form.hp3, exp_hp3, "연락처를 정확히 입력해주세요!")){
					document.join_form.hp3.focus();
					document.join_form.hp3.select();
					return ;
				}
				
				// 이메일 검사
				var exp_email1= /^[0-9a-zA-Z~!@#$%^&*()]+$/;
				var exp_email2= /^[a-z]+\.[a-z]+$/;
				if(!document.join_form.email1.value){
					alert("이메일을 입력해주세요");
					document.join_form.email1.focus();
					return ;
				}
				if(check_exp(document.join_form.email1,exp_email1, "이메일을 정확히 입력해주세요!1")){
					document.join_form.email1.focus();
					document.join_form.email1.select();
					return ;
				}
				if(check_exp(document.join_form.email2,exp_email2, "이메일을 정확히 입력해주세요!2")){
					document.join_form.email2.focus();
					document.join_form.email2.select();
					return ;
				}
				
				// 암호 일치 확인
				if(document.join_form.pass.value != document.join_form.pass_conf.value){
					alert("암호가 일치하지 않습니다. 다시 입력해주세요");
					document.join_form.pass.focus();
					document.join_form.pass.select();
					return ;
				}
				document.join_form.submit();
				
}			



</script>

</head>

<?php 
include_once "../../common_lib/createLink_db.php"; 

$id=$_SESSION['id']; //세션아이디를 변수 $id란 값에 집어 넣는다.

$sql="select * from membership where id='$id'"; //멤버쉽 테이블에 변수$id와 필드값id가 같은 레코드를 전부 보여달라.
$result=mysqli_query($con, $sql); //쿼리문 실행
$row=mysqli_fetch_array($result); // 쿼리문을 실행해서 얻은 값들을 배열로 가져온다

$phone=explode("-",$row['phone']); //문자열로 문자열을 자르는 함수
$phone1=$phone[0]; //$phone[0] 을 $phone1변수에 저장
$phone2=$phone[1]; //$phone[1] 을 $phone2변수에 저장
$phone3=$phone[2]; //$phone[2] 을 $phone3변수에 저장

$email=explode("@",$row['email']);
$email1=$email[0]; //$email[0] 을 $email1변수에 저장
$email2=$email[1]; //$email[1] 을 $email2변수에 저장


$birth=explode("-",$row['birth']);
$birth1=$birth[0]; //$birth[0] 을 $birty1변수에 저장
$birth2=$birth[1]; //$birth[1] 을 $birty2변수에 저장
$birth3=$birth[2]; //$birth[2] 을 $birty3변수에 저장

$address=explode(" ",$row['address']);
$address1=$address[0]; //$address[0] 을 $address1변수에 저장
$address2=$address[1]; //$address[1] 을 $address2변수에 저장

mysqli_close($con);

?>


<body>

   <header>
      <?php include_once "../../common_lib/top_login2.php"; ?>
    </header>
    <nav id="top">
      <?php include_once "../../common_lib/main_menu2.php"; ?>
    </nav>
	
	<section>
	<aside>


  </aside>
	
  <article class=main>
  <div id="head">
  	<h1>회원정보수정</h1>
  	</div>
    <hr>  

<div class=clear></div>

<form name="join_form" method=post action="modify_update.php">

<table id=join_form_content border=0 cellpadding=5 cellspacing=0>
	<caption>
		<div id=join_form_title1><b>회원정보수정</b></div>
		<div id=join_form_title2> <font color=red></font></div>
	</caption>
	<tr>
		<td class=col1> <font color=red><b>*</b></font> 회원 ID </td>
		<td class=col2> 
			<?=$row['id']?> <!-- <<이거는  ?php echo("$row['id]");? 이거랑 같은의미 -->
			<span id=must></span>
		</td>
	</tr>
	<tr>
		<td class=col1> <font color=red><b>*</b></font> 비밀번호 </td>
		<td class=col2> <input type=password name=pass size=15>
			<span id=must>* 비밀번호는 10~16자리의 영문/숫자 또는 영문/숫자/특수문자[!@#$%^&*()] 혼용</span></td>
	</tr>
	<tr>
		<td class=col1> <font color=red><b>*</b></font> 비밀번호 확인</td>
		<td class=col2> <input type=password name=pass_conf size=15> <span id=must>* 비밀번호를 한번 더 입력하세요.</span></td>
	</tr>
	<tr>
		<td class=col1> <font color=red><b>*</b></font> 성명 </td>
		<td class=col2> <?=$row['name']?> </td>
	</tr>
	
	<tr>
		<td class=col1> <font color=red><b>*</b></font> 생년월일 </td>
		<td class=col2> <?=$birth1?>년 <?=$birth2?>월 <?=$birth3?>일</td>
		</tr>
		
	<tr>
		<td class=col1> <font color=red><b>*</b></font> 성별 </td>
		<td class=col2>
				<?php 
				  if($row['gender'] == "male"){
				      echo "<input type=radio name=gender value='male' checked> 남자";
				      echo "<input type=radio name=gender value='female'> 여자";
				  }else{
				      echo "<input type=radio name=gender value='male'> 남자";
				      echo "<input type=radio name=gender value='female' checked> 여자";
				  }
				?>			 	 
		</td>
	</tr>
	

	
		<tr>
		<td class=col1> <font color=red><b>*</b></font> 우편번호</td>
		<td class=col2> <input type="text" id="postcode" name="zip" value=<?=$row['zip']?> placeholder="우편번호" readonly>
			<a href="#"><img src="../image/btn_jusogo.gif" onclick="execDaumPostcode()"></a>
		</td>
	</tr>
	
	<tr>
		<td class=col1 rowspan=2> <font color=red><b>*</b></font> 주소 </td>
		<td class=col2> <input type="text" id="address1" name="address1" value=<?=$address1?> placeholder="주소" readonly></td> 
	</tr>
	<tr>
		<td class=col2><input type="text" id="address2" name="address2" value=<?=$address2?> placeholder="나머지 주소"> <span id=must>* 나머지 주소를 입력하세요.</span> </td>
	<tr>
    <!--  -->
	
	<tr>
		<td class=col1> <font color=red><b>*</b></font> 연락처 </td>
		<td class=col2> <input type=text name=hp1 size=2 value=<?=$phone1?>> - <input type=text name=hp2 size=3 value=<?=$phone2 ?>> - <input type=text name=hp3 size=3 value=<?=$phone3 ?>>
			<span id=must>* 전화번호 또는 휴대전화번호 중 하나를 입력하셔야 합니다.</span>
		</td>
	</tr>
	<tr>
		<td class=col1> <font color=red><b>*</b></font> 이메일주소 </td>
		<td class=col2> <input type=text name=email1 size=20 value=<?=$email1?>> @  
			<input type=text name=email2 size=20 value=<?=$email2?>> </td>
	</tr>
	
</table>
<br><br>
<table id=button>
	<tr>
		<td width=750><a href="#"><img src="../image/btn_change.jpg" onclick="check_input();"></a></td>
	</tr>
</table>
</form>
</article>
</section>
<footer>
      <?php include_once "../../common_lib/footer2.php"; ?>
	</footer>
</body>
</html>