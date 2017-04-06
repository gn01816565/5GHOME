<?php
#頁碼function
//當前頁面代號、全部頁碼、當前頁碼、讀取頁數
function pageNumList($pageData, $allPageNum, $nowPage, $readPage) {
echo "<div id='pageNumBox'>";
  echo "<div class='pageNumWarp'>";
    if($nowPage!=1) {
      echo "<a href='?pageData=".$pageData."&page=1' title='第一頁' class='btnPrev'>第一頁</a>";
    }
    echo "<a href='?pageData=".$pageData."&page=".(($nowPage!=1)?$nowPage-1:$nowPage)."' title='上一頁' class='btnPrev'>上一頁</a>";
   
    echo "<span class='pageNum'>";    
      #中心點比例，左距5，右距4
      $plusNum = 0; //開始頁碼
      
      #顯示頁碼數
      if($nowPage+4>=$allPageNum) { //如果頁碼+4超過
        $read_page = $allPageNum;  //最後頁碼
        if($allPageNum-10>0) {
          $plusNum = $allPageNum-10; //開始頁碼
        }
      } else {
        $read_page=$readPage; //頁碼顯示為10頁，過10頁則跑...，並顯示最後一頁
        if($nowPage>6 && $allPageNum>10) { //讓頁碼取值在中間
          $plusNum = $nowPage-6; //開始頁碼
        }
      }

      for($i=(1+$plusNum);$i<=($plusNum+$read_page);$i++) {
        if($i > $allPageNum) { //最後一頁時跳出
          break;
        }
        echo "<a href='?pageData=".$pageData."&page=".$i."' ".($nowPage==($i)?"class='pageNumHold'":"")." title='P：".$i."' >";
        echo $i;
        echo "</a>";
      } //for($i=(1+$plusNum);$i<=($plusNum+$read_page);$i++) {
    echo "</span>";
    
    echo "<a href='?pageData=".$pageData."&page=".(($nowPage!=$allPageNum)?$nowPage+1:$nowPage)."' title='下一頁' class='btnNext'>下一頁</a>";

    if($nowPage != $allPageNum) {// 非最後一頁則跳出
      echo "<a href='?pageData=".$pageData."&page=".$allPageNum." title='最後頁' class='btnPrev'>最後頁</a>";
    }

  echo "</div>";
echo "</div>";
} //function pageNumList($pageData, $allPageNum, $nowPage, $readPage) {

function checkValidIp($ip) {
  if(!eregi("^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$", $ip)) $return = FALSE;
  else $return = TRUE;
 
  $tmp = explode(".", $ip);
  if($return == TRUE){
    foreach($tmp AS $sub){
     $sub = $sub * 1;
           if($sub<0 || $sub>256) $return = FALSE;
     }
  }
  return $return;
}
#取使用者IP
function getIp() {
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip=$_SERVER['HTTP_CLIENT_IP'];
  } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
    $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    $ip=$_SERVER['REMOTE_ADDR']; 
  }
  
  if(!checkValidIp($ip))
  {
    $ip="Null";
  }
  return $ip;
}

#管理者登入次數
#資料庫物件、管理者id
function loginCount($db,$am_id) {
  $sqlLoginCount = "SELECT count(*) FROM  Admin_ManagerLoginMessage where AMLM_AM_ID = '$am_id' ";
  $rsLoginCount = $db->query($sqlLoginCount);
  $rowLoginCount = $rsLoginCount->fetch();
  $LoginCount = $rowLoginCount[0];
  return $LoginCount;
}
#管理者最後登入資料
#資料庫物件、管理者id
function loginLastDate($db,$am_id) {
  $sqlLoginLast = "SELECT * FROM  Admin_ManagerLoginMessage where AMLM_AM_ID = '".$am_id."' ORDER BY  AMLM_ID DESC limit 1,1";
  $rsLoginLast = $db->query($sqlLoginLast);
  $rowLoginLast = $rsLoginLast->fetch(PDO::FETCH_ASSOC); 
  return $rowLoginLast;
}

