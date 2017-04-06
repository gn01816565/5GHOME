<?php
#台灣區供應商編輯頁面
$sadID = $_GET['id']; //供應商使用者id

#叫出帳號資料
$sqlSadAc = "SELECT * FROM Supplier_AccountData WHERE SAD_ID = '".$sadID."'";
$rsSadAc = $Config_db->query($sqlSadAc);
$dataSadAc = $rsSadAc->fetch(PDO::FETCH_ASSOC);

#列出全部群組資料
$sqlSADgroup = "SELECT * FROM Admin_SupplierGroup ORDER BY ASG_ID DESC ";
$rsSADgroup = $Language_db->query($sqlSADgroup);
$dataSADgroup = $rsSADgroup->fetchAll(PDO::FETCH_ASSOC); 

#找出供應商的群組資料
$sqlMappingGroup = "SELECT * FROM  Supplier_AccountGroup where SAG_SAD_ID = '".$sadID."' ";
$rsMappingGroup = $Language_db->query($sqlMappingGroup);
$dataMappingGroup = $rsMappingGroup->fetch(PDO::FETCH_ASSOC); 

$tableName = "Supplier_AccountData".$dataSadAc['SAD_Country']; //供應商資料表分類 

#叫出供應商資料
$sqlSadDa = "SELECT * FROM ".$tableName." WHERE SADT_SAD_ID = '".$sadID."'";
$rsSadDa = $Config_db->query($sqlSadDa);
$dataSadDa = $rsSadDa->fetch(PDO::FETCH_ASSOC);

#將權限字串拆成陣列
$arrayCompetence = explode(",", $dataSadAc['SAD_Competence']);

#列出供應商全部資料表(權限內容)
$sqlCompetence = "select * from Supplier_Menu where SM_Level = '2' order by SM_ID ASC";
$rsCompetence = $Config_db -> query($sqlCompetence);
$dataCompetence = $rsCompetence -> fetchall(PDO::FETCH_ASSOC);

?>
<script>
function upSubmit(){
  var checkstatus = 1; //先預設有值
  //先清除alert狀態
  //$('#acAlert').html(' '); //帳號
  $('#pwAlert').html(' '); //密碼
  $('#cpwAlert').html(' '); //第二次輸入密碼
  $('#nameAlert').html(' '); //公司名稱
  
  if(!$('#account').val()) {
    $('#acAlert').html('<i class="fa fa-warning"> 請輸入帳號！</i>');
    checkstatus=0;
  } else {//如果有輸入帳號，則判斷帳號是否重覆
    var status = recheckAccount();
    if(status==0) {
       $('#acAlert').html('<i class="fa fa-warning"> 該帳號已被使用過！</i>');
      checkstatus=0;
    }
  }

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
  /*
  if(!$('#password').val()) {
    $('#pwAlert').html('<i class="fa fa-warning"> 請輸入密碼！</i>');
    checkstatus=0;
  }
  if(!$('#checkpassword').val()) {
    $('#cpwAlert').html('<i class="fa fa-warning"> 請再次輸入密碼！</i>');
    checkstatus=0;
  }
  */

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
      alert(xhr.responseText);
      //alert('更新失敗!');
    }
  });
}

