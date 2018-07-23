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
    $fly = "?";
} 
if(!empty($_GET['start'])){
    $start = $_GET['start'];
}else{
    $start = "?";
}
if(!empty($_GET['back'])){
    $back = $_GET['back'];
}else{
    $back = "?";
}
if(!empty($_GET['adult_num'])){
    $adult_num = $_GET['adult_num'];
}else{
    $adult_num = "?";
}
if(!empty($_GET['child_num'])){
    $child_num = $_GET['child_num'];
}else{
    $child_num = "?";
}
if(!empty($_GET['baby_num'])){
    $baby_num = $_GET['baby_num'];
}else{
    $baby_num = "?";
}
if(!empty($_POST['start_check'])){
    $start_check = $_POST['start_check'];
}else{
    $start_check = "?";
}
if(!empty($_POST['back_check'])){
    $back_check = $_POST['back_check'];
}else{
    $back_check = "?";
}


//항공권 올바르게 선택됬는지 유효성 검사
if($fly == "round"){    //왕복
    
    if($start_check == "?" && $back_check == "?"){  //둘다 값을 넘겨받지 못했다면
      echo "<script>alert('항공권을 모두 선택해주세요.');
            history.go(-1);
            </script>";
    }elseif(!($start_check == "?") && $back_check == "?"){    //back_check을 못받았다면
       echo "<script>alert('귀국편 항공권을 선택해주세요.');
            history.go(-1);
            </script>";
    }elseif($start_check == "?" && !($back_check == "?")){    //start_check을 못받았다면
        echo "<script>alert('출국편 항공권을 선택해주세요.');
            history.go(-1);
            </script>";
    }
}else{  //one-way
    if($back_check == "?"){  //start_check을 못받았다면
        echo "<script>alert('항공권을 선택해주세요.');
            history.go(-1);
            </script>";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>TICKETING</title>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link type="text/css" rel="stylesheet" href="../../common_css/index_css3.css?var=1">
<link type="text/css" rel="stylesheet" href="../css/ticket1.css?var=1">
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>

<script type="text/javascript">
function updateReserveNum(url){		//다음 php파일로 이동
		location.href=url;	
}

function flight_back_page(){	
	history.go(-1);    	
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

<h1 style="margin:0 auto; text-align: center">FLIGHT TICKETING</h1><br>
<div id="ticket_box6">

<p>
    <br><hr id="hr3"><br><br>
    &nbsp;1. 여정 선택  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    2. 항공편 선택  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    3. 결과 조회  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    4. 좌석 확인  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<p>

<table width='550' border='0' height='18' cellspacing='5' cellpadding='0'>
	<tr>
<?php
   echo "
        <td width='25%' bgcolor= '#dddddd'></td>
        <td width='25%' bgcolor='#dddddd' height=5></td>
        <td width='25%' bgcolor='gray' height=5></td>
        <td width='25%' bgcolor='#dddddd' height=5></td>";
?>
	</tr>
</table><br>

<hr id="hr3">

<?php 

if($fly == 'round'){    ////왕복
    
    if($start_check == "low_price_start" && $back_check == "low_price_back"){   //출발 : 최저가 //도착 : 최저가 선택시
        $sql = "select * from flight_one_way where flight_price =
                (select min(flight_price) from flight_one_way where flight_start = '$start' and flight_back = '$back')";
        $result1 = mysqli_query($con,$sql) or die("실패원인1 : ".mysqli_error($con));
        $row = mysqli_fetch_array($result1);
        $start_flight_price = $row[flight_price];
        $start_flight_start = $row[flight_start];
        $start_flight_back = $row[flight_back];
        $start_fly_start_date = $row[fly_start_date];
        $start_fly_start_time = $row[fly_start_time];
        $start_fly_back_time = $row[fly_back_time];
        $start_fly_time = $row[fly_time];
        $start_flight_ap_num = $row[flght_ap_num];
        
        $sql = "select * from flight_one_way where flight_price =
                (select min(flight_price) from flight_one_way where flight_start = '$back' and flight_back = '$start')";
        $result2 = mysqli_query($con,$sql) or die("실패원인2 : ".mysqli_error($con));
        $row = mysqli_fetch_array($result2);
        $back_flight_price = $row[flight_price];
        $back_flight_start = $row[flight_start];
        $back_flight_back = $row[flight_back];
        $back_fly_start_date = $row[fly_start_date];
        $back_fly_start_time = $row[fly_start_time];
        $back_fly_back_time = $row[fly_back_time];
        $back_fly_time = $row[fly_time];
        $back_flight_ap_num = $row[flght_ap_num];
        
    }else if($start_check == "low_price_start" && $back_check != "low_price_back"){     //출발 : 최저가 //도착 : 최저가 미선택시
        //최저가 티켓
        $sql = "select * from flight_one_way where flight_price =
                (select min(flight_price) from flight_one_way where flight_start = '$start' and flight_back = '$back')";
        $result1 = mysqli_query($con,$sql) or die("실패원인3 : ".mysqli_error($con));
        $row = mysqli_fetch_array($result1);
        $start_flight_price = $row[flight_price];
        $start_flight_start = $row[flight_start];
        $start_flight_back = $row[flight_back];
        $start_fly_start_date = $row[fly_start_date];
        $start_fly_start_time = $row[fly_start_time];
        $start_fly_back_time = $row[fly_back_time];
        $start_fly_time = $row[fly_time];
        $start_flight_ap_num = $row[flght_ap_num];
        //--------------------------------------------------------------------------
        $back_recordnum = substr($back_check, 4);      //귀국편 선택한 티켓 번호(라디오버튼 value값에서 번호만 추출)
        
        $sql = "select * from flight_one_way where flight_start = '$back' and flight_back = '$start' and recordNum = '$back_recordnum' ";
        
        $result2 = mysqli_query($con,$sql) or die("실패원인4: ".mysqli_error($con));
        $row = mysqli_fetch_array($result2);
        $back_flight_price = $row[flight_price];
        $back_flight_start = $row[flight_start];
        $back_flight_back = $row[flight_back];
        $back_fly_start_date = $row[fly_start_date];
        $back_fly_start_time = $row[fly_start_time];
        $back_fly_back_time = $row[fly_back_time];
        $back_fly_time = $row[fly_time];
        $back_flight_ap_num = $row[flght_ap_num];
        
    }else if($start_check != "low_price_start" && $back_check == "low_price_back"){ //출발 : 최저가 미선택 //도착 : 최저가 선택시
        
        $start_recordnum = substr($start_check, 5);      //출국편 선택한 티켓 번호
        
        $sql = "select * from flight_one_way where flight_start= '$start' and flight_back='$back' and recordNum = '$start_recordnum' ";
        
        $result1 = mysqli_query($con,$sql) or die("실패원인5: ".mysqli_error($con));
        
        $row = mysqli_fetch_array($result1);
        $start_flight_price = $row[flight_price];
        $start_flight_start = $row[flight_start];
        $start_flight_back = $row[flight_back];
        $start_fly_start_date = $row[fly_start_date];
        $start_fly_start_time = $row[fly_start_time];
        $start_fly_back_time = $row[fly_back_time];
        $start_fly_time = $row[fly_time];
        $start_flight_ap_num = $row[flght_ap_num];
        //-----------------------------------------------------------------
        $sql = "select * from flight_one_way where flight_price =
                (select min(flight_price) from flight_one_way where flight_start = '$back' and flight_back = '$start')";
        $result2 = mysqli_query($con,$sql) or die("실패원인6 : ".mysqli_error($con));
        $row = mysqli_fetch_array($result2);
        $back_flight_price = $row[flight_price];
        $back_flight_start = $row[flight_start];
        $back_flight_back = $row[flight_back];
        $back_fly_start_date = $row[fly_start_date];
        $back_fly_start_time = $row[fly_start_time];
        $back_fly_back_time = $row[fly_back_time];
        $back_fly_time = $row[fly_time];
        $back_flight_ap_num = $row[flght_ap_num];
        
    }else{                                               //출발 : 최저가 미선택 //도착 : 최저가 미선택시
        $start_recordnum = substr($start_check, 5);      //출국편 선택한 티켓 번호
        
        $sql = "select * from flight_one_way where flight_start= '$start' and flight_back='$back' and recordNum = '$start_recordnum' ";
        
        $result1 = mysqli_query($con,$sql) or die("실패원인7: ".mysqli_error($con));
        
        $row = mysqli_fetch_array($result1);
        $start_flight_price = $row[flight_price];
        $start_flight_start = $row[flight_start];
        $start_flight_back = $row[flight_back];
        $start_fly_start_date = $row[fly_start_date];
        $start_fly_start_time = $row[fly_start_time];
        $start_fly_back_time = $row[fly_back_time];
        $start_fly_time = $row[fly_time];
        $start_flight_ap_num = $row[flght_ap_num];
        
        $back_recordnum = substr($back_check, 4);      //귀국편 선택한 티켓 번호
        
        $sql = "select * from flight_one_way where flight_start = '$back' and flight_back = '$start' and recordNum = '$back_recordnum' ";
        
        $result2 = mysqli_query($con,$sql) or die("실패원인8: ".mysqli_error($con));
        $row = mysqli_fetch_array($result2);
        $back_flight_price = $row[flight_price];
        $back_flight_start = $row[flight_start];
        $back_flight_back = $row[flight_back];
        $back_fly_start_date = $row[fly_start_date];
        $back_fly_start_time = $row[fly_start_time];
        $back_fly_back_time = $row[fly_back_time];
        $back_fly_time = $row[fly_time];
        $back_flight_ap_num = $row[flght_ap_num];
    }
    
    
    $total_flight_price = ($start_flight_price*$adult_num)+($start_flight_price*0.5*$child_num)+($start_flight_price*0.3* $baby_num)+
    ($back_flight_price*$adult_num)+($back_flight_price*0.5*$child_num)+($back_flight_price*0.3* $baby_num);
    //전체 결제 금액 산출식
    //성인 100%
    //어린이 50%
    //유아 30%
    
    $total_flight_price1 = number_format($total_flight_price);   //콤마찍기
    $start_flight_price1 =number_format($start_flight_price);
    $back_flight_price1 =number_format($back_flight_price);
//-----------------------------------------------------------------------------------예약번호 추출식 
$reservation_str = "";          //초기화

    for($i=0;$i<4;$i++) {       //4자리
        $capi = rand()%26+65;   //알파벳대문자 A~Z
        $reservation_str .= chr($capi); //str에 문자로 누적
    }
    
$reservation_num = mt_rand(1000, 9999);     //4자리 숫자 1000~9999 랜덤수 추출
$reservation_number = $reservation_str . $reservation_num;  //알파벳4문자 + 숫자4자리 = 예약번호 생성
//-----------------------------------------------------------------------------------
$reservation_str1 = "";

    for($i=0;$i<4;$i++) {
        $capi = rand()%26+65;
        $reservation_str1 .= chr($capi);
    }
$reservation_num2 = mt_rand(1000, 9999);
$reservation_number2 = $reservation_str1 . $reservation_num2;

    if($adult_num == "없음"){
        $adult_num = "0";
    }
    if($child_num == "없음" ){
        $child_num = "0";
    }
    if($baby_num == "없음"){
        $baby_num ="0";
    }
?>
<br><div id="select_ticket" style="text-align:left;"><span style='font-size:15pt;'>결제 금액</span></div>
  <div id="checked_flight1">총 결제금액 : <?= $total_flight_price1?>  원
  <span style='font-size:12pt;'>(성인 : <?= $adult_num ?> 명 + 어린이 : <?= $child_num ?> 명 + 유아 : <?= $baby_num ?> 명)<br></span>
   </div>

<div id="select_ticket" style="text-align:left;"><span style='font-size:15pt;'>예약 번호</span></div>
<div id="selected_flight3">예약번호  : <?= $reservation_number ?></div><br><br><br>
<div id="select_ticket" style="text-align:left;"><span style='font-size:15pt; '><br><br><br>예매 확인</span></div>
<div id="flight_ok_box">

<table id='row_flight'>
    <tr id='row_flight_tr1'>
    <td colspan='4'><?= $start ?> &nbsp; <span style="font-size: 20pt;">→</span>  &nbsp;<?= $back ?></td>
    </tr>
    <tr id='row_flight_tr2'>
    <td colspan='4'><?= $start_fly_start_date ?>&nbsp; | &nbsp;<?= $start_fly_start_time ?> - <?= $start_fly_back_time ?>&nbsp; | &nbsp;<?= $start_fly_time ?> &nbsp;| &nbsp;직항편</td>
    </tr>
    <tr id='row_flight_tr3'>
    <td><span style="font-size:15pt;"><?= $start ?></span><br><div id="right"><span style="font-size:12pt;">(<?= $start_fly_start_time ?>)</span></div></td>
    <td> <span style="font-size: 25pt;">→</span>  &nbsp;&nbsp;</td>
    <td><span style="font-size:15pt;"><?= $back ?></span><br><div id="right"><span style="font-size:12pt;">(<?= $start_fly_back_time ?>)</span><div></td>
    </tr>
    <tr id='row_flight_tr4'>
    <td colspan='4'><span class="low_price">항공편 운임 : <?= $start_flight_price1 ?> 원</span></td>
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
    <td><span style="font-size:15pt;"><?= $back ?></span><br><div id="right"><span style="font-size:12pt;">(<?= $back_fly_start_time ?>)</span></div></td>
    <td><span style="font-size: 25pt;">→</span>  &nbsp;&nbsp;</td>
    <td><span style="font-size:15pt;"><?= $start ?></span><br><div id="right"><span style="font-size:12pt;">(<?= $back_fly_back_time ?>)</span></div></td>
    </tr>
     </tr>
    <tr id='row_flight_tr4'>
    <td colspan='4'><span class="low_price">항공편 운임 : <?= $back_flight_price1 ?> 원</span></td>
    </tr>
    </table><br><br><br><br>

  <div id="button_div1">

  <a href="#" onclick="updateReserveNum('update_reserve_num.php?rs_num=<?=$reservation_number?>&total_price=<?=$total_flight_price?>&anum=<?=$adult_num?>&cnum=<?=$child_num?>&bnum=<?=$baby_num?>&start_check=<?= $start_check?>&back_check=<?= $back_check?>&start=<?= $start?>&back=<?= $back?>&fly=<?=$fly?>')">
  <input type="button" id="select_ok" value="완료" style='width:100px; height:30px;'></a>
  <input type="button" id="select_ok" value="취소" style='width:100px; height:30px;' onclick="flight_back_page()">
  </div>
    
</div>
</div>
<?php  
}else{      //편도

    if($start_check == "low_price_start"){
        //최저가 티켓
        $sql = "select * from flight_one_way where flight_price =
(select min(flight_price) from flight_one_way where flight_start = '$start' and flight_back = '$back')";
        $result1 = mysqli_query($con,$sql) or die("실패원인1 : ".mysqli_error($con));
        $row = mysqli_fetch_array($result1);
        $start_flight_price = $row[flight_price];
        $start_flight_start = $row[flight_start];
        $start_flight_back = $row[flight_back];
        $start_fly_start_date = $row[fly_start_date];
        $start_fly_start_time = $row[fly_start_time];
        $start_fly_back_time = $row[fly_back_time];
        $start_fly_time = $row[fly_time];
        $start_flight_ap_num = $row[flght_ap_num];

    }else{
        $start_recordnum = substr($start_check, 5);      //출국편 선택한 티켓 번호
        
        $sql = "select * from flight_one_way where flight_start= '$start' and flight_back='$back' and recordNum = '$start_recordnum' ";
        
        $result1 = mysqli_query($con,$sql) or die("실패원인7: ".mysqli_error($con));
        
        $row = mysqli_fetch_array($result1);
        $start_flight_price = $row[flight_price];
        $start_flight_start = $row[flight_start];
        $start_flight_back = $row[flight_back];
        $start_fly_start_date = $row[fly_start_date];
        $start_fly_start_time = $row[fly_start_time];
        $start_fly_back_time = $row[fly_back_time];
        $start_fly_time = $row[fly_time];
        $start_flight_ap_num = $row[flght_ap_num];
    }
    
    
    $total_flight_price = ($start_flight_price*$adult_num)+($start_flight_price*0.5*$child_num)+($start_flight_price*0.3* $baby_num);
    $total_flight_price = floor($total_flight_price)- ($total_flight_price % 10); //1의 자리이하 절삭
    
    $total_flight_price1 = number_format($total_flight_price);   //콤마찍기
    $start_flight_price1 =number_format($start_flight_price);
  
    ?>

<?php
$reservation_str = "";
for($i=0;$i<4;$i++) { 
    $capi = rand()%26+65;
    $reservation_str .= chr($capi);
}
$reservation_num = mt_rand(1000, 9999);

$reservation_number = $reservation_str . $reservation_num;

if($adult_num == "없음"){
    $adult_num = "0";
}
if($child_num == "없음" ){
    $child_num = "0";
}
if($baby_num == "없음"){
    $baby_num ="0";
}
?>
<br><div id="select_ticket" style="text-align:left;"><span style='font-size:15pt;'>결제 금액</span></div>
  <div id="checked_flight1">총 결제금액 : <?= $total_flight_price1?>  원
  <span style='font-size:12pt;'>(성인 : <?= $adult_num ?> 명 + 어린이 : <?= $child_num ?> 명 + 유아 : <?= $baby_num ?> 명)<br></span>
   </div>

<div id="select_ticket" style="text-align:left;"><span style='font-size:15pt;'>예약 번호</span></div>
<div id="selected_flight3">예약번호  : <?= $reservation_number ?></div><br><br><br>
<div id="select_ticket" style="text-align:left;"><span style='font-size:15pt; '><br><br><br>예매 확인</span></div>
<div id="flight_ok_box">
 <table id='row_flight1'>
    <tr id='row_flight_tr1'>
    <td colspan='4'><?= $start_flight_start ?> <span style="font-size: 20pt;">→</span>  <?= $start_flight_back ?></td>
    </tr>
    <tr id='row_flight_tr2'>
    <td colspan='4'><?= $start_fly_start_date ?>&nbsp; | &nbsp;<?= $start_fly_start_time ?> - <?= $start_fly_back_time ?>&nbsp; | &nbsp;<?= $start_fly_time ?>&nbsp; | &nbsp;직항편</td>
    </tr>
    <tr id='row_flight_tr3'>
    <td><span style="font-size:15pt;"><?= $start_flight_start ?></span><br><div id="right"><span style="font-size:12pt;">(<?= $start_fly_start_time ?>)</span></div></td>
    <td><span style="font-size: 25pt;">→</span>  &nbsp;&nbsp;</td>
    <td><span style="font-size:15pt;"><?= $start_flight_back ?></span><br><div id="right"><span style="font-size:12pt;">(<?= $start_fly_back_time ?>)</span></div></td>
    </tr>
    <tr id='row_flight_tr4'>
    <td colspan='4'><span class="low_price">항공편 운임 : <?= $start_flight_price1 ?> 원</span></td>
    </tr>
    </table><br><br><br><br>

 	
 	</div>
  <div id="button_div1">
   
  <a href="#" onclick="updateReserveNum('update_reserve_num.php?rs_num=<?=$reservation_number?>&total_price=<?=$total_flight_price?>&anum=<?=$adult_num?>&cnum=<?=$child_num?>&bnum=<?=$baby_num?>&start_check=<?= $start_check?>&back_check=<?= $back_check?>&start=<?= $start?>&back=<?= $back?>&fly=<?=$fly?>')">
  <input type="button" id="select_ok" value="완료" style='width:100px; height:30px;'></a>
  <input type="button" id="select_ok" value="취소" style='width:100px; height:30px;' onclick="flight_back_page()">
  </div>
</div>

    
<?php
}
?>


<footer>
<?php include_once '../../common_lib/footer2.php';?>
</footer>

</body>
</html>