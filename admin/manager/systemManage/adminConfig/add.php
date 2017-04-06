<?php
#列出權限資料
$comSql = "select AMC_EnName,AMC_TwName,AMC_Level,AMC_MainClass from Admin_ManagerCompetence where AMC_Level = '2' ORDER BY AMC_ID ASC";
$comRs = $Config_db->query($comSql);

?>
<script>
function upSubmit(){
  var checkstatus = 1; //先預設有值
  //先清除alert狀態
  $('#acAlert').html(' ');
  $('#pwAlert').html(' ');
  $('#cpwAlert').html(' ');
  $('#emailAlert').html(' ');

  if(!$('#account').val()) {
    $('#acAlert').html('<i class="fa fa-warning"> 請輸入新增帳號！</i>');
    checkstatus=0;
  }
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
  if(!$('#email').val()) {
    $('#emailAlert').html('<i class="fa fa-warning"> 請輸入管理者的電子信箱！</i>');
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
    data: $('#adConfigEdit').serialize(),
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
          window.location.href='page_index.php?pageData=adminConfig';
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
<script>
$("#newsWarp .tableWarp table tr td a").removeAttr("style");
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
            <h2 class="red">資料新增</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="adConfigEdit" name="adConfigEdit">
                  <input type="hidden" name="act" value="add">
                  <table>
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
                      <td class="num titleTxt">帳號</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="account" id="account" placeholder="請輸入您的帳號...">
                        <span id="acAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">密碼</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="password" name="password" id="password" placeholder="請輸入您的密碼..." >
                        <span id="pwAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">再一次輸入密碼</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="password" name="checkpassword" id="checkpassword" placeholder="請再一次輸入您的密碼..." >
                        <span id="cpwAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">管理者電子信箱</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="email" id="email" placeholder="請輸入管理者的電子信箱..." >
                        <span id="emailAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">權限</td>
                      <td class="txtLeft" id="multselect">
                        <select id="competence" class="multiselect" multiple="multiple" name="competence[]">
                          <?php
                          while($comData = $comRs->fetch()) {
                            #列出主類別
                            $compmSql = "select AMC_ID,AMC_TwName from Admin_ManagerCompetence where AMC_ID = '".$comData['AMC_MainClass']."'"; 
                            $compmRs = $Config_db->query($compmSql);
                            $compmData  = $compmRs->fetch();
                            echo "<option value='".$comData['AMC_EnName']."'>".$compmData['AMC_TwName']." / ".$comData['AMC_TwName']."</option>";
                          }
                          ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">管理者等級</td>
                      <td style="text-align:left;">
                        <select name="selectLevel" id="selectLevel">
                          <option value="2">一般管理者</option>
                          <option value="1">最高管理者</option>
                        </select>
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
              <button class="red" onclick="upSubmit()">新增</button>
            </li>
          </ul>
        </div>  
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

