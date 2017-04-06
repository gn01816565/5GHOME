<?php
#登入管理者的權限列出
$amCompSql   = "select AM_ID,AM_Competence,AM_Level from Admin_Manager where AM_ID = '".$_SESSION['AM_ID']."'";
$amCompRs    = $_db->query($amCompSql);
$amCompData  = $amCompRs->fetch();
$amCompStr   = $amCompData['AM_Competence']; //將管理者的權限先呼叫出來，英文
$amLevel     = $amCompData['AM_Level']; //管理者等級
#將權限陣列(英文)，轉成主類別陣列(數字id)
$amCompArray = explode(",",$amCompStr); //分割將字串轉為陣列，以標點符號為分割點

foreach($amCompArray as $key=>$val) {
  $mIDSql  = "select AMC_ID,AMC_EnName,AMC_MainClass from Admin_ManagerCompetence where AMC_EnName = '$val'";
  $mIDRs   = $_db->query($mIDSql);
  $mIDData = $mIDRs->fetch(); 
  
  if($amLevel == '2' && ($mIDData['AMC_MainClass'] == '1' || $mIDData['AMC_MainClass'] == '6')) { //一般管理者部份功能看不到的過濾，系統管理、數據分析
    continue;
  } else {
    $mIDarray[] = $mIDData['AMC_MainClass']; //將主類別的id值存入陣列
  }
  
  //$mIDarray[] = $mIDData['AMC_MainClass']; //將主類別的id值存入陣列
}

#計算前端當日參觀人數
$toDay           =  date("Y-m-d"); //當天日期
$sqlTodayAmount  = "SELECT * FROM Record_ClickPage WHERE RCP_AddDate = '".$toDay ."' GROUP BY RCP_Ip";
$rsTodayAmount   = $_db -> query($sqlTodayAmount);
$dataTodayAmount = $rsTodayAmount -> fetchAll();

#計算累積參觀人數
$sqlTotalAmount  = "SELECT * FROM Record_ClickPage GROUP BY RCP_Ip";
$rsTotalAmount   = $_db -> query($sqlTotalAmount);
$dataTotalAmount = $rsTotalAmount -> fetchAll();

$mIDcheckArray   = array_unique($mIDarray); //將有重覆的value值刪除，在不考慮key值的情況下刪除，適用於陣列
//$mIDcheckArray = $mIDarray;

#ul的style設定
//找出正在看的功能母類別id
$sqlMainMenu     = "select * from Admin_ManagerCompetence where AMC_EnName = '".$_GET['pageData']."'";
$rsMainMenu      = $_db -> query($sqlMainMenu);
$dataMainMenu    = $rsMainMenu -> fetch();

if($dataMainMenu && $dataMainMenu['AMC_MainClass']!= 0) { //用子類別找出主類別id
  $mainID = $dataMainMenu['AMC_MainClass']; //主類別ID
}

