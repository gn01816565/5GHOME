<?php
session_start(); //讓session可執行

include_once('../../../include/config/config_inc.php');
include_once('../../../include/function/function.php');
 

$act = $_POST['act']; //執行動作判斷 

if($act == 'edit') { //編輯
  
  $toTime = date("Y-m-d"); //今日日期
  #將post過來的值宣告成變數
  foreach($_POST as $key=>$val) {
    $$key=$val;
  }

  $sqlSEL = "select * from Supplier_OrderTitle where SOT_OrderNum like '".$numID."' ";
  $rsSEL = $Language_db -> query($sqlSEL);
  $dataSEL = $rsSEL -> fetch();
  $time = date("Y-m-d H:i:s"); //更新時間
  $reText = "\n\n===".$time."===";//紀錄更新內容

  //訂單狀態比對，與資料庫中不同的話，則更新
  if($dataSEL['SOT_OrderStatus'] != $selectOrderStatus) { 
    $reText .= "\n訂單狀態：".orderStatus($dataSEL['SOT_OrderStatus']); 
    //訂單狀態改為refund(退款/退貨)、replacement(換貨)，則更新訂單申束結束時間
    if($selectOrderStatus == 'refund' || $selectOrderStatus == 'replacement') {
      $sqlMemApply = "UPDATE Supplier_OrderMemberReturns 
                      SET SOMR_EndDate = '".$toTime."' 
                      where SOMR_SOT_OrderNum like '".$numID."'
                     ";
      $rsMemApply = $Language_db -> query($sqlMemApply); 
    }
  } 

  //訂單付款狀態比對
  if($dataSEL['SOT_ProductStatus'] != $selectProductStatus) { 
    if($selectProductStatus == 'Y') { //改為已付款狀態
      $reText .= "\n訂單結帳狀態：未付款=>已付款"; 
    } else { //改為未付款
      $reText .= "\n訂單結帳狀態：已付款=>未付款"; 
    }
  }

  //運費付款狀態比對
  if($dataSEL['SOT_Freight'] != $selectFreight) { 
    if($selectFreight == 'Y') { //改為已付款狀態
      $reText .= "\n運費結帳狀態：未付款=>已付款"; 
    } else { //改為未付款
      $reText .= "\n運費結帳狀態：已付款=>未付款"; 
    }
  }

  
  #更新title資料庫
  $sqlUp = "UPDATE Supplier_OrderTitle SET 
            SOT_OrderStatus ='".$selectOrderStatus."', 
            SOT_ProductStatus = '".$selectProductStatus."', 
            SOT_Freight = '".$selectFreight."', 
            SOT_Remarks = '".$reText."\n".$remark."' 
            where SOT_OrderNum like '".$numID."' 
           ";
  $result = $Language_db->prepare($sqlUp);
  $result->execute();

  $ar["remsg"] = "更新成功";
  echo json_encode($ar);
} //if($act == 'edit') { //編輯

if($act == 'del') {
  
  $id = $_POST['id'];
  /* Delete all rows from the FRUIT table */
  $count = $Language_db->exec("DELETE FROM Supplier_OrderTitle WHERE SOT_OrderNum = '".$id."'"); //刪除title資料表
  $count = $Language_db->exec("DELETE FROM Supplier_OrderContent WHERE SOC_SOT_OrderNum = '".$id."'"); //刪除產品資料表
  $count = $Language_db->exec("DELETE FROM Supplier_OrderStatus WHERE SOS_SOT_OrderNum = '".$id."'"); //刪除運費資料表

  $ar["remsg"] = "刪除成功，影響 ".$count." 行數列";
  echo json_encode($ar);
}

?>  