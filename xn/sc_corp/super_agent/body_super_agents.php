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
}else{

$row = mysql_fetch_array($result);
$agname=$row['Agname'];

$edit=$row['edit'];
$langx='zh-vn';
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
$super_agents_id=$_REQUEST['super_agents_id'];

$mid=$_REQUEST["mid"];
$page=$_REQUEST["page"];
if ($page==''){
	$page=0;
}
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
	$xm="Bật";
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
	$xm="Tắt";
	break;
default:
	$enable='S';
	$memstop='Y';
	$enabled=2;
	$stop=2;
	$start_font="";
	$end_font="</font>";
	$caption2="<SPAN STYLE='background-color: rgb(0,255,0);'>Tạm ngưng</SPAN>";
	$caption1=$mem_enable;
	$xm="Tạm ngưng";
	break;
}

if ($active==3){
	$mysql="select agname from web_world where ID=$mid";
	mysql_query( $mysql);
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$agent_name=$row['agname'];

	$mysql="delete from web_world where ID=$mid";
	mysql_query( $mysql);
	$mysql="delete from web_agents where world='".$agent_name."'";
	mysql_query( $mysql);
	$mysql="delete from web_member where world='".$agent_name."'";
	mysql_query( $mysql);
	//$mysql="delete from web_db_io where world='".$agent_name."'";
	//mysql_query( $mysql);

	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','Xóa','$agent_name','Đại lý tổng hợp',2)";
	mysql_query($mysql) or die ("Thao tác thất bại!");
}

if ($active==2){
	$mysql="update web_world set oid='',Status=$stop where ID=$mid";
	mysql_query($mysql);

	$mysql="select agname from web_world where ID=$mid";
	$result = mysql_query( $mysql);
	$row = mysql_fetch_array($result);
	$agent_name=$row['agname'];

	$mysql="update web_world set oid='',Status=$stop where subuser=1 and subname='$agent_name'";
	mysql_query( $mysql);

	$mysql="update web_agents set oid='',Status=$stop where world='$agent_name'";
	mysql_query( $mysql);

	$mysql="update web_member set oid='',Status=$stop where world='$agent_name'";
	mysql_query( $mysql);

	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','$xm','$agent_name','Đại lý tổng hợp',2)";
	mysql_query($mysql) or die ("Thao tác thất bại!");
}

if ($super_agents_id==''){
	$sql = "select corprator,passwd,ID,Agname,passwd_safe,Alias,Credit,AgCount,date_format(AddDate,'%Y-%m-%d %H:%i:%s') as AddDate, date_format(enddate,'%Y-%m-%d %H:%i:%s') as enddate from web_world where Status=$enabled and subuser=0  and super='$agname' order by ".$sort." ".$orderby;
}else{
	$sql = "select corprator,passwd,ID,Agname,passwd_safe,Alias,Credit,AgCount,date_format(AddDate,'%Y-%m-%d %H:%i:%s') as AddDate, date_format(enddate,'%Y-%m-%d %H:%i:%s') as enddate from web_world where Status=$enabled and corprator='$super_agents_id' and subuser=0  and super='$agname'  order by ".$sort." ".$orderby;
}
$result = mysql_query( $sql);
$cou=mysql_num_rows($result);

