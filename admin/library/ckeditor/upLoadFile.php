<?php
include_once('../../include/function/function.php');

#單獨寫的檔案上傳用

$file_name = uploadFile('upload','../../../images/ckeditor/','ck'); //回傳更改過後的上傳檔名
$fileURL = "http://".$_SERVER['HTTP_HOST']."/images/ckeditor/".$file_name; //檔案路徑


// CKEditor 的編號
$CKEditorFuncNum = isset($_GET['CKEditorFuncNum']) ? $_GET['CKEditorFuncNum'] : 2;
// $fileUrl是圖片網址 就自己先處理好吧
echo "<script>";
echo "window.parent.CKEDITOR.tools.callFunction('".$CKEditorFuncNum."','" . $fileURL . "','ok');";
echo "</script>";


?>