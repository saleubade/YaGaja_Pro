<meta charset="UTF-8">
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
  $regist_day = date("Y-m-d (H:i:s)");
  
  if($mode === "modify"){ //글수정
      if(isset($_POST["del_file"])){ //그림을 삭제하려고 체크
          $num_checked=count($_POST["del_file"]); //체크한 개수
          $position=$_POST["del_file"]; //체크된것들이 배열형태로 저장
          for($i=0 ; $i<$num_checked ; $i++){
              $index = $position[$i];
              $del_ok[$index]="y";
          }
          echo "1".$del_ok[0]."2".$del_ok[1]."<br>";
      }
      $sql = "select * from shop_qna where qna_no=$no";
      $result = mysqli_query($con, $sql);
      $row = mysqli_fetch_array($result);
      
      for($i=0; $i<2; $i++){ //파일전체개수 만큼 반복
          $field_org_name="file_name_".$i;
          $field_real_name="file_copied_".$i;
          if(!empty($new_file_name[$i])){
              $org_real_value=$new_file_name[$i];
          }
          if(isset($del_ok) && $del_ok[$i] == "y"){
              $delete_field = "file_copied_".$i;
              $delete_name = $row[$delete_field];
              $delete_path = "../upload_image/".$delete_name;
              unlink($delete_path); //data폴더에서 제거
              $sql="update shop_qna set $field_org_name='',$field_real_name='' where qna_no=$no";
              mysqli_query($con, $sql);
          }else if(!empty($files["name"][$i])){
              if(!$upfile_error[$i] && isset($upfile_name[$i])){
                  $sql = "update shop_qna set $field_org_name='$upfile_name[$i]',$field_real_name='$org_real_value' where qna_no=$no";
                  echo "<br>22".$sql;
                  mysqli_query($con, $sql);
              }
          }
      }
      $sql="update shop_qna set subject='$subject',content='$content' where qna_no=$no";
      echo "33".$sql;
      mysqli_query($con, $sql);
      
      
  }
  
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





