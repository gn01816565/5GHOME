<?php
session_start(); //讓session可執行

include_once('../../../include/config/config_inc.php');
include_once('../../../include/function/function.php');
 

$act = $_POST['act']; //執行動作判斷 


if($act == 'edit') { //編輯
  
  $proStatus = $_POST['proStatus']; //上下架狀態
  $remark = $_POST['remark']; //備註
  $id = $_POST['pid']; //商品id
  $amid = $_SESSION['AM_ID']; //管理者id

  #更新資料庫語法
  $sqlUp = "UPDATE Supplier_ProductDetail SET SPD_CheckStatus ='".$proStatus."', SPD_CheckReason = '".$remark."', SPD_AM_ID = '".$amid."' WHERE SPD_ID = '".$id."'";
  $result = $Language_db->prepare($sqlUp);
  $result->execute();

  $ar["remsg"] = "更新成功";
  echo json_encode($ar);
} //if($act == 'edit') { //編輯

?>  