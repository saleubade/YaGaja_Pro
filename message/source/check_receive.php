<?php
session_start();

$id = $_SESSION['id'];
$name = $_SESSION['name'];

$receive_id = $_POST['receive_id'];
$message_content =$_POST['message_content'];

$regist_day = date("Y-m-d (H:i)");

include_once '../../common_lib/createLink_db.php';

$sql ="select * from membership where id = '$receive_id'";
$result = mysqli_query($con, $sql);
$row=mysqli_fetch_array($result);
if(mysqli_num_rows($result) == 0){
    echo "<script>
            alert('잘못된 아이디 입니다.');
            window.history.go(-1);
          </script>";
}else if(empty($message_content)){
    echo "<script>
            alert('메세지를 입력해 주세요.');
            window.history.go(-1);
          </script>";
}else{
    $sql = "insert into message (recv_id,send_id,name,message,regist_day)";
    $sql .= "values('$receive_id', '$id', '$name', '$message_content', '$regist_day')";    
    mysqli_query($con, $sql) or die(mysqli_error($con));
   
    echo "<script>
            window.close();
            alert('전송됐습니다.');
          </script>";
    
}

?>