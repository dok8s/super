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
$sql = "select Agname,ID,language,edit from web_super where Oid='$uid'";
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
$langx='zh-cn';
require ("../../member/include/traditional.zh-cn.inc.php");

$result = mysql_db_query( $dbname, "select * from web_system" );
$setrow = mysql_fetch_array( $result );
$setdata = @unserialize($setrow['setdata']);
$setdata['opendel']!=1 && $mem_delete='';

$enable=$_REQUEST["enable"];
$enabled=$_REQUEST["enabled"];
$sort=$_REQUEST["sort"];
$active=$_REQUEST["active"];
$orderby=$_REQUEST["orderby"];
$super_agents_id=$_REQUEST['super_agents_id'];
$mid=$_REQUEST["mid"];

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



if ($active==2){
	$mysql="update web_agents set oid='',Status=$stop where id=$mid";
	mysql_query( $mysql);

	$mysql="select agname,world from web_agents where ID=$mid";
	mysql_query( $mysql);
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$agent_name=$row['agname'];
	$world=$row['world'];
	$mysql="update web_member set oid='',Status=$stop where agents='$agent_name'";
	mysql_query( $mysql);
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','$xm','$agent_name','代理商',2)";
	mysql_query($mysql) or die ("操作失败!");
}else if ($active==3){

	$mysql="select agname from web_agents where ID=$mid";
	mysql_query( $mysql);
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$agent_name=$row['agname'];

	$mysql="delete from web_agents where ID=$mid";
	mysql_query( $mysql);
	$mysql="delete from web_member where agents='".$agent_name."'";
	mysql_query( $mysql);
	//$mysql="delete from web_db_io where agents='".$agent_name."'";
	//mysql_query( $mysql);
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','删除','$agent_name','代理商',2)";
	mysql_query($mysql) or die ("操作失败!");
}else if ($active==8){
	$mysql="update web_agents set oid='',Status=$stop where ID=$mid";
	mysql_query($mysql);

	$mysql="select agname from web_agents where ID=$mid";
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$agent_name=$row['agname'];

	$mysql="update web_agents set oid='',Status=$stop where subuser=1 and subname='$agent_name'";
	mysql_query( $mysql);

	$mysql="update web_member set oid='',Status=$stop where agents='$agent_name'";
	mysql_query( $mysql);
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','$xm','$agent_name','代理商',2)";
	mysql_query($mysql) or die ("操作失败!");
}
$page=$_REQUEST["page"];
if ($page==''){
	$page=0;
}
if ($super_agents_id==''){
	$sql = "select ID,Agname,passwd_safe,passwd,Alias,Credit,mCount,date_format(AddDate,'%Y-%m-%d %H:%i:%s') as AddDate, date_format(enddate,'%Y-%m-%d %H:%i:%s') as enddate,world from web_agents where Status='$enabled' and subuser=0  and super='$agname'  order by ".$sort." ".$orderby;
}else{
	$sql = "select ID,Agname,passwd_safe,passwd,Alias,Credit,mCount,date_format(AddDate,'%Y-%m-%d %H:%i:%s') as AddDate, date_format(enddate,'%Y-%m-%d %H:%i:%s') as enddate,world from web_agents where world='$super_agents_id' and subuser=0  and super='$agname'  and Status=$enabled order by ".$sort." ".$orderby;
}
$result = mysql_query( $sql);
$cou=mysql_num_rows($result);
$page_size=30;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
$result = mysql_query( $mysql);
$cou=mysql_num_rows($result);
$level=$_REQUEST['level']?$_REQUEST['level']:2;
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a1.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a2.css" type="text/css">
<link rel="stylesheet" href="../css/loader.css" type="text/css">
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="/js/ClassSelect_ag.js" type="text/javascript"></script>
<style type="text/css">
<!--
.m_title {  background-color: #86C0A6; text-align: center}
-->
</style>
<SCRIPT language=javaScript src="/js/agents.js" type=text/javascript></SCRIPT>
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
<SCRIPT language=javaScript>
<!--
 function onLoad()
 {
  var obj_sagent_id = document.getElementById('super_agents_id');
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
<form name="myFORM" action="./su_agents.php?uid=<?=$uid?>" method=POST style="padding-top: 62px;">
<table width="840" border="0" cellspacing="0" cellpadding="0" style="margin-left:20px;margin-bottom: 10px;">
  <tr>
    <td class="">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td>&nbsp;&nbsp;<?=$wld_selagent?>:</td>
            <td>
              <select class=za_select id=super_agents_id onchange=document.myFORM.submit(); name=super_agents_id>
				<option value="" selected><?=$rep_pay_type_all?></option>
				<?
				$mysql="select ID,Agname from web_world where Status=1 and super='$agname' and subuser=0";
				$ag_result = mysql_query( $mysql);
				while ($ag_row = mysql_fetch_array($ag_result)){
					if ($super_agents_id==$ag_row['ID']){
						echo "<option value=".$ag_row['Agname']." selected>".$ag_row['Agname']."</option>";
						$sel_agents=$ag_row['Agname'];
					}else{
						echo "<option value=".$ag_row['Agname'].">".$ag_row['Agname']."</option>";

					}
				}
				?>
			</select>
			  <select id="enable" name="enable" onChange="self.myFORM.submit()" class="za_select">
                <option value="Y" ><?=$mem_enable?></option>
                <option value="N" ><?=$mem_disable?></option>                 <option value="S" >暂停</option>
              </select>
            </td>
            <td> -- <?=$mem_orderby?></td>
            <td>
              <select id="agents_id" name="sort" onChange="document.myFORM.submit();" class="za_select">
                <option value="alias"><?=$mem_name?></option>
                <option value="Agname"><?=$mem_uid?></option>
                <option value="Adddate"><?=$mem_adddate?></option>
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
		if ($page_count==0){$page_count=1;}
		for($i=0;$i<$page_count;$i++){
			echo "<option value='$i'>".($i+1)."</option>";
		}
		?>
              </select>
            </td>
            <td> / <?=$page_count?> <?=$mem_page?> </td>
            <td>
              <input type=BUTTON name="append" value="<?=$mem_add?>" onClick="document.location='./su_ag_add.php?uid=<?=$uid?>'" class="za_button">
            </td>
          </tr>
        </table>
    </td>
  </tr>
</table>
<?
if ($cou==0){
?>
<table width="860" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab" style="margin-left:20px;margin-bottom: 10px;">
	<tr class="m_title">
      <td height="30" >目前无任何代理商</td>
    </tr>
  </table>
<?
}else{
?>
<table width="" border="0" cellspacing="1" cellpadding="0"  bgcolor="4B8E6F" class="m_tab" style="margin-left:20px;margin-bottom: 10px;">
   <tr class="m_title">
      <td width="60">总代理</td>
      <td width="76"><?=$rcl_agent?><?=$sub_name?></td>
      <td width="80"><?=$rcl_agent?><?=$sub_user?></td>
      <td width="80">登录帐号</td>
	  	<? if($edit==1) echo "<td width=86>密码</td>"; ?>
	  	<td width="91"><?=$rep_pay_type_c?></td>
      <td width="50"><?=$wld_memcount?></td>
      <td width="130"><?=$mem_adddate?></td>
      <td width="130">到期时间</td>
      <td width="59"><?=$mem_status?></td>
      <td width="230"><?=$mem_option?></td>
    </tr>
	<?
	while ($row = mysql_fetch_array($result)){
			$sql = "select count(*) as cou from web_member where agents='".$row['Agname']."' order by id";
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
      <td><?=$row['world']?></td>
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
<a href="javascript:CheckSTOP('./su_agents.php?uid=<?=$uid?>&active=8&mid=<?=$row['ID']?>&enable=S','S')">暂停</a> /
<?
}
?><a href="javascript:CheckSTOP('./su_agents.php?uid=<?=$uid?>&active=2&mid=<?=$row['ID']?>&enable=<?=$memstop?>','<?=$memstop?>')">
        <?=$caption1?>
        </a>
       / <a href="./su_ag_edit.php?uid=<?=$uid?>&id=<?=$row['ID']?>&wid=<?=$row['world']?>"><?=$mem_acount?></a>
        / <a href="./su_ag_set.php?uid=<?=$uid?>&id=<?=$row['ID']?>&wid=<?=trim($row['world'])?>"><?=$mem_setopt?></a>
         / <a href="javascript:CheckDEL('./su_agents.php?uid=<?=$uid?>&active=3&mid=<?=$row['ID']?>&enable=<?=$enable?>')"><?=$mem_delete?></a>
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
