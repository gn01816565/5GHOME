<?php

foreach($_GET as $key=>$val) {
  $$key=$val;
}

foreach($_POST as $key=>$val) {
  $$key=$val;
}

//給變數一個值 
$list_dateSort = "";

//先代入頁面代號
$URLplus = '?pageData='.$pageData; //跳頁所帶參數
$sqlPlus = ' '; //資料庫語法
$sqlStatus = ''; //資料庫狀態
$sqlSC = ''; //資料庫順序

if(isset($searchSAD)) { //查詢供應商帳號
  $sqlPlus .= " AND SF_SAD_ID = '".$searchSAD."'";
  $URLplus .= "&searchSAD=".$searchSAD;
}

if(isset($searchFraction)) { //查詢評分
  //$sqlPlus .= " AND SF_SAD_ID = '".$searchSAD."'";
}

#日期標題排序, css顯示箭頭用
if(isset($_GET['list_dateSort'])) {
  #日期所帶參數
  $list_dateSort = $_GET['list_dateSort']; //抓取變數
  if($list_dateSort == 'asc') {
    //順序
    $css_dataStyle = "fa-caret-up"; //css icon
    $sqlStatus= "SF_Date";
    $sqlSC = "ASC";
  } else if($list_dateSort == 'desc') {
    //逆序
    $css_dataStyle = "fa-caret-down"; //css icon
    $sqlStatus = "SF_Date";
    $sqlSC = "DESC";
  } else {
    //預設
    $css_dataStyle = "fa-caret-down"; //css icon
    $sqlStatus = "SF_Date";
    $sqlSC = "DESC";
  }
} else { //預設
  $css_dataStyle = "fa-caret-down";
  //$sqlOrder .= ",SF_Date DESC";
  $sqlStatus = "SF_ID";
  $sqlSC = "DESC";
}

#評分總分數排序


#列出全部的供應商資料
$sqlSAD = "select * from Supplier_AccountData order by SAD_ID DESC";
$rsSAD = $Config_db -> query($sqlSAD);
$dataSAD = $rsSAD -> fetchAll();

#換頁所需要資訊
$page = isset($_GET['page'])?$_GET['page']:1 ; //當頁頁碼
$read_num = 10; //當頁觀看數量
$star_num = $read_num*($page-1); //開始讀取資料行數

#搜尋出所屬資料全部的數量
#資料庫、資料表
$sqlPage = "SELECT count(*)  FROM Supplier_Fraction  
            where SF_ID != '' 
            $sqlPlus
           ";     
$rsPage = $Language_db->query($sqlPage);
$dataPage = $rsPage->fetch();
$all_num = $dataPage['count(*)'];

$pageAll_num = ceil($all_num / $read_num); //頁碼數計算，全部數量/讀取數量 

#列出紀錄資料
$sqlContent = "SELECT *, $sqlStatus AS sort 
               FROM Supplier_Fraction 
               left join Supplier_OrderTitle
               on  Supplier_Fraction.SF_SOT_OrderNum = Supplier_OrderTitle.SOT_OrderNum
               where 1=1
               $sqlPlus
               ORDER BY sort  ".$sqlSC." 
               limit $star_num, $read_num
              ";
$rsContent = $Language_db->query($sqlContent);
$dataContent = $rsContent->fetchAll();

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
            <form method="get" action="page_index.php">
              <input type="hidden" name="pageData" value="<?=$_GET['pageData'];?>">
              <select name="searchSAD" style='float:left;height: 34px;background-color: #fff;margin-left:5px;'>
                <option value="0">查詢供應商</option>
                <?php
                foreach($dataSAD as $key=>$val) {
                  echo "<option value='".$val['SAD_ID']."'";

                  if(isset($_GET['searchSAD'])) {
                    if($_GET['searchSAD'] == $val['SAD_ID']) {
                      echo " selected ";
                    }
                  }

                  echo ">";
                  echo sadAccountSearch($Config_db, $val['SAD_ID']);
                  echo "</option>";
                }
                ?>
              </select>
              <!--
              <select name="searchFraction" style='float:left;height: 34px;background-color: #fff;margin-left:5px;'>
                <option value="0">查詢總評分</option>
                <?php
                for($i=1;$i<=5;$i++) {
                  echo "<option value='".$i."'";
                  if($searchFraction == $i) {
                    echo " selected ";
                  }
                  echo ">";
                  echo $i;
                  echo "</option>";
                }
                ?>
              </select>
              -->
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
                    <td class="txt titleTxt">
                      <?php
                      if(isset($_GET['list_dateSort'])) {
                        $list_dateSort = $_GET['list_dateSort'];
                        if($list_dateSort == 'asc') { //順序，連結為逆序
                          echo '<a href="'.$URLplus.'&list_dateSort=desc" style="display: inline;">日期</a>';
                          $URLplus .= "&list_dateSort=".$list_dateSort; //跳頁用, 連結參數
                        } else { //逆序，連結為順序
                          echo '<a href="'.$URLplus.'&list_dateSort=asc" style="display: inline;">日期</a>';
                          $URLplus .= "&list_dateSort=".$list_dateSort; //跳頁用, 連結參數
                        }
                      } else {
                        echo '<a href="'.$URLplus.'&list_dateSort=asc" style="display: inline;">日期</a>';
                        $URLplus .= "&list_dateSort=".$list_dateSort; //跳頁用, 連結參數
                      }

                      ?>
                      <i class="fa <?=$css_dataStyle;?>" aria-hidden="true"></i>
                    </td>
                    <td class="txt titleTxt">評分訂單</td>
                    <td class="txt titleTxt">會員姓名</td>
                    <td class="txt titleTxt">評分總分數</td>                      
                    <td class="btnTools">動作</td>
                    <td class="btnTools">刪除</td>
                  </tr>
                  <?php
                  $i=0;
                  //for($i=0;$dataContent = $rsContent->fetch();$i++) {
                  foreach($dataContent as $key => $val) {
                  ?>
                  <tr>
                    <td class="num"><?=$i+1;?></td>
                    <td>
                      <h3>
                        <?=substr($val['SF_Date'],0,10);?>
                      </h3>
                    </td>
                    <td>
                      <h3>
                        <?=$val['SOT_OrderNumCode'];?>
                      </h3>
                    </td>
                    <td>
                      <h3>
                        <?=memberNameSearch($Config_db, $val['SF_MAD_ID']);?>
                      </h3>
                    </td>
                    <td>
                      <h3>
                        <?php
                        $totalFraction = ($val['SF_Fraction1'] + $val['SF_Fraction2'] + $val['SF_Fraction3'] + $val['SF_Fraction4'] + $val['SF_Fraction5'])/5;
                        echo $totalFraction;
                        ?>
                      </h3>
                    </td>
                    <td>
                      <button class="yellow toolsBtn" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=read&id=<?=$val['SF_ID'];?>'">查閱 </button>
                    </td>
                    <td>
                      <button class="red toolsBtn" onclick='delSubmit(<?=$val['SF_ID'];?>)'>刪除</button>
                    </td>
                  </tr>
                  <?php
                  $i++;
                  } //for($i=0;$dataContent = $rsContent->fetch();$i++) {
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