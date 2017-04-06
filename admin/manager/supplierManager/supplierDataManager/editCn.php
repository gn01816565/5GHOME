<?php
#台灣區供應商編輯頁面
$sadId = $_GET['id']; //供應商使用者id

#叫出帳號資料
$sqlSadAc = "SELECT * FROM Supplier_AccountData WHERE SAD_ID = '".$sadId."'";
$rsSadAc = $Config_db->query($sqlSadAc);
$dataSadAc = $rsSadAc->fetch();

#列出全部群組資料
$sqlSADgroup = "SELECT * FROM Admin_SupplierGroup ORDER BY ASG_ID DESC ";
$rsSADgroup = $Language_db->query($sqlSADgroup);
$dataSADgroup = $rsSADgroup->fetchAll(PDO::FETCH_ASSOC); 

#找出供應商的群組資料
$sqlMappingGroup = "SELECT * FROM  Supplier_AccountGroup where SAG_SAD_ID = '".$sadId."' ";
$rsMappingGroup = $Language_db->query($sqlMappingGroup);
$dataMappingGroup = $rsMappingGroup->fetch(PDO::FETCH_ASSOC); 

$tableName = "Supplier_AccountData".$dataSadAc['SAD_Country']; //供應商資料表分類 

#叫出供應商資料
$sqlSadDa = "SELECT * FROM ".$tableName." WHERE SADC_SAD_ID = '".$sadId."'";
$rsSadDa = $Config_db->query($sqlSadDa);
$dataSadDa = $rsSadDa->fetch();
?>
<script>
function upSubmit(){
  var checkstatus = 1; //先預設有值
  //先清除alert狀態
  $('#acAlert').html(' '); //帳號
  $('#pwAlert').html(' '); //密碼
  $('#cpwAlert').html(' '); //第二次輸入密碼
  $('#nameAlert').html(' '); //公司名稱

  /*
  $('#cpwAlert').html(' '); //公司簡稱
  $('#cpwAlert').html(' '); //統一編號
  $('#cpwAlert').html(' '); //郵遞區號
  $('#cpwAlert').html(' '); //公司地址
  $('#cpwAlert').html(' '); //公司網站
  $('#cpwAlert').html(' '); //公司Email
  $('#cpwAlert').html(' '); //公司電話國碼
  $('#cpwAlert').html(' '); //公司聯絡電話
  $('#cpwAlert').html(' '); //公司傳真號碼
  $('#cpwAlert').html(' '); //聯絡人姓名
  $('#cpwAlert').html(' '); //聯絡人職稱
  $('#cpwAlert').html(' '); //聯絡人Email
  */
  /*
  if(!$('#account').val()) {
    $('#acAlert').html('<i class="fa fa-warning"> 請輸入新增帳號！</i>');
    checkstatus=0;
  }
  */
  if(!$('#password').val()) {
    $('#pwAlert').html('<i class="fa fa-warning"> 請輸入密碼！</i>');
    checkstatus=0;
  }
  if(!$('#checkpassword').val()) {
    $('#cpwAlert').html('<i class="fa fa-warning"> 請再次輸入密碼！</i>');
    checkstatus=0;
  }
  if($('#password').val() != $('#checkpassword').val()) {
    $('#cpwAlert').html('<i class="fa fa-warning"> 密碼不相同，請確認密碼輸入正確！</i>');
    checkstatus=0;
  }
  if(!$('#Name').val()) {
    $('#nameAlert').html('<i class="fa fa-warning"> 請輸入公司名稱！</i>');
    checkstatus=0;
  }

  if(checkstatus==1) {
    ajaxPro(); //執行ajax
  }
} //function upSubmit(){

