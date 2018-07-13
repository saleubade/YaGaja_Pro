<?php  
  session_start();

  unset($_SESSION['id']);
  unset($_SESSION['name']);
  echo "<script>
    alert('로그아웃되었습니다.');
    location.href='../../index.php';
  </script>";
?>