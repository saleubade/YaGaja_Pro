<?php
   include_once "../../common_lib/createLink_db.php";
   
   $sql ="select * from survey";
   $result = mysqli_query($con, $sql);
   $row = mysqli_fetch_array($result);

   $ans1 = $row['ans1'];
   $ans2 = $row['ans2'];
   $ans3 = $row['ans3'];
   $ans4 = $row['ans4'];
   $ans5 = $row['ans5'];

?>
<html>
 <head>
  <title> Survey </title>
  <script>
  function pie_exit(){
	  window.close();
  }
  </script>
  	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  	<script type="text/javascript">
		//파이차트
		google.charts.load("current", {packages:['corechart']});
		google.charts.setOnLoadCallback(drawChart);
		function drawChart(){	
			var data = google.visualization.arrayToDataTable([
			['Task', 'using per reserve'],
			['Aisa \n(아시아)',     <?php echo $ans1; ?>],
			['Europe  \n(유럽)',      <?php echo $ans2; ?>],
			['America  \n(아메리카)',      <?php echo $ans3; ?>],
			['Afreeca  \n(아프리카)',      <?php echo $ans4; ?>],
			['Oceania  \n(오세아니아)',      <?php echo $ans5; ?>],
			]);			
			var options = {
				title: '가보고 싶은 여행지!'
			};
			var chart = new google.visualization.PieChart(document.getElementById('piechart'));
			chart.draw(data, options);
		}
	</script>
  <meta charset="utf-8">
 </head>
<body style="margin: 0px; padding: 0px;">
<div id="piechart" style="height: 400px;" >
</div>
<div style="text-align: center;">
<button onclick="pie_exit()">확인</button>
</div>
</body>
</html>