//帳號重覆判斷
function recheckAccount(){
  var checkURLs = "manager/supplierManager/supplierDataManager/accountRecheckProcess.php";
  var status;
  $.ajax({
    url: checkURLs,
    data: { account:$('#account').val(),id:<?=$sadID;?>,act:'edit'  }, //抓取要檢查的帳號值
    type:"POST",
    async:false, //有回傳值才會執行以下的js
    dataType:'json',
      
    success: function(msg){ //成功執行完畢
      
      if(msg.remsg=='success') {
        $("#acAlert").html('<i class="fa fa-warning" style="color:blue;"> 該帳號可以使用！</i>');
        status = 1;
      } else{
        $("#acAlert").html('<i class="fa fa-warning"> 該帳號已被使用過！</i>');
        status = 0;
      }
      
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
  return status;
}

//供應商重新申請密碼用
function PWSubmit(id) { //刪除function
  swal({   
    title: "確定要申請?",   
    text: "申請之後，供應商會自動產生一組新密碼，並寄到供應商信箱！",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",   
    confirmButtonText: "送出",   
    closeOnConfirm: false 
  }, function(){   
    PWajaxPro(id);
  });
} //function delSubmit(id) { //刪除function
function PWajaxPro(sid) {
  //var URLs  = "page_index.php?pageData=adminConfig&secondURL=process&act=del";
  var URLs  = "manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/process.php";
  $.ajax({
    url: URLs,
    data: { id:sid,act:"forgetSend"},
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
  }); //$.ajax({
} //function ajaxPro(mid) {

function creatrPW() { //隨機產生密碼
  //var text=['abcdefghijklmnopqrstuvwxyz','ABCDEFGHIJKLMNOPQRSTUVWXYZ','1234567890','~!@#$%^&*()_+";",./?<>']; 
  var text=['abcdefghijklmnopqrstuvwxyz','ABCDEFGHIJKLMNOPQRSTUVWXYZ','1234567890']; 
  var rand = function(min, max){return Math.floor(Math.max(min, Math.random() * (max+1)));} 
  var len = rand(8, 16); //長度為8-16
  var pw = ''; 
  for(i=0; i<len; ++i) { 
    var strpos = rand(0, 2);  //指定范圍
    pw += text[strpos].charAt(rand(0, text[strpos].length)); 
  } 
  $('#password').val();
  $('#checkpassword').val();
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
            密碼可自定或由系統生成，將帳號狀態調為『開啟』後，該帳號會自動生成密碼給供應商，後續由供應商登入後自行更改密碼資訊。
            <a href='javascript:void();' onclick="PWSubmit(<?=$sadID;?>)">重新發送密碼</a>
          </div> 
          <div id="newsWarp" class="boxWarp">
            <h2 class="red">資料編輯</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="editForm" name="editForm">
                  <input type="hidden" name="act" value="edit">
                  <input type="hidden" name="sid" value="<?=$sadID;?>">
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
                      <td class="num titleTxt">*帳號</td>
                      <td class="leftTxt">
                        <input type="text" name="account" id="account" placeholder="請輸入您的帳號..." value="<?= $dataSadAc['SAD_Account']; ?>">
                        <span id="acAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">密碼</td>
                      <td class="leftTxt">
                        <input type="password" name="password" id="password" placeholder="請輸入您的密碼...">
                        <span id="pwAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">再一次輸入密碼</td>
                      <td class="leftTxt">
                        <input type="password" name="checkpassword" id="checkpassword" placeholder="請再一次輸入您的密碼...">
                        <span id="cpwAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">功能權限</td>
                      <td id="multselect">
                        <select id="competence" class="multiselect" multiple="multiple" name="competence[]">
                        <?php
                          foreach($dataCompetence as $key => $val) {
                            #列出主類別
                            $sqlCompentenceMain = "select SM_ID,SM_Name from Supplier_Menu where SM_ID = '".$val['SM_MainClass']."'"; //列出主類別名稱語法
                            $rsCompentenceMain = $Config_db->query($sqlCompentenceMain);
                            $dataCompentenceMain = $rsCompentenceMain->fetch();
                            ?>
                            <option value="<?=$val['SM_EnName']?>" <?php if(in_array($val['SM_EnName'],$arrayCompetence)) { echo "selected"; } ?> ><?=$dataCompentenceMain['SM_Name']." / ".$val['SM_Name'];?></option>
                            <?php
                          } //foreach($dataCompetence as $key => $val)) {
                        ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">公司地區</td>
                      <td class="leftTxt">
                        <input type="radio" name="Country" value="Tw" <? if($dataSadAc['SAD_Country']=='Tw') { echo "checked"; }?> >
                        <label>台灣</label>
                        <!--
                        <input type="radio" name="Country" value="Cn" <? if($dataSadAc['SAD_Country']=='Cn') { echo "checked"; }?> disabled>
                        <label>大陸</label>
                        -->
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*公司名稱</td>
                      <td class="leftTxt">
                        <input type="text" name="Name" id="Name" placeholder="請輸入您的公司名稱..." value="<?=$dataSadDa['SADT_Name'];?>">
                        <span id="nameAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">統一編號</td>
                      <td class="leftTxt">
                        <input type="text" name="VATNum" id="VATNum" placeholder="請輸入您的公司統一編號..." value="<?=$dataSadDa['SADT_VATNum'];?>" >
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*負責人</td>
                      <td class="leftTxt">
                        <input type="text" name="Principal" id="Principal" placeholder="請輸入您的公司負責人..." value="<?=$dataSadDa['SADT_Principal'];?>" >
                        <span id="principalAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*公司地址</td>
                      <td class="leftTxt">
                        <input type="text" name="Address" id="Address" placeholder="請輸入您的公司營業地..." value="<?=$dataSadDa['SADT_Address'];?>" >
                        <span id="addressAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*通訊地址</td>
                      <td class="leftTxt">
                        <input type="text" name="mailingAddress" id="mailingAddress" placeholder="請輸入您的公司通訊地..." value="<?=$dataSadDa['SADT_MailingAddress'];?>" >
                        <span id="addressAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*公司電話國碼</td>
                      <td class="leftTxt">
                        <input type="text" name="PhoneZip" id="PhoneZip" placeholder="請輸入您的公司電話國碼，如: 886、86" value="<?=$dataSadDa['SADT_PhoneZip'];?>" >
                        <span id="phonezipAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*公司電話</td>
                      <td class="leftTxt">
                        <input type="text" name="Phone" id="Phone" placeholder="請輸入您的公司聯絡電話，手機或市話，如: 0921xxxxxx、06-2223333" value="<?=$dataSadDa['SADT_Phone'];?>" >
                        <span id="phoneAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">公司傳真</td>
                      <td class="leftTxt">
                        <input type="text" name="Fax" id="Fax" placeholder="請輸入您的公司傳真號碼，請加上傳真區碼，如: 06-2223333" value="<?=$dataSadDa['SADT_Fax'];?>" >
                      </td>
                    </tr>
                    <tr>
                      <td class="red" colspan="2" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>聯絡資料</td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*聯絡人</td>
                      <td class="leftTxt">
                        <input type="text" name="ContactPerson" id="ContactPerson" placeholder="請輸入您的公司聯絡人..." value="<?=$dataSadDa['SADT_ContactPerson'];?>" >
                        <span id="contactpersonAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">職位</td>
                      <td class="leftTxt">
                        <input type="text" name="ContactOffice" id="ContactOffice" placeholder="請輸入您的公司聯絡人職位..." value="<?=$dataSadDa['SADT_ContactOffice'];?>" >
                        <span id="contactofficeAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*聯絡Email</td>
                      <td class="leftTxt">
                        <input type="text" name="Email" id="Email" placeholder="請輸入您的公司聯絡Email..." value="<?=$dataSadDa['SADT_Email'];?>" >
                        <span id="contactemailAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">備註</td>
                      <td class="leftTxt">
                        <textarea name="Remark" id="" placeholder="可輸入備註紀錄..." style='height:150px;'><?=$dataSadDa['SADT_Remark'];?></textarea>
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