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
<?php
  include_once('./include/config/config_inc.php');
  include_once('./include/function/function.php');
  #抓取認證修改密碼的編碼
  $num = $_GET['d']; 

  $SQLsearch = "SELECT * 
                FROM Admin_Manager 
                WHERE AM_forgetPWDNum LIKE '$num'";
  //$DATAsearch = $dbc -> query('fskt_Config',$SQLsearch);
  $result = $Language_db->query($SQLsearch);
  $dataSearch = $result->fetch();

  #比對時間，判段是否超過2個小時
  date_default_timezone_set('Asia/Taipei');
  $time = date("Y-m-d H:i:s"); //當前時間
  $resetTime = $dataSearch['AM_forgetPWDTime']; //申請時間

  if(count($dataSearch) < 1 || ((strtotime($time)-strtotime($resetTime))/60)>=120) { //假設沒找到資料，表示密碼已修改過，跳回首頁
    echo "<script>alert('此修改連結已失效，請重新申請忘記密碼流程，或是用新密碼登入')</script>";
    //echo "<script>location.href='./index.php'</script>";
  }
?>
<script>
//密碼判斷英、數字
function checkPwd(passwd){
  var myArray = new Array(2); //回傳陣列
  re = /^([a-zA-Z]+\d+|\d+[a-zA-Z]+)[a-zA-Z0-9]*$/;  
  var status = 1; //判斷狀態 
  //var regExp = /^[\d|a-zA-Z]+$/;
  if (!re.test(passwd)) {  
    myArray[0] = 0;
    myArray[1] = '請輸入包含英文、數字的密碼';
    status = 0;
  } else if(passwd.length < 8 || passwd.length > 20) { //判斷長度
    myArray[0] = 0;
    myArray[1] = '請輸入密碼至少8 ～ 20的長度';
    status = 0;
  }

  if(status == 0) {
    return myArray;
  } else {
    myArray[0] = 1;
    myArray[1] = 'ok';
    return myArray;
  }
}

//檢查密碼
//輸入欄位、顯示警示DIV的id
function checkInputPwd(pwd, warningDiv) {
  var reString = checkPwd($('#'+pwd).val());  
  if(reString[0]==0) { //錯誤
    $('#'+warningDiv).html('<i class="fa fa-warning" style="color:red;"> '+reString[1]+'</i>');
  } else {
    $('#'+warningDiv).html('<i class="fa fa-check" style="color:green">格式正確！</i>');
  }
} //function checkInputPwd(pwd) {

//再次檢查密碼
function checkInputRePwd(pwd1, pwd2, warningDiv) {
  if($('#'+pwd1).val() != $('#'+pwd2).val()) {
    $('#'+warningDiv).html('<i class="fa fa-warning" style="color:red;"> 密碼不相同，請確認密碼輸入正確！</i>');
  } else if(!$('#'+pwd2).val()) {
    $('#'+warningDiv).html('<i class="fa fa-warning" style="color:red;"> 請再次輸入密碼！</i>');
  } else {
    $('#'+warningDiv).html('<i class="fa fa-check" style="color:green">格式正確！</i>');
  }
} //function checkInputPwd(pwd) {


function upSubmit(){  
  var checkstatus = 1; //先預設有值
  var warnString = "";
  $('#pwAlert').html(' '); //狀態消除
  $('#checkPwAlert').html(' '); //狀態消除

  if(!$('#pw').val()) {
    $('#pwAlert').html('<i class="fa fa-warning" style="color:red;"> 請輸入修改密碼！</i>');
    checkstatus=0;
  } else {
    var reString = checkPwd($('#pw').val()); //判斷密碼狀態
    if(reString[0] == 0) { //錯誤
      $('#pwAlert').html('<i class="fa fa-warning" style="color:red;">'+reString[1]+'</i>');
      warnString += reString[1]+'!\n';
      status = 0;
    } 
  }

  if(!$('#checkPw').val()) {
    $('#checkPwAlert').html('<i class="fa fa-warning" style="color:red;"> 請再次輸入密碼！</i>');
    checkstatus=0;
  } else {
    if($('#pw').val() != $('#checkPw').val()) {
      $('#checkPwAlert').html('<i class="fa fa-warning" style="color:red;"> 密碼不相同，請確認密碼輸入正確！</i>');
      checkstatus=0;
    }
  }

  if(checkstatus==1) {
    ajaxPro(); //執行ajax
  }
} //function upSubmit(){

function ajaxPro() {

  var URLs ="./pwResetPro.php";
  $.ajax({
    url: URLs,
    data: {pw:$('#pw').val(),checkPw:$('#checkPw').val(),num:$('#num').val()},
    type:"POST",
    async:false, //有回傳值才會執行以下的js
    dataType:'json',
    
    success: function(msg){ //成功執行完畢
      //alert(msg.remsg);
      window.location.href='./pwReset_ok.php';
     },

    error:function(xhr, ajaxOptions, thrownError){ //丟出錯誤
      alert(xhr.responseText);
      alert(xhr.status);
      alert(thrownError);
    }
  });
} //function ajaxPro() {
</script>
  <body>
    <div id="loginMainWarp">
      <div id="topLineWarp" class="red">
        <div class="btnWarp">
          <ul>
            <li><a href='./forget_pw.php' class="green" title="忘記密碼">忘記密碼</a></li>
            <li><a href="../tc" class="red" title="連結官網">連結官網</a></li>
          </ul>
        </div>
      </div>
      <header id="loginWarp">
        <form id="resetForm">
          <div class="logo"><img src ="../images/logo.svg" alt="logo"></div>
          <div class="txt">重設密碼</div>
          <input type="hidden" name="num" id="num" value="<?= $num; ?>">
          <div class="formWarp">
            <div class="formBox">
              <div class="title red">輸入密碼</div>
              <div class="form">
                <input type="password" name="pw" id="pw" placeholder="請輸入您的密碼..." onblur="checkInputPwd(this.id, 'pwAlert');">
              </div>
              <span id="pwAlert"></span>
            </div>
            <div class="formBox">
              <div class="title red">再次輸入密碼</div>
              <div class="form">
                <input type="password" name="checkPw" id="checkPw" placeholder="請再次輸入您的密碼..." onblur="checkInputRePwd('pw', this.id, 'checkPwAlert');">
              </div>
              <span id="checkPwAlert"></span>
            </div>
            <div class="formBox">
              <button class="yellow" style='width:100%;height:40px;' type="reset">重新填寫</button> <br><br>
              <button class="red" type="button" style='width:100%;height:40px;' onclick="upSubmit();">確定送出</button>
            </div>
          </div>
        </form>
      </header>
      <footer id="footerWarp" class="login">
        <h2>Copyright © 2015 FIVE STARS. All Rights Reserved.</h2>
      </footer>
    </div>
  </body>
</html>