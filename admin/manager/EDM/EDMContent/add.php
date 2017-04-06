<script>
function checkSerialize() {
  for ( instance in CKEDITOR.instances ) {
    CKEDITOR.instances[instance].updateElement(); //將ckeditor重新更新
  }
return true; 
}

function checkPost() { //送出前檢查欄位
  var checkstatus = 1; //先預設有值
  $('#addFile_Alert').html(' '); //檔案判斷
  $('#title_Alert').html(' '); //標題判斷

  /*
  if(!$('#addFile').val()) {
    $('#addFile_Alert').html('<i class="fa fa-warning">！</i>'); //檔案判斷
    checkstatus=0;
  } else {
    var ext = $('#addFile').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
      $('#addFile_Alert').html('<i class="fa fa-warning">不符合檔案類型，請重新選擇!</i>'); //檔案類型判斷
      checkstatus=0;
    } 
  }
  */
  if(!$('#title').val()) {
    $('#title_Alert').html('<i class="fa fa-warning">請輸入標題！</i>');
    checkstatus=0;
  }
  /*
  if(!$('#content').val()) {
    $('#content_Alert').html('<i class="fa fa-warning">請輸入電子報內文！</i>');
    checkstatus=0;
  }
  */
  
  if(checkstatus==1) {
    $('#checkButton').hide(); //按扭隱藏
    $('#loadingImg').show(); //顯示loading
    return true;
  } else {
    return false;
  }
}  
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
          <a href="page_index.php?pageData=<?=$subDirectory?>" title="<?=$pageTitle;?>"><?=$pageTitle;?></a>
        </div>
        <div class="clearBoth"></div>
        <div id="pageIndexWarp" class="boxWarp">

          <div id="newsWarp" class="boxWarp">
            <h2 class="red">資料新增</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="formFileAdd" name="formFileAdd" action="manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/process.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="act" value="add">
                  <input type="hidden" id="pageURL" value="<?=$_GET['pageData'];?>">
                  <table>
                    <tr>
                      <td class="num titleTxt">信件標題</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="title" id="title" placeholder="請輸入電子報標題...">
                        <span id="title_Alert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">內容</td>
                      <td class="txtLeft" style="text-align:left;" id="ckeditor">
                        <textarea id="content" name="content" class="ckeditor" placeholder="請輸入電子報內文..."></textarea>
                        <span id="content_Alert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">上傳檔案</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="file" name="addFile" id="addFile"> 
                        <span id="addFile_Alert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">建立日期</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=date("Y-m-d H:i:s");?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">新增人員</td>
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
            <li><button type="button" id="returePage" class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>'">返回列表</button></li>
            <li>
              <!--<button class="red" onclick="upSubmit()">新增</button>-->
              <span id="loadingImg" style="display:none;"><img id="loadingImg" src="../images/ajax-loader.gif" stle="height:30px;">上傳中</span>
              <button class="red" id="checkButton" type="submit">新增</button>
            </li>
          </ul>
        </div>  
      </form>
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

