<?php
session_start();
include "../../common_lib/createLink_db.php";

    $mode = $_GET['mode'];
    $num = $_GET["num"];
    $page = $_GET["page"];
    $table = $_GET["table"];
    $subject = $_POST['subject'];
    $content = $_POST['content'];
    $continent = $_POST['continent'];

if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    
    $name=$_SESSION['name'];
}

$regist_day = date("Y-m-d(H:i)");
if(isset($_FILES["upfile"])){
    $files=$_FILES["upfile"];
    
    $count = count($files["name"]);
    $upload_dir='../data/';
    for($i=0;$i<$count;$i++){
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
                $new_file_name=date("Y_m_d_h_i_s");
                $new_file_name=$new_file_name."_".$i;
                $copied_file_name[$i]=$new_file_name.".".$file_ext;
                $upload_file[$i]=$upload_dir.$copied_file_name[$i];
<<<<<<< HEAD
                if($upfile_size[$i]>30000000){
                    echo ("
            <script>
            alert('업로드 파일 크기가 지정된 용량(30MB)을 초과합니다!<br> 파일크기를  확인해주세요')
            history.go(-1)
=======
                
                
                if($upfile_size[$i]>500000){
                    echo ("
            <script>
            alert('업로드 파일 크기가 지정된 용량(500KB)을 초과합니다!<br> 파일크기를  확인해주세요');
            history.go(-1);
>>>>>>> db11a656d13e4fb6694c8910e2ea27da64bd7fd1
            </script>
");
                    exit();
                }
                if(!move_uploaded_file($upfile_tmp_name[$i],$upload_file[$i])){
                    echo ("
               <script>
                alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
                history.go(-1);
               </script>
");
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
    $sql = "select * from $table where num=$num";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    
    for($i=0 ; $i<$count ; $i++){ //파일전체개수 만큼 반복
        $field_org_name="file_name_".$i;
        $field_real_name="file_copied_".$i;
        
        if(!empty($copied_file_name[$i])){
            $org_real_value=$copied_file_name[$i];
        }
        if(isset($del_ok) && $del_ok[$i] == "y"){
            $delete_field = "file_copied_".$i;
            $delete_name = $row[$delete_field];
            $delete_path = "../data/".$delete_name;
            unlink($delete_path); //data폴더에서 제거
            $sql="update $table set $field_org_name='',$field_real_name='' where num='$num'";
            mysqli_query($con, $sql);
        }else{
            if(!$upfile_error[$i] && isset($upfile_name[$i])){
                $sql = "update $table set $field_org_name='$upfile_name[$i]',$field_real_name='$org_real_value' where num='$num'";
                mysqli_query($con, $sql);
            }
        }
    }
    $sql="update $table set subject='$subject',content='$content' where num='$num'";
    mysqli_query($con, $sql);
    
}else{
    $sql="insert into $table (id,name,continent,subject,content,regist_day,hit,file_name_0,file_name_1,file_copied_0,file_copied_1)";
    $sql.="values('$id','$name','$continent','$subject','$content','$regist_day',0, ";
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
                $sql.= "'$copied_file_name[$i]')";
            }else{
                $sql.= "'$copied_file_name[$i]', ";
            }
            
        }else{
            if($i==$count-1){
                $sql.= "'')";
            }else{
                $sql.= "'', ";
            }
        }
    }
    
    mysqli_query($con, $sql) or die("실패원인1".mysqli_error($con));
}
mysqli_close($con);

echo ("
 <script>
    location.href='list.php?table=$table&page=$page';
 </script>
 ");   
?>