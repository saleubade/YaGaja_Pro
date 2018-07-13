 <?php 
 include '../../common_lib/createLink_db.php';
 session_start();
 if(!empty($_SESSION['id'])){
     $id = $_SESSION['id'];
 }else{
     $id = "?";
 }
 
 if(!empty($_POST['start'])){
     $start = $_POST['start'];
 }else{
     $start = "출발지";
 }
 
 if(!empty($_POST['back'])){
     $back = $_POST['back'];
 }else{
     $back = "목적지";
 }
 


 ?>
<head>
<meta charset="UTF-8">
<title>TICKETING</title>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link type="text/css" rel="stylesheet" href="../../common_css/index_css3.css?var=1">
<link type="text/css" rel="stylesheet" href="../css/admin_ticket.css?v=3">
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<script type="text/javascript">
function check_input(){
	if(!document.select_form.start.value || !document.select_form.back.value){
		alert('출발지와 목적지를 설정하세요');
		return;
	}else{
		document.select_form.submit();		
	}

}



function start_area(){		
	window.open("../../flight/source/start_area.php", "", "left=400, top=50, width=600, height=650, status=no, scrollbars=yes");
}

function back_area(){		
	window.open("../../flight/source/back_area.php", "", "left=400, top=50, width=600, height=650, status=no, scrollbars=yes");
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
<h1 style="padding-top:40px; margin:0 auto; margin-top:20px; text-align: center">FLIGHT SELECTING</h1><br>
<div id ="ticket_box1">
<div id="select_ticket"><h4>항공권 관리</h4></div>

<?php 

$month = date('m');
$ten = substr($month,0,1);     // 1, 2,3, 4,5,6,7,8,9 

if($ten == 1){ //10, 11, 12
    $month = substr($month,1,2);
}

?>

<form action="flight_read.php" method="post" name="select_form">

<hr id="hr1"><br>
<div id="form_select">
     <table class="table2">
	<tr>
		<td><input type="text" name="start" class="select_flight" placeholder="출발지"  autofocus autocomplete="off" onclick="start_area()" ></td>
		<td><input type="text" name="back" class="select_flight" placeholder="목적지" autocomplete="off" onclick="back_area()"></td>
        <td><div id="form_search2"><input type="image" src="../image/list_search_button.gif" id="button_search"  onclick="check_input()"></div></td>
	</tr>
</table>
</div>  

    
    <hr id="hr1"><br>    <br><br>
   <hr id="hr1">
   <div id="spandiv"><span style="font-size: 15pt; font-weight: 500;"> [<?= $start ?>] - [<?= $back ?>] </span></div>
   <hr id="hr1"><br><br><br>

     <table class="table1"><!-- 장소 : 830px -->
	<tr id="table1_header">
	<td style="width:95;">출 발 지</td>
	<td style="width:95;">도 착 지</td>
	<td style="width:50;">항공 번호</td>
	<td style="width:55;">출 발 일</td>
	<td style="width:40;">출발시간</td>
	<td style="width:40;">도착시간</td>
	<td style="width:55;">운행 시간</td>
	<td style="width:55;">운 임</td>
	</tr>
	<?php 
	$sql = "select * from flight_one_way where flight_start='$start' and flight_back = '$back'";
	
	$result = mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
	$total_record = mysqli_num_rows($result);
	
/* 	$rows_scale=5;
	$pages_scale=2;
	
	// 전체 페이지 수 ($total_page) 계산
	$total_pages= ceil($total_record/$rows_scale);
	
	if(empty($_GET['page'])){
	    $page=1;
	}else{
	    $page = $_GET['page'];
	}
	
	// 현재 페이지 시작 위치 = (페이지 당 글 수 * (현재페이지 -1))  [[ EX) 현재 페이지 2일 때 => 3*(2-1) = 3 ]]
	$start_row= $rows_scale * ($page -1) ;
	
	// 이전 페이지 = 현재 페이지가 1일 경우. null값.
	$pre_page= $page>1 ? $page-1 : NULL;
	
	// 다음 페이지 = 현재페이지가 전체페이지 수와 같을 때  null값.
	$next_page= $page < $total_pages ? $page+1 : NULL;
	
	// 현재 블럭의 시작 페이지 = (ceil(현재페이지/블럭당 페이지 제한 수)-1) * 블럭당 페이지 제한 수 +1  [[  EX) 현재 페이지 5일 때 => ceil(5/3)-1 * 3  +1 =  (2-1)*3 +1 = 4 ]]
	$start_page= (ceil($page / $pages_scale ) -1 ) * $pages_scale +1 ;
	
	// 현재 블럭 마지막 페이지
	$end_page= ($total_pages >= ($start_page + $pages_scale)) ? $start_page + $pages_scale-1 : $total_pages; */
	

if($total_record == 0){
?>
    <tr>
    <td colspan="8" style="text-align: center;"><br>[항목없음]<br><br></td>
    </tr>
    
    </table>
<?php 
}
/* for($i=$start_row; ($i<$start_row+$rows_scale) && ($i< $total_record); $i++){
    //가져올 레코드 위치 이동
    mysqli_data_seek($result, $i); */
while($row = mysqli_fetch_array($result)){
   
    $flight_price = $row[flight_price];
    $flight_start = $row[flight_start];
    $flight_back = $row[flight_back];
    $fly_start_date = $row[fly_start_date];
    $fly_start_time = $row[fly_start_time];
    $fly_back_time = $row[fly_back_time];
    $fly_time = $row[fly_time];
    $start_flight_ap_num = $row[flght_ap_num];
  

    echo "<tr>
    <td>$flight_start</td>
    <td>$flight_back</td>
    <td>$start_flight_ap_num</td>
    <td>$fly_start_date</td>
    <td>$fly_start_time</td>
    <td>$fly_back_time</td>
    <td>$fly_time</td>
    <td>$flight_price 원</td>
    </tr>";
}

?>   
</table>
</div>
<div id='page_box' style="text-align: center;">
<?php
       /*  #----------------이전블럭 존재시 링크------------------#
        if($start_page > $pages_scale){
           $go_page= $start_page - $pages_scale;
           echo "<a id='before_block' href='flight_list.php?page=$go_page&start2=$start&back2=$back'> << </a>";   
        }
        #----------------이전페이지 존재시 링크------------------#
        if($pre_page){
            echo "<a id='before_page' href='flight_list.php?page=$pre_page&start2=$start&back2=$back'> < </a>";
        }
         #--------------바로이동하는 페이지를 나열---------------#
        for($dest_page=$start_page;$dest_page <= $end_page;$dest_page++){
           if($dest_page == $page){
                echo( "&nbsp;<b id='present_page'>$dest_page</b>&nbsp" );
            }else{
                echo "<a id='move_page' href='flight_list.php?page=$dest_page&start2=$start&back2=$back'> $dest_page </a>";
            }
         }
         #----------------이전페이지 존재시 링크------------------#
         if($next_page){  
             echo "<a id='next_page' href='flight_list.php?page=$next_page&start2=$start&back2=$back'> > </a>";
         }
         #---------------다음페이지를 링크------------------#
        if($total_pages >= $start_page+ $pages_scale){
          $go_page= $start_page+ $pages_scale;
          echo "<a id='next_block' href='flight_list.php?page=$go_page&start2=$start&back2=$back'> >> </a>";
         } */
?>      
   </div>
</form>


</div>
<footer>
<?php include_once '../../common_lib/footer2.php';?>
</footer>
  
</body>
</html>
 
 
