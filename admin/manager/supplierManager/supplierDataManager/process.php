<?php
/*
新增供應商時，要再以供應商id增加以下資料表的欄位 
運費說明: Supplier_IndexFreightIntroduction
購物說明: Supplier_IndexShoppingIntroduction
關於我們說明: Supplier_IndexAbout
版面選擇: Supplier_Layout
logo上傳：Supplier_Logo

並在./images/supplier/ ：此處增加供應商資料夾，
例：
供應商banner存放： ./images/supplier/sadkai/banner/
供應商footer存放：./images/supplier/sadkai/footer/ 
供應商活動廣告存放：./images/supplier/sadkai/ADImg/ 
供應商編輯器圖片存放： ./images/supplier/sadkai/ckeditor/
供應商產品資料夾： ./images/supplier/sadkai/product/
供應商產品大圖： ./images/supplier/sadkai/product/contentImage/
供應商產品小圖： ./images/supplier/sadkai/product/titleImage/

logo圖：./images/supplier/sadkai/logo/
*/

include_once('../../../include/config/config_inc.php');
include_once('../../../include/function/function.php');
include_once('../../../../conf/mailTypeFunciton.php'); //信件function

$act = $_POST['act']; //頁面動作
$errStr = " "; //錯誤碼回傳

#編輯頁面 
if($act == 'edit') {
  $toDate = date("Y-m-d");
  #將input欄位轉為參數
  foreach($_POST as $key=>$val) {
    $$key=$val;
  }

  #找出群組id
  $sqlSelGroup = "select * from Supplier_AccountGroup where SAG_SAD_ID = '".$sid."'";
  $rsSelGroup = $Language_db->query($sqlSelGroup);
  $dataSelGroup = $rsSelGroup->fetch();
  $sagID = $dataSelGroup['SAG_ID']; //供應商群組mapping id

  #更新密碼
  /*
  if($password && $checkpassword) { //密碼自行輸入的
    $passwordStr = $password; //密碼字串
    $sqlUpPw = "UPDATE Supplier_AccountData SET 
                SAD_Password ='".sha1($passwordStr)."'
                WHERE SAD_ID = '".$sid."'
               ";
    $resultPw = $Config_db->prepare($sqlUpPw);
    $resultPw->execute();
  } else { // 密碼自動生成
    $passwordStr = pwRandCreate(); //亂數生成密碼function
    $sqlUpPw = "UPDATE Supplier_AccountData SET 
                SAD_Password ='".sha1($passwordStr)."'
                WHERE SAD_ID = '".$sid."'
               ";
    $resultPw = $Config_db->prepare($sqlUpPw);
    $resultPw->execute();
  }
  */
  if($password && $checkpassword) { //密碼自行輸入的，不分開啟、關閉
    $passwordStr = $password; //密碼字串
    $sqlUpPw = "UPDATE Supplier_AccountData SET 
                SAD_Password ='".sha1($passwordStr)."'
                WHERE SAD_ID = '".$sid."'
               ";
    $resultPw = $Config_db->prepare($sqlUpPw);
    $resultPw->execute();
  } 

  #更新群組資料
  $sqlUpGroup = "UPDATE Supplier_AccountGroup SET 
  SAG_ASG_ID = '".$group."' 
  where SAG_SAD_ID = '".$sid."'";

  $resultGroup = $Language_db->prepare($sqlUpGroup);
  $resultGroup->execute();

  $tableName = "Supplier_AccountData".$Country; //供應商資料表分類 

  #更新供應商資料
  if($Country =='Tw') { //台灣
    $sqlUpData = "UPDATE ".$tableName." SET 
    SADT_Name = '".$Name."',
    SADT_VATNum = '".$VATNum."',
    SADT_Principal = '".$Principal."',
    SADT_Address = '".$Address."',
    SADT_MailingAddress = '".$mailingAddress."',
    SADT_Email = '".$Email."',
    SADT_PhoneZip = '".$PhoneZip."',
    SADT_Phone = '".$Phone."',
    SADT_Fax = '".$Fax."',
    SADT_ContactPerson = '".$ContactPerson."',
    SADT_ContactOffice = '".$ContactOffice."',
    SADT_Remark = '".$Remark."'
    WHERE SADT_SAD_ID = '".$sid."'";
  } else { //大陸
    $sqlUpData = "UPDATE ".$tableName." SET 
    SADC_Name = '".$Name."',
    SADC_SimpleName = '".$SimpleName."',
    SADC_VATNum = '".$VATNum."',
    SADC_ZipCode = '".$ZipCode."',
    SADC_Address = '".$Address."',
    SADC_Website = '".$Website."',
    SADC_Email = '".$Email."',
    SADC_PhoneZip = '".$PhoneZip."',
    SADC_Phone = '".$Phone."',
    SADC_Fax = '".$Fax."',
    SADC_ContactPerson = '".$ContactPerson."',
    SADC_ContactOffice = '".$ContactOffice."',
    SADC_ContactEmail = '".$ContactEmail."',
    SADC_Remark = '".$Remark."'
    WHERE SADC_SAD_ID = '".$sid."'";
  }
  $resultDa = $Config_db->prepare($sqlUpData);
  $resultDa->execute();
	
  #搜尋供應商狀態
  $sqlSADstatus = "select * from Supplier_AccountData where SAD_ID = '".$sid."'";
  $rsSADstatus = $Config_db -> query($sqlSADstatus);
  $dataSADstatus = $rsSADstatus -> fetch();
  if($dataSADstatus['SAD_Status'] != $acStatus) { //判斷更新狀態與資料庫內容不相同(有更動)
    #建立資料夾
    if($acStatus == 'Y') { //上線

      if(!$password && !$checkpassword) { //無輸入設定密碼
        //帳號狀態『關閉』->『開啟』未設定密碼，則改密碼
        $passwordStr = pwRandCreate(); //亂數生成密碼function
        $sqlUpPw = "UPDATE Supplier_AccountData SET 
                    SAD_Password ='".sha1($passwordStr)."'
                    WHERE SAD_ID = '".$sid."'
                   ";
        $resultPw = $Config_db->prepare($sqlUpPw);
        $resultPw->execute();
      }  //if(!$password && !$checkpassword)


      #資料庫物件、資料表名稱、資料欄位、供應商id
      addTable($Config_db, 'Supplier_IndexFreightIntroduction', 'SIFI_SAD_ID', $sid); //增加運費說明 
      addTable($Config_db, 'Supplier_IndexShoppingIntroduction', 'SISI_SAD_ID', $sid); //增加購物說明
      addTable($Config_db, 'Supplier_IndexAbout', 'SIA_SAD_ID', $sid); //增加關於我們
      addTable($Config_db, 'Supplier_Layout', 'SL_SAD_ID', $sid); //增加版面選擇，預設紅色 
      addTable($Config_db, 'Supplier_Logo', 'SL_SAD_ID', $sid); //增加logo上傳欄位

      $path = "../../../../images/supplier/".$dataSADstatus['SAD_Num']; //供應商根目錄

      if(!is_dir($path)) { //判斷如果沒此資料夾的話
        mkdir($path,0777,true);
        mkdir("../../../../images/supplier/".$dataSADstatus['SAD_Num']."/banner",0777,true); //banner圖資料夾
        mkdir("../../../../images/supplier/".$dataSADstatus['SAD_Num']."/footer",0777,true); //footer圖資料夾
        mkdir("../../../../images/supplier/".$dataSADstatus['SAD_Num']."/adImage",0777,true); //活動廣告圖資料夾
        mkdir("../../../../images/supplier/".$dataSADstatus['SAD_Num']."/ckeditor",0777,true); //編輯器圖資料夾
        mkdir("../../../../images/supplier/".$dataSADstatus['SAD_Num']."/product",0777,true); //產品圖資料夾
        mkdir("../../../../images/supplier/".$dataSADstatus['SAD_Num']."/product/contentImage",0777,true); //產品大圖資料夾
        mkdir("../../../../images/supplier/".$dataSADstatus['SAD_Num']."/product/titleImage",0777,true); //產品小圖資料夾
        mkdir("../../../../images/supplier/".$dataSADstatus['SAD_Num']."/product/firstImage",0777,true); //產品原圖資料夾
        mkdir("../../../../images/supplier/".$dataSADstatus['SAD_Num']."/logo",0777,true); //供應商logo資料夾
      } else {
        $errStr = "<br>無法建立資料夾";
      }

      #開通mail處理
      //呼叫供應商資料
      if($dataSADstatus['SAD_Country'] == 'Tw') { //台灣
        $sqlSAD = "select * from Supplier_AccountDataTw where SADT_SAD_ID = '".$sid."'";
        $rsSAD = $Config_db -> query($sqlSAD);
        $dataSAD = $rsSAD ->fetch();
        #信件處理
        $arraySAD[0][0] = "公司名稱";
        $arraySAD[0][1] = $dataSAD['SADT_Name'];
        $arraySAD[1][0] = "公司統編";
        $arraySAD[1][1] = $dataSAD['SADT_VATNum'];
        $arraySAD[1][0] = "負責人";
        $arraySAD[1][1] = $dataSAD['SADT_Principal'];
        $arraySAD[2][0] = "公司營業地";
        $arraySAD[2][1] = $dataSAD['SADT_Address'];
        $arraySAD[3][0] = "公司通訊地";
        $arraySAD[3][1] = $dataSAD['SADT_MailingAddress'];
        $arraySAD[4][0] = "公司電話國碼";
        $arraySAD[4][1] = $dataSAD['SADT_PhoneZip'];
        $arraySAD[5][0] = "公司電話";
        $arraySAD[5][1] = $dataSAD['SADT_Phone'];
        $arraySAD[6][0] = "公司傳真";
        $arraySAD[6][1] = $dataSAD['SADT_Fax'];

        $arrayContact[1][0] = "聯絡人";
        $arrayContact[1][1] = $dataSAD['SADT_ContactPerson'];
        $arrayContact[2][0] = "職位";
        $arrayContact[2][1] = $dataSAD['SADT_ContactOffice'];
        $arrayContact[3][0] = "聯絡電話";
        $arrayContact[3][1] = $dataSAD['SADT_ContactPhone'];
        $arrayContact[4][0] = "聯絡EMAIL";
        $arrayContact[4][1] = $dataSAD['SADT_Email'];

      } 
      
      $arraySADdata[0][0] = "登入位置";
      $arraySADdata[0][1] = "http://fs.kingtechcorp.com/tc_admin/login.php";
      $arraySADdata[1][0] = "帳號";
      $arraySADdata[1][1] = $dataSADstatus['SAD_Account'];
      $arraySADdata[2][0] = "密碼";
      $arraySADdata[2][1] = $passwordStr;


      #供應商資料(陣列)、聯絡資料(陣列)、供應商帳號資料(陣列)[帳號]
      $mailContent = SADstatusOK($arraySAD, $arrayContact, $arraySADdata); //生成email內容
      admin_systemMail($Config_db, $dataSAD['SADT_Name']. ' 供應商帳號已開通', $mailContent); //系統管理員留存
      admin_supplierMail($Config_db, $sid, '供應商帳號已開通', $mailContent); //供應商留存

      #開啟帳號時間
        #更新帳號資料
        $sqlStatusOpen = "UPDATE Supplier_AccountData SET 
        SAD_Status = '".$acStatus."',
        SAD_OpenDate = '".$toDate."'
        WHERE SAD_ID = '".$sid."'";
        $resultStatusOpen = $Config_db->prepare($sqlStatusOpen);
        $resultStatusOpen->execute();
    } else { //關閉
      #mail處理
      if($dataSADstatus['SAD_Country'] == 'Tw') { //台灣
        $sqlSAD = "select * from Supplier_AccountDataTw where SADT_SAD_ID = '".$sid."'";
        $rsSAD = $Config_db -> query($sqlSAD);
        $dataSAD = $rsSAD ->fetch();
        #信件處理
        $arraySAD[0][0] = "公司名稱";
        $arraySAD[0][1] = $dataSAD['SADT_Name'];
        $arraySAD[1][0] = "公司統編";
        $arraySAD[1][1] = $dataSAD['SADT_VATNum'];
        $arraySAD[1][0] = "負責人";
        $arraySAD[1][1] = $dataSAD['SADT_Principal'];
        $arraySAD[2][0] = "公司營業地";
        $arraySAD[2][1] = $dataSAD['SADT_Address'];
        $arraySAD[3][0] = "公司通訊地";
        $arraySAD[3][1] = $dataSAD['SADT_MailingAddress'];
        $arraySAD[4][0] = "公司電話國碼";
        $arraySAD[4][1] = $dataSAD['SADT_PhoneZip'];
        $arraySAD[5][0] = "公司電話";
        $arraySAD[5][1] = $dataSAD['SADT_Phone'];
        $arraySAD[6][0] = "公司傳真";
        $arraySAD[6][1] = $dataSAD['SADT_Fax'];

        $arrayContact[1][0] = "聯絡人";
        $arrayContact[1][1] = $dataSAD['SADT_ContactPerson'];
        $arrayContact[2][0] = "職位";
        $arrayContact[2][1] = $dataSAD['SADT_ContactOffice'];
        $arrayContact[3][0] = "聯絡電話";
        $arrayContact[3][1] = $dataSAD['SADT_ContactPhone'];
        $arrayContact[4][0] = "聯絡EMAIL";
        $arrayContact[4][1] = $dataSAD['SADT_Email'];
      } 
      
      $arraySADdata[1][0] = "帳號";
      $arraySADdata[1][1] = $dataSADstatus['SAD_Account'];

      #供應商資料(陣列)、聯絡資料(陣列)、供應商帳號資料(陣列)[帳號]
      $mailContent = SADstatusClose($arraySAD, $arrayContact, $arraySADdata);
      admin_systemMail($Config_db, $dataSAD['SADT_Name']. ' 供應商帳號已關閉', $mailContent); //系統管理員留存
      admin_supplierMail($Config_db, $sid, '供應商帳號已關閉', $mailContent); //供應商留存

      #更新帳號資料
      $sqlStatusClose = "UPDATE Supplier_AccountData SET 
      SAD_Status = '".$acStatus."',
      SAD_CloseDate = '".$toDate."'
      WHERE SAD_ID = '".$sid."'";
      $resultStatusClose = $Config_db -> prepare($sqlStatusClose);
      $resultStatusClose -> execute();
    }
  }
  
  #權限處理
  //將權限陣列變字串
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
    $sqlPlus .= ",SAD_Competence = '".$str."'"; //增加搜尋條件
  } else {
    $sqlPlus .= ",SAD_Competence = '' "; //若沒有值傳送，表示權限被全取下，設定為空白
  }

  #更新帳號資料
  $sqlUpAc = "UPDATE Supplier_AccountData SET 
  SAD_Account = '".$account."',
  SAD_Country = '".$Country."',
  SAD_Group = '".$sagID."'
  $sqlPlus
  WHERE SAD_ID = '".$sid."'";
  $result = $Config_db->prepare($sqlUpAc);
  $result->execute();
  
	$ar["remsg"] = "成功更新";
	echo json_encode($ar);
} //if($act == 'edit') {



