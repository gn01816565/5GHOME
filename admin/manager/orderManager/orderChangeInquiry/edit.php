<?php
$id = $_GET['id']; //詢價轉訂單編號

$sqlTitle = "select * from Admin_OrderChangeInquiryTitle where AOCIT_OrderNum = '".$id."'";
$rsTitle = $Language_db->query($sqlTitle);
$dataTitle = $rsTitle->fetch();

#產品列出
$sqlProduct = "select * from Admin_OrderChangeInquiryProduct where AOCIP_AOCIT_OrderNum = '".$id."'";
$rsProduct = $Language_db->query($sqlProduct);
$dataProduct = $rsProduct->fetchAll(PDO::FETCH_ASSOC); //移除數字索引

#管理者回報時的總金額、備註列出 
$sqlStatus  = "SELECT * FROM Admin_OrderChangeInquiryStatus where AOCIS_AOCIT_OrderNum = '".$id."'";
$rsStatus = $Language_db -> query($sqlStatus);
$dataStatus = $rsStatus -> fetchAll();
?>
<script>
function openSAD(id) { //打開供應商資料    
  $('.inquirySAD'+id).toggle();
}

function upSubmit(){
  var checkstatus = 1; //先預設有值
  
  //總金額判斷空白
  if(!$('#totalPrice').val()) {
    $('#totalPriceAlert').html('<i class="fa fa-warning"> 請輸入總金額！</i>');
    checkstatus=0;
  }
  //收件人姓名
  if(!$('#recipientName').val()) {
    $('#recipientNameAlert').html('<i class="fa fa-warning"> 請輸入收件人姓名！</i>');
    checkstatus=0;
  }
  //收件人聯絡手機
  if(!$('#mobile').val()) {
    $('#mobileAlert').html('<i class="fa fa-warning"> 請輸入收件人手機！</i>');
    checkstatus=0;
  }
  //收件人email
  if(!$('#email').val()) {
    $('#emailAlert').html('<i class="fa fa-warning"> 請輸入收件人email！</i>');
    checkstatus=0;
  }
  //收件人地址
  if(!$('#address').val()) {
    $('#addressAlert').html('<i class="fa fa-warning"> 請輸入收件人地址！</i>');
    checkstatus=0;
  }
  //訂單狀態
  if(!$('#orderStatus').val()) {
    $('#orderStatusAlert').html('<i class="fa fa-warning"> 請輸入訂單狀態！</i>');
    checkstatus=0;
  }

    if(checkstatus==1) {
      swal({   
      title: "確定要轉單?",   
      text: "轉單之後，此詢價單將增加成訂單！",   
      type: "warning",   
      showCancelButton: true,   
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "OK",   
      closeOnConfirm: false 
    }, function(){   
      //swal("Deleted!", "Your imaginary file has been deleted.", "success"); 
      //進入轉訂單的頁面
      ajaxPro(); //執行ajax
    });

  }
} //function upSubmit(){

