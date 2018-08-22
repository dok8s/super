<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require( "../../member/include/config.inc.php" );
$date_start = $_REQUEST['date_start'];
$agents_id = $_REQUEST['agents_id'];
$uid = $_REQUEST['uid'];
$level = $_REQUEST['level'];
$user = $_REQUEST['agents_id'];
$active = $_REQUEST['active'];
$logip = $_REQUEST['ip'];
$sql = "select id,subuser,agname,subname,status, setdata, edit from web_super where Oid='$uid'";
$result = mysql_query($sql);
$cou = mysql_num_rows( $result );
if ( $cou == 0 )
{
				echo "<script>window.open('".$site."/index.php','_top')</script>";
				exit( );
}

$row = mysql_fetch_array($result);
$super=$row['agname'];
$agname=$row['agname'];
$edit=intval($row['edit']);
if($edit!=1){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>无权访问";
}

$setdata = @unserialize($row['setdata']);
$update_sec = intval($setdata['showlog_update_sec']);
if($update_sec<3) $update_sec=60;
$sound_sec = intval($setdata['showlog_sound_sec']);
$sound_time = time()-$sound_sec;
$is_sound = 0;

if(isset($_GET['update_sec'])){
	$showlog_update_sec = intval($_GET['update_sec']);
	if($showlog_update_sec>=3){
		$setdata['showlog_update_sec']=$showlog_update_sec;
		$mysql = "update web_super set setdata='".serialize($setdata)."' where agname='$agname'";
		mysql_query( $mysql );
	}
	echo "<script language='javascript'>self.location='?uid=".$uid."&level={$level}&agents_id=$agents_id';</script>";
	exit;
}
if(isset($_GET['sound_sec'])){
	$showlog_sound_sec = intval($_GET['sound_sec']);
	if($showlog_sound_sec>=3){
		$setdata['showlog_sound_sec']=$showlog_sound_sec;
		$mysql = "update web_super set setdata='".serialize($setdata)."' where agname='$agname'";
		mysql_query( $mysql );
	}
	echo "<script language='javascript'>self.location='?uid=".$uid."&level={$level}&agents_id=$agents_id';</script>";
	exit;
}

if ( $date_start == "" )
{
				$date_start = date( "m-d" );
}
switch ( $level )
{
case 0 :
				$level0 = 1;
				$level1 = 0;
				$level3 = 0;
				$level2 = 0;
				$sp = $user;
				break;
case 1 :
				$level0 = 1;
				$level1 = 1;
				$level3 = 0;
				$level2 = 0;
				$co = $user;
				$sql = "select super from web_corprator where super='$super' and agname='".$user."'";
				$result = mysql_query( $sql );
				$row = mysql_fetch_array( $result );
				$sp = $row['super'];
				break;
case 2 :
				$level0 = 1;
				$level1 = 1;
				$level2 = 1;
				$level3 = 0;
				$wd = $user;
				$sql = "select super,corprator from web_world where super='$super' and agname='".$user."'";
				$result = mysql_query( $sql );
				$row = mysql_fetch_array( $result );
				$co = $row['corprator'];
				$sp = $row['super'];
				break;
case 3 :
				$level0 = 1;
				$level1 = 1;
				$level2 = 1;
				$level3 = 1;
				$sql = "select super,world,corprator from web_agents where super='$super' and agname='".$user."'";
				$result = mysql_query( $sql );
				$row = mysql_fetch_array( $result );
				$wd = $row['world'];
				$co = $row['corprator'];
				$sp = $row['super'];
				if($logip!='')$sqladd .= " and logip='$logip' ";
				break;
case 4 :
				$level0 = 1;
				$level1 = 1;
				$level2 = 1;
				$level3 = 1;
				$level4 = 1;
				$sql = "select super,corprator,world,agents,memname,logdate,logip from web_member where super='$super' and id='".$user."'";
				$result = mysql_query( $sql );
				$row = mysql_fetch_array( $result );
				$memname = $row['memname'];
				$logdate = $row['logdate'];
				$logip = $row['logip'];
				$user = $row['agents'];
				$wd = $row['world'];
				$co = $row['corprator'];
				$sp = $row['super'];
				$sqladd .= " and logip='$logip' ";
				break;
}

