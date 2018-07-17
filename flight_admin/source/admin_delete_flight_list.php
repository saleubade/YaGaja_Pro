<?php
include '../../common_lib/createLink_db.php';
session_start();

if(!empty($_GET['start_flight_ap_num'])){
    $start_flight_ap_num = $_GET['start_flight_ap_num'];
}else{
    $start_flight_ap_num = "";
}
    
    $sql="delete from flight_one_way where flght_ap_num ='$start_flight_ap_num' ";  
    $result=mysqli_query($con, $sql) or die("실패원인 : ".mysqli_error($con));
    
    echo"
    <script>
    alert('항공권 삭제 완료');
    location.href='admin_flight_list.php';
</script>
";

mysqli_close($con);
?>