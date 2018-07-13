<?php
session_start();

include '../../common_lib/createLink_db.php';



$num= $_GET['num'];
$page= $_GET['page'];

$sql= "select * from qna where num=$num";
$result= mysqli_query($con, $sql) or die(mysqli_error($con));
$row= mysqli_fetch_array($result);

$gno= $row['gno'];
$item_id= $row['id'];
$content= $row['content'];
$content=str_replace(" ", "&nbsp;", $content);
$content=str_replace("\n", "<br>", $content);
$regist_day= $row['regist_day'];
$hit= $row['hit']+1;
$subject=$row['subject'];

$sql= "update qna set hit=$hit where num=$num";
mysqli_query($con, $sql) or die(mysqli_error($con));


//$sql2= "select id, max(depth) from qna where gno=$gno";
$sql2= "select id from qna where gno=$gno";
$result2= mysqli_query($con, $sql2) or die(mysqli_error($con));
$row2= mysqli_fetch_array($result2);
$p_id= $row2['id'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>야 ~ 가자!</title>
    <link rel="stylesheet" href="../css/qna.css?ver=1">
    <link rel="stylesheet" href="../../common_css/index_css3.css">
</head>
<body>
    <header>
      <?php include "../../common_lib/top_login2.php"; ?>
    </header>
    <nav id="top">
      <?php include "../../common_lib/main_menu2.php"; ?>
    </nav>
	<section id="section2">
		<article class="main2">
			<div id="head">
        		<h1>문의 글 보기</h1>
        	</div>
        	<hr>
        	<div id="view_contents">
        		<div id="view_contents_title">
        			<div id="view_contents_title1"><?=$subject?></div>
        			<div id="view_contents_title2"><?=$row['id']?> | 조회 : <?=$hit?> | <?=$regist_day?></div>
        			<div class="clear"></div>
        		</div>
        		<br>
        		<div id="view_contents_content"><?=$content?></div>
        		<hr>
        	</div>
        	<div id="qna_link">
        		<?php 
        		if(isset($_SESSION['id'])){
        		?>
        		<a href="qna_input_form.php?page=<?=$page?>"><img src="../img/write.png"></a>
        		<?php 
            		if($_SESSION['id']===$item_id || $_SESSION['id']==="admin"){
        		    ?>
            		<a href="qna_delete.php?page=<?=$page?>&num=<?=$num?>"><img src="../img/delete.png"></a>
            		<a href="qna_input_form.php?page=<?=$page?>&num=<?=$num?>&mode=update"><img src="../img/modify.png"></a>
            		<?php 
        		    }
            		if($_SESSION['id']==="admin" || $_SESSION['id']===$p_id){
        		    ?>
            		<a href="qna_input_form.php?page=<?=$page?>&gno=<?=$gno?>&num=<?=$num?>&mode=reply"><img src="../img/response.png"></a>
                    <?php
                    }
        		}
            		?>
        		<a href="qna_list.php?page=<?=$page?>"> <img src="../img/list.png"> </a>
        	</div>
        	<div class="clear"></div>
    	</article>
    	
	</section>
    <footer>
      	<?php include "../../common_lib/footer2.php"; ?>
    </footer>
</body>
</html>