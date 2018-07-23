 <?php 
 include '../../common_lib/createLink_db.php';     
 include './create_country.php';
 include './create_flight_one_way.php';
 include './create_reserve_info.php';
 include '../../flight_reserve/source/create_seat_state.php';
 
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
<link type="text/css" rel="stylesheet" href="../../common_css/index_css3.css?v=1">
<link type="text/css" rel="stylesheet" href="../css/ticket1.css?v=4">
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<script type="text/javascript">

function checkround(){
	
	var fly = $(':input[name=fly]:radio:checked').val();
	
    if(fly == 'one-way'){
    	$("#one-way_div").hide();
    }else if(fly == 'round'){
    	$("#one-way_div").show();
    }
}

function start_area(){	
	var popupX = (window.screen.width / 2) - (800 / 2);
	var popupY= (window.screen.height /2) - (500 / 2);
	window.open('start_area.php', '', 'status=no, width=800, height=500, left='+ popupX + ', top='+ popupY + ', screenX='+ popupX + ', screenY= '+ popupY);
}

function back_area(){
	var popupX = (window.screen.width / 2) - (800 / 2);
	var popupY= (window.screen.height /2) - (500 / 2);
	window.open('back_area.php', '', 'status=no, width=800, height=500, left='+ popupX + ', top='+ popupY + ', screenX='+ popupX + ', screenY= '+ popupY);
}

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
  
$(function(){ 
	$('.bt_up').click(function(){ 
		
    var n = $('.bt_up').index(this);
    var num = $(".num:eq("+n+")").val();

        if(num == 10 ){	//최대10명
        	
        }else{
        	num = $(".num:eq("+n+")").val(num*1+1); 
        }
	});
  
	$('.bt_down').click(function(){ 
		
    var n = $('.bt_down').index(this);
    var num = $(".num:eq("+n+")").val();
    
        if(num == 0 ){
    		 
    	}else{
    	 	num = $(".num:eq("+n+")").val(num*1-1); 
		}
	});
});

</script>
</head>
<body>
<header>
	<?php include_once '../../common_lib/top_login2.php';?>
</header>
<nav id="top">
	<?php include_once '../../common_lib/main_menu2.php';?>
</nav><br><br>

<h1 style="margin:0 auto; text-align: center">FLIGHT TICKETING</h1><br>
<div id="ticket_box0">
<p>
    <br><hr id="hr1"><br><br>
    &nbsp;1. 여정 선택  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    2. 항공편 선택  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    3. 결과 조회  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    4. 좌석 확인  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<p>

<table width=550 border=0 height=18 cellspacing=5 cellpadding=0>
	<tr>
<?php
   echo "
        <td width='25%' bgcolor=gray></td>
        <td width='25%' bgcolor= '#dddddd' height=5></td>
        <td width='25%' bgcolor='#dddddd' height=5></td>
        <td width='25%' bgcolor='#dddddd' height=5></td>";
?>
	</tr>
</table><br>

<hr id="hr1"><br>

<div id="select_ticket"><h4>여정선택</h4></div>

<div id="div1">
    <form name='ticket_form' method='post' action='check_flight.php'> 
        <input type="radio" value="round" name="fly" id="round" style='width:20px;height:20px;' checked onclick="checkround()">왕복
        <input type="radio" value="one-way" name="fly" id="one-way" style='width:20px;height:20px;' onclick="checkround()">편도<br><br>
  
<table class="table2">
	<tr>
		<td><input type="text" name="start" class="div_none" id="asearch"  placeholder="출발지"  autofocus onclick="start_area()"></td>
		<td><input type="text" name="back" class="div_none" placeholder="목적지"  onclick="back_area()"></td>
	</tr>
</table><br><br>

<table class="table2">
	<tr>
		<td><input type="text" id="datepicker1" class="div_none" name="start_day" placeholder="가는날(YYYY-MM-DD)"></td>
		<td id="one-way_div"><input type="text" id="datepicker2" class="div_none" name="back_day" placeholder="오는날(YYYY-MM-DD)"></td>
	</tr>	
</table><br></div>


<hr id="hr1">
<div id="seat_class">항공권 인원</div>
<hr id="hr1">

<table id="table3">
	<tr>
		<td class="count_box2">성인<br>
    		<div class="count_box1"> <img src="../image/minus.jpg" alt="" width="60" height="60" class="bt_down"/></div>
    		<div class="count_box1"> <input type="text" class="num" id="nnum1" name="num1" value="0"></div>
    		<div class="count_box1"> <img src="../image/plus.jpg" alt="" width="60" height="60" class="bt_up"/></div>
		</td>
		
		<td class="count_box2">소아(만 2세~11세)<br>
    		<div class="count_box1"> <img src="../image/minus.jpg" alt="" width="60" height="60" class="bt_down"/></div>
    		<div class="count_box1"> <input type="text" class="num" id="nnum2" name="num2" value="0"></div>
    		<div class="count_box1"> <img src="../image/plus.jpg" alt="" width="60" height="60" class="bt_up"/></div>
		</td>
		<td class="count_box2">유아(만2세미만)<br>
    		<div class="count_box1"> <img src="../image/minus.jpg" alt="" width="60" height="60" class="bt_down"/></div>
    		<div class="count_box1"> <input type="text" class="num" id="nnum3" name="num3" value="0"></div>
    		<div class="count_box1"> <img src="../image/plus.jpg" alt="" width="60" height="60" class="bt_up"/></div>
		</td>
	</tr> 
	<tr>
		<td colspan="3" id="count_btn">
			<hr id="hr1"><br><br><br>
			<input type='submit' id='select_ok' value='항공편 조회'  onclick='flight_lookup()'>
		</td>
	</tr> 
</table>
</form>
</div>

<footer>
	<?php include_once '../../common_lib/footer2.php';?>
</footer>
</body>
</html>
