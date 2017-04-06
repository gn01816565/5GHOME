<?php
#抓取列出的資料內容
foreach($_GET as $key=>$val) {
  $$key=$val;
}

#判斷資料內容
if($act == 'group') { //自訂群組內容
  #找出群組名稱
  //id: 群組id
  $sqlGroup = "SELECT * FROM Admin_MemberGroup where AMG_ID = '".$id."' "; 
  $rsGroup = $Language_db -> query($sqlGroup);
  $dataGroup = $rsGroup -> fetch();
  $groupName = $dataGroup['AMG_Name']; //群組名稱

  #找出群組有mapping到的會員num
  $sqlGroupMapping = "SELECT * FROM Admin_MemberGroupMapping where AMGM_AMG_ID = '".$id."' "; 
  $rsGroupMapping = $Language_db -> query($sqlGroupMapping);
  $dataGroupMapping = $rsGroupMapping -> fetchAll();

  #找出有在該群組的會員
  $i=0;
  foreach($dataGroupMapping as $key=>$val) {
  //for($i=0;$i<count($dataGroupMapping);$i++) {
    #找出會員編號
    $sqlMem = "SELECT * FROM Member_AccountsData where MAD_Num = '".$val['AMGM_MAD_Num']."'";
    $rsMem = $Config_db -> query($sqlMem);
    $dataMem = $rsMem -> fetch();
    
    #找出會員資料
    if($dataMem['MAD_Type'] == 'general') { //一般會員
      $sqlMemData = "SELECT * FROM Member_AccountsDataGeneral where MADG_MAD_Num = '".$dataMem['MAD_Num']."' ";
      $rsMemData = $Config_db -> query($sqlMemData);
      $dataMemData = $rsMemData -> fetch();
      $arrayList[$i]['id'] = $dataMemData['MADG_MAD_Num']; //會員編號
      $arrayList[$i]['name'] = $dataMemData['MADG_LastName'].$dataMemData['MADG_Name']; //會員名稱
      $arrayList[$i]['email'] = $dataMemData['MADG_Email'];  //email
    } else { //找企業會員
      $sqlMemData = "SELECT * FROM Member_AccountsDataCompany where MADC_MAD_Num = '".$dataMem['MAD_Num']."' ";
      $rsMemData = $Config_db -> query($sqlMemData);
      $dataMemData = $rsMemData -> fetch();
      $arrayList[$i]['id'] = $dataMemData['MADC_MAD_Num']; //會員編號
      $arrayList[$i]['name'] = $dataMemData['MADC_Name']; //會員名稱
      $arrayList[$i]['email'] = $dataMemData['MADC_Email'];//公司email
    }
    $i++;
  }
  
} else if($act == 'noClass') { //沒有群組的

  $groupName = "未分類會員"; //群組名稱
  //全部會員
  $sqlMemList = "SELECT * FROM Member_AccountsData ";
  $rsMemList = $Config_db -> query($sqlMemList);
  $dataMemList = $rsMemList -> fetchAll();
  //計算沒在群組中的數量
  $i=0;
  foreach($dataMemList as $key=>$val) {
    $sqlMappingCheck = "SELECT * from Admin_MemberGroupMapping where AMGM_MAD_Num = '".$val['MAD_Num']."'";
    $rsMappingCheck = $Language_db -> query($sqlMappingCheck);
    $dataMappingCheck = $rsMappingCheck -> fetchAll();
    if(count($dataMappingCheck) <= 0) { //如果沒資料，表示未分類
      //分辨是企業會員、一般會員
      if($val['MAD_Type'] == 'general') { //一般會員
        $sqlMemData = "SELECT * FROM Member_AccountsDataGeneral where MADG_MAD_Num = '".$val['MAD_Num']."' ";
        $rsMemData = $Config_db -> query($sqlMemData);
        $dataMemData = $rsMemData -> fetch();
        $arrayList[$i]['id'] = $dataMemData['MADG_MAD_Num']; //會員編號
        $arrayList[$i]['name'] = $dataMemData['MADG_LastName'].$dataMemData['MADG_Name']; //會員名稱
        $arrayList[$i]['email'] = $dataMemData['MADG_Email'];  //email
      } else { //企業會員
        $sqlMemData = "SELECT * FROM Member_AccountsDataCompany where MADC_MAD_Num = '".$val['MAD_Num']."' ";
        $rsMemData = $Config_db -> query($sqlMemData);
        $dataMemData = $rsMemData -> fetch();
        $arrayList[$i]['id'] = $dataMemData['MADC_MAD_Num']; //會員編號
        $arrayList[$i]['name'] = $dataMemData['MADC_Name']; //會員名稱
        $arrayList[$i]['email'] = $dataMemData['MADC_Email'];//公司email
      }
      $i++;
    } 
  } //foreach($dataMemList as $key=>$val) {

} else if($act == 'country') { //分國家的
  #群組名稱
  $sqlCountry = "SELECT * FROM ISO_3166_1_Cities where I31C_Code = '".$id."'";
  $rsCountry = $Config_db -> query($sqlCountry);
  $dataCountry = $rsCountry -> fetch();
  $groupName = $dataCountry['I31C_TwName']; //群組名稱
  #找出會員編號
  //找企業會員
  $sqlMemC = "SELECT * FROM Member_AccountsDataCompany where MADC_Country = '".$id."' ";
  $rsMemC = $Config_db -> query($sqlMemC);
  $dataMemC = $rsMemC -> fetchAll();

  for($i=0;$i<count($dataMemC);$i++) {
    $arrayList[$i]['id'] = $dataMemC[$i]['MADC_MAD_Num']; //會員編號
    $arrayList[$i]['name'] = $dataMemC[$i]['MADC_Name']; //公司名稱
    $arrayList[$i]['email'] = $dataMemC[$i]['MADC_Email'];//公司email
  } //for($i=0;$i<count($dataMemC);$i++) {
  //找一般會員
  $sqlMemG = "SELECT * FROM Member_AccountsDataGeneral where MADG_Country = '".$id."' ";
  $rsMemG = $Config_db -> query($sqlMemG);
  $dataMemG = $rsMemG -> fetchAll();

  for($i=count($dataMemC),$j=0;$i<(count($dataMemG)+count($dataMemC));$i++,$j++) {
    $arrayList[$i]['id'] = $dataMemG[$j]['MADG_MAD_Num']; //會員編號
    $arrayList[$i]['name'] = $dataMemG[$j]['MADG_LastName'].$dataMemG[$j]['MADG_Name']; //會員名稱
    $arrayList[$i]['email'] = $dataMemG[$j]['MADG_Email'];  //email
  }

} else { //非會員定閱，agree
  $groupName = "非會員訂閱"; //群組名稱
  $sqlRead = "SELECT * FROM Admin_EdmApply where AEA_Status = 'Y' order by AEA_ID DESC ";
  $rsRead = $Language_db -> query($sqlRead);
  $dataRead = $rsRead -> fetchAll();

  for($i=0;$i<count($dataRead);$i++) {
    $arrayList[$i]['id'] = null; //會員編號
    $arrayList[$i]['name'] = null; //會員名稱
    $arrayList[$i]['email'] = $dataRead[$i]['AEA_Email'];  //email
  }
}

