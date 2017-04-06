<?php
#判斷是否有搜尋值
$sqlPlus = " "; //sql語法搜詢值
$searchType = isset($_GET['searchType'])?$_GET['searchType']:$_POST['searchType']; //接收詢價狀態
$searchNum = isset($_GET['searchNum'])?$_GET['searchNum']:$_POST['searchNum']; //接收詢價單號

if($searchType) { //詢價狀態
  $sqlPlus .= " AND AOIL_ProStatus like '".$searchType."'";
}
if($searchNum) { //詢價單號
  $sqlPlus .= " AND AOIL_InquiryNum like '".$searchNum."'";
}

#換頁所需要資訊
$page = isset($_GET['page'])?$_GET['page']:1 ; //當頁頁碼
$read_num = 10; //當頁觀看數量
$star_num = $read_num*($page-1); //開始讀取資料行數

#搜尋出所屬資料全部的數量
#資料庫、資料表
//$all_num = allTableNum($Language_db,'Admin_OrderInquiryList'); 
$sqlPage = "select count(*) FROM Admin_OrderInquiryList where 1 = 1 $sqlPlus";
$rsPage = $Language_db -> query($sqlPage);
$dataPage = $rsPage -> fetch();

$all_num = $dataPage['count(*)']; //資料總數量
$pageAll_num = ceil($all_num / $read_num); //頁碼數計算，全部數量/讀取數量 

