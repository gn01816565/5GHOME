<?php
$secondURL = isset($_GET['secondURL'])?$_GET['secondURL']:""; //用在第二個轉頁判斷，如主功能底下的新增、刪除、修改頁面 
//$mainDirectory = "orderManaer"; //資料夾第一層目錄
//$subDirectory = "supplierOrder"; //資料夾第二層目錄

#抓出主類別代號
$mcRs = $Config_db->query("select AMC_ID,AMC_TwName,AMC_MainClass,AMC_getURL from Admin_ManagerCompetence where AMC_getURL = '".$_GET['pageData']."' ");
$mcData = $mcRs->fetch();
$mainClassid  = $mcData['AMC_MainClass']; //主類別的AMC_ID

#抓出主類別名稱
$mcMRs = $Config_db->query("select AMC_ID,AMC_TwName,AMC_Level,AMC_getURL from Admin_ManagerCompetence where AMC_ID = '".$mainClassid."' AND AMC_Level = '1' "); //層級為1的主類別
$mcMData = $mcMRs->fetch();

$pageMainTitle = $mcMData['AMC_TwName']; //抓出功能的主類別名稱
$pageTitle =$mcData['AMC_TwName']; //頁面標題名稱
$mainDirectory = $mcMData['AMC_getURL'];//抓取資料夾第一層目錄(主類別資料夾代號)
$subDirectory = $mcData['AMC_getURL'];//抓取資料夾第二層目錄(子類別資料夾代號)
switch($secondURL) {
	case 'process' ; //代入執行判斷用檔案
	    include('process.php'); 
      break;
    case 'add' ; //代入執行判斷用檔案
	    include('add.php'); 
      break;
    case 'edit' ; //代入執行判斷用檔案
	    include('edit.php'); 
      break;   
    default:
      include('list.php');
      break;
	}
?>