<?php
$id = $_GET['id']; //會員編號

#一般會員修改內容

#會員帳號資料
$sqlMemAccount = "SELECT * FROM Member_AccountsData WHERE MAD_Num = '".$id."'";
$rsMemAccount = $Config_db->query($sqlMemAccount);
$dataMemAccount = $rsMemAccount->fetch();

#會員聯絡資料
$sqlMemData = " SELECT * FROM Member_AccountsDataGeneral WHERE MADG_MAD_Num = '".$id."'";
$rsMemData = $Config_db -> query($sqlMemData);
$dataMemData = $rsMemData->fetch();
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
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script>
$(function() {
  $.datepicker.regional['zh-TW']={
   dayNames:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],
   dayNamesMin:["日","一","二","三","四","五","六"],
   monthNames:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
   monthNamesShort:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
   prevText:"上月",
   nextText:"次月",
   weekHeader:"週"
   };
   $.datepicker.setDefaults($.datepicker.regional["zh-TW"]);
   
  $( "#birthday").datepicker({
    showOn: "button",
    buttonImage: "../images/calendar.gif",
    buttonImageOnly: true,
    dateFormat: 'yy-mm-dd'
  });
});
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
            <h2 class="red">商品內容資料</h2>
            <div class="tableWarp">
              <div id="formTable">
                <input type="hidden" name="act" value="editG" >
                <table>
                  <tr>
                    <td class="num titleTxt" style="width:120px;">會員類型</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?php
                      if($dataMemAccount == 'general') {
                        echo "企業會員";
                      } else {
                        echo "一般會員";
                      }
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">帳號</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?=$dataMemAccount['MAD_Account'];?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">密碼</td>
                    <td class="txtLeft" style="text-align:left;">
                      <input type="password" name="pw" >
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">再次輸入密碼</td>
                    <td class="txtLeft" style="text-align:left;">
                      <input type="password" name="pwCheck" >
                    </td>
                  </tr>
                  
                  <tr>
                    <td class="num titleTxt">姓</td>
                    <td class="txtLeft" style="text-align:left;">
                      <input type="text" name="lastName" value="<?=$dataMemData['MADG_LastName'];?>" >
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">名</td>
                    <td class="txtLeft" style="text-align:left;">
                      <input type="text" name="name" value="<?=$dataMemData['MADG_Name'];?>" >
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">生日</td>
                    <td class="txtLeft" style="text-align:left;">
                      <input type="text" name="birthday" id="birthday" placeholder="生日" value="<?=$dataMemData['MADG_Birthday'];?>"style="width:100px;">
                  </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">姓別</td>
                    <td class="txtLeft" style="text-align:left;">
                      <input type="radio" name="sex" value="M">
                      <label>男</label>
                      <input type="radio" name="sex" value="F">
                      <label>女</label>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">商片簡介</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?=$dataProDetail['SPD_Introduction'];?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">原價(TWD)</td>
                    <td class="txtLeft" style="text-align:left;">
                       <?=$dataProDetail['SPD_Price'];?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">特價(TWD)</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?=$dataProDetail['SPD_BargainPrice'];?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">商品圖片</td>
                    <td class="txtLeft" style="text-align:left;">
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">商品規格 / 型號</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?=$dataProDetail['SPD_Nom'];?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt">商品內容</td>
                    <td class="txtLeft" style="text-align:left;">
                      <?=$dataProDetail['SPD_Content'];?>
                    </td>
                  </tr>
                </table>
              </div><!--<div id="formTable">-->  
            </div>
          </div>

          <div id="newsWarp" class="boxWarp">
            <h2 class="red">上架、下架送出資訊</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="formEdit" name="formEdit">
                  <input type="hidden" name="act" value="edit">
                  <input type="hidden" name="pid" value="<?=$id;?>">
                  <table>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">商品狀態</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="radio" name="proStatus" value="Y" <? if($dataProDetail['SPD_CheckStatus']=='Y') { echo "checked"; }?>>
                        <label>上架</label>
                        <input type="radio" name="proStatus" value="N" <? if($dataProDetail['SPD_CheckStatus']=='N') { echo "checked"; }?>>
                        <label>下架</label>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">上、下架原因</td>
                      <td class="txtLeft" style="text-align:left;">
                        <textarea name="remark" placeholder="請輸入原因..."><?=$dataProDetail['SPD_CheckReason'];?></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">最後更新管理者</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?php
                        if($dataProDetail['SPD_AM_ID']) {
                          $sqlAm = "select AM_ID,AM_Account from Admin_Manager where AM_ID = '".$dataProDetail['SPD_AM_ID']."' ";
                          $rsAm = $Language_db->query($sqlAm);
                          $rowAm  = $rsAm->fetch();
                          echo $rowAm['AM_Account'];
                        } else {
                          echo "無紀錄";
                        }
                        ?>
                      </td>
                    </tr>
                  </table>
                </form>
              </div>
            </div>
          </div>

          <?php
          if($dataProDetail['SPD_SADClaim']=='Y') {
          ?>
          <div id="newsWarp" class="boxWarp">
          <h2 class="red">供應商請求上線內容</h2>
          <div class="tableWarp">
            <div id="formTable">
                <table>

                  <tr>
                    <td class="num titleTxt" style="width:120px;">上架請求說明</td>
                    <td class="txtLeft" style="text-align:left;">
                        <?=$dataProDetail['SPD_SADClaimReason'];?>
                    </td>
                  </tr>
                  <tr>
                    <td class="num titleTxt" style="width:120px;">請求時間</td>
                    <td class="txtLeft" style="text-align:left;">
                        <?=$dataProDetail['SPD_SADClaimTime'];?>
                    </td>
                  </tr>
                </table>
            </div>
          </div>
        </div>
        <?php
        } //if($dataPro['SPD_SADClaim']=='Y') {
        ?>

        <div class="pageBtnWarp">
          <ul>
            <li>
              <button class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>'">返回列表</button>
            </li>
            <li><button class="red" onclick="ajaxPro()">儲存</button></li>
          </ul>
        </div>  
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

