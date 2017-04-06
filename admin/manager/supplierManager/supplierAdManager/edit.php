<?php
$id = $_GET['id']; //商品id
#供應商商品資料
$sqlAD = "SELECT * FROM Supplier_IndexIconManager WHERE SIIM_ID = '".$id."'";
$rsAD = $Config_db->query($sqlAD);
$dataAD = $rsAD->fetch();

//呼叫供應商資料
$arraySAD = fiveSadAccountSearch($Config_db,$dataAD['SIIM_SAD_ID']);
?>
<script>
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
            <h2 class="red">廣告內容資料</h2>
            <div class="tableWarp">
              <div id="formTable">
                <table>
                  <tr>
                    <td class="num titleTxt" style="width:150px;">
                      圖
                    </td>
                    <td style="text-align:left;">
                       <img src='../images/supplier/<?= $arraySAD[1]; ?>/adImage/<?=$dataAD['SIIM_Img'];?>' style="max-width:100%;">
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">連結</td>
                    <td style="text-align:left;">
                      <a href='<?= $dataAD['SIIM_Url']; ?>' target="_blank" >
                        <?=$dataAD['SIIM_Url'];?>
                      </a>
                    </td>
                  </tr> 
                  <tr>
                    <td class="num titleTxt">供應商</td>
                    <td style="text-align:left;"><?=$arraySAD[0];?></td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">檔案資訊</td>
                    <td style="text-align:left;">
                      <?php
                      $imagesData = getimagesize("../images/supplier/".$arraySAD[1]."/adImage/".$dataAD['SIIM_Img']."");
                      echo "寬：".$imagesData[0]."<br>";
                      echo "高：".$imagesData[1]."<br>";
                      echo "檔案格式：".$imagesData['mime']."<br>";
                      ?>
                    </td>
                  </tr>
                  
                  <tr>
                    <td class="num titleTxt">廣告狀態</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?php
                      #判斷管理者是否有下架
                        if($dataAD['SIIM_CheckStatus']=='N') {
                          echo "<text style='color:red'>管理者下架</text>";
                        } else {
                          #管理者沒下架，則判斷供應商是否有下架
                          if($dataAD['SIIM_CheckStatus']=='Y') {
                            echo "<text style='color:blue'>上架中</text>";
                          } else {
                            echo "<text style='color:red'>供應商自設下架</text>";
                          }
                        }
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">商品上傳日期</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?=$dataAD['SIIM_UploadDate'];?>
                    </td>
                  </tr>
                  
                  
                </table>
              </div><!--<div id="formTable">-->  
            </div>
          </div>

          <div id="newsWarp" class="boxWarp">
            <h2 class="red">上架、下架送出資訊</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="formEdit" name="formEdit">
                  <input type="hidden" name="act" value="edit">
                  <input type="hidden" name="id" value="<?=$id;?>">
                  <table>
                    <tr>
                      <td class="num titleTxt" style="width:150px;">商品狀態</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="radio" name="proStatus" value="Y" <? if($dataAD['SIIM_CheckStatus']=='Y') { echo "checked"; }?>>
                        <label>上架</label>
                        <input type="radio" name="proStatus" value="N" <? if($dataAD['SIIM_CheckStatus']=='N') { echo "checked"; }?>>
                        <label>下架</label>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">上、下架原因</td>
                      <td class="txtLeft" style="text-align:left;">
                        <textarea name="remark" placeholder="請輸入原因..."><?=$dataAD['SIIM_Reason'];?></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">最後更新管理者</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?php
                        if($dataAD['SIIM_AM_ID']) {
                          echo amAccountSearch($Language_db,$dataAD['SIIM_AM_ID']);
                        } else {
                          echo "無紀錄";
                        }
                        ?>
                      </td>
                    </tr>
                  </table>
                </form>
              </div>
            </div>
          </div>

          <?php
          #如果有供應商請求，則列出以下內容
          if($dataAD['SIIM_SADClaim']=='Y') {
          ?>
          <div id="newsWarp" class="boxWarp">
          <h2 class="red">供應商請求上線內容</h2>
          <div class="tableWarp">
            <div id="formTable">
                <table>
                  <tr>
                    <td class="num titleTxt" style="width:120px;">上架請求說明</td>
                    <td class="txtLeft" style="text-align:left;">
                        <?=$dataAD['SIIM_SADClaimReason'];?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt" style="width:120px;">請求時間</td>
                    <td class="txtLeft" style="text-align:left;">
                        <?=$dataAD['SIIM_SADClaimTime'];?>
                    </td>
                  </tr>
                </table>
            </div>
          </div>
        </div>
        <?php
        } //if($dataPro['SPD_SADClaim']=='Y') {
        ?>

        <div class="pageBtnWarp">
          <ul>
            <li>
              <button class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>'">返回列表</button>
            </li>
            <li><button class="red" onclick="ajaxPro()">儲存</button></li>
          </ul>
        </div>  
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

