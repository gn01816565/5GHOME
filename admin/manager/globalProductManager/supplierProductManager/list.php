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
                    <td class="txt titleTxt">商品名稱 </td>
                    <td class="txt titleTxt">供應商</td>
                    <td class="txt titleTxt">商品狀態</td>
                    <td class="date">發佈時間</td>
                    <td class="btnTools">編輯</td>
                  </tr>
                  <?php
                  #換頁所需要資訊
                  $page = isset($_GET['page'])?$_GET['page']:1 ; //當頁頁碼
                  $read_num = 10; //當頁觀看數量
                  $star_num = $read_num*($page-1); //開始讀取資料行數
                  
                  #搜尋出所屬資料全部的數量
                  #資料庫、資料表
                  $all_num = allTableNum($Language_db,'Supplier_ProductDetail'); 
                  $pageAll_num = ceil($all_num / $read_num); //頁碼數計算，全部數量/讀取數量 

                  #列出紀錄資料
                  $sqlContent = "SELECT * FROM Supplier_ProductDetail ORDER BY SPD_ID DESC  limit $star_num, $read_num";
                  $rsContent = $Language_db->query($sqlContent);

                  for($i=0;$dataContent = $rsContent->fetch();$i++) {
                  ?>
                  <tr>
                    <td class="num"><?=$i+1;?></td>
                    <td>
                      <h3>
                        <?=$dataContent['SPD_Name'];?>
                      </h3>
                    </td>
                    <td>
                      <h3>
                        <?php
                        #列出供應商地區
                        $sqlSAD = "SELECT SAD_ID,SAD_Country FROM Supplier_AccountData WHERE SAD_ID = '".$dataContent['SPD_SAD_ID']."'";
                        $rsSAD = $Config_db->query($sqlSAD);
                        $dataSAD = $rsSAD->fetch();

                        #供應商所在資料表
                        $sadTable = "Supplier_AccountData".$dataSAD['SAD_Country']; //資料表名稱
                        if($dataSAD['SAD_Country']=='Tw') {
                          $sadNum = "T"; 
                        } else {
                          $sadNum = "C"; 
                        }
                        #列出供應商資料
                        $sqlSADda = "SELECT SAD".$sadNum."_ID,SAD".$sadNum."_Name FROM ".$sadTable." WHERE SAD".$sadNum."_SAD_ID = '".$dataContent['SPD_SAD_ID']."'";
                        $rsSADda = $Config_db->query($sqlSADda);
                        $dataSADda = $rsSADda->fetch();
                        echo  $dataSADda["SAD".$sadNum."_Name"];
                        ?>
                      </h3>
                    </td>
                    <td>
                      <h3>
                        <?php
                        if($dataContent['SPD_CheckStatus']=='Y') {
                          echo "<text style='color:blue;'>上架</text>";
                        } else {
                          echo "<text style='color:red;'>下架</text>";
                        }
                        ?>
                      </h3>
                    </td>
                    <td class="date">
                      <h3>
                        <?=$dataContent['SPD_CreateDate'];?>
                      </h3>
                    </td>
                    <td>
                       <button class="yellow toolsBtn" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData'];?>&secondURL=edit&id=<?=$dataContent['SPD_ID'];?>'">修改</button>
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
        </div>
        <!--<div id="pageNumBox">頁碼區塊-->
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>