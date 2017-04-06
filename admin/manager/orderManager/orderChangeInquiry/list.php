<?php
#接收post資料，並轉換成參數
foreach($_POST as $key=>$val) {
  $$key=$val;
}
#接收get資料，並轉換成參數
foreach($_GET as $key=>$val) {
  $$key=$val;
}

//付款狀態
function switchPay($pay) {
  $returnStr = ""; //回傳狀態字串
  switch($pay) {
    case 'Y':
      $returnStr = "<span class='blue' style='padding:5px 13px 5px 13px;'>已付款<span>";
      break;
    case 'N':
      $returnStr = "<span class='red' style='padding:5px 13px 5px 13px;'>未付款</span>";
      break;      
    default:
      $returnStr = "N";
  }
  return $returnStr;
}

$SQLplus = ""; //資料庫語法
$URLplus = ""; //換頁所需參數
$pageURLstatus = ""; //連結 get 參數，訂單狀態
$pageURLpay = ""; //連結 get 參數，付款方式
$pageURLfre = ""; //連結 get 參數，運費

if($status) { //訂單狀態，有值的話 
  $SQLplus .= " AND SOT_OrderStatus = '".$status."' ";
  $URLplus .= "&status=".$status; //路徑
  //$pageURLstatus = "&status=".$status;
}

if($productStatusPayment) { //付款方式，有值的話
  $SQLplus .= " AND SOT_ProductStatus = '".$productStatusPayment."' ";
  $URLplus .= "&productStatusPayment=".$productStatusPayment; //路徑
  //$pageURLpay = "&productStatusPayment=".$productStatusPayment;
}

if($freight) { //運費付款狀態
  $SQLplus .= " AND SOT_Freight = '".$freight."' ";
  $URLplus .= "&freight=".$freight; //路徑
  //$pageURLfre = "&freight=".$freight;
}

if($orderNum) { //訂單編號明碼
  $SQLplus .= " AND SOT_OrderNumCode LIKE '".$orderNum."' ";
  $URLplus .= "&orderNum=".$orderNum; //路徑
  //$pageURLfre = "&freight=".$freight;
}

if($supplier) { //供應商名稱
  #從供應商id找出訂單編號，再從訂單找出資料
  $SQLsupplier = "SELECT * FROM Supplier_OrderStatus where SOS_SAD_ID = '".$supplier."'";
  $RSsupplier = $Language_db ->  query($SQLsupplier);
  $DATAsupplier = $RSsupplier -> fetchall();
  $sNum = count($DATAsupplier); //要列出來的訂單總數

  if($sNum > 0) { //有找到供應商訂單
    $SQLplus .= "AND (";
    $si = 0;  //算陣列筆數
    
    foreach($DATAsupplier as $key=>$val) {
      $SQLplus .= " SOT_OrderNum LIKE '".$val['SOS_SOT_OrderNum']."' ";
      if($si == ($sNum-1)) { //最後一筆不加 OR
        break;
      } else {
        $SQLplus .= " OR ";
      }
      $si++;
    } //foreach($DATAsupplier as $key=>$val) {
    $SQLplus .= ")";
  } else { // 沒找到供應商訂單
    $SQLplus .= " AND SOT_OrderNum LIKE '123' "; //給資料欄位一筆搜尋不到的資料
  } //if($sNum > 0) { //有找到供應商訂單
} //if($supplier) {

#換頁所需要資訊
$_GET['page'] = isset($_GET['page'])?$_GET['page']:1 ; //當頁頁碼
$page = isset($_GET['page'])?$_GET['page']:1 ; //當頁頁碼
$read_num = 10; //當頁觀看數量
$star_num = $read_num*($page-1); //開始讀取資料行數

#搜尋出所屬資料全部的數量
#資料庫、資料表
//$all_num = allTableNum($Language_db,'Supplier_OrderTitle'); 
$SQLpageNum = "SELECT count(*)
               FROM Admin_OrderChangeInquiryTitle
               WHERE 1 = 1
               $SQLplus";
$RSpageNum = $Language_db->query($SQLpageNum);
$DATApageNum = $RSpageNum->fetch();
$all_num = $DATApageNum['count(*)']; //目前資料行列
$pageAll_num = ceil($all_num / $read_num); //頁碼數計算，全部數量/讀取數量 

#列出紀錄資料
$sqlContent = "SELECT * 
               FROM Admin_OrderChangeInquiryTitle
               WHERE 1 = 1
               $SQLplus
               ORDER BY AOCIT_ID DESC 
               LIMIT $star_num, $read_num";
$rsContent = $Language_db->query($sqlContent);


//搜詢資訊
#列出全部供應商
$SQLsupplierData = "SELECT * FROM Supplier_AccountData ORDER BY SAD_ID DESC ";
$RSsupplierData = $Config_db->query($SQLsupplierData);
$DATAsupplierData = $RSsupplierData->fetchAll(PDO::FETCH_ASSOC); 

