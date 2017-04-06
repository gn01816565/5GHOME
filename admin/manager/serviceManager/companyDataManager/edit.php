<?php
$upSql = "select * from Admin_CompanyInformation where ACI_ID = '1' ";
$upRs = $Language_db->query($upSql);
$upData = $upRs->fetch();
?>
<script>
function upSubmit(){
    ajaxPro(); //執行ajax
} //function upSubmit(){

function ajaxPro() {
  CKEDITOR.instances.content.updateElement(); // Update the textarea
  //var URLs="page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=process";
  var URLs ="manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/process.php";
  $.ajax({
    url: URLs,
    data: $('#formEdit').serialize(),
    type:"POST",
    async:false, //有回傳值才會執行以下的js
    dataType:'json',
    
    success: function(msg){ //成功執行完畢
      //swal(msg.remsg);
      
      swal({
        title: msg.remsg,
        text: "",
        type: "success"
        },
        function() {
          window.location.href='page_index.php?pageData=<?=$subDirectory;?>';
        }
      );
      
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
      //alert('更新失敗!');
    }
  });
} //function ajaxPro() {
</script>

<script src="library/ckeditor/ckeditor.js"></script>
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
            <h2 class="red">編輯頁面</h2>
            <div class="tableWarp">
              <div id="formTable">
              <!--內文 -->
              <form id="formEdit" name="formEdit">
                <input type="hidden" name="act" value="edit">
                <table id="pwUpdate">
                  <tr>
                    <td class="num titleTxt" style="width:200px;">
                      公司資訊內容
                    </td>
                    <td class="txtLeft" style="text-align:left;height:300px;" id="ckeditor">
                      <h3>
                        <textarea name="content" id="content" placeholder="請輸入公司資訊內容..." style="height:300px;" class="ckeditor"><?=$upData['ACI_InformationContent'];?></textarea>
                      </h3>
                  </tr>
                  <tr>
                    <td class="num titleTxt" style="width:200px;">
                      最後更新人員
                    </td>
                    <td class="txtLeft" style="text-align:left;">
                      <h3>
                        <?php
                        echo amAccountSearch($Language_db,$upData['ACI_AM_ID']);
                        ?>
                    </h3>
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