function ajaxPro() {
  //var URLs  = "manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/index.php?secondURL=process";
  var URLs  = "manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/process.php";
  $.ajax({
    url: URLs,
    data: $('#orderChange').serialize(),
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
<style>
#orderContent {
  display: none;
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
          <span>></span>
          <span>詢價轉訂單</span>
        </div>
        <div class="clearBoth"></div>
        <div id="pageIndexWarp" class="boxWarp">
          <div id="newsWarp" class="boxWarp">
              <h2 class="red">訂單</h2>
              <div id="formTable">
                <div class="tableWarp">
                  <form id="orderChange">
                  <input type="hidden" name="act" value="inquiryChangePro">
                  <input type="hidden" name="id" id="id" value="<?=$id;?>">
                  <input type="hidden" name="M_Num" value="<?=$editData['AOIL_MAD_Num']?>">
                  <table>
                    <tr>
                      <td class="num titleTxt" style="width:150px;">訂單編號</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$dataTitle['AOCIT_OrderNumCode'];?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">轉單建立時間</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$dataTitle['AOCIT_CreateDate'];?>
                      </td>
                    </tr>
                  </tabel>
                  <table>
                    <tr>
                      <td class="red" colspan="3" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>詢價產品資訊</td>
                    </tr>
                    <tr>
                      <td class="txt titleTxt">產品名稱</td>
                      <td class="txt titleTxt">規格</td>
                      <td class="txt titleTxt">數量</td>
                    </tr>
                    <?php
                    #列出產品資訊
                    for($i=0;$i<count($dataProduct);$i++) {
                    ?>
                    <tr>
                      <td>
                        <?=$dataProduct[$i]['AOCIP_Name'];?>
                      </td>
                      <td>
                        <?=$dataProduct[$i]['AOCIP_Nom'];?>
                      </td>
                      <td>
                        <?=$dataProduct[$i]['AOCIP_Amount'];?>
                      </td>
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
                      <td class="num titleTxt">運送金額</td>
                      <td class="txtLeft" colspan="3" style="text-align:left;">
                        <input type="text" id="freightPrice" name="freightPrice" placeholder="請輸入運送金額" value="<?=$dataStatus[0]['AOCIS_FreightPrice']?>">
                        <span id="totalPriceAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*總金額</td>
                      <td class="txtLeft" colspan="3" style="text-align:left;">
                        <input type="text" id="totalPrice" name="totalPrice" placeholder="請輸入總金額" value="<?=$dataStatus[0]['AOCIS_TotalPrice'];?>">
                        <span id="totalPriceAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">運送方式</td>
                      <td class="txtLeft" colspan="3" style="text-align:left;">
                        <textarea name="shipping" placeholder="請輸入運送方式" style="height:100px;"><?=$dataStatus[0]['AOCIS_Shipping']?></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">付款方式</td>
                      <td class="txtLeft" colspan="3" style="text-align:left;">
                        <input type="text" name="payment" placeholder="請輸入付款方式" value="<?=$dataStatus[0]['AOCIS_Payment']?>">
                      </td>
                    </tr>
                  </tabel>
                  <table>
                    <tr>
                      <td class="red" colspan="4" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>詢價者資訊</td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">*姓名</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <input type="text" name="recipientName" id="recipientName" placeholder="請輸入姓名" value="<?=$dataTitle['AOCIT_Name'];?>">
                        <span id="recipientNameAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">*聯絡電話</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <input type="text" name="phone" id="phone" value="<?=$dataTitle['AOCIT_Phone'];?>">
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">*手機</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <input type="text" name="mobile" id="mobile" value="<?=$dataTitle['AOCIT_Mobile'];?>">
                        <span id="mobileAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">*電子信箱</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <input type="text" name="email" id="email" value="<?=$dataTitle['AOCIT_Email'];?>">
                        <span id="emailAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">*聯絡地址</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <input type="text" name="address" id="address" value="<?=$dataTitle['AOCIT_Address'];?>">
                        <span id="addressAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">會員備註(詢價單時的)</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <?php
                        $sqlInquiryList = "SELECT * FROM Admin_OrderInquiryList where AOIL_InquiryNum = '".$dataTitle['AOCIT_AOIL_InquiryNum']."'";
                        $rsInquiryList = $Language_db -> query($sqlInquiryList);
                        $dataInquiryList = $rsInquiryList -> fetch();
                        echo nl2br($dataInquiryList['AOIL_Remark']);
                        ?>
                      </td>
                    </tr>
                  </table>

                  <table>
                    <tr>
                      <td class="red" colspan="4" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>發票資訊</td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">發票類型</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <input type="radio" name="selectInvoiceType" value="3" <?php if($dataStatus[0]['AOCIS_InvoiceType']=='3') { echo "selected"; } ?> >
                        <label>三聯</label>
                        <input type="radio" name="selectInvoiceType" value="2" <?php if($dataStatus[0]['AOCIS_InvoiceType']=='2') { echo "selected"; } ?>>
                        <label>二聯</label>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">發票抬頭</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <input type="text" name="invoiceTitle" placeholder="請輸入發票抬頭" value="<?=$dataStatus[0]['AOCIS_InvoiceTitle']?>">
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">發票統編</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <input type="text" name="invoiceNumber" placeholder="請輸入發票統編" value="<?=$dataStatus[0]['AOCIS_InvoiceNum']?>">
                      </td>
                    </tr>
                  </table>
                  <table>
                    <tr>
                      <td class="red" colspan="4" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>狀態資訊</td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">*訂單狀態</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <input type="text" name="orderStatus" id="orderStatus" placeholder="可自行設定此訂單運作狀態" value="<?=$dataStatus[0]['AOCIT_OrderStatus'];?>">
                        <span id="orderStatusAlert"></sapn>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">物流業者名稱</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <input type="text" name="logisticsName" placeholder="請輸入物流業者名稱" value="<?=$dataStatus[0]['AOCIS_LogisticsName'];?>">
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">貨運單號</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <input type="text" name="logisticsNumber" placeholder="請輸入貨運單號" value="<?=$dataStatus[0]['AOCIS_LogisticsNum'];?>">
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">訂單結帳狀態</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <!--
                        <input type="text" name="orderCheckoutStatus" placeholder="請輸入結帳狀態">
                        -->
                        <select name="orderCheckoutStatus">
                          <option value="N">未結帳</option>
                          <option value="Y">已結帳</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">運費結帳狀態</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <!--
                        <input type="text" name="freightChechout" placeholder="請輸入運費結帳狀態">
                        -->
                        <select name="freightChechout">
                          <option value="N">未結帳</option>
                          <option value="Y">已結帳</option>
                        </select>
                      </td>
                    </tr>
                  </table>

                  <table> 
                    <tr>
                      <td class="red" colspan="4" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>狀況資訊</td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">管理者自行備註(會員看不到)</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><textarea name="adminRemarks" style="height:100px;"></textarea>
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
              <button class="yellow" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>&secondURL=read&id=<?=$id;?>'">回上一頁</button>
            </li>
            <li>
              <button class="red" onclick="upSubmit();">轉成訂單</button>
            </li>
          </ul>
        </div>  
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>
