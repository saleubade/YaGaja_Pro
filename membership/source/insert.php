<meta charset=utf-8>
<?php

include '../../common_lib/createLink_db.php';    

// 아이디
$id= $_POST['id'];
// 암호
$pass= $_POST['pass'];
// 이름
$name= $_POST['name'];
// 생년월일
$year= $_POST['year'];
$month= $_POST['month'];
$day= $_POST['day'];

if($month<10){
    $month="0".$month;
}
if($day<10){
    $day= "0".$day;
}
$birth= $year."-".$month."-".$day;
// 성별
$gender= $_POST['gender'];
// 우편번호
$zip= $_POST['zip'];
// 주소
$address1= $_POST['address1'];
$address2= $_POST['address2'];
// 연락처
$hp= $_POST['hp1']."-".$_POST['hp2']."-".$_POST['hp3'];
// 이메일
$email=$_POST['email1']."@".$_POST['email2'];


    $sql= "insert into membership (id, pass, name, birth, gender, zip, address1,address2, phone, email) ";
    $sql.= "values ('$id', '$pass', '$name', '$birth', '$gender', '$zip', '$address1', '$address2', '$hp', '$email')";

    mysqli_query($con, $sql) or die(mysqli_error($con));


mysqli_close($con);

echo "<script>alert('회원가입이 완료되었습니다.')</script>";
echo "<script> location.href='../../index.php'; </script>";

?>