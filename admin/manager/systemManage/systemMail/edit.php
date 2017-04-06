<?php
$mailSql = "select * from Admin_SystemMail where ASM_ID = '1' ";
$mailRs = $Config_db->query($mailSql);
$mailData = $mailRs->fetch();
?>
<script>
function upSubmit(){
  ajaxPro();
} //function upSubmit(){

function ajaxPro() {
  //var URLs  = "manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/index.php?secondURL=process";
  var URLs  = "manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/process.php";
  $.ajax({
    url: URLs,
    data: $('#adConfigEdit').serialize(),
    type:"POST",
    async:false, //有回傳值才會執行以下的js
    dataType:'json',
      
    success: function(msg){ //成功執行完畢
      swal(msg.remsg);
    },
    /*
    beforeSend:function(){ //執行中
    $('#submit_ca').css('display','none');
    $('#loadingIMG').css('display','block');
    //$('#loadingIMG').fadeIn(); //執行時loading
    },
    */
      
    complete:function(){ //執行完畢,不論成功或失敗
      //$('#loadingIMG').fadeOut();  //執行完畢將圖隱藏
      //location.href='manager/system/adminConfig/index.php?secondURL=process';
    },
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
         <div id="toolsBar" class="boxWarp" style="background-color: #BDE5F8;color: #00529B;">
          <i class="fa fa-info-circle"></i>
          輸入系統信箱時，若要輸入第二筆以上的email，請用逗點符號分隔『 , 』。<BR>此處輸入的信箱位置，會以BCC(密件副本)方式收到系統相關信件進行備份留存。
         </div>
          <div id="newsWarp" class="boxWarp">
            <h2 class="red">系統信箱編輯</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="adConfigEdit" name="adConfigEdit">
                  <input type="hidden" name="act" value="edit" >
                  <table>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">系統信箱</td>
                      <td class="leftTxt">
                        <input type="text" name="systemMail" placeholder="請輸入系統信箱..." value="<?=$mailData['ASM_Email'];?>">
                      </td>
                    </tr>
                  </table>
                </form>
              </div><!--<div id="formTable">-->  

            </div>
          </div>
        <div class="pageBtnWarp">
          <ul>
            <li>
              <button class="red" onclick="upSubmit()">更新</button>
            </li>
          </ul>
        </div>  
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

