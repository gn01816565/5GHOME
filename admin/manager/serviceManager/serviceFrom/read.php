<?php
$id = $_GET['id']; //編輯id

$readSql = "select * from Admin_CustomerServiceForm where ACSF_ID = '".$id."'";
$readRs = $Language_db->query($readSql);
$readData = $readRs->fetch();
?>
<script>
function upSubmit(){
    ajaxPro(); //執行ajax
} //function upSubmit(){

function ajaxPro() {
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
            <h2 class="red">資料查閱</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="formEdit" name="formEdit">
                  <input type="hidden" name="act" value="read">
                  <input type="hidden" name="id" value="<?=$id;?>">
                  <table>
                    <tr>
                      <td class="num titleTxt">姓名</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$readData['ACSF_Name'];?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">聯絡電話</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$readData['ACSF_Phone'];?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">email</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$readData['ACSF_Email'];?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">地址</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?php
                        echo $readData['ACSF_Address'];
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">問題種類</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?php
                        echo serviceType($readData['ACSF_Type']);
                        ?>
                      </td>
                    </tr>
                    <?php
                    if($readData['ACSF_OrderNum']) { //有訂單編號，表示從會員後台過來
                    ?>
                    <tr>
                      <td class="num titleTxt">訂單編號</td>
                      <td class="txtLeft" style='text-align:left;'>
                        <a href='page_index.php?pageData=supplierOrder&secondURL=edit&id=<?=$readData['ACSF_OrderNum'];?>' target="_blank">
                          <?=$readData['ACSF_OrderNum'];?>
                        </a>
                      </td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr>
                      <td class="num titleTxt">詢問內容</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=nl2br($readData['ACSF_Content']);?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">處理狀況</td>
                      <td class="txtLeft" style="text-align:left;">
                        <select name="status">
                          <option value="N" <? if($readData['ACSF_Status']=='N') { echo "selected"; }  ?>>未處理</option>
                          <option value="Y" <? if($readData['ACSF_Status']=='Y') { echo "selected"; }  ?>>已處理</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">上傳檔案</td>
                      <td class="txtLeft" style="text-align:left;">
                        <a href='../tc/download.php?f=images/serviceForm/<?=$readData['ACSF_File1']?>'>
                          連結
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">更新人員</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=amAccountSearch($Language_db,$readData['ACSF_AM_ID']);?>
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
             <li><button class="red" onclick="upSubmit()">更新</button></li>
          </ul>
        </div>  
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

