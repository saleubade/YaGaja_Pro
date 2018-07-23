<?php 
 include '../../common_lib/createLink_db.php';
 session_start();
 if(!empty($_SESSION['id'])){
     $id = $_SESSION['id'];
 }else{
     $id = "?";
 }
 if(!empty($_GET['fly'])){
     $fly = $_GET['fly'];
 }else{
     $fly = "";
 }
 if(!empty($_GET['start'])){
     $start = $_GET['start'];
 }else{
     $start = "";
 }
 if(!empty($_GET['back'])){
     $back = $_GET['back'];
 }else{
     $back = "";
 }
 if(!empty($_GET['start_day'])){
     $start_day = $_GET['start_day'];
 }else{
     $start_day = "";
 }
 if(!empty($_GET['back_day'])){
     $back_day = $_GET['back_day'];
 }else{
     $back_day = "";
 }
 
 if(!empty($_GET['num1'])){
     $adult_num = $_GET['num1'];
 }else{
     $adult_num = "없음";
 }
 if(!empty($_GET['num2'])){
     $child_num = $_GET['num2'];
 }else{
     $child_num = "없음";
 }
 if(!empty($_GET['num3'])){
     $baby_num = $_GET['num3'];
 }else{
     $baby_num = "없음";
 }
 
 ?>
 <!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>TICKETING</title>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link type="text/css" rel="stylesheet" href="../css/ticket1.css?var=1">
<link type="text/css" rel="stylesheet" href="../../common_css/index_css3.css?var=1">
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<script type="text/javascript">
function next_page(href2){	//항공권 선택 유효성 검사 && 선택한 티켓전달

	if($('input:radio[name=start_check]').is(':checked') && $('input:radio[name=back_check]').is(':checked')){
		var start = $('input:radio[name=start_check]:checked').val();
		var back = $('input:radio[name=back_check]:checked').val();
		
		location.href= href2;
		
	}else{
		alert('항공권을 선택해주세요.');
		return;
	}
}

