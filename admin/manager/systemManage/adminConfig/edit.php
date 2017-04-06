<?php
$id = $_GET['id']; //使用者id
$amSql = "select * from Admin_Manager where AM_ID = '".$id."'";
$amRs = $Language_db->query($amSql);
$amData = $amRs->fetch();

#將權限字串拆成陣列
$comp = explode(",", $amData['AM_Competence']);

#列出全部的權限資料
$comSql = "select * from Admin_ManagerCompetence where AMC_Level = '2' ORDER BY AMC_ID ASC";
$comRs = $Config_db->query($comSql);

?>
<script>
function upSubmit(){
  var checkstatus = 1; //先預設有值
  //先清除alert狀態

  $('#cpwAlert').html(' ');
  $('#emailAlert').html(' ');

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
      //swal(msg.remsg);
      swal({
          title:msg.remsg,
          text: "",
          type: "success"
        },
        function() {
          window.location.href='page_index.php?pageData=adminConfig';
        }
      );
      //setTimeout("location.href='page_index.php?pageData=adminConfig'",3000);
    },
    /*
    beforeSend:function(){ //執行中
    $('#submit_ca').css('display','none');
    $('#loadingIMG').css('display','block');
    //$('#loadingIMG').fadeIn(); //執行時loading
    },
    */
    
    complete:function(){ //執行完畢,不論成功或失敗
    //$('#loadingIMG').fadeOut();  //執行完畢將圖隱藏
    //location.href='manager/system/adminConfig/index.php?secondURL=process';
    },
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
            <h2 class="red">資料編輯</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="adConfigEdit" name="adConfigEdit">
                  <input type="hidden" name="act" value="edit">
                  <input type="hidden" name="aid" value="<?=$id;?>">
                  <table>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">帳號狀況</td>
                      <td class="leftTxt">
                        <input type="radio" name="acStatus" value="Y" <? if($amData['AM_Status']=='Y') { echo "checked"; } ?>>
                        <label>開啟</label>
                        <input type="radio" name="acStatus" value="N" <? if($amData['AM_Status']=='N') { echo "checked"; } ?>>
                        <label>關閉</label>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">帳號</td>
                      <td class="txtLeft" style="text-align:left;"><?=$amData['AM_Account'];?></td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">密碼</td>
                      <td><input type="password" name="password" id="password" placeholder="請輸入您的密碼..." ></td>
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
                        <input type="text" name="email" id="email" placeholder="請輸入管理者的電子信箱..." value="<?=$amData['AM_Email'];?>">
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
                            $compmSql = "select AMC_ID,AMC_TwName from Admin_ManagerCompetence where AMC_ID = '".$comData['AMC_MainClass']."'"; //列出主類別名稱語法
                            $compmRs = $Config_db->query($compmSql);
                            $compmData  = $compmRs->fetch();
                            ?>
                            <option value="<?=$comData['AMC_EnName']?>" <?php if(in_array($comData['AMC_EnName'],$comp)) { echo "selected"; } ?> ><?=$compmData['AMC_TwName']." / ".$comData['AMC_TwName'];?></option>
                            <?php
                          } //while($comData = $comRs->fetch()) {
                        ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">管理者等級</td>
                      <td style="text-align:left;">
                        <select name="selectLevel" id="selectLevel">
                          <option value="2" <?php if($amData['AM_Level']=='2') { echo "selected"; } ?>>一般管理者</option>
                          <option value="1" <?php if($amData['AM_Level']=='1') { echo "selected"; } ?>>最高管理者</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">建立時間</td>
                      <td class="txtLeft" style="text-align:left;"><?=$amData['AM_Create_Time'];?></td>
                    </tr>
                    <tr>
                      <td class="num titleTxt" >最後更新時間</td>
                      <td class="txtLeft" style="text-align:left;"><?=$amData['AM_Update_Time'];?></td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">最後更新ip</td>
                      <td class="txtLeft" style="text-align:left;"><?=$amData['AM_Update_Ip'];?></td>
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
              <button class="red" onclick="upSubmit()">更新</button>
            </li>
          </ul>
        </div>  
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

