<?php
  session_start(); //讓session可執行

  include_once('../../../include/config/config_inc.php');
  include_once('../../../include/function/function.php');
   

  $act = $_POST['act']; //執行動作判斷

  //一般會員編輯動作
  if( $act == 'editG' ) {
    foreach ($_POST as $postData => $value) {
      $$postData = $value; 
    }

    #檢查自訂電話國碼是否有輸入
    
    if($MADG_PhoneCode=='other') {//電話國碼，判斷是否為自訂輸入
      $MADG_PhoneCode = 'other#'.$_POST['phoneZipText'];
    }
    


    $sqlUpdateGeneral = "UPDATE Member_AccountsDataGeneral 
                         SET MADG_LastName = '$MADG_LastName', 
                             MADG_Name = '$MADG_Name',
                             MADG_Birthday = '$MADG_Birthday',
                             MADG_Sex = '$MADG_Sex',
                             MADG_PhoneCode = '$MADG_PhoneCode',
                             MADG_HomePhone = '$MADG_HomePhone',
                             MADG_MobilePhone = '$MADG_MobilePhone',
                             MADG_Email = '$MADG_Email',
                             MADG_Country ='$Country',
                             MADG_Zip = '$Zip',
                             MADG_Address = '$Address',
                             MADG_Company = '$MADG_Company'
                          WHERE MADG_MAD_Num='$id'";
    $result = $Config_db->prepare($sqlUpdateGeneral);
    $result->execute();

    #更新群組
    //先刪除
    $Language_db->exec("DELETE FROM Admin_MemberGroupMapping WHERE AMGM_MAD_Num like '".$id."'"); //刪除群組對應資料表
    //重新建立
    $sqlGroupMapping = "INSERT INTO Admin_MemberGroupMapping (AMGM_AMG_ID, AMGM_MAD_Num) 
               VALUES ('".$memGroup."', '".$id."');";
    $rsGroupMapping = $Language_db->prepare($sqlGroupMapping);
    $rsGroupMapping->execute();

    $ar["remsg"] = "更新成功";
    //$ar["remsg"] = $sqlGroupMapping;           
    echo json_encode($ar);
  }//end if( $act == 'editG' )

  //企業會員編輯動作
  if( $act == 'editC' ) {
    foreach ($_POST as $postData => $value) {
      $$postData = $value; 
    }
    $sqlUpdateCompany = "UPDATE Member_AccountsDataCompany 
                         SET MADC_Name = '$MADC_Name',
                             MADC_PhoneCode = '$MADC_PhoneCode',
                             MADC_Phone = '$MADC_Phone',
                             MADC_Email = '$MADC_Email',
                             MADC_ContactName = '$MADC_ContactName',
                             MADC_ContactOffice = '$MADC_ContactOffice',
                             MADC_ContactMobilePhone = '$MADC_ContactMobilePhone',
                             MADC_ContactEmail = '$MADC_ContactEmail' 
                          WHERE MADC_MAD_Num='$id'";
    $result = $Config_db->prepare($sqlUpdateCompany);
    $result->execute();

    #更新群組
    //先刪除
    $Language_db->exec("DELETE FROM Admin_MemberGroupMapping WHERE AMGM_MAD_Num like '".$id."'"); //刪除群組對應資料表
    //重新建立
    $sqladd = "INSERT INTO Admin_MemberGroupMapping (AMGM_AMG_ID, AMGM_MAD_Num) 
               VALUES ('".$memGroup."', '".$id."');";
    $result = $Language_db->prepare($sqladd);
    $result->execute();

    $ar["remsg"] = "更新成功";
    echo json_encode($ar);
  }//end if( $act == 'editC' )

  //會員資料刪除
  if($act == 'del') {
    
    $id = $_POST['id']; //會員編號
    $count = 0;
    /* Delete all rows from the FRUIT table */
    $count += $Config_db->exec("DELETE FROM Member_AccountsData WHERE MAD_Num like '".$id."'"); //刪除帳號資料表
    $count += $Config_db->exec("DELETE FROM Member_AccountsAddress WHERE MAA_MAD_Num like '".$id."'"); //刪除收件資料
    $count += $Config_db->exec("DELETE FROM Member_AccountsDataCompany WHERE MADC_MAD_Num like '".$id."'"); //刪除公司會員資料
    $count += $Config_db->exec("DELETE FROM Member_AccountsDataGeneral WHERE MADG_MAD_Num like '".$id."'"); //刪除一般會員資料


    $ar["remsg"] = "刪除成功，影響 ".$count." 行數列";
    //$ar["remsg"] = $id;
    echo json_encode($ar);
  }//end if($act == 'del')
?>  