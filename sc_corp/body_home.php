<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require_once('../member/include/config.inc.php');
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$langx='zh-cn';
require ("../member/include/traditional.$langx.inc.php");

$sql = "select agname from web_super where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['agname'];

$sql = "select agname from web_super where subuser=1 and subname='$agname'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
	$ag=" M_czz='".$row['agname']."' or ";
}


$sql = "select * from web_system";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$messages=$row['msg_member'];

?>
<html>
<head> 
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.m_title_re {  background-color: #577176; text-align: right; color: #FFFFFF}
.m_bc { background-color: #C9DBDF; padding-left: 7px }
-->
</style>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/calendar.css">
<link rel="stylesheet" href="/style/control/control_main1.css" type="text/css">

<style type="text/css">
<!--
.m_title_ce {background-color: #669999; text-align: center; color: #FFFFFF}
-->
</style>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >
<table width="750" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed" >
  <tr> 
    <td width="150" align="right">系统公告</td>
    <td width="520"><marquee scrollDelay=200><?=$messages?></marquee></td>
    <td align="center"> <A HREF="javascript://" onClick="javascript: window.showModalDialog('scroll_history.php?uid=<?=$uid?>&langx=zh-cn','','help:no')"> 
      历史讯息</a> </td>
  </tr>
  <tr align="center" > 
    <td colspan="3" bgcolor="6EC13E">&nbsp; </td>
  </tr>
</table>
<div id="user_msg" class="user_msg">
	<span>帐号新增及密码更改提示</span>
	<div id="table_master">
		<table cellpadding="0" cellspacing="0" id="table_header">
		  <tbody>
			<tr class="msg_td">
				<td>时间</td>
				<td>操作者</td>
				<td>项目</td>
				<td>帐号</td>
				<td>阶层</td>
			</tr>
			<?
if($ag==""){
	$sql="select  * from agents_log  where Status=2 and M_czz='$agname' order by M_DateTime desc";
}else{
	$sql="select  * from agents_log  where Status=2 and (".$ag." M_czz='$agname') order by M_DateTime desc";
}
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)){
?>
			<tr>
				<td><?=$row["M_DateTime"]?></td>
				<td><?=$row["M_czz"]?></td>
				<td><?=$row["M_xm"]?></td>
				<td><?=$row["M_user"]?></td>
				<td><?=$row["M_jc"]?></td>
			</tr>
<?
}
?>
			</tbody>
		</table>
  </div>
	
</div>

</body>
</html>
<?
mysql_close();
?>
