<?php
require("../../../include/config/config_inc.php"); //新資料庫設定檔
require("../../../include/function/function.php"); //funciton庫

$account = $_POST['account']; //抓取帳號
$act = $_POST['act']; //動作，add:新增，edit:編輯
$id = $_POST['id']; //供應商id
$status = 0; //狀態值

if($act == 'add') { //新增頁面過來
  $sql = "SELECT * FROM Supplier_AccountData WHERE SAD_Account = '".$account."'";
  $rs = $Config_db->query($sql);
  $result = $rs->fetch();
  if($result) { //如果有值，表示錯誤
    $status = 1;
  }
}

if($act == 'edit') { //編輯頁面過來，有供應商id
	//先比對是否是同一個帳號
  if($id) {
  	$sqlSel = "SELECT * FROM Supplier_AccountData WHERE SAD_ID = '".$id."'";
    $rsSel = $Config_db -> query($sqlSel);
    $dataSel = $rsSel -> fetch();
  	if($dataSel['SAD_Account'] != $account) {
      $sql = "SELECT * FROM Supplier_AccountData WHERE SAD_Account = '".$account."'";
      $rs = $Config_db->query($sql);
      $result = $rs->fetch();
      if($result) { //如果有值，表示錯誤
        $status = 1;
      }  //if($result) {
    } //if($dataSel['SAD_Account'] != $account) {
  } //if($id) {
}

if($status == 0) {
	$ar["remsg"] = "success";
  echo json_encode($ar);
}else{
  $ar["remsg"] = "fail";
  echo json_encode($ar);
}

?>