$page_size=30;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";
$result = mysql_query( $mysql);
$level=$_REQUEST['level']?$_REQUEST['level']:1;
if ($cou==0){
	$page_count=1;
}
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
.m_title_suag {  background-color: #CD9A99; text-align: center}
-->
</style>
<SCRIPT language=javaScript src="/js/agents<?=$body_js?>.js" type=text/javascript></SCRIPT>
<SCRIPT language=javaScript>
    var uid='<?=$uid?>';
    function ch_level(i)
    {
        if(i === 1) {
            self.location = '/xn/sc_corp/super_agent/body_super_agents.php?uid='+uid+'&level='+i;
        } else if(i === 2) {
            self.location = '/xn/sc_corp/agents/su_agents.php?uid='+uid+'&level='+i;
        } else if(i === 3) {
            self.location = '/xn/sc_corp/members/ag_members.php?uid='+uid+'&level='+i;
        } else if(i === 5) {
            self.location = '/xn/sc_corp/wager_list/wager_add.php?uid='+uid+'&level='+i;
        } else if(i === 6) {
            self.location = '/xn/sc_corp/wager_list/wager_hide.php?uid='+uid+'&level='+i;
        } else  {
            self.location = '/xn/sc_corp/su_subuser.php?uid='+uid+'&level='+i;
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
</head>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()";>
<div id="top_nav_container" name="fixHead" class="top_nav_container_ann" >
    <div id="general_btn" class="<? if ($level == 1) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(1);">Đại lý tổng hợp</div>
    <div id="important_btn" class="<? if ($level == 2) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(2);">Đại lý</div>
    <div id="personal_btn" class="<? if ($level == 3) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(3);">Thành viên</div>
    <div id="general_btn1" class="<? if ($level == 4) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(4);">Tài khoản phụ</div>
    <? if($setdata['d0_wager_add']==1){ ?>
        <div id="important_btn1" class="<? if ($level == 5) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(5);">Thêm tài khoản</div>
    <? } ?>
    <? if($setdata['d0_wager_hide']==1){ ?>
        <div id="personal_btn1" class="<? if ($level == 6) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(6);">Tài khoản ẩn</div>
    <? } ?>
</div>
<form name="myFORM" action="./body_super_agents.php?uid=<?=$uid?>" method=POST style="padding-top: 62px;">
<table width="840" border="0" cellspacing="0" cellpadding="0" style="margin-left:20px;margin-bottom: 10px;">
  <tr>
    <td class="">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td>&nbsp;&nbsp;<?=$cor_agents?>:</td>
            <td>
           <select class=za_select id=super_agents_id onchange=document.myFORM.submit(); name=super_agents_id>
				<option value="" selected><?=$rep_pay_type_all?></option>
				<?
	$mysql = "select ID,Agname from web_corprator where Status=1 and super='$agname' and subuser=0";
	$ag_result = mysql_query( $mysql);
				while ($ag_row = mysql_fetch_array($ag_result)){
					if ($super_agents_id==$ag_row['Agname']){
						echo "<option value=".$ag_row['Agname']." selected>".$ag_row['Agname']."</option>";
						$sel_agents=$ag_row['Agname'];
					}else{
						echo "<option value=".$ag_row['Agname'].">".$ag_row['Agname']."</option>";

					}
				}
				?>
			</select>
			<select id="enable" name="enable" onChange="self.myFORM.submit()" class="za_select">
                <option value="Y"><?=$mem_enable?></option>
                <option value="N"><?=$mem_disable?></option>                 <option value="S" >Tạm ngưng</option>
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
		<?
		for($i=0;$i<$page_count;$i++){
			echo "<option value='$i'>".($i+1)."</option>";
		}
		?>
              </select>
            </td>
            <td> / <?=$page_count?> <?=$mem_page?> </td>
                        <td>
              <input type=BUTTON name="append" value="Thêm" onClick="document.location='./body_super_agents_add.php?uid=<?=$uid?>'" class="za_button">
            </td>
          </tr>
        </table>
    </td>
  </tr>
</table>
<?

if ($cou==0){
$page_count=1;
?>
<table width="860" border="0" cellspacing="1" cellpadding="0"  bgcolor="976061" class="m_tab" style="margin-left:20px;margin-bottom: 10px;">
    <tr class="m_title_suag">
      <td height="30" align=center>Hiện tại không có đại lý chung</td>
    </tr>
  </table>
<?
}else{
 ?>
  <table width="" border="0" cellspacing="1" cellpadding="0"  bgcolor="976061" class="m_tab" style="margin-left:20px;margin-bottom: 10px;">
    <tr class="m_title_suag"  bgcolor="86C0A6">
      <td width="60">Cổ đông</td>
      <td width="76"><?=$cor_name1?></td>
      <td width="80"><?=$cor_user?></td>
      <td width="80">Mã bảo mật</td>
      <? if($edit==1) echo "<td width=86>Mật khẩu</td>"; ?>
      <td width="91"><?=$rep_pay_type_c?></td>
      <td width="81"><?=$cor_count?></td>
      <td width="130">Thêm ngày</td>
      <td width="130">Thời gian hết hạn</td>
      <td width="59"><?=$mem_status?></td>
      <td width="230"><?=$mem_option?></td>
    </tr>
    <?
	while ($row = mysql_fetch_array($result)){
			$sql = "select count(*) as cou from web_agents where world='".$row['Agname']."' order by id";
		$cresult = mysql_query( $sql);
		$crow = mysql_fetch_array($cresult);
		
		$class = 'm_cen';
		if($row['enddate']=='0000-00-00 00:00:00'){
			$row['enddate']='Không bao';
		}
		elseif(strtotime($row['enddate']) < time()){
			$class = 'm_cen_red';
		}

?>
    <tr  class="<?=$class?>">
      <td><?=$row['corprator']?></td>
      <td><?=$row['Alias']?></td>
      <td><?=$row['Agname']?></td>
      <td><?=$row['passwd_safe']?></td>
      <? if($edit==1) echo "<td>$row[passwd] </td>"; ?>
      <td align="right"><?=$row['Credit']?> </td>
      <td><?=$crow['cou']?></td>
      <td><?=$row['AddDate']?></td>
      <td><?=$row['enddate']?></td>
      <td><?=$caption2?></td>
      <td align="left">
 <?
if($enable=='Y'){
?>
<a href="javascript:CheckSTOP('./body_super_agents.php?uid=<?=$uid?>&active=2&mid=<?=$row['ID']?>&enable=S','S')">Tạm ngưng</a> /
<?
}
?>       <a href="javascript:CheckSTOP('./body_super_agents.php?uid=<?=$uid?>&active=2&mid=<?=$row['ID']?>&enable=<?=$memstop?>','<?=$memstop?>')">
        <?=$caption1?>
        </a>       / <a href="./body_super_agents_edit.php?uid=<?=$uid?>&id=<?=$row['ID']?>&sid=<?=$row['corprator']?>"><?=$mem_acount?></a>
        / <a href="./body_super_agents_set.php?uid=<?=$uid?>&id=<?=$row['ID']?>&sid=<?=$row['corprator']?>"><?=$mem_setopt?></a>
 / <a href="javascript:CheckDEL('./body_super_agents.php?uid=<?=$uid?>&active=3&mid=<?=$row['ID']?>&enable=<?=$enable?>')">
        <?=$mem_delete?>
        </a>
        </td>
    </tr>
    <?
}
}
}
?>
  </table>
  </table>

</form>
</body>
</html>
<?
mysql_close();
?>
