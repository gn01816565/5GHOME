<?php
ob_start();
session_start();

#判斷是否已登入，若時間過長未登入則回到登入畫面
if(!$_SESSION['AM_login']) {
  echo "<script>";
  echo "location.href='index.php'";
  echo "</script>";
} //if(!$_SESSION['AM_login']) {
  
?>
<!DOCTYPE html>
<html>
  <head>
    <?php
      include ('head.php');
      include 'include/config/config_inc.php'; //資料庫資訊檔
      include 'include/function/function.php'; //function庫 
    ?>
  </head>
  <body>  
    <div id="pageTopBtn">
      <a href="javascript:void(0);" class="red" title="PAGE TOP">PAGE TOP</a>
    </div>
    <div id="topLineWarp" class="red">
      <div class="btnWarp">
        <ul>
          <li><a href="../tc" class="red" title="連結官網">連結官網</a></li>
          <li><a href="../tc_admin/login.php" class="yellow" title="連結供應商首頁">連結供應商首頁</a></li>
          <li><a href="logout.php" class="blue" title="管理者登出">管理者登出</a></li>
        </ul>
      </div>
      <div class="clearBoth"></div>
    </div>

      <?php

    
    #網頁預設路徑  
    if($_GET['pageData']=='page_index_info') {
      include('page_index_info.php');//程式預設頁面
    }
    if($_GET['pageData']=='page') {
      include('page.php');//程式預設頁面
    }

    #載入資料庫紀錄中的menu路徑
    
    $rsToPage = $Config_db->query("select * from Admin_ManagerCompetence ORDER BY AMC_ID ASC ");  
    while($dataToPage = $rsToPage->fetch()) {
      if($_GET['pageData']==$dataToPage['AMC_getURL']) { //PAGE, 依get代號叫出頁面代號
        if(file_exists('manager/'.$dataToPage['AMC_realURL'])==true) { //判斷檔案存不存在
          
          include('manager/'.$dataToPage['AMC_realURL']); //載入內頁檔案
        } else {//if(file_exists('manager/'.$dataToPage['AMC_realURL'])==true): //判斷檔案存不存在
          include('noFile.php'); //載入未完成功能說明頁
        }
      } //if($_GET['pageData']==$dataToPage['AMC_getURL']) { //PAGE
    } //while($dataToPage = $rsToPage->fetch()) {
      
    ?>


    <footer id="footerWarp">
      <h2>Copyright © 2015 FIVE STARS. All Rights Reserved.</h2>
    </foote>
    
    <!--
    <script type="text/javascript" src="../jquery/jquery.ajaxfileupload.js"></script>
  -->
  </body>
</html>
<!--Jquery-->
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<!--select 多重選取_start-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/plugins/localisation/jquery.localisation-min.js"></script>
<script type="text/javascript" src="js/plugins/scrollTo/jquery.scrollTo-min.js"></script>
<script type="text/javascript" src="js/ui.multiselect.js"></script>
<script type="text/javascript">
$("#newsWarp .tableWarp table tr td a").removeClass(); //移除原本的css
$(function(){
  $.localise('ui-multiselect', {language: 'de', path: 'js/locale/'});
  $(".multiselect").multiselect();
  //$('#switcher').themeswitcher();
});
</script> 
 <!--select 多重選取_end-->
<!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
-->
<!--sweetalert https://limonte.github.io/sweetalert2/-->
<!--<script src="../jquery/sweetalert.min.js"></script>-->
<script src="../jquery/sweetalert2.js"></script>
<!--Easing-->
<script src="../jquery/jquery.easing.1.3.js"></script>
<!--圖片裁切-->
<script src="../jquery/jquery.imgLiquid.js"></script>
<!--textarea高度伸長-->
<script src="../jquery/jquery.autosize.js"></script>
<!--Jquery全設定-->
<script src="js/jquery.admin.js"></script>    
<!--jquery form-->
<script src="../jquery/jquery.form.js"></script>
<!--台灣成市select，參考：http://app.essoduke.org/twzipcode/-->
<script src="../jquery/jquery.twzipcode.js"></script>
<script>
$(function () {
  $('#twzipcode').twzipcode({
    'css': ['county', 'district', 'zipcode'],
    'detect': true // 預設值為 false
  });
});
</script>