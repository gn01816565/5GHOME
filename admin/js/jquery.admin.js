jQuery(document).ready(function(e) {



  //Page Up
  jQuery(window).scroll(function() {
    if (jQuery(this).scrollTop() > 50) {
      jQuery('#pageTopBtn').addClass('move');
    } else {
      jQuery('#pageTopBtn').removeClass('move');
    }
  });
  jQuery('#pageTopBtn a').click(function() {
    jQuery('html, body').animate({
      scrollTop: 0
    }, 500, "easeInOutQuint");
    return false;
  });



  //開合選單
  //jQuery('.listMenu').hide();
  jQuery('.listMenuBtn').click(function(e) {
    jQuery(this).closest('li').siblings().find('ul').slideUp(300);
    jQuery(this).siblings('ul').animate({
      height: "toggle",
      opacity: "toggle"
    }, 300);
  
  });


  //圖片裁切
  jQuery(".imgCarp").imgLiquid();



  //textarea 輸入欄位高度自動增加
  jQuery('textarea').autosize();

  //有檔案上傳的頁面要用到此方法，產品管理、banner管理、footer管理、ad管理
/*
  $('#formFileAdd').ajaxForm(function() { 
    var dataURL = $('#pageURL').val(); //回傳的list頁面資訊 
      swal({
        title:"新增成功",
        text: "",
        type: "success"
        },
        function() {
          window.location.href='page_index.php?pageData='+dataURL;
        }
      );
  });
*/ 


var options = {
  beforeSerialize: checkSerialize,
  beforeSubmit:  checkPost, //該執行的功能頁面設定，執行前會先跑這段
  success:    showResponse //執行完畢
}; //var options = {

//上傳完成的function
function showResponse(responseText, statusText, xhr, $form){
  var dataURL = $('#pageURL').val(); //回傳的list頁面資訊 
    swal({
      title:"成功上傳",
      text: responseText,
      type: "success"
      },
      function() {
        window.location.href='page_index.php?pageData='+dataURL;
      }
    );//swal({
}

$('#formFileAdd').ajaxForm(options); //載入ajax檔案上傳 

//上傳完成的function
/*
function showResponse(responseText, statusText, xhr, $form){
  var $showResponse = jQuery.noConflict(); 
  var dataURL = $showResponse('#pageURL').val(); //回傳的list頁面資訊
    swal({
      title:"完成!",
      text: responseText,
      type: "success"
      },
      function() {
        window.location.href='page_index.php?pageData='+dataURL;
      }
    );//swal({
}
var $fileUpload = jQuery.noConflict();
$fileUpload('#formFileAdd').ajaxForm(options); //載入ajax檔案上傳   
*/
  $('#twzipcode').twzipcode({
    'css': ['county', 'district', 'zipcode'],
    'detect': true // 預設值為 false
  });

});