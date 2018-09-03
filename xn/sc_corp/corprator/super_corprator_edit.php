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
$mid=intval($_REQUEST["id"]);
$sql = "select Agname,ID,language,credit,d1edit,credit_balance,winloss,setdata from web_super where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$row = mysql_fetch_array($result);
$langx=$row['language'];
$d1edit=$row['d1edit'];
$credit=$row['credit'];
$credit_balance = $row['credit_balance'];
$winloss_super=$row['winloss'];
$agname=$row['Agname'];
$d0set = @unserialize($row['setdata']);
$d0set['d1edit'] = $d1edit;

require ("../../member/include/traditional.zh-vn.inc.php");

$setrow = mysql_fetch_array(mysql_query("select setdata from web_system limit 0,1"));
$setdata = @unserialize($setrow['setdata']);
$resetwinloss=intval($setdata['resetwinloss']);

$keys=$_REQUEST['keys'];
if ($keys=='upd'){
	$AddDate=date('Y-m-d H:i:s');
	$memname=$_REQUEST['username'];
	if($_REQUEST['password']<>"admin111"){
		$mempasd=substr(md5(md5($_REQUEST['password']."abc123")),0,16);
		$chk=chk_pwd($mempasd);
	}
	$enddate = strtotime($_REQUEST['enddate']);
	$enddate = $enddate>strtotime('2008-08-08') ? date('Y-m-d H:i:s', $enddate) : '';
	$gold=$_REQUEST['maxcredit'];
	$edit = intval($_REQUEST['edit']);
	$alias=$_REQUEST['alias'];
	$winloss = intval($_REQUEST['winloss_c']);
	$winloss_parents=100-$winloss;
	

	//判断额度是否超过限制
	$mysql="select credit,setdata,Agname from web_corprator where id='$mid'";

	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$credit1=$row['credit'];
	$memname=$row['Agname'];
	$setdata = @unserialize($row['setdata']);
	$setdata['d1_wager_add'] = intval($_POST['d1_wager_add']);
	$setdata['d1_wager_add_deluser'] = intval($_POST['d1_wager_add_deluser']);
	$setdata['d1_wager_add_edit'] = intval($_POST['d1_wager_add_edit']);
	$setdata['d1_wager_hide'] = intval($_POST['d1_wager_hide']);
	$setdata['d1_wager_hide_deluser'] = intval($_POST['d1_wager_hide_deluser']);
	$setdata['d1_wager_hide_edit'] = intval($_POST['d1_wager_hide_edit']);
	$setdata['d1_ag_online_show'] = intval($_POST['d1_ag_online_show']);
	$setdata['d1_mem_online_show'] = intval($_POST['d1_mem_online_show']);
	$setdata['d1_mem_online_aglog'] = intval($_POST['d1_mem_online_aglog']);
	$setdata['d1_mem_online_domain'] = intval($_POST['d1_mem_online_domain']);
	$setdata['d1_edit_list_re'] = intval($_POST['d1_edit_list_re']);
	$setdata['d1_edit_list_edit'] = intval($_POST['d1_edit_list_edit']);
	$setdata['d1_edit_list_del'] = intval($_POST['d1_edit_list_del']);
	$setdata['d1_edit_list_hide'] = intval($_POST['d1_edit_list_hide']);
	$setdata['d1_edit'] = intval($_POST['d1_edit']);

	$mysql="select sum(credit) as credit from web_corprator where super='".$agname."'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$credit2=$row['credit']-$credit1;

	if ($credit2+$gold>$credit){
		echo wterror("Hạn mức tín dụng của cổ đông này là$gold<br>Giới hạn tín dụng tối đa hiện tại của công ty là$credit<br>,Hạn mức tín dụng tích lũy của cổ đông là$credit2<br>Đã vượt quá giới hạn tín dụng của công ty, vui lòng quay lại và nhập lại");
		exit();
	}
	if($_REQUEST['password']<>"admin111"){
		$mysql="update web_corprator set passwd='$mempasd',Credit='$gold',edit='$edit',Alias='$alias',enddate='$enddate', setdata='".serialize($setdata)."' where id='$mid'";
	}else{
		$mysql="update web_corprator set Credit='$gold',edit='$edit',Alias='$alias',enddate='$enddate', setdata='".serialize($setdata)."' where id='$mid'";
	}
	mysql_query($mysql) or exit("error 8838");
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','Thay đổi mật khẩu','$memname','Cổ đôngCổ đông',2)";
	mysql_query($mysql) or die ("Thao tác thất bại!");
	if($setdata['resetwinloss']==1){
		if($winloss>$winloss_super || $winloss<0){
			echo wterror("Cổ phần của cổ đông này".($winloss/10)."<br>Số lượng công ty hiện tại là".($winloss_super/10)."<br>,Chia sẻ được phân bổ đã vượt quá tỷ lệ chia sẻ của công ty, vui lòng quay lại và nhập lại");
			exit();
		}
		$mysql="update web_corprator set winloss='$winloss',winloss_parents='$winloss_parents' where id='$mid'";
		mysql_query($mysql) or exit("error 8839");
	}
	echo "<script languag='JavaScript'>self.location='super_corprator.php?uid=$uid'</script>";
	exit;
}else{
	$sql = "select *, date_format(enddate,'%Y-%m-%d %H:%i:%s') as enddate from web_corprator where ID='$mid'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$winloss=$row['winloss'];
	$winloss_parents=$row['winloss_parents'];
	$enddate = $row['enddate']=='0000-00-00 00:00:00' ? '0' : $row['enddate'];
	$d1set = @unserialize($row['setdata']);
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_suag_ed {  background-color: #D3C9CB; text-align: right}
-->
</style>
<SCRIPT>
<!--
function SubChk()
{
// if(document.all.username.value=='')
// { document.all.username.focus(); alert("<?=$mem_alert1?>"); return false; }
 /*if(document.all.password.value=='' )
 { document.all.password.focus(); alert("<?=$mem_alert5?>"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("<?=$mem_alert6?>"); return false; }*/
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("<?=$mem_alert7?>"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("Vui lòng tham khảo tên đại lý chung.!!"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("Vui lòng tham khảo giới hạn tín dụng đại lý chung.!!"); return false; }
// if(document.all.winloss_s.value=='')
// { document.all.winloss_s.focus(); alert("请选择总代理商佔成数!!"); return false; }
// if (eval(document.all.winloss_c.value) > eval(document.all.winloss_s.value))
// { document.all.winloss_s.focus(); alert("总代理商佔成数超过股东佔成数!!"); return false; }
 if(!confirm("Bạn có chắc chắn để viết??"))
 {
  return false;
 }
}


 function onLoad()
 {
  var obj_type_id = document.getElementById('type');
  obj_type_id.value = '';
 }
// -->
</SCRIPT>
</head>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()">
<FORM NAME="myFORM" ACTION="super_corprator_edit.php" METHOD=POST onSubmit="return SubChk()">
 <INPUT TYPE=HIDDEN NAME="id" VALUE="<?=$mid?>">
 <INPUT TYPE=HIDDEN NAME="adddate" VALUE="">
  <INPUT TYPE=HIDDEN NAME="keys" VALUE="upd">
  <INPUT TYPE=HIDDEN NAME="enable" VALUE="Y">
  <input TYPE=HIDDEN NAME="s_type" VALUE="">
  <input TYPE=HIDDEN NAME="uid" VALUE="<?=$uid?>">
  <input TYPE=HIDDEN NAME="winloss_c" VALUE="10">
  <table width="780" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td class="m_tline">&nbsp;&nbsp;<?=$cor_manage?>--<?=$mem_addnewuser?></td>

      <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
</tr>
<tr>
<td colspan="2" height="4"></td>
</tr>
</table>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td colspan="2" ><?=$mem_accset?></td>
  </tr>
<!--
  <tr class="m_bc_ed">
    <td width="120" class="m_suag_ed">身份:</td>
    <td>
      <select name="type" class="za_select">
        <option value="1">股东</option>
        <option value="2">总代理 ／半退</option>
        <option value="3">总代理 ／全退</option>
        <option value="8">外调</option>
      </select>
    </td>
  </tr>
-->
<input type="HIDDEN" value="" name="type">
  <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120"> <?=$sub_user?>:</td>
    <td><?=$row['Agname']?></td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_suag_ed"><?=$sub_pass?>:</td>
    <td>
      <input type=PASSWORD name="password" value="admin111" size=12 maxlength=12 class="za_text">
        Mật khẩu phải dài ít nhất 6 ký tự, dài tối đa 12 ký tự và chỉ có thể có số (0-9) và chữ hoa và chữ thường tiếng Anh. </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_suag_ed"><?=$acc_repasd?>:</td>
    <td>
      <input type=PASSWORD name="repassword" value="admin111" size=12 maxlength=12 class="za_text">
    </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_suag_ed"><?=$rcl_corp?><?=$sub_name?>:</td>
    <td>
      <input type=TEXT name="alias" value="<?=$row['Alias']?>" size=10 maxlength=10 class="za_text">
    </td>
  </tr>
</table>

  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit">
      <td colspan="2" ><?=$mem_betset?></td>
    </tr>

<?
if($d0set['d1_wager_add']==1){
	$selected = $d1set['d1_wager_add']==1 ? array('','selected') : array('selected','');
	$deluser_checked = $d1set['d1_wager_add_deluser']==1 ? 'checked' : '';
	$edit_checked = $d1set['d1_wager_add_edit']==1 ? 'checked' : '';
	echo "
	<tr class='m_bc_ed'>
	  <td class='m_suag_ed' width='120'>Thêm tài khoản:</td>
		<td>
			<select class='za_select' name='d1_wager_add'>
				<option value='0' $selected[0]>Tắt</option>
				<option value='1' $selected[1]>Bật</option>
			</select>";
	if($d0set['d1_wager_add_deluser']==1)echo "
			&nbsp;&nbsp;<input type='checkbox' name='d1_wager_add_deluser' value='1' $deluser_checked>Xóa tài khoản";
	if($d0set['d1_wager_add_edit']==1)echo "
			&nbsp;&nbsp;<input type='checkbox' name='d1_wager_add_edit' value='1' $edit_checked>Chi tiết cá cược";
	echo "
		</td>
	</tr>";
}

if($d0set['d1_wager_hide']==1){
	$selected = $d1set['d1_wager_hide']==1 ? array('','selected') : array('selected','');
	$deluser_checked = $d1set['d1_wager_hide_deluser']==1 ? 'checked' : '';
	$edit_checked = $d1set['d1_wager_hide_edit']==1 ? 'checked' : '';
	echo "
	<tr class='m_bc_ed'>
	  <td class='m_suag_ed' width='120'>Tài khoản ẩn:</td>
		<td>
			<select class='za_select' name='d1_wager_hide'>
				<option value='0' $selected[0]>Tắt</option>
				<option value='1' $selected[1]>Bật</option>
			</select>";
	if($d0set['d1_wager_hide_deluser']==1)echo "
			&nbsp;&nbsp;<input type='checkbox' name='d1_wager_hide_deluser' value='1' $deluser_checked>Xóa tài khoản";
	if($d0set['d1_wager_hide_edit']==1)echo "
			&nbsp;&nbsp;<input type='checkbox' name='d1_wager_hide_edit' value='1' $edit_checked>Chi tiết cá cược";
	echo "
		</td>
	</tr>";
}
if($d0set['d1_ag_online_show']==1){
	$selected = $d1set['d1_ag_online_show']==1 ? array('','selected') : array('selected','');
	echo "
	<tr class='m_bc_ed'>
	  <td class='m_suag_ed' width='120'>Đại lý trực tuyến:</td>
		<td>
			<select class='za_select' name='d1_ag_online_show'>
				<option value='0' $selected[0]>Tắt</option>
				<option value='1' $selected[1]>Bật</option>
			</select>";
	echo "
		</td>
	</tr>";
}

if($d0set['d1_mem_online_show']==1){
	$selected = $d1set['d1_mem_online_show']==1 ? array('','selected') : array('selected','');
	$checked1 = $d1set['d1_mem_online_aglog']==1 ? 'checked' : '';
	$checked2 = $d1set['d1_mem_online_domain']==1 ? 'checked' : '';
	$checked3 = $d1set['d1_edit']==1 ? 'checked' : '';
	echo "
	<tr class='m_bc_ed'>
	  <td class='m_suag_ed' width='120'>Thành viên trực tuyến:</td>
		<td>
			<select class='za_select' name='d1_mem_online_show'>
				<option value='0' $selected[0]>Tắt</option>
				<option value='1' $selected[1]>Bật</option>
			</select>";
	if($d0set['d1_mem_online_aglog']==1){
		echo "&nbsp;&nbsp;<input type='checkbox' name='d1_mem_online_aglog' value='1' $checked1>Lịch sử tác nhân";
	}
	if($d0set['d1_mem_online_domain']==1){
		echo "&nbsp;&nbsp;<input type='checkbox' name='d1_mem_online_domain' value='1' $checked2>URL";
	}
	if($d0set['d1edit']==1){
		echo "&nbsp;&nbsp;<input type='checkbox' name='d1_edit' value='1' $checked3>Cá cược";
	}
	echo "
		</td>
	</tr>";
}


if($d0set['d1_edit_list_re']==1 || $d0set['d1_edit_list_edit']==1 || $d0set['d1_edit_list_del']==1 ||$d0set['d1_edit_list_hide']==1){
	echo "
    <tr class='m_bc_ed'>
      <td class='m_suag_ed' width='120'>Thay đổi danh sách:</td>
		<td>";

		$checked1 = $d1set['d1_edit_list_re']==1 ? 'checked' : '';
		$checked2 = $d1set['d1_edit_list_edit']==1 ? 'checked' : '';
		$checked3 = $d1set['d1_edit_list_del']==1 ? 'checked' : '';
		$checked4 = $d1set['d1_edit_list_hide']==1 ? 'checked' : '';
		if($d0set['d1_edit_list_re']==1)echo "&nbsp;&nbsp;<input type='checkbox' name='d1_edit_list_re' value='1' $checked1>Căn chỉnh";
		if($d0set['d1_edit_list_edit']==1)echo "&nbsp;&nbsp;<input type='checkbox' name='d1_edit_list_edit' value='1' $checked2>Sửa đổi";
		if($d0set['d1_edit_list_del']==1)echo "&nbsp;&nbsp;<input type='checkbox' name='d1_edit_list_del' value='1' $checked3>Xóa";
		if($d0set['d1_edit_list_hide']==1)echo "&nbsp;&nbsp;<input type='checkbox' name='d1_edit_list_hide' value='1' $checked4>Ẩn";

	echo "
		</td>
    </tr>";
}
?>
    <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">Thời gian hết hạn:</td>
		<td>
			<input type=TEXT name="enddate" value="<?=$enddate?>" size=20 class="za_text">
            Ví dụ：2010-12-30 Hoặc 2010-12-30 23:59:59 。Lưu ý: 0 không bao giờ hết hạn。
		</td>
    </tr>

    <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120"><?=$mem_maxcredit?>:</td>
      <td>
        <?
$sql="select sum(credit) as credit from web_world where corprator='$row[Agname]' and status=1";
$sresult = mysql_query($sql);
$srow = mysql_fetch_array($sresult);

$sql="select sum(credit) as credit from web_world where corprator='$row[Agname]' and status=0";
$eresult = mysql_query($sql);
$erow = mysql_fetch_array($eresult);

$sql="select sum(credit) as credit from web_world where corprator='$row[Agname]' and status=2";
$kresult = mysql_query($sql);
$krow = mysql_fetch_array($kresult);

?>
        
       
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input type=TEXT name="maxcredit" value="<?=$row['Credit']?>" size=10 maxlength=10 class="za_text"></td>
		<td>Sử dụng / bật:<?=$srow['credit']+0?>　Tắt:<?=$erow['credit']+0?>　Tạm ngưng:<?=$krow['credit']+0?>  Có sẵn:<?=($row['Credit']-$erow['credit']-$srow['credit']-$krow['credit'])+0?>
		<? if($credit_balance==1){
		$mysql="select sum(credit) as credit_used from web_corprator where super='$agname'";
		$result = mysql_query($mysql);
		$row = mysql_fetch_array($result);
		$credit_used = intval($row['credit_used']);
		$credit_canuse = $credit-$credit_used;
			echo "<BR><font color=#FF0000> $agname </font>Hạn mức tín dụng／Tổng số:$credit Đã sử dụng:$credit_used  Có sẵn:$credit_canuse";
			}
		?>
		</td>
	</tr>
</table>
      </td>    </tr>
	<tr class=m_bc_ed>
    <td class=m_suag_ed><?=$rcl_corp?>Nghề nghiệp:</td>
    <td>
	<?
	if($resetwinloss==1){
		echo "<select name='winloss_c' class='za_select'>";	
		//$winloss=80;
		for($i=$winloss_super;$i>=50;$i=$i-5){
			$selected = $i==$winloss ? 'selected' : '';
			echo "<option value='$i' $selected>".($i/10).$wor_percent."</option>\n";
		}
		echo "</select>";
	}
	else{
		echo ($winloss_super/10).$wor_percent;
	}
	?>
	
    </TD></TR>
    <tr class="m_bc_ed" align="center">
      <td colspan="2">
        <input type=SUBMIT name="OK" value="<?=$submit_ok?>" class="za_button">
        &nbsp; &nbsp; &nbsp;
        <input type=BUTTON name="FormsButton2" value="<?=$submit_cancle?>" id="FormsButton2" onClick="javascript:history.go(-1)" class="za_button">
      </td>
    </tr>
  </table>

</form>
</body>
</html>

<?
}
?>