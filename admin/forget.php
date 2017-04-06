<!DOCTYPE html>
<html>
  <head>
    <?php
      include ('head.php');
    ?>
  </head>
<!--Jquery-->
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="../jquery/sweetalert2.js"></script>
<script>
function upSubmit(){
  var checkstatus = 1; //先預設有值
  //先清除alert狀態
  //$('#titleAlert').html(' ');
  alert("123");
  /*
  if(!$('#title').val()) {
    $('#titleAlert').html('<i class="fa fa-warning"> 請輸入標題！</i>');
    checkstatus=0;
  }
  */
  /*
  if(checkstatus==1) {
    ajaxPro(); //執行ajax
  }
  */
} //function upSubmit(){

</script>
  <body>
    <div id="loginMainWarp">
      <div id="topLineWarp" class="red">
        <div class="btnWarp">
          <ul>
            <li><a href='forget.php' onclick="forget();" class="green" title="忘記密碼">忘記密碼</a></li>
            <li><a href="../tc" class="red" title="連結官網">連結官網</a></li>
          </ul>
        </div>
      </div>
      <form id="sentForget" name="sentForget">
      <input type="hidden" name="act" value="pro">
      <header id="loginWarp">
        <div class="logo"><img src ="../images/logo.svg" alt="logo"></div>
        <div class="txt">忘記密碼</div>
        <div class="formWarp">
          <div class="formBox">
            <!--
            <div id="errorMsgs" style="display:none;">帳號密碼有誤，請重新輸入</div>
            -->
            <div class="title red">電子信箱</div>
            <div class="form">
              <input type="text" name="email" id="email" placeholder="請輸入您的電子信箱...">
            </div>
          </div>
          <div class="formBox">
            <div class="title red">帳號</div>
            <div class="form">
              <input type="password" name="account" id="account" placeholder="請輸入您的帳號...">
            </div>
          </div>
          <div class="pageBtnWarp" style="background:#fff"><!--class="formBox"-->
            <!--原本預設
            <button class="loginBtn yellow" onclick="javascript:location.href='page_index.php?pageData=page_index_info'">LOGIN</button>
            -->
            <ul>
              <li>
                <button class="yellow" type="button" onclick="location.href='index.php'">回到登入畫面</button>
              </li>
              <li>
                <button class="red" onclick="upSubmit();">送出</button>
              </li>
            </ul>
            <!--改ajax需要
            <button class="loginBtn yellow" onclick="Submit()">LOGIN</button>
             -->
          </div>
        </div>
      </header>
    </form>
      <footer id="footerWarp" class="login">
        <h2>Copyright © 2015 FIVE STARS. All Rights Reserved.</h2>
      </footer>
    </div>
  </body>
</html>