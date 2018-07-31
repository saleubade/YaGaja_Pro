 <?php 
 include '../../common_lib/createLink_db.php';
 session_start();
 if(!empty($_SESSION['id'])){
     $id = $_SESSION['id'];
 }else{
     $id = "?";
 }
 if(!empty($_POST['find'])){
     $find = $_POST['find'];
 }else{
     $find = "";
 }

$jan = "01";
$feb = "02";
$mar = "03";
$apr = "04";
$may = "05";
$jun = "06";
$jul = "07";
$aug = "08";
$sep = "09";
$oct = "10";
$nov = "11";
$dec = "12";

$jan_price =0;
$feb_price =0;
$mar_price =0;
$apr_price =0;
$may_price =0;
$jun_price =0;
$jul_price =0;
$aug_price =0;
$sep_price =0;
$oct_price =0;
$nov_price =0;
$dec_price =0;

$current_date = date(Y);    //현재년도

if($find){
    $sql = "select * from reserve_info where payment_date like '$find%'";
}else{
    $sql = "select * from reserve_info where payment_date like '$current_date%'";
}

$result = mysqli_query($con,$sql) or die("실패원인1: ".mysqli_error($con));

while($row = mysqli_fetch_array($result)){

$payment_price = $row[payment_price];
$payment_date = $row[payment_date];

$payment_date = substr($payment_date, 5,2);    // 07/07/07/03 */

$sql1 = "select sum(payment_price) from reserve_info where payment_date like '_____$jan%' ";
$result1 = mysqli_query($con,$sql1) or die("실패원인1: ".mysqli_error($con));
$row = mysqli_fetch_array($result1);
$jan_price = $row[0];
if(!$jan_price){$jan_price =0;}

$sql2 = "select sum(payment_price) from reserve_info where payment_date like '_____$feb%' ";
$result2 = mysqli_query($con,$sql2) or die("실패원인1: ".mysqli_error($con));
$row = mysqli_fetch_array($result2);
$feb_price = $row[0];
if(!$feb_price){$feb_price =0;}

$sql3 = "select sum(payment_price) from reserve_info where payment_date like '_____$mar%' ";
$result3 = mysqli_query($con,$sql3) or die("실패원인1: ".mysqli_error($con));
$row = mysqli_fetch_array($result3);
$mar_price = $row[0];
if(!$mar_price){$mar_price =0;}

$sql4 = "select sum(payment_price) from reserve_info where payment_date like '_____$apr%' ";
$result4 = mysqli_query($con,$sql4) or die("실패원인1: ".mysqli_error($con));
$row = mysqli_fetch_array($result4);
$apr_price = $row[0];
if(!$apr_price){$apr_price =0;}

$sql5 = "select sum(payment_price) from reserve_info where payment_date like '_____$may%' ";
$result5 = mysqli_query($con,$sql5) or die("실패원인1: ".mysqli_error($con));
$row = mysqli_fetch_array($result5);
$may_price = $row[0];
if(!$may_price){$may_price =0;}

$sql6 = "select sum(payment_price) from reserve_info where payment_date like '_____$jun%' ";
$result6 = mysqli_query($con,$sql6) or die("실패원인1: ".mysqli_error($con));
$row = mysqli_fetch_array($result6);
$jun_price = $row[0];
if(!$jun_price){$jun_price =0;}

$sql7 = "select sum(payment_price) from reserve_info where payment_date like '%$jul%' ";
$result7 = mysqli_query($con,$sql7) or die("실패원인1: ".mysqli_error($con));
$row = mysqli_fetch_array($result7);
$jul_price = $row[0];
if(!$jul_price){$jul_price =0;}

$sql8 = "select sum(payment_price) from reserve_info where payment_date like '%$aug%' ";
$result8 = mysqli_query($con,$sql8) or die("실패원인1: ".mysqli_error($con));
$row = mysqli_fetch_array($result8);
$aug_price = $row[0];
if(!$aug_price){$aug_price =0;}

$sql9 = "select sum(payment_price) from reserve_info where payment_date like '_____$sep%' ";
$result9 = mysqli_query($con,$sql9) or die("실패원인1: ".mysqli_error($con));
$row = mysqli_fetch_array($result9);
$sep_price = $row[0];
if(!$sep_price){$sep_price =0;}

$sql10 = "select sum(payment_price) from reserve_info where payment_date like '_____$oct%' ";
$result10 = mysqli_query($con,$sql10) or die("실패원인1: ".mysqli_error($con));
$row = mysqli_fetch_array($result10);
$oct_price = $row[0];
if(!$oct_price){$oct_price =0;}

$sql11 = "select sum(payment_price) from reserve_info where payment_date like '_____$nov%' ";
$result11 = mysqli_query($con,$sql11) or die("실패원인1: ".mysqli_error($con));
$row = mysqli_fetch_array($result11);
$nov_price = $row[0];
if(!$nov_price){$nov_price =0;}

$sql12 = "select sum(payment_price) from reserve_info where payment_date like '_____$dec%' ";
$result12 = mysqli_query($con,$sql12) or die("실패원인1: ".mysqli_error($con));
$row = mysqli_fetch_array($result12);
$dec_price = $row[0];
if(!$dec_price){$dec_price =0;}

}


 ?>
