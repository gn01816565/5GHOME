<?php
session_start();
unset($_SESSION['AM_login']); //指定清除登入狀態, 1:登入中, 0:無登入
unset($_SESSION['AM_ID']); //指定清除管理者帳號
UNSET($_SESSION['AM_Account']); //指定清除管理者帳號
//session_unregister('login');
//session_unregister('AM_ID');
//session_destroy(); //清除全部session
header("Location:index.php");
?>