#列出紀錄資料
$sqlContent = "SELECT * FROM Admin_OrderInquiryList where 1 = 1 $sqlPlus ORDER BY AOIL_ID DESC  limit $star_num, $read_num";
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

          <form method="post" action="#">
            <div id="toolsBar" class="boxWarp">
              <select name="searchType" style='float:left;height: 34px;background-color: #fff;'>
                <option value="0">請選擇詢價單狀態</option>
                <option value="noProcess" <?php if($searchType=='noProcess') { echo "selected"; } ?>>未處理</option>
                <option value="transfer" <?php if($searchType=='transfer') { echo "selected"; } ?>>已轉發供應商</option>
                <option value="quoted" <?php if($searchType=='quoted') { echo "selected"; } ?>>已報價</option>
                <option value="buy" <?php if($searchType=='buy') { echo "selected"; } ?>>已下訂結案</option>
              </select>
              <input type="text" name="searchNum" placeholder="詢價單編號" style='float:left;line-height: 22px;border: 1px solid #e1e1e1;margin-left:5px;border-radius:5px;padding:5px;' value="<?=$searchNum;?>">
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
                  <td class="txt titleTxt" style="width:150px;">詢價單號</td>
                  <td class="txt titleTxt" style="width:150px;">預覽圖</td>
                  <td class="txt titleTxt" style="width:150px;">詢價者</td>
                  <td class="txt titleTxt" style="width:150px;">處理狀態</td>
                  <!--
                  <td class="txt titleTxt" style="width:90px;">檢視</td>
                  <td class="txt titleTxt" style="width:90px;">供應商動作</td>
                  <td class="txt titleTxt" style="width:90px;">修改</td>
                  <td class="txt titleTxt" style="width:90px;">回覆會員</td>
                  -->
                  <td class="txt titleTxt" style="width:90px;">刪除</td>
                </tr>
                <?php
                
                for($i=0;$dataContent = $rsContent->fetch();$i++) {
                ?>
                <tr>
                 
                  <td class="num"><?=$i+1;?></td>
                  <td>
                    <h3>
                      <a href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=read&id=<?=$dataContent['AOIL_InquiryNum'];?>'>
                      <?php
                        echo $dataContent['AOIL_InquiryNum'];
                      ?>
                      </a>
                    </h3>
                  </td>
                  <td>
                    <a href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=read&id=<?=$dataContent['AOIL_InquiryNum'];?>'>
                    <?php
                    #查看是否有參考產品
                    $SQLreferPro = "SELECT * FROM Admin_OrderInquiryProduct where AOIP_AOIL_InquiryNum = '".$dataContent['AOIL_InquiryNum']."' ORDER BY AOIP_ID ASC limit 0,1";
                    $RSreferPro = $Language_db->query($SQLreferPro);
                    $DATAreferPro = $RSreferPro->fetch();
                    if($DATAreferPro['AOIP_ReferProduct']) { //如果有參考商品的話，則列出參考商品的第一個圖
                      $SQLPro = "SELECT * FROM Supplier_ProductImage where SPI_SPD_PID = '".$DATAreferPro['AOIP_ReferProduct']."' AND SPI_Sort = '1'";
                      $RSPro = $Language_db->query($SQLPro);
                      $DATAPro = $RSPro -> fetch();
                      $proImg = $DATAPro['SPI_Image']; //檔案名稱
                      #找出檔案路徑
                      $sadArray = fiveSadAccountSearch($Config_db, $DATAreferPro['AOIP_ReferSupplier']); //找出供應商ac
                      echo "<img src='../images/supplier/".$sadArray[1]."/product/titleImage/".$proImg."'>";
                    }
                    ?>
                    </a>
                  </td>
                  <td>
                    <h3>
                      <a href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=read&id=<?=$dataContent['AOIL_InquiryNum'];?>'>
                        <?=$dataContent['AOIL_Name'];?>
                      </a>
                    </h3>
                  </td>
                  <!--
                  <td>
                    <h3>
                      <?= substr($dataContent['AOIL_CreateDate'],0,10);?>
                    </h3>
                  </td>
                  -->
                  <td>
                    <h3>
                      <a href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=read&id=<?=$dataContent['AOIL_InquiryNum'];?>'>
                      <?php
                      
                      switch($dataContent['AOIL_ProStatus']) {
                        case 'noProcess': 
                          echo "<span class='red' style='padding:5px 30px 5px 30px;'>未處理</span>";
                          break;
                        case 'transfer': 
                          echo "<span class='yellow' style='padding:5px 16px 5px 16px;'>轉發供應商</span>";
                          break;
                        case 'quoted': 
                          echo "<span style='padding:5px 30px 5px 30px;border-style:solid;border-width:1px;font-weight:bold;'>已報價</span>";
                          break;
                        case 'buy': 
                          echo "<span class='blue' style='padding:5px 16px 5px 16px;'>已下訂結案</span>";
                          break;
                        case 'closed': 
                          echo "<span class='red2' style='padding:5px 16px 5px 16px;'>未下訂結案</span>";
                          break;     
                        default:  
                          echo "<span style='padding:5px 16px 5px 16px;border-style:solid;border-width:1px;font-weight:bold;border-color:#b83b35;color:#b83b35;'>非會員詢價</span>";
                          break;
                      }
                      ?>
                      </a>
                    </h3>
                  </td>   
                  <!--
                  <td>
                    <button class="yellow toolsBtn" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=read&id=<?=$dataContent['AOIL_InquiryNum'];?>'">檢視</button>
                  </td>
                  <td>
                    <button class="blue toolsBtn" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=send&id=<?=$dataContent['AOIL_InquiryNum'];?>'">轉發</button>
                  </td>
                  <td>
                    <button class="green toolsBtn" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=edit&id=<?=$dataContent['AOIL_InquiryNum'];?>'">修改</button>
                  </td>
                  <td>
                    <button class="red2 toolsBtn" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=sendM&id=<?=$dataContent['AOIL_InquiryNum'];?>'">回覆</button>
                  </td>
                  -->
                  <td>
                    <button class="red toolsBtn" onclick='delSubmit("<?=$dataContent['AOIL_InquiryNum'];?>")'>刪除</button>
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
          //當前頁面代號、全部頁碼、當前頁碼、讀取頁數
          pageNumList($_GET['pageData'], $pageAll_num, $page, $read_num); 
          ?>
          <!--
          <div id="pageNumBox">
            <div class="pageNumWarp">
              <a href="page_index.php?pageData=<?=$_GET['pageData'];?>&page=<?=$page!=1?$page-1:$page;?>" title="上一頁" class="btnPrev">上一頁</a>
              <span class="pageNum">
                <?php
                
                #中心點比例，左距5，右距4
                $plusNum = 0; //開始頁碼
                
                #顯示頁碼數
                if($page+4>=$pageAll_num) {
                  $read_page = $pageAll_num;  //最後頁碼
                  if($pageAll_num-10>0) {
                    $plusNum = $pageAll_num-10; //開始頁碼
                  }
                } else {
                  $read_page=10; //頁碼顯示為10頁，過10頁則跑...，並顯示最後一頁
                  if($page>6 && $pageAll_num>10) { //讓頁碼取值在中間
                    $plusNum = $page-6; //開始頁碼
                  }
                }

                for($i=(1+$plusNum);$i<=$read_page;$i++) {
                ?>
                  <a href="page_index.php?pageData=<?=$_GET['pageData'];?>&page=<?=$i;?>" <?=$page==($i)?"class='pageNumHold'":"";?> title="P：<?=$i;?>"><?=$i;?></a>
                <?php
                } //for($i=0;$i<$page_num;$i++) {

                if($all_num>10 && $read_page!=$pageAll_num){
                ?>
                  <span>...</span>
                  <a href="page_index.php?pageData=<?=$_GET['pageData'];?>&page=<?=$all_num?>" title="P：<?=$all_num;?>"><?=$all_num;?></a>
                <?php
                } //if($all_num>10){
                ?>
              </span>
              <a href="page_index.php?pageData=<?=$_GET['pageData'];?>&page=<?=$page!=$pageAll_num?$page+1:$page;?>" title="下一頁" class="btnNext">下一頁</a>
            </div>
          </div>
          -->
        </div>
        <!--<div id="pageNumBox">頁碼區塊-->
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

<!--供應商資料列出-->
<div id="refundDialog" title="Create new user" style="display:none;">
  <p class="validateTips">All form fields are required.</p>
  <form>
    <fieldset>
      <label for="name">Name</label>
      <input type="text" name="name" id="name" value="Jane Smith" class="text ui-widget-content ui-corner-all">
      <label for="email">Email</label>
      <input type="text" name="email" id="email" value="jane@smith.com" class="text ui-widget-content ui-corner-all">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" value="xxxxxxx" class="text ui-widget-content ui-corner-all">
 
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>
