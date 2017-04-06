<?php
/*
include_once("../conf/Db.class.php"); //新資料庫設定檔
include_once("../conf/function.php"); //funciton庫
require("../conf/mailTypeFunciton.php");  //信件mail格式function
*/
include_once('./include/config/config_inc.php');
include_once('./include/function/function.php');
require("../conf/mailTypeFunciton.php");  //信件mail格式function
$reIP = $_SERVER['HTTP_REFERER']; //前一頁網址
$serverIP = $_SERVER['HTTP_HOST']; //當頁網址

if(preg_match("/\b".$serverIP."\b/i", $reIP)) { //比對前一頁網址與當頁網址是否一致
  #抓取參數
  
  //$email = $_POST['email'];
  foreach($_POST as $key=>$val) {
    $$key=$val;
  }
  $num = md5(uniqid()); //編碼
  $time = date("Y-m-d H:i:s");
  
  $sql = "UPDATE Admin_Manager  
             SET AM_forgetPWDTime = '$time', 
                 AM_forgetPWDNum = '$num' 
             WHERE AM_Email LIKE '$email'";
  //$dbt = new Db(); //宣告使用config資料庫
  //$dbt->query('fskt_Config',$sql);
  $result = $Language_db->prepare($sql);
  $result->execute();
  
  $URL = "http://".$serverIP."/admin/pwReset.php?d=".$num;

  //$mailContent = "修改密碼路徑<br><a href='".$URL."'>".$URL;
  $mailContent = AMforgetPWmail($email, $URL);
  admin_webMailSent($email,'FIVESTARS - 忘記密碼',$mailContent); 
  
  $ar["remsg"] = "資料已送出";
  //$ar["remsg"] = $sql;
  echo json_encode($ar);   
}
?>