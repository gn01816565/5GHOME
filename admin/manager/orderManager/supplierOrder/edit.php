<?php
$id = $_GET['id']; //訂單編號

$editSql = "select * from Supplier_OrderTitle where SOT_OrderNum = '".$id."'";
$editRs = $Language_db->query($editSql);
$editData = $editRs->fetch();

#運費計算
$sqlOrderStatus = "select * from Supplier_OrderStatus where SOS_SOT_OrderNum = '".$editData['SOT_OrderNum']."'";
$rsOrderStatus = $Language_db->query($sqlOrderStatus);
$dataOrderStatus = $rsOrderStatus->fetch();

#抓取訂單申訴資料
$SQLorderMemReturn = "SELECT * FROM Supplier_OrderMemberReturns WHERE SOMR_SOT_OrderNum like '".$id."'";
$RSorderMemReturn = $Language_db->query($SQLorderMemReturn);
$DATAorderMemReturn = $RSorderMemReturn->fetch();
?>
<script>
function upSubmit(){
  var checkstatus = 1; //先預設有值

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
      //alert(xhr.status);
      //alert(thrownError);
      alert(xhr.responseText);
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
            <form id="formEdit" name="formEdit">
              <h2 class="red">資料編輯</h2>
              <div id="formTable">
                <div class="tableWarp">
                  <input type="hidden" name="act" value="edit">
                  <input type="hidden" name="id" id="id" value="<?=$id;?>">
                  <table>
                    <tr>
                      <td class="num titleTxt">訂單編號</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="hidden" name="numID" id="numID" value="<?=$editData['SOT_OrderNum'];?>">
                        <?=$editData['SOT_OrderNumCode'];?>
                      </td>
                    </tr>
                  </tabel>
                  <table>
                    <tr>
                      <td class="red" colspan="4" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>產品資訊</td>
                    </tr>
                    <tr>
                      <td class="txt titleTxt">產品名稱</td>
                      <td class="txt titleTxt">規格</td>
                      <td class="txt titleTxt">數量</td>
                      <td class="txt titleTxt">金額</td>
                    </tr>
                    <?php
                    $totalPrice = 0; //總金額
                    #列出訂單產品資訊
                    $sqlOrderPro = "select * from Supplier_OrderContent where SOC_SOT_OrderNum = '".$editData['SOT_OrderNum']."' ";
                    $rsOrderPro = $Language_db->query($sqlOrderPro);
                    while($dataOrderPro = $rsOrderPro->fetch()) {
                      $totalPrice += ($dataOrderPro['SOC_Price']*$dataOrderPro['SOC_Amount']); //金額加總
                    ?>
                    <tr>
                      <td><?=$dataOrderPro['SOC_Name'];?></td>
                      <td><?=$dataOrderPro['SOC_Nom'];?></td>
                      <td><?=$dataOrderPro['SOC_Amount'];?></td>
                      <td><?=$dataOrderPro['SOC_Price'];?></td>
                    </tr>
                    <?php
                    } //while($dataOrderPro = $rsOrderPro->fetch()) {
                    ?>
                  </table>
                  <table>
                    <tr>
                      <td class="red" colspan="4" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>統計資訊</td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">運費</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <?php
                        echo $dataOrderStatus['SOS_FreightPrice'];
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">總金額</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$totalPrice+$dataOrderStatus['SOS_FreightPrice'];?></td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">運送方式</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$dataOrderStatus['SOS_Shipping'];?></td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">付款方式</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <?php
                        switch($editData['SOT_Payment']) {
                          case 'CreditCard': 
                            echo "線上刷卡";
                            break;
                          case 'formStore': 
                            echo "到店取貨";
                            break;
                          case 'aliPay': 
                            echo "支付寶";
                            break; 
                          case 'paypal':
                            echo "paypal";
                            break;     
                          case 'arrivalPayment':
                            echo "貨到付款";
                            break;
                          case 'bankTransfer':
                            echo "匯款";
                            break;    
                          default:
                            echo "未選擇";
                            break;
                        }
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="red" colspan="4" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>收件資訊</td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">購買時間</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$editData['SOT_CreateDate'];?></td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">姓名</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$editData['SOT_Name'];?></td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">運送地址</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$editData['SOT_Address'];?></td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">聯絡電話</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$editData['SOT_Phone'];?></td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">聯絡手機</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$editData['SOT_Mobile'];?></td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">電子信箱</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$editData['SOT_Email'];?></td>
                    </tr>
                    <tr>
                      <td class="red" colspan="4" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>發票資訊</td>
                    </tr>
                    <!--
                    <tr>
                      <td class="titleTxt num">地區</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"></td>
                    </tr>
                    -->
                    <tr>
                      <td class="titleTxt num">發票類型</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <?
                        if($dataOrderStatus['SOS_InvoiceType'] == 3) {
                          echo "三聯式";
                        } else {
                          echo "二聯式";
                        }
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">發票抬頭</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$dataOrderStatus['SOS_InvoiceTitle'];?></td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">發票統編</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$dataOrderStatus['SOS_InvoiceNum'];?></td>
                    </tr>
                    <tr>
                      <td class="red" colspan="4" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>狀態資訊</td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">訂單狀態</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <select name="selectOrderStatus">
                          <option value="noShipping" <? if($editData['SOT_OrderStatus']=='noShipping') { echo "selected"; }?>>未出貨</option>
                          <option value="shipped" <? if($editData['SOT_OrderStatus']=='shipped') { echo "selected"; }?>>已出貨</option>
                          <option value="refund" <? if($editData['SOT_OrderStatus']=='refund') { echo "selected"; }?>>退貨/退款</option>
                          <option value="replacement" <? if($editData['SOT_OrderStatus']=='replacement') { echo "selected"; }?>>換貨</option>
                          <option value="complaints" <? if($editData['SOT_OrderStatus']=='complaints') { echo "selected"; }?>>客訴</option>
                          <option value="invaild" <? if($editData['SOT_OrderStatus']=='invaild') { echo "selected"; }?>>作廢</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">物流業者名稱</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$dataOrderStatus['SOS_LogisticsName'];?></td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">貨運單號</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$dataOrderStatus['SOS_LogisticsNum'];?></td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">結帳狀態</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <select name="selectProductStatus">
                          <option value="N" <? if($editData['SOT_ProductStatus']=='N') { echo "selected"; }?>>未付款</option>
                          <option value="Y" <? if($editData['SOT_ProductStatus']=='Y') { echo "selected"; }?>>已付款</option>
                        </select>
                        <text style="color:red;">(視未來金流系統串聯狀況做自動/手動連動)</text>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">運費結帳狀態</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <select name="selectFreight">
                          <option value="N" <? if($editData['SOT_Freight']=='N') { echo "selected"; }?>>未付款</option>
                          <option value="Y" <? if($editData['SOT_Freight']=='Y') { echo "selected"; }?>>已付款</option>
                        </select>
                        <text style="color:red;">(視未來金流系統串聯狀況做自動/手動連動)</text>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">供應商檢視狀態</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <?php
                        if($dataOrderStatus['SOS_CheckStatus']=='Y') {
                          echo "<text style='color:blue;'>已檢視</text>";
                        } else {
                          echo "<text style='color:red;'>未檢視</text>";
                        }
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">供應商檢視時間</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$dataOrderStatus['SOS_CheckDate'];?></td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">管理者修改紀錄</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <textarea name="remark" id="remark" placeholder="請輸入修改過的紀錄" style='height:300px;'><?=$editData['SOT_Remarks'];?></textarea>
                      </td>
                    </tr>
                  </table>
                </form>
              </div><!--<div id="formTable">-->  
            </div>
          </div>

          <?php
          if($DATAorderMemReturn) { //有會員申訴資料，則列出以下資料
          ?>
          <div id="newsWarp" class="boxWarp Reply">
            <h2 class="red">會員申訴內容</h2>
            <div class="tableWarp">
              <div id="formTable">
                  <table>
                    <tr>
                      <td class="titleTxt num">申訴狀態</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <?php
                         if($DATAorderMemReturn['SOMR_ApplyType']=='refund') {
                          echo "退貨/退款";
                         }
                         if($DATAorderMemReturn['SOMR_ApplyType']=='replacement') {
                          echo "換貨";
                         }
                         ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">留言內容</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <?= nl2br($DATAorderMemReturn['SOMR_Remark']); ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">附加檔案</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <?php
                        if($DATAorderMemReturn['SOMR_File']) { //如果有檔案
                        ?>
                        <!--
                          <button class="yellow" onclick="location.href='../tc/download.php?f=./images/order/appeal/<?=$DATAorderMemReturn['SOMR_File']?>'"><?=$DATAorderMemReturn['SOMR_File'];?></button>
                        -->
                        <button class="yellow" onclick="window.open('../images/order/appeal/<?=$DATAorderMemReturn['SOMR_File']?>')"><?=$DATAorderMemReturn['SOMR_File'];?></button>
                        <?php
                        } else { //if($DATAorderMemReturn['SOMR_File']) {
                          echo "無";
                        }
                        ?>
                      </td>
                    </tr>
                  </table>
              </div>
            </div>
          </div>
          <?php
          } //if(count($DATAorderMemReturn) > 0 ) { //有會員申訴資料，則列出以下資料
          ?>


        <div class="pageBtnWarp">
          <ul>
            <li><button class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>'">返回列表</button></li>
            <li><button class="red" onclick="upSubmit()">儲存</button></li>
          </ul>
        </div>  
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

