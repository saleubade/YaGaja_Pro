<?php  
  include "../../common_lib/createLink_db.php";
  
  $id = $_POST['id'];
  $pnum = $_POST['pnum'];
  
  if(isset($id) && isset($pnum)){
    $sql = "select * from membership where id='$id' and phone='$pnum'";
    $result = mysqli_query($con,$sql) or die("실패원인 : ".mysqli_error($con));
    if(mysqli_num_rows($result)==0){
      echo "<script>
          alert('회원님의 정보가 존재하지 않습니다.');
        </script>";
    }else{
      $row = mysqli_fetch_array($result);
      $pw = $row['pass'];
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>비밀번호 찾기</title>
    <link rel="stylesheet" href="../css/find.css">
    <script>
      function input_check(){
        if(!document.login_form.id.value){
          alert('아이디를 입력해주세요!');
          document.login_form.id.focus();
          return;
        }
        if(!document.login_form.pnum.value){
          alert('전화번호를 입력해주세요!');
          document.login_form.pw.focus();
          return;
        }
        document.login_form.submit();
      }
      function cancel(){
     	 history.go(-1);
      }
    </script>
  </head>
  <body>
    <table width="600">
      <tr height="20"></tr>
      <tr>
        <td id="main">
          <?php  
            if(isset($pw)){?>
              <form name="login_form" action="login.php" method="post">
                        <table>
                          <tr>
                            <td colspan="5" width="800"></td>
                          </tr>
                          <tr height="8"></tr>
                          <tr>
                            <td border-top width="120" id="first"></td>
                            <td ><label for="name" size="30"></label></td>
                            <td align="center"><?= $row['name']."님!" ?></td>
                            <td width="80"></td>
                            <td width="120"></td>
                          </tr>
                          <tr>
                            <td width="120"></td>
                            <td align="left" width="80"><label for="pnum"> </label></td>
                            <td width="300" style="text-align: center;">비밀번호는 <?= "$pw 입니다." ?></td>
                            <td></td>
                            <td width="120"></td>
                          </tr>
                          <tr height="20"></tr>
                          <tr height="20"></tr>
                          <input type="hidden" name="pw" value=<?= $pw?>>
                          <input type="hidden" name="id" value=<?= $id?>>
                          <tr>
                            <td colspan="5" align="center"><input type="submit" value="확인" style="width:100pt; height:30pt"></td>
                          </tr>
                          <tr height="20"></tr>
                        </table>
              </form>
          <?php    
            }else{?>
              <form name="login_form" action="pw_find.php" method="post">
                <div id="guide_find_id">
               <h2>비밀번호 찾기</h2>
               <b>비밀번호</b>를 찾으시려면 <b>아이디</b>와 <b>전화번호</b>를 입력해주세요!
               <img src="../image/find.jpg" style="width: 30px;">
              </div>
                <table>
                  <tr>
                    <td colspan="5" width="800"></td>
                  </tr>
                  <tr height="8"></tr>
                  <tr>
                    <td border-top width="120" id="first"></td>
                    <td><label for="name" size="30">아이디</label></td>
                    <td><input type="text" name="id" size="30"></td>
                    <td width="80"></td>
                    <td width="120"></td>
                  </tr>
                  <tr>
                    <td width="120"></td>
                    <td align="left" width="80"><label for="pnum">전화번호</label></td>
                    <td width="180"><input type="text" name="pnum" size="30"></td>
                    <td></td>
                    <td width="120"></td>
                  </tr>
                  <tr height="20"></tr>
                  <tr height="20"></tr>
                  <tr>
                    <td colspan="5" align="center"><input type="button" value="확인" style="width:100pt; height:30pt" onclick="input_check()">
                    <input type="button" value="취소" style="width:100pt; height:30pt" onclick="cancel()"></td>
                  </tr>
                  <tr height="20"></tr>
                </table>
              </form>
          <?php  
            }
          ?>
        </td>
      </tr>
      <tr height="20">
        <td></td>
      </tr>
      <tr height="20">
        <td align="center"></td>
      </tr>
      <tr height="20">
        <td></td>
      </tr>
      <tr height="20">
        <td><img src="../../common_img/logo.png" style="margin-top: -60px;"></td>
      </tr>
    </table>

  </body>
</html>