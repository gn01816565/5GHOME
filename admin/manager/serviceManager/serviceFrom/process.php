<?php
session_start(); //讓session可執行

include_once('../../../include/config/config_inc.php');
include_once('../../../include/function/function.php');
// 

$act = $_POST['act']; //執行動作判斷 

if($act == 'read') {
  #抓取參數
  $id = $_POST['id'];
  $status = $_POST['status'];
  $amID = $_SESSION['AM_ID']; //管理者id

  #資料庫執行
  $sqlUpData="UPDATE Admin_CustomerServiceForm SET ACSF_Status = '".$status."' , ACSF_AM_ID = '".$amID."' WHERE ACSF_ID = '".$id."' ";
  $resultDa = $Language_db->prepare($sqlUpData);
  $resultDa->execute();

  $ar["remsg"] = "更新完成！";
  echo json_encode($ar);
}

if($act == 'del') {
  
  $id = $_POST['id'];
  #Delete all rows from the FRUIT table 
  $count = $Language_db->exec("DELETE FROM Admin_CustomerServiceForm WHERE ACSF_ID = '".$id."'");

  $ar["remsg"] = "刪除成功，影響 ".$count." 行數列";
  echo json_encode($ar);
}

?>  