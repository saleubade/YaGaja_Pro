<?php
include "../../common_lib/createLink_db.php";


if(!empty($_GET['no'])){
    $no = $_GET['no'];
}

$sql = "select * from shop_qna where qna_no = $no";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$depth1 = $row['qna_depth'];
$group_num = $row['qna_group_num'];
$ord1 = $row['qna_ord'];

if($depth1==0){
    $sql = "delete from shop_qna where qna_group_num= $group_num";
    mysqli_query($con, $sql) or die("실패원인 : " . mysqli_error_list($con));
}else{
    $sql = "select qna_depth, qna_ord from shop_qna where qna_group_num= $group_num and qna_ord > $ord1 order by qna_ord";
    $result = mysqli_query($con, $sql) or die("실패원인 : " . mysqli_error_list($con));
    $total_record = mysqli_num_rows($result);
    if($total_record==0){
        $sql = "delete from shop_qna where qna_ord= $ord1";
        mysqli_query($con, $sql) or die("실패원인 : " . mysqli_error_list($con));
    }else{
        for ($i = 0; $i <= $total_record; $i ++) {
            $row = mysqli_fetch_array($result);
            if ($row['qna_depth'] <= $depth1) {
                $sql = "delete from shop_qna where qna_ord=$ord1";
                mysqli_query($con, $sql) or die("실패원인 : " . mysqli_error_list($con));
                break;
            }
            $sql = "delete from shop_qna where qna_ord = {$row['ord']}";
            mysqli_query($con, $sql) or die("실패원인 : " . mysqli_error_list($con));
        }
    }
}
mysqli_close($con);


echo "
	   <script>
	    location.href = './shop_qna.php?page=1';
	   </script>
	";

?>