<?php
include_once('../../../include/config/config_inc.php');
include_once('../../../include/function/function.php');
 

header('Content-Type: application/json');

$price = $_POST['price']; //系統信箱欄位

$sqlUpPw = "UPDATE Admin_OrderInquiryQuota SET AOIQ_Price = '".$price."' WHERE AOIQ_ID = '1' ";
$result = $Language_db->prepare($sqlUpPw);
$result->execute();

$ar["remsg"] = "成功更新";
echo json_encode($ar);

?>