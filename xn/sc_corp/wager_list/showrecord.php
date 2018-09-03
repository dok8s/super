<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require ("../../member/include/config.inc.php");

$sql = "select wager from web_system";
$result4 = mysql_query($sql);
$row4 = mysql_fetch_array($result4);

$wager=$row4['wager'];

$uid = $_REQUEST['uid'];

$sql = "select agname,setdata from web_super where oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['agname'];
$setdata = @unserialize($row['setdata']);

if($setdata['d0_voucher_f5']==1) $wager=0; 

echo $wager;

?>