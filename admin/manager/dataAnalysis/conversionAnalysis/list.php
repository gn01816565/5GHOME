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
  $.datepicker.setDefaults({
    showOn: "button",
    buttonImage: "../images/calendar.gif",
    buttonImageOnly: true,
    dateFormat: 'yy-mm-dd'
  });
   
  //全商場訂單回購 
  $("#startTimeAllRepurchaseOrder").datepicker();
  $("#endTimeAllRepurchaseOrder").datepicker();
  //商品回購率
  $("#startTimeRepurchaseOrder").datepicker();
  $("#endTimeRepurchaseOrder").datepicker();
  //商品成交率
  $("#startTimeCommodityTransactions").datepicker();  
  $("#endTimeCommodityTransactions").datepicker();
  //商品總成交率
  $("#startTimeAllCommodityTransactions").datepicker();  
  $("#endTimeAllCommodityTransactions").datepicker();
  //商場成交率
  $("#startTimeMarketTransactions").datepicker();  
  $("#endTimeMarketTransactions").datepicker();
  //商場點擊率
  $("#startTimeClick").datepicker();  
  $("#endTimeClick").datepicker();
  //商品詢價率
  $("#startTimeInquiryPro").datepicker();  
  $("#endTimeInquiryPro").datepicker();
  //商場詢價率
  $("#startTimeInquiryMarket").datepicker();  
  $("#endTimeInquiryMarket").datepicker();
   /*
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
  */

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

        <div style="font-size:36px;margin: 20px 0 20px 0;padding:20px;background-color:#DDDDDD;color:white;">
          回購率
        </div>

        <div id="pageIndexWarp" class="boxWarp">
          <div id="newsWarp" class="boxWarp">
            <div id="formTable">
              <div class="tableWarp">
                <h2 class="red">全商場訂單回購率 = 重覆人員 / 下訂會員數</h2>
                <div id="searchBar">
                  <div class="searchBarTR">
                    <div class="searchIcon"></div>
                    <form id="searchForm" method="post" action="page_index.php?pageData=<?= $_GET['pageData']; ?>&secondURL=<?= $_GET['secondURL']; ?>">
                      <div class="searchForm">
                        <input type="hidden" name="act" id="act" value="search">
                        <input type="text" id="startTimeAllRepurchaseOrder" name="startTime" placeholder="開始時間" value="<?= $startTime; ?>"style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                        <span>~</span>
                        <input type="text" id="endTimeAllRepurchaseOrder" name="endTime" placeholder="結束時間" value="<?= $endTime; ?>" style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                      </div>
                      <div class="searchBtn">
                        <button class="red" type="button" onclick="javascript:submit()">搜尋</button>
                      </div>
                    </form>
                  </div>
                </div>
                <div style="padding:10px;">
                  <div style="float:left;padding:5px;">全商場訂單回購率</div>
                  <div style="float:left;padding:5px;">重覆人員 / 訂單會員數</div>
                  <!--
                  <table>
                    <tr>
                      <td style="width:150px;">全商場訂單回購率</td>
                      <td>重覆人員 / 訂單會員數</td>
                    </tr>
                  </table>
                  -->
                  
                  
                </div>
              </div>
            </div>
          </div>

          <div id="newsWarp" class="boxWarp">
            <div id="formTable">
              <div class="tableWarp">
                <h2 class="red">商品回購率 = 『同商品』、『購買人』、『訂單筆數』重複2次以上 / 商品重覆訂單總數</h2>
                <div id="searchBar">
                  <div class="searchBarTR">
                    <div class="searchIcon"></div>
                    <form id="searchForm" method="post" action="page_index.php?pageData=<?= $_GET['pageData']; ?>&secondURL=<?= $_GET['secondURL']; ?>">
                      <div class="searchForm">
                        <input type="hidden" name="act" id="act" value="search">
                        <input type="text" id="startTimeRepurchaseOrder" name="startTime" placeholder="開始時間" value="<?= $startTime; ?>"style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                        <span>~</span>
                        <input type="text" id="endTimeRepurchaseOrder" name="endTime" placeholder="結束時間" value="<?= $endTime; ?>" style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                      </div>
                      <div class="searchBtn">
                        <button class="red" type="button" onclick="javascript:submit()">搜尋</button>
                      </div>
                    </form>
                  </div>
                </div>
                <div>畫布</div>
              </div>
            </div>
          </div>
        </div>

        <div>
          <div class="red" style="font-size:36px;margin: 20px 0 20px 0;padding:20px;">
            成交率
          </div>

          <div id="pageIndexWarp" class="boxWarp">
            <div id="newsWarp" class="boxWarp">
              <div id="formTable">
                <div class="tableWarp">
                  <h2 class="red">商品成交率 = 訂單商品筆數 / 瀏覽數</h2>
                  <div id="searchBar">
                    <div class="searchBarTR">
                      <div class="searchIcon"></div>
                      <form id="searchForm" method="post" action="page_index.php?pageData=<?= $_GET['pageData']; ?>&secondURL=<?= $_GET['secondURL']; ?>">
                        <div class="searchForm">
                          <input type="hidden" name="act" id="act" value="search">
                          <input type="text" id="startTimeCommodityTransactions" name="startTime" placeholder="開始時間" value="<?= $startTime; ?>"style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                          <span>~</span>
                          <input type="text" id="endTimeCommodityTransactions" name="endTime" placeholder="結束時間" value="<?= $endTime; ?>" style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                        </div>
                        <div class="searchBtn">
                          <button class="red" type="button" onclick="javascript:submit()">搜尋</button>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div>畫布</div>
                </div>
              </div>
            </div>

            <div id="newsWarp" class="boxWarp">
              <div id="formTable">
                <div class="tableWarp">
                  <h2 class="red">商品總成交率 = 訂單商品總數 / 瀏覽次數</h2>
                  <div id="searchBar">
                    <div class="searchBarTR">
                      <div class="searchIcon"></div>
                      <form id="searchForm" method="post" action="page_index.php?pageData=<?= $_GET['pageData']; ?>&secondURL=<?= $_GET['secondURL']; ?>">
                        <div class="searchForm">
                          <input type="hidden" name="act" id="act" value="search">
                          <input type="text" id="startTimeAllCommodityTransactions" name="startTime" placeholder="開始時間" value="<?= $startTime; ?>"style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                          <span>~</span>
                          <input type="text" id="endTimeAllCommodityTransactions" name="endTime" placeholder="結束時間" value="<?= $endTime; ?>" style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                        </div>
                        <div class="searchBtn">
                          <button class="red" type="button" onclick="javascript:submit()">搜尋</button>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div>畫布</div>
                </div>
              </div>
            </div>

            <div id="newsWarp" class="boxWarp">
              <div id="formTable">
                <div class="tableWarp">
                  <h2 class="red">商場成交率 = 商場的訂單成交數 / 商品瀏覽數</h2>
                  <div id="searchBar">
                    <div class="searchBarTR">
                      <div class="searchIcon"></div>
                      <form id="searchForm" method="post" action="page_index.php?pageData=<?= $_GET['pageData']; ?>&secondURL=<?= $_GET['secondURL']; ?>">
                        <div class="searchForm">
                          <input type="hidden" name="act" id="act" value="search">
                          <input type="text" id="startTimeMarketTransactions" name="startTime" placeholder="開始時間" value="<?= $startTime; ?>"style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                          <span>~</span>
                          <input type="text" id="endTimeMarketTransactions" name="endTime" placeholder="結束時間" value="<?= $endTime; ?>" style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                        </div>
                        <div class="searchBtn">
                          <button class="red" type="button" onclick="javascript:submit()">搜尋</button>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div>畫布</div>
                </div>
              </div>
            </div>

          </div>  
        </div>

        <div>
          <div class="green" style="font-size:36px;margin: 20px 0 20px 0;padding:20px;">
            點擊率
          </div>

          <div id="pageIndexWarp" class="boxWarp">
            <div id="newsWarp" class="boxWarp">
              <div id="formTable">
                <div class="tableWarp">
                  <h2 class="red">商場商品點擊率 = 商品總點擊數 / 賣場所有商品總點擊數</h2>
                  <div id="searchBar">
                    <div class="searchBarTR">
                      <div class="searchIcon"></div>
                      <form id="searchForm" method="post" action="page_index.php?pageData=<?= $_GET['pageData']; ?>&secondURL=<?= $_GET['secondURL']; ?>">
                        <div class="searchForm">
                          <input type="hidden" name="act" id="act" value="search">
                          <input type="text" id="startTimeClick" name="startTime" placeholder="開始時間" value="<?= $startTime; ?>"style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                          <span>~</span>
                          <input type="text" id="endTimeClick" name="endTime" placeholder="結束時間" value="<?= $endTime; ?>" style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                        </div>
                        <div class="searchBtn">
                          <button class="red" type="button" onclick="javascript:submit()">搜尋</button>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div>畫布</div>
                </div>
              </div>
            </div>
          </div>

        </div>


        <div>

          <div class="blue" style="font-size:36px;margin: 20px 0 20px 0;padding:20px;">
            詢價率
          </div>
          <div id="pageIndexWarp" class="boxWarp">
            <div id="newsWarp" class="boxWarp">
              <div id="formTable">
                <div class="tableWarp">
                  <h2 class="red">商品詢價率 = 詢價商品筆數 / 商品瀏覽總數</h2>
                  <div id="searchBar">
                    <div class="searchBarTR">
                      <div class="searchIcon"></div>
                      <form id="searchForm" method="post" action="page_index.php?pageData=<?= $_GET['pageData']; ?>&secondURL=<?= $_GET['secondURL']; ?>">
                        <div class="searchForm">
                          <input type="hidden" name="act" id="act" value="search">
                          <input type="text" id="startTimeInquiryPro" name="startTime" placeholder="開始時間" value="<?= $startTime; ?>"style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                          <span>~</span>
                          <input type="text" id="endTimeInquiryPro" name="endTime" placeholder="結束時間" value="<?= $endTime; ?>" style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                        </div>
                        <div class="searchBtn">
                          <button class="red" type="button" onclick="javascript:submit()">搜尋</button>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div>畫布</div>
                </div>
              </div>
            </div>


            <div id="newsWarp" class="boxWarp">
              <div id="formTable">
                <div class="tableWarp">
                  <h2 class="red">商場詢價率 = 所有詢價總比數 / 所有商品的瀏覽總數</h2>
                  <div id="searchBar">
                    <div class="searchBarTR">
                      <div class="searchIcon"></div>
                      <form id="searchForm" method="post" action="page_index.php?pageData=<?= $_GET['pageData']; ?>&secondURL=<?= $_GET['secondURL']; ?>">
                        <div class="searchForm">
                          <input type="hidden" name="act" id="act" value="search">
                          <input type="text" id="startTimeInquiryMarket" name="startTime" placeholder="開始時間" value="<?= $startTime; ?>"style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                          <span>~</span>
                          <input type="text" id="endTimeInquiryMarket" name="endTime" placeholder="結束時間" value="<?= $endTime; ?>" style="width:100px;border: 1px solid #e1e1e1;background: #FFF;">
                        </div>
                        <div class="searchBtn">
                          <button class="red" type="button" onclick="javascript:submit()">搜尋</button>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div>畫布</div>
                </div>
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