<head>
<meta charset="UTF-8">
<title>TICKETING</title>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link type="text/css" rel="stylesheet" href="../../common_css/index_css3.css?var=1">
<link type="text/css" rel="stylesheet" href="../css/admin_ticket.css?v=8">
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>

<script type="text/javascript">

google.charts.load('current', {'packages':['line']});	/*LINE차트를 사용하기 위한 준비  */
google.charts.setOnLoadCallback(drawChart);		/* 로딩 완료시 함수 실행하여 차트 생성 */

function drawChart() {

    var data = new google.visualization.DataTable();
    data.addColumn('number', 'Month');
    data.addColumn('number', '매출');
    
    
    data.addRows([
      [1,  <?= $jan_price ?>],
      [2,  <?= $feb_price ?>],
      [3,  <?= $mar_price ?>],
      [4,  <?= $apr_price ?>],
      [5,  <?= $may_price ?>],
      [6,  <?= $jun_price ?>],
      [7,  <?= $jul_price ?>],
      [8,  <?= $aug_price ?>],
      [9,  <?= $sep_price ?>],
      [10, <?= $oct_price ?>],
      [11, <?= $nov_price ?>],
      [12, <?= $dec_price ?>]
      
    ]);
    
    var options = {
      chart: {
        title: 'Monthly payment history',
        subtitle: 'in won (KRW)'
      },
      width: 815,
      height: 500
    };
    
    var chart = new google.charts.Line(document.getElementById('linechart'));
    
    chart.draw(data, google.charts.Line.convertOptions(options));
}

