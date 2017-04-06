<?php


#接收post資料，並轉換成參數
foreach($_POST as $key=>$val) {
  $$key=$val;
}

#接收get資料，並轉換成參數
foreach($_GET as $key=>$val) {
  $$key=$val;
}

#列出全部群組資料
$sqlSADgroup = "SELECT * FROM Admin_SupplierGroup ORDER BY ASG_ID DESC ";
$rsSADgroup = $Language_db->query($sqlSADgroup);
$dataSADgroup = $rsSADgroup->fetchAll(PDO::FETCH_ASSOC); 

$sqlPlus = ""; //資料庫語法加入
$URLplus = ""; //換頁所需參數

#檢查是否有搜尋的資料
/*
$country:地區
$group:群組
$status:狀態
$account:帳號
*/
if($country) { //國家
  $sqlPlus .= " AND SAD_Country = '".$country."'";
  $URLplus .= "&country=".$country; 
}
if($group) { //群組
  
  $sqlGroup = "select * from Supplier_AccountGroup where SAG_ASG_ID = '".$group."'";
  $rsGroup = $Language_db ->query($sqlGroup);
  $dataGroup = $rsGroup -> fetchAll();
  if(count($dataGroup) > 0) {
    $sqlPlus .= " AND (";
    for($i=0; $i < count($dataGroup);$i++) {
      if(($i+1) == count($dataGroup)) { //最後一筆
        $sqlPlus .= " SAD_Group = '".$dataGroup[$i]['SAG_ID']."'";
      } else {
        $sqlPlus .= " SAD_Group = '".$dataGroup[$i]['SAG_ID']."' OR";
      }
    }
    $sqlPlus .= ")";
  }

  
  //$sqlPlus .= " AND (select * from fskt_TW.Supplier_AccountGroup where SAG_ASG_ID = '".$group."')"
  $URLplus .= "&group=".$group;
}
if($status) { //帳號狀態
  $sqlPlus .= " AND SAD_Status = '".$status."'";
  $URLplus .= "&status=".$status;
}
if($account) { //帳號
  $sqlPlus .= " AND SAD_Account like '%".$account."%'";
  $URLplus .= "&account=".$account;
}
if($sName){ //供應商名稱
  $sqlPlus .= " AND SAD_ID in (select SADT_SAD_ID from Supplier_AccountDataTw where SADT_Name like '%".$sName."%')";
  $sqlPlus .= " OR SAD_ID in (select SADC_SAD_ID from Supplier_AccountDataCn where SADC_Name like '%".$sName."%')";
  $URLplus .= "&sName=".$sName;
}


#換頁所需要資訊
$page = isset($_GET['page'])?$_GET['page']:1 ; //當頁頁碼
$read_num = 10; //當頁觀看數量
$star_num = $read_num*($page-1); //開始讀取資料行數

#搜尋出所屬資料全部的數量
#資料庫、資料表
$sqlPage = "SELECT count(*) FROM Supplier_AccountData 
            where SAD_ID != '' 
            $sqlPlus
           ";                     
$rsPage = $Config_db->query($sqlPage);
$dataPage = $rsPage->fetch();           
$all_num = $dataPage['count(*)'];
$pageAll_num = ceil($all_num / $read_num); //頁碼數計算，全部數量/讀取數量 

#列出紀錄資料
$sqlSAD = "SELECT * FROM Supplier_AccountData 
           where SAD_ID != '' 
           $sqlPlus 
           ORDER BY SAD_ID DESC 
           limit $star_num, $read_num
          "; //列表資料         
