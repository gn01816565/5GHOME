<!DOCTYPE html>
<html>
  <head>
    <?php
      include ('./head.php');
    ?>
  </head>
    <!--Jquery-->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <script>
  function upSubmit(){  

    var checkstatus = 1; //先預設有值
    
    $('#emailAlert').html(' '); //狀態消除

    if(!$('#email').val()) {
      $('#emailAlert').html('<i class="fa fa-warning" style="color:red;"> 請輸入電子信箱！</i>');
      checkstatus=0;
    } else { //如果有輸入資料
      if(checkAC()==0) { //檢查email是否有找到一致的
        $('#emailAlert').html('<i class="fa fa-warning" style="color:red;"> 此電子信箱無效，請重新輸入！</i>');
        checkstatus=0;
      }
    }
    if(checkstatus==1) {
      ajaxPro(); //執行ajax
    }
  } //function upSubmit(){

  function ajaxPro() {
    var URLs ="./forgetPro.php";
    $.ajax({
      url: URLs,
      //data: {$('#forgetForm').serialize()},
      data: {email:$('#email').val()},
      type:"POST",
      async:false, //有回傳值才會執行以下的js
      dataType:'json',
      
      success: function(msg){ //成功執行完畢
        window.location.href='./forget_pw_check.php';
        //swal(msg.remsg);
       },
    
      /*
      complete:function(){ //執行完畢,不論成功或失敗
        //$('#loadingIMG').fadeOut();  //執行完畢將圖隱藏
        location.href='page_index.php?pageData=acConfig';
      },
      */
      error:function(xhr, ajaxOptions, thrownError){ //丟出錯誤
        alert(xhr.responseText);
        //alert(xhr.status);
        //alert(thrownError);
        //alert('更新失敗!');
      }
    });
  } //function ajaxPro() {

  function checkAC() {
    var reStatus;
    var URLs ="./madAcPro.php";
    $.ajax({
      url: URLs,
      //data: {$('#forgetForm').serialize()},
      data: {email:$('#email').val()},
      type:"POST",
      async:false, //有回傳值才會執行以下的js
      dataType:'json',
      
      success: function(msg){ //成功執行完畢      
        if(msg.remsg==1) { //有帳號
          reStatus = 1; 
        } else { //無帳號
          reStatus = 0;
        }
       },
      error:function(xhr, ajaxOptions, thrownError){ //丟出錯誤
        alert(xhr.responseText);
        //alert(xhr.status);
        //alert(thrownError);
        //alert('更新失敗!');
      }
    });
    return reStatus;
  }
  </script>
  <body>
    <div id="loginMainWarp">
      <div id="topLineWarp" class="red">
        <div class="btnWarp">
          <ul>
            <li><a href='./index.php' class="green" title="管理者登入">管理者登入</a></li>
            <li><a href="../tc" class="red" title="連結官網">連結官網</a></li>
          </ul>
        </div>
      </div>
      <form id="sentCheck" method="post" action="forget_proc.php">
        <header id="loginWarp">
          <div class="logo"><img src ="../images/logo.svg" alt="logo"></div>
          <div class="txt">忘記密碼</div>
          <div class="formWarp">
            <div class="formBox">
              <div class="title red">FORGET PASSWORD</div>
              <div class="form">
                <input type="text" name="email" id="email" placeholder="請輸入您的信箱...">
              </div>
              <span id="emailAlert"></span>
            </div>
            <div class="formBox">
              <!--<input type="submit" class="loginBtn yellow" value="送出">-->
              <button type="button" class="yellow" onclick="upSubmit();" style='width:100%;height:40px;'>送出</button>
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