#新增頁面
if($act == 'add') { 
  $toDate = date("Y-m-d"); //今日日期
  #將input欄位轉為參數
  foreach($_POST as $key=>$val) {
    $$key=$val;
  }
  $passwordStr = pwRandCreate(); //亂數生成密碼function
  $SADnum = RandCreateNum(); //供應商編碼
  #資料庫語法
  $sql = "INSERT INTO Supplier_AccountData ( 
            SAD_Num,
            SAD_Country, 
            SAD_Account, 
            SAD_Password, 
            SAD_Status, 
            SAD_CreateDate
          ) VALUES ( 
            '".$SADnum."',
            '".$Country."', 
            '".$account."', 
            '".sha1($passwordStr)."', 
            '".$acStatus."', 
            '".$toDate."'
          )";
  $result = $Config_db->prepare($sql);
  $result->execute();

  $reSadID =  $Config_db->lastInsertId(); //得到上一筆加入的供應商id

  #群組資料庫處理
  $sqlGroup = "INSERT INTO Supplier_AccountGroup ( SAG_SAD_ID, SAG_ASG_ID) VALUES 
  ( '".$reSadID."', '".$group."' )";
  $resultGroup = $Language_db->prepare($sqlGroup);
  $resultGroup->execute();
  
  $tableName = "Supplier_AccountData".$Country; //供應商資料表分類 

  #台灣區供應商寫入資料
  if($Country =='Tw') { //台灣
    $sqlData = "INSERT INTO ".$tableName." ( 
                  SADT_Name, 
                  SADT_VATNum, 
                  SADT_Principal,
                  SADT_Address, 
                  SADT_MailingAddress,
                  SADT_Email, 
                  SADT_PhoneZip, 
                  SADT_Phone, 
                  SADT_Fax, 
                  SADT_ContactPerson, 
                  SADT_ContactOffice, 
                  SADT_ContactPhone,
                  SADT_Remark, 
                  SADT_SAD_ID
                ) VALUES ( 
                  '".$Name."', 
                  '".$VATNum."', 
                  '".$Principal."',
                  '".$Address."', 
                  '".$mailingAddress."',
                  '".$Email."', 
                  '".$PhoneZip."', 
                  '".$Phone."', 
                  '".$Fax."', 
                  '".$ContactPerson."',
                  '".$ContactOffice."',
                  '".$ContactPhone."',
                  '".$Remark."',
                  '".$reSadID."'
                )";
  } else { //大陸
    $sqlData = "INSERT INTO ".$tableName." ( 
                  SADC_Name, 
                  SADC_SimpleName, 
                  SADC_VATNum, 
                  SADC_ZipCode, 
                  SADC_Address, 
                  SADC_Website, 
                  SADC_Email, 
                  SADC_PhoneZip, 
                  SADC_Phone, 
                  SADC_Fax, 
                  SADC_ContactPerson, 
                  SADC_ContactOffice, 
                  SADC_ContactEmail,
                  SADC_Remark, 
                  SADC_SAD_ID
                ) VALUES ( 
                  '".$Name."', 
                  '".$SimpleName."', 
                  '".$VATNum."', 
                  '".$ZipCode."', 
                  '".$Address."', 
                  '".$Website."', 
                  '".$Email."', 
                  '".$PhoneZip."', 
                  '".$Phone."', 
                  '".$Fax."', 
                  '".$ContactPerson."', 
                  '".$ContactOffice."', 
                  '".$ContactEmail."', 
                  '".$Remark."', 
                  '".$reSadID."' 
                )";
  }
  $resultData = $Config_db->prepare($sqlData);
  $resultData->execute();

  #建立資料夾
  if($acStatus=='Y') { //開啟，要通知供應商
    #增加相關功能說明欄位 
    #資料庫物件、資料表名稱、資料欄位、供應商id
    addTable($Config_db, 'Supplier_IndexFreightIntroduction', 'SIFI_SAD_ID', $reSadID); //增加運費說明 
    addTable($Config_db, 'Supplier_IndexShoppingIntroduction', 'SISI_SAD_ID', $reSadID); //增加購物說明
    addTable($Config_db, 'Supplier_IndexAbout', 'SIA_SAD_ID', $reSadID); //增加關於我們
    addTable($Config_db, 'Supplier_Layout', 'SL_SAD_ID', $reSadID); //增加版面選擇，預設紅色 
    addTable($Config_db, 'Supplier_Logo', 'SL_SAD_ID', $reSadID); //增加logo上傳欄位

    $path = "../../../../images/supplier/".$SADnum; //供應商根目錄
    if(!is_dir($path)) {
      mkdir($path,0777,true);
      mkdir("../../../../images/supplier/".$SADnum."/banner",0777,true); //banner圖資料夾
      mkdir("../../../../images/supplier/".$SADnum."/footer",0777,true); //footer圖資料夾
      mkdir("../../../../images/supplier/".$SADnum."/adImage",0777,true); //活動廣告圖資料夾
      mkdir("../../../../images/supplier/".$SADnum."/ckeditor",0777,true); //編輯器圖資料夾
      mkdir("../../../../images/supplier/".$SADnum."/product",0777,true); //產品圖資料夾
      mkdir("../../../../images/supplier/".$SADnum."/product/contentImage",0777,true); //產品大圖資料夾
      mkdir("../../../../images/supplier/".$SADnum."/product/titleImage",0777,true); //產品小圖資料夾
      mkdir("../../../../images/supplier/".$SADnum."/product/firstImage",0777,true); //產品原圖資料夾
      mkdir("../../../../images/supplier/".$SADnum."/logo",0777,true); //供應商logo資料夾
    } else { //新增資料後關閉，暫時先建檔
      $errStr = "<br>無法建立資料夾";
    }

    #信件處理
    $arraySAD[0][0] = "公司名稱";
    $arraySAD[0][1] = $Name;
    $arraySAD[1][0] = "公司統編";
    $arraySAD[1][1] = $VATNum;
    $arraySAD[1][0] = "負責人";
    $arraySAD[1][1] = $Principal;
    $arraySAD[2][0] = "公司營業地";
    $arraySAD[2][1] = $Address;
    $arraySAD[3][0] = "公司通訊地";
    $arraySAD[3][1] = $mailingAddress;
    $arraySAD[4][0] = "公司電話國碼";
    $arraySAD[4][1] = $PhoneZip;
    $arraySAD[5][0] = "公司電話";
    $arraySAD[5][1] = $Phone;
    $arraySAD[6][0] = "公司傳真";
    $arraySAD[6][1] = $Fax;

    $arrayContact[1][0] = "聯絡人";
    $arrayContact[1][1] = $ContactPerson;
    $arrayContact[2][0] = "職位";
    $arrayContact[2][1] = $ContactOffice;
    $arrayContact[3][0] = "聯絡電話";
    $arrayContact[3][1] = $ContactPhone;
    $arrayContact[4][0] = "聯絡EMAIL";
    $arrayContact[4][1] = $Email;

    $arraySADdata[0][0] = "登入位置";
    $arraySADdata[0][1] = "http://fs.kingtechcorp.com/tc_admin/login.php";
    $arraySADdata[1][0] = "帳號";
    $arraySADdata[1][1] = $account;
    $arraySADdata[2][0] = "密碼";
    $arraySADdata[2][1] = $passwordStr;

    #供應商資料(陣列)、聯絡資料(陣列)、供應商帳號資料(陣列)[帳號]
    $mailContent = SADstatusOK($arraySAD, $arrayContact, $arraySADdata); //生成email內容
    admin_systemMail($Config_db, $Name. ' 供應商帳號已開通', $mailContent); //系統管理員留存
    admin_supplierMail($Config_db, $reSadID, '供應商帳號已開通', $mailContent); //供應商留存

  } //if($acStatus=='Y') { //開啟，要通知供應商
  

  $ar["remsg"] = "新增成功".$errStr;
  echo json_encode($ar);

} //if($act == 'add') {