?>
<script>
function delSubmit(id) { //刪除function
  swal({   
    title: "確定要刪除?",   
    text: "刪除之後，記錄將直接消失！",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",   
    confirmButtonText: "Yes, delete it!",   
    closeOnConfirm: false 
  }, function(){   
    //swal("Deleted!", "Your imaginary file has been deleted.", "success"); 
    ajaxPro(id);
  });
}

function ajaxPro(mid) {
  //var URLs  = "page_index.php?pageData=adminConfig&secondURL=process&act=del";
  var URLs  = "manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/process.php";
  $.ajax({
    url: URLs,
    data: { id:mid,act:"del"},
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
          <span><?=$pageTitle;?></span>
        </div>
        <div class="clearBoth"></div>
        <div id="pageIndexWarp" class="boxWarp">
 
          <div id="newsWarp" class="boxWarp">
            <h2 class="red"><?=$pageTitle;?></h2>
            <div id="formTable">
              <div class="tableWarp">
                <table>
                  <tr>
                    <td class="num titleTxt">編號</td>
                    <td class="txt titleTxt">群組名稱</td>
                    <td class="txt titleTxt">會員名稱</td>
                    <td class="txt titleTxt">EMAIL</td>
                    <td class="btnTools">編輯</td>
                  </tr>
                  <?php
                  #群組資料
                  for($i=0;$i<count($arrayList);$i++) {
                  ?>
                  <tr>
                    <td class="num"><?=$i+1;?></td>
                    <td>
                      <h3><?= $groupName; ?></h3>
                    </td>  
                    <td>
                      <h3><?= $arrayList[$i]['name']; ?></h3>
                    </td>
                    <td>
                      <h3><?= $arrayList[$i]['email']; ?></h3>
                    </td>
                    <td>
                      <?php
                       #非會員訂閱用不到會員修改
                      if($act != "agree") { 
                      ?>
                        <button class="yellow toolsBtn" onclick="location.href='page_index.php?pageData=memberDataManager&secondURL=edit&id=<?= $arrayList[$i]['id']; ?>'">修改</button>
                      <?php
                      } //if($act != "agree") {
                      ?>
                    </td>
                  </tr>
                <?php
                } //foreach($DATAMemList as $key=>$val) {
                ?>
                </table>
              </div>
            </div>
          </div>

          <div class="pageBtnWarp">
            <ul>
              <li><button class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>'">返回列表</button></li>
            </ul>
          </div> 

        </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>