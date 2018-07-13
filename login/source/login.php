<?php

/*  로그인 버튼 시 팝업창이 뜬다.
 *  아이디저장 체크를 하고 로그인 할 시 아이디 값이 쿠키에 저장된다.
 *  id_find.php 아이디 찾기
 *  pw_find.php 비밀번호 찾기
 *  로그인 버튼 input_check()
 *  회원가입 버튼 membership/source/join_form.php
 *   
 *   */

  if(isset($_POST['id'])){
    $id = $_POST['id'];
  }
  if(isset($_POST['pw'])){
    $pw = $_POST['pw'];
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>로그인</title>
    <link rel="stylesheet" href="../css/login1.css">
    <script>
      function input_check(){
        if(!document.login_form.id.value){
          alert('아이디를 입력해주세요!');
          document.login_form.id.focus();
          return;
        }
        if(!document.login_form.pw.value){
          alert('비밀번호를 입력해주세요!');
          document.login_form.pw.focus();
          return;
        }
        document.login_form.submit();
      }
    </script>
  </head>
  <body>
    <table width="700">
      <tr height="20"></tr>
      <tr>
        <td width="200" ></td>
        <td id="main">
		<form name="login_form" action="login_db.php" method="post">
          <table>
            <tr>
              <td colspan="5"><img src="../image/login_top.png" width="800"></td>
            </tr>
            <tr height="8"></tr>
            <tr>
              <td width="120" id="first"></td>
              <td><label for="id">아이디</label></td>
              <?php
                if(isset($_COOKIE['cookie_id'])){
                  echo "<td><input type='text' name='id' size='30' value=".$_COOKIE['cookie_id']."></td>";
                }else if(isset($id)){
                  echo "<td><input type='text' name='id' size='30' value=$id readonly></td>";
                }else{
                  echo "<td><input type='text' name='id' size='30'></td>";
                }
                
                if(isset($_COOKIE['cookie_id'])){
                  echo "<td width='80'><input type='checkbox' name='save_id' value='1' checked>아이디저장</td>";                
                }else{
                  echo "<td width='80'><input type='checkbox' name='save_id' value='1'>아이디저장</td>";                
                }
              ?>
              <td width="120"></td>
            </tr>
            <tr>
              <td width="120"></td>
              <td align="left" width="80"><label for="pw">비밀번호</label></td>
              <?php  
                if(isset($pw)){
                  echo "<td width=180><input type='password' name='pw' size='30' value=$pw readonly></td>";
                }else{
                  echo "<td width='180'><input type='password' name='pw' size='30'></td>";
                }
              ?>
              <td><a href="#"><img src="../image/login_button.jpg" onclick="input_check()" style="width: 105px;"></a></td>
              <td width="120"></td>
            </tr>
            <tr height="20"></tr>
            <tr height="20"></tr>
            <tr>
              <td colspan="5" align="center">
                <a href="id_find.php">▷아이디찾기</a>&nbsp;&nbsp;&nbsp;
                <a href="pw_find.php">▷비밀번호찾기</a>&nbsp;&nbsp;&nbsp;
                <a href="#" onclick="mem()">▷회원가입</a>
                <script>
                  function mem(){
                    opener.location.href='../../membership/source/join_form.php';
                    window.close();
                  }
                </script>
              </td>
            </tr>
            <tr height="20"></tr>
          </table>
	</form>
        </td>
      </tr>
      <tr height="20">
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td></td>
        <td align="center"></td>
      </tr>
      <tr height="20">
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td></td>
        <td><img src="../../common_img/logo.png" style="margin-top: -60px;"></td>
      </tr>
    </table>

  </body>
</html>