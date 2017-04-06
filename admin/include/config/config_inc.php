<?php
include 'database_inc.php'; //資料庫資訊檔
//include ('../../test/index.php');

#資料庫連線
try {
    /*
    $dbTW = new PDO($Language_dbtype . ':host=' . $Language_host . ';dbname=' . $Language_dbname, $Language_username, $Language_password,$Language_options); //TW資料庫連線
    $dbConfig = new PDO($Config_dbtype . ':host=' . $Config_host . ';dbname=' . $Config_dbname, $Config_username, $Config_password,$Config_options); //Config資料庫連線
    
    #防止 sql進入
    $dbTW -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //禁用模擬預處理語句，並使用 real parepared statements
    $dbConfig -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //禁用模擬預處理語句，並使用 real parepared statements
    

    $Language_db = new PDO($Language_dbtype . ':host=' . $Language_host . ';dbname=' . $Language_dbname, $Language_username, $Language_password,$Language_options); //TW資料庫連線
    $Config_db = new PDO($Config_dbtype . ':host=' . $Config_host . ';dbname=' . $Config_dbname, $Config_username, $Config_password,$Config_options); //Config資料庫連線
    
    #防止 sql進入
    $Language_db -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //禁用模擬預處理語句，並使用 real parepared statements
    $Config_db -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //禁用模擬預處理語句，並使用 real parepared statements
    */
    $_db = new PDO($dbtype . ':host=' . $host . ';dbname=' . $dbname, $username, $password,$options); //資料庫連線
    $_db -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //禁用模擬預處理語句，並使用 real parepared statements
    // 資料庫使用 UTF8 編碼
    //$dbh->query('SET NAMES UTF8'); //設定編碼
} catch (PDOException $e) {
    echo 'Error!: ' . $e->getMessage() . '<br />';
}
?>