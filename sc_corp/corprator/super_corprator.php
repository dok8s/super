<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
$uid=$_REQUEST["uid"];
$sql = "select Agname,ID,language,edit from web_super where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$edit=$row['edit'];
$langx='zh-cn';
require ("../../member/include/traditional.$langx.inc.php");

$result = mysql_db_query( $dbname, "select * from web_system" );
$setrow = mysql_fetch_array( $result );
$setdata = @unserialize($setrow['setdata']);
$setdata['opendel']!=1 && $mem_delete='';

$enable=$_REQUEST["enable"];
$enabled=$_REQUEST["enabled"];
$sort=$_REQUEST["sort"];
$active=$_REQUEST["active"];
$orderby=$_REQUEST["orderby"];
$page=$_REQUEST["page"];
if ($page==''){
	$page=0;
}
$mid=$_REQUEST["mid"];

if ($enable==""){
$enable='Y';
}

if ($sort==""){
	$sort='Alias';
}

if ($orderby==""){
	$orderby='asc';
}

switch($enable){
case "Y":
	$enabled=1;
	$memstop='N';
	$stop=1;
	$start_font="";
	$end_font="";
	$caption1=$mem_disable;
	$caption2=$mem_enable;
	$xm="启用";
	break;
case "N":
	$enable='N';
	$memstop='Y';
	$enabled=0;
	$stop=0;
	//$start_font="<font color=#999999>";
	$start_font="";
	$end_font="</font>";
	$caption2="<SPAN STYLE='background-color: rgb(255,0,0);'>$mem_disable</SPAN>";
	$caption1=$mem_enable;
	$xm="停用";
	break;
default:
	$enable='S';
	$memstop='Y';
	$enabled=2;
	$stop=2;
	$start_font="";
	$end_font="</font>";
	$caption2="<SPAN STYLE='background-color: rgb(0,255,0);'>暂停</SPAN>";
	$caption1=$mem_enable;
	$xm="暂停";
	break;
}
if ($active==3){
	$xm="删除";
}

