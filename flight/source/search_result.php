<?php
include '../../common_lib/createLink_db.php';


?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link type="text/css" rel="stylesheet" href="../../common_css/index_css3.css?v=1">
<link type="text/css" rel="stylesheet" href="../css/ticket1.css?v=8">
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<script>
	$(document).ready(function(){
		$(".abcd").click(function(){		//검색어에 키 누르면
			$("#src_rst").hide();	
			var a = $(this).val();
			$.ajax({	//ajax로 이부분만 보내겠다.
				type : "post",		//post방식으로 
				url : "flight.php",		
				data : {
					a : a
				},	 //보낼값들 
				error : function(){alert('통신실패1!!');},
				success : function(data){
				$("#asearch").val(a);
				}
			});
		});
	});

</script>


<?php

$search = $_POST["search"];

$sql = "select * from country where city like '%$search%' order by city asc";
$result = mysqli_query($con, $sql) or die("실패원인12 " . mysqli_error($con));
$total_record = mysqli_num_rows($result);

while ($row = mysqli_fetch_array($result)) {
    $city = $row['city'];
    
    echo "<input type='button' value='$city' class='abcd' style='padding : 5px 5px; border:0px; background-color:white;'><br>";
    
}
?>

