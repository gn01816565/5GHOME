<?php
$newPassword = $_POST['newPassword']; //新密碼
$newAgainPassword = $_POST['newAgainPassword']; //再次輸入新密碼

#使用sha1編碼

$sqlUpPw = "UPDATE Admin_Manager SET AM_Password='".sha1($newPassword)."' WHERE AM_ID = '$_SESSION[AM_ID]' ";
$result = $Language_db->prepare($sqlUpPw);
$result->execute();

?>