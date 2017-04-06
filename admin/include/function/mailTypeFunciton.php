<?php

#會員註冊 - 寄送驗證信件(一般會員)
#註冊名字(全名)、連結路徑
function registerMemberCheckMail($name, $mailURL) {
  $content = "";
  /*
  $content .= "
    <table style='width:100%;border-style:solid;border-width:1px;'>
      <tr>
        <td>
          <img src='http://fs.kingtechcorp.com/images/logo.jpg' alt='logo' style='width:35%;'>
        </td>
      </tr>  
    </table>
    ";
  */  
  $content .= "
  <table>
    <tr>
      <td>
        親愛的 ".$name." <br><br>
        感謝您註冊FIVESTARS的會員
      </td>
    </tr>
    <tr>
      <td> 
        --------------------------------------------------------------------------------<br>
        【FIVESTARS】恭喜您已完成註冊，現在只差最後一步<br>
        --------------------------------------------------------------------------------<br>
        ※請進入以下連結開通會員帳號<br>
        <br>
        <br>
        驗證路徑:<a href='".$mailURL."' target='_blank'>".$mailURL."</a><br>
        <br>
        <br>
        ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
        <br>
        --------------------------------------------------------------------------------<br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
        <br>
        <br>
        <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>


      </td>
    </tr>
  </table>  
  ";  
  return $content;
}

#會員註冊 - 驗證完成信件(一般會員)
#會員姓名、帳號
function registerMemberMailOK($name, $account) {
  $content = "";

  $content .= "
  <table>
    <tr>
      <td>
        親愛的 ".$name." <br><br>
        感謝您註冊FIVESTARS的會員
      </td>
    </tr>
    <tr>
      <td> 
        --------------------------------------------------------------------------------<br>
        【FIVESTARS】恭喜您已完成驗證。<br>
        --------------------------------------------------------------------------------<br>
        ※您所註冊的帳號為：".$account."
        <br>
        <br>
        ※帳號開通後，可開始使用FIVESTARS的購物功能。<br>
        ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
        <br>
        --------------------------------------------------------------------------------<br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
        <br>
        <br>
        <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>

      </td>
    </tr>
  </table>  
  ";  
  return $content;
}

#會員註冊 - 寄送驗證信件(企業會員)
#註冊名字(全名)、連結路徑
function registerCompanyMemberCheckMail($name, $mailURL) {
  $content = "";
  /*
  $content .= "
    <table style='width:100%;border-style:solid;border-width:1px;'>
      <tr>
        <td>
          <img src='http://fs.kingtechcorp.com/images/logo.jpg' alt='logo' style='width:35%;'>
        </td>
      </tr>  
    </table>
    ";
  */  
  $content .= "
  <table>
    <tr>
      <td>
        親愛的 ".$name." <br><br>
        感謝您註冊FIVESTARS的企業會員
      </td>
    </tr>
    <tr>
      <td> 
        --------------------------------------------------------------------------------<br>
        【FIVESTARS】恭喜您已完成註冊，現在只差最後一步<br>
        --------------------------------------------------------------------------------<br>
        ※請進入以下連結開通會員帳號<br>
        <br>
        <br>
        驗證路徑:<a href='".$mailURL."' target='_blank'>".$mailURL."</a><br>
        <br>
        <br>
        ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
        <br>
        --------------------------------------------------------------------------------<br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
        <br>
        <br>
        <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>


      </td>
    </tr>
  </table>  
  ";  
  return $content;
}

#會員註冊 - 驗證完成信件(企業會員)
#會員姓名、帳號
function registerCompanyMemberMailOK($name, $account) {
  $content = "";

  $content .= "
  <table>
    <tr>
      <td>
        親愛的 ".$name." <br><br>
        感謝您註冊FIVESTARS的企業會員
      </td>
    </tr>
    <tr>
      <td> 
        --------------------------------------------------------------------------------<br>
        【FIVESTARS】恭喜您已完成驗證。<br>
        --------------------------------------------------------------------------------<br>
        ※您所註冊的帳號為：".$account."
        <br>
        <br>
        ※帳號開通後，可開始使用FIVESTARS的購物功能。<br>
        ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
        <br>
        --------------------------------------------------------------------------------<br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
        <br>
        <br>
        <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>

      </td>
    </tr>
  </table>  
  ";  
  return $content;
}


#會員 - 忘記密碼
#會員mail、密碼路徑
function forgetPWmail($mail, $mailContent) {
  $content = "";
  $content = "
    <table>
      <tr>
        <td>
          親愛的 ".$mail." <br><br>
          您已申請重新設定您在FIVESTARS的會員密碼
        </td>
      </tr>
      <tr>
        <td> 
          --------------------------------------------------------------------------------<br>
          【FIVESTARS】請從以下修改密碼路徑進入修改。<br>
          --------------------------------------------------------------------------------<br>
          ※修改密碼路徑：<br>
          <a href='".$mailContent."'>".$mailContent."</a>
          <br>
          <br>
          ---此連結將在數小時後失效。<br>
          ---若您未提出修改密碼的申請，請忽略此訊息。<br>
          <br>
          <br>
          ※若想修改帳號資料，請進入到會員中心做修改動作。<br>
          ※密碼更改過後，請使用新密碼登入。<br>
          ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
          <br>
          --------------------------------------------------------------------------------<br>
          ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
          <br>
          ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
          <br>
          ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
          <br>
          <br>
          <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>
        </td>
      </tr>
    </table> 
  ";
  return $content;
}

