<?php
#給定資料庫變數
#使用PDO測試連線
/*
#language資料庫設定
$Language_dbtype = 'mysql';
$Language_host = 'localhost';
$Language_dbname = 'nextdkco_fskt_TW';

$Language_username = 'nextdkco_root';
$Language_password = 'cLDI8ooNi7Zs';

//$Language_username = 'root';
//$Language_password = '';
$Language_options=array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'); //編碼處理

#Config資料庫設定
$Config_dbtype = 'mysql';
$Config_host = 'localhost';
$Config_dbname = 'nextdkco_fskt_Config';

$Config_username = 'nextdkco_root';
$Config_password = 'cLDI8ooNi7Zs';

//$Config_username = 'root';
//$Config_password = '';
$Config_options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'); //編碼處理
*/
#資料庫連線設定
$dbtype = 'mysql';
$host = 'localhost';
$dbname = '5ghome';

$username = 'root';
$password = '';
$options=array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'); //編碼處理
//將選擇的資料庫連線資訊，代入共用函式
/*
define('_DB_',$DB_Config['Config']['DB_Name']);
define('_USER_',$DB_Config['Config']['DB_User']);
define('_PWD_',$DB_Config['Config']['DB_Pwd']);
define('_SERVER_',$DB_Config['Config']['DB_Server']);
define('_PORT_',3306);
*/
?>