function ajaxPro() {
  //var URLs  = "manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/index.php?secondURL=process";
  var URLs  = "manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/process.php";
  $.ajax({
    url: URLs,
    data: $('#editForm').serialize(), //抓取全部的input值
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
          window.location.href="page_index.php?pageData=<?=$_GET['pageData'];?>"
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
          <div id="toolsBar" class="boxWarp" style="background-color: #BDE5F8;color: #00529B;">
            <i class="fa fa-info-circle"></i>
            為保持帳號重覆性，帳號新增後『不可』轉移地區，如：台灣->大陸、大陸->台灣
          </div>
          <div id="newsWarp" class="boxWarp">
            <h2 class="red">資料編輯</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="editForm" name="editForm">
                  <input type="hidden" name="act" value="edit">
                  <input type="hidden" name="sid" value="<?=$sadId;?>">
                  <table>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">所在群組</td>
                      <td class="leftTxt">
                        <select name="group">
                          <option value="0">請選擇...</option>
                          <?php
                          for($i=0;$i<count($dataSADgroup);$i++){
                          ?>
                          <option <? if($dataSADgroup[$i]['ASG_ID']==$dataMappingGroup['SAG_ASG_ID']) { echo "selected"; } ?> value="<?=$dataSADgroup[$i]['ASG_ID'];?>" ><?=$dataSADgroup[$i]['ASG_Name'];?></option>
                          <?php
                          } //for($i=0;$i<count($dataSADgroup);$i++){
                          ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">帳號狀況</td>
                      <td class="leftTxt">
                        <input type="radio" name="acStatus" value="Y" <? if($dataSadAc['SAD_Status']=='Y') { echo "checked"; }?>>
                        <label>開啟</label>
                        <input type="radio" name="acStatus" value="N" <? if($dataSadAc['SAD_Status']=='N') { echo "checked"; }?>>
                        <label>關閉</label>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">帳號</td>
                      <td class="leftTxt">
                        <?php
                        /*
                        <input type="text" name="account" id="account" placeholder="請輸入您的帳號..." value="<?=$dataSadAc['SAD_Account'];?>">
                        <span id="acAlert" ></span>
                        */
                        ?>
                        <?= $dataSadAc['SAD_Account']; ?>
                        <input type="hidden" name="account" value="<?= $dataSadAc['SAD_Account']; ?>">
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">密碼</td>
                      <td class="leftTxt">
                        <input type="password" name="password" id="password" placeholder="請輸入您的密碼..." value="<?=$dataSadAc['SAD_Password'];?>">
                        <span id="pwAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">再一次輸入密碼</td>
                      <td class="leftTxt">
                        <input type="password" name="checkpassword" id="checkpassword" placeholder="請再一次輸入您的密碼..." value="<?=$dataSadAc['SAD_Password'];?>">
                        <span id="cpwAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">公司地區</td>
                      <td class="leftTxt">
                        <input type="radio" name="Country" value="Tw" <? if($dataSadAc['SAD_Country']=='Tw') { echo "checked"; }?> disabled>
                        <label>台灣</label>
                        <input type="radio" name="Country" value="Cn" <? if($dataSadAc['SAD_Country']=='Cn') { echo "checked"; }?>>
                        <label>大陸</label>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">公司名稱</td>
                      <td class="leftTxt">
                        <input type="text" name="Name" id="Name" placeholder="請輸入您的公司名稱..." value="<?=$dataSadDa['SADC_Name'];?>">
                        <span id="nameAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">公司簡稱</td>
                      <td class="leftTxt">
                        <input type="text" name="SimpleName" id="SimpleName" placeholder="請輸入您的公司簡稱..." value="<?=$dataSadDa['SADC_SimpleName'];?>" >
                        <span id="simplenameAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">統一編號</td>
                      <td class="leftTxt">
                        <input type="text" name="VATNum" id="VATNum" placeholder="請輸入您的公司統一編號..." value="<?=$dataSadDa['SADC_VATNum'];?>" >
                        <span id="vatnumAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">郵遞區號</td>
                      <td class="leftTxt">
                        <input type="text" name="ZipCode" id="ZipCode" placeholder="請輸入您的公司地址的郵遞區號..." value="<?=$dataSadDa['SADC_ZipCode'];?>" >
                        <span id="zipcodeAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">公司地址</td>
                      <td class="leftTxt">
                        <input type="text" name="Address" id="Address" placeholder="請輸入您的公司地址..." value="<?=$dataSadDa['SADC_Address'];?>" >
                        <span id="addressAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">公司網站</td>
                      <td class="leftTxt"> 
                        <input type="text" name="Website" id="Website" placeholder="請輸入您的公司網站，如: www.google.com" value="<?=$dataSadDa['SADC_Website'];?>" >
                        <span id="websiteAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">公司Email</td>
                      <td>
                        <input type="text" name="Email" id="Email" placeholder="請輸入您的公司Email..." value="<?=$dataSadDa['SADC_Email'];?>" >
                        <span id="emailAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">公司電話國碼</td>
                      <td class="leftTxt">
                        <input type="text" name="PhoneZip" id="PhoneZip" placeholder="請輸入您的公司電話國碼，如: 886、86" value="<?=$dataSadDa['SADC_PhoneZip'];?>" >
                        <span id="phonezipAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">公司聯絡電話</td>
                      <td class="leftTxt">
                        <input type="text" name="Phone" id="Phone" placeholder="請輸入您的公司聯絡電話，手機或市話，如: 0921xxxxxx、06-2223333" value="<?=$dataSadDa['SADC_Phone'];?>" >
                        <span id="phoneAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">公司傳真號碼</td>
                      <td class="leftTxt">
                        <input type="text" name="Fax" id="Fax" placeholder="請輸入您的公司傳真號碼，請加上傳真區碼，如: 06-2223333" value="<?=$dataSadDa['SADC_Fax'];?>" >
                        <span id="faxAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">聯絡人姓名</td>
                      <td class="leftTxt">
                        <input type="text" name="ContactPerson" id="ContactPerson" placeholder="請輸入您的公司聯絡人姓名..." value="<?=$dataSadDa['SADC_ContactPerson'];?>" >
                        <span id="contactpersonAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">聯絡人職稱</td>
                      <td class="leftTxt">
                        <input type="text" name="ContactOffice" id="ContactOffice" placeholder="請輸入您的公司聯絡人職稱..." value="<?=$dataSadDa['SADC_ContactOffice'];?>" >
                        <span id="contactofficeAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">聯絡人Email</td>
                      <td class="leftTxt">
                        <input type="text" name="ContactEmail" id="ContactEmail" placeholder="請輸入您的公司聯絡人Email..." value="<?=$dataSadDa['SADC_ContactEmail'];?>" >
                        <span id="contactemailAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">備註</td>
                      <td class="leftTxt">
                        <textarea name="Remark" id="" placeholder="可輸入備註紀錄..."><?=$dataSadDa['SADC_Remark'];?></textarea>
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
            <li>
              <button class="red" onclick="upSubmit()">更新資料</button>
            </li>
          </ul>
        </div>  
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

