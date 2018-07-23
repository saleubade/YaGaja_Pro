<meta charset="UTF-8">
<?php  
  session_start();
  
  if(isset($_SESSION['id'])){
      $id=$_SESSION['id'];
      $cname = $_SESSION['name'];
  }
  if(isset($_GET['mode'])){
      $mode = $_GET['mode'];
      $no = $_GET["no"];
  }
  include "../../common_lib/createLink_db.php";
  
  $subject=$_POST['subject'];
  $content=$_POST['content'];

  if($_SERVER['REQUEST_METHOD']){//보안검사
    $subject=test_input($subject);
    $content=test_input($content);
  }
  function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $regist_day = date("Y-m-d (H:i)");
  
if(isset($_FILES["upfile"])){
  $files=$_FILES["upfile"];
  $count = count($files["name"]);
  for($i=0; $i<$count; $i++)
  {
      $upfile_error=null;
      if(!empty($files["name"][$i])){
          $upfile_name[$i]=$files["name"][$i];
          $upfile_tmp_name[$i] = $files["tmp_name"][$i];
          $upfile_type[$i]=$files["type"][$i];
          $upfile_size[$i]=$files["size"][$i];
          $upfile_error[$i]=$files["error"][$i];
          
          $file=explode(".",$upfile_name[$i]);//.을 기점으로 배열로 나누겠다
          $file_name=$file[0];
          $file_ext=$file[1];
          
          if(!$upfile_error[$i]){
              
              $new_file_name[$i]=date("Y_m_d_H_i_s");
              $new_file_name[$i]=$new_file_name[$i]."_".$i.".".$file_ext;
              $upload_image_dir_name[$i]="../upload_image/".$new_file_name[$i];
              if(!move_uploaded_file($upfile_tmp_name[$i],$upload_image_dir_name[$i])){
                  echo "<script>alert('[$i]susecc.')</script>";
                  exit();
              }
          }
      }
  }
}else{
    $file_name="";
    $file_ext="";
}
if(isset($mode) && $mode === "modify"){ //글수정
  if(isset($_POST["del_file"])){ //그림을 삭제하려고 체크
      $num_checked=count($_POST["del_file"]); //체크한 개수
      $position=$_POST["del_file"]; //체크된것들이 배열형태로 저장
      for($i=0 ; $i<$num_checked ; $i++){
          $index = $position[$i];
          $del_ok[$index]="y";
      }     
  }
  $sql = "select * from shop_notice where notice_no=$no";
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
          $sql="update shop_notice set $field_org_name='',$field_real_name='' where notice_no=$no";
          mysqli_query($con, $sql);
      }else if(!empty($files["name"][$i])){
           if(!$upfile_error[$i] && isset($upfile_name[$i])){
               $sql = "update shop_notice set $field_org_name='$upfile_name[$i]',$field_real_name='$org_real_value' where notice_no=$no";
           mysqli_query($con, $sql);
          }
       }
   }
   $sql="update shop_notice set notice_subject='$subject',notice_content='$content' where notice_no=$no";
   mysqli_query($con, $sql);
  
  
 }else{
  $sql="insert into shop_notice (notice_id, notice_nick, notice_subject,  notice_content,
                              file_name_0, file_name_1, file_name_2, file_copied_0,
                              file_copied_1, file_copied_2, hit, regist_day)";
  $sql.=" values('$id', '$cname', '$subject', '$content', '$upfile_name[0]', '$upfile_name[1]', '$upfile_name[2]',
               '$new_file_name[0]', '$new_file_name[1]','$new_file_name[2]', 0, '$regist_day')";
 }
 echo "<br><br>===<br>".$sql;
    if(!mysqli_query($con,$sql)){
      echo "no DB: ".mysqli_error($con);
    }else{
      echo "<script>location.href='./shop_notice.php?';</script>";
    } 
?>





