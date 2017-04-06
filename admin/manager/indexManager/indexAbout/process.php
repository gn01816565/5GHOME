<?php
session_start();

include_once('../../../include/config/config_inc.php');
include_once('../../../include/function/function.php');
 

$content = $_POST['content']; //內文
$amID = $_SESSION['AM_ID'];  //管理者id

#sql資料修改
$sqlUp = "UPDATE Admin_IndexAboutManager SET AIAM_Content = '".$content."', AIAM_AM_ID = '".$amID."' WHERE AIAM_ID = '1' ";
$result = $Language_db->prepare($sqlUp);
$result->execute();

$ar["remsg"] = "更新成功";
echo json_encode($ar);
?>