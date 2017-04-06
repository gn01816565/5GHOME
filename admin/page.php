<div id="pageMainWarp">
  <div id="pageWarp">
    <div id="pageWarpTR">
      <?php
        include('aside.php');
      ?>
      <section id="rightWarp">
        <div id="placeWarp" class="boxWarp">
          <div class="title red_T">目前位置：</div>
          <span>主按鈕標題</span>
          <span>></span>
          <a href="" title="次按鈕標題">次按鈕標題</a>
        </div>
        <div class="clearBoth"></div>
        <div id="pageformWarp" class="boxWarp">
          <h2 class="red_T">主按鈕標題<span> / 次按鈕標題</span></h2>
          <div id="searchBar">
            <div class="searchBarTR">
              <div class="searchIcon"></div>
              <div class="searchForm">
                <input type="text" placeholder="請輸入搜尋本區的關鍵字...">
              </div>
              <div class="searchBtn">
                <button class="red">搜尋</button>
              </div>
            </div>
          </div>
          <div class="clearBoth"></div>
          <div id="toolsBar" class="boxWarp">
            <button class="red">新增</button>
            <button class="yellow">全部勾選</button>
            <button class="blue">取消勾選</button>
            <button class="green">刪除</button>
          </div>
          <div id="formTable">
            <div class="boxWarp">
              <table>
                <tr>
                  <td class="title">編號</td>
                  <td class="txt">標題</td>
                  <td class="date">發佈日期</td>
                  <td class="btnTools">修改內容</td>
                </tr>
                <tr>
                  <td class="title">01</td>
                  <td class="txt leftTxt">
                    <input type="checkbox" checked>
                    <label>標題文字 - 1</label>
                  </td>
                  <td class="date">2015.01.01</td>
                  <td>
                    <button class="yellow toolsBtn">修改</button>
                  </td>
                </tr>
                <tr>
                  <td class="title">02</td>
                  <td class="txt leftTxt">
                    <input type="checkbox">
                    <label>標題文字 - 2</label>
                  </td>
                  <td class="date">2015.01.01</td>
                  <td>
                    <button class="yellow toolsBtn">修改</button>
                  </td>
                </tr>
                <tr>
                  <td class="title">02</td>
                  <td class="txt leftTxt">
                    <input type="checkbox">
                    <label>標題文字 - 3</label>
                  </td>
                  <td class="date">2015.01.01</td>
                  <td>
                    <button class="yellow toolsBtn">修改</button>
                  </td>
                </tr>
              </table>
            </div>
            <div class="boxWarp">
              <table>
                <tr>
                  <td class="title">產品名稱</td>
                  <td class="leftTxt">
                    <input type="text" placeholder="請輸入產品名稱...">
                  </td>
                </tr>
                <tr>
                  <td class="title">上架 / 下架</td>
                  <td class="leftTxt">
                    <input type="radio" name="type" value="上架" checked>
                    <label>上架</label>
                    <input type="radio" name="type" value="下架">
                    <label>下架</label>
                  </td>
                </tr>
                <tr>
                  <td class="title">產品編號</td>
                  <td class="leftTxt">
                    <input type="text" placeholder="請輸入產品編號...">
                  </td>
                </tr>
                <tr>
                  <td class="title">內文說明</td>
                  <td class="leftTxt">
                    <textarea rows="5" placeholder="請輸入內文說明..."></textarea>
                  </td>
                </tr>
                <tr>
                  <td class="title">照片上傳</td>
                  <td>
                    <input type="file" id="photosUpload">
                    <label class="yellow btnUpload" for="photosUpload">瀏覽檔案</label>
                    <button class="red">新增</button>
                    <button class="blue">刪除</button>
                  </td>
                </tr>
              </table>
            </div>
            <div class="boxWarp">
              <table>
                <tr>
                  <td class="title">產品名稱</td>
                  <td class="leftTxt">產品名稱</td>
                </tr>
                <tr>
                  <td class="title">上架 / 下架</td>
                  <td class="leftTxt">上架</td>
                </tr>
                <tr>
                  <td class="title">產品編號</td>
                  <td class="leftTxt">1234567-abc</td>
                </tr>
                <tr>
                  <td class="title">內容敘述</td>
                  <td class="leftTxt">文字內容</td>
                </tr>
                <tr>
                  <td class="title">照片上傳</td>
                  <td class="leftTxt">1234567-abc.jpg</td>
                </tr>
              </table>
            </div>
          </div>
          <?php
            include('page_num.php');
          ?>
          <div class="pageBtnWarp">
            <ul>
              <li><button class="green">返回列表</button></li>
              <li><button class="yellow">重新填寫</button></li>
              <li><button class="red">確定送出</button></li>
            </ul>
          </div>
        </div>
      </section>     
      <div class="clearBoth"></div>
    </div>
  </div>
</div>