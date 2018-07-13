<?php 
include '../../common_lib/createLink_db.php';
include './create_flight_one_way.php';
include './create_reserve_info.php';
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
<title>Insert title here</title>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link type="text/css" rel="stylesheet" href="../css/ticket1.css?var=1">
<link type="text/css" rel="stylesheet" href="../../common_css/index_css3.css?var=1">
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<script type="text/javascript">

function flight_next_page(href2){	//항공권 선택 유효성 검사 && 선택한 티켓전달

	if($('input:radio[name=start_check]').is(':checked') && $('input:radio[name=back_check]').is(':checked')){
		var start = $('input:radio[name=start_check]:checked').val();
		var back = $('input:radio[name=back_check]:checked').val();
		
		location.href= href2;
		
	}else{
		alert('항공권을 선택해주세요.');
		return;
	}


//-----------------------------------------------7/6일 출발지 목적지 출국일 귀국일 설정후 검색 오류해결

</script>
</head>
<body>

<?= $fly ,$start, $back ,$start_day ,$back_day, $seat_class , $adult_num, $child_num ,$baby_num ?>
<header>
<?php include_once '../../common_lib/top_login2.php';?>
</header>
<nav id="top">
<?php include_once '../../common_lib/main_menu2.php';?>
</nav>

<h1 style="margin:0 auto; text-align: center">FLIGHT TICKETING
</h1><br>
<div id="ticket_box1">
<p>
<br><hr id="hr1"><br><br>
&nbsp;1. 여정 선택  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
2. 항공편 선택  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
3. 결과 조회  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
4. 좌석 확인  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<p>
<table width=550 border=0 height=18 cellspacing=5 cellpadding=0>
<tr>
<?php
   echo "
        <td width='25%' bgcolor='#dddddd'></td>
        <td width='25%' bgcolor=gray height=5></td>
        <td width='25%' bgcolor='#dddddd' height=5></td>
        <td width='25%' bgcolor='#dddddd' height=5></td>";
?>
</tr>
</table><br> 
<?php    

if($fly == 'round'){        //왕복
    
    $sql = "select * from flight_one_way where flight_price =
(select min(flight_price) from flight_one_way where flight_start = '$start' and flight_back = '$back' and fly_start_date = '$start_day')";
    $result1 = mysqli_query($con,$sql) or die("실패원인 : ".mysqli_error($con));
    
    
    
    while($row = mysqli_fetch_array($result1)){
        $start_flight_price_min = $row[flight_price];
        
        $start_flight_start = $row[flight_start];
        $start_flight_back = $row[flight_back];
        
        $start_fly_start_date = $row[fly_start_date];
        $start_fly_start_time = $row[fly_start_time];
        $start_fly_back_time = $row[fly_back_time];
        $start_fly_time = $row[fly_time];
        $start_flight_ap_num = $row[flght_ap_num];
    }
    
    $sql = "select * from flight_one_way where flight_price =
(select min(flight_price) from flight_one_way where flight_start = '$back' and flight_back = '$start' and fly_start_date = '$back_day')";
    $result2 = mysqli_query($con,$sql) or die("실패원인 : ".mysqli_error($con));
    
    while($row = mysqli_fetch_array($result2)){
        $back_flight_price_min = $row[flight_price];
        
        $back_flight_start = $row[flight_start];
        $back_flight_back = $row[flight_back];
        
        $back_fly_start_date = $row[fly_start_date];
        $back_fly_start_time = $row[fly_start_time];
        $back_fly_back_time = $row[fly_back_time];
        $back_fly_time = $row[fly_time];
        $back_flight_ap_num = $row[flght_ap_num];
    }
    
    $round_low_price = $start_flight_price_min + $back_flight_price_min;
    
    ?>
<hr id="hr1"><br>
<div id="select_ticket"><span style='font-size:17pt;'>여정선택</span></div>
<div id='checked_flight'><?= $start ?>  >>>> <?= $back ?></div><div id='checked_flight'><?= $start ?>  >>>> <?= $back ?></div>
<hr id='hr1'><br>
<div id='select_ticket'>항공권 선택</div>

<div id='selected_flight1'><br>
<div id='select_ticket'><span style='font-size:15pt;'>[최저가 항공]</span>
<div id="low_price">최저운임 : <?= $round_low_price ?> 원</div></div><br>

    <table id='row_flight'>
    <tr id='row_flight_tr1'>
    <td colspan='4'><?= $start ?>  >>>> <?= $back ?></td>
    </tr>
    <tr id='row_flight_tr2'>
    <td colspan='4'><?= $start_fly_start_date ?> | <?= $start_fly_start_time ?> - <?= $start_fly_back_time ?> | <?= $start_fly_time ?> | 직항편</td>
    </tr>
    <tr id='row_flight_tr3'>
    <form name="select_ticket" method="post" action="flight_ok.php?fly=<?= $fly ?>&start=<?= $start ?>&back=<?= $back ?>
    &adult_num=<?= $adult_num ?>&child_num=<?= $child_num ?>&baby_num=<?= $baby_num ?>">
    <td><input type='radio' name="start_check" value='low_price_start' style="width:30px; height:30px; margin:0 -15px 0 15px"></td>
    <td><?= $start ?><br><?= $start_fly_start_time ?></td>
    <td>>>>></td>
    <td><?= $back ?><br><?= $start_fly_back_time ?></td>
    </tr>
    <tr id='row_flight_tr4'>
    <td colspan='4'><span class="low_price"> 최저가 운임 : <?= $start_flight_price_min ?> 원</span></td>
    </tr>
    </table>
    
    <table id='row_flight1'>
    <tr id='row_flight_tr1'>
    <td colspan='4'><?= $back ?>  >>>> <?= $start ?></td>
    </tr>
    <tr id='row_flight_tr2'>
    <td colspan='4'><?= $back_fly_start_date ?> | <?= $back_fly_start_time ?> - <?= $back_fly_back_time ?> | <?= $back_fly_time ?> | 직항편</td>
    </tr>
    <tr id='row_flight_tr3'>
    <td><input type='radio'name="back_check" value='low_price_back'  style="width:30px;height:30px; margin:0 -15px 0 15px"></td>
    <td><?= $back ?><br><?= $back_fly_start_time ?></td>
    <td>>>>></td>
    <td><?= $start ?><br><?= $back_fly_back_time ?></td>
    </tr>
     </tr>
    <tr id='row_flight_tr4'>
    <td colspan='4'><span class="low_price"> 최저가 운임 : <?= $back_flight_price_min ?> 원</span></td>
    </tr>
    </table>
    </div>
   
    <br><br><hr id='hr1'><br><br>
    <div id="selected_flight2">
    <div id='select_ticket'><span style='font-size:15pt;'>운임별 선택<br></span><br></div>
    
    <table id='row_flight2'>
    <tr id='row_flight2_tr1'>
    <td width='370' height='40'>출 국 편</td>
    <td width='80' height='40'>항공 번호</td>
    <td width='120' height='40'>날 짜</td>
    <td width='120' height='40'>시 간</td>
    <td width='100' height='40'>운행 시간</td>
    <td width='150' height='40'>운 임</td>
    <td width='80' height='40'>선 택</td>
    </tr>
   
    <?php 
    
        $sql = "select * from flight_one_way where flight_start = '$start' and flight_back = '$back' and fly_start_date = '$start_day' order by recordnum desc";
    
        $result = mysqli_query($con,$sql) or die("실패원인 : ".mysqli_error($con));
        $total_record = mysqli_num_rows($result);
        
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
  
    ?>
    <?php 
        
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
 
    ?>
    </table><br><br>
    
         <table id="row_flight2">
    <tr id="row_flight2_tr1">
    <td width="370" height="40">귀 국 편</td>
    <td width="80" height="40">항공 번호</td>
    <td width="120" height="40">날 짜</td>
    <td width="120" height="40">시 간</td>
    <td width="100" height="40">운행 시간</td>
    <td width="150" height="40">운 임</td>
    <td width="80" height="40">선 택</td>
    </tr>
<?php 


$sql = "select * from flight_one_way where flight_start = '$back' and flight_back = '$start' and fly_start_date = '$back_day' order by recordnum desc";

$result = mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
$total_record = mysqli_num_rows($result);

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
  <div id='select_ticket'><span style='font-size:15pt;'>예상운임<br></span></div>
  <!-- <div id="selected_flight3">예상 총 운임 : 원 </div>
  <div id="button_div"> -->
  <input type="submit" id="select_ok" value="항공권 예매"  >
  </td>
  </div>
       
   
</div>
</form>
 <?php 
 
 
}else{ //편도
    
    
    
    
    $sql = "select * from flight_one_way where flight_price =
(select min(flight_price) from flight_one_way where flight_start = '$start' and flight_back = '$back' and fly_start_date = '$start_day')";
    $result1 = mysqli_query($con,$sql) or die("실패원인 : ".mysqli_error($con));
    
    while($row = mysqli_fetch_array($result1)){
        $start_flight_price_min = $row[flight_price];
        
        $start_flight_start = $row[flight_start];
        $start_flight_back = $row[flight_back];
        
        $start_fly_start_date = $row[fly_start_date];
        $start_fly_start_time = $row[fly_start_time];
        $start_fly_back_time = $row[fly_back_time];
        $start_fly_time = $row[fly_time];
        $start_flight_ap_num = $row[flght_ap_num];
    }
    
   
    
    ?>
<hr id="hr1"><br>
<div id="select_ticket"><span style='font-size:17pt;'>여정선택</span></div>
<div id='checked_flight'><?= $start ?>  >>>> <?= $back ?></div><div id='checked_flight2'></div>
<hr id='hr1'><br>
<div id='select_ticket2'>항공권 선택</div>

<div id='selected_flight1'><br>
<div id='select_ticket'><span style='font-size:15pt;'>[최저가 항공]</span>
<div id="low_price">최저운임 : <?= $start_flight_price_min ?> 원</div></div><br>

    <table id='row_flight'>
    <tr id='row_flight_tr1'>
    <td colspan='4'><?= $start ?>  >>>> <?= $back ?></td>
    </tr>
    <tr id='row_flight_tr2'>
    <td colspan='4'><?= $start_fly_start_date ?> | <?= $start_fly_start_time ?> - <?= $start_fly_back_time ?> | <?= $start_fly_time ?> | 직항편</td>
    </tr>
    <tr id='row_flight_tr3'>
    <form name="select_ticket" method="post" action="flight_ok.php?fly=<?= $fly ?>&start=<?= $start ?>&back=<?= $back ?>
    &adult_num=<?= $adult_num ?>&child_num=<?= $child_num ?>&baby_num=<?= $baby_num ?>">
    <td><input type='radio' name="start_check" value='low_price_start' style="width:30px; height:30px; margin:0 -15px 0 15px"></td>
    <td><?= $start ?><br><?= $start_fly_start_time ?></td>
    <td>>>>></td>
    <td><?= $back ?><br><?= $start_fly_back_time ?></td>
    </tr>
    <tr id='row_flight_tr4'>
    <td colspan='4'><span class="low_price"> 최저가 운임 : <?= $start_flight_price_min ?> 원</span></td>
    </tr>
    </table>
    </div>
    <br><br><hr id='hr1'><br><br>
    <div id="selected_flight2">
    <div id='select_ticket'><span style='font-size:15pt;'>운임별 선택<br></span><br></div>
    
    <table id='row_flight2'>
    <tr id='row_flight2_tr1'>
    <td width='370' height='40'>출 국 편</td>
    <td width='80' height='40'>항공 번호</td>
    <td width='120' height='40'>날 짜</td>
    <td width='120' height='40'>시 간</td>
    <td width='100' height='40'>운행 시간</td>
    <td width='150' height='40'>운 임</td>
    <td width='80' height='40'>선 택</td>
    </tr>
    <?php 
        $sql = "select * from flight_one_way where flight_start = '$start' and flight_back = '$back' and fly_start_date = '$start_day' order by recordnum desc";
    
        $result = mysqli_query($con,$sql) or die("실패원인 : ".mysqli_error($con));
        $total_record = mysqli_num_rows($result);
        
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
    ?>
    <?php 
        
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
    ?>
    </table><br><br>
 
  <br><br><br>
  <div id="button_div">
  <input type="submit" id="select_ok" value="항공권 예매" >
 
  </div>
</div>
 </form>
<?php 
}
?>

<footer>
  <?php include_once '../../common_lib/footer2.php';?>
  </footer>     
</body>
</html>