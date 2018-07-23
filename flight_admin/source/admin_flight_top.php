<?php
include '../../common_lib/createLink_db.php';
session_start();

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link type="text/css" rel="stylesheet" href="../../common_css/index_css3.css?var=1">
<link type="text/css" rel="stylesheet" href="../css/ticket1.css?var=4">
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>

<script type="text/javascript">
function page_move(url){
		location.href=url;	
}

</script>
</head>
<body>
<header>
<?php include_once '../../common_lib/top_login2.php';?>
</header>
<nav id="top">
<?php include_once '../../common_lib/main_menu2.php';?>
</nav><br><br><br><br>

<h1 style="margin:0 auto; text-align: center">WELCOME TICKET MANAGER</h1><br>
<div id="ticket_box66">
<div style="text-align: center; font-size:15pt; font-weight: bold">CLICK what you want :D</div>
<div class="child_1" onclick="page_move('admin_country_insert.php')">
<p class="sp1">취항지 등록/<br>취항지 관리</p><br>
<span class="sp2"> - 항공권 선택시 대륙/취항지 도시 DB 등록 및 수정/삭제</span><br><br>
<span class="sp3">  ex)유럽 - 바르셀로나(BCN)</span><br>
</div>

<div class="child_1" onclick="page_move('flight_insert.php')">
<p class="sp1">항공권 등록</p><br>
<span class="sp2"> - 출/귀국 비행기 항공권 DB 등록</span><br><br>
<span class="sp3">  ex) 대한민국/인천(ICN) - 바르셀로나(BCN)<br>항공번호 : B777-401</span><br>
</div>

<div class="child_1" onclick="page_move('admin_flight_list.php')">
<p class="sp1">항공권 관리</p><br>
<span class="sp2"> - 출/귀국 비행기 항공권 DB 수정/삭제</span><br><br>
<span class="sp3">  ex) 대한민국/인천(ICN) - 로마(FCO)<br>항공번호 : B777-402</span><br>
</div>

<div class="child_1" onclick="page_move('admin_flight_ticketing.php')">
<p class="sp1">항공권 예매내역</p><br>
<span class="sp2"> - 항공권 예매 내역 확인</span><br><br>
<span class="sp3">  ex) soong1298님의<br> 출국/귀국 내역 :<br><br>출국 항공번호 : B777-401<br>귀국 항공번호 : B777-235</span><br>
</div>

<div class="child_1" onclick="page_move('../../flight_admin_reserve/source/admin_flight_reserve.php')">
<p class="sp1">좌석 배치</p><br>
<span class="sp2"> - 검색된 항공권과 아이디를 통해 좌석 번호 확인</span><br><br>
<span class="sp3">  ex) B777-401/<br>soong1298님의 좌석번호<br><br>항공번호 : B777-401<br>좌석 번호 : 26번</span><br>
</div>
<?php 
$current_date = date(Y);
?>
<div class="child_1" onclick="page_move('../../flight_sales/source/admin_flight_sales.php')">
<p class="sp1">매출 내역</p><br>
<span class="sp2"> - 올해 <?= $current_date ?>년부터 5년전 항공권 월별 매출 실적 현황 확인</span><br><br>
<span class="sp3">  ex) <?= $current_date ?>년도 현시점을 기준으로 매출 총액 : 15,465,208 원</span><br>
</div>
</div>
<footer>
<?php include_once '../../common_lib/footer2.php';?>
</footer>

</body>
</html>