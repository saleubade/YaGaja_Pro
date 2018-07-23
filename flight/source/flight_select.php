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
<link type="text/css" rel="stylesheet" href="../css/ticket1.css?var=3">
<link type="text/css" rel="stylesheet" href="../../common_css/index_css3.css?var=1">
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
</head>
<body>

<header>
	<?php include_once '../../common_lib/top_login2.php';?>
</header>
<nav id="top">
	<?php include_once '../../common_lib/main_menu2.php';?>
</nav><br><br><br><br>

<h1 style="margin:0 auto; text-align: center">FLIGHT TICKETING</h1><br>
<div id="ticket_box5">

<p>
    <br><hr id="hr3"><br><br>
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
        <td width='25%' bgcolor= gray height=5></td>
        <td width='25%' bgcolor='#dddddd' height=5></td>
        <td width='25%' bgcolor='#dddddd' height=5></td>";
?>
	</tr>
</table><br> 
<?php    
if($fly == 'round'){        //왕복
    //서브쿼리 : 출발지, 도착지, 출발일 기준 가장 낮은 가격 검색(출국)
    //최저가 항공인 항공권 검색
    $sql = "select * from flight_one_way where flight_price =
            (select min(flight_price) from flight_one_way where flight_start = '$start' and flight_back = '$back' and fly_start_date = '$start_day')";
    $result1 = mysqli_query($con,$sql) or die("실패원인 : ".mysqli_error($con));
    
    while($row = mysqli_fetch_array($result1)){
        $start_flight_price_min = $row[flight_price];
        $start_fly_start_date = $row[fly_start_date];
        $start_fly_start_time = $row[fly_start_time];
        $start_fly_back_time = $row[fly_back_time];
        $start_fly_time = $row[fly_time];
        $start_flight_ap_num = $row[flght_ap_num];
    }
    
    //서브쿼리 : 출발지, 도착지, 출발일 기준 가장 낮은 가격 검색(귀국)
    //최저가 항공인 항공권 검색
    $sql = "select * from flight_one_way where flight_price =
            (select min(flight_price) from flight_one_way where flight_start = '$back' and flight_back = '$start' and fly_start_date = '$back_day')";
    $result2 = mysqli_query($con,$sql) or die("실패원인 : ".mysqli_error($con));
    
    while($row = mysqli_fetch_array($result2)){
        $back_flight_price_min = $row[flight_price];
        $back_flight_back = $row[flight_back];
        $back_fly_start_date = $row[fly_start_date];
        $back_fly_start_time = $row[fly_start_time];
        $back_fly_back_time = $row[fly_back_time];
        $back_fly_time = $row[fly_time];
        $back_flight_ap_num = $row[flght_ap_num];
    }
    $round_low_price = $start_flight_price_min + $back_flight_price_min;
?>
<hr id="hr3"><br><br><br>

<hr id='hr2'><br>
<div id="select_ticket" style="text-align:left;"><span style='font-size:16pt; margin-left:45px;'>선택 여정</span></div>

<hr id='hr2'><br><br><br><br>
<span style="font-size: 13pt;">출 국 편</span>
<span style="font-size: 13pt; margin-left:430px;">귀 국 편</span><br>

<div id='checked_flight'><?= $start ?>  → <?= $back ?></div>
<div id='checked_flight'><?= $back ?>  → <?= $start ?></div>
<hr id='hr2'><br>

<div id='select_ticket1' style="text-align:left;">
<span style='font-size:16pt;  margin-left:40px;'>항공권 선택</span>
</div>

<hr id="hr2"><br><br><br>
<div id='selected_flight1'><br>
    <div id='select_ticket'>
        <span style='font-size:15pt;'>최저가 항공</span><hr id='hr3' style="width:980px; margin-left:0px;">
        <?php $round_low_price = number_format($round_low_price);?>
        <div id="low_price">최저 운임 : <?= $round_low_price ?> 원</div>
    </div>
    <hr id='hr3' style="width:980px; margin-left:0px;"><br>

    <table id='row_flight'>
    	<tr id='row_flight_tr1'>
    		<td colspan='4'><?= $start ?> &nbsp; <span style="font-size: 20pt;">→</span>&nbsp;<?= $back ?></td>
    	</tr>
        <tr id='row_flight_tr2'>
        	<td colspan='4'><?= $start_fly_start_date ?>&nbsp; | &nbsp;<?= $start_fly_start_time ?> - <?= $start_fly_back_time ?>&nbsp; | &nbsp;<?= $start_fly_time ?> &nbsp;| &nbsp;직항편</td>
        </tr>
        <tr id='row_flight_tr3'>
            <form name="select_ticket" method="post" action="flight_ok.php?fly=<?= $fly ?>&start=<?= $start ?>&back=<?= $back ?>
            &adult_num=<?= $adult_num ?>&child_num=<?= $child_num ?>&baby_num=<?= $baby_num ?>">
            <td><input type='radio' name="start_check" value='low_price_start' style="width:30px; height:30px; margin:0 0 0 15px"></td>
            <td><span style="font-size:15pt;"><?= $start ?></span><br>
            	<div id="right"><span style="font-size:12pt;">(<?= $start_fly_start_time ?>)</span></div>
            </td>
            <td> <span style="font-size: 25pt;">→</span>  &nbsp;&nbsp;</td>
            <td><span style="font-size:15pt;"><?= $back ?></span><br>
            	<div id="right"><span style="font-size:12pt;">(<?= $start_fly_back_time ?>)</span><div>
            </td>
        </tr>
        <tr id='row_flight_tr4'>
        <?php $start_flight_price_min = number_format($start_flight_price_min);?>
        <td colspan='4'><span class="low_price"> 최저가 운임 : <?= $start_flight_price_min ?> 원</span></td>
        </tr>
    </table>
    
    <table id='row_flight1'>
        <tr id='row_flight_tr1'>
        	<td colspan='4'><?= $back ?> <span style="font-size: 20pt;">→</span>  <?= $start ?></td>
        </tr>
        <tr id='row_flight_tr2'>
        	<td colspan='4'><?= $back_fly_start_date ?>&nbsp; | &nbsp;<?= $back_fly_start_time ?> - <?= $back_fly_back_time ?>&nbsp; | &nbsp;<?= $back_fly_time ?>&nbsp; | &nbsp;직항편</td>
        </tr>
        <tr id='row_flight_tr3'>
            <td><input type='radio'name="back_check" value='low_price_back'  style="width:30px;height:30px; margin:0 0 0 15px"></td>
            <td><span style="font-size:15pt;"><?= $back ?></span><br>
            	<div id="right"><span style="font-size:12pt;">(<?= $back_fly_start_time ?>)</span></div>
            </td>
            <td><span style="font-size: 25pt;">→</span>  &nbsp;&nbsp;</td>
            <td><span style="font-size:15pt;"><?= $start ?></span><br>
            	<div id="right"><span style="font-size:12pt;">(<?= $back_fly_back_time ?>)</span></div>
            </td>
        </tr>
        <tr id='row_flight_tr4'>
        	<?php $back_flight_price_min = number_format($back_flight_price_min);?>
        	<td colspan='4'><span class="low_price"> 최저가 운임 : <?= $back_flight_price_min ?> 원</span></td>
        </tr>
    </table>
</div>
<br><br><br><br><hr id='hr3'><br><br>

<div id="selected_flight2"><br><br>
	<div id="select_ticket" style="text-align:left;"><span style='font-size:16pt; margin-left:-15px;'>운임별 선택</span></div>
    
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
    //선택한 출발지, 도착지, 출발일을 레코드넘을 내림차순으로 정렬 검색
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
        $flight_price =number_format($flight_price);
        
        $i=0;
        $select_start = 'start'.$record_num;    //라디오버튼의 value 값을 설정해서 연결해주는 역할 //날짜만 다른 항공에 레코드넘이 겹쳐버리는 현상 --수정필요
         
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
        $flight_price =number_format($flight_price);
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
</table><br><br><br>

	<div style="text-align:center;"><input type="submit"  value="다 음" style="width:100px; height:40px;"></div>
</div>
       
   
</div><!--end of ticketbox  -->
</form>

<?php 
}else{ //편도
    
    //서브쿼리 : 출발지, 도착지, 출발일을 기준으로 최저가격 검색
    //최저가격을 기준으로 항공권 검색
    $sql = "select * from flight_one_way where flight_price =
            (select min(flight_price) from flight_one_way where flight_start = '$start' and flight_back = '$back' and fly_start_date = '$start_day')";
    $result1 = mysqli_query($con,$sql) or die("실패원인 : ".mysqli_error($con));
    
    while($row = mysqli_fetch_array($result1)){
        $start_flight_price_min = $row[flight_price];
        $start_fly_start_date = $row[fly_start_date];
        $start_fly_start_time = $row[fly_start_time];
        $start_fly_back_time = $row[fly_back_time];
        $start_fly_time = $row[fly_time];
        $start_flight_ap_num = $row[flght_ap_num];
    }
?>
    
<hr id="hr3"><br><br><br>

<div id="select_ticket" style="text-align:left;"><span style='font-size:16pt; margin-left:45px;'>선택 여정</span></div>
<hr id='hr2'><br><br><br><br>
<span style="font-size: 13pt; margin-left:25px;">출 국 편</span><br>

<div id='checked_flight' style="margin-left:25px;"><?= $start ?>  - <?= $back ?></div>
<div id='select_ticket1' style="text-align:left;"><span style='font-size:16pt;  margin-left:40px;'>항공권 선택</span></div>

<hr id="hr2"><br><br><br>
<div id='selected_flight1'><br>
<div id='select_ticket'><span style='font-size:15pt;'>[최저가 항공]</span>
<hr id='hr3' style="width:980px; margin-left:0px;">

<?php $start_flight_price_min = number_format($start_flight_price_min);?>
<div id="low_price">최저 운임 : <?= $start_flight_price_min ?> 원</div></div>
<hr id='hr3' style="width:980px; margin-left:0px;"><br><br>

<table id='row_flight'>
    <tr id='row_flight_tr1'>
   		<td colspan='4'><?= $start ?> &nbsp; <span style="font-size: 20pt;"> → </span>  &nbsp;<?= $back ?></td>
    </tr>
    <tr id='row_flight_tr2'>
    	<td colspan='4'><?= $start_fly_start_date ?>&nbsp; | &nbsp;<?= $start_fly_start_time ?> - <?= $start_fly_back_time ?>&nbsp; | &nbsp;<?= $start_fly_time ?> &nbsp;| &nbsp;직항편</td>
    </tr>
    <form name="select_ticket" method="post" action="flight_ok.php?fly=<?= $fly ?>&start=<?= $start ?>&back=<?= $back ?>
    &adult_num=<?= $adult_num ?>&child_num=<?= $child_num ?>&baby_num=<?= $baby_num ?>">
    <tr id='row_flight_tr3'>
        <td><input type='radio' name="start_check" value='low_price_start' style="width:30px; height:30px; margin:0 0 0 15px"></td>
        <td><span style="font-size:15pt;"><?= $start ?></span><br>
        	<div id="right"><span style="font-size:12pt;">(<?= $start_fly_start_time ?>)</span></div></td>
        <td> <span style="font-size: 25pt;">→</span>  &nbsp;&nbsp;</td>
        <td><span style="font-size:15pt;"><?= $back ?></span><br>
        	<div id="right"><span style="font-size:12pt;">(<?= $start_fly_back_time ?>)</span></div></td>
    </tr>
    <tr id='row_flight_tr4'>
    	<td colspan='4'><span class="low_price"> 최저가 운임 : <?= $start_flight_price_min ?> 원</span></td>
    </tr>
</table>
</div><br><br><br><br>

<div id="selected_flight2"><br><br><br>
    <div id="select_ticket" style="text-align:left;"><span style='font-size:16pt; margin-left:45px;'>운임별 선택</span></div>
    <hr id='hr2'><br><br>

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

        $flight_price =number_format($flight_price);
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
</table><br><br><br><br><br>

<div id="button_div"><input type="submit"  value="다 음" style="width:100px; height:40px;"></div>

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

