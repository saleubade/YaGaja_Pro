 <?php 
 include '../../common_lib/createLink_db.php';
 session_start();
 if(!empty($_SESSION['id'])){
     $id = $_SESSION['id'];
 }else{
     $id = "?";
 }
 
 if(!empty($_POST['reservenum'])){
     $reservenum = $_POST['reservenum'];
 }else{
     $reservenum = "";
 }
 
 if(!empty($_POST['userid'])){
     $userid = $_POST['userid'];
 }else{
     $userid = "";
 }
 if(!empty($_GET['rsnum'])){
     $rsnum = $_GET['rsnum'];
 }else{
     $rsnum = "";
 }
 
 
 ?>
<head>
<meta charset="UTF-8">
<title>TICKETING</title>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link type="text/css" rel="stylesheet" href="../../common_css/index_css3.css?var=1">
<link type="text/css" rel="stylesheet" href="../css/admin_ticket.css?v=8">
<link type="text/css" rel="stylesheet" href="../css/start_area1.css?v=4">
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<script type="text/javascript">
function check_input(){
	if(!document.select_form.reservenum.value){
		alert('예약번호를 입력하세요');
		return;
	}else{
		document.select_form.submit();		
	}

}

function aaa(a,b,c,d,e,f){
	$("#sp1").text(a);
	$("#sp2").text(b);
	$("#sp3").text(c);
	$("#sp4").text(d);
	$("#sp5").text(e);
	$("#sp6").text(f);
}

function bbb(a,b,c,d,e,f){
	$("#sp1-1").text(a);
	$("#sp2-1").text(b);
	$("#sp3-1").text(c);
	$("#sp4-1").text(d);
	$("#sp5-1").text(e);
	$("#sp6-1").text(f);
}

