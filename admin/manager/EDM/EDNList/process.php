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
  
  #資料庫處理
  $sqladd = "INSERT INTO Admin_MemberGroup (AMG_Name, AMG_Remark, AMG_EditStatus) 
             VALUES ('".$gName."', '".$remark."', 'Y')
             ";
  $result = $Language_db->prepare($sqladd);
  $result->execute();

  $ar["remsg"] = "新增成功";
  echo json_encode($ar);
} //if($act == 'add') {

if($act == 'edit') {
  #參數處理
  foreach($_POST as $key=>$val) {
    $$key=$val;
  }
  
  $sqledit = "UPDATE Admin_MemberGroup SET 
              AMG_Name = '".$gName."', 
              AMG_Remark = '".$remark."' 
              $sqlPlus 
              WHERE AMG_ID = '".$id."'";
  $result = $Language_db->prepare($sqledit);
  $result->execute();

  $ar["remsg"] = "修改成功";
  echo json_encode($ar);
}

if($act == 'del') { //刪除
  #抓取資料
  $id = $_POST['id']; //抓取電子報id
  
  #資料庫語法
  $count = $Language_db->exec("DELETE FROM Admin_MemberGroup WHERE AMG_ID = '".$id."'");
  
  $ar["remsg"] = "刪除成功，影響 ".$count." 行數列";
  echo json_encode($ar);
}
?>