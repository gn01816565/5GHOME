<?php
$id = $_GET['id']; //詢價單編號
$sadID = $_GET['sadID']; //供應商id

$editSql = "select * from Admin_OrderInquiryList where AOIL_InquiryNum = '".$id."'";
$editRs = $Language_db->query($editSql);
$editData = $editRs->fetch();

#產品資訊列出
$sqlInquiryPro = "select * from Admin_OrderInquiryProduct where AOIP_AOIL_InquiryNum = '".$id."'";
$rsInquiryPro = $Language_db->query($sqlInquiryPro);
$dataInquiryPro = $rsInquiryPro->fetchAll(PDO::FETCH_ASSOC); //移除數字索引

#有推送的供應商通知，查閱指定供應商
$sqlSupplier = "select * from Admin_OrderInquirySupplier where AOIS_AOIL_InquiryNum = '".$id."' AND AOIS_SAD_ID = '".$sadID."'";
$rsSupplier= $Language_db->query($sqlSupplier);
$dataSupplier = $rsSupplier->fetchAll(PDO::FETCH_ASSOC); //移除數字索引
?>
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
              <h2 class="red">詢價資訊</h2>
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
                    <tr>
                      <td><?=$dataInquiryPro[$i]['AOIP_Name'];?></td>
                      <td><?=$dataInquiryPro[$i]['AOIP_Nom'];?></td>
                      <td><?=$dataInquiryPro[$i]['AOIP_Amount'];?></td>
                      <td><?=$dataInquiryPro[$i]['AOIP_ReferPrice'];?></td>
                      <td><?=$dataInquiryPro[$i]['AOIP_ReferPrice'];?></td>
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
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?=$editData['AOIL_Remark'];?></td>
                    </tr>
                  </table>    
              
              </div><!--<div id="formTable">-->  
            </div>
          </div>

          <!--供應商回報_start-->
          <?php
          for($i=0;$i<count($dataSupplier);$i++) {
          ?>
          <div id="newsWarp" class="boxWarp">
              <h2 class="red">供應商報價明細</h2>
              <div id="formTable">
                <div class="tableWarp">
                  <table>
                    <tr>
                      <td>產品名稱</td>
                      <td>會員詢問價格</td>
                      <td>廠商報價</td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td class="txt titleTxt" style="width:150px;">供應商</td>
                      <td class="txt titleTxt">回覆內容</td>
                    </tr>
                  </table>
              </div>
            </div>
          </div>
          <?php
          } //for($i=0;$i<$dataSupplier;$i++) {
          ?>
          <!--供應商回報_end-->


        <div class="pageBtnWarp">
          <ul>
            <li>
              <button class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>'">返回列表</button>
            </li>
          </ul>
        </div>  
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

