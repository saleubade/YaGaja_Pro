<?php 
/* 
 * 주요 사항 
 * 1.join_form.php 에서 넘긴  id값을 저장.
 * 2.id값으로 쿼리문 작성
 * 3.입력한 아이디 길이를 확인.
 * 4.아이디 중복여부에 따른 버튼 컨트롤.
 *  
 *  
 *  
 *  */

include '../../common_lib/createLink_db.php'; 

//아이디가 세팅되어있을 시 
if(isset($_GET['id'])){
    $id= $_GET['id'];
}else{
    $id="";
}

$sql="select * from membership where id='$id'";

$result= mysqli_query($con, $sql);
$row= mysqli_fetch_array($result);

//입력한 아이디 길이가 6이상 12이하
if(strlen($id) >= 6 && strlen($id) <= 12){
    $num_record= mysqli_num_rows($result);//레코드가 없을 시 0
}else{
    $num_record=1;//레코드 1
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8>
	<link href=../css/join.css rel=stylesheet>
</head>
<script>
	// 요소 검사 함수
	function check_exp(elem, exp, msg){
		if(!elem.value.match(exp)){
			alert(msg);
			return true;
		}
	}
	//아이디 검사
	function id_check(){
    	var exp_id= /^[0-9a-zA-Z]{6,12}$/;
    	var id_val= document.id_check_form.id.value;
    	//아이디 값이 비어있을 시.
		if(!id_val){
			alert("ID를 입력해주세요");
			return ;
		}
    	//유효성에 맞지 않을 시
    	if(check_exp(document.id_check_form.id, exp_id, "ID는 6~12자리 영문 또는 숫자만 입력해주세요!")){
    		document.id_check_form.id.focus();
    		document.id_check_form.id.select();
    		return ;
    	}
    	document.id_check_form.submit();
	}
	
	//사용 가능 할 시 나오는 버튼. 
	function id_use(a){
		opener.join_form.id.value=a;
		window.close();
	}
	
	function closer(){
		window.close();
	}

</script>
<body>
	<div id=wrap>
		<div id=id_check_title>
			<div id=id_check_title1><img src=../image/pop_idcomf.gif></div>
			<div id=id_check_title2><a href="#"><img src=../image/pop_login_close.gif onclick="closer()"></a></div>
		</div>
		<div class=clear></div>
		<div id=hr_line></div>
		<br>
		<div id=text1 align=center>
			사용하고자 하는 아이디를 입력하신 후 중복검색 버튼을 눌러주세요.<br>
			(6자 이상 12자 이내의 영문 또는 영문과 숫자를 조합, 한글 및 특수문자 제외)
		</div>
		<br>
		<form name=id_check_form method=get action="check_id.php">
		<div align=center>
			<input type="text" name="id" value="<?=$id?>"> <a href="#"><img src="../image/idComF.gif" onclick="id_check()"></a>
		</div>
		</form>
		<br>
		<div id=hr_line_middle></div>
		<br>
		<?php 
		if($num_record){
		?>
		<div id=text2 align=center>
			<b>입력하신 '<font color=red><?=$id?></font>'는 <font color=red>사용할 수 없는</font> 아이디입니다.<br>
				새로운 아이디로 선택해 주십시오.</b>
		</div>
		<?php 
		}else{
		?>
		<div id=text2 align=center>
			<b>입력하신 '<font color=red><?=$id?></font>'는 사용하실 수 있습니다.<br>
				이 아이디를 사용하시겠습니까?</b><br><br>
			<a href="#"><img src="../image/use.gif" onclick="id_use('<?=$id?>')"></a>
		</div>
		<?php
		}
		?>
	
	</div>
</body>
</html>
<?php

mysqli_close($con);
?>


