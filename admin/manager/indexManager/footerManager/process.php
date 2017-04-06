<?php
session_start();
include_once('../../../include/config/config_inc.php');
include_once('../../../include/function/function.php');
 

$act = $_POST['act']; //執行動作判斷 

if($act == 'add') { //新增

  #檔案上傳處理
  $file_name = "";
  //$checkImg = getimagesize($_FILES['addFile']['tmp_name']); //抓取圖片的詳細資訊，若沒圖片則會回傳false
  //if($checkImg != false) {
  if(!empty($_FILES['addFile']['name'])){ //如果不是空值，則進入檔案上傳
    #檔案名稱、上傳路徑、檔案標頭 
    $file_name = uploadFile('addFile','../../../../images/footerImage/','Footer'); //回傳更改過後的上傳檔名
  } else {//if(!empty($_FILES['addFile']['name'])){ //如果不是空值，則進入檔案上傳
    echo "沒有檔案";
  }
  #資料庫處理

  $imgURL =  $_POST['imgUrl']; //圖片連結路徑
  $date = date("Y-m-d H:i:s"); //更新時間
  $amID = $_SESSION['AM_ID']; //管理者id

  $sqladd = "INSERT INTO Admin_IndexFooterManager (AIFM_Img, AIFM_Url, AIFM_UploadDate, AIFM_Sort, AIFM_AM_ID) VALUES ('".$file_name."', '".$imgURL."', '".$date."', '1', '".$amID."');";
  $result = $Language_db->prepare($sqladd);
  $result->execute();
} //if($act == 'add') {

if($act == 'edit') {
  $sqlPlus = " "; //檔案上傳的資料語法 
  #檔案上傳處理
  if(!empty($_FILES['addFile']['name'])){ //如果不是空值，則進入檔案上傳
    #先刪除既有圖片
    $fileURL = "../../../../images/footerImage/".$_POST['fileName'];
    delFile($fileURL); //放入檔案路徑

    #開始新增圖片
    #檔案名稱、上傳路徑、檔案標頭 
    $file_name = uploadFile('addFile','../../../../images/footerImage/','Footer'); //回傳更改過後的上傳檔名
    
    $sqlPlus = ",AIFM_Img = '".$file_name."'";
  } else {//if(!empty($_FILES['addFile']['name'])){ //如果不是空值，則進入檔案上傳
    echo "沒有檔案";
  }

  #資料庫處理
  $imgURL =  $_POST['imgUrl']; //圖片連結路徑
  $date = date("Y-m-d H:i:s"); //更新時間
  $amID = $_SESSION['AM_ID']; //管理者id
  $bid = $_POST['bid']; 
  
  $sqledit = "UPDATE Admin_IndexFooterManager SET AIFM_Url = '".$imgURL."', AIFM_UploadDate = '".$date."' $sqlPlus WHERE AIFM_ID = '".$bid."'";
  $result = $Language_db->prepare($sqledit);
  $result->execute();
  
}

if($act == 'del') { //刪除
  #抓取資料
  $id = $_POST['id']; //抓取banner id

  #抓取資料庫中的檔案名稱
  $sql = "SELECT AIFM_ID,AIFM_Img FROM Admin_IndexFooterManager where AIFM_ID = '".$id."'";
  $rs = $Language_db->query($sql);
  $data = $rs->fetch();
  $fileURL = "../../../../images/footerImage/".$data['AIFM_Img'];
  
  #資料庫語法
  $count = $Language_db->exec("DELETE FROM Admin_IndexFooterManager WHERE AIFM_ID = '".$id."'");
  $ar["remsg"] = "刪除成功，影響 ".$count." 行數列";
  
  #檔案刪除
  delFile($fileURL); //放入檔案路徑

  echo json_encode($ar);
}
?>