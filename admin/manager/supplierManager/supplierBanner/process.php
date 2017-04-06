<?php
session_start(); //讓session可執行

include_once('../../../include/config/config_inc.php');
include_once('../../../include/function/function.php');
include_once('../../../../conf/mailTypeFunciton.php'); //信件function

$act = $_POST['act']; //執行動作判斷 

if($act == 'edit') { //編輯
  
  foreach($_POST as $key=>$val) {
    $$key=$val;
  }
  $amID = $_SESSION['AM_ID']; //管理者id
  $toTime = date("Y-m-d"); //更新時間

  #信件資訊
  $sqlSel = "select * from Supplier_IndexBannerManager WHERE SIBM_ID = '".$bid."'";
  $rsSel = $Config_db -> query($sqlSel);
  $dataSel = $rsSel -> fetch();

  //proStatus：上下架狀態
  //remark：原因撰寫
  //bid：Banner id
  #更新資料庫語法
  $sqlUp = "UPDATE Supplier_IndexBannerManager SET 
            SIBM_CheckStatus ='".$status."', 
            SIBM_Reason = '".$remark."', 
            SIBM_AM_ID = '".$amID."',
            SIBM_RemoveDate = '".$toTime."' 
            WHERE SIBM_ID = '".$bid."'
           ";
  $result = $Config_db->prepare($sqlUp);
  $result->execute();
  

  $nameSAD = sadAccountSearch($Config_db, $dataSel['SIBM_SAD_ID']); //抓出供應商名字
  #下架email通知
  //找供應商資料夾編號
  $sqlSAD = "select * from Supplier_AccountData where SAD_ID = '".$dataSel['SIBM_SAD_ID']."'";
  $rsSAD = $Config_db -> query($sqlSAD);
  $dataSAD = $rsSAD -> fetch();

  #供應商姓名、banner下架資訊內容
  if($status == 'N' && $status != $dataSel['SIBM_CheckStatus']) { //狀態改為下架，而且資料庫與post過來的值不一致
    $arrayContent[0][0] = "下架圖片";
    $arrayContent[0][1] = "<img src='http://".$_SERVER['HTTP_HOST']."/images/supplier/".$dataSAD['SAD_Num']."/banner/".$dataSel['SIBM_Img']."' style='width:90%;'>";
    $arrayContent[1][0] = "圖片連結";
    $arrayContent[1][1] = "<a target='_blank' href='".$dataSel['SIBM_Url']."'>連結</a>";
    $arrayContent[2][0] = "廣告建立時間";
    $arrayContent[2][1] = $dataSel['SIBM_UpTime'];
    $arrayContent[3][0] = "下架原因";
    $arrayContent[3][1] = nl2br($remark);
    #供應商名稱、下架資訊內容(陣列)
    $mailContent = bannerShelves($nameSAD, $arrayContent); //mail內容生成
    admin_systemMail($Config_db, $nameSAD. ' - 上方橫幅廣告下架', $mailContent); //系統管理員留存
    admin_supplierMail($Config_db, $dataSel['SIBM_SAD_ID'], '上方橫幅廣告下架', $mailContent); //供應商留存
  }

  #上架email通知
  if($status == 'Y' && $status != $dataSel['SIBM_CheckStatus']) { //狀態改為下架，而且資料庫與post過來的值不一致
    $arrayContent[0][0] = "重新上架圖片";
    $arrayContent[0][1] = "<img src='http://".$_SERVER['HTTP_HOST']."/images/supplier/".$dataSAD['SAD_Num']."/banner/".$dataSel['SIBM_Img']."' style='width:90%;'>";
    $arrayContent[1][0] = "圖片連結";
    $arrayContent[1][1] = "<a target='_blank' href='".$dataSel['SIBM_Url']."'>連結</a>";
    $arrayContent[2][0] = "圖片建立時間";
    $arrayContent[2][1] = $dataSel['SIBM_UpTime'];
    $arrayContent[3][0] = "申請原因";
    $arrayContent[3][1] = "<br>".nl2br($dataSel['SIBM_SADClaimReason']);

    #供應商名稱、上架架資訊內容(陣列)
    //$mailContent = bannerAdded($nameSAD, $arrayContent); //mail內容生成
    //admin_systemMail($Config_db, $nameSAD. ' - 上方橫幅廣告上架', $mailContent); //系統管理員留存
    //admin_supplierMail($Config_db, $dataSel['SIBM_SAD_ID'], '上方橫幅廣告上架', $mailContent); //供應商留存
  }

  $ar["remsg"] = "更新成功";
  echo json_encode($ar);
} //if($act == 'edit') { //編輯

?>  