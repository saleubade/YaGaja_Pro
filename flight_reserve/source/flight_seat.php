<?php 

include '../../common_lib/createLink_db.php';
include './create_seat_state.php';
session_start();

if(!empty($_SESSION['id'])){
    $id = $_SESSION['id'];
}else{
    $id = "?";
}

if(!empty($_GET['fly'])){
    $fly = $_GET['fly'];
}else{
    $fly = "asd?";
} 

if(!empty($_GET['start_check'])){
    $start_check = $_GET['start_check'];
}else{
    $start_check = "?";
}
if(!empty($_GET['back_check'])){
    $back_check = $_GET['back_check'];
}else{
    $back_check = "?";
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
if(!empty($_GET['rs_num'])){
    $rs_num = $_GET['rs_num'];
}else{
    $rs_num = "?";
}

if(!empty($_GET['rs_cnt'])){
    $rs_cnt = $_GET['rs_cnt'];
}else{
    $rs_cnt = "?";
}

if(!empty($_GET['start_flight_ap_num'])){
    $start_flight_ap_num = $_GET['start_flight_ap_num'];
}else{
    $start_flight_ap_num = "?";
}

if(!empty($_GET['back_flight_ap_num'])){
    $back_flight_ap_num = $_GET['back_flight_ap_num'];
}else{
    $back_flight_ap_num = "?";
}

echo $fly, $start, $back, $start_check ,$back_check, $rs_num,'--'. $rs_cnt, $start_flight_ap_num, $back_flight_ap_num;

?>



<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link type="text/css" rel="stylesheet" href="../css/ticket1.css?ver=1">
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>

<script type="text/javascript">
function flight_next_page(){	
	alert('좌석배치되었습니다. 즐거운 여행 되세요');
	location.href="reserve.php";   
}

var seat_id;
var count = 0;
function select_seat(obj, num, seatnum){//button , rs_cnt, $i,
    if(obj.style.backgroundColor == "yellow" && (count >= 0 && count <= num)){		//선택좌석이고 카운트가 0~3
    	if(count == num){		//카운트 3이면
    		if(obj.style.backgroundColor == "yellow"){		//선택좌석취소, 카운트 --
    			obj.style.backgroundColor = ""; 
    			count--;	//카운트 0이면
    		}
    	}
    	obj.style.backgroundColor = ""; //선택해제
    	if(count != 0){	//카운트가 0이 아니면 카운트 --;	==선택해제 시 카운트 감소
    		count--;
    	}
    }else if(obj.style.backgroundColor != "yellow" && (count >= 0 && count <= num)){	//선택좌석아니고 0~3일떄
    	if(count == num){return;} //3개까지만 선택하도록
    	obj.style.backgroundColor = "yellow"; 	//좌석선택시 색상
    	if(count != num){count++;} //카운트가 3아 아니면 카운트 ++; == 맨처음클릭시 선택하면서 카운트 증가
	}
    	
    	
    	seat_id = seatnum; //seat_id = $i (선택한 버튼의 번호임)
    	document.getElementById('no').innerHTML = seat_id;	///좌석번호  = 번호를 찍어줌
	
} 


function select_seat_ok(){
	for(var i=1; i <= 8; i++){
		var btn = document.getElementById('n_'+i);
	
	btn.disabled = "disabled";
	}
	
	
	
}
function input_check(a,b){
	
	seat_id = "seat"+seat_id;
	
	reserve_form.action = "reserve.php?seat="+seat_id+"&start_ap_num="+a+"&back_ap_num="+b;
	
    reserve_form.submit();  
	
}
</script>

</head>
<body>
<h1 style="margin:0 auto; text-align: center">FLIGHT TICKETING</h1><br>
<div id="ticket_box3">
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
        <td width='25%' bgcolor= '#dddddd'></td>
        <td width='25%' bgcolor='#dddddd' height=5></td>
        <td width='25%' bgcolor='#dddddd' height=5></td>
        <td width='25%' bgcolor='gray' height=5></td>";
?>
</tr>
</table><br>
<hr id="hr1">
<div id="select_ticket"><span style='font-size:15pt;'><br><br>좌석 배치</span>
<div style="text-align:right;">
<span style='font-size:12pt;'>예약불가 </span><input type='button' name='seat' value='' style='width:15pt;height:15pt;background:#2478FF'>
<span style='font-size:12pt;'>예약가능 </span><input type='button' name='seat' value='' style='width:15pt;height:15pt;'>&nbsp;&nbsp;
</div>
</div>

<img src="../image/ap_seat1.png" width='80%'>		<!-- 위  -->
<div id="seat_1">

<?php 

     
   if($start_check == "low_price_start" && $back_check == "low_price_back"){
        //최저가 티켓
        $sql = "select * from flight_one_way where flight_price =
(select min(flight_price) from flight_one_way where flight_start = '$start' and flight_back = '$back')";
        $result1 = mysqli_query($con,$sql) or die("실패원인1 : ".mysqli_error($con));
        $row = mysqli_fetch_array($result1);
        $start_flight_ap_num = $row[flght_ap_num];
   
        $sql = "select * from flight_one_way where flight_price =
(select min(flight_price) from flight_one_way where flight_start = '$back' and flight_back = '$start')";
        $result2 = mysqli_query($con,$sql) or die("실패원인2 : ".mysqli_error($con));
        $row = mysqli_fetch_array($result2);
       
        
    }else if($start_check == "low_price_start" && $back_check != "low_price_back"){
      
        $sql = "select * from flight_one_way where flight_price =
(select min(flight_price) from flight_one_way where flight_start = '$start' and flight_back = '$back')";
        $result1 = mysqli_query($con,$sql) or die("실패원인3 : ".mysqli_error($con));
        $row = mysqli_fetch_array($result1);
        
        //-----------------------------------------------------------------
        $back_recordnum = substr($back_check, 4);      //귀국편 선택한 티켓 번호
        
        $sql = "select * from flight_one_way where flight_start = '$back' and flight_back = '$start' and recordNum = '$back_recordnum' ";
        
        $result2 = mysqli_query($con,$sql) or die("실패원인4: ".mysqli_error($con));
        $row = mysqli_fetch_array($result2);
     
    }else if($start_check != "low_price_start" && $back_check == "low_price_back"){
        $start_recordnum = substr($start_check, 5);      //출국편 선택한 티켓 번호
        
        $sql = "select * from flight_one_way where flight_start= '$start' and flight_back='$back' and recordNum = '$start_recordnum' ";
        
        $result1 = mysqli_query($con,$sql) or die("실패원인5: ".mysqli_error($con));
        
        $row = mysqli_fetch_array($result1);
       
        //-----------------------------------------------------------------
        $sql = "select * from flight_one_way where flight_price =
(select min(flight_price) from flight_one_way where flight_start = '$back' and flight_back = '$start')";
        $result2 = mysqli_query($con,$sql) or die("실패원인6 : ".mysqli_error($con));
        $row = mysqli_fetch_array($result2);
       
        
    }else{
        $start_recordnum = substr($start_check, 5);      //출국편 선택한 티켓 번호
        
        $sql = "select * from flight_one_way where flight_start= '$start' and flight_back='$back' and recordNum = '$start_recordnum' ";
        $result1 = mysqli_query($con,$sql) or die("실패원인7: ".mysqli_error($con));
        $row = mysqli_fetch_array($result1);
       
        $back_recordnum = substr($back_check, 4);      //귀국편 선택한 티켓 번호
        
        $sql = "select * from flight_one_way where flight_start = '$back' and flight_back = '$start' and recordNum = '$back_recordnum' ";
        $result2 = mysqli_query($con,$sql) or die("실패원인8: ".mysqli_error($con));
        $row = mysqli_fetch_array($result2);
        
    }  

    
   if($start_check == "low_price_start"){
        //최저가 티켓
        $sql = "select * from flight_one_way where flight_price =
(select min(flight_price) from flight_one_way where flight_start = '$start' and flight_back = '$back')";
        $result1 = mysqli_query($con,$sql) or die("실패원인1 : ".mysqli_error($con));
        $row = mysqli_fetch_array($result1);
       
    }else{
        $start_recordnum = substr($start_check, 5);      //출국편 선택한 티켓 번호
        
        $sql = "select * from flight_one_way where flight_start= '$start' and flight_back='$back' and recordNum = '$start_recordnum' ";
        $result1 = mysqli_query($con,$sql) or die("실패원인7: ".mysqli_error($con));
        
        $row = mysqli_fetch_array($result1);
      
    } 
    ?>
<form name="reserve_form" method="post">
<?php 


$count = 0;
for($i=1;$i<=8;$i++){
    $count++;
    if($seat.$i == "y"){
        ?>
        <input type="button" name="seat[]" value="<?=$i ?>" id="y_<?= $i?>" onclick="select_seat(this,<?= $rs_cnt ?>)" style='width:45px;height:45px;background:#2478FF'>
        <?php 
    }else{
        ?>
        <input type="button" name="seat[]" value="<?=$i ?>" id="n_<?=$i ?>" onclick="select_seat(this,<?= $rs_cnt ?>,<?= $i ?>)" style='width:45px;height:45px;'>
        
        <?php 
    }
    
    if($count <= 5){   
        echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";  //2줄띄움
    }            
    if($count == 4 ){   
        echo "<br><br>";  
        $count=0;         
    }
}
?>
</form>
</div>
<img src="../image/ap_seat2.png" width='80%'> <!-- 아래  -->
<input type="button" id="select_ok" value="선택완료" onclick="select_seat_ok()">

<div id="seat_info">
<div id="select_ticket"><span style='font-size:15pt;'>좌석 정보</span><br></div>
<div>선택가능한 좌석수 : <?= $rs_cnt ?> 개</div>
선택한 좌석 번호 : 
<?php 
echo "<div id='no'></div>";

?>
</div>
<div>

<input type="button" id="select_ok" value="좌석 예약하기" style=''>
</div>
</div>

</body>
</html>




