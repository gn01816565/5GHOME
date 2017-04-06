<?php
session_start();
include_once('../../../include/config/config_inc.php');
include_once('../../../include/function/function.php');
 

$act = $_POST['act']; //執行動作判斷 

if($act == 'add') { //新增
  #參數處理
  foreach($_POST AS $key=>$val) {
    $$key=$val;
  }
  
  #檔案上傳處理
  $file_name = "";
  //$checkImg = getimagesize($_FILES['addFile']['tmp_name']); //抓取圖片的詳細資訊，若沒圖片則會回傳false
  //if($checkImg != false) {
  if(!empty($_FILES['addFile']['tmp_name'])){ //如果不是空值，則進入檔案上傳
    #檔案名稱、上傳路徑、檔案標頭 
    $file_name = uploadFile('addFile','../../../../images/edm/','Edm'); //回傳更改過後的上傳檔名
    #來源檔案、除存檔案、寬、高、品質(0-100)
    //ImageResize('../../../../images/bannerImage/'.$file_name,'../../../../images/bannerImage/'.$file_name,1024,auto,90); //縮圖處理，縮圖
    echo "檔案上傳成功";
  } else {//if(!empty($_FILES['addFile']['name'])){ //如果不是空值，則進入檔案上傳
    echo "無附加檔案";
  }
  
  #資料庫處理
  $date = date("Y-m-d"); //更新時間
  $amID = $_SESSION['AM_ID']; //管理者id
  $num = "EDM_".date("YmdGis").floor(microtime()*1000); //電子報編號

  $sqladd = "INSERT INTO Admin_EdmContent(AEC_Num, AEC_Title, AEC_Content, AEC_File, AEC_Date, AEC_AM_ID) VALUES ('".$num."', '".$title."', '".$content."', '".$file_name."', '".$date."', '".$amID."');";
  $result = $Language_db->prepare($sqladd);
  $result->execute();
} //if($act == 'add') {

if($act == 'edit') {
  $sqlPlus = " "; //資料庫語法
  #檔案上傳處理
  if(!empty($_FILES['addFile']['tmp_name'])){ //如果不是空值，則進入檔案上傳
    #先刪除既有圖片
    $fileURL = "../../../../images/edm/".$_POST['fileName'];
    delFile($fileURL); //放入檔案路徑

    #開始新增圖片
    #檔案名稱、上傳路徑、檔案標頭 
    $file_name = uploadFile('addFile','../../../../images/edm/','Edm'); //回傳更改過後的上傳檔名
    $sqlPlus = ", AEC_File = '".$file_name."' ";
  } else {//if(!empty($_FILES['addFile']['name'])){ 
    echo "無更新檔案";
  }

  #資料庫處理
  $date = date("Y-m-d H:i:s"); //更新時間
  $amID = $_SESSION['AM_ID']; //管理者id
  
  #參數處理
  foreach($_POST as $key=>$val) {
    $$key=$val;
  }
  
  $sqledit = "UPDATE Admin_EdmContent SET AEC_Title = '".$title."', AEC_Content = '".$content."' $sqlPlus WHERE AEC_ID = '".$eid."'";
  $result = $Language_db->prepare($sqledit);
  $result->execute();
}

#編輯頁面刪檔案
if($act == 'editDel') {
  #抓取資料
  $id = $_POST['id']; //抓取電子報id
  $fileName = $_POST['fileName']; //抓取檔案名稱

  #檔案刪除
  delFile("../../../../images/edm/".$fileName); //放入檔案路徑，刪除內文圖片

  #更新資料庫
  $sqleditUp = "UPDATE Admin_EdmContent SET AEC_File = '' WHERE AEC_ID = '".$id."'";
  $resultUp = $Language_db->prepare($sqleditUp);
  $resultUp->execute();

  $ar["remsg"] = "刪除成功";
  echo json_encode($ar);
}

if($act == 'del') { //刪除
  #抓取資料
  $id = $_POST['id']; //抓取電子報id

  #抓取資料庫中的檔案名稱
  $sql = "SELECT AEC_ID,AEC_File FROM Admin_EdmContent where AEC_ID = '".$id."'";
  $rs = $Language_db->query($sql);
  $data = $rs->fetch();
  $fileURL = "../../../../images/edm/".$data['AEC_File'];
  
  #資料庫語法
  $count = $Language_db->exec("DELETE FROM Admin_EdmContent WHERE AEC_ID = '".$id."'");
  $ar["remsg"] = "刪除成功，影響 ".$count." 行數列";
  
  #檔案刪除
  delFile($fileURL); //放入檔案路徑

  echo json_encode($ar);
}
?>