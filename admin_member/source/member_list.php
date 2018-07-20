<?php
include_once '../../common_lib/createLink_db.php';



?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Ya! Gaja~</title>
<link rel="stylesheet" href="../css/member_list.css">
<?php 


if(isset($_GET['mode'])){
    
$search_value = $_POST['search_value'];

$kind = $_POST['kind'];
   
}


if(empty($search_value)){
    $sql = "select * from membership";
}else if($kind=="id1"){
    $sql="select * from membership where id like '%$search_value%' ";
}else if($kind=="name1"){
    $sql="select * from membership where name like '%$search_value%' ";
}

    $result = mysqli_query($con, $sql) or die(mysqli_error($con)."ㅇㅇ");
    $total_record = mysqli_num_rows($result); //전체 레코드 수     

// 페이지 당 글수, 블럭당 페이지 수
$rows_scale=15;
$pages_scale=5;

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
$end_page= ($total_pages >= ($start_page + $pages_scale)) ? $start_page + $pages_scale-1 : $total_pages;

$number=$total_record- $start_row;

?>
 <script></script>
</head>
<body>
  <article class="main">
        <div id="head">
          <h1 style="display: inline;">Member List</h1>
          	<div style="display: inline-block; margin-top: 10px; float: right;">
          		
          		<form action="./member_list.php?mode=search" method="post" id="form1">
					<select name="kind">
						<option value="id1">아이디</option>
						<option value="name1">이름</option>
					</select>
        				<input type="text" name="search_value">
        				<input type="submit" value="검색" id="form1">
				</form>
            
            </div>
          
           
          
        </div>
        <hr style="border: 1px solid black;">
  		 <table id="memberlist">
       
         
         
      
      <?php 
      echo "<tr class='memberlist_tr' style='text-align:center;'>
                    <td width='128'>아이디</td>
                    <td width='124'>이름</td>
                    <td width='179.2'>성별</td>
                    <td width='181.2'>전화번호</td>
                    <td width='275.6'>이메일</td>
                    <td width='90'>회원추방</td>
                    </tr>";
      
 
      for($i=$start_row; ($i<$start_row+$rows_scale) && ($i< $total_record); $i++){
        //가져올 레코드 위치 이동
        mysqli_data_seek($result, $i);
        
        //하나 레코드 가져오기
        $row=mysqli_fetch_array($result);
        
        $item_id=$row["id"];
        $item_name=$row["name"];
        $gender=$row["gender"];
        if($gender == "male"){
            $item_gender = "남성";
        }else{
            $item_gender = "여성";
        }
        $item_phone=$row["phone"];
        $item_email=$row["email"];
     
   
        echo "<tr class='memberlist_tr2' style='text-align:center;'>
                    <td>$item_id</td>
                    <td>$item_name</td>
                    <td>$item_gender</td>
                    <td>$item_phone</td>
                    <td>$item_email</td>
                    <td style='text-align:center;'>&nbsp;&nbsp;<a href='delete_memberlist.php?id=$item_id'><button type='button' class='button'>삭제</button></a></td>
                    </tr>";
        echo"  <tr class='gray' bgcolor='#cccccc'><td colspan='7'></td></tr>";
      }
        ?>
      
   </table>
   <hr>
        <div style="text-align: right;"><a href='member_list.php'><input type='button' value='전체목록'></a></div>
   
    
     	<div id='page_box' style="text-align: center;">
		<?PHP 
                #----------------이전블럭 존재시 링크------------------#
                if($start_page > $pages_scale){
                   $go_page= $start_page - $pages_scale;
                   echo "<a id='before_block' href='message.php?mode=$mode&page=$go_page'> << </a>";   
                }
                #----------------이전페이지 존재시 링크------------------#
                if($pre_page){
                    echo "<a id='before_page' href='message.php?mode=$mode&page=$pre_page'> < </a>";
                }
                 #--------------바로이동하는 페이지를 나열---------------#
                for($dest_page=$start_page;$dest_page <= $end_page;$dest_page++){
                   if($dest_page == $page){
                        echo( "&nbsp;<b id='present_page'>$dest_page</b>&nbsp" );
                    }else{
                        echo "<a id='move_page' href='message.php?mode=$mode&page=$dest_page'>$dest_page</a>";
                    }
                 }
                 #----------------이전페이지 존재시 링크------------------#
                 if($next_page){  
                     echo "<a id='next_page' href='message.php?mode=$mode&page=$next_page'> > </a>";
                 }
                 #---------------다음페이지를 링크------------------#
                if($total_pages >= $start_page+ $pages_scale){
                  $go_page= $start_page+ $pages_scale;
                  echo "<a id='next_block' href='message.php?mode=$mode&page=$go_page'> >> </a>";
                 }
       ?>      
   </div>

      
     
      
         </article>
      
</body>
</html>