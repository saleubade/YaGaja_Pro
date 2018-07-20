<?php
session_start();
include "../../common_lib/createLink_db.php";

if(!empty($_GET['mode'])){
    $mode = $_GET['mode'];
}

if(!empty($_POST['content'])){
    $content = $_POST['content'];
}

if(!empty($_POST['subject'])){
    $subject = $_POST['subject'];
}

if(!empty($_GET['table'])){
    $table = $_GET['table'];
}

if(!empty($_GET['page'])){
    $page = $_GET['page'];
}

if(!empty($_GET['num'])){
    $num = $_GET['num'];
}

if(!empty($_POST['radio_from'])){
    $continent = $_POST['radio_from'];
}

if(!empty($_SESSION['id'])){
    $id = $_SESSION['id'];
}

if(!empty($_SESSION['name'])){
    $name = $_SESSION['name'];
}


$regist_day = date("Y-m-d(H:i)");
if(isset($_FILES["upfile"])){
    $files=$_FILES["upfile"];
    
    $count = count($files["name"]);
    if($count == 0 ){
        check_file_good();
    }
    $upload_dir = '../data/';
    for($i=0;$i<$count;$i++){
        $upfile_error = null;
        
            $upfile_name[$i]=$files["name"][$i];
            $upfile_tmp_name[$i] = $files["tmp_name"][$i];
            $upfile_type[$i]=$files["type"][$i];
            $upfile_size[$i]=$files["size"][$i];
            $upfile_error[$i]=$files["error"][$i];
            
            $file=explode(".",$upfile_name[$i]); //.을 기점으로 배열로 나누겠다
            $file_name=$file[0];
            $file_ext=$file[1];
            if(!$upfile_error[$i]) {
                $new_file_name=date("Y_m_d_h_i_s");
                $new_file_name=$new_file_name."_".$i;
                $copy_file_name[$i]=$new_file_name.".".$file_ext;
                $upload_file[$i]=$upload_dir.$copy_file_name[$i];
                if($upfile_size[$i]>30000000){
                    echo ("
            <script>
            alert('업로드 파일 크기가 지정된 용량(30MB)을 초과합니다! \\n파일크기를  확인해주세요!')
            history.go(-1)
            </script>
");
                    exit();
                }
                
                if (($upfile_type[$i] != "image/gif") && ($upfile_type[$i] != "image/jpeg") && ($upfile_type[$i] != "image/pjpeg")) {
                    echo ("
					<script>
						alert('JPG와 GIF 이미지 파일만 업로드 가능합니다! \\n이미지를 파일을 올려주세요!');
						history.go(-1)
					</script>
					");
                    exit();
                }
                
                if(!move_uploaded_file($upfile_tmp_name[$i],$upload_file[$i])){
                    echo ("
               <script>
                alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.')
                history.go(-1);
               </script>
");
                    exit();
                }
                
            }
        
    }
}else{
    $file_name="";
    $file_ext="";
}
if(isset($mode) && $mode === "modify"){ //글수정
    if(isset($_POST["del_file"])){ //그림을 삭제하려고 체크
        $num_checked = count($_POST["del_file"]); //체크한 개수
        $position=$_POST["del_file"]; //체크된것들이 배열형태로 저장
        
        
        for($i=0 ; $i<$num_checked ; $i++){
            $index = $position[$i];
            $del_ok[$index]="y";
        }
        
    }
    $sql = "select * from $table where num=$num";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    
    for($i=0; $i<$count; $i++){ //파일전체개수 만큼 반복
        $field_org_name="file_name_".$i;
        $field_real_name="file_copy_".$i;
        
        if(!empty($copy_file_name[$i]) && !empty($upfile_name[$i])){
            $org_real_value = $copy_file_name[$i];
            $org_name_value = $upfile_name[$i];
        }
        if(isset($del_ok) && $del_ok[$i] == "y"){
            $delete_field = "file_copy_".$i; // 저장되는 이미지를 새로운 변수에 저장
            $delete_name = $row[$delete_field]; // 삭제할 파일명
            $delete_path = "../data/".$delete_name; // 삭제 경로
            unlink($delete_path); //data폴더에서 제거
            $sql="update $table set $field_org_name = '$org_name_value', $field_real_name = '$org_real_value' where num=$num";
            mysqli_query($con, $sql) or die("실패원인1 : ".mysqli_error($con));
        }else{
            if(!$upfile_error[$i] && isset($upfile_name[$i])){
                $sql = "update $table set $field_org_name = '$org_name_value',$field_real_name = '$org_real_value' where num=$num";
                mysqli_query($con, $sql) or die("실패원인2 : ".mysqli_error($con));
            }
        }
    }
    $sql="update gallery set subject='$subject',content='$content' where num=$num";
    mysqli_query($con, $sql)or die("실패원인3 : ".mysqli_error($con));
    
}else{
    $sql="insert into gallery (id,name,continent,subject,content,regist_day,hit,file_name_0,file_name_1,file_name_2,file_copy_0,file_copy_1,file_copy_2)";
    $sql.="values('$id','$name','$continent','$subject','$content','$regist_day', 0, ";
    for($i=0;$i<$count;$i++){
        if($files["name"][$i]!=""){
            $sql.= "'{$upfile_name[$i]}', ";
        }else{
            $sql.= "'', ";
        }
    }
    for($i=0;$i<$count;$i++){
        if($files["name"][$i]!=""){
            if($i==$count-1){
                $sql.= "'$copy_file_name[$i]')";
            }else{
                $sql.= "'$copy_file_name[$i]', ";
            }
            
        }else{
            if($i==$count-1){
                $sql.= "'')";
            }else{
                $sql.= "'', ";
            }
        }
    }
    
    
    

    mysqli_query($con, $sql) or die("실패원인4 : ".mysqli_error($con));
}
mysqli_close($con);

echo ("
 <script>
    location.href='gallery_list.php?table=$table&page=$page';
 </script>
 ");

?>