#會員 - 訂單完成
#訂單編號、會員資料(二維陣列)、產品明細資料(二維陣列)、發票資料(二維)、金流及物流方式(陣列)、運費、總金額
function memberOrderOK($orderNum, $arrayMemberData, $arrayOrderProduct, $arrayInvoice, $arrayPayment, $shipment, $totalPrice){

$content = "
  <table style='width:100%;'>
    <tr>
      <td style='text-align:center;'>
        <img src='http://fs.kingtechcorp.com/images/logo.jpg' alt='logo' style='width:30%'> 
        <h2 style='font-size:14px;'>訂單資料</h2>
      </td>
    </tr>
  </table>

  <table style='width:100%;border-top:3px #B73B35 dashed;border-bottom:3px #B73B35 solid;'>  
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        親愛的會員您好，您的訂單資料已經建立成功，明細如下：
      </td>
    </tr>
            
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>訂單資訊</td>
          </tr>
          <tr>
            <td width='150' align='center' style='background-color:#F7941D;color:white;'>
              訂單編號
            </td>
            <td>
              ".$orderNum."
            </td>
          </tr>
        </table>
      </td>
    </tr>    
    
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' rules='all' cellpadding='5' style='width:80%;border:1px solid;border-color:#AAAAAA;'>
          <tr>
            <td align='center' colspan='2' style='background-color:#B73B35;color:white;'>個人資料</td>
          </tr>
          ";
    #個人資料陣列      
    foreach($arrayMemberData as $key=>$val) {
    $content .= "      
          <tr>
            <td width='150' style='text-align:center;background-color:#F7941D;color:white;'>".$val[0]."</td>
            <td>".$val[1]."</td>
          </tr>
          ";
    } //foreach($arrayMemberData as $key=>$val) {
    $content .= "
        </table>
      </td>
    </tr>

    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>
          <tr style='text-align:center;background-color:#B73B35;color:white;'>
            <td>商品名稱</td>
            <td>商品規格</td>
            <td>商品數量</td>
            <td width='80'>價格</td>
          </tr>
          ";
    #產品列表      
    foreach($arrayOrderProduct as $key=>$val) {      
    $content .="        
          <tr>
            <td>".$val['name']."</td>
            <td>".$val['nom']."</td>
            <td align='center' width='80'>".$val['amount']."</td>
            <td align='center'>NT.".$val['price']."</td>
          </tr>
          ";
    } //foreach($arrayOrderProduct as $key=>$val) {   
    $content .="  
          <tr style='text-align:center;background-color:#B73B35;color:white;'>
            <td colspan='2' style='text-align:right;'>
              運費：NT.".$shipment."
              &nbsp;&nbsp;&nbsp;&nbsp;
              總計：NT.".$totalPrice."
            </td>
            <td>
              總金額：
            </td>
            <td>
              NT.".($shipment+$totalPrice)."
            </td>
          </tr>
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>發票資訊</td>
          </tr>
          ";
  #發票資訊， $array[][]，0->名稱，1->內容        
  foreach($arrayInvoice as $key => $val) {
  $content.="
          <tr>
            <td width='150' align='center' style='background-color:#F7941D;color:white;'>
              ".$val[0]."
            </td>
            <td>
              ".$val[1]."
            </td>
          </tr>
            ";
  } //foreach($arrayInvoice as $key => $val) {         
  $content.="        
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>
  
        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>其它資訊</td>
          </tr>
          ";
  #金流&物流， $array[][]，0->名稱，1->內容        
  foreach($arrayPayment as $key => $val) {
  $content.="
          <tr>
            <td width='150' align='center' style='background-color:#F7941D;color:white;'>
              ".$val[0]."
            </td>
            <td>
              ".$val[1]."
            </td>
          </tr>
            ";
  } //foreach($arrayInvoice as $key => $val) {         
  $content.="        
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>備註</td>
          </tr>
          <tr>
            <td colspan='4'>
              <span style='color:#B73B35;'>注意事項</span>
              <br>
              ※請注意選擇的收件地址，我們會以您所選擇輸入的地址為主。<br>
              ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
            </td>
          </tr>
        </table>

      </td>
    </tr>
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>
  </table>

  <table style='width:100%;'>  
    <tr>
      <td>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
        <br>
        <br>
        <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>
      </td>
    </tr>
  </table>
  ";
  return $content;
}