#刪除資料
if($act == 'del') {
  $id = $_POST['id']; //供應商id

  #刪除資料夾
  $sadData = fiveSadAccountSearch($Config_db,$id); //找出供應商資料
  if(is_dir("../../../../images/supplier/".$sadData[1])) { //如果有此資料夾，則刪除
    $count += deleteDirectory("../../../../images/supplier/".$sadData[1]); //刪除該供應商的資料夾
  }

  /* Delete all rows from the FRUIT table */
  $sqlDel = "UPDATE Supplier_AccountData SET SAD_Status = 'N' WHERE SAD_ID = '".$id."'"; //將供應商的帳號設定為取消
  $result = $Config_db->prepare($sqlDel);
  $count = $result->execute();
  /*
  $count = $Config_db->exec("DELETE FROM Supplier_AccountData WHERE SAD_ID = '".$id."'");
  $count += $Config_db->exec("DELETE FROM Supplier_AccountDataTw WHERE SADT_SAD_ID = '".$id."'"); //刪除台灣供應商資料表
  $count += $Config_db->exec("DELETE FROM Supplier_AccountDataCn WHERE SADC_SAD_ID = '".$id."'"); //刪除大陸供應商資料表

  #刪除運費說明
  $count += $Config_db->exec("DELETE FROM Supplier_IndexFreightIntroduction WHERE SIFI_SAD_ID = '".$id."'");

  #刪除購物說明
  $count += $Config_db->exec("DELETE FROM Supplier_IndexShoppingIntroduction WHERE SISI_SAD_ID = '".$id."'");

  #刪除關於我們
  $count += $Config_db->exec("DELETE FROM Supplier_IndexAbout WHERE SIA_SAD_ID = '".$id."'");

  #刪除版面選擇
  $count += $Config_db->exec("DELETE FROM Supplier_Layout WHERE SL_SAD_ID = '".$id."'");
  
  #刪除群組關聯資料表
  $count += $Language_db->exec("DELETE FROM Supplier_AccountGroup WHERE SAG_SAD_ID = '".$id."'");
 
  #刪除logo資料表
  $count += $Config_db->exec("DELETE FROM Supplier_Logo WHERE SL_SAD_ID = '".$id."'");
  
  #刪除運費計算方式
  $count += $Config_db->exec("DELETE FROM Supplier_ProductNotFreight WHERE SPNF_SAD_ID = '".$id."'");
  
  #列出供應商的產品資料圖，並刪除
  $RSpro = $Language_db -> query("SELECT * FROM Supplier_ProductDetail where SPD_SAD_ID = '".$id."' "); //列出供應商的商品
  while($DataPro = $RSpro -> fetch()) {
    $count += $Language_db->exec("DELETE FROM Supplier_ProductImage WHERE SPI_SPD_PID = '".$DataPro['SPD_PID']."'");
  }

  #刪除供應商的產品資料
  $count += $Config_db->exec("DELETE FROM Supplier_ProductDetail WHERE SPD_SAD_ID = '".$id."'");

  #刪除供應商的群組資料
  $count += $Config_db->exec("DELETE FROM Supplier_AccountGroup WHERE SAG_SAD_ID = '".$id."'");
  */
  #刪除供應商的點擊資料

  #刪除供應商的訂單資料
  
  //$ar["remsg"] = "刪除成功，影響 ".$count." 行的數列";
  $ar["remsg"] = "關閉成功！";
  echo json_encode($ar);
} //if($act == 'del') {

#供應商忘記密碼申請
if($act == 'forgetSend') {
  $passwordStr = pwRandCreate(); //亂數生成密碼function
  $id = $_POST['id']; //供應商id

  #更新資料庫內容
  $sqlPW = "UPDATE Supplier_AccountData SET 
            SAD_Password = '".sha1($passwordStr)."'
            WHERE SAD_ID = '".$id."'
            ";
  $result = $Config_db->prepare($sqlPW);
  $result -> execute();
  
  #撈出供應商帳號資料
  $sqlSel = "select * from Supplier_AccountData where SAD_ID = '".$id."'";
  $rsSel  = $Config_db -> query($sqlSel);
  $dataSel = $rsSel -> fetch();

  $name = sadAccountSearch($Config_db, $id); //供應商名稱
  #供應商名稱、帳號、密碼
  $mailContent = forgetSAD($name, $dataSel['SAD_Account'], $passwordStr);
  admin_systemMail($Config_db, '忘記密碼 - '.$name, $mailContent); //系統管理員留存
  admin_supplierMail($Config_db, $id, '重新申請新密碼資訊', $mailContent); //供應商

  $ar["remsg"] = "申請成功";
  echo json_encode($ar);
}
?>