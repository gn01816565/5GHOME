<?php
$id = $_GET['id']; //商品id
#供應商商品資料
$sqlProDetail = "SELECT * FROM Supplier_ProductDetail WHERE SPD_ID = '".$id."'";
$rsProDetail = $Language_db->query($sqlProDetail);
$dataProDetail = $rsProDetail->fetch();
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
<style>
.txtLeft img {
  width:100%;
}
</style>
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
            <h2 class="red">商品內容資料</h2>
            <div class="tableWarp">
              <div id="formTable">
                <table>
                  <tr>
                    <td class="num titleTxt" style="width:120px;">商品類別</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?php
                      #抓出全域主類別、次類別
                      #列出主類別
                      $sqlGMain = "SELECT * FROM Admin_GlobalProductMainClass WHERE  AGPMC_ID = '".$dataProDetail['SPD_AGPMC_ID']."' ";
                      $rsGMain = $Language_db->query($sqlGMain);
                      $dataGMain = $rsGMain->fetch();

                      #列出次類別
                      $sqlGSub = "SELECT * FROM Admin_GlobalProductSubClass WHERE  AGPSC_ID = '".$dataProDetail['SPD_AGPSC_ID']."' ";
                      $rsGSub = $Language_db->query($sqlGSub);
                      $dataGSub = $rsGSub->fetch();

                      echo $dataGMain['AGPMC_Name'];
                      ?>
                      <span>></span>
                      <?=$dataGSub['AGPSC_Name'];?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">供應商自訂類別</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?php
                      #抓出供應商自訂主類別、次類別
                      #列出主類別
                      $sqlClassMain = "SELECT * FROM Supplier_ProductMainClass WHERE  SPMC_ID = '".$dataProDetail['SPD_SPMC_ID']."' AND SPMC_SAD_ID = '".$dataProDetail['SPD_SAD_ID']."' ";
                      $rsClassMain = $Config_db->query($sqlClassMain);
                      $dataClassMain = $rsClassMain->fetch();

                      #列出次類別
                      $sqlClassSub = "SELECT * FROM Supplier_ProductSubClass WHERE  SPSC_ID = '".$dataProDetail['SPD_SPSC_ID']."' AND SPSC_SAD_ID = '".$dataProDetail['SPD_SAD_ID']."' ";
                      $rsClassSub = $Config_db->query($sqlClassSub);
                      $dataClassSub = $rsClassSub->fetch();

                      echo $dataClassMain['SPMC_Name'];
                      ?>
                      <span>></span>
                      <?=$dataClassSub['SPSC_Name'];?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">商品狀態</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?php
                      if($dataProDetail['SPD_CheckStatus']=='Y') {
                        echo "<text style='color:blue;'>上架</text>";
                      } else {
                        echo "<text style='color:red;'>下架</text>";
                        echo "下架原因:";
                        echo $dataProDetail['SPD_CheckReason'];
                      }
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">商品型態選擇</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?php
                      #general：一般商品
                      #special: 特價商品
                      #limited: 限時特價商品
                      if($dataProDetail['SPD_Type']=='general') {
                        echo "一般商品";
                      } else if($dataProDetail['SPD_Type']=='special') {
                        echo "特價商品";
                      } else {
                        echo "限時特價商品";
                      }
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">限時特價時間區段</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?
                      if($dataProDetail['SPD_LimitedStartTime']) {
                        echo $dataProDetail['SPD_LimitedStartTime']." ~ ".$dataProDetail['SPD_LimitedEndTime'];
                      } else {
                        echo "無活動";
                      }
                        ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">商品數量</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?=$dataProDetail['SPD_Amount'];?>
                  </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">商品名稱</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?=$dataProDetail['SPD_Name'];?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">商品簡介</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?=$dataProDetail['SPD_Introduction'];?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">原價(TWD)</td>
                    <td class="txtLeft" style="text-align:left;">
                       <?=$dataProDetail['SPD_Price'];?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">特價(TWD)</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?=$dataProDetail['SPD_BargainPrice'];?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">商品圖片</td>
                    <td class="txtLeft" style="text-align:left;" id="productImg">
                      <?php
                      #找出供應商名稱
                      $sadDate = fiveSadAccountSearch($Config_db,$dataProDetail['SPD_SAD_ID']); 
                      $sqlImg = "select * from Supplier_ProductImage where SPI_SPD_PID = '".$dataProDetail['SPD_ID']."'";
                      $rsImg = $Language_db->query($sqlImg);

                      while($dataImg = $rsImg->fetch()) { 
                        echo "<a class='fancybox' rel='group' href='../images/supplier/".$sadDate[1]."/product/contentImage/".$dataImg['SPI_Image']."'>";
                        echo "<img src='../images/supplier/".$sadDate[1]."/product/titleImage/".$dataImg['SPI_Image']."' style='width:100px' >";
                        echo "</a>";
                      }
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">商品規格 / 型號</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?=$dataProDetail['SPD_Nom'];?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">商品內容</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?=$dataProDetail['SPD_Content'];?>
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
                  <input type="hidden" name="pid" value="<?=$id;?>">
                  <table>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">商品狀態</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="radio" name="proStatus" value="Y" <? if($dataProDetail['SPD_CheckStatus']=='Y') { echo "checked"; }?>>
                        <label>上架</label>
                        <input type="radio" name="proStatus" value="N" <? if($dataProDetail['SPD_CheckStatus']=='N') { echo "checked"; }?>>
                        <label>下架</label>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">上、下架原因</td>
                      <td class="txtLeft" style="text-align:left;">
                        <textarea name="remark" placeholder="請輸入原因..."><?=$dataProDetail['SPD_CheckReason'];?></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">最後更新管理者</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?php
                        if($dataProDetail['SPD_AM_ID']) {
                          $sqlAm = "select AM_ID,AM_Account from Admin_Manager where AM_ID = '".$dataProDetail['SPD_AM_ID']."' ";
                          $rsAm = $Language_db->query($sqlAm);
                          $rowAm  = $rsAm->fetch();
                          echo $rowAm['AM_Account'];
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
          if($dataProDetail['SPD_SADClaim']=='Y') {
          ?>
          <div id="newsWarp" class="boxWarp">
          <h2 class="red">供應商請求上線內容</h2>
          <div class="tableWarp">
            <div id="formTable">
                <table>

                  <tr>
                    <td class="num titleTxt" style="width:120px;">上架請求說明</td>
                    <td class="txtLeft" style="text-align:left;">
                        <?=$dataProDetail['SPD_SADClaimReason'];?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt" style="width:120px;">請求時間</td>
                    <td class="txtLeft" style="text-align:left;">
                        <?=$dataProDetail['SPD_SADClaimTime'];?>
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

