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

switch($secondURL) {
	case 'pageClick' ; //各頁面點擊統計
	  include('pageClick.php'); 
    break;
  case 'pageClickProduct' ; //各商品點擊統計
	  include('pageClickProduct.php'); 
    break;
  case 'orderProduct' ; //銷售商品統計
    include('orderProduct.php'); 
    break;
  case 'inquiryProduct' ; //詢價商品統計
    include('inquiryProduct.php'); 
    break;  
  case 'SADorderRanking' ; //供應商銷售排名統計
    include('SADorderRanking.php'); 
    break;
  case 'searchKeyword' ; //搜尋關鍵字統計
    include('searchKeyword.php'); 
    break;     
  case 'bannerClick' ; //Banner
    include('bannerClick.php'); 
    break;
  case 'footerClick' ; //Footer
    include('footerClick.php'); 
    break; 
  case 'adClick' ; //AD廣告
    include('adClick.php'); 
    break;      
  default:
    include('pageClick.php');
    break;
	}
?>