<?php
session_start();

include '../../common_lib/createLink_db.php';


$id=$_POST['id'];
$pnum=$_POST['pnum'];
$mode= "send";
srand((double)microtime()*1000000); //난수값 초기화
$password=rand(10000000,99999999);


$sms_phone=str_replace("-","", $pnum);



$sql = "select * from membership where id = '$id' and phone = '$pnum'";
$result=mysqli_query($con, $sql);
if(!mysqli_num_rows($result)){
    echo "<script> 
     alert('아이디와 전화번호가 일치하지 않습니다.');
     history.go(-1);
     </script>";
    exit();
}

$sql="update membership set pass='$password' where id='$id' and phone='$pnum' ";
mysqli_query($con, $sql)or die(mysqli_error($con));

//$mode = $_POST['mode'];

//건들지 마세요 ///////////////////////////////////////////////////////////////////////////////////////////////////
function SocketPost($posts) {
    $host = "jmunja.com";
    $target = "/sms/app/api.php";
    $port = 80;
    $socket  = fsockopen($host, $port);
    if( is_array($posts) ) {
        foreach( $posts AS $name => $value )
            $postValues .= urlencode($name)."=".urlencode( $value )."&";
            $postValues = substr($postValues, 0, -1);
    }
    
    $postLength = strlen($postValues);
    $request = "POST $target HTTP/1.0\r\n";
    $request .= "Host: $host\r\n";
    $request .= "Content-type: application/x-www-form-urlencoded\r\n";
    $request .= "Content-length: ".$postLength."\r\n\r\n";
    $request .= $postValues."\r\n";
    fputs($socket, $request);
    
    $ret = "";
    while( !feof($socket) ){
        $ret .= trim(fgets($socket,4096));
    }
    fclose( $socket );
    $std_bar = ":header_stop:";
    return substr($ret,(strpos($ret,$std_bar)+strLen($std_bar)));
}

//건들지 마세요 ///////////////////////////////////////////////////////////////////////////////////////////////////

if($mode == "send") {
 
    $title = "Ya! Gaja~ 임시비밀번호"; 
    $message = "Ya! Gaja~ 입니다. 임시번호는 [ $password ] 입니다. 로그인후 꼭 비밀번호를 변경 해주세요.";
    
    $array['mode']    = "send"; //'send' 고정
    $array['id']      = "kswoah123"; //제이문자 아이디 입력
    $array['pw']      = "62ac33ff4b43b6f390df291c22a71a"; //제이문자 API 인증키(로그인 비밀번호 아닙니다.!!!)
    $array['title']   = $title; //제목
    $array['message'] = $message; //내용
    $array['reqlist'] = $pnum."@"; //수신자: 휴대폰번호@이름|휴대폰번호@이름|휴대폰번호@이름
    
    $ret = SocketPost($array);
    if($ret) echo "<script>  
                       alert('임시 비밀번호가 휴대폰으로 발송 됐습니다.');
                       location.href='./login.php';
                    </script>";
    else echo "발송 실패";
    exit;
}


?>