#搜尋資料表的資料數量
#資料庫物件、資料表名稱、要加上的條件式(陣列)
function whereTableNum($db,$tableName,$condition) {
  $num = 0; //迴圈數量
  $sql_plus=""; //條件式字串
  
  foreach($condition as $key => $val) { //將條件式從陣列整理成字串
    $num++; //迴圈+1
    if($num==1) {
      $sql_plus .= $key." like ".$val; //第一個條件式不加AND
    } else {
      $sql_plus .= " AND ".$key." like ".$val; //第二個以上的條件式需加上AND
    }
  }
  
  $sql = "select count(*) from $tableName where $sql_plus";
  $rs = $db->query($sql);
  $row  = $rs->fetch();
  return $row[0]; //回傳數量
}

#搜尋資料表的資料數量
#資料庫物件、資料表名稱
function allTableNum($db,$tableName) {
  $sql = "select count(*) from $tableName ";
  $rs = $db->query($sql);
  $row  = $rs->fetch();
  return $row[0]; //回傳數量
}

#上傳檔案function，輸入檔名、上傳路徑（需加/確保目錄)、檔案類型(Banner、Footer，此處資料會加在檔名前面)
function uploadFile($filename,$szUpLoad,$titleFileName) {
//$szUpLoad = "upload/";
if( $_FILES[$filename]["error"] == UPLOAD_ERR_OK )
{           
  $file_date=date("YmdHis");
    //$file_date=date("YmdGis").floor(microtime()*1000);
  $file_name=trim($_FILES[$filename]['name'],' '); //取得檔案名稱
    //$file_name2=str_replace(" ","_",$file_name); //
  $second_name=explode(".",$file_name);//分割名稱，並取得副檔名
  $file_name=$titleFileName."_".$file_date.".".end($second_name);  //重新組合名稱
    //$file_name=$file_date.".".$M_ID.".".$PM_ID.".".end($second_name); //用pm_id跟M_id組成檔案名稱
    //if( move_uploaded_file($_FILES["Filedata"]["tmp_name"],$szUpLoad.$_FILES["Filedata"]["name"]))
  copy($_FILES[$filename]["tmp_name"],$szUpLoad.$file_name);
    //用copy的函數將暫存檔存入指定路徑中
 }  
 return $file_name;
}

#檢查並刪除檔案
function delFile($imgURL) {
  if(is_file($imgURL)) {
      unlink($imgURL);
  }
  return true;
}

#刪除資料夾，使用根目錄路徑
function deleteDirectory($dir) {  
  if (!file_exists($dir)) return true;  
  if (!is_dir($dir) || is_link($dir)) return unlink($dir);  

  foreach (scandir($dir) as $item) {  
    if ($item == '.' || $item == '..') continue;  
    if (!deleteDirectory($dir . "/" . $item)) {  
      chmod($dir . "/" . $item, 0777);  
      if (!deleteDirectory($dir . "/" . $item)) return false;  
    };  
  }  
  return rmdir($dir);  
}  

#從管理者id抓出管理者帳號
#放入管理者id
function amAccountSearch($db,$id) {
  $sql = "select AM_ID,AM_Account from Admin_Manager where AM_ID = '".$id."' ";
  $rs = $db->query($sql);
  $row  = $rs->fetch();
   
  return $row['AM_Account']; 
} //function amAccountSearch($id) {

#從供應商id抓出供應商名稱
#放入供應商id
function sadAccountSearch($db,$id) {
  #列出供應商地區
  $sqlSAD = "SELECT * FROM Supplier_AccountData WHERE SAD_ID = '".$id."' ";
  $rsSAD = $db->query($sqlSAD);
  $dataSAD = $rsSAD->fetch();

  #供應商所在資料表
  $sadTable = "Supplier_AccountData".$dataSAD['SAD_Country']; //資料表名稱
  if($dataSAD['SAD_Country']=='Tw') {
    $sadNum = "T"; 
  } else {
    $sadNum = "C"; 
  }
  #列出供應商資料
  $sqlSADda = "SELECT SAD".$sadNum."_ID,SAD".$sadNum."_Name FROM ".$sadTable." WHERE SAD".$sadNum."_SAD_ID = '".$id."'";
  $rsSADda = $db->query($sqlSADda);
  $dataSADda = $rsSADda->fetch();

  return $dataSADda["SAD".$sadNum."_Name"];
} //function sadAccountSearch($id) {
  
