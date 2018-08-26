<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
echo "<script>if(self == top) location='/'</script>\r\n";
require( "../../member/include/config.inc.php" );
$date_start = $_REQUEST['date_start'];
$agents_id = $_REQUEST['agents_id'];
$uid = $_REQUEST['uid'];
$user = $_REQUEST['user'];
$active = $_REQUEST['active'];
$so_log_name=trim($_REQUEST['so_log_name']);
$sql = "select id,subuser,agname,subname,status,setdata,edit from web_super where Oid='$uid'";
$result = mysql_query($sql);
$cou = mysql_num_rows( $result );
if ( $cou == 0 )
{
				echo "<script>window.open('".$site."/index.php','_top')</script>";
				exit( );
}

$row = mysql_fetch_array($result);
$agname=$row['agname'];
$super=$row['agname'];
$setdata = @unserialize($row['setdata']);
$edit=intval($row['edit']);

$update_sec = intval($setdata['memlog_update_sec']);
if($update_sec<3) $update_sec=120;

if(isset($_GET['update_sec'])){
	$memlog_update_sec = intval($_GET['update_sec']);
	if($memlog_update_sec>=3){
		$setdata['memlog_update_sec']=$memlog_update_sec;
		$mysql = "update web_super set setdata='".serialize($setdata)."' where agname='$agname'";
		mysql_query( $mysql );
	}
	echo "<script language='javascript'>self.location='memlog.php?uid=".$uid."';</script>";
}

if ( $date_start == "" )
{
				$date_start = date( "m-d" );
}
if ( $active == 1 )
{
				$sql = "update web_member set oid='' where super='$agname' and memname='".$user."'";
				mysql_db_query( $dbname, $sql );
				echo "<script language='javascript'>self.location='memlog.php?uid=".$uid."';</script>";
}
?>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<script>
<!--
var limit="<?=$update_sec?>";
var parselimit=limit;

function $(name){
	return document.getElementById(name);
}

function beginrefresh(){
	if (!document.images) return
	if (parselimit<=1){
		window.location.reload();
	}else{
		parselimit-=1
		curmin=Math.floor(parselimit)
		if (curmin!=0){
			curtime="("+curmin+")更新";
		}else{
			curtime="("+cursec+")更新";
		}
		$('F5').value=curtime;
		setTimeout("beginrefresh()",1000)
	}
}

function reload(){
	window.location.reload();
}

function report_bg(){
	$('mem_num').innerText=cou;
}

function so_log()
{
	var so_log_name = $('so_log_name').value;
	if(so_log_name!=''){
		self.location.href='memlog.php?uid=<?=$uid?>&so_log_name='+so_log_name;
	}
}

function update_sec_save(){
	self.location.href='memlog.php?uid=<?=$uid?>&update_sec='+$('update_sec').value;
}

window.onload=beginrefresh

