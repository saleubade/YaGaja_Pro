<meta charset="UTF-8">
<?php
if(isset($_POST["type"]))
{
    $type=$_POST["type"];
}
else  
{
    $type="";
}
if($type == "의류")
{
    echo    "S :<input type='number' name='sizeS' class='size' min='0'>
             M :<input type='number' name='sizeM' class='size' min='0'>
             L :<input type='number' name='sizeL' class='size' min='0'>
             XL :<input type='number' name='sizeXL' class='size' min='0'>";
    
}
else 
{
    echo    "<input id='shop_amount' type='text' name='shop_amount'>"; 
}
?>