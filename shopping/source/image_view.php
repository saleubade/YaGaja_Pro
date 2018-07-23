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
if($type == "travel" || $type == "clothe" || $type == "acc" || $type == "cosmetics"){
    $sql="select * from shop_goods where shop_type='$type' order by hit desc";
    $result=mysqli_query($con, $sql);
    for($i=0; $i<7; $i++){
        $row=mysqli_fetch_array($result);
        $image[$i]=$row['shop_image_change_name1'];
        echo    "<div class='weekly_img'>
     					<img src='../../input/upload_image/$image'>
     			 </div>";
    }
}
?>