if ($active==2){
	$mysql="update web_corprator set oid='',Status=$stop where ID=$mid";
	mysql_query( $mysql);

	$mysql="select agname from web_corprator where ID=$mid";
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$agent_name=$row['agname'];

	$mysql="update web_corprator set oid='',Status=$stop where subuser=1 and subname='$agent_name'";
	mysql_query($mysql);

	$mysql="update web_world set oid='',Status=$stop where corprator='$agent_name'";
	mysql_query( $mysql);
	$mysql="update web_agents set oid='',Status=$stop where corprator='$agent_name'";
	mysql_query( $mysql);
	$mysql="update web_member set oid='',Status=$stop where corprator='$agent_name'";
	mysql_query( $mysql);
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','$xm','$agent_name','股东',2)";
	mysql_query($mysql) or die ("操作失败!");
}else if ($active==3){

	$mysql="select agname from web_corprator where ID=$mid";
	mysql_query( $mysql);

	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$agent_name=$row['agname'];

	$mysql="delete from web_agents  where corprator='$agent_name'";
	mysql_query( $mysql);

	$mysql="delete from web_member where corprator='$agent_name'";
	mysql_query( $mysql);

	$mysql="delete from web_world  where corprator='$agent_name'";
	mysql_query($mysql) or die ("操作失败!");
	
	$mysql="delete from  web_corprator  where ID=$mid";
	mysql_query($mysql);

	//$mysql="delete from web_db_io where corprator='$agent_name'";
	//mysql_query( $mysql);
	
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','$xm','$agent_name','股东',2)";
	mysql_query($mysql) or die ("操作失败!");
}
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_title_sucor {  background-color: #429CCD; text-align: center}
-->
</style>

<SCRIPT language=javaScript src="/js/agents<?=$body_js?>.js" type=text/javascript></SCRIPT>
<SCRIPT language=javaScript>
<!--
 function onLoad()
 {
  var obj_sagent_id = document.getElementById('super_agents_id');
  obj_sagent_id.value = '';
  var obj_enable = document.getElementById('enable');
  obj_enable.value = '<?=$enable?>';
  var obj_page = document.getElementById('page');
  obj_page.value = '<?=$page?>';
  var obj_sort=document.getElementById('sort');
  obj_sort.value='<?=$sort?>';
  var obj_orderby=document.getElementById('orderby');
  obj_orderby.value='<?=$orderby?>';
 }
// -->
</SCRIPT>
</head>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()";>
<form name="myFORM" action="super_corprator.php?uid=<?=$uid?>" method=POST>
<table width="840" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="m_tline">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td>&nbsp;&nbsp;<?=$cor_manage?>:</td>
            <td>
              <select id="enable" name="enable" onChange="self.myFORM.submit()" class="za_select">
                <option value="Y"><?=$mem_enable?></option>
                <option value="N"><?=$mem_disable?></option>                 <option value="S" >暂停</option>
              </select>
            </td>
            <td> -- <?=$mem_orderby?>:</td>
            <td>
              <select id="super_agents_id" name="sort" onChange="document.myFORM.submit();" class="za_select">
                <option value="Alias"><?=$cor_name1?></option>
                <option value="Agname"><?=$cor_user?></option>
                <option value="AddDate"><?=$mem_adddate?></option>
              </select>
              <select id="enable" name="orderby" onChange="self.myFORM.submit()" class="za_select">
                <option value="asc"><?=$mem_order_asc?></option>
                <option value="desc"><?=$mem_order_desc?></option>
              </select>
            </td>
            <td width="52"> -- <?=$mem_pages?>:</td>
            <td>
              <select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
              <option value="0">1</option>
              </select>
            </td>
            <td> / 1 <?=$mem_page?> -- </td>
            <td>
              <input type=BUTTON name="append" value="<?=$mem_add?>" onClick="document.location='super_corprator_add.php?uid=<?=$uid?>'" class="za_button">
            </td>
          </tr>
        </table>
    </td>
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr>
    <td colspan="2" height="4"></td>
  </tr>
</table>
<?
$sql = "select ID,Agname,passwd_safe,passwd,Alias,Credit,AgCount,date_format(AddDate,'%Y-%m-%d %H:%i:%s') as AddDate, date_format(enddate,'%Y-%m-%d %H:%i:%s') as enddate from web_corprator where Status='$enabled' and super='$agname'  and subuser=0 order by ".$sort." ".$orderby;
$result = mysql_query( $sql);
$cou=mysql_num_rows($result);
if ($cou==0){
?>
  <table width="780" border="0" cellspacing="1" cellpadding="0"  bgcolor="0E75B0" class="m_tab">
    <tr class="m_title">
      <td height="30" class="m_title_sucor" >
        目前无任何股东
      </td>
    </tr>
  </table>
<?
}else{
 ?>
  <table width="" border="0" cellspacing="1" cellpadding="0"  bgcolor="0E75B0" class="m_tab">
    <tr class="m_title_sucor"  bgcolor="#429CCD">
      <td width="80"><?=$rcl_corp?><?=$sub_name?></td>
      <td width="80"><?=$rcl_corp?><?=$sub_user?></td>
      <td width="80">安全代码</td>
      <? if($edit==1) echo "<td width=107>密码</td>"; ?>
      <td width="101"><?=$rep_pay_type_c?></td>
      <td width="87"><?=$rcl_world?></td>
      <td width="130"><?=$mem_adddate?></td>
      <td width="130">到期时间</td>
      <td width="66"><?=$mem_status?></td>
      <td width="230"><?=$mem_option?></td>
    </tr>
    <?
		while ($row = mysql_fetch_array($result)){
			$sql = "select count(*) as cou from web_world where corprator='".$row['Agname']."' order by id";
			$cresult = mysql_query( $sql);
			$crow = mysql_fetch_array($cresult);
		
		$class = 'm_cen';
		if($row['enddate']=='0000-00-00 00:00:00'){
			$row['enddate']='永不过期';
		}
		elseif(strtotime($row['enddate']) < time()){
			$class = 'm_cen_red';
		}
		?>
    <tr class="<?=$class?>">
      <td><?=$row['Alias']?></td>
      <td><?=$row['Agname']?></td>
      <td><?=$row['passwd_safe']?></td>
      <? if($edit==1) echo "<td>$row[passwd] </td>"; ?>
      <td align="right"><?=$row['Credit']?></td>
      <td><?=$crow['cou']?></td>
      <td><?=$row['AddDate']?></td>
      <td><?=$row['enddate']?></td>
      <td><?=$caption2?></td>
      <td align="left">
			 <?
			if($enable=='Y'){
			?>
			<a href="javascript:CheckSTOP('./super_corprator.php?uid=<?=$uid?>&active=9&mid=<?=$row['ID']?>&enable=S','S')">暂停</a> /
			<?
			}
			?>
				<a href="javascript:CheckSTOP('./super_corprator.php?uid=<?=$uid?>&active=2&mid=<?=$row['ID']?>&enable=<?=$memstop?>','<?=$memstop?>')">
        <?=$caption1?>
        </a> / <a href="./super_corprator_edit.php?uid=<?=$uid?>&id=<?=$row['ID']?>&super_agents_id=<?=$agid?>">
        <?=$mem_acount?>
        </a> / <a href="./super_corprator_set.php?uid=<?=$uid?>&id=<?=$row['ID']?>&super_agents_id=<?=$agid?>">
        <?=$mem_setopt?>
        </a> / <a href="javascript:CheckDEL('./super_corprator.php?uid=<?=$uid?>&active=3&mid=<?=$row['ID']?>&enable=<?=$enable?>')">
        <?=$mem_delete?>
        </a></td>
    </tr>
    <?
}
}
?>
  </table>
  </table>
</form>
<!----------------------赋梛弝敦---------------------------->
</body>
</html>
<?
mysql_close();
?>
