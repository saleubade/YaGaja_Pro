<?php
$flag1 = "NO";
$sql = "show tables from yagajadb";
$result10 = mysqli_query($con, $sql) or die("실패원인 : " . mysqli_error($con));

while ($row10 = mysqli_fetch_row($result10)) {
    if ($row10[0] === "gallery_ripple") {
        $flag1 = "OK";
        break;
    }
}

if ($flag1 !== "OK") {
    $sql = "create table gallery_ripple(
                num int not null auto_increment,
                id varchar(20) not null,
                parent int not null,
                name varchar(30) not null,
                content text not null,
                regist_day varchar(20),
                primary key(num)
            )";
    if (mysqli_query($con, $sql)) {
        echo "<script>
            alert('gallery_ripple 테이블이 생성되었습니다.')
          </script>";
    } else {
        echo "실패원인 : " . mysqli_error($con);
    }
}

?>


