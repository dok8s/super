<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
require ("../../member/include/traditional.zh-cn.inc.php");

$uid=$_REQUEST["uid"];
$sql = "select * from web_super where Oid='$uid'";

$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$row = mysql_fetch_array($result); //print_r($row );
$agname=$row['Agname'];
$agname1=$row['Agname'];
$agid=$row['ID'];
$credit=$row['Credit'];
$credit_balance = $row['credit_balance'];
$winloss_super=$row['winloss'];
$d1edit=$row['d1edit'];
$d0set = @unserialize($row['setdata']);
$d0set['d1edit'] = $d1edit;

$name_left = substr($agname,0,1);

$keys=$_REQUEST['keys'];
if ($keys=='add'){
	$skey='';
		$svalue='';
		while (list($key, $value) = each($row)) {
	  	if (preg_match("/Scene/i",$key) || preg_match ("/Bet/i",$key) || preg_match ("/Turn/i",$key)){
	  		//if (preg_match("/Scene/i",$key) || preg_match ("/Bet/i",$key)){
				$skey=$skey==''?$key:$skey.','.$key;
				$svalue=$svalue==''?$value:$svalue."','".$value;
			}
		}
		$svalue="'".$svalue."'";
	$AddDate=date('Y-m-d H:i:s');
	$memname=$name_left.$_REQUEST['username'];
	$mempasd=substr(md5(md5($_REQUEST['password']."abc123")),0,16);
	$winloss=$_REQUEST['winloss_c'];
	$winloss_c=100-$_REQUEST['winloss_c'];
	if($memcount==''){$memcount=99999;}
	$memcount=$_REQUEST['maxmember'];
	$chk=chk_pwd($mempasd);

	$maxcredit=$_REQUEST['maxcredit'];
	$edit=intval($_REQUEST['edit']);
	$alias=$_REQUEST['alias'];
	$mysql="select * from web_corprator where Agname='$memname'";
	$result = mysql_query($mysql);
	$count=mysql_num_rows($result);
	if ($count>0){
		echo wterror("您输入的帐号 $memname 已经有人使用了，请回上一页重新输入");
		exit;
	}

	$mysql="select sum(credit) as credit from web_corprator where super='$agname'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$credit2=$row['credit'];

	if ($credit2+$gold>$credit){
		echo wterror("此股东的信用额度为$gold<br>目前公司 最大信用额度为$credit<br>,所属股东累计信用额度为$credit2<br>已超过公司信用额度，请回上一面重新输入");
		exit();
	}

	$setdata = array();
	$setdata['d1_wager_add'] = intval($_POST['d1_wager_add']);
	$setdata['d1_wager_add_deluser'] = intval($_POST['d1_wager_add_deluser']);
	$setdata['d1_wager_add_edit'] = intval($_POST['d1_wager_add_edit']);
	$setdata['d1_wager_hide'] = intval($_POST['d1_wager_hide']);
	$setdata['d1_wager_hide_deluser'] = intval($_POST['d1_wager_hide_deluser']);
	$setdata['d1_wager_hide_edit'] = intval($_POST['d1_wager_hide_edit']);
	$setdata['d1_mem_online_show'] = intval($_POST['d1_mem_online_show']);
	$setdata['d1_ag_online_show'] = intval($_POST['d1_ag_online_show']);
	$setdata['d1_mem_online_show'] = intval($_POST['d1_mem_online_show']);
	$setdata['d1_mem_online_aglog'] = intval($_POST['d1_mem_online_aglog']);
	$setdata['d1_mem_online_domain'] = intval($_POST['d1_mem_online_domain']);
	$setdata['d1_edit_list_re'] = intval($_POST['d1_edit_list_re']);
	$setdata['d1_edit_list_edit'] = intval($_POST['d1_edit_list_edit']);
	$setdata['d1_edit_list_del'] = intval($_POST['d1_edit_list_del']);
	$setdata['d1_edit_list_hide'] = intval($_POST['d1_edit_list_hide']);
	$setdata['d1_edit'] = intval($_POST['d1_edit']);

	$mysql="insert into web_corprator(Agname,Passwd,Credit,edit,Alias,super,AddDate,winloss,winloss_parents,setdata,$skey) values ('$memname','$mempasd','$maxcredit','$edit','$alias','$agname','$AddDate','$winloss_c','$winloss','".serialize($setdata)."',$svalue)";

	mysql_query($mysql) or die ("error!");
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname1','新增','$memname','股东',2)";
	mysql_query($mysql) or die ("操作失败!");
	echo "<script languag='JavaScript'>self.location='super_corprator.php?uid=$uid'</script>";

}
else{
$d1set = array();
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_suag_ed {  background-color: #BACBC1; text-align: right}
-->
</style>
<SCRIPT>
<!--

function SubChk(){
	if(document.all.username.value=='')
		{ document.all.username.focus(); alert("<?=$mem_alert3?>"); return false; }
	if(document.all.password.value=='')
		{ document.all.password.focus(); alert("<?=$mem_alert5?>"); return false; }
	if(document.all.repassword.value=='')
	{ document.all.repassword.focus(); alert("<?=$mem_alert6?>"); return false; }
	if(document.all.password.value != document.all.repassword.value)
		{ document.all.password.focus(); alert("<?=$mem_alert7?>"); return false; }
	if(document.all.alias.value=='')
		{ document.all.alias.focus(); alert("<?=$mem_alert8?>"); return false; }
	if(document.all.maxcredit.value=='0' || document.all.maxcredit.value=='')
 		{ document.all.maxcredit.focus(); alert("<?=$mem_alert9?>"); return false; }
	if(!confirm("<?=$mem_alert10?>")){return false;}
	//document.all.username.value = document.all.ag_count.innerHTML;
	if (document.all.keys.value == 'add' && document.all.new_ratio.value != 1 ){
	 	alert('<?=$mem_alert11?>');
	}

}
function show_count(w,s) {
	//alert(w+' - '+s);
	var org_str=document.all.username.value;//org_str.substr(1,5)
	if (s!=''){
		switch(w){
			case 0:	document.all.username.value = s.substr(0,3);break;
			case 1:document.all.username.value = org_str.substr(0,3)+s+org_str.substr(4,3);break;
			case 2:document.all.username.value = org_str.substr(0,4)+s+org_str.substr(5,2);break;
			case 3:document.all.username.value = org_str.substr(0,5)+s+org_str.substr(6,1);break;
			case 4:document.all.username.value= org_str.substr(0,6)+s;break;
		}
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

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<FORM NAME="myFORM" ACTION="super_corprator_add.php" METHOD=POST onSubmit="return SubChk()">
 <INPUT TYPE=HIDDEN NAME="id" VALUE="<?=$agid?>">
 <INPUT TYPE=HIDDEN NAME="adddate" VALUE="">
  <INPUT TYPE=HIDDEN NAME="keys" VALUE="add">
  <INPUT TYPE=HIDDEN NAME="enable" VALUE="Y">
  <input TYPE=HIDDEN NAME="s_type" VALUE="">
  <input TYPE=HIDDEN NAME="uid" VALUE="<?=$uid?>">
<INPUT TYPE=HIDDEN NAME="keys" VALUE="add">
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

<input type="HIDDEN" value="" name="type">
  <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">
        <?=$sub_user?>:</td>
      <td><?=$name_left?><input name="username" type=text class="za_text" id="username" value="" size=12 maxlength=8>
      </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_suag_ed"><?=$sub_pass?>:</td>
    <td>
      <input type=PASSWORD name="password" value="" size=12 maxlength=12 class="za_text">
    密码必须至少6个字元长，最多12个字元长，并只能有数字(0-9)，及英文大小写字母 </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_suag_ed"><?=$acc_repasd?>:</td>
    <td>
      <input type=PASSWORD name="repassword" value="" size=12 maxlength=12 class="za_text">
    </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_suag_ed"><?=$rcl_corp?><?=$sub_name?>:</td>
    <td>
      <input type=TEXT name="alias" value="" size=12 maxlength=12 class="za_text">
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
	  <td class='m_suag_ed' width='120'>添单账号:</td>
		<td>
			<select class='za_select' name='d1_wager_add'>
				<option value='0' $selected[0]>禁用</option>
				<option value='1' $selected[1]>启用</option>
			</select>";
	if($d0set['d1_wager_add_deluser']==1)echo "
			&nbsp;&nbsp;<input type='checkbox' name='d1_wager_add_deluser' value='1' $deluser_checked>帐号删除";
	if($d0set['d1_wager_add_edit']==1)echo "
			&nbsp;&nbsp;<input type='checkbox' name='d1_wager_add_edit' value='1' $edit_checked>详细投注";
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
	  <td class='m_suag_ed' width='120'>隐单账号:</td>
		<td>
			<select class='za_select' name='d1_wager_hide'>
				<option value='0' $selected[0]>禁用</option>
				<option value='1' $selected[1]>启用</option>
			</select>";
	if($d0set['d1_wager_hide_deluser']==1)echo "
			&nbsp;&nbsp;<input type='checkbox' name='d1_wager_hide_deluser' value='1' $deluser_checked>帐号删除";
	if($d0set['d1_wager_hide_edit']==1)echo "
			&nbsp;&nbsp;<input type='checkbox' name='d1_wager_hide_edit' value='1' $edit_checked>详细投注";
	echo "
		</td>
	</tr>";
}

if($d0set['d1_ag_online_show']==1){
	$selected = $d1set['d1_ag_online_show']==1 ? array('','selected') : array('selected','');
	echo "
	<tr class='m_bc_ed'>
	  <td class='m_suag_ed' width='120'>代理在线:</td>
		<td>
			<select class='za_select' name='d1_ag_online_show'>
				<option value='0' $selected[0]>禁用</option>
				<option value='1' $selected[1]>启用</option>
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
	  <td class='m_suag_ed' width='120'>会员在线:</td>
		<td>
			<select class='za_select' name='d1_mem_online_show'>
				<option value='0' $selected[0]>禁用</option>
				<option value='1' $selected[1]>启用</option>
			</select>";
	if($d0set['d1_mem_online_aglog']==1){
		echo "&nbsp;&nbsp;<input type='checkbox' name='d1_mem_online_aglog' value='1' $checked1>代理历史记录";
	}
	if($d0set['d1_mem_online_domain']==1){
		echo "&nbsp;&nbsp;<input type='checkbox' name='d1_mem_online_domain' value='1' $checked2>网址";
	}
	if($d0set['d1edit']==1){
		echo "&nbsp;&nbsp;<input type='checkbox' name='d1_edit' value='1' $checked3>投注";
	}
	echo "
		</td>
	</tr>";
}


if($d0set['d1_edit_list_re']==1 || $d0set['d1_edit_list_edit']==1 || $d0set['d1_edit_list_del']==1 ||$d0set['d1_edit_list_hide']==1){
	echo "
    <tr class='m_bc_ed'>
      <td class='m_suag_ed' width='120'>改单列表:</td>
		<td>";

		$checked1 = $d1set['d1_edit_list_re']==1 ? 'checked' : '';
		$checked2 = $d1set['d1_edit_list_edit']==1 ? 'checked' : '';
		$checked3 = $d1set['d1_edit_list_del']==1 ? 'checked' : '';
		$checked4 = $d1set['d1_edit_list_hide']==1 ? 'checked' : '';
		if($d0set['d1_edit_list_re']==1)echo "&nbsp;&nbsp;<input type='checkbox' name='d1_edit_list_re' value='1' $checked1>对调";
		if($d0set['d1_edit_list_edit']==1)echo "&nbsp;&nbsp;<input type='checkbox' name='d1_edit_list_edit' value='1' $checked2>修改";
		if($d0set['d1_edit_list_del']==1)echo "&nbsp;&nbsp;<input type='checkbox' name='d1_edit_list_del' value='1' $checked3>删除";
		if($d0set['d1_edit_list_hide']==1)echo "&nbsp;&nbsp;<input type='checkbox' name='d1_edit_list_hide' value='1' $checked4>隐藏";

	echo "
		</td>
    </tr>";
}
?>


    <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120"><?=$mem_maxcredit?>:</td>
      <td>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input type=TEXT name="maxcredit" value="0" size=10 maxlength=10 class="za_text"></td>
		<td>使用状况／启用:0　停用:0　暂停:0　可用:0
		<? if($credit_balance==1){
		$mysql="select sum(credit) as credit_used from web_corprator where super='$agname'";
		$result = mysql_query($mysql);
		$row = mysql_fetch_array($result);
		$credit_used = intval($row['credit_used']);
		$credit_canuse = $credit-$credit_used;
			echo "<BR><font color=#FF0000> $agname </font>的信用馀额提示／总额:$credit 已用:$credit_used  可用:$credit_canuse"; 
			}
		?>
		</td>
	</tr>
</table>

      </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">股东佔成数:</td>
      <td>
        <select name="winloss_c" class="za_select">
	<?
	$winloss=80;
	for($i=$winloss_super;$i>=50;$i=$i-5){
		if($i==$winloss){
		echo "<option value=".(100-$i)." selected>".($i/10).$wor_percent."</option>\n";
	}else{
		echo "<option value=".(100-$i).">".($i/10).$wor_percent."</option>\n";

		}
	}
	?>      </select>
      </td>
    </tr>
    <!--tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">会员数:</td>
      <td>
        <input type=TEXT name="maxmember" value="" size=10 maxlength=10 class="za_text">
         </td>
    </tr-->
    <!--tr class="m_bc_ed">
      <td class="m_suag_ed" width="120">佔成数:</td>
      <td>
        <select name="winloss_c" class="za_select">
	<?
	$winloss=100;
	for($i=$winloss;$i>=0;$i=$i-5){
		echo "<option value=".(100-$i).">".($i/10).$wor_percent."</option>\n";
	}
	?>      </select>
      </td>
    </tr-->
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
mysql_close();
?>
