<?php
/*
include_once("../conf/Db.class.php"); //新資料庫設定檔
include_once("../conf/function.php"); //funciton庫
*/
include_once('./include/config/config_inc.php');
include_once('./include/function/function.php');
$reIP = $_SERVER['HTTP_REFERER']; //前一頁網址
$serverIP = $_SERVER['HTTP_HOST']; //當頁網址

if(preg_match("/\b".$serverIP."\b/i", $reIP)) { //比對前一頁網址與當頁網址是否一致
  #抓取參數
  foreach($_POST as $key=>$val) {
    $$key=$val;
  }
  
  $sql = "SELECT * 
          FROM Admin_Manager 
          WHERE AM_Email LIKE '".$email."' ;";
  //$dbt = new Db(); //宣告使用config資料庫
  $result = $Language_db->prepare($sql);
  $data = $result->execute();
  //$data = $dbt->query('fskt_Config',$sql);
  
  if(count($data) > 0) { //有資料
    $status = 1;
  } else { //無資料
    $status = 0;
  }

  $ar["remsg"] = $status;
  echo json_encode($ar);   
}
?>