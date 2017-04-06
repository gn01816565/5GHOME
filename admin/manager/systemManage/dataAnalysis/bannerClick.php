<?php
#宣告參數
foreach($_POST as $key=>$val) {
  $$key=$val;
}

#判斷是否有搜尋日期
if($act == 'search') {
  $SQLplus = "";
  if($startTime) { //開始時間
    $SQLplus .= " AND ";
    $SQLplus .= " AIAC_AddDate >= '".$startTime."'";
  }

  if($endTime) { //結束時間
    $SQLplus .= " AND ";
    $SQLplus .= " AIAC_AddDate <= '".$endTime."'";
  }
} //if($act == 'search') {

#抓出頁面點擊數量，先把重覆的網址濾掉，過濾用AIAC_IDNum將同覆的篩選掉
$SQLbannerClick = "SELECT * FROM  Admin_IndexAdClick where AIAC_Unit like 'banner'  $SQLplus group by AIAC_IDNum ORDER BY AIAC_ID DESC ";
$RSbannerClick = $Language_db->query($SQLbannerClick);
$databannerClick = $RSbannerClick -> fetchAll();

#找出各個banner的資料行數，並列出數字排列
//for($i = 0; $i <= count($dataAllPageClick); $i++ ) {
foreach($databannerClick as $key => $val) {
  $SQLamountBannerClick = "SELECT count(*) FROM Admin_IndexAdClick WHERE AIAC_Unit like 'banner' AND AIAC_IDNum = '".$val['AIAC_IDNum']."' $SQLplus";
  $RSamountBannerClick = $Language_db->query($SQLamountBannerClick);
  $DATAamountPageClick = $RSamountBannerClick->fetch();
  //echo $dataAmountPageClick['SUM(RCP_Amount)'];
  $arrayClick[$val['AIAC_Img']] = $DATAamountPageClick['count(*)'];
}

arsort($arrayClick); //重新排列，用val做降序排列
$fi=0; //foreach的輸出行數
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
google.load('visualization', '1', {packages: ['corechart', 'bar']}); //代入function
google.setOnLoadCallback(drawChart); //執行畫圖的設定

function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['PageClick', '點擊數',],
  <?php
  foreach($arrayClick as $key=>$val) {
    if($fi>20) { break; } //第20行跳出
    echo "['".$key."', ".$val."],";
    $fi++;
  }
  ?>
  /*
  ['New York City, NY', 1000000],
  ['Los Angeles, CA', 2000000],
  ['Chicago, IL', 3000000],
  ['Houston, TX', 4000000],
  ['Philadelphia, PA', 5000000],
  ['Philadelphia, PA', 5000000],
  ['Philadelphia, PA', 5000000],
  ['Philadelphia, PA', 5000000]
  */
]);

var options = {
  title: 'Banner點擊排行 / Banner Click Ranking',
  chartArea: {width: '60%',height:'90%'},
  hAxis: {
    title: '前20名排列',
    minValue: 0
  },
  /*
  vAxis: {
    title: 'City'
  }
  */
};

//var chart = new google.charts.Bar(document.getElementById('barchart_material'));
var chart = new google.visualization.BarChart(document.getElementById('barchart_material'));
chart.draw(data, options);
}
//點擊開啟、關閉
function allPrint() {

  jQuery.fn.extend({
    toggleText: function (a, b){
        var that = this;
            if (that.text() != a && that.text() != b){
                that.text(a);
            }
            else
            if (that.text() == a){
                that.text(b);
            }
            else
            if (that.text() == b){
                that.text(a);
            }
        return this;
    }
  });

  $('#moreButton').toggleText('點擊關閉', '查閱全部資料'); //切換按扭顯示
  $('#moredData').toggle(); //table顯示切換
}
</script>
<!--小日曆-->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script>
$(function() {
  $.datepicker.regional['zh-TW']={
   dayNames:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],
   dayNamesMin:["日","一","二","三","四","五","六"],
   monthNames:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
   monthNamesShort:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
   prevText:"上月",
   nextText:"次月",
   weekHeader:"週"
   };
   $.datepicker.setDefaults($.datepicker.regional["zh-TW"]);
   
  $( "#startTime").datepicker({
    showOn: "button",
    buttonImage: "../images/calendar.gif",
    buttonImageOnly: true,
    dateFormat: 'yy-mm-dd'
  });
  $( "#endTime").datepicker({
    showOn: "button",
    buttonImage: "../images/calendar.gif",
    buttonImageOnly: true,
    dateFormat: 'yy-mm-dd'
  });
});
</script>
<!--小日曆-->
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
          <a href="page_index.php?pageData=dataAnalysis" title="數據分析">數據分析</a>
        </div>
        <div class="clearBoth"></div>
        <div id="pageIndexWarp" class="boxWarp">
          <?php
          include("menu.php");
          ?>
          <div id="newsWarp" class="boxWarp">
            <div id="formTable">
              <div class="tableWarp">
                <h2 class="red">頁面點擊分析</h2>
                <div id="searchBar">
                  <div class="searchBarTR">
                    <div class="searchIcon"></div>

                    <form id="searchForm" method="post" action="page_index.php?pageData=<?= $_GET['pageData']; ?>&secondURL=<?= $_GET['secondURL']; ?>">
                      <div class="searchForm">
                        <input type="hidden" name="act" id="act" value="search">
                        <input type="text" id="startTime" name="startTime" placeholder="開始時間" value="<?= $startTime; ?>"style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                        <span>~</span>
                        <input type="text" id="endTime" name="endTime" placeholder="結束時間" value="<?= $endTime; ?>" style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                      </div>
                      <div class="searchBtn">
                        <button class="red" type="button" onclick="javascript:submit()">搜尋</button>
                      </div>
                    </form>

                  </div>
                </div>
        
                <div id="barchart_material" style="width: 900px; height: 500px;"></div>
                <table>
                  <tr>
                    <td colspan="3"><button class="yellow toolsBtn" id="moreButton" onclick="allPrint()">查閱全部資料</button></td>
                  </tr>
                </table>
                <table id="moredData" style="display:none;">  
                  <tr>
                    <td class="num titleTxt" style="width:20px;">排名</td>
                    <td class="num">網頁</td>
                    <td class="num" style="width:20px;">點擊數</td>
                  </tr>
                  <?php
                  $i=0;
                  foreach($arrayClick as $key=>$val) {
                  ?>
                  <tr>
                    <td class="num"><?= $i+1; ?></td>
                    <td>
                      <a href='' target="_blank">
                        <?php                        
                        if(file_exists('../images/bannerImage/'.$key)==true){
                          echo "<img src='../images/bannerImage/".$key."' width='100%'>";
                        } else {
                          echo "圖片已移除";
                        } //if(is_file)
                        
                        ?>
                      </a>
                    </td>
                    <td><?= $val; ?></td>
                  </tr>
                  <?php
                  $i++;
                  } //foreach($arrayClick as $key=>$val) {
                  ?>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
        <!--<div id="pageNumBox">頁碼區塊-->

      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>