function back_page(){
	location.href= "flight.php";
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
<h1 style="margin:0 auto; text-align: center">FLIGHT TICKETING</h1><br>
<div id="ticket_box0">
<p>
<br><hr id="hr1"><br><br>
&nbsp;1. 여정 선택  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
2. 항공편 선택  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
3. 스케줄 확인  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
4. 결과 조회  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
5. 좌석 확인  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<p>
<table width=700 border=0 height=18 cellspacing=5 cellpadding=0>
<tr>
<?php
   echo "
        <td width='20%' bgcolor=#dddddd></td>
        <td width='20%' bgcolor='#dddddd' height=5></td>
        <td width='20%' bgcolor='gray' height=5></td>
        <td width='20%' bgcolor='#dddddd' height=5></td>
        <td width='20%' bgcolor='#dddddd' height=5></td>";
   
   $timestamp1 = strtotime("$start_day -3 days"); //-3일
   $timestamp2 = strtotime("$start_day +7 days"); //+7일
   $start_day4 = date('y-m-d', $timestamp1);
   $start_day5 = date('y-m-d', $timestamp2);
   
   $start_day6 = "20".$start_day4;
   $start_day7 = "20".$start_day5;
  
?>
</tr>
</table><br>
<hr id="hr1"><br>
<div id="select_ticket"><h4>비행 스케줄</h4></div>
<div id="select_ticket"><h6>선택한 출국 일정(<?= $start_day ?>) 3일전 부터 7일 후(<?=$start_day6?> ~ <?=$start_day7 ?>) 까지의 비행스케줄입니다.</h6></div>


<?php
if($fly == 'round'){
?>
    <form name="select_ticket" method="post" action="flight_ok.php?fly=<?= $fly ?>&start=<?= $start ?>&back=<?= $back ?>
    &adult_num=<?= $adult_num ?>&child_num=<?= $child_num ?>&baby_num=<?= $baby_num ?>">
    <table id='row_flight2'>
    <tr id='row_flight2_tr1'>
    <td width='370' height='40'>출 국 편</td>
    <td width='100' height='40'>항공 번호</td>
    <td width='120' height='40'>날 짜</td>
    <td width='120' height='40'>시 간</td>
    <td width='100' height='40'>운행 시간</td>
    <td width='150' height='40'>운 임</td>
    <td width='80' height='40'>선 택</td>
    </tr>
 
 <?php 

 $sql = "select * from flight_one_way where flight_start = '$start' and flight_back = '$back' and fly_start_date >= '$start_day6' and fly_start_date <= '$start_day7' order by recordnum desc";
    $result = mysqli_query($con,$sql) or die("실패원인 : ".mysqli_error($con));
    $total_record = mysqli_num_rows($result);
   
    if($total_record == 0){
        ?>
        <tr>
        <td colspan="7">[항목없음]</td>
        </tr>
        
        </table>
        <br><br><br>
        <div id="button_div">
       	<input type="button" id="select_ok" value="이전" onclick="back_page()">
        </form>
        </div>
<?php  
    }else{  //total_Record != 0 
        
    while($row = mysqli_fetch_array($result)){
        $flight_price = $row[flight_price];
        $flight_start = $row[flight_start];
        $flight_back = $row[flight_back];
        $fly_start_date = $row[fly_start_date];
        $fly_start_time = $row[fly_start_time];
        $fly_back_time = $row[fly_back_time];
        $fly_time = $row[fly_time];
        $flight_ap_num = $row[flght_ap_num];
        $record_num = $row[recordNum];
     
        
     $i=0;
     $select_start = 'start'.$record_num;
        echo "<tr>
        <td>$flight_start - $flight_back</td>
        <td>$flight_ap_num</td>
        <td>$fly_start_date</td>
        <td>$fly_start_time - $fly_back_time </td>
        <td>$fly_time</td>
        <td>$flight_price 원</td>
        <td><input type='radio' value='$select_start' name='start_check' id='start_check' style='width:20px;height:20px;'></td>
        </tr>";
       $i++;
    }
  
}//end of  ifelse __total_Record  !=0
?>
    </table><br><br>
    
     <table id="row_flight2">
    <tr id="row_flight2_tr1">
    <td width="370" height="40">귀 국 편</td>
    <td width="100" height="40">항공 번호</td>
    <td width="120" height="40">날 짜</td>
    <td width="120" height="40">시 간</td>
    <td width="100" height="40">운행 시간</td>
    <td width="150" height="40">운 임</td>
    <td width="80" height="40">선 택</td>
    </tr>
<?php 
$sql = "select * from flight_one_way where flight_start = '$back' and flight_back = '$start' and fly_start_date >= '$start_day6' and fly_start_date <= '$start_day7' order by recordnum desc";
    
    $result = mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
    $total_record = mysqli_num_rows($result);
    
    if($total_record == 0){
?>
        <tr>
        <td colspan="7">[항목없음]</td>
        </tr>
        
        </table>
        <br><br><br>
        <div id="button_div">
       	<input type="button" id="select_ok" value="이전" onclick="back_page()">
        </form>
        </div>
<?php  
    }else{  //total_Record != 0 
        
        while($row = mysqli_fetch_array($result)){
            $flight_price = $row[flight_price];
            $flight_start = $row[flight_start];
            $flight_back = $row[flight_back];
            $fly_start_date = $row[fly_start_date];
            $fly_start_time = $row[fly_start_time];
            $fly_back_time = $row[fly_back_time];
            $fly_time = $row[fly_time];
            $flight_ap_num = $row[flght_ap_num];
            $record_num = $row[recordNum];
            
            $i=0;
            $select_back = 'back'.$record_num;
            echo "<tr>
        <td>$flight_start - $flight_back</td>
        <td>$flight_ap_num</td>
        <td>$fly_start_date</td>
        <td>$fly_start_time - $fly_back_time</td>
        <td>$fly_time</td>
        <td>$flight_price 원</td>
        <td><input type='radio' value='$select_back' name='back_check' id='back_check' style='width:20px;height:20px;'></td>
        </tr>";
            $i++;
            
        }//end of while
       ?>
        </table>
        <br><br><br>
        <div id="button_div">
        <input type="submit" id="select_ok" value="항공권 예매" >
        <input type="button" id="select_ok" value="이전" onclick="back_page()">
        </form>
        </div>
<?php 

    }//end of ifelse

  
}else{      //fly != round
    
?>
	<form name="select_ticket" method="post" action="flight_ok.php?fly=<?= $fly ?>&start=<?= $start ?>&back=<?= $back ?>
    &adult_num=<?= $adult_num ?>&child_num=<?= $child_num ?>&baby_num=<?= $baby_num ?>">
     <table id="row_flight2">
    <tr id="row_flight2_tr1">
    <td width="370" height="40">귀 국 편</td>
    <td width="100" height="40">항공 번호</td>
    <td width="120" height="40">날 짜</td>
    <td width="120" height="40">시 간</td>
    <td width="100" height="40">운행 시간</td>
    <td width="150" height="40">운 임</td>
    <td width="80" height="40">선 택</td>
    </tr>
    <?php 
    $sql = "select * from flight_one_way where flight_start = '$back' and flight_back = '$start' and fly_start_date >= '$start_day6' and fly_start_date <= '$start_day7' order by recordnum desc";
    
    $result = mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
    $total_record = mysqli_num_rows($result);
    
    if($total_record == 0){
   ?>
       
        <tr>
        <td colspan="7">[항목없음]</td>
        </tr>
        
        </table>
        <br><br><br>
        <div id="button_div">
  		<input type="button" id="select_ok" value="이전" onclick="back_page()">
        </form>
        </div>
        
    
    <?php
    }else{
        
        while($row = mysqli_fetch_array($result)){
            $flight_price = $row[flight_price];
            $flight_start = $row[flight_start];
            $flight_back = $row[flight_back];
            $fly_start_date = $row[fly_start_date];
            $fly_start_time = $row[fly_start_time];
            $fly_back_time = $row[fly_back_time];
            $fly_time = $row[fly_time];
            $flight_ap_num = $row[flght_ap_num];
            $record_num = $row[recordNum];
            
            $i=0;
            $select_back = 'back'.$record_num;
            echo "<tr>
        <td>$flight_start - $flight_back</td>
        <td>$flight_ap_num</td>
        <td>$fly_start_date</td>
        <td>$fly_start_time - $fly_back_time</td>
        <td>$fly_time</td>
        <td>$flight_price 원</td>
        <td><input type='radio' value='$select_back' name='back_check' id='back_check' style='width:20px;height:20px;'></td>
        </tr>";
            $i++;
        }
        ?>
     </table>
      <br><br><br>
     <div id="button_div">
     <input type="submit" id="select_ok" value="항공권 예매" >
     <input type="button" id="select_ok" value="이전" onclick="back_page()">
  </form>
  </div>
 <?php  
    }
   

}
?>

     
</div>
<footer>
  <?php include_once '../../common_lib/footer2.php';?>
  </footer>   
 