//列出供應商名稱
foreach($DATAsupplierData as $key=>$val){
  $arraySupplierName[$val['SAD_ID']] = sadAccountSearch($Config_db,$val['SAD_ID']);
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
      //alert(xhr.status);
      //alert(thrownError);
      alert(xhr.responseText);
      //alert('更新失敗!');
    }
  });
}
function closeTab() {
  $('#titleWarning').hide(1000);
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
            <button class="red" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>'">清除查詢條件</button>
          </div>
          -->
          <div id="toolsBar" class="boxWarp">
            <form method="post" action="#">
              <select name="productStatusPayment" style='float:left;height: 34px;background-color: #fff;margin-left:5px;'>
                <option value="0">請選擇商品結帳狀態</option>
                <option value="N" <?php if($productStatusPayment=='N') { echo "selected"; }  ?>>未付款</option>
                <option value="Y" <?php if($productStatusPayment=='Y') { echo "selected"; }  ?>>已付款</option>
              </select>
              <select name="freight" style='float:left;height: 34px;background-color: #fff;margin-left:5px;'>
                <option value="0">請選擇運費付款狀態</option>
                <option value="N" <?php if($freight=='N') { echo "selected"; }  ?>>未付款</option>
                <option value="Y" <?php if($freight=='Y') { echo "selected"; }  ?>>已付款</option>
              </select>
              <input type="text" name="orderNum" placeholder="訂單編號" style='float:left;line-height: 32px;border: 1px solid #e1e1e1;margin-left:5px;border-radius:5px;' value="<?= $orderNum; ?>">
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
                    <td class="txt titleTxt" style="width:80px;">建立日期</td>
                    <td class="txt titleTxt" style="width:130px;">訂單編號</td>
                    <td class="txt titleTxt">購買人</td>
                    <td class="txt titleTxt" style="width:100px;">金額</td>
                    <td class="txt titleTxt" style="width:100px;">訂單狀態</td>
                    <td class="txt titleTxt" style="width:100px;">結帳狀態</td>
                    <td class="txt titleTxt" style="width:120px;">運費付款狀態</td>
                    <td class="txt titleTxt" style="width:100px;">修改</td>
                    <td class="txt titleTxt" style="width:100px;">刪除</td>
                  </tr>
                  <?php
                    for( $i=0; $dataContent = $rsContent->fetch(); $i++ ) {
                  ?>
                  <tr>
                    <td class="num"><?=$i+1;?></td>
                    <td>
                      <h3>
                        <?=$dataContent['AOCIT_CreateDate'];?>
                      </h3>
                    </td>
                    <td>
                      <h3>
                        <?php
                         /*substr($dataContent['SOT_CreateDate'],0,10);*/
                         echo $dataContent['AOCIT_OrderNumCode'];
                         ?>
                      </h3>
                    </td>
                    <td>
                      <h3>
                        <?= $dataContent['AOCIT_Name']; ?>
                      </h3>
                    </td>
                    <td>
                      <h3>
                        <?php
                          #算訂單總金額
                          $sqlProPrice = "select * from Admin_OrderChangeInquiryStatus where AOCIS_AOCIT_OrderNum = '".$dataContent['AOCIT_OrderNum']."'";
                          $rsProPrice = $Language_db->query($sqlProPrice);
                          $dataproPrice = $rsProPrice->fetch();
                          echo $dataproPrice['AOCIS_TotalPrice'];
                        ?>
                      </h3>
                    </td>
                    <td>
                        <?php
                          echo $dataContent['AOCIT_OrderStatus'];
                        ?>
                      
                    </td>   
                    <td>
                      <h3>
                        <?php
                          echo switchPay($dataContent['AOCIT_ProductSataus']);
                        ?> 
                      </h3>
                    </td>
                    <td>
                      <h3>
                        <?php
                          echo switchPay($dataContent['AOCIT_Freight']);
                        ?>  
                      </h3>
                    </td>
                    <!--
                      <td class="date">觀看</td>
                      <td class="date"><a href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=edit&id=<?=$dataList['SOT_ID'];?>'>編輯</a></td>
                      <td class="date"><a href='javascript: void(0)' onclick='delSubmit(<?=$dataList['SOT_ID'];?>)'>刪除</a></td>
                    -->
                    <td>
                      <button class="yellow toolsBtn" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=edit&id=<?=$dataContent['AOCIT_OrderNum'];?>'">修改</button>
                    </td>
                    <td>
                      <button class="red toolsBtn" onclick='delSubmit("<?=$dataContent['SOT_OrderNum'];?>")'>刪除</button>
                    </td>
                  </tr>
                  <?php
                    } //end for( $i=0; $dataContent = $rsContent->fetch(); $i++ )
                  ?>
                </table>
                <div style="text-align:center;">
                  <div id="pageSwap" style="margin:0 auto; width:400px;"></div>
                </div>
              </div><!--tableWarp-->  
            </div><!--formTable-->
          </div><!--newsWarp-->
        </div><!--pageIndexWarp-->
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