#從供應商id抓出供應商名稱
#資料庫物件、供應商id
function fiveSadAccountSearch($db,$id) {
  #列出供應商地區
  $sqlSAD = "SELECT * FROM Supplier_AccountData WHERE SAD_ID = '".$id."' ";
  $rsSAD = $db->query($sqlSAD);
  $dataSAD = $rsSAD->fetch();
  
  #供應商所在資料表
  $sadTable = "Supplier_AccountData".$dataSAD['SAD_Country']; //資料表名稱
  if($dataSAD['SAD_Country']=='Tw') {
    $sadNum = "T"; 
  } else {
    $sadNum = "C"; 
  }
  
  #列出供應商資料
  $sqlSADda = "SELECT SAD".$sadNum."_ID,SAD".$sadNum."_Name FROM ".$sadTable." WHERE SAD".$sadNum."_SAD_ID = '".$id."'";
  $rsSADda = $db->query($sqlSADda); 
  $dataSADda = $rsSADda->fetch();

  return array($dataSADda["SAD".$sadNum."_Name"],$dataSAD['SAD_Num']);
} //function sadAccountSearch($id) {

/*
 * 壓縮圖檔
 * $from_filename : 來源路徑, 檔名, ex: /tmp/xxx.jpg
 * $save_filename : 縮圖完要存的路徑, 檔名, ex: /tmp/ooo.jpg
 * $in_width : 縮圖預定寬度
 * $in_height: 縮圖預定高度
 * $quality  : 縮圖品質(1~100)
*/

function ImageResize($from_filename, $save_filename, $in_width, $in_height, $quality){
    $allow_format = array('jpeg', 'png', 'gif','jpg');
    $sub_name = $t = '';

    $img_info = getimagesize($from_filename);
    $width    = $img_info['0'];
    $height   = $img_info['1'];
    $imgtype  = $img_info['2'];
    $imgtag   = $img_info['3'];
    $bits     = $img_info['bits'];
    $channels = $img_info['channels'];
    $mime     = $img_info['mime'];

    list($t, $sub_name) = split('/', $mime);
    if ($sub_name == 'jpg') {
        $sub_name = 'jpeg';
    
    }else{
    }

    if (!in_array($sub_name, $allow_format)) {
        return false;
    }
    $quality=($sub_name=="png") ? 0 :$quality; //如果是PNG 設為0
   
    $percent = getResizePercent($width, $height, $in_width, $in_height);
    $new_width  = $width * $percent;
    $new_height = $height * $percent;
    
    $image_new = imagecreatetruecolor($new_width, $new_height);
    // $function_name: set function name
    //   => imagecreatefromjpeg, imagecreatefrompng, imagecreatefromgif
    
    // $sub_name = jpeg, png, gif
    $function_name = 'imagecreatefrom'.$sub_name;
    $image = $function_name($from_filename); //$image = imagecreatefromjpeg($filename);
    
    $return_funciton_name='image'.$sub_name;//==>組合函式名稱
  
    // $image = imagecreatefromjpeg($from_filename);
  
    //$image=imagecreatefromjpeg($from_filename);
    $white = imagecolorallocate($image, 0, 0,0); 
    imagecolortransparent($image, $white);//背景色填滿白

    imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
  
    //return imagejpeg($image_new, $save_filename, $quality);
    return $return_funciton_name($image_new, $save_filename ,$quality);
}  
function getResizePercent($source_w, $source_h, $inside_w, $inside_h){
    if ($source_w < $inside_w && $source_h < $inside_h) {
        return 1; // Percent = 1, 如果都比預計縮圖的小就不用縮
    }

    $w_percent = $inside_w / $source_w;
    $h_percent = $inside_h / $source_h;

    return ($w_percent > $h_percent) ? $h_percent : $w_percent;
}
#增加欄位
#資料庫物件、資料表名稱、資料欄位、供應商id
function addTable($db, $TableName, $Column, $reID) {
  //先檢查是否有相關欄位
  $sqlSel = "select * from ".$TableName." where ".$Column." = '".$reID."'";
  $rsSel  = $db -> query($sqlSel);
  $dataSel  = $rsSel -> fetch();
  if(!$dataSel) { //無值再執行新增
    $sqlSupplier = "insert into ".$TableName." (".$Column.") values ('".$reID."')";
    $dataSupplier = $db->prepare($sqlSupplier);
    $dataSupplier->execute();
  }
}

