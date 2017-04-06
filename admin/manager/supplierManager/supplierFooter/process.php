<?php
session_start(); //讓session可執行

include_once('../../../include/config/config_inc.php');
include_once('../../../include/function/function.php');
// 

$act = $_POST['act']; //執行動作判斷 

if($act == 'edit') { //編輯
  
  foreach($_POST as $key=>$val) {
    $$key=$val;
  }
  $amID = $_SESSION['AM_ID']; //管理者id
  $toTime = date("Y-m-d"); //更新時間
  //proStatus：上下架狀態
  //remark：原因撰寫
  //bid：footer id
  #更新資料庫語法

  $sqlUp = "UPDATE Supplier_IndexFooterManager SET SIFM_CheckStatus ='".$proStatus."', SIFM_Reason = '".$remark."', SIFM_AM_ID = '".$amID."',SIFM_RemoveDate = '".$toTime."' WHERE SIFM_ID = '".$bid."'";
  $result = $Config_db->prepare($sqlUp);
  $result->execute();
  

  $ar["remsg"] = "更新成功";
  echo json_encode($ar);
} //if($act == 'edit') { //編輯

?>  