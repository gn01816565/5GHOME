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
    $file_name = uploadFile('addFile','../../../../images/otherPlatFormIcon/','platFormIcon'); //回傳更改過後的上傳檔名
    #來源檔案、除存檔案、寬、高、品質(0-100)
    //ImageResize('../../../../images/bannerImage/'.$file_name,'../../../../images/bannerImage/'.$file_name,1024,auto,90); //縮圖處理，縮圖

  } else {//if(!empty($_FILES['addFile']['name'])){ //如果不是空值，則進入檔案上傳
    echo "沒有檔案";
  }
  #資料庫處理

  $platFormName =  $_POST['platFormName']; //名稱
  //$date = date("Y-m-d H:i:s"); //更新時間
  //$amID = $_SESSION['AM_ID']; //管理者id

  $sqladd = "INSERT INTO Admin_OtherPlatforms (AOP_PlatformName, AOP_Icon) VALUES ('".$platFormName."', '".$file_name."');";
  $result = $Config_db->prepare($sqladd);
  $result->execute();
} //if($act == 'add') {

if($act == 'edit') {
  $sqlPlus = " "; //檔案上傳的資料語法 
  #檔案上傳處理
  if(!empty($_FILES['addFile']['name'])){ //如果不是空值，則進入檔案上傳
    #先刪除既有圖片
    $fileURL = "../../../../images/otherPlatFormIcon/".$_POST['fileName'];
    delFile($fileURL); //放入檔案路徑

    #開始新增圖片
    #檔案名稱、上傳路徑、檔案標頭 
    $file_name = uploadFile('addFile','../../../../images/otherPlatFormIcon/','platFormIcon'); //回傳更改過後的上傳檔名
    
    $sqlPlus = ",AOP_Icon = '".$file_name."'";
  } else {//if(!empty($_FILES['addFile']['name'])){ //如果不是空值，則進入檔案上傳
    echo "沒有檔案";
  }

  #資料庫處理
  $platFormName =  $_POST['platFormName']; //名稱
  //$date = date("Y-m-d H:i:s"); //更新時間
  //$amID = $_SESSION['AM_ID']; //管理者id
  $id = $_POST['id']; 
  
  $sqledit = "UPDATE Admin_OtherPlatforms SET AOP_PlatformName = '".$platFormName."' $sqlPlus WHERE AOP_ID = '".$id."'";
  $result = $Config_db->prepare($sqledit);
  $result->execute();
  
}

if($act == 'del') { //刪除
  #抓取資料
  $id = $_POST['id']; //抓取id

  #抓取資料庫中的檔案名稱
  $sql = "SELECT * FROM Admin_OtherPlatforms where AOP_ID = '".$id."'";
  $rs = $Config_db->query($sql);
  $data = $rs->fetch();
  $fileURL = "../../../../images/otherPlatFormIcon/".$data['AOP_Icon'];
  
  #資料庫語法
  $count = $Config_db->exec("DELETE FROM Admin_OtherPlatforms WHERE AOP_ID = '".$id."'");
  $ar["remsg"] = "刪除成功，影響 ".$count." 行數列";
  
  #檔案刪除
  delFile($fileURL); //放入檔案路徑

  echo json_encode($ar);
}
?>