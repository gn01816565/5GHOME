<?php
ob_start();
session_start();
// session保存一天 24 * 3600
//$lifeTime = 24 * 3600;
/*
$lifeTime = 10 * 60;
setcookie(session_name(), session_id(), time() + $lifeTime, "/");
*/

include 'include/config/config_inc.php'; //資料庫資訊檔
include '../conf/function.php'; 

/*
$passcode = AesCtr::decrypt($_POST['passcode'], $_SESSION['LOGIN_TOKEN'], 256);
$passcode = split(',', $passcode);

if ( false == preg_match('/^\w{2,18}$/', $passcode[0]) || false == preg_match('/^\w{2,18}$/', $passcode[1]) || $passcode[2] != $_SESSION['LOGIN_EXPIRE'] || 90 < abs(time()-(base_convert(strrev($passcode[2]),27,10)-12345))  ) 
{
	// 回傳錯誤訊息，建議在網址後面接一個亂數，以免瀏覽器把 token 快取起來造成驗證錯誤
	//$pager->zapto('signon.php?err=1&r='.rand(100000, 999999));
	echo "<script>location.href='login.php?r=".rand(100000, 999999)."';</script>";
	exit;
}

$admid = remove_html_tag(quotes($passcode[0]));
$admpw = remove_html_tag(quotes($passcode[1]));
*/

#抓取登入的帳號跟密碼
$ac = isset($_GET['Account'])?$_GET['Account']:$_POST['Account'] ;
$pw = isset($_GET['Passwords'])?$_GET['Passwords']:$_POST['Passwords'] ;

if (isset($ac) && isset($pw)) {


  $sqlAC = "SELECT AM_ID,AM_Account,AM_Password FROM Admin_Manager WHERE AM_Account = :AM_Account AND AM_Status = 'Y'";
  
  
  $loginAC = $_db->prepare($sqlAC, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
  $loginAC->bindParam(":AM_Account", $ac); //防first order sql injection
  $loginAC->execute();
  

  //$sqlAC = "SELECT AM_ID,AM_Account,AM_Password FROM Admin_Manager WHERE AM_Account = '".$ac."' AND AM_Status = 'Y'";
  //$loginAC = $Language_db -> query($sqlAC);

  //$sthAC->execute(array(':AM_Account' => $ac));
  //$dataAC = $loginAC->fetchAll(PDO::FETCH_ASSOC); //將得到的資料轉存為陣列
  $dataAC = $loginAC->fetch(PDO::FETCH_ASSOC);
	
  if($dataAC) { //有資料的話
	#進入比對密碼階段
	  if(sha1($pw)==$dataAC['AM_Password']) { //密碼比對,編碼使用sha1
	  	$_SESSION['AM_login'] = true; //紀錄是否有正確登入
	  	$_SESSION['AM_ID']=$dataAC['AM_ID']; //紀錄會員id
	  	$_SESSION['AM_Account'] = $dataAC['AM_Account']; //紀錄會員帳號 
	    // echo "<a href='page_index.php?pageData=page_index_info'>Enter Right</a>";
	  	#紀錄登入資訊
	  	$userIP=getIp();
	  	$sqlRecord = "INSERT INTO  Admin_ManagerLoginMessage (AMLM_Status ,AMLM_Browser ,AMLM_Ip ,AMLM_Date,AMLM_Time,AMLM_AM_ID)
VALUES ('登入成功', '".$_SERVER['HTTP_USER_AGENT']."', '".$userIP."',  '".date("Y-m-d")."', '".date("H:i:s")."', '".$dataAC['AM_ID']."');";
      $_db->exec($sqlRecord); //寫入資料庫

	    echo "<script>location.href='page_index.php?pageData=page_index_info';</script>";
	  } else {
	  	#紀錄登入資訊，密碼錯誤
	  	$userIP=getIp();
	  	$sqlRecord = "INSERT INTO  Admin_ManagerLoginMessage (AMLM_Status ,AMLM_Browser ,AMLM_Ip ,AMLM_Date,AMLM_Time,AMLM_AM_ID)
VALUES ('密碼錯誤-".$pw."', '".$_SERVER['HTTP_USER_AGENT']."', '".$userIP."',  '".date("Y-m-d")."', '".date("H:i:s")."', '".$dataAC['AM_ID']."');";
      $_db->exec($sqlRecord); //寫入資料庫
	    echo "<script>alert('帳號或密碼錯誤!')</script>";
	    echo "<script>location.href='index.php';</script>";
	    exit();
	  }
	  
  } else { //比對帳號錯誤，代表沒資料
    #紀錄登入資訊，帳號錯誤
    $userIP=getIp();
    $sqlRecord = "INSERT INTO  Admin_ManagerLoginMessage (AMLM_Status ,AMLM_Browser ,AMLM_Ip ,AMLM_Date,AMLM_Time,AMLM_AM_ID)
VALUES ('帳號輸入錯誤', '".$_SERVER['HTTP_USER_AGENT']."', '".$userIP."',  '".date("Y-m-d")."', '".date("H:i:s")."', '".$dataAC['AM_ID']."');";
    $_db->exec($sqlRecord); //寫入資料庫
    echo "<script>alert('帳號或密碼錯誤!')</script>";
    echo "<script>location.href='index.php';</script>";
	exit();
  }
} else {
  #紀錄登入資訊，未輸入
  $userIP=getIp();
  $sqlRecord = "INSERT INTO  Admin_ManagerLoginMessage (AMLM_Status ,AMLM_Browser ,AMLM_Ip ,AMLM_Date,AMLM_Time,AMLM_AM_ID)
VALUES ('帳號密碼空白', '".$_SERVER['HTTP_USER_AGENT']."', '".$userIP."',  '".date("Y-m-d")."', '".date("H:i:s")."', '".$dataAC['AM_ID']."');";
  $_db->exec($sqlRecord); //寫入資料庫

  echo "<script>alert('請輸入密碼!')</script>";
  echo "<script>location.href='index.php';</script>";
  exit();
}
?>