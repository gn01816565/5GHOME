<script>
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
          <div id="toolsBar" class="boxWarp" style="background-color: #BDE5F8;color: #00529B;">
            <i class="fa fa-info-circle"></i>
            此部份資訊由程式資訊人員管理
          </div>
          <div id="newsWarp" class="boxWarp">
            <h2 class="red"><?=$pageTitle;?></h2>
            <div class="tableWarp">
              <table>
                <tr>
                  <td class="num titleTxt">編號</td>
                  <td class="txt titleTxt">顏色顯示</td>
                  <td class="txt titleTxt" style="width:100px;">版面名稱</td>
                  <td class="txt titleTxt" style="width:400px;">版面說明</td>
                </tr>
                <?php
                #換頁所需要資訊
                $page = isset($_GET['page'])?$_GET['page']:1 ; //當頁頁碼
                $read_num = 10; //當頁觀看數量
                $star_num = $read_num*($page-1); //開始讀取資料行數
                
                #搜尋出所屬資料全部的數量
                #資料庫、資料表
                $all_num = allTableNum($Config_db,'Admin_SupplierLayoutData'); 
                $pageAll_num = ceil($all_num / $read_num); //頁碼數計算，全部數量/讀取數量 

                #列出紀錄資料
                $sqlContent = "SELECT * FROM Admin_SupplierLayoutData ORDER BY  ASLD_ID  DESC  limit $star_num, $read_num";
                $rsContent = $Config_db->query($sqlContent);

                for($i=0;$dataContent = $rsContent->fetch();$i++) {
                ?>
                <tr>
                  <td class="num"><?=$i+1;?></td>
                  <td class="leftTxt" style="padding:5px;">
                    <h3>
                      <?php
                      /*
                      $dataContent['ASLD_Image'];
                      */
                      if($dataContent['ASLD_Name']=='Green') {
                        echo '<div style="marring:5px;width:30px;height:30px;background-color:#598527;margin:0px auto;"></div>';
                      } elseif($dataContent['ASLD_Name']=='Blue') {
                        echo '<div style="width:30px;height:30px;background-color:#448ccb;margin:0px auto;"></div>';
                      } else {
                        echo '<div style="width:30px;height:30px;background-color:#b83b35;margin:0px auto;"></div>';
                      }
                      ?>
                    </h3>
                  </td>
                  <td>
                    <h3>
                      <?=$dataContent['ASLD_Name'];?>
                    </h3>
                  </td>
                  <td style="text-align:left;">
                    <h3>
                      <?=$dataContent['ASLD_Introduction'];?>
                    </h3>
                  </td>  
                </tr>
                <?php
                } //for($i=0;$dataAIN = $rsAIN->fetch();$i++) {
                ?>

              </table>
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