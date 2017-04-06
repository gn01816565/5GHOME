<?php
include_once('../../../include/config/config_inc.php');
include_once('../../../include/function/function.php');
 

header('Content-Type: application/json');

$act = $_POST['act']; //頁面動作
/*
增加供應商帳號，以下資料表也需增加該供應商的欄位
購物說明：Supplier_IndexShoppingIntroduction

*/
#編輯頁面 
if($act == 'edit') {
  /*
	$aid = $_POST['aid']; //帳號
  $password = $_POST['password']; //第一次輸入密碼
  $checkpassword = $_POST['checkpassword']; //第二次輸入密碼
  $email = $_POST['email']; //管理者電子信箱
  */
  #宣告參數
  foreach($_POST as $key=>$val) {
    $$key=$val;
  }

	$sqlPlus = "";
  
  if($password && $checkpassword) { //如果有輸入密碼的話
    $sqlPlus .= ",AM_Password='".sha1($password)."'"; //增加搜尋條件
  }

  $competence = isset($_POST['competence'])?$_POST['competence']:""; //抓取權限字串
  #將權限陣列變字串
  $str = '';
  if($competence) { //如果權限有值在分割
    for($i=0;$i<count($competence);$i++) {
     $str .=$competence[$i];
       if($i != (count($competence)-1)) {
        $str .=  ",";
     }   
    }
  } //if($competence) {


  if($competence != "") { //陣列有資料，再將權限寫入到資料庫
    $sqlPlus .= ",AM_Competence = '".$str."'"; //增加搜尋條件
  } else {
    $sqlPlus .= ",AM_Competence = '' "; //若沒有值傳送，表示權限被全取下，設定為空白
  }

  
  $date = date("Y-m-d H:i:s");//現在時間
	$ip = getIp(); //抓取ip
	$acStatus = $_POST['acStatus']; //帳號狀態
  
  #更新資料庫語法
	$sqlUp = "UPDATE Admin_Manager SET 
            AM_Email = '".$email."', 
            AM_Update_Time ='".$date."', 
            AM_Update_Ip = '".$ip."',
            AM_Status='".$acStatus."',
            AM_Level = '".$selectLevel."'
            ".$sqlPlus." 
            WHERE AM_ID = '".$aid."' ";
  $result = $Language_db->prepare($sqlUp);
	$result->execute();
	

	$ar["remsg"] = "成功更新";
	echo json_encode($ar);
} //if($act == 'edit') {

#新增頁面
if($act == 'add') { 
  #宣告參數
  foreach($_POST as $key=>$val) {
    $$key=$val;
  }
  /*
  $acStatus = $_POST['acStatus']; //帳號狀態
  $account = $_POST['account']; //帳號
  $password = $_POST['password']; //第一次輸入密碼
  $checkpassword = $_POST['checkpassword']; //第二次輸入密碼
  //$email = $_POST['email']; //電子信箱
  */
  //$email = "gn01816565@gmail.com";
  $date = date("Y-m-d H:i:s");//現在時間
  $ip = getIp(); //抓取ip
  $competence = isset($_POST['competence'])?$_POST['competence']:""; // 權限
  
  #將權限陣列變字串
  $str = '';
  if($competence) { //如果權限有值在分割
    for($i=0;$i<count($competence);$i++) {
     $str .=$competence[$i];
       if($i != (count($competence)-1)) {
        $str .=  ",";
     }   
    }
  } //if($countries) {
  

  #資料庫語法
  $sqlUpPw = "INSERT INTO Admin_Manager ( AM_Account, AM_Password, AM_Competence, AM_Email, AM_Create_Time, AM_Update_Time, AM_Update_Ip, AM_Status, AM_Level) VALUES ( '".$account."', '".sha1($password)."', '".$str."', '".$email."', '".$date."', '".$date."', '".$ip."', '".$acStatus."', '".$selectLevel."');";
  $result = $Language_db->prepare($sqlUpPw);
  $result->execute();
  
  $ar["remsg"] = "新增成功";
  //$ar["remsg"] = $sqlUpPw;
  echo json_encode($ar);

} //if($act == 'add') {

#刪除資料
if($act == 'del') {
  $id = $_POST['id'];
  /* Delete all rows from the FRUIT table */
  $count = $Language_db->exec("DELETE FROM Admin_Manager WHERE AM_ID = '".$id."'");

  $ar["remsg"] = "刪除成功，影響 ".$count." 行數列";
  echo json_encode($ar);
} //if($act == 'del') {


?>