#會員 - 申請退貨、退款
#訂單編號、會員資料(二維陣列)、產品明細資料(二維陣列)、發票資料(二維)、運費、總金額、申請模式(退款/退貨、換貨)、申請原因
function memberOrderReturn($orderNum, $arrayMemberData, $arrayOrderProduct, $arrayInvoice, $shipment, $totalPrice, $applyType, $remarks){

$content = "
  <table style='width:100%;'>
    <tr>
      <td style='text-align:center;'>
        <img src='http://fs.kingtechcorp.com/images/logo.jpg' alt='logo' style='width:30%'> 
        <h2 style='font-size:14px;'>訂單資料</h2>
      </td>
    </tr>
  </table>

  <table style='width:100%;border-top:3px #B73B35 dashed;border-bottom:3px #B73B35 solid;'>  
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        親愛的會員您好，您所申請 ".$applyType." 的訂單資訊如下：
      </td>
    </tr>
            
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>訂單資訊</td>
          </tr>
          <tr>
            <td width='150' align='center' style='background-color:#F7941D;color:white;'>
              訂單編號
            </td>
            <td>
              ".$orderNum."
            </td>
          </tr>
        </table>
      </td>
    </tr>    
    
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' rules='all' cellpadding='5' style='width:80%;border:1px solid;border-color:#AAAAAA;'>
          <tr>
            <td align='center' colspan='2' style='background-color:#B73B35;color:white;'>個人資料</td>
          </tr>
          ";
    #個人資料陣列      
    foreach($arrayMemberData as $key=>$val) {
    $content .= "      
          <tr>
            <td width='150' style='text-align:center;background-color:#F7941D;color:white;'>".$val[0]."</td>
            <td>".$val[1]."</td>
          </tr>
          ";
    } //foreach($arrayMemberData as $key=>$val) {
    $content .= "
        </table>
      </td>
    </tr>

    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>
          <tr style='text-align:center;background-color:#B73B35;color:white;'>
            <td>商品名稱</td>
            <td>商品規格</td>
            <td>商品數量</td>
            <td width='80'>價格</td>
          </tr>
          ";
    #產品列表      
    foreach($arrayOrderProduct as $key=>$val) {      
    $content .="        
          <tr>
            <td>".$val['name']."</td>
            <td>".$val['nom']."</td>
            <td align='center' width='80'>".$val['amount']."</td>
            <td align='center'>NT.".$val['price']."</td>
          </tr>
          ";
    } //foreach($arrayOrderProduct as $key=>$val) {   
    $content .="  
          <tr style='text-align:center;background-color:#B73B35;color:white;'>
            <td colspan='2' style='text-align:right;'>
              運費：NT.".$shipment."
              &nbsp;&nbsp;&nbsp;&nbsp;
              總計：NT.".$totalPrice."
            </td>
            <td>
              總金額：
            </td>
            <td>
              NT.".($shipment+$totalPrice)."
            </td>
          </tr>
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>發票資訊</td>
          </tr>
          ";
  #發票資訊， $array[][]，0->名稱，1->內容        
  foreach($arrayInvoice as $key => $val) {
  $content.="
          <tr>
            <td width='150' align='center' style='background-color:#F7941D;color:white;'>
              ".$val[0]."
            </td>
            <td>
              ".$val[1]."
            </td>
          </tr>
            ";
  } //foreach($arrayInvoice as $key => $val) {         
  $content.="        
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>申訴資訊</td>
          </tr>
          <tr>
            <td width='150' align='center' style='background-color:#F7941D;color:white;'>
              申請模式
            </td>
            <td>
              ".$applyType."
            </td>
          </tr>    
          <tr>
            <td width='150' align='center' style='background-color:#F7941D;color:white;'>
              申請原因
            </td>
            <td>
              ".$remarks."
            </td>
          </tr>  
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>備註</td>
          </tr>
          <tr>
            <td colspan='4'>
              <span style='color:#B73B35;'>注意事項</span>
              <br>
              ※此內容資訊依據您當初建立的訂單內容為準。<br>
              ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
            </td>
          </tr>
        </table>

      </td>
    </tr>
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>
  </table>

  <table style='width:100%;'>  
    <tr>
      <td>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
        <br>
        <br>
        <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>
      </td>
    </tr>
  </table>
  ";
  return $content;
}

#會員 - 詢價單建立(直接詢價)
#詢價編號、會員資料(陣列)、詢價車產品明細(陣列)、自定產品明細(陣列)
function inquiryOK($inquiryNum, $arrayMemberData, $arrayInquiryProduct, $arrayInquiryProductCreate) {
  $content = "
  <table style='width:100%;'>
    <tr>
      <td style='text-align:center;'>
        <img src='http://fs.kingtechcorp.com/images/logo.jpg' alt='logo' style='width:30%'> 
        <h2 style='font-size:14px;'>詢價單資料</h2>
      </td>
    </tr>
  </table>

  <table style='width:100%;border-top:3px #B73B35 dashed;border-bottom:3px #B73B35 solid;'>  
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        親愛的會員您好，您的詢價單資料已經建立成功，明細如下：
      </td>
    </tr>
            
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>詢價單資訊</td>
          </tr>
          <tr>
            <td width='150' align='center' style='background-color:#F7941D;color:white;'>
              詢價單編號
            </td>
            <td>
              ".$inquiryNum."
            </td>
          </tr>
        </table>
      </td>
    </tr>    
    
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' rules='all' cellpadding='5' style='width:80%;border:1px solid;border-color:#AAAAAA;'>
          <tr>
            <td align='center' colspan='2' style='background-color:#B73B35;color:white;'>個人資料</td>
          </tr>
          ";
    #個人資料陣列      
    foreach($arrayMemberData as $key=>$val) {
    $content .= "      
          <tr>
            <td width='150' style='text-align:center;background-color:#F7941D;color:white;'>".$val[0]."</td>
            <td>".$val[1]."</td>
          </tr>
          ";
    } //foreach($arrayMemberData as $key=>$val) {
    $content .= "
        </table>
      </td>
    </tr>

    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
                ";
    //詢價車判斷  
    if($arrayInquiryProduct != 0) {
      $content.="
        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>
          <tr style='text-align:center;background-color:#B73B35;color:white;'>
            <td>商品名稱</td>
            <td>商品規格</td>
            <td>商品數量</td>
            <td>參考金額</td>
            <td>參考供應商</td>
            <td>說明</td>
          </tr>
          ";
      #產品列表            
      foreach($arrayInquiryProduct as $key=>$val) {      
      $content .="        
            <tr>
              <td>".$val['name']."</td>
              <td>".$val['nom']."</td>
              <td align='center' width='80'>".$val['amount']."</td>
              <td align='center' width='80'>".$val['price']."</td>
              <td>".$val['sadName']."</td>
              <td>".$val['remark']."</td>
            </tr>
            ";
      } //foreach($arrayOrderProduct as $key=>$val) {   
      $content .="  
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>
        ";
    } //if($arrayInquiryProduct != 0) {       
    $content.="
        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>
          <tr style='text-align:center;background-color:#B73B35;color:white;'>
            <td>商品名稱</td>
            <td>商品規格</td>
            <td>商品數量</td>
            <td>說明</td>
          </tr>
          ";
    //自建詢價單      
    #產品列表      
    foreach($arrayInquiryProductCreate as $key=>$val) {      
    $content .="        
          <tr>
            <td>".$val['name']."</td>
            <td>".$val['nom']."</td>
            <td align='center' width='80'>".$val['amount']."</td>
            <td>".$val['remark']."</td>
          </tr>
          ";
    } //foreach($arrayOrderProduct as $key=>$val) {   
    $content .="  
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>備註</td>
          </tr>
          <tr>
            <td colspan='4'>
              <span style='color:#B73B35;'>注意事項</span>
              <br>
              ※感謝您的詢問，您的詢價單已建立。<br>
              ※請注意輸入的電話/手機、電子信箱等聯繫方式是否正確，我們會再以此資訊與您聯絡。<br>
              ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
            </td>
          </tr>
        </table>

      </td>
    </tr>
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>
  </table>

  <table style='width:100%;'>  
    <tr>
      <td>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
        <br>
        <br>
        <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>
      </td>
    </tr>
  </table>
  ";
  return $content;
}

