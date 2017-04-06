<!--pages-starts-->
<div class="pages">
	<div class="container">
		<ol class="breadcrumb">
		  <li><a href="index.html">首頁</a></li>
		  <li class="active">詢問我們</li>
		</ol>

    <div style="margin:10px;">
      <div style="text-align:left;">
      	<table class="table table-striped">
          <tr>
            <td style="padding:20px;">姓名</td>
            <td>
              <input type="text" placeholder="姓名" style="width:50%;height:30px;margin:10px;">
            </td>
          </tr>
          <tr>
            <td style="padding:20px;">電子信箱</td>
            <td>
              <input type="text" placeholder="email" style="width:50%;height:30px;margin:10px;">
            </td>
          </tr>
          <tr>
            <td style="padding:20px;">詢問事項</td>
            <td>          
              <textarea rows="3" placeholder="詢問事項" style="width:90%;margin:10px;height:120px;"></textarea>
            </td>
          </tr>
          <tr>
            <td style="padding:20px;">驗證碼</td>
            <td>
              <input type="text" style="margin:10px;">
              <img src="checkCode.php" style="margin:10px;" name="verify_code" id="verify_code">
              <a href="javascript:void()" onclick="document.getElementById('verify_code').src='checkCode.php'">刷新</a>
            </td>
          </tr>
          <tr>
            <td colspan="2" style="text-align:center;">
              <button class="btn btn-success">送出</button>
            </td>
          </tr>
        </table>
      </div>
    </div>
	</div>	
</div>	