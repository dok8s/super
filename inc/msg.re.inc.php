<?
$exArr=array();
$exArr['zh-cn']='';
$exArr['zh-tw']='_tw';
$exArr['en-us']='_en';
$ex = isset($exArr[$langx]) ? $exArr[$langx] : $exArr['zh-tw'];

$sql = "select memname from web_member where oid='$uid'";
$result = mysql_query($sql) or exit('error inc001');
$row = mysql_fetch_array($result);
$memname = $row['memname'];

$sql = "select message,message_tw from message where member='$memname'";
$result = mysql_query($sql);// or exit("error 998".mysql_error());
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
$talert = $cou>0 ? $row['message'.$ex] : '';
if(strlen($talert)>2){
	$type = strlen($ShowType)>1 ? $ShowType : $showtype;
	echo "window.parent.body_browse.setTimeout(\"alert(' $talert ')\",1000);";
	
}
?>
