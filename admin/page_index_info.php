<?php
/*
  //會員數量
  $sqlMemCount = "SELECT count(*) FROM Member_AccountsData";
  $rsMemCount = $Config_db -> query($sqlMemCount);
  $dataMemCount = $rsMemCount -> fetch();

  $memberCount = $dataMemCount['count(*)']; //會員數量
  
  //當日表單數量
  $toTime = date("Y-m-d"); //當天日期
  $sqlFormTo = "select count(*) from Admin_CustomerServiceForm
                WHERE Date(ACSF_CreateTime) = '".$toTime."'
               ";            
  $rsFormTo = $Language_db -> query($sqlFormTo);
  $dataFormTo = $rsFormTo -> fetch(); 

  if($dataFormTo['count(*)'] > 0) { //有資料，表示今日有詢問表單資料
    $countFormTo = $dataFormTo['count(*)'];  //當日表單數量
  } else {
    $countFormTo = 0;
  }

  //詢問表單資訊
  $sqlForm = "select * from Admin_CustomerServiceForm
              WHERE ACSF_Status = 'N'
              ORDER BY ACSF_ID DESC
              limit 5
             ";
  $rsForm = $Language_db -> query($sqlForm);
  $dataForm = $rsForm -> fetchall(); 
    
  //最新詢價單五筆
  $SQLinquiry = "SELECT * 
                 FROM Admin_OrderInquiryList
                 ORDER BY  AOIL_ID DESC
                 limit 5
                 ";
  $RSinquiry = $Language_db -> query($SQLinquiry);  
  $DATAinquiry = $RSinquiry -> fetchall();              

  //最新建立供應商資料五筆
  $sqlSADinfo = "select * from Supplier_AccountData 
                 order by SAD_CreateDate DESC
                 limit 5
                ";
  $rsSADinfo = $Config_db -> query($sqlSADinfo);
  $dataSADinfo = $rsSADinfo -> fetchall();

  //取得商品請求上架前五筆
  $sqlGetAskToSale = "SELECT * 
                      FROM Supplier_ProductDetail 
                      WHERE SPD_SADClaim = 'Y'
                      AND SPD_CheckStatus = 'N'
                      ORDER BY SPD_SADClaimTime DESC 
                      LIMIT 5";
  $rsGetAskToSale = $Language_db -> query($sqlGetAskToSale);
  $dataGetAskToSale = $rsGetAskToSale -> fetchall();

  //取得供應商banner上架請求前五筆
  $SQLbannerSAD = "SELECT * 
                    FROM Supplier_IndexBannerManager
                    WHERE SIBM_SADClaim = 'Y'
                    AND SIBM_CheckStatus = 'N'
                    ORDER BY SIBM_SADClaimTime DESC 
                    LIMIT 5";
  $RSbannerSAD = $Config_db -> query($SQLbannerSAD);
  $DATAbannerSAD = $RSbannerSAD -> fetchall();

  //取得供應商footer上架請求前五筆
  $SQLfooterSAD = "SELECT * 
                    FROM Supplier_IndexFooterManager
                    WHERE SIFM_SADClaim = 'Y'
                    AND SIFM_CheckStatus = 'N'
                    ORDER BY SIFM_SADClaimTime DESC 
                    LIMIT 5";
  $RSfooterSAD = $Config_db -> query($SQLfooterSAD);
  $DATAfooterSAD = $RSfooterSAD -> fetchall();

  //取得供應商AD廣告上架請求前五筆
  $SQLadSAD = "SELECT * 
                FROM Supplier_IndexIconManager
                WHERE SIIM_SADClaim = 'Y'
                AND SIIM_CheckStatus = 'N'
                ORDER BY SIIM_SADClaimTime DESC 
                LIMIT 5";
  $RSadSAD = $Config_db -> query($SQLadSAD);
  $DATAadSAD = $RSadSAD -> fetchall();
*/                
?>
<style>
@media all and (min-width: 768px) and (max-width: 1280px) { /*電腦版*/
    .2row{
      width:49%;
    }
}
@media all and (min-width: 480px) and (max-width: 768px) { /*ipad版*/
    .2row{
      width:47%;
    }
}
@media all and (min-width: 320px) and (max-width: 480px) { /*手機版*/
    .2row{
      width:45%;
    }
}
@media all and (max-width: 320px) { /*其它解析度*/
    .2row{
      width:43%;
    }
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
          <span>管理者後台 - 首頁</span>
        </div>
        <div class="clearBoth"></div>
        <!--
        <div id="toolsBar" class="boxWarp">
          <button class="red">購物記錄</button>
          <button class="yellow">購買清單</button>
          <button class="blue">詢價清單</button>
          <button class="green">詢價記錄</button>
          <button class="red2">瀏覽記錄</button>
        </div>
        -->
        <div id="pageIndexWarp" class="boxWarp">


          
          <div id="infoBoxWarp" class="boxWarp">
            <ul>
              <li>
                <h2 class="red">會員資料</h2>
                <div class="linksWarp">
                  <h3><a href="" title="個人資料管理中心">個人資料管理中心</a></h3>
                  <h3><a href="" title="修改密碼">修改密碼</a></h3>
                  <h3><a href="" title="會員規約">會員規約</a></h3>
                </div>
              </li>
              <li>
                <h2 class="red">問與答</h2>
                <div class="linksWarp">
                  <h3><a href="" title="主類別-1">主類別-1</a></h3>
                  <h3><a href="" title="主類別-2">主類別-2</a></h3>
                  <h3><a href="" title="主類別-3">主類別-3</a></h3>
                </div>
              </li>
              <li>
                <h2 class="red">電子報</h2>
                <div class="linksWarp">
                  <h3><a href="" title="訂閱電子報">訂閱電子報</a></h3>
                  <h3><a href="" title="取消訂閱電子報">取消訂閱電子報</a></h3>
                  <h3><a href="" title="電子報列表">電子報列表</a></h3>
                </div>
              </li>
              <li>
                <h2 class="red">客服中心</h2>
                <div class="linksWarp">
                  <h3><a href="" title="公司資料">公司資料</a></h3>
                  <h3><a href="" title="詢問我們">詢問我們</a></h3>
                  <h3><a href="" title="公告">公告</a></h3>
                </div>
              </li>
            </ul>
          </div>
          <div class="clearBoth"></div>
          <div id="historyWarp" class="boxWarp">
            <h2 class="red">瀏覽記錄
            <div class="moreBtn">
              <a href="" title="MORE">MORE</a>
            </div>
            </h2>
            <ul>
              <li>
                <a href="" title="商品標題">
                  <div class="imgBox red_B imgCarp">
                    <img src="../images/no_img.svg" alt="no_img">
                  </div>
                  <h3 class="red_T">商品標題</h3>
                  <div class="corp">供應商：FIVESTARS</div>
                  <div class="like">
                    <p>評價：</p>
                    <ul>
                      <li class="good"></li>
                      <li class="good"></li>
                      <li class="good"></li>
                      <li class="goodHalf"></li>
                      <li></li>
                    </ul>
                  </div>
                  <div class="price red_T"><span>999,999</span> / 元</div>
                </a>
              </li>
              <li>
                <a href="" title="商品標題">
                  <div class="imgBox red_B imgCarp">
                    <img src="../images/no_img.svg" alt="no_img">
                  </div>
                  <h3 class="red_T">商品標題</h3>
                  <div class="corp">供應商：FIVESTARS</div>
                  <div class="like">
                    <p>評價：</p>
                    <ul>
                      <li class="good"></li>
                      <li class="good"></li>
                      <li class="good"></li>
                      <li class="goodHalf"></li>
                      <li></li>
                    </ul>
                  </div>
                  <div class="price red_T"><span>999,999</span> / 元</div>
                </a>
              </li>
              <li>
                <a href="" title="商品標題">
                  <div class="imgBox red_B imgCarp">
                    <img src="../images/no_img.svg" alt="no_img">
                  </div>
                  <h3 class="red_T">商品標題</h3>
                  <div class="corp">供應商：FIVESTARS</div>
                  <div class="like">
                    <p>評價：</p>
                    <ul>
                      <li class="good"></li>
                      <li class="good"></li>
                      <li class="good"></li>
                      <li class="goodHalf"></li>
                      <li></li>
                    </ul>
                  </div>
                  <div class="price red_T"><span>999,999</span> / 元</div>
                </a>
              </li>
              <li>
                <a href="" title="商品標題">
                  <div class="imgBox red_B imgCarp">
                    <img src="../images/no_img.svg" alt="no_img">
                  </div>
                  <h3 class="red_T">商品標題</h3>
                  <div class="corp">供應商：FIVESTARS</div>
                  <div class="like">
                    <p>評價：</p>
                    <ul>
                      <li class="good"></li>
                      <li class="good"></li>
                      <li class="good"></li>
                      <li class="goodHalf"></li>
                      <li></li>
                    </ul>
                  </div>
                  <div class="price red_T"><span>999,999</span> / 元</div>
                </a>
              </li>
              <li>
                <a href="" title="商品標題">
                  <div class="imgBox red_B imgCarp">
                    <img src="../images/no_img.svg" alt="no_img">
                  </div>
                  <h3 class="red_T">商品標題</h3>
                  <div class="corp">供應商：FIVESTARS</div>
                  <div class="like">
                    <p>評價：</p>
                    <ul>
                      <li class="good"></li>
                      <li class="good"></li>
                      <li class="good"></li>
                      <li class="goodHalf"></li>
                      <li></li>
                    </ul>
                  </div>
                  <div class="price red_T"><span>999,999</span> / 元</div>
                </a>
              </li>
              <li>
                <a href="" title="商品標題">
                  <div class="imgBox red_B imgCarp">
                    <img src="../images/no_img.svg" alt="no_img">
                  </div>
                  <h3 class="red_T">商品標題</h3>
                  <div class="corp">供應商：FIVESTARS</div>
                  <div class="like">
                    <p>評價：</p>
                    <ul>
                      <li class="good"></li>
                      <li class="good"></li>
                      <li class="good"></li>
                      <li class="goodHalf"></li>
                      <li></li>
                    </ul>
                  </div>
                  <div class="price red_T"><span>999,999</span> / 元</div>
                </a>
              </li>
              <li>
                <a href="" title="商品標題">
                  <div class="imgBox red_B imgCarp">
                    <img src="../images/no_img.svg" alt="no_img">
                  </div>
                  <h3 class="red_T">商品標題</h3>
                  <div class="corp">供應商：FIVESTARS</div>
                  <div class="like">
                    <p>評價：</p>
                    <ul>
                      <li class="good"></li>
                      <li class="good"></li>
                      <li class="good"></li>
                      <li class="goodHalf"></li>
                      <li></li>
                    </ul>
                  </div>
                  <div class="price red_T"><span>999,999</span> / 元</div>
                </a>
              </li>
              <li>
                <a href="" title="商品標題">
                  <div class="imgBox red_B imgCarp">
                    <img src="../images/no_img.svg" alt="no_img">
                  </div>
                  <h3 class="red_T">商品標題</h3>
                  <div class="corp">供應商：FIVESTARS</div>
                  <div class="like">
                    <p>評價：</p>
                    <ul>
                      <li class="good"></li>
                      <li class="good"></li>
                      <li class="good"></li>
                      <li class="goodHalf"></li>
                      <li></li>
                    </ul>
                  </div>
                  <div class="price red_T"><span>999,999</span> / 元</div>
                </a>
              </li>
            </ul>
            <div class="clearBoth"></div>
            <div class="historyClear">
              <button class="red">清除記錄</button>
            </div>
          </div>
          <div id="newsWarp" class="boxWarp">
            <h2 class="red">供應商公告
            <div class="moreBtn">
              <a href="" title="MORE">MORE</a>
            </div>
            </h2>
            <div class="tableWarp">
              <table>
                <tr>
                  <td class="num titleTxt">編號</td>
                  <td class="txt titleTxt">標題</td>
                  <td class="date titleTxt">發佈日期</td>
                </tr>
                <tr>
                  <td class="num">01</td>
                  <td class="leftTxt">
                    <a href="" title="標題文字 - 1"><h3>標題文字 - 1</h3></a>
                  </td>
                  <td class="date">2015.01.01</td>
                </tr>
                <tr>
                  <td class="num">02</td>
                  <td class="leftTxt">
                    <a href="" title="標題文字 - 2"><h3>標題文字 - 2</h3></a>
                  </td>
                  <td class="date">2015.01.01</td>
                </tr>
                <tr>
                  <td class="num">03</td>
                  <td class="leftTxt">
                    <a href="" title="標題文字 - 3"><h3>標題文字 - 3</h3></a>
                  </td>
                  <td class="date">2015.01.01</td>
                </tr>
              </table>
            </div>
          </div>
        
        </div>
      </section>

    </div>
  </div>
</div>