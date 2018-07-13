 <?php 
 include '../../common_lib/createLink_db.php';
 session_start();
 if(!empty($_SESSION['id'])){
     $id = $_SESSION['id'];
 }else{
     $id = "?";
 }
 
 ?>
<head>
<meta charset="UTF-8">
<title>TICKETING</title>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link type="text/css" rel="stylesheet" href="../../common_css/index_css3.css?var=1">
<link type="text/css" rel="stylesheet" href="../css/admin_ticket.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<script type="text/javascript">

$.datepicker.setDefaults({
    dateFormat: 'yy-mm-dd',
    prevText: '이전 달',
    nextText: '다음 달',
 monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
    dayNames: ['일', '월', '화', '수', '목', '금', '토'],
    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
    showMonthAfterYear: true,
    yearSuffix: '년'
  });

  $(function() {
    $("#datepicker1 , #datepicker2").datepicker({
    	 minDate: 0 
    });
  });
  
function check_input(){
	
    if(!document.insert_form.start.value){
    	alert("출발지를 입력해주세요");
    	document.insert_form.start.focus();
    	return ;
    }
    if(!document.insert_form.back.value){
    	alert("도착지를 입력해주세요");
    	document.insert_form.back.focus();
    	return ;
    }
    if(!document.insert_form.flight_ap_num.value){
    	alert("항공번호를 입력해주세요");
    	document.insert_form.flight_ap_num.focus();
    	return ;
    }
    if(!document.insert_form.start_day.value){
    	alert("가는날을 선택해주세요");
    	document.insert_form.start_day.focus();
    	return ;
    }
    if(!document.insert_form.fly_start_time.value){
    	alert("출발시간을 입력해주세요");
    	document.insert_form.fly_start_time.focus();
    	return ;
    }
    if(!document.insert_form.fly_back_time.value){
    	alert("도착시간을 입력해주세요");
    	document.insert_form.fly_back_time.focus();
    	return ;
    }
    if(!document.insert_form.fly_time.value){
    	alert("운행시간을 입력해주세요");
    	document.insert_form.fly_time.focus();
    	return ;
    }
    if(!document.insert_form.flight_price.value){
    	alert("예상 운임을 입력해주세요");
    	document.insert_form.flight_price.focus();
    	return ;
    }
    if(!document.insert_form.recordnum.value){
    	alert("레코드번호를 입력해주세요");
    	document.insert_form.recordnum.focus();
    	return ;
    }
	document.insert_form.submit();
}

</script>
</head>
<body>

<header>
<?php include_once '../../common_lib/top_login2.php';?>
</header>
<nav id="top">
<?php include_once '../../common_lib/main_menu2.php';?>
</nav>
<h1 style="padding-top:40px; margin:0 auto; margin-top:20px; text-align: center">FLIGHT INSERTING</h1><br>
<div id ="ticket_box0">
<div id="select_ticket"><h4>항공권 등록</h4></div>


<form action="insert.php" method="post" name="insert_form">
<table class="table1">
<tr>
<td>출 발 지</td>
<td><input type="text" name="start" class="div_none" placeholder="서울/인천(ICN)"  autofocus></td>
</tr>

<tr>
<td>도 착 지</td>
<td><input type="text" name="back" class="div_none" placeholder="도쿄/나리타(NRT)"  autofocus></td>
</tr>

<tr>
<td>항공 번호</td>
<td><input type="text" name="flight_ap_num" class="div_none" placeholder="B777-301"  autofocus>
<span style="font-size:11pt; color: red;">* 항공번호 작성시 중복 자제 요망</span></td>
</tr>

<tr>
<td>출 발 일</td>
<td><input type="text" id="datepicker1" class="div_none" name="start_day" placeholder="가는날(YYYY-MM-DD)"></td>
</tr>

<tr>
<td>출발 시간</td>
<td><input type="text" name="fly_start_time" class="div_none" placeholder="출발시간(HH:MM)"  autofocus></td>
</tr>

<tr>
<td>도착 시간</td>
<td><input type="text" name="fly_back_time" class="div_none" placeholder="도착시간(HH:MM)"  autofocus></td>
</tr>

<tr>
<td>운행 시간</td>
<td><input type="text" name="fly_time" class="div_none" placeholder="2시간 30분"  autofocus></td>
</tr>

<tr>
<td>운 임</td>
<td><input type="text" name="flight_price" class="div_none" placeholder="예상 운임"  autofocus></td>
</tr>

<tr>
<td>레코드 번호</td>
<td><input type="text" name="recordnum" class="div_none" placeholder="순차생성"  autofocus>
<span style="font-size:11pt; color: red;"><br>* 항공권 등록 시  경로(출발-도착)별 레코드 번호 순차작성 요망</span><br>
&nbsp;&nbsp;&nbsp;<span style="font-size:11pt;">ex)2018-07-11 - 출발(서울/인천) -  도착(도쿄/나리타) - B777-301(항공번호) - 0(레코드번호)<br>
&nbsp;&nbsp;&nbsp;ex)2018-07-11 - 출발(서울/인천) -  도착(도쿄/나리타) - B777-302(항공번호) - 1(레코드번호)
</span></td>
</tr>
</table>
</form>
<div id="btn_cancel">
<input id="flight_insert" type="button" onclick="check_input()" value="항공권 등록">
</div>

<?php 


?>

</div>
<footer>
<?php include_once '../../common_lib/footer2.php';?>
</footer>
  
</body>
</html>
 
 
