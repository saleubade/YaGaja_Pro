<?php 
include_once "../../common_lib/createLink_db.php";
include_once "./create_survey.php";
?>

<html>
 <head>
  <title> Survey </title>
  <meta charset="utf-8">
  <script>
      function update(){
        var vote;
        var length = document.survey_form.composer.length; 

        for (var i=0; i<length; i++){
           if (document.survey_form.composer[i].checked == true){
                vote= document.survey_form.composer[i].value;
                break;
           }
        }

        if (i == length){
           alert("문항을 선택하세요!");
           return;
        }

        window.open("update.php?composer="+vote , "", 
              "left=200, top=200, width=500, height=450, status=no, scrollbars=no");
        window.close();
    }

  	  function result(){
         window.open("result.php" , "", 
              "left=200, top=200, width=500, height=450, status=no, scrollbars=no");
    }
</script>

 </head> 
<body>
  <form name=survey_form method=post > 
    <table border=0 cellspacing=0 cellpdding=0 width='0' align='center'>
      <input type=hidden name=kkk value=100>
        <tr height=40>
          <td><img src="../img/bbs_poll.gif"></td>
        </tr>
        <tr height=1 bgcolor=#cccccc><td></td></tr>
       <tr height=7><td></td></tr>
       <tr><td><b> 한번쯤 가보고 싶었던 여행지를 투표해주세요!!</b></td></tr>
       <tr><td><input type=radio name='composer' value='ans1' > Asia</td></tr>
       <tr height=5><td></td></tr>
       <tr><td><input type=radio name='composer' value='ans2' > Europe</td></tr>
       <tr height=5><td></td></tr>
       <tr><td><input type=radio name='composer' value='ans3' > America</td></tr>
       <tr height=5><td></td></tr>
       <tr><td><input type=radio name='composer' value='ans4' > Afreeca</td></tr>
       <tr height=7><td></td></tr>
       <tr><td><input type=radio name='composer' value='ans5' > Oceania</td></tr>
       <tr height=7><td></td></tr>
       <tr height=1 bgcolor=#cccccc><td></td></tr>
       <tr>
       <tr height=7><td></td></tr>
       <tr>
         <td align=middle><img src="../img/b_vote.gif" border="0"  style='cursor:hand' 
            onclick=update()></a>
           <img src="../img/b_result.gif" border="0"  style='cursor:hand' 
               onclick=result()></a></td></tr>
    </table>
  </form>
</body>
</html>
