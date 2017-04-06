<?php
$id = $_GET['id']; //編輯id

#叫出電子報資料
$sqlRead = "SELECT * FROM  Admin_EdmContent where AEC_ID = '".$id."'";
$rsRead = $Language_db->query($sqlRead);
$dataRead = $rsRead->fetch();
?>

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

          <div id="newsWarp" class="boxWarp">
            <h2 class="red">資料查閱</h2>
            <div class="tableWarp">
              <div id="formTable">
                <form id="formFileAdd" name="formFileAdd" action="manager/<?=$mainDirectory;?>/<?=$subDirectory;?>/process.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="act" value="edit">
                  <input type="hidden" id="pageURL" value="<?=$_GET['pageData'];?>">
                  <input type="hidden" id="eid" name="eid" value="<?=$dataRead['AEC_ID'];?>">
                  <table>
                    <tr>
                      <td class="num titleTxt" style='width:100px;'>電子報編號</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$dataRead['AEC_Num'];?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">信件標題</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$dataRead['AEC_Title'];?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">內容</td>
                      <td class="txtLeft" style="text-align:left;" id="ckeditor">
                        <?=$dataRead['AEC_Content'];?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">上傳檔案</td>
                      <td class="txtLeft" style="text-align:left;">
                        <!--
                        <input type="file" name="addFile" id="addFile"> 
                        <span id="addFile_Alert"></span>
                      -->
                      <?php
                      if($dataRead['AEC_File']) {
                      /*
                      echo "<button class='yellow' id='checkFile".$i."' name='checkFile".$i."' type='button' onclick=imgOpen('../images/supplier/".$_SESSION['SAD_Account']."/product/contentImage/".$dataImg[0]['SPI_Image']."') target='_blank'>".$dataImg[0]['SPI_Image']."</button>
                      <input type='file' name='file".$i."' id='file".$i."'><span id='file".$i."Alert'></span><br><br>";
                      */
                      ?>
                      <span id="addFileDiv">
                        <button class="yellow" type="button" onclick="location.href='../download.php?f=<?=$dataRead['AEC_File'];?>&url=images/edm/'"><?=$dataRead['AEC_File'];?><button>
                      </span>
                        <?php
                      } else {
                        echo "無附加檔案";
                      }
                      ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">建立日期</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$dataRead['AEC_Date'];?>
                      </td>
                    </tr>
                    <tr>
                      <td class="num titleTxt">新增人員</td>
                      <td class="txtLeft" style="text-align:left;">
                        <?=$_SESSION['AM_Account'];?>
                      </td>
                    </tr>
                  </table>
                
              </div><!--<div id="formTable">-->  
            </div>
          </div>
        <div class="pageBtnWarp">
          <ul>
            <li><button type="button" id="returePage" class="green" onclick="location.href='page_index.php?pageData=<?=$_GET['pageData']?>'">返回列表</button></li>
        </div>  
      </form>
      </section>
      <div class="clearBoth"></div>
    </div>
  </div>
</div>

