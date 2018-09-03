<?php
error_reporting(0);
require_once('global.php');
isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['REMOTE_ADDR']=$_SERVER['HTTP_X_FORWARDED_FOR'];
$ip_addr = $_SERVER['REMOTE_ADDR'];

$dbhost = "114.215.154.112";
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
		    echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'><SCRIPT language='javascript'>\nalert('Chứa các ký tự không hợp lệ".$arr[$i]."');window.open('index.php','_top');</script>";
            exit;
		}
		if(strlen($_REQUEST[$key])>100){			
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'><SCRIPT language='javascript'>\nalert('Chuỗi quá dài');window.open('index.php','_top');</script>";
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
$wager_vars = array("Cược", "Cược không", "", "", "Sự kiện", "Tiện ích", "Lỗi tỷ", "Sự kiện/cộng", "Người", " Lỗi tên "," "," "," Hủy " );
$wager_vars_p = array( "Đặt cược", "đặt cược", "", "", "", "", "", "", "", "", "", "", "Hủy");
$wager_vars_re = array( "Cược", "Cược không", "Hủy", "Hủy thẻ", "Vòng chung", "Tiện ích", "Lỗi tỷ", "Sự kiện/cộng", "Player abstain", "Team name", "Confirm", "Ghi chú", "Hủy" );
$match_status = array( "", "Hủy sự", "Tiện ích", "Vòng", "Sự kiện/cộng", "Người", "Lỗi tên" );
$ODDS=Array(
    'H' => 'Đĩa Hồng Kông <br>',
    'M' => 'Đĩa của Malaysia <br>',
    'I' => 'Tấm Indonesia <br>',
    'E' => 'Đĩa châu Âu <br>'
);
?>
