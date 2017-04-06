<?php
$mid = $_GET['mid']; //主類別id

$sqlPlus = "";
if($mid) {
  $sqlPlus .= " AND AGPSC_AGPMC_ID = '".$mid."'";
}

#換頁所需要資訊
$page = isset($_GET['page'])?$_GET['page']:1 ; //當頁頁碼
$read_num = 10; //當頁觀看數量
$star_num = $read_num*($page-1); //開始讀取資料行數

#搜尋出所屬資料全部的數量
#資料庫、資料表
//$all_num = allTableNum($Language_db,'Admin_GlobalProductSubClass'); 
$sqlPage = "select count(*) from Admin_GlobalProductSubClass 
            where 1=1 
            $sqlPlus
           ";
$rsPage = $Language_db -> query($sqlPage);
$dataPage = $rsPage -> fetch();
$all_num = $dataPage['count(*)'];
$pageAll_num = ceil($all_num / $read_num); //頁碼數計算，全部數量/讀取數量 

#列出紀錄資料
$sqlContent = "SELECT * FROM Admin_GlobalProductSubClass
               where 1=1
               $sqlPlus 
               ORDER BY  AGPSC_ID  DESC  
               limit $star_num, $read_num
              ";
$rsContent = $Language_db->query($sqlContent);
$dataContent = $rsContent -> fetchall();

$sqlMainTitle = "SELECT * FROM Admin_GlobalProductMainClass WHERE  AGPMC_ID  = '".$dataContent[0]['AGPSC_AGPMC_ID']."'";
$rsMainTitle = $Language_db->query($sqlMainTitle);
$dataMainTitle = $rsMainTitle->fetch();

$mainName = $dataMainTitle['AGPMC_Name']; //主類別名稱
?>
<script>
function delSubmit(id, mid) { //刪除function
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
    ajaxPro(id, mid);
  });


}
function ajaxPro(id, mid) {
  //var URLs  = "page_index.php?pageData=adminConfig&secondURL=process&act=del";
  var URLs  = "manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/subProcess.php";
  $.ajax({
    url: URLs,
    data: { id:id,act:"del"},
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
          window.location.href='page_index.php?pageData=<?=$subDirectory;?>&secondURL=<?=$secondURL;?>&mid='+mid;
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
          <span>
            <a href='page_index.php?pageData=<?=$_GET['pageData'];?>'>
              <?=$pageTitle;?>
            </a>
          </span>
          <span>></span>
          <span><?="【 ".$mainName." 】";?> - 次類別管理</span>
        </div>
        <div class="clearBoth"></div>
        <div id="pageIndexWarp" class="boxWarp">
          <div id="toolsBar" class="boxWarp">
            <button class="blue" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=subAdd&mid=<?= $mid; ?>'">新增次類別</button>
          </div>

          <div id="toolsBar" class="boxWarp" style="background-color: #BDE5F8;color: #00529B;">
            <i class="fa fa-info-circle"></i>
            數量：<?=$all_num;?>
          </div>

          
          <div id="newsWarp" class="boxWarp">
            <h2 class="red"><?="【 ".$mainName." 】- 次類別管理";?></h2>
            <div id="formTable">
              <div class="tableWarp">
                <table>
                  <tr>
                    <td class="num titleTxt">編號</td>
                    <td class="txt titleTxt">次類別名稱</td>
                    <td class="btnTools">編輯</td>
                    <td class="btnTools">刪除</td>
                  </tr>
                  <?php
                  for($i=0;$i < count($dataContent);$i++) {
                  ?>
                  <tr>
                    <td class="num"><?=$i+1;?></td>
                    <td>
                      <h3>
                        <?=$dataContent[$i]['AGPSC_Name'];?>
                      </h3>
                    </td>
                    <td>
                       <button class="yellow toolsBtn" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=subEdit&id=<?=$dataContent[$i]['AGPSC_ID'];?>&mid=<?= $mid; ?>'">修改</button>
                    </td>
                    <td >
                      <button class="green toolsBtn" onclick='delSubmit(<?=$dataContent[$i]['AGPSC_ID'];?>, <?= $mid; ?>)'>刪除</button>
                    </td>
                  </tr>
                  <?php
                  } //for($i=0;$i < count($dataContent);$i++) {
                  ?>

                </table>
              </div>
            </div>
          </div>
          <div class="pageBtnWarp">
            <ul>
              <li>
                <button class="green" onclick="location.href='page_index.php?pageData=globalClassProduct'">返回主類別列表</button>
              </li>
            </ul>
          </div>
          <!--頁碼區塊 -->
          <?php 
          //當前頁面代號、全部頁碼、當前頁碼、讀取頁數
          pageNumList($_GET['pageData'], $pageAll_num, $page, $read_num); 
          ?>
        </div>
        <!--<div id="pageNumBox">頁碼區塊-->
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>