$rsSAD = $Config_db->query($sqlSAD);
$dataSAD = $rsSAD->fetchAll(PDO::FETCH_ASSOC);
?>
<script>
function delSubmit(id) { //刪除function
  swal({   
    title: "確定要關閉?",   
    text: "關閉之後，相關的產品資料將下架！",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",   
    confirmButtonText: "Yes, close it!",   
    closeOnConfirm: false 
  }, function(){   
    ajaxPro(id);
  });
} //function delSubmit(id) { //刪除function
function ajaxPro(sid) {
  //var URLs  = "page_index.php?pageData=adminConfig&secondURL=process&act=del";
  var URLs  = "manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/process.php";
  $.ajax({
    url: URLs,
    data: { id:sid,act:"del"},
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
  }); //$.ajax({
} //function ajaxPro(mid) {
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
          <span><?=$pageTitle;?></span>
        </div>
        <div class="clearBoth"></div>
        <div id="pageIndexWarp" class="boxWarp">
          <div id="toolsBar" class="boxWarp">
            <button type="button" class="blue" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=add'">新增供應商帳號</button>
          </div>
          <div id="toolsBar" class="boxWarp">
            <form method="post" action="page_index.php?pageData=<?=$_GET['pageData'];?>">
              <select name="country" style='float:left;height: 34px;background-color: #fff;margin-left:5px;'>
                <option value="0">查詢地區</option>
                <option value="Tw" <?php if($country=='Tw') { echo "selected"; } ?>>台灣</option>
                <option value="Cn" <?php if($countrys=='Cn') { echo "selected"; } ?>>大陸</option>
              </select>
              <select name="group" style='float:left;height: 34px;background-color: #fff;margin-left:5px;'>
                <option value="0">群組名稱</option>
                <?php
                for($i=0;$i<count($dataSADgroup);$i++){
                  if($group == $dataSADgroup[$i]['ASG_ID']) {
                    echo "<option value=".$dataSADgroup[$i]['ASG_ID']." selected >".$dataSADgroup[$i]['ASG_Name']."</option>";
                  } else {
                    echo "<option value=".$dataSADgroup[$i]['ASG_ID'].">".$dataSADgroup[$i]['ASG_Name']."</option>";
                  }
                } //for($i=0;$i<count($dataSADgroup);$i++){
                ?>
              </select>
              <select name="status" style='float:left;height: 34px;background-color: #fff;margin-left:5px;'>
                <option value="0">帳號狀態</option>
                <option value="Y" <?php if($status=='Y') { echo "selected"; } ?>>開啟</option>
                <option value="N" <?php if($status=='N') { echo "selected"; } ?>>關閉</option>
              </select>
              <input type="text" name="account" placeholder="供應商帳號" style='float:left;line-height: 32px;border: 1px solid #e1e1e1;margin-left:5px;border-radius:5px;' value="<?= $orderNum; ?>">
              <input type="text" name="sName" placeholder="供應商名稱" style='float:left;line-height: 32px;border: 1px solid #e1e1e1;margin-left:5px;border-radius:5px;' value="<?= $sName; ?>">
              <input type="submit" class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=search'" value="查詢" style='width:50px;border-radius:5px;line-height: 32px;margin:2px 0px 0px 5px;'> 
            </form>
          </div>

          <div id="titleWarning" class="boxWarp" style="background-color: #BDE5F8;color: #00529B;padding: 10px;">
            <div style="float:right;right:0px;">
              <a href="#" class="close" onclick="closeTab()">
                <img src="../images/cross_grey_small.png" title="Close this notification" alt="close" />
              </a>
            </div>
            <i class="fa fa-info-circle"></i>
            資料筆數為：<?= $all_num; ?>
          </div>
          
          <div id="newsWarp" class="boxWarp">
            <h2 class="red"><?=$pageTitle;?></h2>
            <div id="formTable">
            <div class="tableWarp">
              <table>
                <tr>
                  <td class="num titleTxt">編號</td>
                  <td class="txt titleTxt" style="width:50px;">地區</td>
                  <td class="txt titleTxt" style="width:150px;">帳號</td>
                  <td class="txt titleTxt" style="width:200px;">供應商名稱</td>
                  <td class="txt titleTxt" style="width:100px;">帳號狀態</td>
                  <td class="btnTools">編輯</td>
                  <td class="btnTools">關閉</td>
                </tr>
                <?php
                for($i=0;$i<count($dataSAD);$i++) {
                ?>
                <tr>
                  <td class="num"><?=$i+1;?></td>
                  <td>
                    <h3>
                      <?=$dataSAD[$i]['SAD_Country'];?>
                    </h3>
                  </td>
                  <td>
                    <h3>
                      <?=$dataSAD[$i]['SAD_Account'];?>
                    </h3>
                  </td>
                  <td>
                    <h3>
                      <?=sadAccountSearch($Config_db, $dataSAD[$i]['SAD_ID']);?>
                    </h3>
                  </td>
                  <td>
                    <h3>
                      <?php
                      if($dataSAD[$i]['SAD_Status'] == 'Y') {
                        echo "<text style='color:blue'>開啟中</text>";
                      } else {
                        echo "<text style='color:red'>關閉中</text>";
                      }
                      ?>
                    </h3>
                  </td>
                  <td>
                    <button type="button" class="yellow toolsBtn" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=edit<?=$dataSAD[$i]['SAD_Country'];?>&id=<?=$dataSAD[$i]['SAD_ID'];?>'">修改</button>
                  </td>
                  <td>
                    <button type="button" class="red toolsBtn" onclick='delSubmit(<?=$dataSAD[$i]['SAD_ID'];?>)'>關閉</button>
                  </td>
                </tr>
                <?php
                /*onclick='delSubmit(<?=$dataAM['AM_ID'];?>)'*/
                } //for($i=0;$dataAM = $rsAM->fetch();$i++) {
                ?>

              </table>
            </div>
          </div>
          </div>
          <!--頁碼區塊 -->
          <?php
          //當前頁面代號、全部頁碼、當前頁碼、讀取頁數
          pageNumList($_GET['pageData'].$URLplus, $pageAll_num, $page, $read_num); 
          ?>
        </div>
        <!--<div id="pageNumBox">頁碼區塊-->
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>