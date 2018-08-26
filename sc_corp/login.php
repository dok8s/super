<?
Session_start();
require_once('../member/include/config.inc.php');
//require_once('../member/include/define_function_list.inc.php');
$username=$_REQUEST["username"];
$password=substr(md5(md5($_REQUEST["passwd"]."abc123")),0,16);
$langx=$_REQUEST["langx"];
$active=$_REQUEST["active"];

//$rt = mysql_fetch_array( mysql_query( "select setdata from web_system limit 0,1" ) );
//$setdata = @unserialize($rt['setdata']);

$line='';
$str = time();
$uid=substr(md5($str),0,15);
//$uid=substr(md5(time().$username),0,15);

$sql = "select * from `web_super` where Agname ='$username' and Passwd='$password' and Status<>0";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);

//if(intval($setdata['d0oneonline'])!=0 && strlen($uid)==strlen($row['oid'])){
//	$uid=$row['oid'];
//}

$count=mysql_num_rows($result);
if ($count==0){
	echo "<script>alert('LOGIN ERROR!!\\nPlease check username/passwd and try again!!');window.open('../index.php','_top')</script>";
	exit;
}else{
	$tu=rand(1345515,8345915);
     $_SESSION["tktk"]=$tu;
	$loginfo='用户登入成功';
	$ip_addr = $_SERVER['REMOTE_ADDR'];
	$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$username',now(),'$loginfo','$ip_addr','0')";
	mysql_query($mysql);

	$sql="update web_super set oid='$uid',logintime=now(),domain='$_SERVER[HTTP_HOST]',language='zh-cn',logip='$ip_addr' where Agname='".$username."'";
	mysql_query($sql) or die ("操作失败!");
	//show_message('d0:'.$username);
?>
<html>
<head>
<title>web</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<frameset rows="75,*" frameborder="NO" border="0" framespacing="0">
<frame name="topFrame" scrolling="NO" noresize src="header.php?langx=<?=$langx?>&uid=<?=$uid?>">
<frame name="main" src="body_home.php?langx=<?=$langx?>&uid=<?=$uid?>">
</frameset>
<noframes>
<body bgcolor="#FFFFFF" text="#000000">
</body>
</noframes>
</html>
<?
}

?>