#供應商使用 - 訂單出貨單
#訂單編號、會員資料(二維陣列)、產品明細資料(二維陣列)、發票資料(二維)、運費、總金額
function shippedMail($orderNum, $arrayMemberData, $arrayOrderProduct, $arrayInvoice, $arrayLogic, $shipment, $totalPrice) {

$content = "
  <table style='width:100%;'>
    <tr>
      <td style='text-align:center;'>
        <img src='http://fs.kingtechcorp.com/images/logo.jpg' alt='logo' style='width:30%'> 
        <h2 style='font-size:14px;'>產品出貨單</h2>
      </td>
    </tr>
  </table>

  <table style='width:100%;border-top:3px #B73B35 dashed;border-bottom:3px #B73B35 solid;'>  
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        親愛的會員您好，您的訂單已經出貨，一般運送期為三到五個工作日，訂單資料如下：
      </td>
    </tr>
            
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>訂單資訊</td>
          </tr>
          <tr>
            <td width='150' align='center' style='background-color:#F7941D;color:white;'>
              訂單編號
            </td>
            <td>
              ".$orderNum."
            </td>
          </tr>
        </table>
      </td>
    </tr>    
    
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' rules='all' cellpadding='5' style='width:80%;border:1px solid;border-color:#AAAAAA;'>
          <tr>
            <td align='center' colspan='2' style='background-color:#B73B35;color:white;'>個人資料</td>
          </tr>
          ";
    #個人資料陣列      
    foreach($arrayMemberData as $key=>$val) {
    $content .= "      
          <tr>
            <td width='150' style='text-align:center;background-color:#F7941D;color:white;'>".$val[0]."</td>
            <td>".$val[1]."</td>
          </tr>
          ";
    } //foreach($arrayMemberData as $key=>$val) {
    $content .= "
        </table>
      </td>
    </tr>

    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>
          <tr style='text-align:center;background-color:#B73B35;color:white;'>
            <td>商品名稱</td>
            <td>商品規格</td>
            <td>商品數量</td>
            <td width='80'>價格</td>
          </tr>
          ";
    #產品列表      
    foreach($arrayOrderProduct as $key=>$val) {      
    $content .="        
          <tr>
            <td>".$val['name']."</td>
            <td>".$val['nom']."</td>
            <td align='center' width='80'>".$val['amount']."</td>
            <td align='center'>NT.".$val['price']."</td>
          </tr>
          ";
    } //foreach($arrayOrderProduct as $key=>$val) {   
    $content .="  
          <tr style='text-align:center;background-color:#B73B35;color:white;'>
            <td colspan='2' style='text-align:right;'>
              運費：NT.".$shipment."
              &nbsp;&nbsp;&nbsp;&nbsp;
              總計：NT.".$totalPrice."
            </td>
            <td>
              總金額：
            </td>
            <td>
              NT.".($shipment+$totalPrice)."
            </td>
          </tr>
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>發票資訊</td>
          </tr>
          ";
  #發票資訊， $array[][]，0->名稱，1->內容        
  foreach($arrayInvoice as $key => $val) {
  $content.="
          <tr>
            <td width='150' align='center' style='background-color:#F7941D;color:white;'>
              ".$val[0]."
            </td>
            <td>
              ".$val[1]."
            </td>
          </tr>
            ";
  } //foreach($arrayInvoice as $key => $val) {         
  $content.="        
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>物流資訊</td>
          </tr>
        ";

  #物流資訊， $array[][]，0->名稱，1->內容        
  foreach($arrayLogic as $key => $val) {
  $content.="
          <tr>
            <td width='150' align='center' style='background-color:#F7941D;color:white;'>
              ".$val[0]."
            </td>
            <td>
              ".$val[1]."
            </td>
          </tr>
            ";
  } //foreach($arrayInvoice as $key => $val) {         
  $content.="        
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>      

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>備註</td>
          </tr>
          <tr>
            <td colspan='4'>
              <span style='color:#B73B35;'>注意事項</span>
              <br>
              ※感謝您的訂購，出貨完成可至會員中心 -> 訂單紀錄裡，對訂單做評分，感謝。<br>
              ※請注意選擇的收件地址，我們會以您所選擇輸入的地址為主。<br>
              ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
            </td>
          </tr>
        </table>

      </td>
    </tr>
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>
  </table>

  <table style='width:100%;'>  
    <tr>
      <td>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
        <br>
        <br>
        <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>
      </td>
    </tr>
  </table>
  ";
  return $content;  
}


