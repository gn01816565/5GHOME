<!DOCTYPE html>
<html>
  <head>
    <?php
      include ('head.php');
    ?>
  </head>
  <body>
    <div id="loginMainWarp">
      <div id="topLineWarp" class="red">
        <div class="btnWarp">
          <ul>
            <li><a href='forget_pw.php' class="green" title="忘記密碼">忘記密碼</a></li>
            <li><a href="../index.php" class="red" title="連結官網">連結官網</a></li>
          </ul>
        </div>
      </div>
      <form id="sentCheck" method="post" action="check.php">
      <header id="loginWarp">
        <div class="logo">
          <!--
          <img src ="../images/logo.svg" alt="logo">
          -->
        </div>
        <div class="txt">後台管理系統</div>
        <div class="formWarp">
          <div class="formBox">
            <div class="title red">USER</div>
            <div class="form">
              <input type="text" name="Account" id="Account" placeholder="請輸入您的帳號...">
            </div>
          </div>
          <div class="formBox">
            <div class="title red">PASSWORD</div>
            <div class="form">
              <input type="password" name="Passwords" id="Passwords" placeholder="請輸入您的密碼...">
            </div>
          </div>
          <div class="formBox">
            <input type="submit" class="loginBtn yellow" value="LOGIN">
          </div>
        </div>
      </header>
    </form>
    <!--
      <footer id="footerWarp" class="login">
        <h2>Copyright © 2015 FIVE STARS. All Rights Reserved.</h2>
      </footer>
    -->
    </div>
  </body>
</html>