#menu選單列出
$mMenuSql = "select * from Admin_ManagerCompetence where AMC_Level = '1' order by AMC_ID ASC";
$mMenuRs  = $_db->query($mMenuSql);
?>
<section id="asideWarp">
  <header id="logoWarp" class="boxWarp">
    <div class="logoBox">
      <!--LOGO圖片放置，class="logo"-->
      <div class="logo">
        <a href='page_index.php?pageData=page_index_info'>
          <img src="../images/logo.svg" width="250" height="40" alt="logo">
        </a>
      </div>
      <h1>後台管理系統</h1>
    </div>
    <div class="userInfo">管理員：<span><?=$_SESSION['AM_Account'];?></span> 您好！</div>
  </header>
  <aside id="menuWarp" class="boxWarp">
    <h2 class="red_T">MENU</h2>
    <div class="btnWarp">
      
      <ul>
        <?php
        $mMenuNum = 0; //主類別數目計算
        while($mMenuData = $mMenuRs->fetch()) {
          if(in_array($mMenuData['AMC_ID' ], $mIDcheckArray)) { //比對主類別是否有權限，比對陣列
          $mMenuNum++;
          $subMenuNum = 0; //次類別數目計算
        ?>
        <li>
          <a href="javascript:void(0);" class="listMenuBtn" title="<?php echo $mMenuData['AMC_TwName']; ?>">
            <div class="icon"></div>
            <h3><?php echo $mMenuNum." . ".$mMenuData['AMC_TwName']?></h3>
          </a>
          <ul class="listMenu" style="<?php if($mMenuData['AMC_ID'] == $mainID) { echo "display:block"; } else { echo "display:none"; } ?>">
            <?php
            $subMenuSql = "select * from Admin_ManagerCompetence where AMC_Level = '2' AND AMC_MainClass = '$mMenuData[AMC_ID]' order by AMC_ID ASC";
            $subMenuRs = $_db->query($subMenuSql);
            while($subMenuData = $subMenuRs->fetch()) {
              //if(strpos($amCompStr, $subMenuData['AMC_EnName'])) { //比對次類別字串，是否帳號中有一樣的權限，比對字串
              if(preg_match("/\b".$subMenuData['AMC_EnName']."\b/i", $amCompStr)) { //比對次類別字串，是否帳號中有一樣的權限，比對字串
            ?>
              <li>
                <a href="?pageData=<?php echo $subMenuData['AMC_getURL']; ?>" title="<?php echo $subMenuData['AMC_TwName']; ?>">
                  <h4 style='<?php if($dataMainMenu['AMC_ID'] == $subMenuData['AMC_ID']) { echo "color:white"; } ?>' >
                    <?php echo $subMenuData['AMC_TwName']?>
                  </h4>
                </a>
              </li>
            <?php
              } //if(strpos($amCompStr, $subMenuData['AMC_EnName'])) { 
            } //while($subMenuData = $subMenuRs->fetch()) {
            ?>
          </ul>
        </li>
        <?php
          } //if(strpos($amCompStr, $mMenuData['AMC_EnName'])) {
        } //while($mMenuData = $mMenuRs->fetch()) {
        ?>
      </ul>
    </div>
  </aside>
  <?php               
  #搜尋出所屬資料全部的數量，管理者帳號登入次數 
  #資料庫、資料表、條件式(陣列)
  $searchParameters['AMLM_AM_ID'] = $_SESSION['AM_ID']; //列出條件式 
  //$LoginCount = allTableNum($Config_db,'Admin_ManagerLoginMessage',$searchParameters); 
  $LoginCount = whereTableNum($Config_db,'Admin_ManagerLoginMessage',$searchParameters); 
   //$LoginCount= loginCount($Config_db,$_SESSION['AM_ID']); //取出次數
  #最後登入日期
  $rowLoginLast = loginLastDate($Config_db,$_SESSION['AM_ID']); //取出最後登入紀錄
  
  if(!$rowLoginLast['AMLM_Date']) { //判斷是否過去有登入紀錄
    $login_status = "過去無登入紀錄！";
  } else {
    $login_status = $rowLoginLast['AMLM_Date']." ".$rowLoginLast['AMLM_Time'];
  }
  ?>
  <div id="infoWarp" class="boxWarp">
    <h2 class="red_T">INFO</h2>
    <div class="txtWarp">
      <div class="txt"><span class="red_T">登入次數：</span><span style="font-size:10px;"><?=$LoginCount;?> / 次</span></div>
      <div class="txt"><span class="red_T">最後登入：</span><span style="font-size:10px;"><?=$login_status;?></span></div>
      <div class="txt"><span class="red_T">當日人數：</span><span style="font-size:10px;"><?=count($dataTodayAmount);?></span></div>
      <div class="txt"><span class="red_T">累積人數：</span><span style="font-size:10px;"><?=count($dataTotalAmount);?></span></div>
      <?php
      echo " ";
      ?>
      <!--
      <div class="txt">
        <span class="red_T">
          線上人數：
        </span>
        <span style="font-size:10px;">
          <?php
          $counterFile = "count.txt";     //讀取寫入的檔案名稱
          $counterizo = intval(file_get_contents($counterFile));
          if($_SESSION['countizo']!=1){     //檢查SESSION
            $fp = @fopen($counterFile, "w");
            if($fp){
              flock($fp, 2);
              @fwrite($fp, ++$counterizo);
              flock($fp, 3);
              fclose($fp);
              $_SESSION['countizo']=1;  //防止重複計算
            }
          }
           
          echo $counterizo;      //輸出
          ?>
        </span>
      </div>
      -->
      <!--
      <div>製作參考頁面： <a href='page_index.php?pageData=page'>page</a> , <a href='page_index.php?pageData=page_index_info'>pageinfo</a><br></div>
      -->
    </div>
  </div>
</section>