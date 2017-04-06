<?php
$id = $_GET['id']; //詢價單編號

$editSql = "select * from Admin_OrderInquiryList where AOIL_InquiryNum = '".$id."'";
$editRs = $Language_db->query($editSql);
$editData = $editRs->fetch();

#產品列出
$sqlInquiryPro = "select * from Admin_OrderInquiryProduct where AOIP_AOIL_InquiryNum = '".$id."'";
$rsInquiryPro = $Language_db->query($sqlInquiryPro);
$dataInquiryPro = $rsInquiryPro->fetchAll(PDO::FETCH_ASSOC); //移除數字索引

#有推送的供應商通知
$sqlSupplier = "select * from Admin_OrderInquirySupplier where AOIS_AOIL_InquiryNum = '".$id."'";
$rsSupplier= $Language_db->query($sqlSupplier);
$dataSupplier = $rsSupplier->fetchAll(PDO::FETCH_ASSOC); //移除數字索引
?>
<script>
function openSAD(id) {
  /*
  for(i=0;i < $('#sadCount').val(); i++) {
    $('.inquirySAD'+i).hide();
  }
  */
    
  $('.inquirySAD'+id).toggle();
}
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


function delSubmit(id) { //刪除function
  swal({   
    title: "確定要刪除?",   
    text: "刪除之後，記錄將直接消失！",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",   
    confirmButtonText: "Yes, delete it!",   
    closeOnConfirm: false 
  }, function(){   
    //swal("Deleted!", "Your imaginary file has been deleted.", "success"); 
    ajaxDelPro(id);
  });


}
function ajaxDelPro(mid) {
  //var URLs  = "page_index.php?pageData=adminConfig&secondURL=process&act=del";
  var URLs  = "manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/process.php";
  $.ajax({
    url: URLs,
    data: { id:mid,act:"editDel"},
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
          window.location.href='page_index.php?pageData=<?=$subDirectory;?>&secondURL=edit&id=<?=$id;?>';
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
      alert(xhr.responseText);
      //alert('更新失敗!');
    }
  });
}
</script>

