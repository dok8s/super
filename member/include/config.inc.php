<?php
error_reporting(0);
require_once('global.php');
isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['REMOTE_ADDR']=$_SERVER['HTTP_X_FORWARDED_FOR'];
$ip_addr = $_SERVER['REMOTE_ADDR'];

$dbhost = "";
$dbuser = "bjfxzf";
$dbpass = "123456";
$dbname = "bjfxzf";
$lnk = mysql_connect($dbhost,$dbuser,$dbpass) or exit("ERROR MySQL Connect");
mysql_select_db($dbname, $lnk);

$str="!and|update|from|where|order|by|*|delete|\'|insert|into|values|create|table|database|script|iframe|<>|onload|\"|eval|base64_decode";  //非法字符 

$arr=explode("|",$str);//数组非法字符，变单个 
foreach ($_REQUEST as $key=>$value){
	for($i=0;$i<sizeof($arr);$i++){
		if (substr_count(strtolower($_REQUEST[$key]),$arr[$i])>0){       //检验传递数据是否包含非法字符 
		    echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'><SCRIPT language='javascript'>\nalert('含有非法字符".$arr[$i]."');window.open('index.php','_top');</script>";
            exit;
		}
		if(strlen($_REQUEST[$key])>100){			
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'><SCRIPT language='javascript'>\nalert('字符串太长');window.open('index.php','_top');</script>";
            exit;
		}
	} 
} 

$sql = "select allowip,logip from web_system";
$result = mysql_db_query( $dbname, $sql );
$row = mysql_fetch_array( $result );
$allowip = $row['allowip'];
$logip = $row['logip'];
if ( $allowip == 1 && $ip_addr != $logip )
{
				echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"></head>IP不合法.<br>您所在的<font style=\"background-color: #3399FF\"><B>IP</B></font>位置:<font style=\"background-color: #3399FF\"><B>".$ip_addr."</B></font>.<br>不允许进入，请连络相关人员.<br></html>";
				exit( );
}
$wager_vars = array( "正常注单", "非正常注单", "", "", "赛事腰斩", "赛事延期", "赔率错误", "赛事无pk/加时", "球员弃权", "队名错误", "", "", "取消" );
$wager_vars_p = array( "正常注单", "非正常注单", "", "", "", "", "", "", "", "", "", "", "取消" );
$wager_vars_re = array( "正常注单", "非正常注单", "进球取消", "红卡取消", "赛事腰斩", "赛事延期", "赔率错误", "赛事无pk/加时", "球员弃权", "队名错误", "确认注单", "未确认注单", "取消" );
$match_status = array( "", "赛事取消", "赛事延期", "赛事腰斩", "赛事无pk/加时", "球员弃权", "队名错误" );
$ODDS=Array(
	'H'=>'香港盘<br>',
	'M'=>'马来盘<br>',
	'I'=>'印尼盘<br>',
	'E'=>'欧洲盘<br>'
);
?>
