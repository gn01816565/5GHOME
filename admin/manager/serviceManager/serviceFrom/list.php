<?php
#post、get過來的參數
foreach($_GET as $key=>$val) {
  $$key=$val;
}
foreach($_POST as $key=>$val) {
  $$key=$val;
}

$sqlPlus = ""; //sql語法
$getURL = ""; //用在換頁用的get語法上
if($serviceType) { //問題種類
  $sqlPlus .= "AND ACSF_Type LIKE '".$serviceType."'";
  $getURL .= "&serviceType=".$serviceType;
}
if($status) { //處理狀況
  $sqlPlus .= "AND ACSF_Status LIKE '".$status."'";
  $getURL .= "&status=".$status;
}

#換頁所需要資訊
$page = isset($_GET['page'])?$_GET['page']:1 ; //當頁頁碼
$read_num = 10; //當頁觀看數量
$star_num = $read_num*($page-1); //開始讀取資料行數

#搜尋出所屬資料全部的數量
#資料庫、資料表
//$all_num = allTableNum($Language_db,'Admin_CustomerServiceForm'); 
$sqlPage = "select count(*) from Admin_CustomerServiceForm 
            where 1 = 1
            $sqlPlus
           ";
$rsPage = $Language_db -> query($sqlPage);
$dataPage = $rsPage -> fetch();           
$all_num = $dataPage['count(*)']; //列出目前資料數量

$pageAll_num = ceil($all_num / $read_num); //頁碼數計算，全部數量/讀取數量 


#列出紀錄資料
$sqlContent = "SELECT * FROM Admin_CustomerServiceForm 
               WHERE 1 = 1
               $sqlPlus
               ORDER BY ACSF_ID DESC 
               limit $star_num, $read_num
              ";
$rsContent = $Language_db->query($sqlContent);
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
            <form method="post" action="#">
                <select name="serviceType" style='float:left;height: 34px;background-color: #fff;margin-left:5px;'>
                  <option value="0">請選擇問題種類</option>
                  <option value="shop" <?php if($serviceType == 'shop') { echo "selected"; } ?>>購物問題</option>
                  <option value="inquiry" <?php if($serviceType == 'inquiry') { echo "selected"; } ?>>詢價問題</option>
                  <option value="order" <?php if($serviceType == 'order') { echo "selected"; } ?>>訂單問題</option>
                  <option value="complaints" <?php if($serviceType == 'complaints') { echo "selected"; } ?>>客訴問題</option>
                  <option value="product" <?php if($serviceType == 'product') { echo "selected"; } ?>>產品問題</option>
                  <option value="other" <?php if($serviceType == 'other') { echo "selected"; } ?>>其他問題</option>
                  <option value="account" <?php if($serviceType == 'account') { echo "selected"; } ?>>帳號問題</option>
                </select>
                <select name="status" style='float:left;height: 34px;background-color: #fff;margin-left:5px;'>
                  <option value="0">請選擇問題狀況</option>
                  <option value="N" <?php if($status =='N') { echo "selected"; }  ?>>未處理</option>
                  <option value="Y" <?php if($status =='Y') { echo "selected"; }  ?>>已處理</option>
                </select>
                <input type="submit" class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>'" value="查詢" style='width:50px;border-radius:5px;line-height: 32px;margin:2px 0px 0px 5px;'>
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
          
          <!--
          <div id="toolsBar" class="boxWarp">
            <button class="blue" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=add'">新增主類別</button>
          </div>
          -->
          <div id="newsWarp" class="boxWarp">
            <h2 class="red"><?=$pageTitle;?></h2>
            <div id="formTable">
              <div class="tableWarp">
                <table>
                  <tr>
                    <td class="num titleTxt">編號</td>
                    <td class="txt titleTxt">時間</td>
                    <td class="txt titleTxt">問題種類</td>
                    <td class="txt titleTxt">姓名</td>
                    <td class="btnTools">狀態</td>
                    <td class="btnTools">功能</td>
                    <td class="btnTools">刪除</td>
                  </tr>
                  <?php
                  for($i=0;$dataContent = $rsContent->fetch();$i++) {
                  ?>
                  <tr>
                    <td class="num"><?=$i+1;?></td>
                    <td>
                      <h3>
                        <?=substr($dataContent['ACSF_CreateTime'],0,10);?>
                      </h3>
                    </td>
                    <td>
                      <h3>
                        <?php
                        echo serviceType($dataContent['ACSF_Type']);
                        ?>
                      </h3>
                    </td>
                    <td>
                      <h3>
                        <?=$dataContent['ACSF_Name'];?>
                      </h3>
                    </td>
                    <td>
                      <h3>
                        <?php
                        if($dataContent['ACSF_Status']=='N') {
                          echo "<text style='color:red'>未處理</text>";
                        } else {
                          echo "<text style='color:blue'>已處理</text>";
                        }
                        ?>
                      </h3>
                    </td>
                    <td>
                      <button class="yellow toolsBtn" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=read&id=<?=$dataContent['ACSF_ID'];?>'">查閱</button>
                    </td>
                    <td>
                      <button class="red toolsBtn" onclick='delSubmit(<?=$dataContent['ACSF_ID'];?>)'>刪除</button>
                    </td>
                  </tr>
                  <?php
                  } //for($i=0;$dataAIN = $rsAIN->fetch();$i++) {
                  ?>

                </table>
              </div>
            </div>

          </div>
          <!--頁碼區塊 -->
          <?php
          pageNumList($_GET['pageData'].$getURL, $pageAll_num, $page, $read_num); 
          ?>
        <!--<div id="pageNumBox">頁碼區塊-->  
        </div>
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>