function aa(data){
	document.click_form.submit();
	
	document.click_form.reservenum.text(data);
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
<h1 style="padding-top:40px; margin:0 auto; margin-top:20px; text-align: center">FLIGHT SEAT CHECK</h1><br>
<div id ="ticket_box12">
<div id="select_ticket"><h4>좌석 확인</h4></div>
<?php 

$sql = "select * from reserve_info where id= '$id'";            //로그인된 아이디 예약정보 테이블에서 예약번호 뽑아내기

$result = mysqli_query($con,$sql) or die("실패원인4: ".mysqli_error($con));
$total_record = mysqli_num_rows($result);

if($total_record == 0){echo "<br>[항목없음]<br>";}
$array =[];
while($row = mysqli_fetch_array($result)){
    $rsnum = $row[reserve_num];
    $array[] = $rsnum;
}

//예약번호를 중복없이 로그인된 아이디에 출력해줌
echo "<span style='font-size:15pt; font-weight:550'>[$id]"."님 예약번호 : </span>";
for($i=0; $i < count($array); $i++){
    if($array[$i] != $array[$i+1] ){
        echo "
        <form method='post' action='flight_reserve_check.php?rsnum=$rsnum' name='click_form'>
        <a href='#'><span style='font-size:14pt; font-weight:550' onclick='aa(\"$rsnum\")'>$array[$i]&nbsp;</span></a>
        </form>
        ";
    }
}

?>

<form action="flight_reserve_check.php" method="post" name="select_form">
<hr id="hr1"><br>
<div id="form_select">
     <table class="table2">
	<tr>
		<td><input type="text" name="reservenum" class="select_flight" placeholder="ex)ABCD1234"  autofocus autocomplete="off" ></td>
        <td><div id="form_search2"><input type="image" src="../image/list_search_button.gif" id="button_search"  onclick="check_input()"></div></td>
        
	</tr>
</table>

</div>  
</form>
<hr id="hr1">
<div>
<?php 

$sql = "select * from reserve_info where reserve_num= '$reservenum'";        //검색한 예약번호를 기반으로 항공번호를 검색 편도=1개 왕복2개           

$result = mysqli_query($con,$sql) or die("실패원인4: ".mysqli_error($con));
$total_record = mysqli_num_rows($result);

if($total_record == 0){echo "<br>[검색 결과 없음]<br>";}

while($row = mysqli_fetch_array($result)){
    $sapnum = $row[start_apnum];

    $sql = "select * from seat_state where flght_ap_num= '$sapnum'";        //검색한 예약번호를 기반으로 항공번호를 검색 편도=1개 왕복2개
    
    $result = mysqli_query($con,$sql) or die("실패원인4: ".mysqli_error($con));
    $total_record = mysqli_num_rows($result);
    
    if($total_record == 0){echo "<br>[검색 결과 없음]<br>";}
    
    while($row = mysqli_fetch_array($result)){
        $choice_seat = $row[choice_seat];
    }
}

$sql = "select * from reserve_info where reserve_num= '$reservenum'";       

$result = mysqli_query($con,$sql) or die("실패원인4: ".mysqli_error($con));
$total_record = mysqli_num_rows($result);

while($row = mysqli_fetch_array($result)){
    $bapnum = $row[back_apnum];
    
    $sql = "select * from seat_state where flght_ap_num= '$bapnum'";       
    $result1 = mysqli_query($con,$sql) or die("실패원인4: ".mysqli_error($con));
    $total_record3 = mysqli_num_rows($result1);
    if($total_record == 1){
        $total_record3 =0;
    }
    if($total_record3 == 0){echo "<br>[검색 결과 없음]<br>";}
    
    while($row = mysqli_fetch_array($result1)){
        $choice_seat1 = $row[choice_seat];
    }
    
}

?>
<div id="select_ticket"><br><br>
<div id="box1">
<span id="sp1" style="font-size:17pt; font-weight: 550; margin-left:150px;"></span><span id="sp6"></span><span id="sp2" style="font-size:17pt; font-weight: 550;"></span>
<span id="sp3"  style="font-size:13pt; font-weight: 500;"></span>
<span id="sp4"  style="font-size:13pt; font-weight: 500;"></span> 
<span id="sp5"  style="font-size:13pt; font-weight: 500;"></span>

</div>

<div style="text-align:right;">
<span style='font-size:12pt;'>예매불가 </span><input type='button' name='seat' value='' style='width:15pt;height:15pt; background: gray'>
<span style='font-size:12pt;'>예매가능 </span><input type='button' name='seat' value='' style='width:15pt;height:15pt; background: white'>
</div>
</div>

<div style="text-align: center;"><img src="../image/ap_seat1.png" width='80%' >		<!-- 위  -->
<div id="seat_1"><br>


<?php
$sql = "select * from seat_state s inner join flight_one_way f on s.flght_ap_num = f.flght_ap_num where s.flght_ap_num ='$sapnum' and s.id='$id'";

$result = mysqli_query($con,$sql) or die("실패원인1: ".mysqli_error($con));
while($row = mysqli_fetch_array($result)){
 $choice_seat = $row[choice_seat];
 
 $start = $row[flight_start];
 $back = $row[flight_back];
 $fly_date = $row[fly_start_date];
 $fly_start_time = $row[fly_start_time];
 $fly_back_time = $row[fly_back_time];
 
 $str .= $choice_seat;      //예약된 좌석번호 누적해서 변수에 저장 ex) "/4/5/6" + "/1/2/3"+ "/65/78"
}
 $choice_seat = explode("/", $str);     // "/"를 기준으로 분리해서 배열에 저장 ex) $c[0]="", $c[1]="4", $c[2]="5", $c[2]="6"
 
 foreach ($choice_seat as $key => $val) {
     $seat[$val] = $val;    //배열에 원소수만큼 돌면서 $seat[4] = 4,  $seat[5] = 5, $seat[65] = 65
 }
 
for($i=1; $i<=100; $i++){
    if($seat[$i]==$i){
        echo "<button type='button' id='seat$i' class='seat' value='$i' style='background-color:gray;'>$i</button>";
    }else{
        echo "<button type='button' id='seat$i' class='seat' value='$i' style='background-color:white;'>$i</button>";
    }
    if($i== 13 || $i== 38 || $i== 63 || $i== 88){
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    }
    
    if($i%25 == 0){
        echo "<br>";
    }
    if($i%50 == 0){
        echo "<br><br>";
    }
}

for($i=1; $i<=100; $i++){
    if($seat[$i]==$i){
        $seatnum1 .= "$seat[$i]"."번"."&nbsp;";
    }
}

if($total_record == 0){
    echo "<script>aaa('예약번호를 입력해주세요.','','','','','');</script>";
}else{
    echo "<script>aaa('[$start]','[$back]','($fly_date)','($fly_start_time) -','($fly_back_time)',' → ');</script>";
    echo "<span style='font-size:15pt; font-weight:550; margin-left:-450px;'>[$id]님의 예매된 좌석 : $seatnum1</span><br><br>";
}

?>
</div>
<img src="../image/ap_seat2.png" style="width:80%; margin-bottom:-150px;"> <!-- 아래  --></div>
<br><br><br><br>

<?php
if($total_record3 == 0){        
    //검색된 항공권예약번호로 돌아오는 항공권을 검색한 레코드갯수가 0이면 돌아오는 항공편의 좌석정보를 띄우지 않음
}else{
?>
<div id="select_ticket"><br><br><br><br>
<div id="box1">
<span id="sp1-1" style="font-size:17pt; font-weight: 550; margin-left:150px;"></span>
<span id="sp6-1"></span>
<span id="sp2-1" style="font-size:17pt; font-weight: 550;"></span>
<span id="sp3-1"  style="font-size:13pt; font-weight: 500;"></span>
<span id="sp4-1"  style="font-size:13pt; font-weight: 500;"></span> 
<span id="sp5-1"  style="font-size:13pt; font-weight: 500;"></span>

</div>
<div style="text-align:right;">
<span style='font-size:12pt;'>예매불가 </span><input type='button' name='seat' value='' style='width:15pt;height:15pt; background: gray'>
<span style='font-size:12pt;'>예매가능 </span><input type='button' name='seat' value='' style='width:15pt;height:15pt; background: white'>
</div>
</div>
<br><br><br>
	<div style="text-align:center;"><img src="../image/ap_seat2.png" style="width:80%; transform:rotate(180deg);"> 	<!-- 위  -->
    <div id="seat_1"><br>
<?php
    
    $sql = "select * from seat_state s inner join flight_one_way f on s.flght_ap_num = f.flght_ap_num where s.flght_ap_num ='$bapnum' and s.id='$id'";
    
    $result = mysqli_query($con,$sql) or die("실패원인1: ".mysqli_error($con));
    $total_record = mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result)){
        $choice_seat = $row[choice_seat];
        
        $start = $row[flight_start];
        $back = $row[flight_back];
        $fly_date = $row[fly_start_date];
        $fly_start_time = $row[fly_start_time];
        $fly_back_time = $row[fly_back_time];
        
        $str2 .= $choice_seat;      //예약된 좌석번호 누적해서 변수에 저장 ex) "/4/5/6" + "/1/2/3"+ "/65/78"
    }
    $choice_seat2 = explode("/", $str2);     // "/"를 기준으로 분리해서 배열에 저장 ex) $c[0]="", $c[1]="4", $c[2]="5", $c[2]="6"
    foreach ($choice_seat2 as $key => $val) {
        $seat2[$val] = $val;    //배열에 원소수만큼 돌면서 $seat[4] = 4,  $seat[5] = 5, $seat[65] = 65
    }
    
    for($i=1; $i<=100; $i++){
        if($seat2[$i]==$i){
            echo "<button type='button' id='seat$i' class='seat' value='$i' style='background-color:gray;' disabled>-</button>";
        }else{
            echo "<button type='button' id='seat$i' class='seat' value='$i' style='background-color:white; '>$i</button>";
        }
        if($i== 13 || $i== 38 || $i== 63 || $i== 88){
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        
        if($i%50 == 0){
            echo "<br>";
        }
        if($i%25 == 0){
            echo "<br>";
        }
    }
    for($i=1; $i<=100; $i++){
        if($seat2[$i]==$i){
            $seatnum .= "$seat2[$i]"."번"."&nbsp;";
        }
    }
    if($total_record == 0){
        echo "<script>
                bbb('예약번호를 입력해주세요.','','','','','');
                </script>";
    }else{
        echo "<script>bbb('[$start]','[$back]','($fly_date)','($fly_start_time) -','($fly_back_time)',' → ');</script>";
        echo "<span style='font-size:15pt; font-weight:550; margin-left:-450px;'>[$id]님 예매된 좌석 : $seatnum</span><br><br>";
        
    }
?>
    </div>
    <img src="../image/ap_seat1.png" width='80%' style="transform:rotate(180deg);"></div>		<!-- 아래  -->
<?php
   
}//end of else
?>
<br><br><br>


  
</div><!-- end of ticketbox-->
</form>


</div>
<div style="clear:both"></div><br><br>
<footer>
<?php include_once '../../common_lib/footer2.php';?>
</footer>
  
</body>
</html>

 
