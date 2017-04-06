<?php
session_start(); //讓session可執行

include_once('../../../include/config/config_inc.php');
include_once('../../../include/function/function.php');
include_once('../../../../conf/mailTypeFunciton.php'); //email的格式function
 

$act = $_POST['act']; //執行動作判斷 

if($act == 'edit') { //編輯

  #將post過來的值宣告成變數
  foreach($_POST as $key=>$val) {
    $$key=$val;
  }

  #修改詢價產品資料庫
  for($i=0;$i<count($pID);$i++) {
    $sqlUpPro = "UPDATE Admin_OrderInquiryProduct SET 
    AOIP_Name = '".$pName[$i]."',
    AOIP_Nom = '".$pNom[$i]."',
    AOIP_Amount = '".$pAmount[$i]."',
    AOIP_Remark = '".$pRemarks[$i]."'
    WHERE AOIP_ID = '".$pID[$i]."' ";
    $resultPro = $Language_db->prepare($sqlUpPro);
    $resultPro->execute();
  }
  
  #更新狀況、紀錄內容、檔案(未製作)，更新詢價者資料
  $sqlUpList = "UPDATE Admin_OrderInquiryList SET 
    AOIL_Name = '".$name."',
    AOIL_Sex = '".$sex."',
    AOIL_Phone = '".$phone."',
    AOIL_Address = '".$address."',
    AOIL_Email = '".$email."',
    AOIL_Remark = '".$mRemarks."',
    AOIL_ProStatus = '".$selectOrderStatus."',
    AOIL_Record = '".$remark."'
    WHERE AOIL_InquiryNum = '".$id."' ";
  $resultList = $Language_db->prepare($sqlUpList);
  $resultList->execute();

  #更新供應商回報的自建詢價單
  if(count($supplierCreate) > 0 ) { //有值則進入修改階段
    foreach($supplierCreate as $key => $val) { //key:回報id
      //更新回報的總金額、含稅、報價說明
      $sqlUpSAD = "UPDATE  Admin_OrderInquirySupplier 
                   SET AOIS_Tax = '".$val["status"]."',
                   AOIS_ReTotal =  '".$val["reTotal"]."',
                   AOIS_ReRemark = '".$val["reRemark"]."'
                   where AOIS_ID = '".$key."'
                  ";

      $rsUpSAD = $Language_db->prepare($sqlUpSAD);
      $rsUpSAD->execute();         
      //更新回報的產品明細報價
      foreach($val["product"] as $key2=>$val2) {
        $sqlUpProduct = "UPDATE Admin_OrderInquiryProductCreate
                         SET AOIPC_Name = '".$val2["name"]."',
                         AOIPC_Nom = '".$val2["nom"]."',
                         AOIPC_Amount = '".$val2["amount"]."',
                         AOIPC_Price = '".$val2["price"]."',
                         AOIPC_Remark = '".$val2["remarks"]."',
                         AOIPC_RePrice = '".$val2["rePrice"]."'
                         WHERE AOIPC_ID = '".$val2["id"]."'
                        ";   
        $rsUpProduct = $Language_db->prepare($sqlUpProduct);
        $rsUpProduct->execute();                 
      }  
    }

  }
  
  $ar["remsg"] = "更新成功";
  echo json_encode($ar);
} //if($act == 'edit') { //編輯

