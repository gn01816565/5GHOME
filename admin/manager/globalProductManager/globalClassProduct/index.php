<?php
$secondURL = isset($_GET['secondURL'])?$_GET['secondURL']:""; //用在第二個轉頁判斷，如主功能底下的新增、刪除、修改頁面 

#抓出次類別代號
$mcRs = $Config_db->query("select AMC_ID,AMC_TwName,AMC_MainClass,AMC_getURL from Admin_ManagerCompetence where AMC_getURL = '".$_GET['pageData']."' ");
$mcData = $mcRs->fetch();
$mainClassid  = $mcData['AMC_MainClass']; //主類別的AMC_ID

#抓出主類別名稱
$mcMRs = $Config_db->query("select AMC_ID,AMC_TwName,AMC_Level,AMC_getURL from Admin_ManagerCompetence where AMC_ID = '".$mainClassid."' AND AMC_Level = '1' "); //層級為1的主類別
$mcMData = $mcMRs->fetch();

$pageMainTitle = $mcMData['AMC_TwName']; //抓出功能的主類別
$pageTitle =$mcData['AMC_TwName']; //頁面標題

$mainDirectory = $mcMData['AMC_getURL'];//抓取資料夾第一層目錄(主類別資料夾代號)
$subDirectory = $mcData['AMC_getURL'];//抓取資料夾第二層目錄(子類別資料夾代號)
/*
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
*/
switch($secondURL) {
  case 'mainProcess' ; //主類別處理程式
    include('mainProcess.php'); 
    break;
  case 'mainAdd' ; //主類別新增頁面
    include('mainAdd.php'); 
    break;
  case 'mainEdit' ; //主類別編輯頁面
    include('mainEdit.php'); 
    break;
  case 'subProcess' ; //子類別處理程式
    include('subProcess.php'); 
    break;
  case 'subAdd' ; //子類別新增頁面
    include('subAdd.php'); 
    break;
  case 'subEdit' ; //子類別編輯頁面
    include('subEdit.php'); 
    break; 
  case 'subList' ; //子類別列表頁面
    include('subList.php'); 
    break;        
  default:
    include('mainList.php');
    break;
}  
?>