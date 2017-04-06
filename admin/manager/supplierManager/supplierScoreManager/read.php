<?php
$id = $_GET['id']; //評分id

#呼叫評分資料
$sqlRead = "SELECT * FROM Supplier_Fraction 
            left join Supplier_OrderTitle
            on  Supplier_Fraction.SF_SOT_OrderNum = Supplier_OrderTitle.SOT_OrderNum
            where SF_ID = '".$id."'
           ";
$rsRead = $Language_db -> query($sqlRead);
$dataRead = $rsRead->fetch();

#星數列出的數據
function starPrint($num) {
  $starAll = floor($num); //算出星數有多少
  if(($starAll-$num) != 0) {
    $starHalf = 'Y';//是否有半星狀態
  } else {
    $starHalf = 'N';
  }
  #列出星數
  for( $i=0; $i<5; $i++) {
    if($starAll>$i) {
      echo "<li class='good'></li>";
    } else {
      if( $i == $starAll && $starHalf == 'Y') {
        echo "<li class='goodHalf'></li>";
      } else {
        echo "<li></li>";
      }
    } //if($starAll>$i) {
  } //for($i=0;$i<5;$i++) {
} //function starPrint() {
?>
<!--雷達圖設定-->
<script src="../jquery/jquery.radar.js"></script>
<script type="text/javascript">
  window.onload = function() {
    var rc = new html5jp.graph.radar("starsRadar");
    if( ! rc ) { return; }
    var items = [
      [6, <?=$dataRead['SF_Fraction1'];?>, <?=$dataRead['SF_Fraction2'];?>, <?=$dataRead['SF_Fraction3'];?>, <?=$dataRead['SF_Fraction4'];?>, <?=$dataRead['SF_Fraction5'];?>] //第一數字為最大角數，其餘數字為顯示數據。
      //[5, 5, 3, 3, 3, 3] //可陸續增加
    ];
    var params = {
      aCap: ["購買流程", "出貨速度", "商品包裝", "商品品質", "整體服務"]
    }
    rc.draw(items, params);
  };
</script>
<!--End-->
<style>
ul.star {
  width: 100px;
  height: auto;
  overflow: hidden;
  margin: 0;
  padding: 0;
  list-style: none;
  float: left;
}
ul.star li{
  width: 10px;
  height: 10px;
  overflow: hidden;
  margin: 5px;
  background: url(../images/star.svg) no-repeat;
  -webkit-background-size: 10px 30px;
  -moz-background-size: 10px 30px;
  background-size: 10px 30px;
  float: left;
}
ul.star li.goodHalf{
  background-position: 0 -10px;
}
ul.star li.good{
  background-position: 0 -20px;
}
</style>
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
          <a href="page_index.php?pageData=<?=$subDirectory?>" title="<?=$pageTitle;?>"><?=$pageTitle;?></a>
        </div>
        <div class="clearBoth"></div>
        <div id="pageIndexWarp" class="boxWarp">
         
          <div id="newsWarp" class="boxWarp">
            <h2 class="red">資料查閱</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="formAdd" name="formAdd">
                  <input type="hidden" name="act" value="add">
                  <table>
                    <tr>
                      <td class="num titleTxt">日期</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?= $dataRead['SF_Date']; ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">訂單編號</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?= $dataRead['SOT_OrderNumCode']; ?>
                        <button type="button" class="yellow" onclick="location.href='page_index.php?pageData=supplierOrder&secondURL=edit&id=<?=$dataRead['SF_SOT_OrderNum'];?>'">
                          詳細資料
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">會員</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?= memberNameSearch($Config_db, $dataRead['SF_MAD_ID']); ?>
                        <button type="button" class="yellow" onclick="location.href='http://fs.kingtechcorp.com/admin/page_index.php?pageData=memberDataManager&secondURL=editG&id=<?=$dataRead['SF_MAD_ID'];?>'">
                          詳細資料
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">會員留言</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?= $dataRead['SF_Content']; ?>
                      </td>
                    </tr>
                  </table>
                  <table>
                    <tr>
                      <td class="red" colspan="4" style='padding:0 0 0 0;padding-left:10px;text-align:left;'>評價數據</td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">評價明細</td>
                      <td class="num titleTxt">平均星數</td>
                      <td class="num titleTxt">平均分數</td>
                      <td rowspan="6">
                        <div class="starsDataB" width="280">
                          <div class="starsRadarBox">
                            <canvas width="280" height="264" id="starsRadar"></canvas>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="colorBg">商品品項</td>
                      <td>
                        <ul class="star">
                          <?= starPrint($dataRead['SF_Fraction1']); ?>
                        </ul>
                      </td>
                      <td class="colorBg">5.0</td>
                    </tr>
                    <tr>
                      <td class="colorBg">出貨速度</td>
                      <td>
                        <ul class="star">
                          <?= starPrint($dataRead['SF_Fraction2']); ?>
                        </ul>
                      </td>
                      <td class="colorBg">3.5</td>
                    </tr>
                    <tr>
                      <td class="colorBg">商品包裝</td>
                      <td>
                        <ul class="star">
                          <?= starPrint($dataRead['SF_Fraction3']); ?>
                        </ul>
                      </td>
                      <td class="colorBg">3.0</td>
                    </tr>
                    <tr>
                      <td class="colorBg">商品品質</td>
                      <td>
                        <ul class="star">
                          <?= starPrint($dataRead['SF_Fraction4']); ?>
                        </ul>
                      </td>
                      <td class="colorBg">3.0</td>
                    </tr>
                    <tr>
                      <td class="colorBg">整體服務</td>
                      <td>
                        <ul class="star">
                          <?= starPrint($dataRead['SF_Fraction5']); ?>
                        </ul>
                      </td>
                      <td class="colorBg">3.0</td>
                    </tr>
                  </table>
                </form>
              </div><!--<div id="formTable">-->  
            </div>
          </div>
        <div class="pageBtnWarp">
          <ul>
            <li><button class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>'">返回列表</button></li>
          </ul>
        </div>  
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

