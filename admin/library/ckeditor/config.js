/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
  config.allowedContent=true; // 關閉語法過濾器
  // 移掉自己會出現的<p>
  config.enterMode = CKEDITOR.ENTER_BR;
  config.shiftEnterMode = CKEDITOR.ENTER_P;
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

/*
  工具列參數列表：
  'Source'：原始碼
  'Save'：儲存
  'NewPage'：開新檔案
  'Preview'：預覽
  'Templates'：樣版

  'Cut'：剪下
  'Copy'：複製
  'Paste'：貼上
  'PasteText'：貼為文字格式
  'PasteFromWord'：從word 貼上
  'Print'：列印
  'SpellChecker'：拼字檢查
  'Scayt'：即時拼寫檢查

  'Undo'：上一步
  'Redo'：重作
  'Find'：尋找
  'Replace'：取代
  'SelectAll'：全選
  'RemoveFormat'：清除格式

  'Form'：表單
  'Checkbox'：核取方塊
  'Radio'：單選按鈕
  'TextField'：文字方塊
  'Textarea'：文字區域
  'Select'：選單
  'Button'：按鈕
  'ImageButton'：影像按鈕
  'HiddenField'：隱藏欄位

  'Bold'：粗體
  'Italic'：斜體
  'Underline'：底線
  'Strike'：刪除線
  'Subscript'：下標
  'Superscript'：上標
  'NumberedList'：編號清單
  'BulletedList'：項目清單
  'Outdent'：減少縮排
  'Indent'：增加縮排
  'Blockquote'：引用文字

  'JustifyLeft'：靠左對齊
  'JustifyCenter'：置中
  'JustifyRight'：靠右對齊
  'JustifyBlock'：左右對齊

  'Link'：超連結
  'Unlink'：移除超連結
  'Anchor'：錨點

  'Image'：圖片影像
  'Flash'：Flash
  'Table'：表格
  'HorizontalRule'：水平線
  'Smiley'：表情符號
  'SpecialChar'：特殊符號
  'PageBreak'：分頁符號

  'Styles'：樣式
  'Format'：格式
  'Font'：字體
  'FontSize'：大小

  'TextColor'：文字顏色
  'BGColor'：背景顏色

  'Maximize'：最大化
  'ShowBlocks'：顯示區塊
  'About'：關於CKEditor
*/  

  //開啟圖片上傳功能
  /*
  config.filebrowserBrowseUrl = 'library/ckfinder/ckfinder.html'; //出現瀏覽伺服端
  config.filebrowserImageBrowseUrl = 'library/ckfinder/ckfinder.html?Type=Image';
  config.filebrowserFlashBrowseUrl = 'library/ckfinder/ckfinder.html?Type=Flash';
  config.filebrowserUploadUrl = 'library/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
  config.filebrowserImageUploadUrl = 'library/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Image'; //你用來處理上傳檔案的程式位置
  config.filebrowserFlashUploadUrl = 'library/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
  */
  
  config.filebrowserImageUploadUrl = 'library/ckeditor/upLoadFile.php?type=img'; //用來處理上傳檔案的程式位置

};
