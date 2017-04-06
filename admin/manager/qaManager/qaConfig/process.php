<?php
session_start(); //讓session可執行

include_once('../../../include/config/config_inc.php');
include_once('../../../include/function/function.php');
 

$act = $_POST['act']; //執行動作判斷 

if($act == 'add') { //新增
  $mainClass = $_POST['mainClass']; //分類編號
  $title = $_POST['title']; //問題
  $content = $_POST['content']; //答案
  $date = date("Y-m-d H:i:s");//新增時間
  $amID = $_SESSION['AM_ID']; //管理者id

  #資料庫語法
  $sqladd = "INSERT INTO Admin_QAContent (AQAC_Question, AQAC_Answer, AQAC_CreateDate, AQAC_AM_ID, AQAC_AQAMC_ID ) VALUES ('".$title."', '".$content."', '".$date."', '".$amID."', '".$mainClass."')";
  $result = $Config_db->prepare($sqladd);
  $result->execute();

  $ar["remsg"] = "新增成功";
  echo json_encode($ar);
} //if($act == 'add') { //新增

if($act == 'edit') { //編輯
  $mainClass = $_POST['mainClass']; //分類編號
  $title = $_POST['title']; //標題
  $content = $_POST['content']; //答案
  $id = $_POST['id']; //編號id
  $date = date("Y-m-d H:i:s");//更新時間
  $amID = $_SESSION['AM_ID']; //管理者id

  #更新資料庫語法
  $sqlUp = "UPDATE Admin_QAContent SET AQAC_Question ='".$title."', AQAC_Answer = '".$content."', AQAC_UploadDate = '".$date."', AQAC_AM_ID = '".$amID."', AQAC_AQAMC_ID = '".$mainClass."'  WHERE AQAC_ID = '".$id."'";
  $result = $Config_db->prepare($sqlUp);
  $result->execute();

  $ar["remsg"] = "更新成功";
  echo json_encode($ar);
} //if($act == 'edit') { //編輯

if($act == 'del') {
  
  $id = $_POST['id'];
  /* Delete all rows from the FRUIT table */
  $count = $Config_db->exec("DELETE FROM Admin_QAContent WHERE AQAC_ID = '".$id."'");

  $ar["remsg"] = "刪除成功，影響 ".$count." 行數列";
  echo json_encode($ar);
}

?>  