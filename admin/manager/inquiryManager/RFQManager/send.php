<?php
$id = $_GET['id']; //詢價單編號

$editSql = "select * from Admin_OrderInquiryList where AOIL_InquiryNum = '".$id."'";
$editRs = $Language_db->query($editSql);
$editData = $editRs->fetch();

#產品列出
$sqlInquiryPro = "select * from Admin_OrderInquiryProduct where AOIP_AOIL_InquiryNum = '".$id."'";
$rsInquiryPro = $Language_db->query($sqlInquiryPro);
$dataInquiryPro = $rsInquiryPro->fetchAll(PDO::FETCH_ASSOC); //移除數字索引

#有推送的供應商通知
$sqlSupplier = "select * from Admin_OrderInquirySupplier where AOIS_AOIL_InquiryNum = '".$id."'";
$rsSupplier= $Language_db->query($sqlSupplier);
$dataSupplier = $rsSupplier->fetchAll(PDO::FETCH_ASSOC); //移除數字索引


#所有群組資料
$sqlASG = "SELECT * FROM Admin_SupplierGroup";
$rsASG = $Language_db->query($sqlASG);
$dataASG = $rsASG->fetchAll();

#列出全部供應商資料
$sqlSAD = "SELECT * FROM Supplier_AccountData";
$rsSAD = $Config_db -> query($sqlSAD);
$dataSAD = $rsSAD -> fetchAll();

foreach($dataSAD as $key=>$val) {
  #找出有分類的供應商、未分類的供應商
  $sqlClass = "SELECT * FROM Supplier_AccountGroup where SAG_SAD_ID = '".$val['SAD_ID']."' AND SAG_ASG_ID != 0";
  $rsClass = $Language_db -> query($sqlClass);
  $dataClass = $rsClass -> fetchAll();

  if(count($dataClass) > 0) {
    //有分類的供應商
    $haveClassSAD[] = $dataClass[0]['SAG_SAD_ID']; //紀錄SAD_ID
  } else {
    //未分類的供應
    $noClassSAD[] = $val['SAD_ID']; //紀錄SAD_ID
  }
  
}

?>
<script>
function upSubmit(){
  var checkstatus = 1; //先預設有值

  if(checkstatus==1) {
    ajaxPro(); //執行ajax
  }
} //function upSubmit(){

function ajaxPro() {
  //var URLs  = "manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/index.php?secondURL=process";
  var URLs  = "manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/process.php";
  $.ajax({
    url: URLs,
    data: $('#formSend').serialize(),
    type:"POST",
    async:false, //有回傳值才會執行以下的js
    dataType:'json',
      
    success: function(msg){ //成功執行完畢
      swal({
        title:msg.remsg,
        text: "",
        type: "success"
        },
        function() {
          window.location.href='page_index.php?pageData=<?=$subDirectory;?>';
        }
      );
    },
    /*
    beforeSend:function(){ //執行中
    },
    complete:function(){ //執行完畢,不論成功或失敗
    },
    */
    error:function(xhr, ajaxOptions, thrownError){ //丟出錯誤
      alert(xhr.responseText);
      //alert('更新失敗!');
    }
  });
}
function checkAll(id) {
  var chk = "sadID["+id+"][]";
  //檢查是否有全選

  if($('#'+id).attr('checked')){ //被勾選
    $("input[name='"+chk+"']").prop("checked", true); 
  } else { //沒被勾選
    $("input[name='"+chk+"']").prop("checked", false); 
  }
  
  /*
  if($("input[name='"+chk+"']").attr('checked')){ //被勾選
    $("input[name='"+chk+"']").prop("checked", false); 
  } else { //沒被勾選
    $("input[name='"+chk+"']").prop("checked", true); 
  }
  */
  
}
function addInput() {
  var count = $('#inquiryTable tr').length;
  $('#inquiryTable').append(
      '<tr id="row'+count+'" >'+
        '<td class="txtLeft">'+
          '<input id="pName'+count+'" name="pName[]" type="text" placeholder="請輸入商品名稱">'+
        '</td>'+
        '<td class="colorBg">'+
          '<input id="pNom'+count+'" name="pNom[]" type="text" class="colorBorder" placeholder="請輸入產品規格">'+
        '</td>'+
        '<td>'+
          '<input id="pAmount'+count+'" name="pAmount[]" type="text" class="colorBorder" placeholder="請輸入數量">'+
        '</td>'+
        '<td>'+
          '<input id="pPrice'+count+'" name="pPrice[]" type="text" class="colorBorder" placeholder="請輸入金額">'+
        '</td>'+
        '<td class="colorBg">'+
          '<input type="text" id="pRemark" name="pRemark[]" rows="2" placeholder="請輸入商品單一備註">'+
        '</td>'+
        '<td>'+
          '<button type="button" onclick=addInput() class="blue" style="margin:0 4px 0 0">增加</button>'+
          '<button type="button" onclick=delInput("row'+count+'") class="red" style="margin:0 4px 0 0">刪除</button>'+
        '</td>'+
      '</tr>'
  );
}

