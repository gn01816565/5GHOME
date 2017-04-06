<?php
  #宣告參數
  foreach($_POST as $key=>$val) {
    $$key=$val;
  }
  #宣告GET參數
  foreach($_GET as $key=>$val) {
    $$key=$val;
  }

  $sqlPlus = " "; //資料庫語法加入
  $stringPlus = " "; //字串顯示
  /*
  if($act =='search') {
    if($type) { //會員類型
      $sqlPlus .= " AND MAD_Type = '".$type."'";
      $searchArray['MAD_Type'] = $type; //頁碼需要
      $stringPlus .= ($type=='general')?"一般會員":"企業會員"."、"; //顯示搜尋條件
    }
    if($check) { //驗證狀態
      $sqlPlus .= " AND MAD_AcCheck = '".$check."'";
      $searchArray['MAD_AcCheck'] = $check; //頁碼需要
      $stringPlus .= ($check=='Y')?"已驗證":"未驗證"."、"; //顯示搜尋條件
    }
    if($account) { //驗證狀態
      $sqlPlus .= " AND MAD_Account = '".$account."'";
      $searchArray['MAD_Account'] = $account; //頁碼需要
      $stringPlus .=  $account."、"; //顯示搜尋條件
    }
    $all_num = allTableNum($Config_db,'Member_AccountsData'); 

  } else {
    $all_num = allTableNum($Config_db,'Member_AccountsData'); 
  }
  */
  if(isset($searchType)) { //會員類型
    $sqlPlus .= " AND MAD_Type = '".$searchType."'";
    $searchArray['MAD_Type'] = $type; //頁碼需要
  }
  if(isset($check)) { //驗證狀態
    $sqlPlus .= " AND MAD_AcCheck = '".$check."'";
    $searchArray['MAD_AcCheck'] = $check; //頁碼需要
  }
  if(isset($account)) { //驗證狀態
    $sqlPlus .= " AND MAD_Account like '%".$account."%'";
    $searchArray['MAD_Account'] = $account; //頁碼需要
  }

  #換頁所需要資訊
  $page = isset($_GET['page'])?$_GET['page']:1 ; //當頁頁碼
  $read_num = 10; //當頁觀看數量
  $star_num = $read_num*($page-1); //開始讀取資料行數

  #搜尋出所屬資料全部的數量
  #資料庫、資料表
  $sqlPage = "select count(*) FROM Member_AccountsData WHERE 1=1 $sqlPlus";
  $rsPage = $Config_db -> query($sqlPage);
  $dataPage = $rsPage -> fetch();

  $all_num = $dataPage['count(*)']; //資料總數量
  $pageAll_num = ceil($all_num / $read_num); //頁碼數計算，全部數量/讀取數量 

  #列出紀錄資料
  $sqlContent = "SELECT * 
                 FROM Member_AccountsData 
                 WHERE MAD_ID != '' 
                 $sqlPlus 
                 ORDER BY MAD_ID DESC 
                 LIMIT $star_num, $read_num";
  $rsContent = $Config_db->query($sqlContent);
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
          <!--
          <div id="toolsBar" class="boxWarp">
            <button class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=search'">查詢</button>
          </div>
          -->
          <?php
            #列出搜尋條件
          /*
            if($act =='search') {
          ?>
          <div id="toolsBar" class="boxWarp" style="background-color: #BDE5F8;color: #00529B;">
            <i class="fa fa-info-circle"></i>
            搜尋條件為：<?=$stringPlus;?>
          </div> 
          <?php
            } //if($act =='search') {
            */
          ?>
          <form method="post" action="#">
            <div id="toolsBar" class="boxWarp">
              <select name="searchType" style='float:left;height: 34px;background-color: #fff;'>
                <option value="0">查詢會員類型</option>
                <option value="general" <?php if($searchType == 'general') { echo "selected"; } ?>>一般會員</option>
                <option value="company" <?php if($searchType == 'company') { echo "selected"; } ?>>公司會員</option>
              </select>

              <select name="check" style='float:left;height: 34px;background-color: #fff;margin-left:5px;'>
                <option value="0" >帳號驗證狀態</option>
                <option value="Y" <?php if($check == 'Y') { echo "selected"; } ?>>是</option>
                <option value="N" <?php if($check == 'N') { echo "selected"; } ?>>否</option>
              </select>

              <input type="text" name="account" placeholder="會員帳號" style='float:left;line-height: 22px;border: 1px solid #e1e1e1;margin-left:5px;border-radius:5px;padding:5px;' value="<?php if(isset($account)) { echo $account; };?>">
              <input type="hidden" name="act" value="search">
              <input type="submit" class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=search'" value="查詢" style='width:50px;border-radius:5px;line-height: 32px;margin:2px 0px 0px 5px;'>
            </div>
          </form>

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
                    <td class="txt titleTxt" style='width:100px;'>類型</td>
                    <td class="txt titleTxt" style='width:100px;'>姓名</td>
                    <td class="txt titleTxt">帳號</td>
                    <td class="txt titleTxt" style='width:100px;'>國家</td>
                    <td class="txt titleTxt" style='width:100px;'>編輯</td>
                    <td class="btnTools" style='width:100px;'>刪除</td>
                  </tr>
                  <?php
                    for($i=0;$dataContent = $rsContent->fetch();$i++) {
                      #資料表確認
                      $mTable="";
                      if($dataContent['MAD_Type']=='company') {//公司會員
                        $mTable = "Member_AccountsDataCompany";
                        $mTitle = "MADC";
                        $editGo = "C";
                      } else { //個人會員
                        $mTable = "Member_AccountsDataGeneral";
                        $mTitle = "MADG";
                        $editGo = "G";
                      }

                      #列出會員資料
                      $sqlMdata = "SELECT * 
                                   FROM $mTable 
                                   WHERE ".$mTitle."_MAD_Num ='".$dataContent['MAD_Num']."'";
                      $rsMdata = $Config_db->query($sqlMdata);
                      $dataMdata = $rsMdata->fetch();
                  ?>
                  <tr>
                    <td class="num"><?=$i+1;?></td>
                    <td>
                      <h3>
                        <?php
                          if($dataContent['MAD_Type']=='company') {
                            echo "公司會員";
                          } else {
                            echo "一般會員";
                          }
                        ?>
                      </h3>
                    </td>
                    <td>
                      <h3>
                        <?php 
                          echo $dataMdata[$mTitle.'_Name'];
                        ?>
                      </h3>
                    </td>
                    <td>
                      <h3>
                        <?php 
                          echo $dataContent['MAD_Account'];
                        ?>
                      </h3>
                    </td>
                    <td>
                      <h3>
                        <?php
                          $sqlCity = "SELECT * 
                                      FROM  ISO_3166_1_Cities 
                                      WHERE I31C_Code = '".$dataMdata[$mTitle.'_Country']."'";
                          $rsCity = $Config_db->query($sqlCity);
                          $dataCity = $rsCity->fetch();
                          echo $dataCity['I31C_TwName'];
                        ?>
                      </h3>
                    </td>
                    <td>
                      <button type="button" class="yellow toolsBtn" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=edit<?=$editGo;?>&id=<?=$dataContent['MAD_Num'];?>'">修改</button>
                    </td>
                    <td>
                      <button type="button" class="red toolsBtn" onclick='delSubmit("<?=$dataContent['MAD_Num'];?>")'>刪除</button>
                    </td>
                  </tr>
                  <?php
                    } //end for($i=0;$dataContent = $rsContent->fetch();$i++)
                  ?>
                </table>
                <div style="text-align:center;">
                  <div id="pageSwap" style="margin:0 auto; width:400px;"></div>
                </div>
              </div><!--tableWarp-->
            </div><!--formTable-->
          </div><!--newsWarp-->
          <!--頁碼區塊 -->
          <?php
          //當前頁面代號、全部頁碼、當前頁碼、讀取頁數
          pageNumList($_GET['pageData'], $pageAll_num, $page, $read_num); 
          ?>
        </div><!--pageIndexWarp-->
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>