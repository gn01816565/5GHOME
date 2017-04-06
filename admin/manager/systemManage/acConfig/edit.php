
<script>
function upSubmit(){
  var checkstatus = 1; //先預設有值
  //先清除alert狀態
  $('#pwAlert').html(' ');
  $('#cpwAlert').html(' ');

  if(!$('#newPassword').val()) {
    $('#pwAlert').html('<i class="fa fa-warning"> 請輸入密碼！</i>');
    checkstatus=0;
  }
  if(!$('#newAgainPassword').val()) {
    $('#cpwAlert').html('<i class="fa fa-warning"> 請再次輸入密碼！</i>');
    checkstatus=0;
  }
  if($('#newPassword').val() != $('#newAgainPassword').val()) {
    $('#cpwAlert').html('<i class="fa fa-warning"> 密碼不相同，請確認密碼輸入正確！</i>');
    checkstatus=0;
  }
  if(checkstatus==1) {
    ajaxPro(); //執行ajax
  }
}
function ajaxPro() {
  var URLs="page_index.php?pageData=acConfig&secondURL=process";
  $.ajax({
    url: URLs,
    data: $('#pwEdit').serialize(),
    type:"POST",
    async:false, //有回傳值才會執行以下的js
    dataType:'text',
    
    success: function(msg){ //成功執行完畢
      swal("成功修改密碼");
     },
    /*
    beforeSend:function(){ //執行中
      $('#submit_ca').css('display','none');
      $('#loadingIMG').css('display','block');
      //$('#loadingIMG').fadeIn(); //執行時loading
    },
    
    complete:function(){ //執行完畢,不論成功或失敗
      //$('#loadingIMG').fadeOut();  //執行完畢將圖隱藏
      location.href='page_index.php?pageData=acConfig';
    },
    */
    error:function(xhr, ajaxOptions, thrownError){ //丟出錯誤
      alert(xhr.status);
      alert(thrownError);
      //console.log(xhr.responseText);
      //alert('更新失敗!');
    }

  });
}
</script>
<div id="pageMainWarp">
  <div id="pageWarp">
    <div id="pageWarpTR">
      <?php
      include('aside.php');
      ?>
      <section id="rightWarp">
        <div id="placeWarp" class="boxWarp">
          <div class="title red_T">目前位置：</div>
          <span><?=$pageMainTitle;?></span>
          <span>></span>
          <span><?=$pageTitle;?></span>
        </div>
        <div class="clearBoth"></div>
        
        <div id="pageIndexWarp" class="boxWarp">
         
          <div id="newsWarp" class="boxWarp">
            <h2 class="red">設定密碼</h2>
            <div class="tableWarp">
              <div id="formTable">
              <!--內文 -->
              <form id="pwEdit" name="pwEdit">
                <table id="pwUpdate">
                  <tr>
                    <td class="num titleTxt" style="width:200px;">
                      帳號
                    </td>
                    <td class="txtLeft" style="text-align:left;">
                      <h3><?=$_SESSION['AM_Account'];?></h3>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">
                      新密碼
                    </td>
                    <td class="txtLeft" style="text-align:left;">
                      <input type="password" name="newPassword" id="newPassword" placeholder="請輸入您的新密碼...">
                      <span id="pwAlert"></span>
                    </td>
                  </tr>
                  <tr>
                    <td class="num  titleTxt">
                      再一次輸入密碼
                    </td>
                    <td class="txtLeft" style="text-align:left;">
                      <input type="password" name="newAgainPassword" id="newAgainPassword" placeholder="請再次輸入您的新密碼..." >
                      <span id="cpwAlert"></span>
                    </td>
                  </tr>
                </table>
              </form>
            </div> <!--formTable-->  
          </div><!--form id="pwEdit" name="pwEdit">-->
        </div> <!--<div class="tableWarp">-->
        <div class="pageBtnWarp">
          <ul>
            <li><button class="red" onclick="upSubmit()">更新</button></li>
          </ul>
        </div>
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>