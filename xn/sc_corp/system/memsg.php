<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
$date_start=$_REQUEST['date_start'];
$uid=$_REQUEST['uid'];
$id=$_REQUEST['id'];
$usr=$_REQUEST['user'];
$show=$_REQUEST['show'];
if ($show==1){
	$show=0;
}else{
	$show=1;
}

$level=$_REQUEST['form_action'];
$scoll_news=$_REQUEST['scoll_news'];

$sql = "select id,agname,setdata from web_super where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$super=$row['agname'];
$setdata = @unserialize($row['setdata']);
if($setdata['sendmsg']!=1){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>无权访问";
	exit;
}

if($usr){
	$sql = "select id from web_member where Memname='$usr' and super='$super'";
	$result = mysql_query($sql);
	$cou=mysql_num_rows($result);
	if($cou==0)exit;
}

if ($level==1){
	$filename = "../../member/include/big5-gb.table";
	$fp = fopen($filename, "rb");
	$big5 = fread($fp,filesize($filename));
	fclose($fp);
	$filename = "../../member/include/gb-big5.table";
	$fp = fopen($filename, "rb");
	$gb = fread($fp,filesize($filename));
	fclose($fp);

	/**
	GB码转换成Big5码
	*/
	function gb2big5($Text) {
		$filename = "../../member/include/gb-big5.table";
		$fp = fopen($filename, "rb");
		$gb = fread($fp,filesize($filename));
		fclose($fp);
		$max = strlen($Text)-1;
		for($i=0;$i<$max;$i++) {
			$h = ord($Text[$i]);
			if($h>=160) {
				$l = ord($Text[$i+1]);
				if($h==161 && $l==64) {
					$big = "　";
				}else{
					$p = ($h-160)*510+($l-1)*2;
					$big = $gb[$p].$gb[$p+1];
				}
				$Text[$i] = $big[0];
				$Text[$i+1] = $big[1];
				$i++;
			}
		}
		return $Text;
	}
	$msg=$scoll_news;
	$msg_tw=gb2big5($scoll_news);
	$msg_en=$_REQUEST[SC3];
	$ndate=date('Y-m-d');
	$ntime=date('Y-m-d H:i:s');

	$mysql="delete from message where member='".$usr."'";
	mysql_query($mysql);
	$mysql="insert into message(message,message_tw,message_en,ntime,ndate,member) values ('$msg','$msg_tw','$msg_en','$ntime','$ndate','$usr')";

	mysql_query($mysql);
	echo "<Script language=javascript>self.location='./memlog.php?uid=$uid';</script>";
}

if ($date_start=='') {
	$date_start=date('Y-m-d');
}


$action=$_REQUEST['active'];
if ($action==1){
	//$sql="update web_marquee set mshow=".$show." where id=$id";
	//echo $sql;
	//mysql_query($sql);
	//echo "<Script language=javascript>self.location='./notice.php?uid=$uid';</script>";
}else if ($action==2){
	$mysql="delete from message where member='$usr' and id='".$_REQUEST['mid']."'";
	mysql_query($mysql);
}

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<script>
var current = null
function colorTRx(flag){
	if(flag==1 && current!=null){
		current.style.backgroundColor = current._background;
		current.style.color = current._font;
		current = null
		return;
	}
	if ((self.event.srcElement.parentElement.rowIndex!=0) && (self.event.srcElement.parentElement.tagName=="TR") && (current!=self.event.srcElement.parentElement)) {
		if (current!=null){
			current.style.backgroundColor = current._background
			current.style.color = current._font
		}
		self.event.srcElement.parentElement._background = self.event.srcElement.parentElement.style.backgroundColor
		self.event.srcElement.parentElement._font = self.event.srcElement.parentElement.style.color
		self.event.srcElement.parentElement.style.backgroundColor = "#FFCC66"
		self.event.srcElement.parentElement.style.color = "red"
		current = self.event.srcElement.parentElement
	}
}

function scroll_chk(){
	SCROLL_FROM.form_action.value='Y';
	if(SCROLL_FROM.scoll_text.value=='') return false;
}
function news_chk(){
	SCROLL_FROM.form_action.value='1';
	if(SCROLL_FROM.scoll_news.value=='') return false;
}
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="m_tline" width="750">&nbsp;&nbsp;&quot;简体&quot;<font color='#FF0000'>会员<font color="#0000FF"><?=$usr?></font>
      站内短消息</font></td>
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr>
    <td colspan="2" height="4"></td>
  </tr>
</table>
<?

$sql = "select msg.* from message as msg, web_member as m where msg.member=m.Memname and m.super='$super' and msg.member='".$usr."' limit 0,1";
$result = mysql_query( $sql);
$row = mysql_fetch_array($result);

?>
<form method="post" name='SCROLL_FROM' >
  <table width="750" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed" >
    <tr >
      <td width="160" height="80" align="right">更新简体短消息内容:<br> </td>
      <td colspan="3"> <textarea name="scoll_news" cols="85" rows="3" wrap="PHYSICAL"><?=$row['message']?></textarea>
      </td>
    <tr align="center" >
      <td colspan="4" bgcolor="6EC13E"> <input type="submit" value="确定输入"  name="Submit" class="za_button" onclick='return news_chk();'>
        <input type="reset" value="取消重填"  name="Reset" class="za_button"> <input type="hidden" name="form_action" value="Y">
      </td>
    </tr>
  </table>

<BR>
<table width="750" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
	<tr class="m_bc_ed"><td colspan="4" align="center"><b>短信息</b></td></tr>
	<tr class="m_title_edit"><td>编号</td><td>会员</td><td>内容</td><td width="60">已读次数</td><td width="40">功能</td></tr>
  <?

$sql = "select msg.* from message as msg, web_member as m where msg.member=m.Memname and m.super='$super'";

$result = mysql_query( $sql);
while ($row = mysql_fetch_array($result))
{
?>
  <tr bgcolor="#FFFFFF" onmouseover="colorTRx(0)" onmouseout="colorTRx(1)" style="display: {SHOW_TR}">

    <td width="10" align="center"><?=$row['id']?></td><td width="55" align="center"><font color=red><?=$row['member']?></font></td>
      <td align="left"><?=$row['message']?></td>	  
	  <td align="center"><?=$row['readcount']?></td>
      <td width="40" align="center"><a href="memsg.php?uid=<?=$uid?>&mid=<?=$row[id]?>&user=<?=$row['member']?>&active=2" onClick="return Delete_sure();">删除</a></td>
    <?
}
?>
  </tr>

</table>
</form>
</body>
</html>

