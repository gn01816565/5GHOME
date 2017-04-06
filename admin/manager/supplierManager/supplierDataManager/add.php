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

  if(!$('#account').val()) {
    $('#acAlert').html('<i class="fa fa-warning"> 請輸入新增帳號！</i>');
    checkstatus=0;
  } else {//如果有輸入帳號，則判斷帳號是否重覆
    var status = recheckAccount();
    if(status==0) {
       $('#acAlert').html('<i class="fa fa-warning"> 該帳號已被使用過！</i>');
      checkstatus=0;
    }
  }
  /*
  if($('#password').val() != $('#checkpassword').val()) {
    $('#cpwAlert').html('<i class="fa fa-warning"> 密碼不相同，請確認密碼輸入正確！</i>');
    checkstatus=0;
  }
  */

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
    data: $('#addForm').serialize(), //抓取全部的input值
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

//帳號重覆判斷
function recheckAccount(){
  var checkURLs = "manager/supplierManager/supplierDataManager/accountRecheckProcess.php";
  var status;
  $.ajax({
    url: checkURLs,
    data: { account:$('#account').val(),act:'add' }, //抓取要檢查的帳號值
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
</script>
<?php
  #列出全部群組資料
  $sqlSADgroup = "SELECT * 
                  FROM Admin_SupplierGroup 
                  ORDER BY ASG_ID DESC ";
  $rsSADgroup = $Language_db->query($sqlSADgroup);
  $dataSADgroup = $rsSADgroup->fetchAll(PDO::FETCH_ASSOC); 
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
          <div id="toolsBar" class="boxWarp" style="background-color: #BDE5F8;color: #00529B;">
            <i class="fa fa-info-circle"></i>
            密碼由系統生成，若將帳號狀態調為『開啟』後，該帳號會自動生成密碼並寄給供應商，後續由供應商登入後自行更改密碼資訊。
          </div> 
          <div id="newsWarp" class="boxWarp">
            <h2 class="red">資料新增</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="addForm" name="addForm">
                  <input type="hidden" name="act" value="add">
                  <table>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">所在群組</td>
                      <td class="leftTxt">
                        <select name="group">
                          <option value="0">請選擇...</option>
                          <?php
                            for($i=0; $i<count($dataSADgroup); $i++) {
                          ?>
                          <option value="<?=$dataSADgroup[$i]['ASG_ID'];?>" ><?=$dataSADgroup[$i]['ASG_Name'];?></option>
                          <?php
                            } //end for($i=0; $i<count($dataSADgroup); $i++)
                          ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">帳號狀況</td>
                      <td class="leftTxt">
                        <input type="radio" name="acStatus" value="Y" >
                        <label>開啟</label>
                        <input type="radio" name="acStatus" value="N" checked>
                        <label>關閉</label>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*帳號</td>
                      <td class="leftTxt">
                        <input type="text" name="account" id="account" placeholder="請輸入您的帳號..." onblur="recheckAccount()">
                        <span id="acAlert" ></span>
                      </td>
                    </tr>
                    <!--
                    <tr>
                      <td class="num titleTxt">密碼</td>
                      <td class="leftTxt">
                        <input type="password" name="password" id="password" placeholder="請輸入您的密碼..." >
                        <span id="pwAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">再一次輸入密碼</td>
                      <td class="leftTxt">
                        <input type="password" name="checkpassword" id="checkpassword" placeholder="請再一次輸入您的密碼..." >
                        <span id="cpwAlert"></span>
                      </td>
                    </tr>
                    -->
                    <tr>
                      <td class="num titleTxt" style="width:120px;">公司地區</td>
                      <td class="leftTxt">
                        <input type="radio" name="Country" value="Tw" checked>
                        <label>台灣</label>
                        <!--
                        <input type="radio" name="Country" value="Cn">
                        <label>大陸</label>
                        -->
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*公司名稱</td>
                      <td class="leftTxt">
                        <input type="text" name="Name" id="Name" placeholder="請輸入您的公司名稱...">
                        <span id="nameAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">統一編號</td>
                      <td class="leftTxt">
                        <input type="text" name="VATNum" id="VATNum" placeholder="請輸入您的公司統一編號...">
                        <span id="vatnumAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*負責人</td>
                      <td class="leftTxt">
                        <input type="text" name="Principal" id="Principal" placeholder="請輸入您的公司負責人...">
                        <span id="principalAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*營業地址</td>
                      <td class="leftTxt">
                        <input type="text" name="Address" id="Address" placeholder="請輸入您的公司營業地...">
                        <span id="addressAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*通訊地址</td>
                      <td class="leftTxt">
                        <input type="text" name="mailingAddress" id="mailingAddress" placeholder="請輸入您的公司通訊地...">
                        <span id="addressAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*公司電話國碼</td>
                      <td class="leftTxt">
                        <input type="text" name="PhoneZip" id="PhoneZip" placeholder="請輸入您的公司電話國碼，如: 886、86">
                        <span id="phonezipAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*公司電話</td>
                      <td class="leftTxt">
                        <input type="text" name="Phone" id="Phone" placeholder="請輸入您的公司聯絡電話，手機或市話，如: 0921xxxxxx、06-2223333">
                        <span id="phoneAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">公司傳真</td>
                      <td class="leftTxt">
                        <input type="text" name="Fax" id="Fax" placeholder="請輸入您的公司傳真號碼，請加上傳真區碼，如: 06-2223333">
                      </td>
                    </tr>
                    <tr>
                      <td class="red" colspan="2" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>聯絡資料</td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*聯絡人</td>
                      <td class="leftTxt">
                        <input type="text" name="ContactPerson" id="ContactPerson" placeholder="請輸入您的公司聯絡人...">
                        <span id="contactpersonAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">職位</td>
                      <td class="leftTxt">
                        <input type="text" name="ContactOffice" id="ContactOffice" placeholder="請輸入您的公司聯絡人職位...">
                        <span id="contactofficeAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">聯絡電話</td>
                      <td class="leftTxt">
                        <input type="text" name="ContactPhone" id="ContactPhone" placeholder="請輸入您的公司聯絡電話...">
                        <span id="contactPhoneAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">*聯絡Email</td>
                      <td class="leftTxt">
                        <input type="text" name="Email" id="Email" placeholder="請輸入您的公司聯絡Email...">
                        <span id="emailAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">備註</td>
                      <td class="leftTxt">
                        <textarea name="Remark" id="" placeholder="可輸入備註紀錄..." style='height:150px;'></textarea>
                      </td>
                    </tr>
                  </table>
                </form>
              </div><!--tableWarp-->
            </div><!--formTable-->
          </div><!--newsWarp-->
          <div class="pageBtnWarp">
            <ul>
              <li><button class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>'">返回列表</button></li>
              <li>
                <button class="red" onclick="upSubmit()">新增</button>
              </li>
            </ul>
          </div>
        </div><!--pageIndexWarp-->
      </section>
    <div class="clearBoth"></div>
    </div>
  </div>
</div>