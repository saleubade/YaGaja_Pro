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
if($type == "clothe")
{
    echo    "사이즈/수량";
    
}
else 
{
    echo    "수량"; 
}
?>