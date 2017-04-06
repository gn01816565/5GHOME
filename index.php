<!--A Design by W3layouts 
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
  <title>5GHOME購物平台</title>
  <!--
  <script src="js/jquery.min.js"></script>
  -->
  <!--//theme style-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="5ghome" />
  <?php
  //匯入css,js檔案
  include("include_head.php");
  ?>
</head>
<body>
<?php
//top的menu
include("include_topMenu.php");

//banner
include("include_banner.php");

//search
include("include_search.php");

$pageData = @$_GET['pageData']; //抓代表編碼

switch($pageData) {
  case 'product': //產品列表頁
    include('product.php');
    break;
  case 'product_content': //產品內頁
    include('product_content.php');
    break;
  case 'epaper': //電子報頁面
    include('epaper.php');
    break;
  case 'ask': //商品詢問
    include('ask.php');
    break;      
  case 'login': //會員登入頁面
    include('login.php');  
    break;

  case 'news_list': //最新消息列表
    include('news_list.php');  
    break;
  case 'news_content': //最新消息內頁
    include('news_content.php');  
    break;
  case 'faq_list': //問與答列表
    include('faq_list.php');  
    break;
  case 'faq_content': //問與答內頁
    include('faq_content.php');  
    break;
  case 'link_list': //免費連結區列表
    include('link_list.php');  
    break;
  case 'link_content': //免費連結區內頁
    include('link_content.php');  
    break;
  case 'cooperation': //廠商合作表單
    include('cooperation.php');  
    break;
  case 'servicecat': //服務據點
    include('servicecat.php');  
    break;
  case 'member_clause': //會員條款
    include('member_clause.php');  
    break;

  case 'order_help': //訂購說明
    include('order_help.php');  
    break;
  case 'privacy_term': //隱私權政策
    include('privacy_term.php');  
    break;
  case 'shipping_returns': //退換貨須知
    include('shipping_returns.php');  
    break;
  case 'about': //公司簡介
    include('about.php');  
    break;
  case 'authenticate': //公司認證
    include('authenticate.php');  
    break;

   //會員中心 - 登入首頁
  case 'member_info':
    include('view/member/info.php');  
    break;
  //紅利積點詳細使用說明  
  case 'member_redeem_rule': 
    include('view/member/redeem_rule.php');  
    break;
  //紅利積點使用說明  
  case 'member_redeem': 
    include('view/member/redeem.php');  
    break;
  //紅利稅換紀錄      
  case 'member_myredeem_record':
    include('view/member/myredeem_record.php');  
    break;
  //紅利查詢
  case 'member_myredeem':
    include('view/member/myredeem.php');  
    break;  
  //登入頁      
  case 'member_login':
    include('view/member/login.php');  
    break;  
  //忘記密碼      
  case 'member_forget':
    include('view/member/forget.php');  
    break;
  //加入會員條款說明  
  case 'member_join_remarks':
    include('view/member/join_remarks.php');  
    break;
  //個人會員加入頁  
  case 'member_register_personal':
    include('view/member/register_personal.php');  
    break;     
  //企業會員加入頁  
  case 'member_register_company':
    include('view/member/register_company.php');  
    break;
  //會員資料修改  
  case 'member_account_modify':
    include('view/member/account_modify.php');  
    break;      
  //密碼修改  
  case 'member_pw_modify':
    include('view/member/pw_modify.php');  
    break;
  //訂單詢問  
  case 'member_order_qa':
    include('view/member/order_qa.php');  
    break; 
  //訂單列表  
  case 'member_order_list':
    include('view/member/order_list.php');  
    break;
  //訂單內容 
  case 'member_order_content':
    include('view/member/order_content.php');  
    break;        
  //填寫維修單
  case 'member_repairstep_add':
    include('view/member/repairstep_add.php');  
    break;
  //維修查詢
  case 'member_repairstep_search':
    include('view/member/repairstep_search.php');  
    break; 
  //填寫退換貨
  case 'member_repair_add':
    include('view/member/repair_search.php');  
    break;  
  //退換貨查詢
  case 'member_repair_search':
    include('view/member/repair_search.php');  
    break;
  //問答紀錄
  case 'member_qa':
    include('view/member/qa.php');  
    break;    

  default: //首頁 
    include('index_info.php');
    break;  
}

//Footer
include("include_footer.php");
?>
<!---->
</body>
</html>
