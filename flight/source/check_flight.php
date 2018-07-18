<?php
include '../../common_lib/createLink_db.php';
session_start();
if(!empty($_SESSION['id'])){
    $id = $_SESSION['id'];
}else{
    $id = "?";
}
if(!empty($_POST['fly'])){
    $fly = $_POST['fly'];
}else{
    $fly = "";
}
if(!empty($_POST['start'])){
    $start = $_POST['start'];
}else{
    $start = "";
}
if(!empty($_POST['back'])){
    $back = $_POST['back'];
}else{
    $back = "";
}
if(!empty($_POST['start_day'])){
    $start_day = $_POST['start_day'];
}else{
    $start_day = "";
}
if(!empty($_POST['back_day'])){
    $back_day = $_POST['back_day'];
}else{
    $back_day = "";
}

if(!empty($_POST['num1'])){
    $adult_num = $_POST['num1'];
}else{
    $adult_num = "0";
}
if(!empty($_POST['num2'])){
    $child_num = $_POST['num2'];
}else{
    $child_num = "0";
}
if(!empty($_POST['num3'])){
    $baby_num = $_POST['num3'];
}else{
    $baby_num = "0";
}

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link type="text/css" rel="stylesheet" href="../css/ticket1.css?ver=1">
<script type="text/javascript">
</script>
</head>
<body>
<?php 



if($fly == "round"){
    
    if($start == "" || $back == ""){
        echo "<script>alert('출발지 또는 목적지를 선택해주세요.');
                location.href='flight.php';
              </script>";
    }else if($start_day > $back_day || $start_day == "" || $back_day == ""){ //출발일보다 귀국일이 더 크면// 출발일o귀국일 없으면
        echo "<script>alert('올바른 날짜를 선택해주세요.');
                location.href='flight.php';
              </script>";
    }else if($adult_num == "0" && $child_num == "0" && $baby_num == "0"){
        echo "<script>alert('탑승인원을 선택해주세요.');
                location.href='flight.php';
              </script>";
    }
    
    $sql = "select * from flight_one_way where flight_start = '$start' and flight_back = '$back' and fly_start_date = '$start_day'";
    
    $result1 = mysqli_query($con,$sql) or die("실패원인 : ".mysqli_error($con));
    $total_record1 = mysqli_num_rows($result1);
    
    $sql = "select * from flight_one_way where flight_start = '$back' and flight_back = '$start' and fly_start_date = '$back_day'";
    
    $result2 = mysqli_query($con,$sql) or die("실패원인 : ".mysqli_error($con));
    $total_record2 = mysqli_num_rows($result2);
    
    if($total_record1 == 0 || $total_record2 == 0){ //레코드 검색결과 없으면
        echo "<script>alert('선택한 출발날짜에 해당하는 비행일정이 없습니다. \\n스케줄표를 확인합니다.');
              location.href ='flight_schedule.php?fly=$fly&start=$start&back=$back&start_day=$start_day&back_day=$back_day&num1=$adult_num&num2=$child_num&num3=$baby_num';
              </script>";
    }else{
        echo "<script>location.href ='flight_select.php?fly=$fly&start=$start&back=$back&start_day=$start_day&back_day=$back_day&num1=$adult_num&num2=$child_num&num3=$baby_num';
              </script>";
    }
    
}else{  //편도
    
    if($start == "" || $back == ""){
        echo "<script>alert('출발지 또는 목적지를 선택해주세요.');
                location.href='flight.php';
              </script>";
    }else if($start_day == ""){ //출발일 선택 안하면
        echo "<script>alert('올바른 날짜를 선택해주세요.');
                location.href='flight.php';
              </script>";
    }else if($adult_num == "0" && $child_num == "0" && $baby_num == "0"){
        echo "<script>alert('탑승인원을 선택해주세요.');
                location.href='flight.php';
              </script>";
    }
    
    $sql = "select * from flight_one_way where flight_start = '$start' and flight_back = '$back' and fly_start_date = '$start_day'";
    
    $result1 = mysqli_query($con,$sql) or die("실패원인 : ".mysqli_error($con));
    $total_record1 = mysqli_num_rows($result1);

    if($total_record1 == 0){ //레코드 검색결과 없으면
        echo "<script>alert('선택한 출발날짜에 해당하는 비행일정이 없습니다. \\n스케줄표를 확인합니다.');
              location.href ='flight_schedule.php?fly=$fly&start=$start&back=$back&start_day=$start_day&back_day=$back_day&num1=$adult_num&num2=$child_num&num3=$baby_num';
              </script>";
    }else{
        echo "<script>location.href ='flight_select.php?fly=$fly&start=$start&back=$back&start_day=$start_day&back_day=$back_day&num1=$adult_num&num2=$child_num&num3=$baby_num';
              </script>";
    }
    
}


?>
</body>
</html>