#給供應商報價資料
if($act == 'send') {
  #將post值轉為參數
  foreach($_POST as $key=>$val) {
    $$key=$val;
  }
  $id;//詢價單號
  $toTime = date("Y-m-d H:i:s");

  #列出供應商id
  //for($i=0;$i<count($sadID);$i++) {
  $str = "";
  foreach($sadID as $key=>$val) { //根據供應商群組sadID[群組數量][供應商數量]做區分
    foreach($val as $key1 => $val1) {//列出供應商ID 
      //給供應商的總詢價資料
      $sql = "INSERT INTO Admin_OrderInquirySupplier ( AOIS_CreateDate, AOIS_Message, AOIS_SAD_ID, AOIS_AOIL_InquiryNum) 
      VALUES ( '".$toTime."', '".$message."', '".$val1."', '".$id."'); ";
      $result = $Language_db->prepare($sql);
      $result->execute();

      $lastSadId = $Language_db -> lastInsertId(); //供應商詢價資料的id，回報單id

      //做單品推送，列出有勾選的產品
      /*
      foreach($checkInquiryPro as $keyPro => $valPro) {
        $sqlPro = "INSERT INTO Admin_OrderInquiryProductRecord ( AOIPR_SAD_ID, AOIPR_AOIP_ID) 
        VALUES ( '".$val1."', '".$valPro."'); ";
        $resultPro = $Language_db->prepare($sqlPro);
        $resultPro->execute();
      }
      */
      #單品推送，生成各產品的詢價單數
      //找出詢價單中要推送的單品
      /*
      $SQLInquiryPro = "SELECT * FROM Admin_OrderInquiryProduct where AOIP_AOIL_InquiryNum = '".$id."' ";
      $RSInquiryPro = $Language_db -> query($SQLInquiryPro);
      $DATAInquiryPro = $RSInquiryPro -> fetchall();

      //根據詢價商品逐項生成詢問單
      foreach($DATAInquiryPro as $key2 => $val2) {
        $sqlPro = "INSERT INTO Admin_OrderInquiryProductRecord ( AOIPR_SAD_ID, AOIPR_AOIP_ID, AOIPR_AOIS_ID) 
        VALUES ( '".$val1."', '".$val2['AOIP_ID']."', '".$lastSadId."'); ";
        $resultPro = $Language_db->prepare($sqlPro);
        $resultPro->execute();
      } //foreach($DATAInquiryPro as $key2 => $val2) {
      */
      #管理者建立詢價單給供應商
      //抓取建立的自建單陣列
      for($i=0;$i<count($pName);$i++) { //以產品名稱為主
        $sqlPro = "INSERT INTO Admin_OrderInquiryProductCreate (
                     AOIPC_Name,
                     AOIPC_Nom,
                     AOIPC_Amount,
                     AOIPC_Price,
                     AOIPC_Remark,
                     AOIPC_AOIS_ID
                   ) VALUES (
                     '".$pName[$i]."',
                     '".$pNom[$i]."',
                     '".$pAmount[$i]."',
                     '".$pPrice[$i]."',
                     '".$pRemark[$i]."',
                     '".$lastSadId."'
                   )
                  ";
        $resultPro = $Language_db->prepare($sqlPro);
        $resultPro->execute(); 

        //建立陣列供mail使用      
        $arrayInquiryPro[$i]['name']= $pName[$i]; //產品名稱
        $arrayInquiryPro[$i]['nom']= $pNom[$i]; //產品規格
        $arrayInquiryPro[$i]['amount']= $pAmount[$i]; //產品數量
        $arrayInquiryPro[$i]['price']= $pPrice[$i]; //參考金額 
        $arrayInquiryPro[$i]['remark']= $pRemark[$i]; //產品說明
      }  
    } //foreach($val as $key1 => $val1) {
    #mail處理
    #詢價編號、產品明細(陣列)、管理者備註
    $mailContent = inquirySupplierSend($id, $arrayInquiryPro, $message); //建立信件內容
    admin_systemMail($Config_db, 'FIVESTARS - 報價單資料送出_'.sadAccountSearch($Config_db,$val1), $mailContent);  //寄給管理者
    admin_supplierMail($Config_db, $val1, 'FIVESTARS - 報價單資料', $mailContent);//寄給供應商 
  } //foreach($sadID as $key=>$val) {

  #更新詢價狀態
  $sqlUp = "UPDATE  Admin_OrderInquiryList SET  AOIL_ProStatus =  'transfer' WHERE AOIL_InquiryNum like '".$id."'";
  $resultUp = $Language_db->prepare($sqlUp);
  $resultUp->execute();

  $ar["remsg"] = "送出成功";
  echo json_encode($ar);
}