#管理者使用 - 詢價單發送(給供應商)
#詢價編號、產品明細(陣列)、管理者備註
function inquirySupplierSend($inquiryNum, $arrayInquiryProduct, $remarks) {
  $content = "
  <table style='width:100%;'>
    <tr>
      <td style='text-align:center;'>
        <img src='http://fs.kingtechcorp.com/images/logo.jpg' alt='logo' style='width:30%'> 
        <h2 style='font-size:14px;'>詢價單資料</h2>
      </td>
    </tr>
  </table>

  <table style='width:100%;border-top:3px #B73B35 dashed;border-bottom:3px #B73B35 solid;'>  
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        以下為系統管理者發佈的詢價資料，請再查閱後回覆內容資料，感謝。
      </td>
    </tr>
            
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>詢價單資訊</td>
          </tr>
          <tr>
            <td width='150' align='center' style='background-color:#F7941D;color:white;'>
              詢價單編號
            </td>
            <td>
              ".$inquiryNum."
            </td>
          </tr>
        </table>
      </td>
    </tr>    
    
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>
          <tr style='text-align:center;background-color:#B73B35;color:white;'>
            <td>商品名稱</td>
            <td>商品規格</td>
            <td>商品數量</td>
            <td>參考金額</td>
            <td>說明</td>
          </tr>
          ";
    #產品列表      
    foreach($arrayInquiryProduct as $key=>$val) {      
    $content .="        
          <tr>
            <td>".$val['name']."</td>
            <td>".$val['nom']."</td>
            <td align='center' width='80'>".$val['amount']."</td>
            <td align='center' width='80'>".$val['price']."</td>
            <td>".$val['remark']."</td>
          </tr>
          ";
    } //foreach($arrayOrderProduct as $key=>$val) {   
    $content .="  
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>管理者留言</td>
          </tr>
          <tr>
            <td>".nl2br($remarks)."</td>
          </tr>  
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>備註</td>
          </tr>
          <tr>
            <td colspan='4'>
              <span style='color:#B73B35;'>注意事項</span>
              <br>
              ※請進入管理後台 -> 報價管理 -> 待報價管理中回覆訊息。<br>
              ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
            </td>
          </tr>
        </table>

      </td>
    </tr>
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>
  </table>

  <table style='width:100%;'>  
    <tr>
      <td>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
        <br>
        <br>
        <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>
      </td>
    </tr>
  </table>
  ";
  return $content;
}

#供應商使用 - 詢價單報價(給管理者)
#詢價編號、產品明細(陣列，包含回覆金額)、管理者備註、供應商總金額、供應商含稅狀態、供應商備註
function inquirySupplierReSend($inquiryNum, $arrayInquiryProduct, $adminRemarks, $reTotal, $reStatus, $tcReRemark) {
  $content = "
  <table style='width:100%;'>
    <tr>
      <td style='text-align:center;'>
        <img src='http://fs.kingtechcorp.com/images/logo.jpg' alt='logo' style='width:30%'> 
        <h2 style='font-size:14px;'>詢價單資料</h2>
      </td>
    </tr>
  </table>

  <table style='width:100%;border-top:3px #B73B35 dashed;border-bottom:3px #B73B35 solid;'>  
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        以下為供應商報價回覆資料。
      </td>
    </tr>
            
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>詢價單資訊</td>
          </tr>
          <tr>
            <td width='150' align='center' style='background-color:#F7941D;color:white;'>
              詢價單編號
            </td>
            <td>
              ".$inquiryNum."
            </td>
          </tr>
        </table>
      </td>
    </tr>    
    
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>
          <tr style='text-align:center;background-color:#B73B35;color:white;'>
            <td>商品名稱</td>
            <td>商品規格</td>
            <td>商品數量</td>
            <td>參考金額</td>
            <td>說明</td>
            <td>回覆金額</td>
          </tr>
          ";
    #產品列表      
    foreach($arrayInquiryProduct as $key=>$val) {      
    $content .="        
          <tr>
            <td>".$val['name']."</td>
            <td>".$val['nom']."</td>
            <td align='center' width='80'>".$val['amount']."</td>
            <td align='center' width='80'>".$val['price']."</td>
            <td>".$val['remark']."</td>
            <td align='center' width='80'>".$val['rePrice']."</td>
          </tr>
          ";
    } //foreach($arrayOrderProduct as $key=>$val) {   
    $content .="  
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>管理者留言</td>
          </tr>
          <tr>
            <td>".nl2br($adminRemarks)."</td>
          </tr>  
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>
        
        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>報價資訊</td>
          </tr>
          <tr>
            <td width='150' style='text-align:center;background-color:#F7941D;color:white;'>總金額</td>
            <td>".$reTotal."</td>
          </tr>
          <tr>
            <td width='150' style='text-align:center;background-color:#F7941D;color:white;'>是否含稅</td>
            <td>".$reStatus."</td>
          </tr> 
          <tr>
            <td width='150' style='text-align:center;background-color:#F7941D;color:white;'>供應商備註</td>
            <td>".nl2br($tcReRemark)."</td>
          </tr>   
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>備註</td>
          </tr>
          <tr>
            <td colspan='4'>
              <span style='color:#B73B35;'>注意事項</span>
              <br>
              ※請進入管理後台，依詢價編號查閱詳細資料。<br>
              ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
            </td>
          </tr>
        </table>

      </td>
    </tr>
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>
  </table>

  <table style='width:100%;'>  
    <tr>
      <td>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
        <br>
        <br>
        <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>
      </td>
    </tr>
  </table>
  ";
  return $content;
}

