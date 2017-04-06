<script>
//執行ajax form 前要先將更新以下程式
function checkSerialize() {
  return true; 
}
function checkPost() { //送出前檢查欄位
  var checkstatus = 1; //先預設有值
  $('#addFile_Alert').html(' '); //檔案判斷
  $('#imgUrl_Alert').html(' '); //連結判斷
  
  if(!$('#addFile').val()) {
    $('#addFile_Alert').html('<i class="fa fa-warning">請選擇上傳圖片！</i>'); //檔案判斷
    checkstatus=0;
  } else {
    var ext = $('#addFile').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
      $('#addFile_Alert').html('<i class="fa fa-warning">不符合檔案類型，請重新選擇!</i>'); //檔案類型判斷
      checkstatus=0;
    } 
   
  }
  if(!$('#imgUrl').val()) {
    $('#imgUrl_Alert').html('<i class="fa fa-warning">請輸入圖片連結！</i>');
    checkstatus=0;
  }
  
  if(checkstatus==1) {
    return true;
  } else {
    return false;
  }

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
          <a href="page_index.php?pageData=<?=$subDirectory?>" title="<?=$pageTitle;?>"><?=$pageTitle;?></a>
        </div>
        <div class="clearBoth"></div>
        <div id="pageIndexWarp" class="boxWarp">
          <div id="toolsBar" class="boxWarp" style="background-color: #BDE5F8;color: #00529B;">
            <i class="fa fa-info-circle"></i>建議上傳footer的圖，寬度1000px以上，高度不限
          </div>
          <div id="newsWarp" class="boxWarp">
            <h2 class="red">資料新增</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="formFileAdd" name="formFileAdd" action="manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/process.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="act" value="add">
                  <input type="hidden" id="pageURL" value="<?=$_GET['pageData'];?>">
                  <table>
                    <tr>
                      <td class="num titleTxt">上傳檔案</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="file" name="addFile" id="addFile"> 
                        <span id="addFile_Alert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">圖片連結</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="imgUrl" id="imgUrl" placeholder="請輸入您的廣告所連結路徑，如：www.fivestars.com/tw/fivestars/" >
                        <span id="imgUrl_Alert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">建立日期</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=date("Y-m-d H:i:s");?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">上傳人員</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$_SESSION['AM_Account'];?>
                      </td>
                    </tr>
                  </table>
                
              </div><!--<div id="formTable">-->  
            </div>
          </div>
        <div class="pageBtnWarp">
          <ul>
            <li><button type="button" class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>'">返回列表</button></li>
            <li>
              <!--<button class="red" onclick="upSubmit()">新增</button>-->
              <button class="red" type="submit">新增</button>
            </li>
          </ul>
        </div>  
      </form>
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

