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
function openSAD(id) { //打開供應商資料    
  $('.inquirySAD'+id).toggle();
}
/*
function turnOrder() {
  $("#orderContent").dialog({
    autoOpen: false,
    resizable: false,
    modal:false, //鎖定頁面功能
    buttons: {
      '確定轉單': function() {
        $(this).dialog("close");
      },
      "取消": function() {
        $(this).dialog("close");
      }
    },
    height: 600,
    width: 600
  });

  $( "#orderContent" ).dialog("open");
}
*/
function turnOrder() {
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
        </div>
        <div class="clearBoth"></div>
        <div id="pageIndexWarp" class="boxWarp">
          <div id="newsWarp" class="boxWarp">
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
                          echo "<span style='padding:5px 13px 5px 13px;border-style:solid;border-width:1px;font-weight:bold;'>是</span>";
                        } else {
                          echo "<span class='red' style='width:100px;padding:5px 13px 5px 13px;'>否</span>";
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
                      <td class="txtLeft" style="text-align:left;" colspan="3"><?= nl2br($editData['AOIL_Remark']);?></td>
                    </tr>
                  </table>
                  
                  <table> 
                    <tr>
                      <td class="red" colspan="4" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>狀況資訊</td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">處理狀態</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <?php
                        switch($editData['AOIL_ProStatus']) {
                          case 'noProcess': 
                            echo "<span class='red' style='padding:5px 30px 5px 30px;'>未處理</span>";
                            break;
                          case 'transfer': 
                            echo "<span class='yellow' style='padding:5px 16px 5px 16px;'>轉發供應商</span>";
                            break;
                          case 'quoted': 
                            echo "<span style='padding:5px 30px 5px 30px;border-style:solid;border-width:1px;font-weight:bold;'>已報價</span>";
                            break;
                          case 'buy': 
                            echo "<span class='blue' style='padding:5px 16px 5px 16px;'>已下訂結案</span>";
                            break;
                          case 'closed': 
                            echo "<span class='red2' style='padding:5px 16px 5px 16px;'>未下訂結案</span>";
                            break;     
                          default:  
                            echo "<span style='padding:5px 16px 5px 16px;border-style:solid;border-width:1px;font-weight:bold;border-color:#b83b35;color:#b83b35;'>非會員詢價</span>";
                            break;
                        }
                        ?>
                      </td>
                    </tr>
                    <?php
                    #只有已向會員報價才會出現以下資訊
                    if($editData['AOIL_ProStatus']=='quoted') {
                    ?>
                    <tr>
                      <td class="titleTxt num">管理者回報總金額</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <?=$editData['AOIL_rePrice'];?>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">管理者回覆內容</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <?=nl2br($editData['AOIL_Message']);?>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">管理者帳號</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <?=amAccountSearch($Language_db, $editData['AOIL_AM_ID']);?>
                      </td>
                    </tr>
                    <?php
                    } //if($editData['AOIL_ProStatus']=='quoted') {
                    ?>
                    <tr>
                      <td class="red" colspan="4" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>成交紀錄</td>
                    </tr>
                    
                    <tr>
                      <td class="titleTxt num">過程紀錄</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        <?=$editData['AOIL_Record'];?>
                      </td>
                    </tr>
                    <tr>
                      <td class="titleTxt num">紀錄檔案</td>
                      <td class="txtLeft" style="text-align:left;" colspan="3">
                        
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
          <div id="newsWarp" class="boxWarp SADrePort">
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
        <div class="pageBtnWarp">
          <ul>
            <!--
            <li>
              <button class="red" onclick="turnOrder();">轉訂單</button>
            </li>
            -->
            <li>
              <button class="yellow" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>'">返回列表</button>
            </li>
            <li>
              <button class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>&secondURL=edit&id=<?=$id;?>'">修改</button>
            </li>
            <li>
              <button class="blue" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>&secondURL=send&id=<?=$id;?>'">供應商推送</button>
            </li>
            <li>
              <button class="red2" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>&secondURL=sendM&id=<?=$id;?>'">回覆給會員</button>
            </li>
            <li>
              <button class="red" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>&secondURL=orderChange&id=<?=$id;?>'">轉訂單</button>
            </li>
          </ul>
        </div>  
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

<div id="orderContent" title="補齊訂單資料">
  請選擇買家國家:
  <?php
  #抓出國家資料
  $sqlCountry = "select * from ISO_3166_1_Cities order by I31C_ID ASC";
  $rsCountry = $Config_db -> query($sqlCountry);
  $dataCountry = $rsCountry -> fetchAll();
  ?>
  <select name="s_Country" id="s_Country" style="background-color: #fff;color: #000;height:34px" >
    <option value="0">請選擇國家</option>
    <?php
    for($i=0;$i<count($dataCountry);$i++){
      if ($dataCountry[$i]['I31C_Code'] == $dataMADG['MADG_Country']) {
        echo "<option value=".$dataCountry[$i]['I31C_Code']." selected > ".$dataCountry[$i]['I31C_TwName']."</option>";
      }else{
        echo "<option value=".$dataCountry[$i]['I31C_Code']." > ".$dataCountry[$i]['I31C_TwName']."</option>";
      }
    }
    ?>
  </select>
</div>