#詢價單流程，管理者寄給會員
#詢價編號、產品陣列、會員資料、回覆金額、回覆訊息、建立時間
function inquirySendMem($inquiryNum, $arrayInquiryProduct, $arrayMemberData, $reTotal, $reMessage, $time) {
  $content = "
  <table style='width:100%;'>
    <tr>
      <td style='text-align:center;'>
        <img src='http://fs.kingtechcorp.com/images/logo.jpg' alt='logo' style='width:30%'> 
        <h2 style='font-size:14px;'>詢價單資料</h2>
      </td>
    </tr>
  </table>

  <table style='width:100%;border-top:3px #B73B35 dashed;border-bottom:3px #B73B35 solid;'>  
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        親愛的會員您好，您在 ".$time." 所建立的詢價單已回覆，查閱資訊如下：
      </td>
    </tr>
            
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>詢價單資訊</td>
          </tr>
          <tr>
            <td width='150' align='center' style='background-color:#F7941D;color:white;'>
              詢價單編號
            </td>
            <td>
              ".$inquiryNum."
            </td>
          </tr>
        </table>
      </td>
    </tr>    
    
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' rules='all' cellpadding='5' style='width:80%;border:1px solid;border-color:#AAAAAA;'>
          <tr>
            <td align='center' colspan='2' style='background-color:#B73B35;color:white;'>個人資料</td>
          </tr>
          ";
    #個人資料陣列      
    foreach($arrayMemberData as $key=>$val) {
    $content .= "      
          <tr>
            <td width='150' style='text-align:center;background-color:#F7941D;color:white;'>".$val[0]."</td>
            <td>".$val[1]."</td>
          </tr>
          ";
    } //foreach($arrayMemberData as $key=>$val) {
    $content .= "
        </table>
      </td>
    </tr>

    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>
          <tr style='text-align:center;background-color:#B73B35;color:white;'>
            <td>商品名稱</td>
            <td>商品規格</td>
            <td>商品數量</td>
            <td>參考金額</td>
            <td>參考供應商</td>
            <td>商品備註</td>
          </tr>
          ";
    #產品列表      
    foreach($arrayInquiryProduct as $key=>$val) {      
    $content .="        
          <tr>
            <td>".$val['name']."</td>
            <td>".$val['nom']."</td>
            <td align='center' width='80'>".$val['amount']."</td>
            <td align='center' width='80'>".$val['referPrice']."</td>
            <td>".$val['referSAD']."</td>
            <td>".$val['remark']."</td>
          </tr>
          ";
    } //foreach($arrayOrderProduct as $key=>$val) {   
    $content .="  
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='2' style='text-align:center;background-color:#B73B35;color:white;'>回覆報價資訊</td>
          </tr>
          <tr>
            <td width='150' style='text-align:center;background-color:#F7941D;color:white;'>回覆金額</td>
            <td>".$reTotal."</td>
          </tr>
          <tr>
            <td width='150' style='text-align:center;background-color:#F7941D;color:white;'>回覆訊息</td>
            <td>".nl2br($reMessage)."</td>
          </tr>   
        </table>

        <table>
          <tr>
            <td style='height:10px;'>
            &nbsp;
            </td>
          </tr>
        </table>

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>備註</td>
          </tr>
          <tr>
            <td colspan='4'>
              <span style='color:#B73B35;'>注意事項</span>
              <br>
              ※內容為建置在會員所建立的詢價單資料上，並做回覆。<br>
              ※若有相關問題可直接再新建詢價單詢問，並請附上詢價單編號，感謝。<br>
              ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
            </td>
          </tr>
        </table>

      </td>
    </tr>
    <tr>
      <td style='height:10px;'>
        &nbsp;
      </td>
    </tr>
  </table>

  <table style='width:100%;'>  
    <tr>
      <td>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
        <br>
        <br>
        <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>
      </td>
    </tr>
  </table>
  ";
  return $content;
}

#電子報申請 - 申請成功
#email
function edmSuccess($email) {
  $content = "
              親愛的 gn01816565@gmail.com 
              <br><br>
              您已申請FIVESTARS的電子報功能，感謝您的訂閱。
              <br><br>
              --------------------------------------------------------------------------------
              <br><br>
              ※若想取消訂閱電子報，請再訂閱電子報的頁面中，輸入email後選擇『取消訂閱』。
              <br>
              ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 
              <br><br>
              --------------------------------------------------------------------------------
              <br><br>
              ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
              <br>
              ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
              <br>
              ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
              <br>
              <br>
              <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>
             ";
  return $content;
}

#電子報申請 - 取消申請
#email
function edmCancel($email) {
  $content = "
              親愛的 ".$email." 
              <br><br>
              您已取消FIVESTARS的電子報功能，感謝您的使用。
              <br><br>
              --------------------------------------------------------------------------------
              <br><br>
              ※若想訂閱電子報，請再輸入電子信箱申請訂閱。
              <br>
              ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 
              <br><br>
              --------------------------------------------------------------------------------
              <br><br>
              ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
              <br>
              ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
              <br>
              ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
              <br>
              <br>
              <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>
             ";
  return $content;
}

