<?php
  //ini_set("display_errors", "On"); // 顯示錯誤是否打開( On=開, Off=關 )
  //error_reporting(E_ALL & ~E_NOTICE);
  $id = $_GET['id']; //會員編號

  #一般會員修改內容
  #會員帳號資料
  $sqlMemAccount = "SELECT * 
                    FROM Member_AccountsData 
                    WHERE MAD_Num = '$id'";
  $rsMemAccount = $Config_db->query($sqlMemAccount);
  $dataMemAccount = $rsMemAccount->fetch();

  /*****
  Member_AccountsData.MAD_Num == Member_AccountsDataCompany.MADC_MAD_Num;
  *****/
  
  #會員聯絡資料
  $sqlMemData = " SELECT * 
                  FROM Member_AccountsDataCompany 
                  WHERE MADC_MAD_Num = '$id'";
  $rsMemData = $Config_db -> query($sqlMemData);
  $dataMemData = $rsMemData->fetch();

  #列出會員群組資料
  $sqlGroupMapping = "SELECT * FROM Admin_MemberGroupMapping where AMGM_MAD_Num = '".$id."' ";
  $rsGroupMapping = $Language_db -> query($sqlGroupMapping);
  $dataGroupMapping = $rsGroupMapping -> fetch();
  if($dataGroupMapping) { //如果有資料
    $memGroupID = $dataGroupMapping['AMGM_AMG_ID']; //會員所對應的群組id對應
  } else { //如果沒群組
    $memGroupID = 0;
  }

  #計算訂單數
  $sqlOrderCount = "SELECT count(*) FROM  Supplier_OrderTitle where SOT_MAD_ID = '".$dataMemAccount['MAD_ID']."' ";
  $rsOrderCount  = $Language_db -> query($sqlOrderCount);
  $dataOrderCount = $rsOrderCount -> fetch();
  $orderCount = $dataOrderCount['count(*)'];
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
            <h2 class="red">企業會員資料</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="formEdit" name="formEdit" method="post">
                  <input type="hidden" name="act" value="editC" >
                  <input type="hidden" name="id" value="<?= $id; ?>" >
                  <table>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">電子報群組</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?php
                        #列出全部群組資料
                        $sqlGroup = "SELECT * FROM Admin_MemberGroup order by AMG_ID DESC";
                        $rsGroup = $Language_db -> query($sqlGroup);
                        $dataGroup = $rsGroup -> fetchAll();
                        ?>
                        <select name="memGroup" id="memGroup">
                          <option value='0'>請選擇電子報群組</option>
                          <?php
                          foreach($dataGroup as $key=>$val) {
                            if($val['AMG_ID']==$memGroupID) {
                              echo "<option value='".$val['AMG_ID']."' selected>".$val['AMG_Name']."</option>";
                            } else {
                              echo "<option value='".$val['AMG_ID']."'>".$val['AMG_Name']."</option>";
                            }
                          } //foreach($dataGroup as $key=>$val) {
                          ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">會員類型</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?= ($dataMemAccount['MAD_Type'] == 'company') ? "企業會員" : "一般會員"; ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">帳號</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?= $dataMemAccount['MAD_Account']; ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">公司名稱</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="MADC_Name" value="<?= $dataMemData['MADC_Name']; ?>" >
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">公司統編</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="MADC_ECCode" value="<?= $dataMemData['MADC_ECCode']; ?>" >
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">公司電話國碼</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="MADC_PhoneCode" value="<?=$dataMemData['MADC_PhoneCode'];?>" >
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">公司電話</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="MADC_Phone" value="<?=$dataMemData['MADC_Phone'];?>" >
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">公司email</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="MADC_Email" value="<?=$dataMemData['MADC_Email'];?>" >
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">聯絡人姓名</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="MADC_ContactName" value="<?=$dataMemData['MADC_ContactName'];?>" >
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">聯絡人職稱</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="MADC_ContactOffice" value="<?=$dataMemData['MADC_ContactOffice'];?>" >
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">聯絡人電話</td>
                      <td style="text-align:left;">
                        <input type="text" name="MADC_ContactMobilePhone" value="<?=$dataMemData['MADC_ContactMobilePhone'];?>" >
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">聯絡人email</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="MADC_ContactEmail" value="<?=$dataMemData['MADC_ContactEmail'];?>" >
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">
                        訂單數
                      </td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$orderCount;?>
                      </td>
                    </tr>
                  </table>
                </from>
              </div><!--formTable-->
            </div><!--tableWarp-->
          </div><!--newsWarp-->

          <div class="pageBtnWarp">
            <ul>
              <li><button type="button" class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>'">返回列表</button></li>
              <li><button type="button" class="red" onclick="ajaxPro()">儲存</button></li>
            </ul>
          </div>
        </div><!--pageIndexWarp-->
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>      