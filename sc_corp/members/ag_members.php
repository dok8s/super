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
$sql = "select Agname,ID,language,edit,setdata from `web_super` where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}else{

	$row = mysql_fetch_array($result);
	$agname=$row['Agname'];
	$agid=$row['ID'];
	$edit=$row['edit'];
	$setdata = @unserialize($row['setdata']);
	$showpassowrd = 1;
	if($setdata['d0_wager_add_edit']!=1 && $setdata['d0_wager_hide_edit']!=1 && $edit!=1){
		$showpassowrd = 0;
	}


require ("../../member/include/traditional.zh-cn.inc.php");


$setrow = mysql_fetch_array(mysql_query("select * from web_system" ));
$setdata = @unserialize($setrow['setdata']);
$setdata['opendel']!=1 && $mem_delete='';


$enable=$_REQUEST["enable"];
$enabled=$_REQUEST["enabled"];
$sort=$_REQUEST["sort"];
$orderby=$_REQUEST["orderby"];
$mid=$_REQUEST["id"];
$sel_agents=$_REQUEST['super_agents_id'];
$page=$_REQUEST["page"];
if ($page==''){
	$page=0;
}
$active=$_REQUEST["active"];
if ($enable==""){
	$enable='Y';
}

if ($sort==""){
	$sort='alias';
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
	//$enable='N';
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
	//$enable='S';
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

switch ($active){
case 2:
	$mysql="update web_member set oid='',Status=$stop where id=$mid";
	mysql_query( $mysql);

	$mysql="select agents,Memname from web_member where ID=$mid";
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$a11=$row['agents'];
	$memname=$row['Memname'];
	if ($stop==0){
		$mysql="update web_agents set mcount=mcount-1 where agname='$a11'";
	}else{
		$mysql="update web_agents set mcount=mcount+1 where agname='$a11'";
	}
	mysql_query( $mysql);
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','$xm','$memname','会员',2)";
	mysql_query($mysql) or die ("操作失败!");
	break;
case 3:
	$mysql="select memname as agname from web_member where ID=$mid";
	mysql_query( $mysql);
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$agent_name=$row['agname'];

	$sql="delete from web_member where id=$mid";
	mysql_query( $sql);

	//$mysql="delete from web_db_io where m_name='".$agent_name."'";
	//mysql_query( $mysql);
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','删除','$agent_name','会员',2)";
	mysql_query($mysql) or die ("操作失败!");
	break;
case 8:
	$mysql="update web_member set oid='',Status=$stop where ID=$mid";
	mysql_query($mysql);
	$mysql="select agents,Memname from web_member where ID=$mid";
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$a11=$row['agents'];
	$memname=$row['Memname'];
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','$xm','$memname','会员',2)";
	mysql_query($mysql) or die ("操作失败!");
}
$level=$_REQUEST['level']?$_REQUEST['level']:3;
?>
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
<SCRIPT>

 function onLoad()
 {
  var obj_sagent_id = document.getElementById('agent_id');
  obj_sagent_id.value = '<?=$super_agents_id?>';
  var obj_enable = document.getElementById('enable');
  obj_enable.value = '<?=$enable?>';
  var obj_page = document.getElementById('page');
  obj_page.value = '<?=$page?>';
  var obj_sort=document.getElementById('sort');
  obj_sort.value='<?=$sort?>';
  var obj_orderby=document.getElementById('orderby');
  obj_orderby.value='<?=$orderby?>';
 }

function so()
{
	var so_username=document.getElementById('so_username').value;
	if(so_username==''){
		alert('请输入要搜索的会员帐号或会员帐号的一部分');
	}else{
		location='./ag_members.php?uid=<?=$uid?>&so_username='+so_username;
	}
}
// -->
</SCRIPT>
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
</head>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()";>
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
<FORM NAME="myFORM" ACTION="./ag_members.php?uid=<?=$uid?>" METHOD=POST style="padding-top: 62px;">
<input type="hidden" name="agent_id" value="<?=$agid?>">
<?
$sqladd='';
if ($sel_agents!=''){
	$sqladd.="  and Agents='$sel_agents'";
}
if ($_GET['so_username']!=''){
	$sqladd="  and (memname like '%$_GET[so_username]%' or loginname like '%$_GET[so_username]%')";
}

$sql = "select ID,Memname,loginname,passwd,Alias,Credit,money,ratio,date_format(AddDate,'%m-%d / %H:%i') as AddDate,pay_type,OpenType,Agents,super,world,corprator from web_member where Status=$enabled and super='$agname' $sqladd order by $sort $orderby ";

$result = mysql_query( $sql);
$cou=mysql_num_rows($result);
$result = mysql_query( $sql);
$cou=mysql_num_rows($result);
$page_size=30;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
$result = mysql_query( $mysql);
if ($cou==0){
	$page_count=1;
}
?>
<table width="880" border="0" cellspacing="0" cellpadding="0" style="margin-left:20px;margin-bottom: 10px;">
  <tr>
	<td class="">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="60">会员管理</td>
            <td>
			<select class=za_select id=super_agents_id onchange=document.myFORM.submit(); name=super_agents_id>
				<option value="" selected><?=$rep_pay_type_all?></option>
				<?
				$mysql="select ID,Agname from web_agents where Status=1 and subuser=0 and super='$agname'";
				$ag_result = mysql_query( $mysql);
				while ($ag_row = mysql_fetch_array($ag_result)){
					if ($sel_agents==$ag_row['Agname']){
						echo "<option value=".$ag_row['Agname']." selected>".$ag_row['Agname']."</option>";
						//$sel_agents=$ag_row['Agname'];
					}else{
						echo "<option value=".$ag_row['Agname'].">".$ag_row['Agname']."</option>";

					}
				}
				?>
			</select>

							<select id="enable" name="enable" onChange="self.myFORM.submit()" class="za_select">
								<option value="Y">启用</option>
								<option value="N">停用</option>
								<option value="S">暂停</option>
            </select>
            </td>
            <td width="40"> -- <?=$mem_orderby?></td>
            <td>
              <select id="super_agents_id" name="sort" onChange="document.myFORM.submit();" class="za_select">
                <option value="alias"><?=$mem_name?></option>
                <option value="memname"><?=$mem_uid?></option>
                <option value="adddate"><?=$mem_adddate?></option>
              </select>
              <select id="enable" name="orderby" onChange="self.myFORM.submit()" class="za_select">
                <option value="asc"><?=$mem_order_asc?></option>
                <option value="desc"><?=$mem_order_desc?></option>
              </select>
            </td>
            <td width="52"> -- <?=$mem_pages?></td>
            <td>
              <select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
		<?
		for($i=0;$i<$page_count;$i++){
			echo "<option value='$i'>".($i+1)."</option>";
		}
		?>

              </select>
            </td>
            <td> / <?=$page_count?> <?=$mem_page?></td>
            <td>
              <input type=BUTTON name="append" value="<?=$mem_add?>"  onClick="document.location='./ag_mem_add.php?uid=<?=$uid?>'" class="za_button">
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
			<td>会员帐号(或部分)：<INPUT TYPE="text" size=10 name="so_username" id="so_username" value='<?=$_GET['so_username']?>'> <INPUT TYPE="button" VALUE="搜索" ONCLICK="so();"></td>
          </tr>
        </table>
	</td>
</tr>
</table>
<?

if ($cou==0){
?>
  <table width="840" border="0" cellspacing="1" cellpadding="0"  bgcolor="E3D46E" class="m_tab" style="margin-left:20px;margin-bottom: 10px;">
    <tr class="m_title">
      <td height="30" ><?=$mem_nomem?></td>
    </tr>
  </table>
<?
}else{
 ?>
  <table width="" border="0" cellspacing="1" cellpadding="0"  bgcolor="E3D46E" class="m_tab" style="margin-left:20px;margin-bottom: 10px;">
    <tr class="m_title">
      <td width="70"><?=$mem_agents?></td>
      <td width="70"><?=$mem_name?></td>
      <td width="70"><?=$mem_uid?></td>
      <td width="70">登录帐号</td>
      <? if($showpassowrd==1) echo "<td width=70>密码</td>"; ?>
	  <td width="80"><?=$mem_credit?></td>
	  <td width="40"><?=$mem_otypes?></td>
      <td width="80"><?=$mem_adddate?></td>
	  <td width="140">上级</td>
      <td width="60"><?=$mem_status?></td>
      <td width="240"><?=$mem_option?></td>
      <!--<td width="70">押码跳动</td>-->
    </tr>
<?
	while ($row = mysql_fetch_array($result)){
	
	?> <tr class="m_cen">
      <td><?=$start_font?><?=$row['Agents'];?><?=$end_font?></td>
      <td><?=$start_font?><?=$row['Alias'];?><?=$end_font?></td>
      <td><?=$start_font?><?=$row['Memname'];?><?=$end_font?></td>
	  <td><?=$start_font?><?=$row['loginname'];?><?=$end_font?></td>
      <? if($showpassowrd==1) echo "<td>$row[passwd] </td>"; ?>
      <td align="right"><?=$start_font?><?=$row['pay_type']==1? number_format($row['money']*$row['ratio'],2) : number_format($row['Credit']*$row['ratio'],2);?> <?=$end_font?></td>
      <td><?=$start_font?><?=$row['OpenType']?><?=$end_font?></td>
	  <td><?=$row['AddDate'];?></td>
	  <td><?="$row[super] / $row[corprator] / $row[world] / $row[Agents]"?> </td>
	  <td><?=$caption2?></td>
      <td align="left"><font color="#0000FF"><a style="cursor: hand">
		&nbsp;&nbsp;
		<?
		if($enable=='Y'){
		?>
			<a href="javascript:CheckSTOP('./ag_members.php?uid=<?=$uid?>&active=8&id=<?=$row['ID']?>&enable=S','S')">暂停</a> /
		<?
		}
		?>
<a href="javascript:CheckSTOP('./ag_members.php?uid=<?=$uid?>&active=2&id=<?=$row['ID']?>&enable=<?=$memstop?>','<?=$memstop?>')"><?=$caption1?></a>
/ <a href="./ag_mem_edit.php?uid=<?=$uid?>&mid=<?=$row['ID']?>">修改资料</a> 
/ <a href="ag_mem_set.php?uid=<?=$uid?>&pay_type=0&mid=<?=$row['ID']?>&aid=<?=$row['Agents']?>">详细设定</a> 
/ <a href="javascript:CheckDEL('./ag_members.php?uid=<?=$uid?>&active=3&id=<?=$row['ID']?>')"><?=$mem_delete?></a>
		</td>
    </tr>
<?
}
}
}
?>
</table>
</form>
</body>
</html>
<?
mysql_close();
?>