function delInput(id) {
  if(id === 'all'){
    var count = $('#inquiryTable tr').length;
    for (var i = 2; i <= count; i++) {
      $('#row'+i).remove();
    };
  }else{
    $('#'+id).remove();
  }
}
</script>

<div id="pageMainWarp">
  <div id="pageWarp">
    <div id="pageWarpTR">
      <?php
      include('aside.php');
      ?>
      <section id="rightWarp">
        <div id="placeWarp" class="boxWarp">
          <div class="title red_T">目前位置：</div>
          <span><?=$pageMainTitle;?></span>
          <span>></span>
          <a href="page_index.php?pageData=<?=$subDirectory?>" title="<?=$pageTitle;?>"><?=$pageTitle;?></a>
        </div>
        <div class="clearBoth"></div>
        <div id="pageIndexWarp" class="boxWarp">
          <form id="formSend" name="formSend">

            <div id="newsWarp" class="boxWarp">
              <h2 class="red">詢價內容</h2>
              <div id="formTable">
                <div class="tableWarp">
                  <input type="hidden" name="act" value="send">
                  <input type="hidden" name="id" id="id" value="<?=$id;?>">
                  <table>
                    <tr>
                      <td class="num titleTxt" style="width:150px;">詢價單單號</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$editData['AOIL_InquiryNum'];?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">詢價建立時間</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$editData['AOIL_CreateDate'];?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">給供應商的備註</td>
                      <td class="txtLeft" style="text-align:left;">
                        <textarea name="message" placeholder="請輸入您要給供應商的說明" style='height:150px;'></textarea>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>

            <div id="newsWarp" class="boxWarp">
              <h2 class="red">管理者自建詢價單</h2>
              <div id="formTable">
                <div class="tableWarp">  
                  <table id="inquiryTable">
                    <tr>
                      <td colspan="6" style="background-color: #BDE5F8;color: #00529B;">
                        <i class="fa fa-info-circle"></i>
                        供應商所看到的內容為以下自建內容
                      </td>
                    </tr>
                    <tr>
                      <td class="txt titleTxt">產品名稱</td>
                      <td class="txt titleTxt">規格</td>
                      <td class="txt titleTxt">數量</td>
                      <td class="txt titleTxt">參考金額</td>
                      <td class="txt titleTxt">商品備註</td>
                      <td class="txt titleTxt">動作</td>
                    </tr>
                    <tr id="row1">
                      <td><input type="text" name="pName[]" placeholder="請輸入產品名稱"></td>
                      <td><input type="text" name="pNom[]" placeholder="請輸入產品規格"></td>
                      <td><input type="text" name="pAmount[]" placeholder="請輸入數量"></td>
                      <td><input type="text" name="pPrice[]" placeholder="請輸入金額"></td>
                      <td><input type="text" name="pRemark[]" placeholder="請輸入產品單一備註"></td>
                      <td><button class="blue" type="button" onclick="addInput();">增加</button></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>

            <div id="newsWarp" class="boxWarp">
              <h2 class="red">會員詢價產品資訊</h2>
              <div id="formTable">
                <div class="tableWarp">  
                  <table>
                    <tr>
                      <td colspan="6" style="background-color: #BDE5F8;color: #00529B;">
                        <i class="fa fa-info-circle"></i>
                        參考消費者詢價的明細內容
                      </td>
                    </tr>
                    <tr>
                      <td class="txt titleTxt">產品名稱</td>
                      <td class="txt titleTxt">規格</td>
                      <td class="txt titleTxt">數量</td>
                      <td class="txt titleTxt">參考金額</td>
                      <td class="txt titleTxt">參考供應商</td>
                      <td class="txt titleTxt">商品備註</td>
                    </tr>
                    <?php
                    #列出產品資訊
                    for($i=0;$i<count($dataInquiryPro);$i++) {
                    ?>
                    <tr>
                      <td>
                        
                        <?=$dataInquiryPro[$i]['AOIP_Name'];?>
                        <!--
                        <input type="checkbox" name="checkInquiryPro[]" value="<?=$dataInquiryPro[$i]['AOIP_ID'];?>" checked>
                        <label><?=$dataInquiryPro[$i]['AOIP_Name'];?></label>
                        -->
                      </td>
                      <td><?=$dataInquiryPro[$i]['AOIP_Nom'];?></td>
                      <td><?=$dataInquiryPro[$i]['AOIP_Amount'];?></td>
                      <td><?=$dataInquiryPro[$i]['AOIP_ReferPrice'];?></td>
                      <td><?=$dataInquiryPro[$i]['AOIP_ReferPrice'];?></td>
                      <td><?=$dataInquiryPro[$i]['AOIP_Remark'];?></td>
                    </tr>
                    <?php
                    } //while($dataOrderPro = $rsOrderPro->fetch()) {
                    ?>
                  </table>
                </div>
              </div>
            </div>

            <div id="newsWarp" class="boxWarp">
              <h2 class="red">供應商選擇</h2>
              <div id="formTable">
                <div class="tableWarp">
                  <table> 
                    <?php
                    for($i=0;$i<count($dataASG);$i++) {
                    ?>
                    <tr>
                      <td class="txtLeft" style="text-align:left;" colspan="4">
                        <input type="checkbox" name="group[]" id="<?= $i; ?>" value="<?= $i; ?>" onclick="checkAll(this.id);">
                        <label style="font-weight:bold;"><?=$dataASG[$i]['ASG_Name'];?></label>
                        <br>
                        <?php
                        /*
                        #叫出對應的供應商資料
                        $sqlSAG = "SELECT * FROM Supplier_AccountGroup WHERE SAG_ASG_ID = '".$dataASG[$i]['ASG_ID']."'";
                        $rsSAG = $Language_db->query($sqlSAG);
                        $dataSAG = $rsSAG->fetchAll();

                        if(count($dataSAG) > 0) {  //判斷是否有找到資料，若有則進入輸入程序
                          //for($j=0;$dataSAG = $rsSAG->fetch();$j++) {
                          for($j=0;$j<count($dataSAG);$j++) {
                        ?>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="checkbox" name="sadID[<?= $i; ?>][]" id="<?=$dataASG[$i]['ASG_ID'];?>sadID[]" value="<?=$dataSAG['SAG_SAD_ID'];?>">
                          <label><?=sadAccountSearch($Config_db, $dataSAG[$j]['SAG_SAD_ID'])?></label>
                          <br>
                        <?php
                          } //for($j=0;$dataSAG = $rsSAG->fetch();$j++) {
                        } //if(count($dataSAG) > 0) { 
                        */
                        ?>

                        <?php
                        #叫出對應的供應商資料
                        $sqlSAG = "SELECT * FROM Supplier_AccountGroup WHERE SAG_ASG_ID = '".$dataASG[$i]['ASG_ID']."'";
                        $rsSAG = $Language_db->query($sqlSAG);
                        $dataSAG = $rsSAG->fetchAll();

                        if(count($dataSAG) > 0) {  //判斷是否有找到資料，若有則進入輸入程序
                          //for($j=0;$dataSAG = $rsSAG->fetch();$j++) {
                          for($j=0;$j<count($dataSAG);$j++) {
                        ?>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="checkbox" name="sadID[<?= $i; ?>][]" id="<?=$dataASG[$i]['ASG_ID'];?>sadID[]" value="<?=$dataSAG['SAG_SAD_ID'];?>">
                          <label><?=sadAccountSearch($Config_db, $dataSAG[$j]['SAG_SAD_ID'])?></label>
                          <br>
                        <?php
                          } //for($j=0;$dataSAG = $rsSAG->fetch();$j++) {
                        } //if(count($dataSAG) > 0) { 
                        ?>
                      </td>
                    </tr>
                    <?php
                    } //for($i=0;$i<count($dataASG);$i++) {
                    ?>

                    <tr>
                      <td class="txtLeft" style="text-align:left;" colspan="4">
                        <input type="checkbox" name="group[]" id="<?= $i+1; ?>" value="<?= $i+1; ?>" onclick="checkAll(this.id);">
                        <label style="font-weight:bold;">未分類</label>
                        <br>
                        <?php
                        #列出未分類供應商資料
                        foreach($noClassSAD as $key=>$val) {
                        ?>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="checkbox" name="sadID[<?= $i+1; ?>][]" id="noClassSadID[]" value="<?=$val;?>">
                          <label><?=sadAccountSearch($Config_db, $val)?></label>
                          <br>
                        <?php
                        } //foreach($noClassSAD as $key=>$val) {
                        ?>
                      </td>
                    </tr>

                  </table>
                </div><!--<div id="formTable">-->  
              </div>
            </div>
          </form>

        <div class="pageBtnWarp">
          <ul>
            <li>
              <button class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>'">返回列表</button>
            </li>
            <li>
              <button class="yellow" onclick="upSubmit()">送出資料</button>
            </li>
          </ul>
        </div>  

      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