#回覆給會員的資訊
if($act == 'sendM') {
  #將post值轉為參數
  foreach($_POST as $key=>$val) {
    $$key=$val;
  }
  $amid = $_SESSION['AM_ID']; //管理者id
  #更新詢價狀態
  $sqlUp = "UPDATE  Admin_OrderInquiryList SET 
  AOIL_ProStatus = 'quoted', 
  AOIL_Send = 'Y',
  AOIL_rePrice = '".$rePrice."', 
  AOIL_Message = '".$message."', 
  AOIL_AM_ID = '".$amid."' 
  WHERE AOIL_InquiryNum like '".$id."' ";
  $resultUp = $Language_db->prepare($sqlUp);
  $resultUp->execute();

  #email處理
  //叫出會員個資，總詢問事項
  $sqlMem = "select * from Admin_OrderInquiryList where AOIL_InquiryNum = '".$id."'";
  $rsMem = $Language_db->query($sqlMem);
  $dataMem = $rsMem->fetch();

  //陣列處理
  $carateTime = $dataMem['AOIL_CreateDate'];
  $arrayMemberData[0][0] = "姓名";
  $arrayMemberData[0][1] = $dataMem['AOIL_Name'];
  $arrayMemberData[1][0] = "姓別";
  $arrayMemberData[1][1] = $dataMem['AOIL_Sex'];
  $arrayMemberData[2][0] = "聯絡電話";
  $arrayMemberData[2][1] = $dataMem['AOIL_Phone'];
  $arrayMemberData[3][0] = "地址";
  $arrayMemberData[3][1] = $dataMem['AOIL_Address'];
  $arrayMemberData[4][0] = "信箱";
  $arrayMemberData[4][1] = $dataMem['AOIL_Email'];
  $arrayMemberData[5][0] = "備註";
  $arrayMemberData[5][1] = nl2br($dataMem['AOIL_Remark']);

  //叫出詢問產品列表
  $sqlInquiryPro = "select * from Admin_OrderInquiryProduct where AOIP_AOIL_InquiryNum = '".$id."'";
  $rsInquiryPro = $Language_db->query($sqlInquiryPro);
  $dataInquiryPro = $rsInquiryPro->fetchAll(PDO::FETCH_ASSOC); //移除數字索引
  
  for($i=0;$i<count($dataInquiryPro);$i++) {
    $arrayPro[$i]['name'] = $dataInquiryPro[$i]['AOIP_Name']; //產品名稱
    $arrayPro[$i]['nom'] = $dataInquiryPro[$i]['AOIP_Nom']; //產品規格
    $arrayPro[$i]['amount'] = $dataInquiryPro[$i]['AOIP_Amount']; //產品數量
    $arrayPro[$i]['referPrice'] = $dataInquiryPro[$i]['AOIP_ReferPrice']; //參考金額

    if($dataInquiryPro[$i]['AOIP_ReferSupplier']) { //有供應商
      $arrayPro[$i]['referSAD'] = sadAccountSearch($Config_db,$dataInquiryPro[$i]['AOIP_ReferSupplier']);//參考供應商 
    } else { //無供應商
      $arrayPro[$i]['referSAD'] = "";
    }
    
    $arrayPro[$i]['remark'] = $dataInquiryPro[$i]['AOIP_Remark']; //商品備註
  }

  //產品mail內容
  #詢價編號、產品陣列、會員資料、回覆金額、回覆訊息、建立時間
  $mailContent = inquirySendMem($id, $arrayPro, $arrayMemberData, $rePrice, $message, $carateTime); //建立email內容

  admin_systemMail($Config_db, 'FIVESTARS - 報價單回覆會員', $mailContent);  //寄給管理者
  admin_webMailSent($dataMem['AOIL_Email'], 'FIVESTARS - 報價單回覆', $mailContent);  //寄給會員

  $ar["remsg"] = "送出成功";
  echo json_encode($ar);
}

if($act == 'del') {
  
  $id = $_POST['id']; //詢價單號
  /* Delete all rows from the FRUIT table */
  $count += $Language_db->exec("DELETE FROM Admin_OrderInquiryList WHERE AOIL_InquiryNum = '".$id."'"); //刪除主詢價人個資資料表
  $count += $Language_db->exec("DELETE FROM Admin_OrderInquiryProduct WHERE AOIP_AOIL_InquiryNum = '".$id."'"); //刪除詢價產品資料表
  $count += $Language_db->exec("DELETE FROM Admin_OrderInquirySupplier WHERE AOIS_AOIL_InquiryNum = '".$id."'"); //刪除廠商回報資料

  $ar["remsg"] = "刪除成功，影響 ".$count." 行數列";
  echo json_encode($ar);
}

if($act == 'editDel') { //供應商回報單刪除
  $id = $_POST['id']; //回報id，AOIS_ID

  $count += $Language_db->exec("DELETE FROM Admin_OrderInquirySupplier WHERE AOIS_ID = '".$id."'"); //刪除該供應商的回報總金額資料表
  $count += $Language_db->exec("DELETE FROM Admin_OrderInquiryProductCreate WHERE AOIPC_AOIS_ID = '".$id."'");//刪除詢價內容

  $ar["remsg"] = "刪除成功，影響 ".$count." 行數列";
  echo json_encode($ar);
}

