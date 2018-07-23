<?php
include '../../common_lib/createLink_db.php';
session_start();

if(!empty($_SESSION['id'])){
    $id = $_SESSION['id'];
}else{
    $id = "";
}
if(!empty($_POST['start_check'])){
    $start_check = $_POST['start_check'];
}else{
    $start_check = "";
}
if(!empty($_POST['back_check'])){
    $back_check = $_POST['back_check'];
}else{
    $back_check = "";
}

$start_check = substr($start_check,6,7);
$back_check = substr($back_check,5,6);


if($start_check && $back_check){      //출국 and 귀국 삭제
    $sql = "select start_apnum,reserve_num from reserve_info where no = '$start_check'";
    $result1 = mysqli_query($con,$sql) or die("실패원인1: ".mysqli_error($con));
    $row = mysqli_fetch_array($result1);
    $sapnum = $row[start_apnum];
    $reservenum = $row[reserve_num];

    $sql = "select * from reserve_info where no = '$back_check'";
    $result2 = mysqli_query($con,$sql) or die("실패원인1: ".mysqli_error($con));
    $row = mysqli_fetch_array($result2);
    $bapnum = $row[back_apnum];
    
    $sql = "select * from seat_state where flght_ap_num = '$sapnum' or flght_ap_num = '$bapnum'";
    $result3 = mysqli_query($con,$sql) or die("실패원인1: ".mysqli_error($con));
    while($row = mysqli_fetch_array($result3)){
        $apnum = $row[flght_ap_num];
        
        $sql = "delete from reserve_info where no = '$start_check' or no = '$back_check'";
        mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
        
        $sql = "delete from seat_state where flght_ap_num = '$apnum' and id = '$id'";
        mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
            
    }
    
    
}else if($start_check && !$back_check){ //출국만 삭제
    
    $sql = "select start_apnum,reserve_num from reserve_info where no = '$start_check'";
    $result1 = mysqli_query($con,$sql) or die("실패원인1: ".mysqli_error($con));
    $row = mysqli_fetch_array($result1);
    $sapnum = $row[start_apnum];
    $reservenum = $row[reserve_num];
    
    $sql = "select * from seat_state s inner join reserve_info r on s.id = r.id where flght_ap_num = '$sapnum'";
    $result2 = mysqli_query($con,$sql) or die("실패원인1: ".mysqli_error($con));
    while($row = mysqli_fetch_array($result2)){
        $apnum = $row[flght_ap_num];
        
        $sql = "delete from reserve_info where no = '$start_check'";
        mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
       
        $sql = "delete from seat_state where flght_ap_num = '$apnum' and id = '$id'";
        mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
    }
}else if(!$start_check && $back_check){ //귀국만 삭제
    $sql = "select back_apnum,reserve_num from reserve_info where no = '$back_check'";
    $result1 = mysqli_query($con,$sql) or die("실패원인1: ".mysqli_error($con));
    $row = mysqli_fetch_array($result1);
    $bapnum = $row[back_apnum];
    $reservenum = $row[reserve_num];
    
    $sql = "select * from seat_state where flght_ap_num = '$bapnum'";
    $result2 = mysqli_query($con,$sql) or die("실패원인1: ".mysqli_error($con));
    
    while($row = mysqli_fetch_array($result2)){
        $apnum = $row[flght_ap_num];
        
        $sql = "delete from reserve_info where no = '$back_check'";
        mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
        
        $sql = "delete from seat_state where flght_ap_num = '$apnum' and id='$id'";
        mysqli_query($con,$sql) or die("실패원인: ".mysqli_error($con));
    }
}

echo "<script>
     history.go(-1);
 alert('예매취소 되었습니다.');
    </script>";

?>
