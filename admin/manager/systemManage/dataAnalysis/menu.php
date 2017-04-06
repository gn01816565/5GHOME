<div id="toolsBar" class="boxWarp">
  <button type="button" onclick="location.href='page_index.php?pageData=dataAnalysis&secondURL=pageClick'"        <?php if($_GET['secondURL']=='pageClick' || !isset($_GET['secondURL']) || $_GET['secondURL']=='') {echo "class='red2'";} ?>>各頁面點擊分析</button>
  <button type="button" onclick="location.href='page_index.php?pageData=dataAnalysis&secondURL=pageClickProduct'" <?php if($_GET['secondURL']=='pageClickProduct') {echo "class='red2'";} ?>>各商品點擊分析</button>
  <button type="button" onclick="location.href='page_index.php?pageData=dataAnalysis&secondURL=orderProduct'"     <?php if($_GET['secondURL']=='orderProduct') {echo "class='red2'";} ?>>銷售商品統計</button>
  <button type="button" onclick="location.href='page_index.php?pageData=dataAnalysis&secondURL=inquiryProduct'"     <?php if($_GET['secondURL']=='inquiryProduct') {echo "class='red2'";} ?>>詢價商品統計</button>
  <button type="button" onclick="location.href='page_index.php?pageData=dataAnalysis&secondURL=SADorderRanking'"     <?php if($_GET['secondURL']=='SADorderRanking') {echo "class='red2'";} ?>>供應商銷售排名統計</button>
  <button type="button" onclick="location.href='page_index.php?pageData=dataAnalysis&secondURL=searchKeyword'"          <?php if($_GET['secondURL']=='searchKeyword') {echo "class='red2'";} ?>>搜尋關鍵字統計</button>
  <button type="button" onclick="location.href='page_index.php?pageData=dataAnalysis&secondURL=bannerClick'"          <?php if($_GET['secondURL']=='bannerClick') {echo "class='red2'";} ?>>上方橫幅廣告統計</button>
  <button type="button" onclick="location.href='page_index.php?pageData=dataAnalysis&secondURL=footerClick'"          <?php if($_GET['secondURL']=='footerClick') {echo "class='red2'";} ?>>下方橫幅廣告統計</button>
  <button type="button" onclick="location.href='page_index.php?pageData=dataAnalysis&secondURL=adClick'"          <?php if($_GET['secondURL']=='adClick') {echo "class='red2'";} ?>>側邊廣告統計</button>
</div> 