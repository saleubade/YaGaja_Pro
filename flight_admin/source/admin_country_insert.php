 <?php 
 include '../../common_lib/createLink_db.php';
 session_start();
 if(!empty($_SESSION['id'])){
     $id = $_SESSION['id'];
 }else{
     $id = "?";
 }
 
 if(!empty($_POST['find'])){
     $find = $_POST['find'];
 }else{
     $find = "";
 }
 
 if(!empty($_POST['search'])){
     $search = $_POST['search'];
 }else{
     $search = "";
 }
 
 if(!empty($_GET['mode'])){
     $mode = $_GET['mode'];
 }else{
     $mode = "";
 }

 if(!empty($_POST['city2'])){
     $city2 = $_POST['city2'];
 }else{
     $city2 = "1";
 }
 
 if(isset($city2)){
     $modi_city = $city2;
 }else{
     $modi_city = null;
 }
 
 if(empty($_GET['page'])){
     $page=1;
 }else{
     $page = $_GET['page'];
 }
 
 ?>
<head>
<meta charset="UTF-8">
<title>TICKETING</title>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link type="text/css" rel="stylesheet" href="../../common_css/index_css3.css?var=1">
<link type="text/css" rel="stylesheet" href="../css/admin_ticket.css?v=4">
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

if(empty($search)){   //검색결과에 따라서 쿼리문 실행
    $sql = "select * from country order by countrynum desc";
}else if($find == "area"){
    $sql= "select * from country where area like '%$search%' order by area";
}else if($find == "city"){
    $sql= "select * from country where city like '%$search%' order by city";
}


/* if($modi_city =="1"){
    $sql= "select * from country where $find like '%$search%' order by countryNum desc";
}else{
    $sql= "select * from country where city = '$modi_city'";
} */
  /*   if(isset($mode) && ($mode == "search")){
        if(empty($search)){
            echo ("
            <script>
            window.alert('검색할 단어를 입력해 주세요')
            history.go(-1)
            </script>
            ");
            exit;
            
        }
        if($modi_city =="1"){
            $sql= "select * from country where $find like '%$search%' order by countryNum desc";
        }else{
            $sql= "select * from country where city = '$modi_city'";
        }
    }else{
       if($modi_city =="1"){
            $sql = "select * from country order by countryNum desc";
        }else{
            $sql= "select * from country where city = '$modi_city'";
        } 
        }*/

    
    $result =mysqli_query($con, $sql);
    $total_record = mysqli_num_rows($result); //전체 레코드 수 
  
    $rows_scale=15;
    $pages_scale=1;
    
    // 전체 페이지 수 ($total_page) 계산
    $total_pages= ceil($total_record/$rows_scale);
   
    
    // 현재 페이지 시작 위치 = (페이지 당 글 수 * (현재페이지 -1))  [[ EX) 현재 페이지 2일 때 => 3*(2-1) = 3 ]]
    $start_row= $rows_scale * ($page -1) ;
    
    // 이전 페이지 = 현재 페이지가 1일 경우. null값.
    $pre_page= $page>1 ? $page-1 : NULL;
    
    // 다음 페이지 = 현재페이지가 전체페이지 수와 같을 때  null값.
    $next_page= $page < $total_pages ? $page+1 : NULL;
    
    // 현재 블럭의 시작 페이지 = (ceil(현재페이지/블럭당 페이지 제한 수)-1) * 블럭당 페이지 제한 수 +1  [[  EX) 현재 페이지 5일 때 => ceil(5/3)-1 * 3  +1 =  (2-1)*3 +1 = 4 ]]
    $start_page= (ceil($page / $pages_scale ) -1 ) * $pages_scale +1 ;
    
    // 현재 블럭 마지막 페이지
    $end_page= ($total_pages >= ($start_page + $pages_scale)) ? $start_page + $pages_scale-1 : $total_pages;
    
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
	<td style="width:95;">수 정/삭 제</td>
	</tr>
<?php 

for($i=$start_row; ($i<$start_row+$rows_scale) && ($i< $total_record); $i++){
    //가져올 레코드 위치 이동
    mysqli_data_seek($result, $i);
    $row = mysqli_fetch_array($result);
    
    $area = $row[area];
    $city = $row[city];
    
    $j = $i+2;  //form번호 지정
    
    if(!($city == $modi_city)){      //같지 않음
        echo "<tr id='table2_header'>
        <form id='form$j' method='post' action='admin_country_insert.php'>   
        <input type='hidden' name='city2' value='$city'>

    	<td style='width:95;'>$area</td>
    	<td style='width:95;'>$city</td>
        <td style='width:95;'>
        <button type='submit' class='button' id='form$j'>수정 </button>
        <a href='admin_delete_country_list.php?city=$city'><button type='button' class='button'>삭제</button></a>
        </form>
        </td>
    	</tr>";
    }else{
        echo "<tr>
        <form id='form$j' method='post' action='admin_update_country_list.php'>
        <td><input size='16' type='text' name='area' value='$area'></td>
        <td><input size='16' type='text' name='city' value='$city'></td>
        <input type='hidden' name='city2' value='$city'>
        <td>
        <button type='submit' class='button' id='form$j' >완료</button>
        <a href='admin_delete_country_list.php?city=$city'><button type='button' class='button'>삭제</button></a>
        </td>
        </form>
        </tr>";
       
    }
}
	
?>
	
	

</table>
<?php
     /*    #----------------이전블럭 존재시 링크------------------#
        if($start_page > $pages_scale){
           $go_page= $start_page - $pages_scale;
           echo "<a id='before_block' href='admin_country_insert.php?page=$go_page'> << </a>";   
        }
        #----------------이전페이지 존재시 링크------------------#
        if($pre_page){
            echo "<a id='before_page' href='admin_country_insert.php?page=$pre_page'> < </a>";
        }
         #--------------바로이동하는 페이지를 나열---------------#
        for($dest_page=$start_page;$dest_page <= $end_page;$dest_page++){
           if($dest_page == $page){
                echo( "&nbsp;<b id='present_page'>$dest_page</b>&nbsp" );
            }else{
                echo "<a id='move_page' href='admin_country_insert.php?page=$dest_page'> $dest_page </a>";
            }
         }
         #----------------이전페이지 존재시 링크------------------#
         if($next_page){  
             echo "<a id='next_page' href='admin_country_insert.php?page=$next_page'> > </a>";
         }
         #---------------다음페이지를 링크------------------#
        if($total_pages >= $start_page+ $pages_scale){
          $go_page= $start_page+ $pages_scale;
          echo "<a id='next_block' href='admin_country_insert.php?page=$go_page'> >> </a>";
         } */
?>      
 
   
</div><br><br><br><br><br>
<footer>
<?php include_once '../../common_lib/footer2.php';?>
</footer>
  
</body>
</html>
 
 
