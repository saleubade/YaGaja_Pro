<?php 
/*
 *  문의 글 작성
 *   
 *   */
session_start();

include '../../common_lib/createLink_db.php';

if(!isset($_SESSION['id'])){
    echo "<script>
            alert('로그인 후 이용해 주세요!');
            window.open('../../login/source/login.php', 'login', 'top=100, left=50, width=1200, height=600, status=no, scrollbars=no');
            history.back();
        </script>";

}else{
    $id=$_SESSION['id'];
    if(empty($_GET['page'])){
        $page=1;
    }else{
        $page=$_GET['page'];
    }
    
    
    //댓글 일시
    if(isset($_GET['mode']) && $_GET['mode']==="reply"){
        $mode= "reply";
        $gno= $_GET['gno'];
        $num= $_GET['num'];
        $sql= "select * from qna where num=$num";
        $result= mysqli_query($con, $sql);
        $row= mysqli_fetch_array($result);
        $depth= $row['depth'];
        
        
        $subject= "[Re]  ".$row['subject'];
        $content= "\n\n\n\n\n\n==================\n".$row['content'];
        $secret_ok= $row['secret_ok'];
    
    //수정일 시
    }else if(isset($_GET['mode']) && $_GET['mode']==="update"){
        $mode="update";
        $num= $_GET['num'];
        $sql= "select * from qna where num=$num";
        $result= mysqli_query($con, $sql);
        $row= mysqli_fetch_array($result);
        
        $id= $row['id'];
        $subject= $row['subject'];
        $content= $row['content'];
        $secret_ok= $row['secret_ok'];
    //도서 신청일 시
    }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>문의 글 작성</title>
    <link rel="stylesheet" href="../../common_css/index_css3.css">
    <link rel="stylesheet" href="../css/qna.css?ver=1">
    <script>
      function check_input(){
        if(!document.qna_input_form.subject.value){
          alert('제목을 입력하세요!');
          document.input_form.subject.focus();
          return;
        }
        if(!document.qna_input_form.content.value){
          alert('내용을 입력하세요!');
          document.input_form.content.focus();
          return;
        }
        document.qna_input_form.submit();
      }
      
    </script>
  </head>
  <body>
    <header>
      <?php include "../../common_lib/top_login2.php"; ?>
    </header>
    <nav id="top">
      <?php include "../../common_lib/main_menu2.php"; ?>
    </nav>
    <section id="section1">
      <article class="main1">
      	<div id="head">
        	<h1>문의 글 작성</h1>
        </div>
        <hr>
        <?php 
        if(isset($_GET['mode']) && $mode==="reply"){
        ?>
		<form name="qna_input_form" action="qna_input.php?gno=<?=$gno?>&mode=<?=$mode?>&page=<?=$page?>&depth=<?=$depth?>" method="post">
		<?php 
        }else if(isset($_GET['mode']) && $mode==="update"){
		?>
		<form name="qna_input_form" action="qna_input.php?num=<?=$num?>&mode=<?=$mode?>&page=<?=$page?>" method="post">
		<?php 
        }else{
		?>
		<form name="qna_input_form" action="qna_input.php?page=<?=$page?>" method="post">
		<?php 
        }
        ?>
        <table id="qna_input_table" border="0" cellspacing="1" cellpadding="5">
			<tr bgcolor="#d6e3ce">
				<td align="center" width="100">아이디</td>
				<td width="900" height="20"> <?=$id?> </td>
			</tr>
			<tr>
				<td align="center" bgcolor="#d6e3ce">제목</td>
				<td height="30">
					<input type="text" id="sub" name="subject" size="100" value="<?=$subject?>">
					<input type="radio" name="secret_ok" value="n" <?php if($secret_ok!=="y") echo "checked";?>> 공개글
					<input type="radio" name="secret_ok" value="y" <?php if($secret_ok==="y") echo "checked";?>> 비밀글
				</td>
			</tr>
			<tr>
				<td align="center" bgcolor="#d6e3ce">내용</td>
				<td><textarea name="content" cols="129" rows="25"><?=$content?></textarea></td>
			</tr>
			<tr>
				<td height="30"></td>
				<td>
					<a id= "a_list" href="qna_list.php?page=<?=$page?>"><img src="../img/list.png"></a> 
					<div id="a_write" ><a href="#" onclick="check_input()"><img src="../img/write.png"></a></div>
				</td>
			</tr>
        </table>
		</form>
      </article>
    </section>
    <footer>
      <?php include "../../common_lib/footer2.php"; ?>
    </footer>
  </body>
</html>

<?php 
}
?>