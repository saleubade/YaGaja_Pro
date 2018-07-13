<?php
include '../../common_lib/createLink_db.php';
session_start();

if(!empty($_SESSION['id'])){
    $id = $_SESSION['id'];
}else{
    $id = "?";
}
if(!empty($_SESSION['name'])){
    $name = $_SESSION['name'];
}else{
    $name = "?";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link type="text/css" rel="stylesheet" href="../../common_css/index_css3.css">
<link type="text/css" rel="stylesheet" href="../css/ticket1.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>

<script type="text/javascript">


function check_input(){	
	if($("input:radio[id='start_check']").is(":checked") || $("input:radio[id='back_check']").is(":checked")){
	
		document.flight_listform.submit();
		
	}else{
		alert('취소할 항공권을 선택해주세요.');
		return;
	}
	

}

function aab(a){
	$("#totalprice1").text(a);
	
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
<div id="ticket_box4"><br><br>
<div id='select_ticket'><span style='font-size:15pt;'>항공권 예매내역<br></span></div><br><br>

<span style="font-size:14pt;"><b>[ <?= $name ?> ]</b> 님의 항공권 예매 내역입니다.</span>
<span style="font-size:15pt; float:right;">전 체 금 액  : <span  id="totalprice1"><?= $total ?></span> 원 &nbsp;&nbsp;&nbsp;</span>
<br><hr id="hr1"><br><br>



<form action="flight_list_cancel.php?rnum=<?= $rnum ?>" method="post" name="flight_listform">
<table id='row_flight2'>
    <tr id='row_flight2_tr1'>
    <td width='370' height='40'>출 국 편</td>
    <td width='120' height='40'>항공 번호</td>
    <td width='120' height='40'>날 짜</td>
    <td width='120' height='40'>시 간</td>
    <td width='100' height='40'>운행 시간</td>
    <td width='150' height='40'>운 임</td>
    <td width='70' height='40'>선 택</td>
   
    </tr>
<?php 

$sql = "select * from flight_one_way f inner join reserve_info r on f.flght_ap_num = r.start_apnum";
 mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
 

$result = mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
$total_record = mysqli_num_rows($result);
if($total_record == 0){
?>
    <tr>
    <td colspan="7"><br>[항목없음]<br><br></td>
    </tr>
    
    </table>
<?php 
}

while($row = mysqli_fetch_array($result)){
    $no = $row[no];
    $flight_price = $row[flight_price];
    $flight_start = $row[flight_start];
    $flight_back = $row[flight_back];
    $fly_start_date = $row[fly_start_date];
    $fly_start_time = $row[fly_start_time];
    $fly_back_time = $row[fly_back_time];
    $fly_time = $row[fly_time];
    $start_flight_ap_num = $row[flght_ap_num];
  

    echo "<tr>
    <td>$flight_start - $flight_back</td>
    <td>$start_flight_ap_num</td>
    <td>$fly_start_date</td>
    <td>$fly_start_time - $fly_back_time</td>
    <td>$fly_time</td>
    <td>$flight_price 원</td>
    <td><input type='radio' value='start_$no' name='start_check' id='start_check' style='width:20px;height:20px;'></td>
    </tr>";
        
    
}
   

?>   
 </table>
<br>
 <table id='row_flight2'>
    <tr id='row_flight2_tr1'>
    <td width='100' height='40'>예약 번호</td>
    <td width='400' height='40'>출 국 편</td>
    <td width='120' height='40'>이 름</td>
    <td width='120' height='40'>인 원</td>
    <td width='120' height='40'>인 원</td>
    <td width='120' height='40'>인 원</td>
    <td width='150' height='40'>총 운 임</td>
   
   
    </tr>
 <?php   
 $sql = "select * from membership m inner join reserve_info r on m.id = r.id
  inner join flight_one_way f on f.flght_ap_num = r.start_apnum";     

$result = mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
$total_record = mysqli_num_rows($result);
if($total_record == 0){
?>
    <tr>
    <td colspan="7"><br>[항목없음]<br><br></td>
    </tr>
    
    </table>
    <?php 
}
while($row = mysqli_fetch_array($result)){
    $name = $row[name];
    $total_price = $row[total_price];
    $anum = $row[adult_num];
    $bnum = $row[baby_num];
    $cnum = $row[chlid_num];
    $sapnum = $row[start_ap_num];
    $bapnum = $row[back_ap_num];
    $rnum = $row[reserve_num];
    
    $flight_price = $row[flight_price];
    $flight_start = $row[flight_start];
    $flight_back = $row[flight_back];
    $fly_start_date = $row[fly_start_date];
    $fly_start_time = $row[fly_start_time];
    $fly_back_time = $row[fly_back_time];
    $fly_time = $row[fly_time];
    $back_flight_ap_num = $row[flght_ap_num];
    
    
    $start_flight_price = ($flight_price*$anum)+($flight_price*0.5*$cnum)+($flight_price*0.3* $bnum);
    $start_flight_price1 = number_format($start_flight_price);   //콤마찍기
  
    echo "<tr>
        <td>$rnum</td>
        <td>$flight_start - $flight_back</td>
        <td>$name</td>
        <td>성인 : $anum 명</td>
        <td>어린이 : $cnum 명</td>
        <td>유아 : $bnum 명</td>
        <td>$start_flight_price1 원</td>
        </tr>";
}

?>    
</table><br><hr id="hr1"><br><br>

 <table id="row_flight2">
    <tr id="row_flight2_tr1">
    <td width="370" height="40">귀 국 편</td>
    <td width="120" height="40">항공 번호</td>
    <td width="120" height="40">날 짜</td>
    <td width="120" height="40">시 간</td>
    <td width="100" height="40">운행 시간</td>
    <td width="150" height="40">운 임</td>
    <td width="70" height="40">선 택</td>
  
    </tr>
<?php   

$sql = "select * from flight_one_way f inner join reserve_info r on f.flght_ap_num = r.back_apnum";

$result = mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
$total_record = mysqli_num_rows($result);
if($total_record == 0){
?>
    <tr>
    <td colspan="7"><br>[항목없음]<br><br></td>
    </tr>
    
    </table>
    <?php 
}
while($row = mysqli_fetch_array($result)){
    $no = $row[no];
    $flight_price = $row[flight_price];
    $flight_start = $row[flight_start];
    $flight_back = $row[flight_back];
    $fly_start_date = $row[fly_start_date];
    $fly_start_time = $row[fly_start_time];
    $fly_back_time = $row[fly_back_time];
    $fly_time = $row[fly_time];
    $back_flight_ap_num = $row[flght_ap_num];
    $record_num = $row[recordNum];
    
   
  
    echo "<tr>
        <td>$flight_start - $flight_back</td>
        <td>$back_flight_ap_num</td>
        <td>$fly_start_date</td>
        <td>$fly_start_time - $fly_back_time</td>
        <td>$fly_time</td>
        <td>$flight_price 원</td>
        <td><input type='radio' value='back_$no' name='back_check' id='back_check' style='width:20px;height:20px;'></td>
        </tr>";
   
}

?> 
</table><br>

<table id='row_flight2'>
    <tr id='row_flight2_tr1'>
     <td width='100' height='40'>예약 번호</td>
    <td width='400' height='40'>귀 국 편</td>
    <td width='120' height='40'>이 름</td>
    <td width='120' height='40'>인 원</td>
    <td width='120' height='40'>인 원</td>
    <td width='120' height='40'>인 원</td>
    <td width='150' height='40'>총 운 임</td>
    
   
    </tr>
 <?php   
 $sql = "select * from membership m inner join reserve_info r on m.id = r.id
  inner join flight_one_way f on f.flght_ap_num = r.back_apnum";     

$result = mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
$total_record = mysqli_num_rows($result);
if($total_record == 0){
?>
    <tr>
    <td colspan="7"><br>[항목없음]<br><br></td>
    </tr>
    
    </table>
    <?php 
}
while($row = mysqli_fetch_array($result)){
    $name = $row[name];
    $total_price = $row[total_price];
    $anum = $row[adult_num];
    $bnum = $row[baby_num];
    $cnum = $row[chlid_num];
    $sapnum = $row[start_ap_num];
    $bapnum = $row[back_ap_num];
    $rnum = $row[reserve_num];
    
    $flight_price = $row[flight_price];
    $flight_start = $row[flight_start];
    $flight_back = $row[flight_back];
    $fly_start_date = $row[fly_start_date];
    $fly_start_time = $row[fly_start_time];
    $fly_back_time = $row[fly_back_time];
    $fly_time = $row[fly_time];
    $back_flight_ap_num = $row[flght_ap_num];
    
      
    $back_flight_price = ($flight_price*$anum)+($flight_price*0.5*$cnum)+($flight_price*0.3* $bnum);
    $back_flight_price1 = number_format($back_flight_price);   //콤마찍기
    
    echo "<tr>
        <td>$rnum</td>
        <td>$flight_start - $flight_back</td>
        <td>$name</td>
        <td>성인 : $anum 명</td>
        <td>어린이 : $cnum 명</td>
        <td>유아 : $bnum 명</td>
        <td>$back_flight_price1 원</td>
        </tr>";
}

?>    
</table>
<br><hr id="hr1"><br><br>
<?php 

if(!isset($start_flight_price1)){
    $start_flight_price1 =0;
}

if(!isset($back_flight_price1)){
    $back_flight_price1 =0;
}


$total = $start_flight_price +  $back_flight_price;

?>
<script>

aab('<?=$total?>');
</script>


 </form>
<div id="btn_cancel">

<input type="button" onclick="check_input()" value="예약취소">

</div>


</div>
<footer>
<?php include_once '../../common_lib/footer2.php';?>
</footer>

</body>
</html>