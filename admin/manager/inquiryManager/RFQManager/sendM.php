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
      <form id="formEdit" name="formEdit">
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
              <h2 class="red">詢價內容</h2>
              <div id="formTable">
                <div class="tableWarp">
                  <input type="hidden" name="act" value="sendM">
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
                    <tr>
                      <td><?=$dataInquiryPro[$i]['AOIP_Name'];?></td>
                      <td><?=$dataInquiryPro[$i]['AOIP_Nom'];?></td>
                      <td><?=$dataInquiryPro[$i]['AOIP_Amount'];?></td>
                      <td><?=$dataInquiryPro[$i]['AOIP_ReferPrice'];?></td>
                      <td><?=$dataInquiryPro[$i]['AOIP_ReferSupplier'];?></td>
                      <td><?=$dataInquiryPro[$i]['AOIP_Remark'];?></td>
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
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$editData['AOIL_Name'];?></td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">姓別</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <?php
                        if($editData['AOIL_Sex']=='M') {
                          echo "男";
                        } else {
                          echo "女";
                        }
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">聯絡電話 / 手機</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$editData['AOIL_Phone'];?></td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">電子信箱</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$editData['AOIL_Email'];?></td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">聯絡地址</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$editData['AOIL_Address'];?></td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">詢價者備註</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=nl2br($editData['AOIL_Remark']);?></td>
                    </tr>
                    <!--
                    <tr>
                      <td class="red" colspan="4" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>供應商回報狀況</td>
                    </tr>
                    <tr>
                      <td colspan="4" style="background-color: #BDE5F8;color: #00529B;">
                        <i class="fa fa-info-circle"></i>
                        此供應商回報，只有管理者&供應商自動接收查閱。
                      </td>
                    </tr>
                  -->
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
                    foreach($dataProCreate as $key2=>$val2) {
                    ?>
                    <tr>
                      <td><?= $val2['AOIPC_Name']; ?></td>
                      <td><?= $val2['AOIPC_Nom']; ?></td>
                      <td><?= $val2['AOIPC_Amount']; ?></td>
                      <td><?= $val2['AOIPC_Price']; ?></td>
                      <td><?= $val2['AOIPC_Remark']; ?></td>
                      <td><?= $val2['AOIPC_RePrice']; ?></td>
                    </tr>
                    <?php
                    }  //foreach($dataProCreate as $key2=>$val2) {
                    ?>
                    <tr>
                      <td class="txt titleTxt num">總金額</td>
                      <td colspan="5" style="text-align:left;"><?= $val['AOIS_ReTotal'];?></td>
                    </tr>
                    <tr>
                      <td class="txt titleTxt num">是否含稅</td>
                      <td colspan="5" style="text-align:left;"><?= $val['AOIS_Tax'];?></td>
                    </tr>
                    <tr>
                      <td class="txt titleTxt num">報價說明</td>
                      <td colspan="5" style="text-align:left;"><?= nl2br($val['AOIS_ReRemark']);?></td>
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

                  <!--
                  <table>
                    <tr>
                      <td class="txt titleTxt" style="width:100px;">詢問時間</td>
                      <td class="txt titleTxt" style="width:100px;">回覆時間</td>
                      <td class="txt titleTxt" style="width:150px;">供應商</td>
                      <td class="txt titleTxt" style="width:100px;">回應金額</td>
                      <td class="txt titleTxt" style="width:100px;">含稅</td>
                      <td class="txt titleTxt">回覆內容</td>
                    </tr>
                    <?php
                    for($j=0;$j<count($dataSupplier);$j++) {
                    ?>
                    <tr>
                      <td><?=$dataSupplier[$j]['AOIS_CreateDate'];?></td>
                      <td><?=$dataSupplier[$j]['AOIS_ReDate'];?></td>
                      <td><?=sadAccountSearch($Config_db, $dataSupplier[$j]['AOIS_SAD_ID']);?></td>
                      <td><?=$dataSupplier[$j]['AOIS_ReTotal'];?></td>
                      <td>
                      <?php
                      if($dataSupplier[$j]['AOIS_Tax']=='Y') {
                        echo "是";
                      } else {
                        echo "否";
                      }
                      ?>
                      </td>
                      <td style="text-align:left;"><?=nl2br($dataSupplier[$j]['AOIS_ReRemark']);?></td>
                    </tr>
                    <?php
                    }
                    ?>
                  </table>
                  -->
            <div id="newsWarp" class="boxWarp">
              <h2 class="red">回覆資訊</h2>
              <div id="formTable">
                <div class="tableWarp">      
                  <table>
                    <tr>
                      <td colspan="4" style="background-color: #BDE5F8;color: #00529B;">
                        <i class="fa fa-info-circle"></i>
                        此處由管理者撰寫，會員可查閱的內容。
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">回覆金額</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <input type="text" name="rePrice" placeholder="回覆總金額">
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">回覆訊息</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <textarea name="message" placeholder="請輸入您要給會員的報價說明" style='height:100px;'></textarea>
                      </td>
                    </tr>
                  </table>
                
              </div><!--<div id="formTable">-->  
            </div>
          </div>
        <div class="pageBtnWarp">
          <ul>
            <li>
              <button class="green" type="button" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>'">返回列表</button>
            </li>
            <li>
              <button class="red" type="button" onclick="upSubmit()">送出</button>
            </li>
          </ul>
        </div>  
      </section>
      </form>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