#找出供應商的群組名稱
function searchSupplierGroup($db, $groupID) {
  $sql = "select * from Admin_SupplierGroup where ASG_ID = '".$groupID."' ";
  $rs  = $db->query($sql);
  $row = $rs->fetch();
  return $row['ASG_Name']; //回傳名稱
}

#供應商資料用，列出地區的英文代號
function searchSADcountry($SADcountry) {
  if($SADcountry == 'Cn') {
    return "大陸";
  } else { //Tw
    return "台灣";
  }
}

#供應商資料用，列出帳號狀態
function searchSADstatus($SADstatus) {
  if($SADstatus == 'Y') {
    return "開啟";
  } else { //Tw
    return "關閉";
  }
}

#從會員id抓出會員姓名
#資料庫物件、會員id
function memberNameSearch($db, $mid) {
  $sqlMemAc = "select * from Member_AccountsData where MAD_ID = '".$mid."' ";
  $rsMemAc = $db->query($sqlMemAc);
  $dataMemAc = $rsMemAc->fetch();

  #判斷會員類型，general：一般會員、company：公司會員
  if($dataMemAc=='company') { //公司會員
    $sqlMemData = "SELECT * FROM  Member_AccountsDataCompany where MADC_MAD_Num = '".$dataMemAc['MAD_Num']."' ";
    $rsMemData = $db->query($sqlMemData);
    $dataMemData = $rsMemData->fetch();
    return $dataMemData['MADC_Name'];
  } else { //一般會員
    $sqlMemData = "SELECT * FROM  Member_AccountsDataGeneral where MADG_MAD_Num = '".$dataMemAc['MAD_Num']."' ";
    $rsMemData = $db->query($sqlMemData);
    $dataMemData = $rsMemData->fetch();
    return $dataMemData['MADG_LastName'].$dataMemData['MADG_Name'];
  }
}

#訂單狀態英翻中
#放入英文狀態
function orderStatus($status) {
  $reStr = ""; //回傳訊息

  switch($status) {
    case 'noShipping':
      $reStr = "未出貨";
      break;
    case 'shipped':
      $reStr = "已出貨";
      break;
    case 'refund':
      $reStr = "退貨/退款";
      break;
    case 'replacement':
      $reStr = "換貨";
      break;
    case 'complaints':
      $reStr = "客訴";
      break;
    case 'invaild':
      $reStr = "作廢";
      break;             
    default:
      $reStr = "無紀錄";
      break;  
  }
  return $reStr;
}

#寄信function
#系統信件
//資料庫物件、mail內文
function admin_systemMail($db, $mailTitle, $mailContent) {
  #寄信給管理者的系統信件
  $SQLsystemMail = "SELECT * FROM Admin_SystemMail where ASM_ID = '1'";
  $RSsystemMail = $db->query($SQLsystemMail);
  $DATAsystemMail = $RSsystemMail -> fetch();
  $arraySystemEmail = explode(",",$DATAsystemMail['ASM_Email']); //分割字串，將系統信件分割
  if(count($arraySystemEmail)>1) { //有兩個以上
    foreach($arraySystemEmail as $key=>$val) {
      admin_webMailSent($val, $mailTitle, $mailContent);  //寄給管理者
    }
  } else {
    admin_webMailSent($DATAsystemMail['ASM_Email'], $mailTitle, $mailContent);  //寄給管理者
  }
}

#寄信
#本機端mail參數
#收件人email、信件標題、信件內容
function admin_webMailSent($to,$title,$content) {

  $title="=?UTF-8?B?".base64_encode($title)."?=";//信件標題，解決亂碼問題
  mb_internal_encoding('UTF-8');

  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html; charset=utf-8\r\n";

  #國內
  $from_name=mb_encode_mimeheader('FIVESTARS客服', 'UTF-8');
  $headers .= "From: ".$from_name."<service@fs.kingtechcorp.com>" . "\r\n";

  $message = $content;
  mail($to,$title,$message,$headers);
} //function mail_sent($to,$title,$content) {