$level0 = 0;
if(!$sp || ($level==0 && $sp!=$super)){
	echo "<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<title></title>";
	echo "数据不存在 ";exit;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<script>
function $(name){
	return document.getElementById(name);
}
var limit='<?=$update_sec?>'
if (document.images){
	var parselimit=limit
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

function update_sec_save(){
	self.location.href='?uid=<?=$uid?>&level=<?=$level?>&agents_id=<?=$agents_id?>&update_sec='+$('update_sec').value;
}
function sound_sec_save(){
	self.location.href='?uid=<?=$uid?>&level=<?=$level?>&agents_id=<?=$agents_id?>&sound_sec='+$('sound_sec').value;
}

function reload()
{
	self.location.href="showlog.php?uid=<?=$uid?>&level=<?=$level?>&agents_id=<?=$agents_id?>";
}
window.onload=beginrefresh

</script>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
</head>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
 <table width="773" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="m_tline" width="746">&nbsp;线上数据－<font color="#CC0000">日志</font><font color="#CC0000">&nbsp;</font>&nbsp;&nbsp;&nbsp;
		
	  <input name="buttonF5" id="F5" value="更新" type="button" onclick="reload()" class='za_button'>&nbsp;&nbsp;
	  设置为<input type="text" id='update_sec' name="update_sec" value='<?=$update_sec?>' size='3'>秒自动更新&nbsp;
	  <input name="buttonF5" value="保存" type="button" onclick="update_sec_save()"  class='za_button'>&nbsp;&nbsp;

        <span id="timeinfo"></span>-- 上线提醒时间：<input type="text" id='sound_sec' name="sound_sec" value='<?=$sound_sec?>' size='3'>秒&nbsp;
	  <input name="buttonF6" value="保存" type="button" onclick="sound_sec_save()"  class='za_button'> -- <a href="javascript:history.go( -1 );">回上一页</a></td>

      <td width="34"><img src="/images/control/top_04.gif" width="30" height="24"></td>
    </tr>
  </table>
  <table width="774" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="774" height="4"></td>
    </tr>
    <tr>
      <td ></td>
    </tr>
  </table>
<?
if ( $level4 == 1 )
{					$class='';
					if(strtotime($logdate)>$sound_time){
						$class='class=m_cen_red';
						$is_sound=1;
					}
				echo "<table id=\"glist_table\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"006255\" class=\"m_tab\" width=\"778\">
		<tr class='m_title_ft'><td align='middle' width='84'>会员</td><td width='126'>最后活动时间</td><td width='390'>操作</td><td width='173'>登陆IP</td></tr>\r\n  ";
				echo "  <tr class=\"m_cen\">\r\n    <td width=\"84\" $class>";
				echo $memname;
				echo "</td>\r\n    <td width=\"126\"><font color=\"#CC0000\">";
				echo $logdate;
				echo "</font></td>\r\n    <td align=right width=\"390\">";
				echo "用户登入成功";
				echo "</td>\r\n\t<td align=right width=\"173\">";
				echo "<a href='http://ip138.com/ips.asp?action=2&ip=$logip' target=_blank>$logip</a>";
				echo "</td>\r\n  </tr>\r\n  ";
				echo "</table>\r\n<br>\r\n";
}

if ( $level3 == 1 )
{
				echo "<table id=\"glist_table\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"006255\" class=\"m_tab\" width=\"778\">
		<tr class='m_title_ft'><td align='middle' width='84'>代理商</td><td width='126'>最后活动时间</td><td width='390'>操作</td><td width='173'>登陆IP</td></tr>\r\n  ";

				$sql = "select username,logtime,context,logip from web_mem_log where username='".$user."' $sqladd and level=3 order by logtime desc limit 0,8";
				$result = mysql_query( $sql );
				$count = mysql_num_rows( $result );
				while ( $row = mysql_fetch_array( $result ) )
				{
					$class='';
					if(strtotime($row['logtime'])>$sound_time){
						$class='class=m_cen_red';
						$is_sound=1;
					}
								echo "  <tr class=\"m_cen\">\r\n    <td width=\"84\" $class>";
								echo $row['username'];
								echo "</td>\r\n    <td width=\"126\"><font color=\"#CC0000\">";
								echo $row['logtime'];
								echo "</font></td>\r\n    <td align=right width=\"390\">";
								echo $row['context'];
								echo "</td>\r\n\t<td align=right width=\"173\">";
								echo "<a href='http://ip138.com/ips.asp?action=2&ip=$row[logip]' target=_blank>$row[logip]</a>";
								echo "</td>\r\n  </tr>\r\n  ";
				}
				if($count>=8) echo "<tr class='m_cen'> <td colSpan=4 align=right><a href='showlog_more.php?uid=$uid&level=3&agents_id=$user'>更多...</a></td></tr>";
				echo "</table>\r\n<br>\r\n";
}
if ( $level2 == 1 )
{
	echo "<table id=\"glist_table\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"006255\" class=\"m_tab\" width=\"778\">
		<tr class='m_title_ft'><td align='middle' width='84'>总代理</td><td width='126'>最后活动时间</td><td width='390'>操作</td><td width='173'>登陆IP</td></tr>\r\n  ";
				$sql = "select username,logtime,context,logip from web_mem_log where username='".$wd."' $sqladd and level=2 order by logtime desc limit 0,8";
				$result = mysql_query( $sql );
				$count = mysql_num_rows( $result );
				while ( $row = mysql_fetch_array( $result ) )
				{
					$class='';
					if(strtotime($row['logtime'])>$sound_time){
						$class='class=m_cen_red';
						$is_sound=1;
					}
								echo "  <tr class=\"m_cen\">\r\n    <td $class>\r\n      ";
								echo $row['username'];
								echo "    </td>\r\n    <td><font color=\"#CC0000\">\r\n      ";
								echo $row['logtime'];
								echo "      </font></td>\r\n    <td align=right >\r\n      ";
								echo $row['context'];
								echo "    </td>\r\n    <td align=right>\r\n      ";
								echo "<a href='http://ip138.com/ips.asp?action=2&ip=$row[logip]' target=_blank>$row[logip]</a>";
								echo "    </td>\r\n  </tr>\r\n  ";
				}
				if($count>=8) echo "<tr class='m_cen'> <td colSpan=4 align=right><a href='showlog_more.php?uid=$uid&level=2&agents_id=$wd'>更多...</a></td></tr>";
				echo "</table>\r\n<br>\r\n";
}
if ( $level1 == 1 )
{
				echo "<table id=\"glist_table\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"006255\" class=\"m_tab\" width=\"778\">
		<tr class='m_title_ft'><td align='middle' width='84'>股东</td><td width='126'>最后活动时间</td><td width='390'>操作</td><td width='173'>登陆IP</td></tr>\r\n  ";

				$sql = "select username,logtime,context,logip from web_mem_log where username='".$co."' $sqladd and level=1 order by logtime desc limit 0,8";
				$result = mysql_query( $sql );
				$count = mysql_num_rows( $result );
				while ( $row = mysql_fetch_array( $result ) )
				{
					$class='';
					if(strtotime($row['logtime'])>$sound_time){
						$class='class=m_cen_red';
						$is_sound=1;
					}
								echo "  <tr class=\"m_cen\">\r\n    <td width=\"84\" $class>\r\n      ";
								echo $row['username'];
								echo "    </td>\r\n    <td width=\"126\"><font color=\"#CC0000\">\r\n      ";
								echo $row['logtime'];
								echo "      </font></td>\r\n    <td align=right width=\"390\">\r\n      ";
								echo $row['context'];
								echo "    </td>\r\n    <td align=right width=\"173\">\r\n      ";
								echo "<a href='http://ip138.com/ips.asp?action=2&ip=$row[logip]' target=_blank>$row[logip]</a>";
								echo "    </td>\r\n  </tr>\r\n  ";
				}
				if($count>=8) echo "<tr class='m_cen'> <td colSpan=4 align=right><a href='showlog_more.php?uid=$uid&level=1&agents_id=$co'>更多...</a></td></tr>";
				echo "</table>\r\n\r\n<br>\r\n";
}
if ( $level0 == 1 )
{
				echo "<table id=\"glist_table\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"006255\" class=\"m_tab\" width=\"778\">
		<tr class='m_title_ft'><td align='middle' width='84'>大股东</td><td width='126'>最后活动时间</td><td width='390'>操作</td><td width='173'>登陆IP</td></tr>\r\n  ";

				$sql = "select username,logtime,context,logip from web_mem_log where username='".$sp."' $sqladd and level=0 order by logtime desc limit 0,8";
				$result = mysql_query( $sql );
				$count = mysql_num_rows( $result );
				while ( $row = mysql_fetch_array( $result ) )
				{
					$class='';
					if(strtotime($row['logtime'])>$sound_time){
						$class='class=m_cen_red';
						$is_sound=1;
					}
								echo "  <tr class=\"m_cen\">\r\n    <td width=\"84\" $class>\r\n      ";
								echo $row['username'];
								echo "    </td>\r\n    <td width=\"126\"><font color=\"#CC0000\">\r\n      ";
								echo $row['logtime'];
								echo "      </font></td>\r\n    <td align=right width=\"390\">\r\n      ";
								echo $row['context'];
								echo "    </td>\r\n    <td align=right width=\"173\">\r\n      ";
								echo "<a href='http://ip138.com/ips.asp?action=2&ip=$row[logip]' target=_blank>$row[logip]</a>";
								echo "    </td>\r\n  </tr>\r\n  ";
				}
				if($count>=8) echo "<tr class='m_cen'> <td colSpan=4 align=right><a href='showlog_more.php?uid=$uid&level=0&agents_id=$sp'>更多...</a></td></tr>";
				echo "</table>";
}
?>
<br><br><br><br>
<?
if($is_sound){
	echo "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='1' height='1' id='ESTime'>
	<param name='movie' value='/images/sound.swf'param name='quality' value='high'>
	<embed src='/images/sound.swf' quality='high' type='application/x-shockwave-flash' width='1' height='1'></embed></object>";
}
?>
</body>
</html>
