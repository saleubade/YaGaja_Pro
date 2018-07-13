<?php
session_start();
include "../../common_lib/createLink_db.php";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>야! 가자~</title>
<link rel="stylesheet" href="../../common_css/index_css3.css">
<link rel="stylesheet" href="../css/map.css?ver=1">
<!-- 고유 CSS 맞춰주면 좋음 -->
</head>
<body onload=getGeolocation()>
	<header>
      <?php include "../../common_lib/top_login2.php"; ?>
    </header>
	<nav id="top">
      <?php include "../../common_lib/main_menu2.php"; ?>
    </nav>
	<section>

		<article class="main">
		
			<h1>찾아오시는길</h1>


			<div id="map">
				<img width="500" height="300" src="../img/staticmap.png";>
			</div>
			<script>
        var myDiv = document.getElementById("target");
        function getGeolocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showGeolocation);
            }
        }
        function showGeolocation(position) {
            var pos = position.coords.latitude + "," + position.coords.longitude;
            var url = "http://maps.googleapis.com/maps/api/staticmap?center="
            + pos + "&zoom=15&size=500x300&maptype=roadmap&key=AIzaSyDgpSjyuOul61MwVISX4eHrZpkzQP1VQFg";
            document.getElementById("map").innerHTML = "<img src='" + url + "'/>";
        }

    </script>

			<br /> 주소 : 서울특별시 성동구 무학로2길 54 신방<br /> 전화 : 02-441-6006<br />

			<h3>지하철이용</h3>
			<br /> 2, 5호선, 중앙선, 경의중앙선 : 왕십리역 1번, 2번출구에서 도보 5분<br />

			<br>
			<br>
			<br>
			<br>

		</article>
	</section>
	<footer>
      <?php include "../../common_lib/footer2.php"; ?>
    </footer>
</body>
</html>