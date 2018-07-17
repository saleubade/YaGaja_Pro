<?php
    $flag1 ="NO";
    $sql = "show tables from yagaja_db";
    $result = mysqli_query($con, $sql) or die("실패원인:".mysqli_error($con));
      
      while($row = mysqli_fetch_row($result)){
          if($row[0] === "community_ripple"){
              $flag1 = "OK";
              break;
          }
      }
      
      if($flag1 !== "OK"){
          $sql = "create table community_ripple (
                num int not null auto_increment,
                id varchar(15) not null,
                continent char(15) not null,
                parent int not null,
                name varchar(20) not null,
                content text not null,
                regist_day varchar(20),
                primary key(num)
            )";
          if(mysqli_query($con, $sql)){
              echo "<script>
            alert('community_ripple 테이블이 생성되었습니다.')
          </script>";
          }else{
              echo "실패원인:".mysqli_error($con);
          }
      }
?>
      