function admin_supplierMail($db, $sadid, $mailTitle, $mailContent) {
  #判斷供應商地區，找出email
  $SQLsuppier = "SELECT * FROM Supplier_AccountData where SAD_ID = '".$sadid."'";
  $RSsuppier = $db->query($SQLsuppier);
  $DATAsuppier = $RSsuppier ->fetchAll();

  $tableName = ""; //資料表名稱
  $labelName = ""; //資料欄位結尾名稱
  if($DATAsuppier[0]['SAD_Country']=='Cn') {
    $tableName = "Supplier_AccountDataCn"; //大陸供應商
    $labelName = "C";
  } else {
    $tableName = "Supplier_AccountDataTw"; //台灣供應商
    $labelName = "T";
  }

  #找出email
  $SQLsuppierMail = "SELECT * FROM $tableName where SAD".$labelName."_SAD_ID = '".$sadid."' ";
  $RSsuppierMail = $db->query($SQLsuppierMail);
  $DATAsuppierMail = $RSsuppierMail -> fetchAll();
  admin_webMailSent($DATAsuppierMail[0]['SAD'.$labelName.'_Email'], $mailTitle, $mailContent);  //寄給管理者
} 

//問題種類
function serviceType($typeContent) {
  $str = ""; //回傳內容
  switch($typeContent) {
    case 'shop':
      $str = "購物問題";
      break;
    case 'inquiry':
      $str = "詢價問題";
      break;
    case 'order':
      $str = "訂單問題";
      break;
    case 'complaints':
      $str = "客訴問題";
      break;
    case 'product':
      $str = "產品問題";
      break;
    case 'account':
      $str = "帳號問題";
      break;            
    default:
      $str = "其它問題";
      break;    
  }
  return $str;
} 

#密碼亂數產生
#位元數
function pwRandCreate() {
  $mirrorArray = array("a","b","c","d","e","f","g","h","i","j",
             "k","l","m","n","o","p","q","r","s","t",
             "u","v","w","x","y","z",
             "0","1","2","3",
             "4","5","6","7","8","9","0" );
  mt_srand((double)microtime()*1000000);  //以時間當亂數種子
  $Rand = Array(); //定義為陣列
  $count = 10 ; //共產生幾筆
  for ( $i = 1; $i <= $count; $i++ ) {
    $randval = mt_rand( 0, 52 ); //取得範圍為1~500亂數
    if ( in_array( $randval, $Rand ) ) { //如果已產生過迴圈重跑
      $i--;
    }else{
      $Rand[] = $randval; //若無重復則 將亂數塞入陣列
    }
  }
  $str="";
  for( $i = 0; $i < 10; $i++ ) {
    $str = $str.$mirrorArray[$Rand[$i]];
  }
  return $str;
}

#亂碼產生編號，有大寫英文、小寫英文、數字
function RandCreateNum() {
  $mirrorArray = array("a","b","c","d","e","f","g","h","i","j",
             "k","l","m","n","o","p","q","r","s","t",
             "u","v","w","x","y","z",
             "A","B","C","D","E","F","G","H","I","J",
             "K","L","M","N","O","P","Q","R","S","T",
             "U","V","W","X","Y","Z",
             "0","1","2","3",
             "4","5","6","7","8","9","0" );
  mt_srand((double)microtime()*1000000);  //以時間當亂數種子
  $Rand = Array(); //定義為陣列
  $count = 10 ; //共產生幾筆
  for ( $i = 1; $i <= $count; $i++ ) {
    $randval = mt_rand( 0, 62 ); //取得範圍為1~500亂數
    if ( in_array( $randval, $Rand ) ) { //如果已產生過迴圈重跑
      $i--;
    }else{
      $Rand[] = $randval; //若無重復則 將亂數塞入陣列
    }
  }
  $str="";
  for( $i = 0; $i < 10; $i++ ) {
    $str = $str.$mirrorArray[$Rand[$i]];
  }
  return $str;
}

#產生GUID
function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = // "{"
            substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
        return $uuid;
    }
}
?>