#客服中心 - 提出申請
#姓名、填寫資料
function serviceMail($name, $arrayMemberData) {
  $content = "
  <table style='width:100%;'>
    <tr>
      <td style='text-align:center;'>
        <img src='http://fs.kingtechcorp.com/images/logo.jpg' alt='logo' style='width:30%'> 
        <h2 style='font-size:14px;'>客服中心 - 詢問表單</h2>
      </td>
    </tr>
  </table>

  <table style='width:100%;border-top:3px #B73B35 dashed;border-bottom:3px #B73B35 solid;'>  
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

      <tr>
        <td align='center'>
          親愛的 ".$name." 您好，感謝您的來信，我們將會盡快處理，填報資料如下：
        </td>
      </tr>

    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>

        <table CELLSPACING='0' rules='all' cellpadding='5' style='width:80%;border:1px solid;border-color:#AAAAAA;'>
          <tr>
            <td align='center' colspan='2' style='background-color:#B73B35;color:white;'>個人資料</td>
          </tr>
            ";
    #個人資料陣列      
    foreach($arrayMemberData as $key=>$val) {
    $content .= "      
          <tr>
            <td width='150' style='text-align:center;background-color:#F7941D;color:white;'>".$val[0]."</td>
            <td>".$val[1]."</td>
          </tr>
          ";
    } //foreach($arrayMemberData as $key=>$val) {
    $content .= "
          <tr>
            <td colspan='2'>
              <span style='color:#B73B35;'>注意事項</span>
              <br>
              ※本郵件為通知信件，詳細資料請前往後台確認。 <br>
              ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
            </td>
          </tr>

        </table>
      </td>
    </tr>

    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

  </table>

  <table style='width:100%;'>  
    <tr>
      <td>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
        <br>
        <br>
        <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>
      </td>
    </tr>
  </table>           
             ";
  return $content;
}

#供應商申請
#供商商資料(陣列)
function registeredSAD($arraySAD) {
  $content = "
  <table style='width:100%;'>
    <tr>
      <td style='text-align:center;'>
        <img src='http://fs.kingtechcorp.com/images/logo.jpg' alt='logo' style='width:30%'> 
        <h2 style='font-size:14px;'>詢價單資料</h2>
      </td>
    </tr>
  </table>

  <table style='width:100%;border-top:3px #B73B35 dashed;border-bottom:3px #B73B35 solid;'>  
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        親愛的供應商您好，我們已收到您的申請資料，請耐心等候我們的人員與您聯絡，以下是申請資料內容：
      </td>
    </tr>
            
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>


    <tr>
      <td align='center'>
        <table CELLSPACING='0' rules='all' cellpadding='5' style='width:80%;border:1px solid;border-color:#AAAAAA;'>
          <tr>
            <td align='center' colspan='2' style='background-color:#B73B35;color:white;'>公司資料</td>
          </tr>
          ";
    #申請資料陣列
    foreach($arraySAD as $key=>$val) {
    $content .= "      
          <tr>
            <td width='150' style='text-align:center;background-color:#F7941D;color:white;'>".$val[0]."</td>
            <td>".$val[1]."</td>
          </tr>
          ";
    } //foreach($arrayMemberData as $key=>$val) {
    $content .= "
        </table>
      </td>
    </tr>

    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>備註</td>
          </tr>
          <tr>
            <td colspan='4'>
              <span style='color:#B73B35;'>注意事項</span>
              <br>
              ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
            </td>
          </tr>
        </table>

      </td>
    </tr>
    <tr>
      <td style='height:10px;'>
        &nbsp;
      </td>
    </tr>
  </table>

  <table style='width:100%;'>  
    <tr>
      <td>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
        <br>
        <br>
        <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>
      </td>
    </tr>
  </table>
             ";
  return $content;
}


#供應商 - 忘記密碼
#供應商mail、密碼路徑
function SADforgetPWmail($mail, $mailContent) {
  $content = "";
  $content = "
    <table>
      <tr>
        <td>
          親愛的 ".$mail." <br><br>
          您已申請重新設定供應商登入密碼
        </td>
      </tr>
      <tr>
        <td> 
          --------------------------------------------------------------------------------<br>
          【FIVESTARS】請從以下修改密碼路徑進入修改。<br>
          --------------------------------------------------------------------------------<br>
          ※修改密碼路徑：<br>
          <a href='".$mailContent."'>".$mailContent."</a>
          <br>
          <br>
          ---此連結將在數小時後失效。<br>
          ---若您未提出修改密碼的申請，請忽略此訊息。<br>
          <br>
          <br>
          ※若想修改帳號資料，請與管理員聯絡申請修改資料。<br>
          ※密碼更改過後，請使用新密碼登入。<br>
          ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
          <br>
          --------------------------------------------------------------------------------<br>
          ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
          <br>
          ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
          <br>
          ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
          <br>
          <br>
          <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>
        </td>
      </tr>
    </table> 
  ";
  return $content;
}

#管理者 - 忘記密碼
#管理者mail、密碼路徑
function AMforgetPWmail($mail, $mailContent) {
  $content = "";
  $content = "
    <table>
      <tr>
        <td>
          親愛的 ".$mail." <br><br>
          您已申請重新設定管理者登入密碼
        </td>
      </tr>
      <tr>
        <td> 
          --------------------------------------------------------------------------------<br>
          【FIVESTARS】請從以下修改密碼路徑進入修改。<br>
          --------------------------------------------------------------------------------<br>
          ※修改密碼路徑：<br>
          <a href='".$mailContent."'>".$mailContent."</a>
          <br>
          <br>
          ---此連結將在數小時後失效。<br>
          ---若您未提出修改密碼的申請，請忽略此訊息。<br>
          <br>
          <br>
          ※若想修改帳號資料，請與系統管理員聯絡申請修改資料。<br>
          ※密碼更改過後，請使用新密碼登入。<br>
          ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
          <br>
          --------------------------------------------------------------------------------<br>
          ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
          <br>
          ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
          <br>
          ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
          <br>
          <br>
          <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>
        </td>
      </tr>
    </table> 
  ";
  return $content;
}

