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
    echo    "사이즈/수량";
    
}
else 
{
    echo    "수량"; 
}
?>