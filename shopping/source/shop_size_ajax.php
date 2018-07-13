<?php
if($_POST['value2'])
{
    $value2 = $_POST['value2'];
}
else 
{
    $value2="";
}
if($_POST['price'])
{
    $price = $_POST['price'];
}
else 
{
    $price="";
}
if($value2)
{
  $total = $value2 * $price.",000";  
  echo  $total;
}