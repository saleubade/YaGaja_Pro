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
<link type="text/css" rel="stylesheet" href="../css/admin_ticket.css">
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

<?php 


?>

</div>
<footer>
<?php include_once '../../common_lib/footer2.php';?>
</footer>
  
</body>
</html>
 
 
