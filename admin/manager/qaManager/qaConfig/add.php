<script>
function upSubmit(){
  CKEDITOR.instances.content.updateElement(); // Update the textarea
  var checkstatus = 1; //先預設有值
  //先清除alert狀態
  $('#titleAlert').html(' ');
  $('#contentAlert').html(' ');

  if(!$('#title').val()) {
    $('#titleAlert').html('<i class="fa fa-warning"> 請輸入問題！</i>');
    checkstatus=0;
  }
  if(!$('#content').val()) {
    $('#contentAlert').html('<i class="fa fa-warning"> 請輸入答案！</i>');
    checkstatus=0;
  }

  if(checkstatus==1) {
    ajaxPro(); //執行ajax
  }
} //function upSubmit(){

function ajaxPro() {
  
  //var URLs  = "manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/index.php?secondURL=process";
  var URLs  = "manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/process.php";
  $.ajax({
    url: URLs,
    data: $('#formAdd').serialize(),
    type:"POST",
    async:false, //有回傳值才會執行以下的js
    dataType:'json',
      
    success: function(msg){ //成功執行完畢
      swal({
        title:msg.remsg,
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
    },
    complete:function(){ //執行完畢,不論成功或失敗
    },
    */
    error:function(xhr, ajaxOptions, thrownError){ //丟出錯誤
      alert(xhr.status);
      alert(thrownError);
      //alert('更新失敗!');
    }
  });
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
                <form id="formAdd" name="formAdd">
                  <input type="hidden" name="act" value="add">
                  <table>
                    <tr>
                      <td class="num titleTxt" style="width:150px;">分類類別</td>
                      <td class="txtLeft" style="text-align:left;">
                        <select name="mainClass" id="mainClass">
                          <?php
                          $mainSql = "select * from Admin_QAMainClass ORDER BY AQAMC_ID DESC";
                          $mainRs = $Config_db->query($mainSql);
                          while($mainData = $mainRs->fetch()) {
                          ?>
                          <option value="<?=$mainData['AQAMC_ID'];?>"><?=$mainData['AQAMC_Name'];?></option>
                          <?php
                          } //while($mainData = $mainRs->fetch()) {
                          ?>
                        </select>
                        <span id="classAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">問題</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="title" id="title" placeholder="請輸入問題..."> 
                        <span id="titleAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">答案</td>
                      <td class="txtLeft" style="text-align:left;" id="ckeditor">
                        <textarea name="content" id="content" placeholder="請輸入答案..." class="ckeditor"></textarea>
                        <span id="contentAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">新增人員</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$_SESSION['AM_Account'];?>
                      </td>
                    </tr>
                  </table>
                </form>
              </div><!--<div id="formTable">-->  
            </div>
          </div>
        <div class="pageBtnWarp">
          <ul>
            <li><button class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>'">返回列表</button></li>
            <li>
              <button class="red" onclick="upSubmit()">新增</button>
            </li>
          </ul>
        </div>  
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