<style type="text/css">
.borderText {
  border: 1px solid #e1e1e1;
  background: #FFF;
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
            <form id="formEdit" name="formEdit">
              <h2 class="red">詢價內容</h2>
              <div id="formTable">
                <div class="tableWarp">
                  <input type="hidden" name="act" value="edit">
                  <input type="hidden" name="id" id="id" value="<?=$id;?>">
                  <table>
                    <tr>
                      <td class="num titleTxt" style="width:150px;">詢價單單號</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$editData['AOIL_InquiryNum'];?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">詢價建立時間</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$editData['AOIL_CreateDate'];?>
                      </td>
                    </tr>
                  </tabel>
                  <table>
                    <tr>
                      <td class="red" colspan="6" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>詢價產品資訊</td>
                    </tr>
                    <tr>
                      <td class="txt titleTxt">產品名稱</td>
                      <td class="txt titleTxt">規格</td>
                      <td class="txt titleTxt">數量</td>
                      <td class="txt titleTxt">參考金額</td>
                      <td class="txt titleTxt">參考供應商</td>
                      <td class="txt titleTxt">商品備註</td>
                    </tr>
                    <?php
                    #列出產品資訊
                    for($i=0;$i<count($dataInquiryPro);$i++) {
                    ?>
                    <input type="hidden" name="pID[]" value="<?=$dataInquiryPro[$i]['AOIP_ID'];?>">
                    <tr>
                      <td><input type="text" name="pName[]" value="<?=$dataInquiryPro[$i]['AOIP_Name'];?>" style='border: 1px solid #e1e1e1;background: #FFF;'></td>
                      <td><input type="text" name="pNom[]" value="<?=$dataInquiryPro[$i]['AOIP_Nom'];?>" style="border: 1px solid #e1e1e1;background: #FFF;"></td>
                      <td><input type="text" name="pAmount[]" value="<?=$dataInquiryPro[$i]['AOIP_Amount'];?>" style="border: 1px solid #e1e1e1;background: #FFF;"></td>
                      <td><input type="text" name="pPrice[]" value="<?=$dataInquiryPro[$i]['AOIP_ReferPrice'];?>" style="border: 1px solid #e1e1e1;background: #FFF;"></td>
                      <td><input type="text" name="pSAD[]" value="<?=$dataInquiryPro[$i]['AOIP_ReferPrice'];?>" style="border: 1px solid #e1e1e1;background: #FFF;"></td>
                      <td><input type="text" name="pRemarks[]" value="<?=$dataInquiryPro[$i]['AOIP_Remark'];?>" style="border: 1px solid #e1e1e1;background: #FFF;"></td>
                    </tr>
                    <?php
                    } //while($dataOrderPro = $rsOrderPro->fetch()) {
                    ?>
                  </table>
                  <table>
                    <tr>
                      <td class="red" colspan="4" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>詢價者資訊</td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">是否為會員</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <?php
                        if($editData['AOIL_MAD_Num'] != "") {
                          echo "是";
                        } else {
                          echo "否";
                        }
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">姓名</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <input type="text" name="name" value="<?=$editData['AOIL_Name'];?>" style="border: 1px solid #e1e1e1;background: #FFF;">
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">姓別</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <input type="checkbox" name="sex" value="M" <? if($editData['AOIL_Sex']=='M') { echo "checked"; } ?>>
                        <label>男</label>
                        <input type="checkbox" name="sex" value="F" <? if($editData['AOIL_Sex']=='F') { echo "checked"; } ?>>
                        <label>女</label>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">聯絡電話 / 手機</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <input type="text" name="phone" value="<?=$editData['AOIL_Phone'];?>" style="border: 1px solid #e1e1e1;background: #FFF;">
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">電子信箱</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <input type="text" name="email" value="<?=$editData['AOIL_Email'];?>" style="border: 1px solid #e1e1e1;background: #FFF;">
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">聯絡地址</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <input type="text" name="address" value="<?=$editData['AOIL_Address'];?>" style="border: 1px solid #e1e1e1;background: #FFF;">
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">詢價者備註</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <textarea name="mRemarks" style="border: 1px solid #e1e1e1;background: #FFF;height:100px;"><?=$editData['AOIL_Remark'];?></textarea>
                      </td>
                    </tr>
                  </table>
                </div><!--<div id="formTable">-->  
              </div>
            </div>  
            <!--供應商回報_start-->
          <?php
          #以供應商總回報為準
          $i=0;
          foreach($dataSupplier as $key => $val) {
            #列出該報價底下的商品明細
            #供應商回報明細
            $sqlProCreate = "SELECT * FROM Admin_OrderInquiryProductCreate 
                             where AOIPC_AOIS_ID = '".$val['AOIS_ID']."' 
                             ";
            $rsProCreate = $Language_db -> query($sqlProCreate);
            $dataProCreate = $rsProCreate -> fetchAll();
          ?>
          <div id="newsWarp" class="boxWarp">
              <h2 class="red" onclick="openSAD(<?=$i?>);">
                <i class="fa fa-caret-square-o-right"></i>
                <?php
                #用供應商id找出供應商稱呼
                echo sadAccountSearch($Config_db, $val['AOIS_SAD_ID']);
                ?>
                 - 供應商回報狀況 (建立於:<?=$val['AOIS_CreateDate'];?>)
                <div class="moreBtn">
                  <a href="javascript:void();" title="刪除" onclick="delSubmit(<?=$val['AOIS_ID']?>)">刪除</a>
                </div> 
              </h2>

              <div id="formTable" class="inquirySAD<?=$i;?>" style='display:none;'>
                <div class="tableWarp">
                  <table>
                    <tr>
                      <td colspan="6" style="background-color: #BDE5F8;color: #00529B;">
                        <i class="fa fa-info-circle"></i>
                        此供應商回報，只有管理者&供應商可查閱資料。
                      </td>
                    </tr>
                    <tr>
                      <td class="txt titleTxt">產品名稱</td>
                      <td class="txt titleTxt">規格</td>
                      <td class="txt titleTxt">數量</td>
                      <td class="txt titleTxt">參考金額</td>
                      <td class="txt titleTxt">商品備註</td>
                      <td class="txt titleTxt">報價</td>
                    </tr>
                    <?php
                    $j=0;
                    foreach($dataProCreate as $key2=>$val2) {
                    ?>
                    <tr>
                      <input type="hidden" name="supplierCreate[<?= $val['AOIS_ID']; ?>][product][<?= $j; ?>][id]" value="<?= $val2['AOIPC_ID']; ?>">
                      <td><input type="text" name="supplierCreate[<?= $val['AOIS_ID']; ?>][product][<?= $j; ?>][name]" value="<?= $val2['AOIPC_Name']; ?>"></td>
                      <td><input type="text" name="supplierCreate[<?= $val['AOIS_ID']; ?>][product][<?= $j; ?>][nom]" value="<?= $val2['AOIPC_Nom']; ?>"></td>
                      <td><input type="text" name="supplierCreate[<?= $val['AOIS_ID']; ?>][product][<?= $j; ?>][amount]" value="<?= $val2['AOIPC_Amount']; ?>"></td>
                      <td><input type="text" name="supplierCreate[<?= $val['AOIS_ID']; ?>][product][<?= $j; ?>][price]" value="<?= $val2['AOIPC_Price']; ?>"></td>
                      <td><input type="text" name="supplierCreate[<?= $val['AOIS_ID']; ?>][product][<?= $j; ?>][remarks]" value="<?= $val2['AOIPC_Remark']; ?>"></td>
                      <td><input type="text" name="supplierCreate[<?= $val['AOIS_ID']; ?>][product][<?= $j; ?>][rePrice]" value="<?= $val2['AOIPC_RePrice']; ?>"></td>
                    </tr>
                    <?php
                    $j++;
                    }  //foreach($dataProCreate as $key2=>$val2) {
                    ?>
                    <tr>
                      <td class="txt titleTxt num">總金額</td>
                      <td colspan="5" style="text-align:left;">
                        <input type="text" name="supplierCreate[<?= $val['AOIS_ID']; ?>][reTotal]" value="<?= $val['AOIS_ReTotal'];?>">
                      </td>
                    </tr>
                    <tr>
                      <td class="txt titleTxt num">是否含稅</td>
                      <td colspan="5" style="text-align:left;">
                        <input type="radio" name="supplierCreate[<?= $val['AOIS_ID']; ?>][status]" value="Y" <?php if($val['AOIS_Tax'] == 'Y') { echo "checked"; } ?>>
                        <label>是</label>
                        <input type="radio" name="supplierCreate[<?= $val['AOIS_ID']; ?>][status]" value="N" <?php if($val['AOIS_Tax'] == 'N') { echo "checked"; } ?>>
                        <label>否</label>
                      </td>
                    </tr>
                    <tr>
                      <td class="txt titleTxt num">報價說明</td>
                      <td colspan="5" style="text-align:left;">
                        <textarea name="supplierCreate[<?= $val['AOIS_ID']; ?>][reRemark]" style='height:200px;'><?= $val['AOIS_ReRemark'];?></textarea>
                      </td>
                    </tr>
                  </table>
              </div>
            </div>
          </div>
          <?php
          $i++;
          } //foreach($dataProCreate as $key => $val) {
          ?>
          <!--供應商回報_end-->

            <div id="newsWarp" class="boxWarp">
              <h2 class="red">狀況資訊</h2>
              <div id="formTable">
                <div class="tableWarp">      
                  <table> 
                    <tr>
                      <td class="titleTxt num" style='width:150px;'>處理狀態</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <select name="selectOrderStatus">
                          <option value="noProcess" <? if($editData['AOIL_ProStatus']=='noProcess') { echo "selected"; }?>>未處理</option>
                          <option value="transfer" <? if($editData['AOIL_ProStatus']=='transfer') { echo "selected"; }?>>已轉發供應商</option>
                          <option value="quoted" <? if($editData['AOIL_ProStatus']=='quoted') { echo "selected"; }?>>已報價</option>
                          <option value="buy" <? if($editData['AOIL_ProStatus']=='buy') { echo "selected"; }?>>已下訂結案</option>
                          <option value="closed" <? if($editData['AOIL_ProStatus']=='closed') { echo "selected"; }?>>未下訂結案</option>
                          <option value="noMem" <? if($editData['AOIL_ProStatus']=='noMem') { echo "selected"; }?>>非會員詢價</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="red" colspan="4" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>管理者成交紀錄</td>
                    </tr>
                    
                    <tr>
                      <td class="titleTxt num">管理者過程紀錄</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <textarea name="remark" id="remark" placeholder="請輸入紀錄資料" style="border: 1px solid #e1e1e1;background: #FFF;height:100px;" ><?=$editData['AOIL_Record'];?></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">紀錄檔案</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        
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
              <button class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>'">返回列表</button>
            </li>
            <li>
              <button type="button" class="yellow" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>&secondURL=send&id=<?= $id; ?>'">供應商推送</button>
            </li>
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

