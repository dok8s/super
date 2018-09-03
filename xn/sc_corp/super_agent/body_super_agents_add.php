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
$corprator=$_REQUEST["corprator"];

if($corprator<>''){
	$sql = "select winloss,winloss_parents,credit from web_corprator where agname='$corprator'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$winloss=$row['winloss'];
	$winloss_parents=$row['winloss_parents'];
	$credit=$row['credit'];
}else{
	$winloss=0;
}
$credit=intval($credit);
$name_left = substr($corprator,0,2);

$sql = "select agname,ID,language,credit,credit_balance from web_super where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$agname=$row['agname'];
$credit_balance = $row['credit_balance'];

require ("../../member/include/traditional.zh-vn.inc.php");
$keys=$_REQUEST['keys'];
if ($keys=='add'){
	$world=$_REQUEST['cid'];
	$name_left = substr($_REQUEST['cid'],0,2);
	$sql = "select * from web_corprator where agname='$world'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$corprator=$row['Agname'];
	$agid=$row['ID'];
	$mcount=$row['mcount'];

	$credit=$row['Credit'];
	$super=$row['super'];
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
	$memname	=$name_left.$_REQUEST['username'];
	$mempasd	=substr(md5(md5($_REQUEST['password']."abc123")),0,16);
	$maxcredit=$_REQUEST['maxcredit'];
	$alias		=$_REQUEST['alias'];
	$memcount	=$_REQUEST['maxmember'];
$chk=chk_pwd($mempasd);

	$winloss=$_REQUEST['winloss_a'];
	$winloss_parents=$_REQUEST['winloss_s'];
	if($memcount==''){$memcount=99999;}

	$username=$memname;
	$mysql="select * from web_world where Agname='$username'";
	$result = mysql_query($mysql);
	$count=mysql_num_rows($result);
	if ($count>0){
		echo wterror("Tài khoản bạn đã nhập $memname Đã được sử dụng, vui lòng quay lại trang trước và nhập lại");
		exit;
	}else{
		$mysql="select sum(Credit) as credit from web_world where corprator='$corprator'";
		$wdresult = mysql_query($mysql);
		$wdrow = mysql_fetch_array($wdresult);
		if ($wdrow['credit']+$maxcredit>$credit){
			echo wterror("Tổng hạn mức tín dụng của đại lý là$maxcredit<br>Giới hạn tín dụng tối đa của cổ đông hiện tại là$credit<br>,Tổng số tiền tín dụng của tổng đại lý là$row[credit]<br>Đã vượt quá giới hạn tín dụng của cổ đông, vui lòng quay lại và nhập lại");
			exit;
		}else{
			$mysql="select count(*) as cou from web_member where corprator='$corprator'";
			$result = mysql_query($mysql);
			$row = mysql_fetch_array($result);
		/*
			if ($row['cou']+$maxmember>$mcount){
				echo wterror("目前总代理 可用人数 已超过股东可用人数，请回上一面重新输入");
				exit();
			}
	*/
			$mysql="insert into web_world(Agname,Passwd,Credit,Alias,corprator,AddDate,super,winloss,winloss_parents,$skey) values ('$memname','$mempasd','$maxcredit','$alias','$corprator','$AddDate','$agname','$winloss','$winloss_parents',$svalue)";

			mysql_query($mysql) or die ("Thao tác thất bại!");
			$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$agname','Thêm','$memname','Đại lý tổng hợp',2)";
			mysql_query($mysql) or die ("Thao tác thất bại!");
/*			$mysql="update web_corprator set agCount=agCount+1 where agname='$agname'";
			mysql_query($mysql) or die ("操作失败!");
*/			echo "<script languag='JavaScript'>self.location='body_super_agents.php?uid=$uid'</script>";
		}
	}
}else{
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_ag_ed {  background-color: #baccc1; text-align: right}
-->
</style>
<SCRIPT>
function LoadBody(){
document.all.keys.value = '';
document.all.corprator.value = '<?=$corprator?>';
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
function SubChk()
{
	
//if(document.all.corprator.value=='')
//{ document.all.username.focus(); alert("帐号请务必输入!!"); return false; }
 if(document.all.password.value=='')
 { document.all.password.focus(); alert("Vui lòng nhập mật khẩu của bạn !"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("Vui lòng xác nhận mật khẩu của bạn và nhập mật khẩu !"); return false; }
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("Lỗi xác nhận mật khẩu, vui lòng nhập lại !"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("Vui lòng nhập tên của đại lý!"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("Vui lòng nhập tổng hạn mức tín dụng !"); return false; }

 document.all.keys.value = 'add';
 if(!confirm("Bạn có chắc chắn để viết các đại lý?"))
 {
  return false;
 }
}

function roundBy(num,num2) {
	return(Math.floor((num)*num2)/num2);
}

function checkaccKey(keycode){
	if ((keycode>=65 && keycode<=90)  || (keycode>=97 && keycode<=122)||(keycode>=48 && keycode<=57)) return true;
 	return false;
}
function ChkMem(){
	D=document.all.ag_count.innerHTML+document.all.sname.value;
	document.getElementById('getData').src='su_mem_chk.php?uid=<?=$uid?>&langx=zh-tw&username='+D;
}
</SCRIPT>
</head>

<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="LoadBody();">
 <FORM NAME="myFORM1" ACTION="" METHOD=POST>
 <input TYPE=HIDDEN NAME="uid" VALUE="<?=$uid?>">
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="m_tline">&nbsp;&nbsp;&nbsp;&nbsp;<?=$cor_agents?>--<?=$mem_addnewuser?>&nbsp;&nbsp;
     &nbsp;&nbsp;<select name="corprator" class="za_select" onChange="document.myFORM1.submit();">
          <option value=""></option>
          	<?
			$mysql="select ID,Agname from web_corprator where Status=1 and super='".$agname."'";
			$ag_result = mysql_query( $mysql);
			while ($ag_row = mysql_fetch_array($ag_result)){
				echo "<option value=".$ag_row['Agname'].">".$ag_row['Agname']."</option>";
			}
			?>
        </select></td>
	<td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr>
    <td colspan="2" height="4"></td>
  </tr>
</table>
</form>
 <FORM NAME="myFORM" ACTION="" METHOD=POST onSubmit="return SubChk()">
 <input TYPE=HIDDEN NAME="keys" VALUE="add">
 <input TYPE=HIDDEN NAME="cid" VALUE="<?=$corprator?>">
 <input TYPE=HIDDEN NAME="uid" VALUE="<?=$uid?>">
 <input type="hidden" name="winloss_c" value="<?=$winloss?>">
 <input type="hidden" name="checkpay" value="Y">
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td colspan="2" ><?=$mem_accset?></td>
  </tr>
  <tr class="m_bc_ed">
      <td width="120" class="m_ag_ed"><!--input type=button name="chk" value="确认" class="za_button" onclick='ChkMem();'--><?=$sub_user?></td>
       <td>
				<?=$name_left?><input type="text" name="username" value="" size="10" maxlength="5" class="za_text" onKeyPress="return ChkKeyCode();">
			</td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_ag_ed"><?=$sub_pass?>:</td>
      <td>
        <input type=PASSWORD name="password" value="" size=12 maxlength=12 class="za_text">
          Mật khẩu phải dài ít nhất 6 ký tự, dài tối đa 12 ký tự và chỉ có thể có số (0-9) và chữ hoa và chữ thường tiếng Anh. </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_ag_ed"><?=$acc_repasd?>:</td>
      <td>
        <input type=PASSWORD name="repassword" value="" size=12 maxlength=12 class="za_text">
      </td>
  </tr>
  <tr class="m_bc_ed">
    <td class="m_ag_ed"><?=$rcl_agent?><?=$sub_name?>:</td>
      <td>
        <input type=TEXT name="alias" value="" size=10 maxlength=10 class="za_text">
      </td>
  </tr>
</table>
  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
    <tr class="m_title_edit">
      <td colspan="2" >
        <?=$mem_betset?>
      </td>
    </tr>

    <tr class="m_bc_ed">
      <td width="120" class="m_ag_ed">
        <?=$mem_maxcredit?>
        :</td>
      <td width="657"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input type=TEXT name="maxcredit" value="0" size=10 maxlength=10 class="za_text"></td>
		<td>Sử dụng / Kích hoạt: 0 Tắt: 0 Tạm dừng: 0 Sẵn có: 0
		<? if($credit_balance==1){
		$mysql="select sum(credit) as credit_used from web_world where corprator='$corprator'";
		$result = mysql_query($mysql);
		$row = mysql_fetch_array($result);
		$credit_used = intval($row['credit_used']);
		$credit_canuse = $credit-$credit_used;
			echo "<BR><font color=#FF0000> $corprator </font>Giới hạn / lời nhắc giới hạn tín dụng:$credit Đã sử dụng:$credit_used  Có sẵn:$credit_canuse";
			}
		?>
		</td>
	</tr>
</table>
		</td>
    </tr>
	<tr class=m_bc_ed>
    <td class=m_ag_ed>Tổng nắp đại lý:</td>
    <td><select class=za_select name=winloss_s>
	<?

	for($i=$winloss;$i>=0;$i=$i-5){
		$abc=$i;
		echo "<option value=$abc>".($i/10).$wor_percent."</option>\n";

	}
	?>
		</select>
    </TD></TR>
	<tr class=m_bc_ed>
    <td class=m_ag_ed>Tổng nắp đại lý:</td>
    <td><select class=za_select name=winloss_a>
	<?

	for($i=$winloss;$i>=0;$i=$i-5){
		$abc=$i;
		$sele = $i==50 ? 'selected' : '';
		echo "<option value='$abc' $sele>".($i/10).$wor_percent."</option>\n<BR>";

	}
	?>
		</select>
    </TD></TR>
    <!--tr class="m_bc_ed">
      <td class="m_ag_ed" width="120">会员数:</td>
      <td>
        <input type=TEXT name="maxmember" value="" size=10 maxlength=10 class="za_text">
         </td>
    </tr-->
  </table>
  	  <table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed"><tr align="center" bgcolor="#FFFFFF">
      <td align="center">
        <input type=SUBMIT name="OK" value="<?=$submit_ok?>" class="za_button">
        &nbsp;&nbsp; &nbsp;
        <input type=BUTTON name="FormsButton2" value="<?=$submit_cancle?>" id="FormsButton2" onClick="javascript:history.go(-1)" class="za_button">
      </td>
    </tr>
  </table>
</form>
<iframe id="getData" src="../../../../ok.html" width=0 height=0></iframe>
</body>
</html>
<?
}
mysql_close();
?>