//詢價轉訂單處理
if($act=='inquiryChangePro') {

  #將post值轉為參數
  foreach($_POST as $key=>$val) {
    $$key=$val;
  }
  
  #系統時間
  $createDate = Date('Y-m-d');
  $createTime = Date('H-i-s');
  #訂單編號
  $orderNum = getGUID();

  #訂單明碼
  $orderNumCode = substr($orderNum,0,3).date("Ymd").substr($orderNum,-3); 

  #收件資料
  $sqlInsertTitle = "INSERT INTO Admin_OrderChangeInquiryTitle (AOCIT_OrderNum, 
                                                                AOCIT_OrderNumCode, 
                                                                AOCIT_Name, 
                                                                AOCIT_Address, 
                                                                AOCIT_Phone, 
                                                                AOCIT_Mobile, 
                                                                AOCIT_Email, 
                                                                AOCIT_Payment, 
                                                                AOCIT_OrderStatus, 
                                                                AOCIT_ProductSataus, 
                                                                AOCIT_Freight, 
                                                                AOCIT_CreateDate, 
                                                                AOCIT_CreateTime, 
                                                                AOCIT_MAD_Num, 
                                                                AOCIT_AOIL_InquiryNum, 
                                                                AOCIT_Remarks
                                                                ) VALUES ( 
                                                                '".$orderNum."', 
                                                                '".$orderNumCode."', 
                                                                '".$recipientName."',  
                                                                '".$address."', 
                                                                '".$phone."', 
                                                                '".$mobile."', 
                                                                '".$email."', 
                                                                '".$payment."', 
                                                                '".$orderStatus."', 
                                                                '".$orderCheckoutStatus."', 
                                                                '".$freightChechout."', 
                                                                '".$createDate."', 
                                                                '".$createTime."', 
                                                                '".$M_Num."', 
                                                                '".$id."', 
                                                                '".$adminRemarks."'
                                                                ) ";
  $Language_db -> query($sqlInsertTitle);

  #寫入詢價時的商品
  #產品列出
  $sqlInquiryPro = "select * from Admin_OrderInquiryProduct where AOIP_AOIL_InquiryNum = '".$id."'";
  $rsInquiryPro = $Language_db->query($sqlInquiryPro);
  $dataInquiryPro = $rsInquiryPro->fetchAll(PDO::FETCH_ASSOC); //移除數字索引

  foreach($dataInquiryPro as $key=>$val) {
    $sqlInsertProduct = "INSERT INTO Admin_OrderChangeInquiryProduct (
                                                                    AOCIP_Name, 
                                                                    AOCIP_Nom, 
                                                                    AOCIP_Amount, 
                                                                    AOCIP_AOCIT_OrderNum
                                                                   ) VALUES (
                                                                    '".$val['AOIP_Name']."', 
                                                                    '".$val['AOIP_Nom']."', 
                                                                    '".$val['AOIP_Amount']."', 
                                                                    '".$orderNum."'
                                                                    )";
    $Language_db -> query($sqlInsertProduct);
  }
  
  #寫入物流、運費、總金額資料
  $sqlInsertStatus = "INSERT INTO Admin_OrderChangeInquiryStatus (
                                                                  AOCIS_FreightPrice, 
                                                                  AOCIS_TotalPrice, 
                                                                  AOCIS_Shipping, 
                                                                  AOCIS_Payment,
                                                                  AOCIS_LogisticsName, 
                                                                  AOCIS_LogisticsNum, 
                                                                  AOCIS_InvoiceType, 
                                                                  AOCIS_InvoiceTitle, 
                                                                  AOCIS_InvoiceNum, 
                                                                  AOCIS_AOCIT_OrderNum
                                                                  ) VALUES (
                                                                  '".$freightPrice."', 
                                                                  '".$totalPrice."', 
                                                                  '".$shipping."', 
                                                                  '".$payment."', 
                                                                  '".$logisticsName."', 
                                                                  '".$logisticsNumber."', 
                                                                  '".$selectInvoiceType."', 
                                                                  '".$invoiceTitle."', 
                                                                  '".$invoiceNumber."',
                                                                  '".$orderNum."'
                                                                  )";
  $Language_db -> query($sqlInsertStatus);

  $ar["remsg"] = "送出成功";
  echo json_encode($ar);
}

?>  