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

$sql = "select id,subuser,agname,subname,status, setdata,edit from web_super where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
    echo "<script>window.open('$site/index.php','_top')</script>";
    exit;
}

$agname=$row['agname'];
$edit=intval($row['edit']);
$setdata = @unserialize($row['setdata']);
//$result = mysql_db_query( $dbname, "select * from web_system" );
//$setrow = mysql_fetch_array( $result );
//$setdata = @unserialize($setrow['setdata']);
//$setdata['opendel']!=1 && $mem_delete='';

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
    $level=$_REQUEST['level']?$_REQUEST['level']:1;
}
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a1.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a2.css" type="text/css">
<link rel="stylesheet" href="../css/loader.css" type="text/css">
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="/js/ClassSelect_ag.js" type="text/javascript"></script>

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
<style type="text/css">
<!--
.m_title_sucor {  background-color: #429CCD; text-align: center}
-->
</style>

<SCRIPT language=javaScript src="/js/agents<?=$body_js?>.js" type=text/javascript></SCRIPT>
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
<form name="myFORM" action="super_corprator.php?uid=<?=$uid?>" method=POST style="padding-top: 62px;">
<table width="840" border="0" cellspacing="0" cellpadding="0" style="margin-left:20px;margin-bottom: 10px;">
  <tr>
    <td class="">
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
  </tr>
</table>
<?
$sql = "select ID,Agname,passwd_safe,passwd,Alias,Credit,AgCount,date_format(AddDate,'%Y-%m-%d %H:%i:%s') as AddDate, date_format(enddate,'%Y-%m-%d %H:%i:%s') as enddate from web_corprator where Status='$enabled' and super='$agname'  and subuser=0 order by ".$sort." ".$orderby;
$result = mysql_query( $sql);
$cou=mysql_num_rows($result);
if ($cou==0){
?>
  <table width="780" border="0" cellspacing="1" cellpadding="0"  bgcolor="0E75B0" class="m_tab" style="margin-left:20px;margin-bottom: 10px;">
    <tr class="m_title">
      <td height="30" class="m_title_sucor" >
        目前无任何股东
      </td>
    </tr>
  </table>
<?
}else{
 ?>
  <table width="" border="0" cellspacing="1" cellpadding="0"  bgcolor="0E75B0" class="m_tab" style="margin-left:20px;margin-bottom: 10px;">
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
<script>
    function go_web(sw1,sw2,sw3) {
        if(sw1==1 && sw2==5){Go_Chg_pass(1);}
        else{window.open('trans.php?sw1='+sw1+'&sw2='+sw2+'&sw3='+sw3,'main');}
    }
</script>
<?
mysql_close();
?>
