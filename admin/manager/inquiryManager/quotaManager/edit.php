<?php
$editSql = "select * from Admin_OrderInquiryQuota where AOIQ_ID = '1' ";
$editRs = $Language_db->query($editSql);
$editData = $editRs->fetch();
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
    data: $('#editForm').serialize(),
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
            此處資料用在前端詢價車的最低起價，設定為0則自動取消限額。
          </div>
          <div id="newsWarp" class="boxWarp">
            <h2 class="red">限額設定</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="editForm">
                  <input type="hidden" name="act" value="edit" >
                  <table>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">設定金額</td>
                      <td class="leftTxt">
                        <input type="text" name="price" placeholder="請輸入限制金額..." value="<?=$editData['AOIQ_Price'];?>">
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

