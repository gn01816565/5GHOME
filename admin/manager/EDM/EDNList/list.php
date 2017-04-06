<?php
#列出群組列表
$sqlGroupList =  "SELECT * FROM Admin_MemberGroup order by AMG_ID DESC";
$rsGroupList= $Language_db -> query($sqlGroupList);
$dataGroupList = $rsGroupList -> fetchall();

#非會員訂閱
$sqlEDMapply = "SELECT * FROM Admin_EdmApply where AEA_Status = 'Y'";
$rsEDMapply = $Language_db -> query($sqlEDMapply);
$dataEDMapply = $rsEDMapply -> fetchall();

#群組分國家
$sqlCountry = "SELECT * FROM ISO_3166_1_Cities order by I31C_ID ASC";
$rsCountry = $Config_db -> query($sqlCountry);
$dataCountry = $rsCountry -> fetchAll();
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
          <div id="toolsBar" class="boxWarp">
            <!--
            <button class="green">查詢</button>
          -->
            <button class="blue" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=add'">新增群組</button>
          </div>
          <div id="toolsBar" class="boxWarp" style="background-color: #BDE5F8;color: #00529B;">
            <i class="fa fa-info-circle"></i>
            此群組以會員為主。
          </div>
 
          <div id="newsWarp" class="boxWarp">
            <h2 class="red"><?=$pageTitle;?></h2>
            <div id="formTable">
              <div class="tableWarp">
                <table>
                  <tr>
                    <td class="num titleTxt">編號</td>
                    <td class="txt titleTxt">群組名稱</td>
                    <td class="txt titleTxt">數量</td>
                    <td class="btnTools">動作</td>
                    <td class="btnTools">編輯</td>
                    <td class="btnTools">刪除</td>
                  </tr>
                  <?php
                  
                  #群組資料
                  for($i=0;$i<count($dataGroupList);$i++) {
                  ?>
                  <tr>
                    <td class="num"><?=$i+1;?></td>
                    <td>
                      <h3><?=$dataGroupList[$i]['AMG_Name'];?></h3>
                    </td>
                    <td>
                      <h3>
                        <?php
                        #算此群組的數量
                        $sqlMappingAmount = "SELECT count(*) FROM Admin_MemberGroupMapping where AMGM_AMG_ID = '".$dataGroupList[$i]['AMG_ID']."' ";
                        $rsMappingAmount = $Language_db -> query($sqlMappingAmount);
                        $dataMappingAmount = $rsMappingAmount -> fetch();
                        echo $dataMappingAmount['count(*)'];
                        ?>
                      </h3>
                    </td>
                    <td>
                      <button class="blue toolsBtn" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=read&act=group&id=<?=$dataGroupList[$i]['AMG_ID'];?>'">查閱</button>
                    </td>
                    <td>
                      <button class="yellow toolsBtn" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=edit&act=group&id=<?=$dataGroupList[$i]['AMG_ID'];?>'">修改</button>
                    </td>
                    <td>
                      <button class="red toolsBtn" onclick='delSubmit(<?=$DATAGroupList[0]['AMG_ID'];?>)'>刪除</button>
                    </td>
                  </tr>
                <?php
                } //foreach($DATAMemList as $key=>$val) {
                ?>
                </table>
              </div>
            </div>
          </div>

          <div id="newsWarp" class="boxWarp">
            <h2 class="red">會員訂閱未分類</h2>
            <div id="formTable">
              <div class="tableWarp">
                <table>
                  <tr>
                    <td class="num titleTxt">編號</td>
                    <td class="txt titleTxt">群組名稱</td>
                    <td class="txt titleTxt">數量</td>
                    <td class="btnTools">動作</td>
                  </tr>
                  <tr>
                    <td class="num">1</td>
                    <td>
                      <h3>未分類</h3>
                    </td>
                    <td>
                      <h3>
                        <?php
                        #找出會員資料
                        //全部會員
                        $sqlMemList = "SELECT * FROM Member_AccountsData ";
                        $rsMemList = $Config_db -> query($sqlMemList);
                        $dataMemList = $rsMemList -> fetchAll();
                        //計算沒在群組中的數量
                        $noClassAmount = 0;
                        foreach($dataMemList as $key=>$val) {
                          $sqlMappingCheck = "SELECT * from Admin_MemberGroupMapping where AMGM_MAD_Num = '".$val['MAD_Num']."'";
                          $rsMappingCheck = $Language_db -> query($sqlMappingCheck);
                          $dataMappingCheck = $rsMappingCheck -> fetchAll();
                          if(count($dataMappingCheck) <= 0) { //如果沒資料，表示未分類
                            $noClassAmount++;
                          }
                        } //foreach($dataMemList as $key=>$val) {
                        echo $noClassAmount;
                        ?>
                      </h3>
                    </td>
                    <td>
                      <button class="blue toolsBtn" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=read&act=noClass'">查閱</button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>

          <div id="newsWarp" class="boxWarp">
            <h2 class="red">會員訂閱電子報地區群組</h2>
            <div id="formTable">
              <div class="tableWarp">
                <table>
                  <tr>
                    <td class="num titleTxt">編號</td>
                    <td class="txt titleTxt">國家</td>
                    <td class="txt titleTxt">數量</td>
                    <td class="btnTools">動作</td>
                  </tr>
                  <?php
                  #列出資料庫有多少國家
                  for($i=1;$i<count($dataCountry);$i++) {
                  ?>
                  <tr>
                    <td class="num"><?= $i; ?></td>
                    <td>
                      <h3><?= $dataCountry[$i]['I31C_TwName']; ?></h3>
                    </td>
                    <td>
                      <h3>
                        <?php
                        $countryAmount = 0; //總數
                        #找企業會員
                        $sqlMemC = "SELECT count(*) FROM Member_AccountsDataCompany WHERE MADC_Country = '".$dataCountry[$i]['I31C_Code']."' ";
                        $rsMemC = $Config_db -> query($sqlMemC);
                        $dataMemC = $rsMemC -> fetch();
                        $countryAmount = ($countryAmount+$dataMemC['count(*)']); 
                        #找一般會員
                        $sqlMemG = "SELECT count(*) FROM Member_AccountsDataGeneral where MADG_Country = '".$dataCountry[$i]['I31C_Code']."' ";
                        $rsMemG = $Config_db -> query($sqlMemG);
                        $dataMemG = $rsMemG -> fetch();
                        //加總數量
                        $countryAmount = ($countryAmount + $dataMemG['count(*)']);
                        echo $countryAmount;
                        ?>
                      </h3>
                    </td>
                    <td>
                      <button class="blue toolsBtn" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=read&act=country&id=<?= $dataCountry[$i]['I31C_Code']; ?>'">查閱</button>
                    </td>
                  </tr>
                  <?php
                  } //for($i=1;$i<=count($dataCountry);$i++) {
                  ?>
                </table>
              </div>
            </div>
          </div>

          <div id="newsWarp" class="boxWarp">
            <h2 class="red">非會員訂閱電子報信箱</h2>
            <div id="formTable">
              <div class="tableWarp">
                <table>
                  <tr>
                    <td class="num titleTxt">編號</td>
                    <td class="txt titleTxt">群組名稱</td>
                    <td class="txt titleTxt">數量</td>
                    <td class="btnTools">動作</td>
                  </tr>
                  <tr>
                    <td class="num">1</td>
                    <td>
                      <h3>非會員訂閱</h3>
                    </td>
                    <td>
                      <h3><?= count($dataEDMapply); ?></h3>
                    </td>
                    <td>
                      <button class="blue toolsBtn" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=read&act=agree'">查閱</button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>

        </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>