<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=euc-kr">
<title>배경이 가려진 레이어 팝업 뛰우기</title>
<style> 
/* 마스크 뛰우기 */
#mask {  
    position:absolute;  
    z-index:9000;  
    background-color:#000;  
    display:none;  
    left:0;
    top:0;
} 
/* 팝업으로 뜨는 윈도우 css  */ 
.window{
    display: none;
    position:absolute;  
    left:50%;
    top:50px;
    margin-left: -500px;
    width:1000px;
    height:500px;
    background-color:#FFF;
    z-index:10000;   
 }
 
</style>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript"> 
//<![CDATA[
    function wrapWindowByMask(){
 
        //화면의 높이와 너비를 구한다.
        var maskHeight = $(document).height();  
        var maskWidth = $(window).width();  
 
        //마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다.
        $("#mask").css({"width":maskWidth,"height":maskHeight});  
 
        //애니메이션 효과 - 일단 0초동안 까맣게 됐다가 60% 불투명도로 간다.
 
        $("#mask").fadeIn(0);      
        $("#mask").fadeTo("slow",0.6);    
 
        //윈도우 같은 거 띄운다.
        $(".window").show();
 
    }
 
    $(document).ready(function(){
        //검은 막 띄우기
        $(".openMask").click(function(e){
            e.preventDefault();
            wrapWindowByMask();
        });
 
        //닫기 버튼을 눌렀을 때
        $(".window .close").click(function (e) {  
            //링크 기본동작은 작동하지 않도록 한다.
            e.preventDefault();  
            $("#mask, .window").hide();  
        });       
 
        //검은 막을 눌렀을 때
        $("#mask").click(function () {  
            $(this).hide();  
            $(".window").hide();  
 
        });      
 
    });
 
//]]>
</script>
</head>
<body>
    <div id ="wrap"> 
        <div id = "container">  
            <div id="mask"></div>
            <div class="window">
                <p style="width:1000px;height:500px;text-align:center;vertical-align:middle;">팝업 내용 입력</p>
                <p style="text-align:center; background:#ffffff; padding:20px;"><a href="#" class="close">닫기X</a></p>
            </div>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">       
                <tr>
                    <td align="center">
                    <a href="#" class="openMask">레이어 팝업 발생</a>
                    </td>
                </tr>       
            </table>
        </div>
    </div>
</body>
</html>


