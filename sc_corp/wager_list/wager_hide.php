<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$sql = "select agname,setdata from web_super where oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['agname'];
$setdata = @unserialize($row['setdata']);
$cou=mysql_num_rows($result);
if($cou==0 || $setdata['d0_wager_hide']!=1){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$enable=$_REQUEST["enable"];
$enabled=$_REQUEST["enabled"];
$sort=$_REQUEST["sort"];
$orderby=$_REQUEST["orderby"];
$mid=$_REQUEST["id"];
$active=$_REQUEST["active"];
$page=$_REQUEST["page"];
if ($page==''){	$page=0;}
if ($enable==""){	$enable='Y';}

if ($sort==""){	$sort='alias';}

if ($orderby==""){	$orderby='asc';}

if ($enable=="Y"){
	$enabled=1;
	$memstop='N';
	$stop=1;
	$start_font="";
	$end_font="";
	$caption1='停用';
	$caption2='启用';
}else{
	$enable='N';
	$memstop='Y';
	$enabled=0;
	$stop=0;
	$start_font="";
	$end_font="</font>";
	$caption2="<SPAN STYLE='background-color: rgb(255,255,0);'>停用</SPAN>";
	$caption1='启用';
}
if ($active==2){
	$mysql="update web_member set Status=$stop where super='$agname' and id=$mid";
	mysql_query( $mysql);
}
if ($active==3 && $setdata['d0_wager_hide_deluser']==1){
	$sql="update web_member set hidden=0 where super='$agname' and id=$mid";
	mysql_query( $sql);
}
$level=$_REQUEST['level']?$_REQUEST['level']:6;
?>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a1.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a2.css" type="text/css">
<link rel="stylesheet" href="../css/loader.css" type="text/css">
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="/js/ClassSelect_ag.js" type="text/javascript"></script>
<SCRIPT language="javascript" src="/js/member.js"></script>
<SCRIPT language=javaScript>
    var uid='<?=$uid?>';
    function ch_level(i)
    {
        if(i === 1) {
            self.location = '/sc_corp/super_agent/body_super_agents.php?uid='+uid+'&level='+i;
        } else if(i === 2) {
            self.location = '/sc_corp/agents/su_agents.php?uid='+uid+'&level='+i;
        } else if(i === 3) {
            self.location = '/sc_corp/members/ag_members.php?uid='+uid+'&level='+i;
        } else if(i === 5) {
            self.location = '/sc_corp/wager_list/wager_add.php?uid='+uid+'&level='+i;
        } else if(i === 6) {
            self.location = '/sc_corp/wager_list/wager_hide.php?uid='+uid+'&level='+i;
        } else  {
            self.location = '/sc_corp/su_subuser.php?uid='+uid+'&level='+i;
        }

    }
</SCRIPT>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.m_title {  background-color: #FEF5B5; text-align: center}
-->
</style>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
    <link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
    <link rel="stylesheet" href="/style/control/calendar.css">
    <link rel="stylesheet" href="/style/control/control_main1.css" type="text/css">
    <link rel="stylesheet" href="/style/home.css" type="text/css">
    <script type="text/javascript">
        // 等待所有加载
        $(window).load(function(){
            $('body').addClass('loaded');
            $('#loader-wrapper .load_title').remove();
        });
    </script>
<SCRIPT language="javascript" src="/js/member.js"></script>
<SCRIPT>

 function onLoad()
 {
  //var obj_sagent_id = document.getElementById('agent_id');
  //obj_sagent_id.value = '<?=$agid?>';
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
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()";>
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">正在加载...</div>
</div>
<div id="top_nav_container" name="fixHead" class="top_nav_container_ann" >
    <div id="general_btn" class="<? if ($level == 1) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(1);">总代理</div>
    <div id="important_btn" class="<? if ($level == 2) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(2);">代理</div>
    <div id="personal_btn" class="<? if ($level == 3) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(3);">会员</div>
    <div id="general_btn1" class="<? if ($level == 4) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(4);">子帐号</div>
    <? if($setdata['d0_wager_add']==1){ ?>
        <div id="important_btn1" class="<? if ($level == 5) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(5);">添单帐号</div>
    <? } ?>
    <? if($setdata['d0_wager_hide']==1){ ?>
        <div id="personal_btn1" class="<? if ($level == 6) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(6);">隐单帐号</div>
    <? } ?>
</div>
<FORM NAME="myFORM" ACTION="wager_hide.php?uid=<?=$uid?>" METHOD=POST style="padding-top: 62px;">
<input type="hidden" name="agent_id" value="<?=$agid?>">
<?
$sql = "select passwd,ID,Memname,pay_type,money,Alias,Credit,ratio,date_format(AddDate,'%m-%d / %H:%i') as AddDate,pay_type,Agents,OpenType from web_member where super='$agname' and hidden=1 and Status='$enabled' order by ".$sort." ".$orderby;
$result = mysql_query( $sql);
$cou=mysql_num_rows($result);
$page_size=15;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
$result = mysql_query( $mysql);
?>
<table width="775" border="0" cellspacing="0" cellpadding="0" style="margin-left:20px;margin-bottom: 10px;">
  <tr>
	<td class="">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td>&nbsp;&nbsp;隐单会员            <select name="enable" onChange="self.myFORM.submit()" class="za_select" >
                <option value="Y" >启用</option>
                <option value="N" >停用</option></td>

            <td width="40"> -- 排序</td>
            <td>
              <select id="super_agents_id" name="sort" onChange="document.myFORM.submit();" class="za_select">
                <option value="alias">会员名称</option>
                <option value="memname">会员帐号</option>
                <option value="adddate">加入日期</option>
              </select>
              <select id="enable" name="orderby" onChange="self.myFORM.submit()" class="za_select">
                <option value="asc">升幂(由小到大)</option>
                <option value="desc">降幂(由大到小)</option>
              </select>
            </td>
            <td width="52"> -- 总页数:</td>
            <td>
              <select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
		<?
		for($i=0;$i<$page_count;$i++){
			echo "<option value='$i'>".($i+1)."</option>";
		}
		?>

              </select>
            </td>
            <td> / <?=$page_count?> 页 -- </td>
            <td>
              <input type=BUTTON name="append" value="新增" onClick="document.location='./mem_add.php?uid=<?=$uid?>&keys=HIDDEN'" class="za_button">
            </td>
          </tr>
        </table>
	</td>
</tr>
<tr>
	<td colspan="2" height="4"></td>
</tr>
</table>
<?
if ($cou==0){
?>
  <table width="775" border="0" cellspacing="1" cellpadding="0"  bgcolor="E3D46E" class="m_tab">
    <tr class="m_title">
      <td height="30" ><?=$mem_nomem?></td>
    </tr>
  </table>
<?
}else{
 ?>
  <table width="780" border="0" cellspacing="1" cellpadding="0"  bgcolor="E3D46E" class="m_tab" style="margin-left:20px;margin-bottom: 10px;">
    <tr class="m_title">
      <td width="60">会员名称</td>
      <td width="70">会员帐号</td>
      <td width="60">密码</td>
	  <td width="110">信用额度</td>
	  <td width="30">盘口</td>
      <td width="80">新增日期</td>
      <td width="70">使用状况</td>
      <td width="240">功能</td>
    </tr>
<?
	while ($row = mysql_fetch_array($result)){
?>
	<tr class="m_cen">
      <td><?=$start_font?><?=$row['Alias'];?><?=$end_font?></td>
      <td><?=$start_font?><?=$row['Memname'];?><?=$end_font?></td>
      <td><?=$start_font?><?=$row['passwd'];?><?=$end_font?></td>
	  <td align="right">
      <p align="right"><?=$start_font?><? if ($row['pay_type']==1){
      echo number_format($row['money']*$row['ratio'],2);
	}else{
		echo number_format($row['Credit']*$row['ratio'],2);
	}?>
	<?=$end_font?></td>
      <td><?=$start_font?><?=$row['OpenType']?><?=$end_font?></td>
	  <td><?=$row['AddDate'];?></td>
	  <td><?=$caption2?></td>
      <td align="left"><font color="#0000FF">
		&nbsp;&nbsp;<a href="javascript:CheckSTOP('wager_hide.php?uid=<?=$uid?>&active=2&id=<?=$row['ID']?>&enable=<?=$memstop?>','<?=$memstop?>')"><?=$caption1?></a>
		<?
	if($setdata['d0_wager_hide_deluser']==1){
		echo "&nbsp; /&nbsp; <a href=\"javascript:CheckDEL('wager_hide.php?uid=$uid&active=3&id=$row[ID]')\">删除</a>";
	}
	if($setdata['d0_wager_hide_edit']==1){
		echo "&nbsp; /&nbsp; <a href=\"hide_list.php?uid=$uid&username=$row[Memname]\">详细投注</a>";
	}
		?>
	  </td>
    </tr>
<?
	}
?>
	</table>
</form>

<?
}
?>
</body>
</html>