</script> 
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type='text/css'>
form { margin:0; padding:0;}
input,select {vertical-align:middle;}
.m_cen2 {  background-color: #FFEBB5; text-align: center}
</style>
</head>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">

 <table width="1000" border="0" cellspacing="0" cellpadding="0" style="margin-left:20px;margin-bottom: 10px;margin-top: 10px;">
    <tr>
      <td class="">&nbsp;会员在线－<font color="#CC0000">日志</font>&nbsp;
	  <input name="buttonF5" id="F5" value="更新" type="button" onClick="reload()">&nbsp;&nbsp;
	  设置为<input type="text" id='update_sec' name="update_sec" value='<?=$update_sec?>' size='3'>秒自动更新&nbsp;
	  <input name="buttonF5" value="保存" type="button" onClick="update_sec_save()">&nbsp;&nbsp;
        <span id="timeinfo"></span>-- 20分内在线人数<font color=red><b>(<span id="mem_num"></span>)</b></font>&nbsp;&nbsp;&nbsp;-- 会员帐号或其部分:<INPUT TYPE='text' size=10 NAME='so_log_name' id='so_log_name' value=''> <input name=button type=button onclick='so_log()' value='搜索'> -- <a href="javascript:history.go( -1 );">回上一页</a></td>
    </tr>
  </table>
 <table width="774" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="774" height="4"></td>
   </tr>
 </table>


<table id="glist_table" border="0" cellspacing="1" cellpadding="0"  bgcolor="006255" class="m_tab" width="900" style="margin-left:20px;margin-bottom: 10px;">
  <tr class="m_title_ft">
<?
if($setdata['d0_mem_online_aglog']==1){
	echo "<td width=\"100\">代理</td>";
}
echo '<td width="100">会员帐号 </td><td width="100">登陆帐号 </td><td width="150">最后活动时间</td>';

if($setdata['d0show_memip']==1){
	echo "<td width=\"150\">登陆IP</td>";
}
if($setdata['d0_mem_online_domain']==1){
	echo "<td width=\"150\">网址</td>";
}
echo '<td width="150">操作</td></tr>';



$date = date('Y-m-d H:i:s',time()-60*20);
$sql_where="m.super='$agname'  AND m.oid!='out' AND m.active>'$date' AND m.oid!=''";// AND m.active>'$date' AND m.oid!=''(在线会员)
if($so_log_name){
	$sql_where="m.super='$agname' AND (m.memname like '%$so_log_name%' OR m.loginname like '%$so_log_name%') ";
}
$sql = "SELECT m.id, m.memname, m.loginname,m.oid, m.active, m.logip, m.domain, m.agents, a.logip AS logip_a, w.logip AS logip_w, c.logip AS logip_c, s.logip AS logip_s FROM web_member AS m, web_agents AS a, web_world AS w, web_corprator AS c, web_super AS s
WHERE $sql_where AND a.agname=m.agents AND w.agname=m.world AND c.agname=m.corprator AND s.agname=m.super ORDER BY agents, memname";

$i=0;
$upagent='';
$bj='m_cen2';
$result = mysql_query( $sql ) or exit('error super 77382');
while ( $row = mysql_fetch_array( $result ) )
{
	if($upagent!=$row['agents']){
		$upagent=$row['agents'];
		$bj = $bj=="m_cen2" ? "m_cen" : "m_cen2";
	}
	$iptong = "不同";
	if($row['logip']==$row['logip_a'] || $row['logip']==$row['logip_w']  || $row['logip']==$row['logip_c']  || $row['logip']==$row['logip_s'] ){
		$iptong = "<font color='#CC0000'>相同</font>";
	}
	echo "  <tr class='$bj'>";
	if($setdata['d0_mem_online_aglog']==1){
		echo "<td><a href='./showlog.php?uid=$uid&agents_id={$row[agents]}&level=3' target='_blank'>$row[agents]</a></td>";
	}
	echo "
		<td><font color='#CC0000'>$row[memname]</font></td>
		<td><font color='#CC0000'>$row[loginname]</font></td>
		<td>$row[active] </td>";
	if($setdata['d0show_memip']==1){
		echo "
		<td align=center width='160'><a href='http://ip138.com/ips138.asp?action=2&ip=$row[logip]' target=_blank>$row[logip]</a>";
		echo "/ <a href='./showlog.php?uid=$uid&level=4&agents_id=$row[id]' target=_blank>$iptong</a>";
		echo "</td>";
	}
	if($setdata['d0_mem_online_domain']==1){
		echo "<td>$row[domain] </td>";
	}
	if($row['active']>$date and $row['oid']<>""){
	
	echo "
		<td align='center'><a href='./memlog.php?uid=$uid&active=1&user=$row[memname]'>踢线</a>";
		$i++;
		}else{
		echo "
		<td align='center'>离开";
		}
	if($setdata['sendmsg']==1 ){
		echo " / <a href='./memsg.php?uid=$uid&user=$row[memname]'>短消息</a>";
	}
	if($edit==1){
		echo " / <a href='../wager_list/hide_list.php?uid=$uid&username=$row[memname]'>投注</a>";
	}
	echo "</td></tr>";
	
}
echo "</table>\r\n</form></body>\r\n</html>\r\n<script>\r\nvar cou='";
echo $i;
echo "';\r\nreport_bg();\r\n</script>\r\n";


	$loginfo='查看会员在线';
	$ip_addr = $_SERVER['REMOTE_ADDR'];
	$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$super',now(),'$loginfo','$ip_addr','0')";
	mysql_query($mysql);
?>
