<?php
  #列出全部群組資料
  $sqlSADgroup = "SELECT * 
                  FROM Admin_SupplierGroup 
                  ORDER BY ASG_ID DESC ";
  $rsSADgroup = $Language_db->query($sqlSADgroup);
  $dataSADgroup = $rsSADgroup->fetchAll(PDO::FETCH_ASSOC); 
?>
<div id="pageMainWarp">
  <div id="pageWarp">
    <div id="pageWarpTR">
      <?php
      include('aside.php');
      ?>
      <form id="searchForm" name="searchForm" action="page_index.php?pageData=<?=$subDirectory?>" method="post">
        <input type="hidden" name="act" value="search">
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
              <h2 class="red">資料查詢</h2>
              <div class="tableWarp">
                <div id="formTable">  
                  <table>
                    <tr>
                      <td class="num titleTxt" style="width:140px;">查詢會員類型</td>
                      <td class="leftTxt">
                        <select name="type">
                          <option value="0">請選擇...</option>
                          <option value="general">一般會員</option>
                          <option value="company">公司會員</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">查詢是否通過驗證</td>
                      <td class="leftTxt">
                        <select name="check">
                          <option value="0">請選擇...</option>
                          <option value="Y">是</option>
                          <option value="N">否</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">帳號</td>
                      <td class="leftTxt">
                        <input type="text" name="account" placeholder="請輸入要查詢的帳號...">
                      </td>
                    </tr>
                  </table>
                </div><!--formTable-->  
              </div><!--tableWarp-->
            </div><!--newsWarp-->
            <div class="pageBtnWarp">
              <ul>
                <li>
                  <button type="button" class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>'">
                    返回列表
                  </button>
                </li>
                <li>
                  <input type="submit" class="red" value="送出查詢">
                </li>
              </ul>
            </div><!--pageBtnWarp-->
          </div><!--pageIndexWarp-->
        </section>
      </form>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>
