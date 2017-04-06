<?php
  /*
  include_once("../conf/Db.class.php"); //新資料庫設定檔
  include_once("../conf/function.php"); //funciton庫
  */
  include_once('./include/config/config_inc.php');
  include_once('./include/function/function.php');
  $reIP = $_SERVER['HTTP_REFERER']; //前一頁網址
  $serverIP = $_SERVER['HTTP_HOST']; //當頁網址

  //if(preg_match("/\b".$serverIP."\b/i", $reIP)) { //比對前一頁網址與當頁網址是否一致
    #抓取參數
    foreach($_POST as $key=>$val) {
      $$key=$val;
    }

    //$dbt = new Db(); //宣告使用config資料庫
    
    #先確認是否有用此編碼重設過密碼
    $sqlSearch = "SELECT * FROM Admin_Manager WHERE AM_forgetPWDNum LIKE '$num'";
    $result = $Language_db->query($sqlSearch);
    $dataSearch = $result->fetch();
    //$DATAsearch = $dbt -> query('fskt_Config',$SQLsearch);

    if(count($dataSearch) < 1 ) { //假設沒找到資料，表示密碼已修改過，跳回首頁
      $reSTR = "此連結已失效，請重新申請流程";
    } else {
      $AM_Password = sha1($pw);
      $sql = "UPDATE Admin_Manager SET AM_Password = '$AM_Password', AM_forgetPWDTime = '', AM_forgetPWDNum = '' WHERE AM_forgetPWDNum LIKE '$num'";
      $Language_db->query($sql);
      //$dbt->query('fskt_Config',$sql);
      $reSTR = "更新完成，下次登入請使用新密碼";
    }

    $ar["remsg"] = $reSTR;
    echo json_encode($ar);   
  //}
?>