<?php
#列出全部供應觴
$SQLsupplierData = "SELECT * FROM Supplier_AccountData ORDER BY SAD_ID DESC ";
$RSsupplierData = $Config_db->query($SQLsupplierData);
$DATAsupplierData = $RSsupplierData->fetchAll(PDO::FETCH_ASSOC); 

//列出供應商名稱
foreach($DATAsupplierData as $key=>$val){
  $arraySupplierName[$val['SAD_ID']] = sadAccountSearch($Config_db,$val['SAD_ID']);
}
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
                      <td class="num titleTxt" style="width:120px;">供應商</td>
                      <td class="leftTxt">
                        <select name="supplier">
                          <option value="0">請選擇...</option>
                        <?php
                        foreach($arraySupplierName as $key=>$val) {
                          echo "<option value='".$key."'>".$val."</option>";
                        }
                        ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">訂單狀態</td>
                      <td class="leftTxt">
                        <select name="status">
                          <option value="0">請選擇...</option>
                          <option value="noShipping">未出貨</option>
                          <option value="shipped">已出貨</option>
                          <option value="refund">退貨/退款</option>
                          <option value="replacement">換貨</option>
                          <option value="complaints">客訴</option>
                          <option value="invaild">作廢</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">結帳狀況</td>
                      <td class="leftTxt">
                        <select name="productStatusPayment">
                          <option value="0">請選擇...</option>
                          <option value="N">未付款</option>
                          <option value="Y">已付款</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">運費付款狀態</td>
                      <td class="leftTxt">
                        <select name="freight">
                          <option value="0">請選擇...</option>
                          <option value="N">未付款</option>
                          <option value="Y">已付款</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt" style="width:120px;">訂單編號</td>
                      <td class="leftTxt">
                        <input type="text" name="orderNum" placeholder="請輸入要查詢的訂單編號">
                      </td>
                    </tr>
                  </table>
              </div><!--<div id="formTable">-->  
            </div>
          </div>
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
        </div>  
      </section>
      </form>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

