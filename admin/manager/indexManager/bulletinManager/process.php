<?php
session_start(); //讓session可執行

include_once('../../../include/config/config_inc.php');
include_once('../../../include/function/function.php');
 

$act = $_POST['act']; //執行動作判斷 

if($act == 'add') { //新增

  $status = $_POST['newsStatus']; //發佈狀態 
  $title = $_POST['newsTitle']; //標題
  $content = $_POST['newsContent']; //內文
  $date = date("Y-m-d"); //日期
  $time = date("H:i:s"); //時間
  $amID = $_SESSION['AM_ID']; //增加消息的管理者ID

  #資料庫語法
  $sqladd = "INSERT INTO Admin_IndexNews (AIN_Title, AIN_Content, AIN_AddDate, AIN_AddTime, AIN_Status, AIN_AM_ID) VALUES ('".$title."', '".$content."', '".$date."', '".$time."', '".$status."', '".$amID."');";

  $result = $Language_db->prepare($sqladd);
  $result->execute();

  $ar["remsg"] = "新增成功";
  echo json_encode($ar);
} //if($act == 'add') { //新增

if($act == 'edit') { //編輯
  
  $status = $_POST['newsStatus']; //發佈狀態 
  $title = $_POST['newsTitle']; //標題
  $content = $_POST['newsContent']; //內文
  $date = date("Y-m-d"); //日期
  $time = date("H:i:s"); //時間
  $id = $_POST['ainID']; //消息id

  #更新資料庫語法
  $sqlUp = "UPDATE Admin_IndexNews SET AIN_Title ='".$title."', AIN_Content = '".$content."', AIN_AddDate = '".$date."', AIN_AddTime = '".$time."', AIN_Status = '".$status."' WHERE AIN_ID = '".$id."'";
  $result = $Language_db->prepare($sqlUp);
  $result->execute();

  $ar["remsg"] = "更新成功";
  echo json_encode($ar);
} //if($act == 'edit') { //編輯

if($act == 'del') {
  
  $id = $_POST['id'];
  /* Delete all rows from the FRUIT table */
  $count = $Language_db->exec("DELETE FROM Admin_IndexNews WHERE AIN_ID = '".$id."'");

  $ar["remsg"] = "刪除成功，影響 ".$count." 行數列";
  echo json_encode($ar);
}

?>  