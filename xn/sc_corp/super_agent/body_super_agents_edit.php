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
$mid=$_REQUEST["id"];
$sql = "select Agname,ID,language,credit_balance from web_super where Oid='$uid'";

$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$row = mysql_fetch_array($result);
$credit_balance = $row['credit_balance'];
$agname = $row['Agname'];
$agname1 = $row['Agname'];
$langx='zh-vn';
require ("../../member/include/traditional.$langx.inc.php");

$setrow = mysql_fetch_array(mysql_query("select setdata from web_system limit 0,1"));
$setdata = @unserialize($setrow['setdata']);
$setdata['resetwinloss']=intval($setdata['resetwinloss']);

$keys=$_REQUEST['keys'];
if ($keys=='upd'){
	$AddDate=date('Y-m-d H:i:s');
	$memname=$_REQUEST['username'];
	if($_REQUEST['password']<>"admin111"){
		$mempasd=substr(md5(md5($_REQUEST['password']."abc123")),0,16);
		$chk=chk_pwd($mempasd);
	}
	$maxcredit=$_REQUEST['maxcredit'];
	$alias=$_REQUEST['alias'];
	$memcount=$_REQUEST['maxmember'];
	$enddate = strtotime($_REQUEST['enddate']);
	$enddate = $enddate>strtotime('2008-08-08') ? date('Y-m-d H:i:s', $enddate) : '';

	$mysql="select credit,corprator,Agname from web_world where id=$mid";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$credit1=$row['credit'];
	$agname=$row['corprator'];
	$memname1=$row['Agname'];


	$mysql="select credit,winloss from web_corprator where agname='$agname'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$credit=$row['credit'];
	$winloss_max = intval($row['winloss']);

	$mysql="select sum(credit) as credit from web_world where corprator='$agname'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$credit2=$row['credit']-$credit1;

	if ($credit2+$maxcredit>$credit){
		echo wterror("Tổng hạn mức tín dụng của đại lý là$maxcredit<br>Giới hạn tín dụng tối đa của cổ đông hiện tại là$credit<br>,Tổng hạn mức tín dụng của tổng đại lý là$credit2<br>Đã vượt quá giới hạn tín dụng đại lý, vui lòng quay lại và nhập lại");
		exit();
	}else{
		if($_REQUEST['password']<>"admin111"){
			$mysql="update web_world set mcount='$memcount',passwd='$mempasd',Credit='$maxcredit',Alias='$alias',enddate='$enddate' where id='$mid'";
		}else{
			$mysql="update web_world set mcount='$memcount',Credit='$maxcredit',Alias='$alias',enddate='$enddate' where id='$mid'";
		}
		mysql_query($mysql) or die ("error 7738");
		$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname1','Thay đổi mật khẩu','$memname1','Đại lý tổng hợp',2)";
		mysql_query($mysql) or die ("Thao tác thất bại!");
	}
	if($setdata['resetwinloss']==1){
		$maxwinloss=intval($_REQUEST['maxwinloss']);
		$minwinloss=intval($_REQUEST['minwinloss']);
		if($maxwinloss>$winloss_max || $maxwinloss<0){
			echo wterror("Tổng số mũ của đại lý chung này".($maxwinloss/10)."<br>Cổ phần hiện tại của cổ đông là".($winloss_max/10)."<br>,Cổ phần được phân bổ đã vượt quá tỷ lệ cổ đông, vui lòng quay lại và nhập lại");
			exit();
		}
		if($minwinloss>$maxwinloss || $minwinloss<0){
			echo wterror("Giới hạn dưới của tổng số đại lý($minwinloss)Nếu bạn có bất kỳ vấn đề gì, vui lòng quay lại và nhập lại");
			exit();
		}
		$mysql="update web_world set winloss_parents='$maxwinloss',winloss='$minwinloss' where id='$mid'";
		mysql_query($mysql) or exit("error 7739");
	}
	echo "<script languag='JavaScript'>self.location='body_super_agents.php?uid=$uid'</script>";
	exit();
}else{
	$sql = "select *, date_format(enddate,'%Y-%m-%d %H:%i:%s') as enddate from web_world where ID='$mid'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$corprator=$row['corprator'];
	$maxwinloss=$row['winloss_parents'];
	$minwinloss=$row['winloss'];
	$enddate = $row['enddate']=='0000-00-00 00:00:00' ? '0' : $row['enddate'];

	$sql = "select winloss,credit from web_corprator where agname='$corprator'";
	$result1 = mysql_query($sql);
	$row1 = mysql_fetch_array($result1);
	$winloss=$row1['winloss'];
	$credit=$row1['credit'];

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
/* if(document.all.password.value=='' )
 { document.all.password.focus(); alert("<?=$mem_alert5?>"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("<?=$mem_alert6?>"); return false; }*/
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("<?=$mem_alert7?>"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("Vui lòng tham khảo tên đại lý chung.!"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("Vui lòng tham khảo giới hạn tín dụng đại lý chung.!"); return false; }
// if(document.all.winloss_s.value=='')
// { document.all.winloss_s.focus(); alert("请选择总代理商佔成数!!"); return false; }
// if (eval(document.all.winloss_c.value) > eval(document.all.winloss_s.value))
// { document.all.winloss_s.focus(); alert("总代理商佔成数超过股东佔成数!!"); return false; }
 if(!confirm("Bạn có chắc chắn viết thư cho đại lý chung không?"))
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
<FORM NAME="myFORM" ACTION="body_super_agents_edit.php" METHOD=POST onSubmit="return SubChk()">
 <INPUT TYPE=HIDDEN NAME="id" VALUE="<?=$mid?>">
 <INPUT TYPE=HIDDEN NAME="adddate" VALUE="">
  <INPUT TYPE=HIDDEN NAME="keys" VALUE="upd">
  <INPUT TYPE=HIDDEN NAME="enable" VALUE="Y">
  <input TYPE=HIDDEN NAME="s_type" VALUE="">
  <input TYPE=HIDDEN NAME="uid" VALUE="<?=$uid?>">
  <input TYPE=HIDDEN NAME="winloss_c" VALUE="10">
  <table width="780" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td class="m_tline">&nbsp;&nbsp;<?=$cor_agents?>--<?=$mem_addnewuser?></td>

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
    <td>
      <?=$row['Agname']?>
    </td>
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
    <td class="m_suag_ed"><?=$cor_name1?>:</td>
    <td>
      <input type=TEXT name="alias" value="<?=$row['Alias']?>" size=10 maxlength=10 class="za_text">
    </td>
  </tr>
</table>

  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit">
      <td colspan="2" ><?=$mem_betset?></td>
    </tr>

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
$sql="select sum(credit) as credit from web_agents where world='$row[Agname]' and status=1";
$sresult = mysql_query($sql);
$srow = mysql_fetch_array($sresult);

$sql="select sum(credit) as credit from web_agents where world='$row[Agname]' and status=0";
$eresult = mysql_query($sql);
$erow = mysql_fetch_array($eresult);

$sql="select sum(credit) as credit from web_agents where world='$row[Agname]' and status=2";
$kresult = mysql_query($sql);
$krow = mysql_fetch_array($kresult);

?>
       
       
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td> <input type=TEXT name="maxcredit" value="<?=$row['Credit']?>" size=10 maxlength=10 class="za_text"></td>
		<td>Sử dụng / bật:<?=$srow['credit']+0?>　Tắt:<?=$erow['credit']+0?>　Tạm ngưng:<?=$krow['credit']+0?>  Có sẵn:<?=($row['Credit']-$erow['credit']-$srow['credit']-$krow['credit'])+0?>
		<? if($credit_balance==1){
		$mysql="select sum(credit) as credit_used from web_world where corprator='$corprator'";
		$result = mysql_query($mysql);
		$rt = mysql_fetch_array($result);
		$credit_used = intval($rt['credit_used']-$row['Credit']);
		$credit_canuse = $credit-$credit_used;
			echo "<BR><font color=#FF0000> $corprator </font>Giới hạn / lời nhắc giới hạn tín dụng:$credit Đã sử dụng:$credit_used  Có sẵn:$credit_canuse";
			}
		?>
		</td>
	</tr>
</table>

      </td>    </tr>
	<tr class=m_bc_ed>
    <td class=m_suag_ed>Tổng nắp đại lý:</td>
    <td>
	<?
	if($setdata['resetwinloss']==1){
		echo "<select class='za_select' name='maxwinloss'>";	
		for($i=$winloss;$i>=0;$i=$i-5){
			$selected = $i==$maxwinloss ? 'selected' : '';
			echo "<option value='$i' $selected>".($i/10).$wor_percent."</option>\n";
		}
		echo "</select>";
	}
	else{
		echo ($maxwinloss/10).$wor_percent;
	}
	?>
    </TD></TR>
	<tr class=m_bc_ed>
    <td class=m_suag_ed>Tổng đại lý:</td>
    <td>
	<?
	if($setdata['resetwinloss']==1){
		echo "<select class='za_select' name='minwinloss'>";	
		for($i=$winloss;$i>=0;$i=$i-5){
			$selected = $i==$minwinloss ? 'selected' : '';
			echo "<option value='$i' $selected>".($i/10).$wor_percent."</option>\n";
		}
		echo "</select>";
	}
	else{
		echo ($minwinloss/10).$wor_percent;
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
