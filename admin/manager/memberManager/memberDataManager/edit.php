<?php
#查會員編號，判斷會員是一般會員、企業會員 
$sql = "SELECT * 
                  FROM Member_AccountsData 
                  WHERE MAD_Num = '".$_GET['id']."'";
$rs = $Config_db->query($sql);
$data = $rs->fetch();

if($data['MAD_Type']=='general') { //一般會員
  include("editG.php");
} else { //企業會員
  include("editC.php");
}
?>