$(document).ready(function() {
	   $("#btnExport").click(function (e) {
	      window.open('data:application/vnd.ms-excel;chsarset=utf-8,\uFEFF' + encodeURI($('#dvData').html()));
	       e.preventDefault();
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
</nav>


<h1 style="padding-top:40px; margin:0 auto; margin-top:20px; text-align: center">FLIGHT SALES HISTORY</h1><br>
<div id ="ticket_box45">
<div id="select_ticket"><h4>매출 내역</h4></div>
<form name="month_form" action="admin_flight_sales.php" method="post">
   <select name="find" style="width: 100px; height:30px;">
         <option value="<?= $current_date ?>"><?= $current_date ?>년</option>
         <option value="<?= $current_date -1 ?>"><?= $current_date -1 ?>년</option>
         <option value="<?= $current_date -2 ?>"><?= $current_date -2 ?>년</option>
         <option value="<?= $current_date -3 ?>"><?= $current_date -3 ?>년</option>
         <option value="<?= $current_date -4 ?>"><?= $current_date -4 ?>년</option>
         <option value="<?= $current_date -5 ?>"><?= $current_date -5 ?>년</option>
         <option value="<?= $current_date -6 ?>"><?= $current_date -6 ?>년</option>
    </select>
    <input type="submit" value="검색" style="width: 60px; height:30px;">
</form>
<?php
if($find){
    $sql = "select payment_price,payment_date from reserve_info where payment_date like '$find%'";
}else{
    $sql = "select payment_price,payment_date from reserve_info where payment_date like '$current_date%'";
}
$result = mysqli_query($con,$sql) or die("실패원인1: ".mysqli_error($con));
$total=0;
while($row = mysqli_fetch_array($result)){
    $payment_price = $row[payment_price];
    $total = $total + $payment_price;
}
$total = number_format($total);
if($find){
?>
    <div style="float:right;"><span style='font-size: 17pt; font-weight: 550;'><?= $find ?>년도 전체 매출 내역 : <?= $total ?> 원</span></div><br><br>
<?php 
}else{
?>
    <div style="float:right;"><span style='font-size: 17pt;'><?= $current_date ?>년도 전체 매출 내역 : <?= $total ?> 원</span></div><br><br>
<?php 
}
?>
<?php
$jan_price = number_format($jan_price);
$feb_price = number_format($feb_price);
$mar_price = number_format($mar_price);
$apr_price = number_format($apr_price);
$may_price = number_format($may_price);
$jun_price = number_format($jun_price);
$jul_price = number_format($jul_price);
$aug_price = number_format($aug_price);
$sep_price = number_format($sep_price);
$oct_price = number_format($oct_price);
$nov_price = number_format($nov_price);
$dec_price  = number_format($dec_price);
?>

<div id="linechart"></div>
<div style="float:right; margin:-400px 30px 0 0;">
<ul style="list-style: none;">
<li>01 월  : <?= $jan_price ?> 원</li>
<li>02 월  : <?= $feb_price ?> 원</li>
<li>03 월  : <?= $mar_price ?> 원</li>
<li>04 월  : <?= $apr_price ?> 원</li>
<li>05 월  : <?= $may_price ?> 원</li>
<li>06 월  : <?= $jun_price ?> 원</li>
<li>07 월  : <?= $jul_price ?> 원</li>
<li>08 월  : <?= $aug_price ?> 원</li>
<li>09 월  : <?= $sep_price ?> 원</li>
<li>10 월  : <?= $oct_price ?> 원</li>
<li>11 월  : <?= $nov_price ?> 원</li>
<li>12 월  : <?= $dec_price ?> 원</li>
</ul>
<hr style="width:100px; border:2px solid gray;">
<span style="float:right; margin:0 0px 0 0; font-size:13pt;">총액 : <?= $total ?> 원</span></div>

<?php 
//---------------------------------------------------------------------------------------------------
//엑셀파일로 내역확인하기
?>
<button id="btnExport" style="float:right;">매출 내역 상세확인</button>

<div id="dvData">
<table style="visibility: hidden;border-collapse: collapse;
   font-family: "Trebuchet MS", Helvetica, sans-serif;">
   
<?php
   $sql = "select * from reserve_info";
   $result = mysqli_query($con, $sql) or die("실패원인 : " . mysqli_error($con));
 
?>
	<tr>
       <td style="border: 1px solid black; text-align: center;">번 호</td>
       <td style="border: 1px solid black; text-align: center;">아 이 디</td>
       <td style="border: 1px solid black; text-align: center;">항공권 번호</td>
       <td style="border: 1px solid black; text-align: center;">항공권 예매번호</td>
       <td style="border: 1px solid black; text-align: center;">예매 날짜</td>
       <td style="border: 1px solid black; text-align: center;">결제 금액(원)</td>
    </tr>
<?php 
    $i=0;
while($row = mysqli_fetch_array($result)){
    
    $id1 = $row['id'];
    $start_apnum1 = $row['start_apnum'];
    $back_apnum1 = $row['back_apnum'];
    $reserve_num1 = $row['reserve_num'];
    $payment_price1 = $row['payment_price'];
    $payment_date1 = $row['payment_date'];
    $total2 = $total2 + $payment_price1;
    
?>
  <tr>
       <td style="border: 1px solid black; text-align: center;" ><?= $i+1 ?></td>
       <td style="border: 1px solid black;text-align: center;"><?= $id1 ?></td>
       <td style="border: 1px solid black;text-align: center;"><?= $start_apnum1,$back_apnum1 ?></td>
       <td style="border: 1px solid black;text-align: center;"><?= $reserve_num1 ?></td>
       <td style="border: 1px solid black;text-align: center;"><?= $payment_date1 ?></td>
       <td style="border: 1px solid black;text-align: center;"><?= number_format($payment_price1) ?></td>
  </tr>
<?php 
$i++;
}
?>
    <tr>
       <td colspan="3" style="border: 1px solid black; text-align: center;" >총 매출</td>
       <td colspan="3"  style="border: 1px solid black;text-align: center;"><?=number_format($total2) ?>원</td>
    </tr>
</table>
<?php 
//---------------------------------------------------------------------------------------------------
?>
</div>
</div><!-- end of ticketbox-->
<br><br>
<footer>
<?php include_once '../../common_lib/footer2.php';?>
</footer>
  
</body>
</html>

 
