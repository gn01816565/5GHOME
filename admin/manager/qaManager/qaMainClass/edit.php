<?php
$id = $_GET['id']; //編輯id

$editSql = "select * from Admin_QAMainClass where AQAMC_ID = '".$id."'";
$editRs = $Config_db->query($editSql);
$editData = $editRs->fetch();
?>
<script>
function upSubmit(){
  var checkstatus = 1; //先預設有值
  //先清除alert狀態
  $('#titleAlert').html(' ');

  if(!$('#title').val()) {
    $('#titleAlert').html('<i class="fa fa-warning"> 請輸入主類別名稱！</i>');
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
    data: $('#formEdit').serialize(),
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
            <h2 class="red">資料編輯</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="formEdit" name="formEdit">
                  <input type="hidden" name="act" value="edit">
                  <input type="hidden" name="id" id="id" value="<?=$id;?>">
                  <table>
                    <tr>
                      <td class="num titleTxt">類別名稱</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="title" id="title" placeholder="請輸入類別名稱" value="<?=$editData['AQAMC_Name'];?>">  
                        <span id="titleAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">備註</td>
                      <td class="txtLeft" style="text-align:left;">
                        <textarea name="remark" id="remark" placeholder="請輸入備註"><?=$editData['AQAMC_Remark'];?></textarea>
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
              <button class="red" onclick="upSubmit()">儲存</button>
            </li>
          </ul>
        </div>  
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

