<?php
include_once('../../../include/config/config_inc.php');
include_once('../../../include/function/function.php');
 

header('Content-Type: application/json');

$systemMail = $_POST['systemMail']; //系統信箱欄位

$sqlUpPw = "UPDATE Admin_SystemMail SET ASM_Email = '".$systemMail."' WHERE ASM_ID = '1' ";
$result = $Config_db->prepare($sqlUpPw);
$result->execute();

$ar["remsg"] = "成功更新";
echo json_encode($ar);

?>