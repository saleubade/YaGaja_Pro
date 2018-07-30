 <?php 
 include '../../common_lib/createLink_db.php';
 session_start();
 if(!empty($_SESSION['id'])){
     $id = $_SESSION['id'];
 }else{
     $id = "?";
 }
 
 if(!empty($_POST['apnum'])){
     $apnum = $_POST['apnum'];
 }else{
     $apnum = "";
 }
 
 if(!empty($_POST['userid'])){
     $userid = $_POST['userid'];
 }else{
     $userid = "";
 }
 
 
 ?>
<head>
<meta charset="UTF-8">
<title>TICKETING</title>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link type="text/css" rel="stylesheet" href="../../common_css/index_css3.css?var=1">
<link type="text/css" rel="stylesheet" href="../css/admin_ticket.css?v=9">
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<script type="text/javascript">
function check_input(){
	if(!document.select_form.apnum.value || !document.select_form.userid.value){
		alert('항공번호와 아이디를 입력하세요');
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

var auto = "on";
function btn_auto_action(){		//자동완성끄기 버튼
	if(auto=="on"){
		auto= "off";			//auto =off
		$("#src_rst").hide();	//자동완성 창 숨김
	}else if(auto=="off"){		//auto 가 off 이면
		auto= "on";				//auto 킴
	}
}

$(document).ready(function(){
$("#src_rst").hide();		//자동완성숨심
	$("#asearch").keyup(function(){		//검색어에 키 누르면
		if(auto=="on"){				//자동완성 on이면
			var search= $("#asearch").val();		//변수에 값저장
		
			if(search.length <= 0){		//검색어 길이가 0보다 작으면 
				$("#s_r_l").html("");		//자동완성 값 ""주고
				$("#src_rst").hide();		//자동완성 숨김
			}else{						
				$.ajax({	//ajax로 이부분만 보내겠다.
					type : "post",		//post방식으로 
					url : "search_result.php",		//search_Result.php로 이동
					data : "search="+search+"&index=ok", //보낼값들 
					success : function(data){		//성공하면 자동완성 보여줌.
						$("#src_rst").show();		
						$("#s_r_l").html(data);		//데이터 보여줌.
					}
				});
			}
		}
	});
});

var auto1 = "on";
function btn_auto_action1(){		//자동완성끄기 버튼
	if(auto1=="on"){
		auto1= "off";			//auto =off
		$("#src_rst1").hide();	//자동완성 창 숨김
	}else if(auto1=="off"){		//auto 가 off 이면
		auto1= "on";				//auto 킴
	}
}

$(document).ready(function(){
$("#src_rst1").hide();		//자동완성숨심
	$("#asearch1").keyup(function(){		//검색어에 키 누르면
		if(auto1=="on"){				//자동완성 on이면
			var search= $("#asearch1").val();		//변수에 값저장
		
			if(search.length <= 0){		//검색어 길이가 0보다 작으면 
				$("#s_r_l1").html("");		//자동완성 값 ""주고
				$("#src_rst1").hide();		//자동완성 숨김
			}else{						
				$.ajax({	//ajax로 이부분만 보내겠다.
					type : "post",		//post방식으로 
					url : "search_result_id.php",		//search_Result.php로 이동
					data : "search="+search+"&index=ok", //보낼값들 
					success : function(data){		//성공하면 자동완성 보여줌.
						$("#src_rst1").show();		
						$("#s_r_l1").html(data);		//데이터 보여줌.
					}
				});
			}
		}
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
<h1 style="padding-top:40px; margin:0 auto; margin-top:20px; text-align: center">FLIGHT SEAT CHECK</h1><br>
<div id ="ticket_box1">
<div id="select_ticket"><h4>좌석 확인</h4></div>

<form action="admin_flight_reserve.php" method="post" name="select_form">
<hr id="hr1"><br>
<div id="form_select">
     <table class="table2">
	<tr>
		<td>
			<input type="text" name="apnum" id="asearch" class="select_flight" size="15" placeholder="ex)B777-301"  autofocus autocomplete="off" >    
			<div id="src_rst">
        		<div id="s_r_l"></div>
            	<div id="btn_auto2" style="width : 178px; text-align: right;" onclick="btn_auto_action()"><a href='#'>자동완성 끄기</a></div>
    		</div>
    	</td>
		<td>
			<input type="text" name="userid" id="asearch1" class="select_flight" size="15" placeholder="ex)SOONG1298"  autofocus autocomplete="off" >
			<div id="src_rst1">
        		<div id="s_r_l1"></div>
            	<div id="btn_auto2" style="width : 178px; text-align: right;" onclick="btn_auto_action1()"><a href='#'>자동완성 끄기</a></div>
    		</div>
		</td>
        <td><div id="form_search2"><input type="image" src="../image/list_search_button.gif" id="button_search"  onclick="check_input()"></div></td>
        
	</tr>
</table>
 
</div>  
</form>
<hr id="hr1">
<div>
<div id="select_ticket"><span style='font-size:16pt;'><br><br>좌석 배치도</span><span style="font-size:15pt;"> &nbsp;(입력한 항공번호 : <?= $apnum ?>)&nbsp;</span><br>
<span id="sp1" style="font-size:13pt; font-weight: 500;"></span><span id="sp6"></span><span id="sp2" style="font-size:13pt; font-weight: 500;"></span>
<span id="sp3"  style="font-size:12pt; font-weight: 500;"></span><br>
<span id="sp4"  style="font-size:12pt; font-weight: 500; margin-left:75px;"></span><span id="sp5"  style="font-size:12pt; font-weight: 500; margin-left:140px;"></span>
<div style="text-align:right;">
<span style='font-size:12pt;'>예매불가 </span><input type='button' name='seat' value='' style='width:15pt;height:15pt; background: gray'>
<span style='font-size:12pt;'>예매가능 </span><input type='button' name='seat' value='' style='width:15pt;height:15pt; background: white'>
</div>
</div>

<img src="../image/ap_seat1.png" width='80%'>		<!-- 위  -->
<div id="seat_1"><br>

<?php
if(!$apnum){     //항공번호로 검색시 값이 넘어오지 않으면
  
    
    for($i=1; $i<=100; $i++){
        if($seat[$i]==$i){
            echo "<button type='button' id='seat$i' class='seat' value='$i' style='background-color:gray;' disabled>-</button>";
        }else{
            echo "<button type='button' id='seat$i' class='seat' value='$i' style='background-color:white;' disabled>$i</button>";
        }
        if($i== 13 || $i== 38 || $i== 63 || $i== 88){
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        
        if($i%50 == 0){
            echo "<br><br>";
        }
        if($i%25 == 0){
            echo "<br>";
        }
    }
}else{              //apnum이 넘어오면
    $sql = "select * from seat_state s inner join flight_one_way f on s.flght_ap_num = f.flght_ap_num where s.flght_ap_num ='$apnum' and s.id = '$userid'";
    
    $result = mysqli_query($con,$sql) or die("실패원인1: ".mysqli_error($con));
    $total_record = mysqli_num_rows($result);
    
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
            echo "<button type='button' id='seat$i' class='seat' value='$i' style='background-color:gray;' disabled>-</button>";
        }else{
            echo "<button type='button' id='seat$i' class='seat' value='$i' style='background-color:white; '>$i</button>";
        }
        if($i== 13 || $i== 38 || $i== 63 || $i== 88){
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        
        if($i%50 == 0){
            echo "<br><br>";
        }
        if($i%25 == 0){
            echo "<br>";
        }
    }
}

for($i=1; $i<=100; $i++){
    if($seat[$i]==$i){
       $seatnum .= "$seat[$i]"."번"."&nbsp;";
    }
}

?>
<?php 

if($total_record == 0){
    echo "<script>
    aaa('검색하고 싶은 항공권 번호와 아이디를 올바르게 입력해주세요.','','','','','');
    </script>";
}else{
    echo "<script>aaa('[$start]','[$back]','($fly_date)','($fly_start_time)','($fly_back_time)',' → ');</script>";
    echo "<span style='font-size:15pt; font-weight:550;'>[$userid] 님이 예매한 좌석번호 : $seatnum</span><br><br>";
}

?>

</div>
<img src="../image/ap_seat2.png" style="width:80%; float:left;"> <!-- 아래  -->
</div>


<script type="text/javascript">


</script>

  
</div><!-- end of ticketbox-->
</form>


</div><br><br><br><br><br><br><br><br><br><br>
<footer>
<?php include_once '../../common_lib/footer2.php';?>
</footer>
  
</body>
</html>

 
