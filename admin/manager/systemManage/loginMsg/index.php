<div id="pageMainWarp">
  <div id="pageWarp">
    <div id="pageWarpTR">
      <?php
      include('aside.php');
      ?>
      <section id="rightWarp">
        <div id="placeWarp" class="boxWarp">
          <div class="title red_T">目前位置：</div>
          <span>系統管理</span>
          <span>></span>
          <a href="page_index.php?pageData=loginMsg" title="登入狀況">登入狀況</a>
        </div>
        <div class="clearBoth"></div>
        <div id="pageIndexWarp" class="boxWarp">
         
          <div id="newsWarp" class="boxWarp">
            <h2 class="red">登入紀錄</h2>
            <div class="tableWarp">
              <table>
                <tr>
                  <td class="num titleTxt">編號</td>
                  <td class="txt titleTxt" style="width:150px;">登入狀況</td>
                  <td class="txt titleTxt" style="width:150px;">登入ip</td>
                  <td class="txt titleTxt">用戶端資訊</td>
                  <td class="date titleTxt">登入時間</td>
                </tr>
                <?php
                #換頁所需要資訊
                $read_num = 10;
                $page = isset($_GET['page'])?$_GET['page']:1 ; //當頁頁碼
                $star_num = $read_num*($page-1); //開始讀取資料行數
                $searchParameters['AMLM_AM_ID'] = $_SESSION['AM_ID']; //列出條件式 
                
                #搜尋出所屬資料全部的數量
                #資料庫、資料表、條件式
                $all_num = whereTableNum($Config_db,'Admin_ManagerLoginMessage',$searchParameters); 
                $pageAll_num = ceil($all_num / $read_num); //頁碼數計算，全部數量/讀取數量 

                #列出紀錄資料
                $sqlLoginMsg = "SELECT * FROM  Admin_ManagerLoginMessage where AMLM_AM_ID = '$_SESSION[AM_ID]' ORDER BY  AMLM_ID DESC  limit $star_num, $read_num";
                $rsLoginMsg = $Config_db->query($sqlLoginMsg);

                for($i=0;$dataLoginMsg = $rsLoginMsg->fetch();$i++) {
                ?>
                <tr>
                  <td class="num"><?=$i+1;?></td>
                  <td  style="padding:20px;">
                    <h3><?=$dataLoginMsg['AMLM_Status'];?></h3>
                  </td>
                  <td>
                    <h3><?=$dataLoginMsg['AMLM_Ip'];?></h3>
                  </td>
                  <td class="leftTxt">
                    <h3><?=$dataLoginMsg['AMLM_Browser'];?></h3>
                  </td>
                  <td class="date"><?=$dataLoginMsg['AMLM_Date']." ".$dataLoginMsg['AMLM_Time'];?></td>
                </tr>
                <?php
                } //while($dataLoginMsg = $rsLoginMsg->fetch()) {
                ?>

              </table>
            </div>

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