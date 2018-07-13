<?php  
  session_start();
  include "../../common_lib/createLink_db.php";
  
  $shop_no = $_POST['shop_no'];
  $shop_name = $_POST['shop_name'];
  $shop_price = $_POST['shop_price'];
  $shop_type = $_POST['shop_type'];
  $shop_amount = $_POST['shop_amount'];
  $shop_sizeS = $_POST['sizeS'];
  $shop_sizeM = $_POST['sizeM'];
  $shop_sizeL = $_POST['sizeL'];
  $shop_sizeXL = $_POST['sizeXL'];
  $shop_introduce = $_POST['shop_introduce'];

  if($_SERVER['REQUEST_METHOD']){//보안검사
    $no=test_input($shop_no);
    $name=test_input($shop_name);
    $amount=test_input($shop_amount);
    $price=test_input($shop_price);
    $type=test_input($shop_type);
    $size=test_input($shop_size);
  }
  function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $regist_day = date("Y-m-d (H:i)");
  
  for($i=1; $i<=4; $i++)
  {
      $image_name[$i] = $_FILES["shop_image_name$i"]["name"]; 
      $image_tmp_name[$i] = $_FILES["shop_image_name$i"]["tmp_name"];    
      $image_type[$i] = $_FILES["shop_image_name$i"]["type"];
      $image_size[$i]=$_FILES["shop_image_name$i"]["size"];
      $image_error[$i]=$_FILES["shop_image_name$i"]["error"];
      $file[$i] = explode(".",$image_name[$i]);
      $file_name[$i]=$file[$i][0];
      $file_ext[$i]=$file[$i][1];
  
      if(!$image_error[$i]){

            $new_file_name[$i]=date("Y_m_d_H_i_s");
            $new_file_name[$i]=$new_file_name[$i].".".$file_ext[$i];
            $upload_image_dir_name[$i]="../upload_image/".$new_file_name[$i];
            if(!move_uploaded_file($image_tmp_name[$i],$upload_image_dir_name[$i])){
              echo "<script>alert('[$i]susecc.')</script>";
              exit();
            
         }
      }
  }
  
  $sql="insert into shop_goods (shop_no, shop_name, shop_price, shop_amount,  shop_type,
                                shop_sizeS, shop_sizeM, shop_sizeL, shop_sizeXL, shop_image_name1,
                                shop_image_name2, shop_image_name3, shop_image_name4,
                                shop_image_change_name1, shop_image_change_name2, shop_image_change_name3,
                                shop_image_change_name4, shop_introduce, regist_day)";
  $sql.=" values('$shop_no', '$shop_name', '$shop_price','$shop_amount',  '$shop_type', '$shop_sizeS', '$shop_sizeM', '$shop_sizeL', '$shop_sizeXL',
                 '$image_name[1]', '$image_name[2]','$image_name[3]','$image_name[4]',
                 '$new_file_name[1]', '$new_file_name[2]','$new_file_name[3]','$new_file_name[4]', '$shop_introduce', '$regist_day')";

  if(!mysqli_query($con,$sql)){
     echo "no DB: ".mysqli_error($con);
   }else{
     echo "<script>location.href='../../shopping/source/shopmain.php';</script>";
   } 
?>





