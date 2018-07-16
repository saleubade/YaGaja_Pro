<?php
$flag = "NO";
$sql = "show tables from yagajadb";
$result = mysqli_query($con, $sql) or die("실패원인 : " . mysqli_error($con));

while ($row = mysqli_fetch_row($result)) { // mysqli_fetch_row = 쿼리문의 결과값이 들어있는 레코드셋에서 그 첫번째 레코드를 배열로 가져온다, 단 인덱스로 참조한다.
    if ($row[0] === "gallery") { // yagajadb에 테이블중에 첫번째 테이블이 gallery 이면 flag를 ok로 바꾸고 반복문 탈출(gallery 테이블이 있다는 소리)
        $flag = "OK";
        break;
    }
}
if ($flag !== "OK") { // 만약 위에 반복문 구문안에 조건식이 거짓이면 요 구문을 실행 -> $flag가 확실히 "OK"가 아니라면 gallery 테이블을 만든다.
    $sql = "create table gallery(
                num int not null auto_increment,
                id varchar(20) not null,
                name varchar(30) not null,
                continent char(15) not null,
                subject varchar(100) not null,
                content text not null,
                regist_day char(20),
                hit int,
                file_name_0 varchar(50),
                file_name_1 varchar(50),
                file_name_2 varchar(50),
                file_copy_0 varchar(45),
                file_copy_1 varchar(45),
                file_copy_2 varchar(45),
                primary key(num)
            )";
    if (mysqli_query($con, $sql)) {
        echo "<script>
                alert('gallery 테이블이 생성되었습니다.')
              </script>";
    } else {
        echo "실패원인:" . mysqli_error($con);
    }
}

?>