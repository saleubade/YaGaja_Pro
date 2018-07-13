<?php
include_once '../../common_lib/createLink_db.php';
include_once './create_membership.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8>
	<link href=../../common_css/index_css3.css rel=stylesheet>
	<link href=../css/member.css rel=stylesheet>
	<script>
		var conf="y";
		function check_exp(elem, exp, msg){
			if(!elem.value.match(exp)){
				alert(msg);
				return true;
			}
		}
	
		function check_id(){
			window.open("check_id.php?id="+document.join_form.id.value, "IDcheck", "left=200, top=200, width=420, height=350, scrollbars=no, resizable=yes");
		}
		
		function check_email(){
			window.open("check_email.php", "IDEmail", "left=200, top=200, width=420, height=350, scrollbars=no, resizable=yes");
		}
		
		function check_input(){
			
			// 아이디 검사
			var exp_id= /^[0-9a-zA-Z]{6,12}$/;
			if(check_exp(document.join_form.id, exp_id, "ID는 6~12자리 영문 또는 숫자만 입력해주세요!")){
				document.join_form.id.focus();
				document.join_form.id.select();
				return ;
			}
			// 암호 검사
			var exp_pass= /^[0-9a-zA-Z~!@#$%^&*()]{10,16}$/;
			if(!document.join_form.pass.value){
				alert("암호를 입력해주세요");
				document.join_form.pass.focus();
				return ;
			}			
			if(check_exp(document.join_form.pass, exp_pass, "암호는 6~12자리 영문 또는 숫자만 입력해주세요!")){
				document.join_form.pass.focus();
				document.join_form.pass.select();
				return ;
			}
			
			// 이름 검사
			var exp_name= /^[가-힣]{2,5}$/;
			if(!document.join_form.name.value){
				alert("이름을 입력해주세요");
				document.join_form.name.focus();
				return ;
			}
			if(check_exp(document.join_form.name, exp_name, "이름을 정확히 입력해주세요!(한글 입력!)")){
				document.join_form.name.focus();
				document.join_form.name.select();
				return ;
			}
			
			if(!document.join_form.gender.value){
				alert("성별을 선택해주세요");
				document.join_form.gender.focus();
				return ;
			}
			
 			if(!document.join_form.zip.value){
				alert("주소를 선택해주세요");
				document.join_form.zip.focus();
				return ;
			}
			
			if(!document.join_form.address1.value){
				alert("주소를 입력해주세요");
				document.join_form.address1.focus();
				return ;
			}
			
			// 연락처 검사
			var exp_hp1= /^0[1-9][0-9]?$/;
			var exp_hp2= /^[0-9]{4}$/;
			if(!document.join_form.hp1.value){
				alert("연락처를 입력해주세요");
				document.join_form.hp1.focus();
				return ;
			}			
			if(!document.join_form.hp2.value){
				alert("연락처를 입력해주세요");
				document.join_form.hp2.focus();
				return ;
			}			
			if(!document.join_form.hp3.value){
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
			if(check_exp(document.join_form.hp3, exp_hp2, "연락처를 정확히 입력해주세요!")){
				document.join_form.hp3.focus();
				document.join_form.hp3.select();
				return ;
			}
			
			// 암호 일치 확인
			if(document.join_form.pass.value != document.join_form.pass_conf.value){
				alert("암호가 일치하지 않습니다. 다시 입력해주세요");
				document.join_form.pass.focus();
				document.join_form.pass.select();
				return ;
			}
			
			// 이메일 확인
			if(!document.join_form.email1.value){
				alert("e-mail 인증을 해주세요");
				document.join_form.pass.focus();
				document.join_form.pass.select();
				return ;
			}
			
			
			document.join_form.submit();
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
    <header>
      <?php include_once "../../common_lib/top_login2.php"; ?>
    </header>
    <nav id="top">
      <?php include_once "../../common_lib/main_menu2.php"; ?>
    </nav>
    <section id="section">
      <article class="main">
        <div id="head">
          <h1>회원가입</h1>
      </div>
      <hr>
	<div class=clear></div>

<form name=join_form method=post action="insert.php">

<table id=join_form_content border=0 cellpadding=5 cellspacing=0>
	<caption>
		<div id=join_form_title1><b>회원정보입력</b></div>
		<div id=join_form_title2> <font color=red><b>*</b></font> 표시가 된 항목은 필수 항목입니다.</div>
	</caption>
	<tr>
		<td class=col1> <font color=red><b>*</b></font> 회원 ID </td>
		<td class=col2> <input type=text name=id size=15 ><a href="#"><img src=../image/btn_chk_id.gif onclick="check_id()" style="margin-left: 8px; vertical-align: middle;"></a>
			<span id=must>* 아이디는 6~12자리의 영문 또는 숫자 혼용, 특수문자 제외</span>
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
		<td class=col2> <input type=text name=name size=15> </td>
	</tr>
	<tr>
		<td class=col1> <font color=red><b>*</b></font> 생년월일 </td>
		<td class=col2>
			<select name=year>
				<?php 
				for($i=0; $i<60;$i++){
				    $year=2010-$i;
			        echo "<option value=$year>$year</option>";
                }
				?>
			</select> 년
			<select name=month>
				<?php 
				for($i=1; $i<=12;$i++){
			        echo "<option value=$i>$i</option>";
                }
				?>
			</select> 월
			<select name=day>
				<?php 
				for($i=1; $i<=31;$i++){
			        echo "<option value=$i>$i</option>";
                }
				?>
			</select> 일
		</td>
	</tr>
	<tr>
		<td class=col1> <font color=red><b>*</b></font> 성별 </td>
		<td class=col2> <input type=radio name=gender value=male> 남자  <input type=radio name=gender value=female> 여자  </td>
	</tr>
	<tr>
		<td class=col1> <font color=red><b>*</b></font> 우편번호</td>
		<td class=col2> <input type="text" id="postcode" name="zip" placeholder="우편번호" readonly>
			<a href="#"><img src="../image/btn_jusogo.gif" onclick="execDaumPostcode()" style="margin-left: 8px; vertical-align: middle;" ></a>
		</td>
	</tr>
	
	<tr>
		<td class=col1 rowspan=2> <font color=red><b>*</b></font> 주소 </td>
		<td class=col2> <input type="text" id="address1" name="address1" placeholder="주소" readonly></td> 
	</tr>
	<tr>
		<td class=col2><input type="text" id="address2" name="address2" placeholder="나머지 주소"> <span id=must>* 나머지 주소를 입력하세요.</span> </td>
	<tr>
    <!--  -->
	
	<tr>
		<td class=col1> <font color=red><b>*</b></font> 연락처 </td>
		<td class=col2> <input type=text name=hp1 size=2> - <input type=text name=hp2 size=3> - <input type=text name=hp3 size=3>
			<span id=must>* 전화번호 또는 휴대전화번호 중 하나를 입력하셔야 합니다.</span>
		</td>
	</tr>
	<tr>
		<td class=col1> <font color=red><b>*</b></font> 이메일주소 </td>
		<td class=col2>
			<input type=text name=email1 size=10 readonly> @ 
			<input type=text name=email2 size=10 readonly> 
			<a href="#"><img src="../image/email_conf.jpg" onclick="check_email()"></a>
		</td>
	</tr>
	
</table>
<br><br>
<table id=button>
	<tr>
		<td width=750><a href="#"><img src=../image/btn_member_apply.jpg onclick="check_input()"></a></td>
	</tr>
</table>
</form>
<br>
</article>
</section>

<footer>
<?php include_once '../../common_lib/footer2.php';?>
</footer>

</body>
</html>