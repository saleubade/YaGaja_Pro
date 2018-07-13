<?php
session_start();

include '../../common_lib/createLink_db.php';
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

$id= $_SESSION['id'];
$name= $_SESSION['name'];

$subject= $_POST['subject'];

if($_POST['secret_ok']==="y"){
    $secret_ok= "y";
}else{
    $secret_ok= "n";
}

$content= $_POST['content'];
$page= $_GET['page'];


$regist_day= date("Y-m-d (H:i)");

// 답변 쓰기 일 때 ( $gno )
if(isset($_GET['mode']) && $_GET['mode']==="reply"){
    $gno= $_GET['gno'];
    $depth= $_GET['depth'];
    $sql = "select max( depth ) depth from qna where depth like '$depth%' and gno=$gno";
    
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    
    if ($row['depth'] != $depth)
        $depth = $depth.chr(ord(substr($row['depth'], - 1)) + 1);
    else
        $depth = $depth . "A";
    
    $sql= "insert into qna (num, gno, depth, id, name, subject, content, regist_day, hit, secret_ok) values ";
    $sql.= "(null, $gno, '$depth', '$id', '$name', '$subject', '$content', '$regist_day', 0, '$secret_ok')";
    
    $mode="답변";
    
// 글 수정일 때
}else if(isset($_GET['mode']) && $_GET['mode']==="update"){
    $num= $_GET['num'];
    
    $sql= "update qna set subject='$subject', content='$content', secret_ok='$secret_ok' where num=$num";

    $mode="수정";
    
// 새글 쓰기 일 때
}else{
    $sql= "select max( gno ) from qna";
    $result= mysqli_query($con, $sql);
    $row=mysqli_fetch_array($result);
    $gno=$row[0]+1;
    $depth= "A";
    
    $sql= "insert into qna (num, gno, depth, id, name, subject, content, regist_day, hit, secret_ok) values ";
    $sql.= "(null, $gno, '$depth', '$id', '$name', '$subject', '$content', '$regist_day', 0, '$secret_ok')";

    $mode="새";
}


$result= mysqli_query($con, $sql) or die(mysqli_error($con));

mysqli_close($con);

echo "<script> alert('$mode 글이 등록되었습니다. 페이지로 이동합니다.'); location.href='qna_list.php?page=$page'; </script>";

?>