#管理者用 - 供應商帳號開通
#供應商資料(陣列)、供應商帳號資料(陣列)[帳號]
function SADstatusOK($arraySAD, $arraySADdata) {
  $content = "
  <table style='width:100%;'>
    <tr>
      <td style='text-align:center;'>
        <img src='http://fs.kingtechcorp.com/images/logo.jpg' alt='logo' style='width:30%'> 
        <h2 style='font-size:14px;'>供應商資料</h2>
      </td>
    </tr>
  </table>

  <table style='width:100%;border-top:3px #B73B35 dashed;border-bottom:3px #B73B35 solid;'>  
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        親愛的供應商您好，您的帳號已開通，以下是申請資料內容：
      </td>
    </tr>
            
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>


    <tr>
      <td align='center'>
        <table CELLSPACING='0' rules='all' cellpadding='5' style='width:80%;border:1px solid;border-color:#AAAAAA;'>
          <tr>
            <td align='center' colspan='2' style='background-color:#B73B35;color:white;'>公司資料</td>
          </tr>
          ";
    #申請資料陣列
    foreach($arraySAD as $key=>$val) {
    $content .= "      
          <tr>
            <td width='150' style='text-align:center;background-color:#F7941D;color:white;'>".$val[0]."</td>
            <td>".$val[1]."</td>
          </tr>
          ";
    } //foreach($arrayMemberData as $key=>$val) {
    $content .= "
        </table>
      </td>
    </tr>

    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' rules='all' cellpadding='5' style='width:80%;border:1px solid;border-color:#AAAAAA;'>
          <tr>
            <td align='center' colspan='2' style='background-color:#B73B35;color:white;'>帳號資料</td>
          </tr>
          ";
    #帳號資訊
    foreach($arraySADdata as $key=>$val) {
    $content .= "      
          <tr>
            <td width='150' style='text-align:center;background-color:#F7941D;color:white;'>".$val[0]."</td>
            <td>".$val[1]."</td>
          </tr>
          ";
    } //foreach($arrayMemberData as $key=>$val) {
    $content .= "
        </table>
      </td>
    </tr>

    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>
    <tr>
      <td align='center'>

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>備註</td>
          </tr>
          <tr>
            <td colspan='4'>
              <span style='color:#B73B35;'>注意事項</span>
              <br>
              ※若有資料需更改，請聯絡管理員處理，感謝。 <br>
              ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
            </td>
          </tr>
        </table>

      </td>
    </tr>
    <tr>
      <td style='height:10px;'>
        &nbsp;
      </td>
    </tr>
  </table>

  <table style='width:100%;'>  
    <tr>
      <td>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
        <br>
        <br>
        <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>
      </td>
    </tr>
  </table>
             ";
  return $content;
}

#管理者用 - 供應商帳號關閉
#供應商資料(陣列)、供應商帳號資料(陣列)[帳號]
function SADstatusClose($arraySAD, $arraySADdata) {
  $content = "
  <table style='width:100%;'>
    <tr>
      <td style='text-align:center;'>
        <img src='http://fs.kingtechcorp.com/images/logo.jpg' alt='logo' style='width:30%'> 
        <h2 style='font-size:14px;'>供應商資料</h2>
      </td>
    </tr>
  </table>

  <table style='width:100%;border-top:3px #B73B35 dashed;border-bottom:3px #B73B35 solid;'>  
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        親愛的供應商您好，您的帳號已關閉，以下是關閉的資料內容：
      </td>
    </tr>
            
    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>


    <tr>
      <td align='center'>
        <table CELLSPACING='0' rules='all' cellpadding='5' style='width:80%;border:1px solid;border-color:#AAAAAA;'>
          <tr>
            <td align='center' colspan='2' style='background-color:#B73B35;color:white;'>公司資料</td>
          </tr>
          ";
    #申請資料陣列
    foreach($arraySAD as $key=>$val) {
    $content .= "      
          <tr>
            <td width='150' style='text-align:center;background-color:#F7941D;color:white;'>".$val[0]."</td>
            <td>".$val[1]."</td>
          </tr>
          ";
    } //foreach($arrayMemberData as $key=>$val) {
    $content .= "
        </table>
      </td>
    </tr>

    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>

    <tr>
      <td align='center'>
        <table CELLSPACING='0' rules='all' cellpadding='5' style='width:80%;border:1px solid;border-color:#AAAAAA;'>
          <tr>
            <td align='center' colspan='2' style='background-color:#B73B35;color:white;'>帳號資料</td>
          </tr>
          ";
    #帳號資訊
    foreach($arraySADdata as $key=>$val) {
    $content .= "      
          <tr>
            <td width='150' style='text-align:center;background-color:#F7941D;color:white;'>".$val[0]."</td>
            <td>".$val[1]."</td>
          </tr>
          ";
    } //foreach($arrayMemberData as $key=>$val) {
    $content .= "
        </table>
      </td>
    </tr>

    <tr>
      <td style='height:10px;'>
      &nbsp;
      </td>
    </tr>
    <tr>
      <td align='center'>

        <table CELLSPACING='0' cellpadding='5' rules='all' style='width:80%;border:1px solid #AAAAAA;'>  
          <tr>
            <td colspan='4' style='text-align:center;background-color:#B73B35;color:white;'>備註</td>
          </tr>
          <tr>
            <td colspan='4'>
              <span style='color:#B73B35;'>注意事項</span>
              <br>
              ※若有相關問題，請聯絡管理員，感謝。<br>
              ※請勿直接回覆此電子郵件。此電子信箱無法接收來信。 <br>
            </td>
          </tr>
        </table>

      </td>
    </tr>
    <tr>
      <td style='height:10px;'>
        &nbsp;
      </td>
    </tr>
  </table>

  <table style='width:100%;'>  
    <tr>
      <td>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=memberRights'>會員權益</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=qa'>常見問題</a>
        <br>
        ※<a href='http://fs.kingtechcorp.com/tc/index.php?pageData=privacy'>隱私權政策</a>
        <br>
        <br>
        <a href='http://fs.kingtechcorp.com/tc/index.php?pageData=about'>關於FIVESTARS</a>
      </td>
    </tr>
  </table>
             ";
  return $content;
}

?>