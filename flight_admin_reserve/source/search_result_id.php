<?php
include '../../common_lib/createLink_db.php';

?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link type="text/css" rel="stylesheet" href="../../common_css/index_css3.css?v=1">
<link type="text/css" rel="stylesheet" href="../css/ticket1.css?v=6">
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<script>
$(document).ready(function(){
	
	$(".abcd").click(function(){		//검색어에 키 누르면
		$("#src_rst1").hide();	
		var a = $(this).val();
		
		$.ajax({	//ajax로 이부분만 보내겠다.
			type : "post",		//post방식으로 
			url : "admin_flight_reserve.php",		
			data : {
				a : a
			},	 //보낼값들 
			error : function(){alert('통신실패1!!');},
			success : function(data){
				$("#asearch1").val(a);
			}
		});
	});
});


</script>

<?php

$search = $_POST["search"];

$sql = "select * from flight_one_way where id like '%$search%' order by id asc";
$result = mysqli_query($con, $sql) or die("실패원인12 " . mysqli_error($con));

while ($row = mysqli_fetch_array($result)) {
    $apnum = $row['flght_ap_num'];
    
    echo "<input type='button' value='$apnum' class='abcd' style='padding : 5px 5px; border:0px; background-color:white;'><br>";
}
    

?>