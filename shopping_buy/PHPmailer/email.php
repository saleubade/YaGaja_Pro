<?php
session_start();
/*
 *  주요사항.
 *  1. 이메일 값 세팅
 *  2. 난수 초기화 후 세션값에 저장.
 *  3. 입력한 이메일로 난수값 전달.
 *  4. GET으로 이메일 전달.
 *   
 *   */
include './Sendmail.php';
//세팅이 안되있을시 빽
if(!isset($_POST['email1']) || !isset($_POST['email2'])){
    echo "<script> alert('접근 제한'); history.back(); </script>";
    exit;
}else{
    $email= $_POST['email1']."@".$_POST['email2'];
}


/* + $to : 받는사람 메일주소 ( ex. $to="hong <hgd@example.com>" 으로도 가능) +
 * $from : 보내는사람 이름 +
 *  $subject : 메일 제목 +
 *  $body : 메일 내용 +
 *  $cc_mail : Cc 메일 있을경우 (옵션값으로 생략가능) +
 *  $bcc_mail : Bcc 메일이 있을경우 (옵션값으로 생략가능) */

//세션값으로 나수 저장.

 
 srand((double)microtime()*1000000); //난수값 초기화 
 $_SESSION['code']=rand(100000,999999); 
 
$code=$_SESSION['code'];
$count=1;
$to=$email;
$from="관리자";
$subject="[MR_Library] 회원 가입 인증번호입니다.";
$body="[MR_Library] 회원가입 인증번호 입니다.\n인증번호 : ".$code."\n정확히 입력해주세요.";
$cc_mail="";
$bcc_mail=""; /* 메일 보내기*/

$sendmail->send_mail($to, $from, $subject, $body,$cc_mail,$bcc_mail); 


 echo "<script>
         location.href='../source/check_email_conf.php?email=$email';
     </script>";
?>