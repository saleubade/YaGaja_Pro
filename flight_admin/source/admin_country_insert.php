 <?php 
 include '../../common_lib/createLink_db.php';
 session_start();
 if(!empty($_SESSION['id'])){
     $id = $_SESSION['id'];
 }else{
     $id = "?";
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
	
    if(!document.country_form.area.value){
    	alert("출발지를 입력해주세요");
    	document.country_form.area.focus();
    	return ;
    }
    if(!document.country_form.city.value){
    	alert("도착지를 입력해주세요");
    	document.country_form.city.focus();
    	return ;
    }
   
  
	document.country_form.submit();
}



</script>
</head>
<body>
<?php 
    if(isset($mode) && ($mode == "search")){
        if(empty($search)){
            echo ("
            <script>
            window.alert('검색할 단어를 입력해 주세요')
            history.go(-1)
            </script>
");
            exit;
            
        }
        $sql= "select * from qna where $find like '%$search%' order by num desc";
    }else{
        
        $sql = "select * from $table order by num desc";
    }
    
    $result =mysqli_query($con, $sql);
    $total_record = mysqli_num_rows($result); //전체 레코드 수 

 ?>

<header>
<?php include_once '../../common_lib/top_login2.php';?>
</header>
<nav id="top">
<?php include_once '../../common_lib/main_menu2.php';?>
</nav>
<h1 style="padding-top:40px; margin:0 auto; margin-top:20px; text-align: center">COUNTRY INSERTING</h1><br>
<div id ="ticket_box0">
<div id="select_ticket"><h4>취항지 등록</h4></div>


<form action="country_insert.php" method="post" name="country_form">
<table class="table1">
<tr>
<td>지  역</td>
<td><input type="text" name="area" class="div_none" placeholder="ex)유럽"  autofocus></td>
</tr>

<tr>
<td>취 항 지</td>
<td><input type="text" name="city" class="div_none" placeholder="ex)바르셀로나(BCN)"  autofocus></td>
</tr>


</table>
</form>
<div id="btn_cancel">
<input id="flight_insert" type="button" onclick="check_input()" value="취항지 등록">
</div>
<br>
<div id="select_ticket"><h4>취항지 관리</h4></div>

      <form name="country_form2" action="admin_country_insert.php?mode=search" method="post">
          <div id="form_select">
       <select name="find"  style="height:22px;">
         <option value="area">지역</option>
         <option value="city">도시</option>
         </select>
         </div>
         
         <div id="form_search1"><input type="text" name="search"></div>
         <div id="form_search2"><input type="image" src="../image/list_search_button.gif"></div>
         <br>
      
       </form>  


  <table class="table3">
	<tr id="table1_header">
	<td style="width:95;">지 역</td>
	<td style="width:95;">도 시(취항지)</td>
	
	</tr>
</table>


   
</div><br><br><br><br><br>
<footer>
<?php include_once '../../common_lib/footer2.php';?>
</footer>
  
</body>
</html>
 
 
