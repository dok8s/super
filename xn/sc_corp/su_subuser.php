<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../member/include/config.inc.php");
require ("../member/include/define_function_list.inc.php");
$uid=$_REQUEST["uid"];
$addNew=$_REQUEST["addNew"];
$deluser=$_REQUEST["deluser"];
$edituser=$_REQUEST["edituser"];
$edituser1=$_REQUEST["edituser1"];
$mysql="select Agname,ID,language from web_super where Oid='$uid'";
$result = mysql_query($mysql);
$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
if ($deluser=='Y'){
	$mysql="select Agname from web_super where ID=".$_REQUEST["id"];
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$new_user=$row["Agname"];
	$mysql="delete from web_super where ID=".$_REQUEST["id"];
	$result = mysql_query($mysql);
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','Xóa','$new_user','Cổ đông lớn',2)";
	mysql_query($mysql) or die ("Thao tác thất bại!");
}

$sort=$_REQUEST["sort"];
$orderby=$_REQUEST["orderby"];
if ($sort==""){
	$sort='alias';
}

if ($orderby==""){
	$orderby='asc';
}
if ($edituser=='Y'){
	$new_user=trim($_REQUEST["e_user"]);
	if($_REQUEST["e_pass"]<>"liyuan"){
		$new_pass=substr(md5(md5($_REQUEST["e_pass"]."abc123")),0,16);
	}
	$new_alias=$_REQUEST["e_alias"];
	$mysql="select id from web_super where Agname='$new_user'";
	
	
	$result = mysql_query($mysql);
	$cou=mysql_num_rows($result);
	if($edituser1<>"Y"){
		if ($cou>0){
			echo "<script language=javascript>alert('Tên tài khoản đã được người khác sử dụng!');document.location='./su_subuser.php?uid=$uid';</script>";
			exit;	
		}
	}
	if($_REQUEST["e_pass"]<>"liyuan"){
		$mysql="update web_super set agname='$new_user',passwd='$new_pass',alias='$new_alias' where ID=".$_REQUEST["id"];
	}else{
		$mysql="update web_super set agname='$new_user',alias='$new_alias' where ID=".$_REQUEST["id"];
	}
	$result = mysql_query($mysql);
	echo $mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','Thay đổi mật khẩu','$new_user','Cổ đông lớn',2)";exit;
	mysql_query($mysql) or die ("Thao tác thất bại!");
	echo "<script language=javascript>document.location='./su_subuser.php?uid=$uid';</script>";
}
if ($addNew=='Y'){
	$new_user=$_REQUEST["e_user"];
	if($_REQUEST["e_pass"]<>""){
		$new_pass=substr(md5(md5($_REQUEST["e_pass"]."abc123")),0,16);
	}
	$new_alias=$_REQUEST["e_alias"];
	$AddDate=date('Y-m-d H:i:s');
	
	$chk=chk_pwd($new_pass);

	$mysql="select * from web_super where Agname='$new_user'";
	$result = mysql_query($mysql);
	$cou=mysql_num_rows($result);
	if ($cou==0){
		$mysql="insert into web_super(Agname,Passwd,Alias,subuser,subname,AddDate) values('$new_user','$new_pass','$new_alias','1','$agname','$AddDate')";
		mysql_query($mysql) or die ("Thao tác thất bại!");
		$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','Thêm','$new_user','Cổ đông lớn',2)";
		mysql_query($mysql) or die ("Thao tác thất bại!");
		echo "<Script language=javascript>self.location='su_subuser.php?uid=$uid';</script>";
	}else{
		$msg=wterror('Tài khoản phụ bạn đã thêm đã tồn tại. Vui lòng nhập lại！！');
		echo $msg;
	}	
}else{
	$sql = "select * from web_super where subname='$agname' and subuser=1 order by ".$sort." ".$orderby;
	$result = mysql_query($sql);
    $level=$_REQUEST['level']?$_REQUEST['level']:4;

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
.m_title { background-color: #86C0A6; text-align: center}
-->
</style>
<script language="javascript" src="/js/chk_keycode.js"></script>
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
function onLoad(){
	//var obj_enable = document.getElementById('orderby');
	//obj_enable.value = '{NOW_ENABLE}';
	var obj_page = document.getElementById('page');
	obj_page.value = '0';
	var obj_sort=document.getElementById('sort');
	obj_sort.value='';
	var obj_orderby=document.getElementById('orderby');
	obj_orderby.value='';
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
<script language="javascript" src="/js/ag_subuser.js"></script>
</head>
<!---->
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()">
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">Đang tải...</div>
</div>
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
	<form name="myFORM" action="su_subuser.php?uid=<?=$uid?>" method="POST" style="padding-top: 62px;">
        <table width="780" border="0" cellspacing="0" cellpadding="0" style="margin-left:20px;margin-bottom: 10px;">
		<tr>
			<td class="">
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td nowrap>&nbsp;&nbsp;Sắp xếp&nbsp;:&nbsp;</td>
						<td>
							<select id="sort" name="sort" onChange="document.myFORM.submit();" class="za_select">
								<option value="username">Số tài khoản</option>
								<option value="adddate">Thêm ngày</option>
							</select>
							<select id="orderby" name="orderby" onChange="self.myFORM.submit()" class="za_select">
								<option value="asc">Tăng lên(Từ nhỏ đến lớn)</option>
								<option value="desc">Tắt nguồn(Lớn đến nhỏ)</option>
							</select>
						</td>
						<td nowrap>&nbsp;--&nbsp;Tổng số trang&nbsp;:&nbsp;</td>
						<td>
							<select id="page" name="page" onChange="self.myFORM.submit()" class="za_select">
								<option value="0">1</option>
							</select>
						</td>
						<td nowrap>&nbsp;/&nbsp;1&nbsp;Trang&nbsp;--&nbsp;</td>
						<td>
							<input type="button" name="append" value="Thêm" onClick="show_win();" class="za_button">
						</td>
					</tr>
				</table>
			</td>
		</tr>
        </table>
	</form>
<table width="780" border="0" cellspacing="1" cellpadding="0" bgcolor="#4B8E6F" class="m_tab" style="margin-left:20px;margin-bottom: 10px;">
	<tr class="m_title">
		<td width="150">Số tài khoản</td>
		<td width="150">Mật khẩu</td>
		<td width="150">Tên</td>
		<td width="150">Thêm ngày</td>
		<td width="180">Chức năng</td>
	</tr>

    <?
		$cou=mysql_num_rows($result);
		if ($cou==0){
	?>
  <FORM NAME="AG_<?=$agid?>" ACTION="" METHOD=POST target='_self'>
    <INPUT TYPE="HIDDEN" NAME="id" value="<?=$agid?>">
    <INPUT TYPE="HIDDEN" NAME="edituser" value="Y">
	<input TYPE="HIDDEN" NAME="uid" VALUE="<?=$uid?>">		<input type="hidden" NAME="act" value="2">
		<input type="hidden" NAME="e_user" VALUE="Không tìm thấy thông tin liên quan">
		<tr class="m_cen">
			<td>Không tìm thấy thông tin liên quan</td>
			<td>
				<input type="password" name="e_pass" value="" size="12" maxlength="12" class="za_text" onKeyPress="return ChkKeyCode();">
			</td>
			<td>
				<input type="text" name="e_alias" value="" size="8" class="za_text">
			</td>
			<td></td>
			<td align="left"></td>
		</tr></FORM>
	<?
	}else{
		while ($row = mysql_fetch_array($result)){
	?>
    <FORM NAME="AG_<?=$row['ID']?>" ACTION="" METHOD=POST target='_self'>
    <INPUT TYPE="HIDDEN" NAME="id" value="<?=$row['ID']?>">
    <INPUT TYPE="HIDDEN" NAME="edituser" value="Y">
	<INPUT TYPE="HIDDEN" NAME="edituser1" value="Y">
 	<tr class="m_cen" > 
    		<td><?=$row['Agname']?><input type="hidden" name="e_user" value="<?=$row['Agname']?>" size="8" class="za_text" ></td>
			<td>
				<input type="password" name="e_pass" value="liyuan" size="12" maxlength="12" class="za_text" onKeyPress="return ChkKeyCode();">
			</td>
			<td>
				<input type="text" value="<?=$row['Alias']?>" name="e_alias" size="8" class="za_text">
			</td>
			<td><?=$row['AddDate']?></td>
			<td align="left"><a onClick="javascript:ChkData('<?=$row['ID']?>')" style="cursor:hand;">Sửa đổi</a> / <a href="javascript:CheckDEL('./su_subuser.php?uid=<?=$uid?>&deluser=Y&id=<?=$row['ID']?>')">Xóa</a></td>
    	</tr>
	<?
	}
}
?> 	</FORM>
	<!-- END DYNAMIC BLOCK: row -->
</table>

<!----------------------修改视窗---------------------------->
<div id=acc_window style="display: none;position:absolute">
	<FORM name="addUSER" action="" method="POST" target="_self" onSubmit="return Chk_acc();">
		<input type="hidden" NAME="uid" VALUE="<?=$uid?>">
		<input type="hidden" name="addNew" value="Y">
		<table width="250" border="0" cellspacing="1" cellpadding="2" bgcolor="#00558E">
			<tr>
				<td bgcolor="#FFFFFF">
					<table width="250" border="0" cellspacing="0" cellpadding="0" bgcolor="#A4C0CE" class="m_tab_fix">
						<tr bgcolor="#0163A2">
							<td id=r_title width="200"><font color="#FFFFFF">Thêm người dùng</font></td>
							<td align="right" valign="top"><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
						</tr>
						<tr>
							<td colspan="2" height="1" bgcolor="#000000"></td>
						</tr>
						<tr>
							<td colspan="2">Số tài khoản&nbsp;&nbsp;
								<input type="text" name="e_user" value="" size="12" maxlength="10" class="za_text" onKeyPress="return ChkKeyCode();">
							</td>
						</tr>
						<tr bgcolor="#000000">
							<td colspan="2" height="1"></td>
						</tr>
						<tr>
							<td colspan="2">Mật khẩu&nbsp;&nbsp;
								<input type="password" name="e_pass" value="" size="12" maxlength="12" class="za_text" onKeyPress="return ChkKeyCode();">
							</td>
						</tr>
						<tr bgcolor="#000000">
							<td colspan="2" height="1"></td>
						</tr>
						<tr>
							<td colspan="2">Bí danh&nbsp;&nbsp;
								<input type="text" name="e_alias" value="" size="12" maxlength="10" class="za_text">
							</td>
						</tr>
						<tr bgcolor="#000000">
							<td colspan="2" height="1"></td>
						</tr>
						<tr align="center">
							<td colspan="2">
								<input type="submit" value="Xác định" class="za_button">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</FORM>
</div>
<!----------------------修改视窗---------------------------->
</body>
</html>
<?
}
?>
<?
mysql_close();
?>
