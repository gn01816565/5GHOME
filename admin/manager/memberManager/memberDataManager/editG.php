<?php
  #判斷電話國碼是否有輸入#
  function checkArrayPhoneZip($zip) {
    #檢查是否有出現#符號做分隔，表示為其它國家的國碼輸入
    if(strpos($zip,"#")) { //有找到符號
      //開始分割字串
      $array = explode("#",$zip); 
    } else {
      $array[0] = $zip;
    } //if(strpos($zip,"#")) { //有找到符號
      return $array;
  } //function checkArrayPhoneZip($zip) {  

  $id = $_GET['id']; //會員編號

  #一般會員修改內容

  #會員帳號資料
  $sqlMemAccount = "SELECT * 
                    FROM Member_AccountsData 
                    WHERE MAD_Num = '".$id."'";
  $rsMemAccount = $Config_db->query($sqlMemAccount);
  $dataMemAccount = $rsMemAccount->fetch();

  #會員聯絡資料
  $sqlMem = " SELECT * 
              FROM Member_AccountsDataGeneral 
              WHERE MADG_MAD_Num = '".$id."'";
  $rsMem = $Config_db -> query($sqlMem);
  $dataMem = $rsMem->fetch();

  $arrayPhoneZip = checkArrayPhoneZip($dataMem['MADG_PhoneCode']);   //判斷電話國碼

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
      //alert(xhr.status);
      //alert(thrownError);
      alert(xhr.responseText);
      //alert('更新失敗!');
    }
  });
}
</script>
<style>
.zipCode,.county,.district{width:9rem;display:inline-block;margin-right:4px}
.zipCode {
    background-color: #fff;
    color: #000;
    height:34px;    
}
.county {
    background-color: #fff;
    color: #000;
    height:34px;
}
.district {
    background-color: #fff;
    color: #000;
    height:34px;
}
.Qtype {
  background-color: #fff;
  color: #000;
  height:34px;
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
            <h2 class="red">一般會員資料</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="formEdit" name="formEdit" method="post">
                  <input type="hidden" name="act" value="editG" >
                  <input type="hidden" name="id" value="<?= $id; ?>" >
                  <table>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">會員類型</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?php
                          if($dataMemAccount['MAD_Type'] == 'company') {
                            echo "企業會員";
                          } else {
                            echo "一般會員";
                          }
                        ?>
                      </td>
                    </tr>
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
                      <td class="num titleTxt">帳號</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$dataMemAccount['MAD_Account'];?>
                      </td>
                    </tr>
                    <!--
                    <tr>
                      <td class="num titleTxt">密碼</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="password" name="pw" value="<?= $dataMemAccount['MAD_Password']; ?>">
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">再次輸入密碼</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="password" name="pwCheck" value="<?= $dataMemAccount['MAD_Password']; ?>">
                      </td>
                    </tr>
                    -->
                    <tr>
                      <td class="num titleTxt">姓</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="MADG_LastName" value="<?=$dataMem['MADG_LastName'];?>" >
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">名</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="MADG_Name" value="<?=$dataMem['MADG_Name'];?>" >
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">生日</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="MADG_Birthday" id="birthday" placeholder="生日" value="<?=$dataMem['MADG_Birthday'];?>"style="width:100px;">
                        <span style="color:blue;">範例：1985-04-17</span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">姓別</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="radio" name="MADG_Sex" value="M" <?php if($dataMem['MADG_Sex']=='M') { echo "checked"; } ?>>
                        <label>男</label>
                        <input type="radio" name="MADG_Sex" value="F" <?php if($dataMem['MADG_Sex']=='F') { echo "checked"; } ?>>
                        <label>女</label>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">電話國碼</td>
                      <td style="text-align:left;">
                        <select id="MADG_PhoneCode" name="MADG_PhoneCode" style="background-color: #fff;color: #000;height:34px" onchange="phoneCodeChange(this.id);">
                          <option value="852"   <?php if($arrayPhoneZip[0]=='852') { echo "selected"; } ?>  >香港</option>
                          <option value="62"    <?php if($arrayPhoneZip[0]=='62') { echo "selected"; } ?>   >印尼</option>
                          <option value="64"    <?php if($arrayPhoneZip[0]=='64') { echo "selected"; } ?>   >紐西蘭</option>
                          <option value="81"    <?php if($arrayPhoneZip[0]=='81') { echo "selected"; } ?>   >日本</option>
                          <option value="60"    <?php if($arrayPhoneZip[0]=='60') { echo "selected"; } ?>   >馬來西亞</option>
                          <option value="65"    <?php if($arrayPhoneZip[0]=='65') { echo "selected"; } ?>   >新加坡</option>
                          <option value="886"   <?php if($arrayPhoneZip[0]=='886') { echo "selected"; } ?>  >台灣</option>
                          <option value="86"    <?php if($arrayPhoneZip[0]=='86') { echo "selected"; } ?>   >中國</option>
                          <option value="other" <?php if($arrayPhoneZip[0]=='other') { echo "selected"; } ?>>其它國家</option>
                        </select>
                        <span id="div_MADG_PhoneCode">
                          <?php
                          if($arrayPhoneZip[0] == 'other') {
                            echo '<input type="text" name="phoneZipText" id="phoneZipText" style="background-color:#FFF;width:100px;" placeholder="輸入電話國碼" value="'.$arrayPhoneZip[1].'"><span id="div_phoneZipText"></span>';
                          }
                          ?>
                        </span>
                        <!--
                        <select name="MADG_PhoneCode">
                          <option vlaue="0">請選擇</option>
                          <option value="886" <?php if($dataMem['MADG_PhoneCode']=='886') { echo "selected"; } ?>>台灣</option>
                          <option value="86" <?php if($dataMem['MADG_PhoneCode']=='86') { echo "selected"; } ?>> 大陸</option>
                        </select>
                        -->
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">電話</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="MADG_HomePhone" value="<?=$dataMem['MADG_HomePhone'];?>" >
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">手機</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="MADG_MobilePhone" value="<?=$dataMem['MADG_MobilePhone'];?>" >
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">信箱</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type="text" name="MADG_Email" value="<?=$dataMem['MADG_Email'];?>" >
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">國家</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?php
                        /*
                          $sqlGetCountry = "SELECT I31C_TwName 
                                            FROM ISO_3166_1_Cities
                                            WHERE I31C_Code = '$dataMem[MADG_Country]'";
                          $rsGetCountry = $Config_db -> query($sqlGetCountry);
                          $dataGetCountry = $rsGetCountry->fetch();
                          echo $dataGetCountry['I31C_TwName'];
                        */
                          
                        ?>
                        <select id="Country" name="Country" style="background-color: #fff;color: #000;height:34px" onChange="changeCountry(this.id)">
                          <option value="0">請選擇國家</option>
                          <?php
                          $RSCountry = $Config_db->query("SELECT * FROM ISO_3166_1_Cities");
                          $dataCountry = $RSCountry ->fetchall();

                            for($i=0;$i<count($dataCountry);$i++){
                              if ($dataCountry[$i]['I31C_Code'] == $dataMem['MADG_Country']) {
                                echo "<option value=".$dataCountry[$i]['I31C_Code']." selected > ".$dataCountry[$i]['I31C_TwName']."</option>";
                              }else{
                                echo "<option value=".$dataCountry[$i]['I31C_Code']." > ".$dataCountry[$i]['I31C_TwName']."</option>";
                              }
                            }
                          ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">地址</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?php
                        /*
                        if($dataMem['MADG_Zip']) { //假如有郵遞區號
                          $sqlGetAddressTitle = "SELECT *
                                                 FROM taiwanStreetName
                                                 WHERE mailCode = $dataMem[MADG_Zip]";
                          $rsGetAddressTitle = $Config_db -> query( $sqlGetAddressTitle );
                          $dataGetAddressTitle = $rsGetAddressTitle->fetch();
                          echo $dataGetAddressTitle['city'],$dataGetAddressTitle['country'],$dataMem['MADG_Address'];
                        } else { //沒有則直接顯示
                          echo $dataMem['MADG_Address'];
                        }
                        */
                        ?>
                        <div id="twzipcode" style="margin-bottom:10px;">
                          <?php
                          if($dataMem['MADG_Country']=='TW') {
                          ?>
                          <script>selectTW();</script>
                          <?php
                          }
                          ?>
                          *ZIP: <input type="text" name="Zip" id="Zip" style="background-color:#FFF;width:80px;" placeholder="郵遞區號" value="<?= $dataMem['MADG_Zip']; ?>">
                          <span id="div_Zip"></span>
                        
                        </div>  
                        <input id="Address" name="Address" style="border: 1px solid #e1e1e1;background: #FFF;" type="text" value="<?=$dataMem['MADG_Address']?>" placeholder="請輸入地址..." >
                        <br><span id="addressAlert"></span>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">任職公司</td>
                      <td class="txtLeft" style="text-align:left;">
                        <input type='text' name="MADG_Company" id="MADG_Company" value="<?= $dataMem['MADG_Company']; ?>"  >
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
                </form>
              </div><!--formTable-->  
            </div><!--tableWarp-->
          </div><!--newsWarp-->

          <div class="pageBtnWarp">
            <ul>
              <li><button type="button" class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>'">返回列表</button></li>
              <li><button class="red" onclick="ajaxPro()">儲存</button></li>
            </ul>
          </div><!--pageBtnWarp-->
        </div><!--pageIndexWarp-->
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>
<script>
//電話國碼，顯示自定區號
function phoneCodeChange(id) {
  if($('#'+id).val() == 'other') {
    $('#div_'+id).html('<input type="text" name="phoneZipText" id="phoneZipText" style="background-color:#FFF;width:100px;" placeholder="輸入電話國碼"><span id="div_MG_phoneZipText"></span>');
  } else {
    $('#div_'+id).html(' ');
  }
} //function phoneCodeChange(id) {
/*
$("#Country").on('change',function() {
  if($(this).find("option:selected").val() == 'TW'){
    selectTW();
  }else{
    $('#twzipcode').twzipcode('destroy');
    $('#twzipcode').html('*ZIP: <input type="text" name="Zip" id="Zip" style="background-color:#FFF;width:80px;" placeholder="郵遞區號">');
  }
});
*/
function changeCountry(id) {
  if($('#'+id).find("option:selected").val() == 'TW'){
    selectTW();
  }else{
    $('#twzipcode').twzipcode('destroy');
    $('#twzipcode').html('*ZIP: <input type="text" name="Zip" id="Zip" style="background-color:#FFF;width:80px;" placeholder="郵遞區號">');
  }
}
function selectTW(){
  $('#twzipcode').html(' '); //清空div裡的欄位
  $('#twzipcode').twzipcode({
      'css': ['county', 'district', 'zipCode'],
      zipcodeName: "Zip",
      zipcodeSel: "<?=$dataMem['MADG_Zip']?>",
      'detect': false // 預設值為 false
  });
  //$('#twzipcode').append('<span id="div_Zip"></span>');
}
$(function(){
if($("#Country option:selected").val() == 'TW'){
    selectTW();
  } else {
    $('#twzipcode').twzipcode('destroy');
  }
});
/*
$(document).ready(function(){
  if($("#Country option:selected").val() == 'TW'){
    selectTW();
  } else {
    $('#twzipcode').twzipcode('destroy');
  }
});
*/
</script>