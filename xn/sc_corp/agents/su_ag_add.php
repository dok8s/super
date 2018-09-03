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
$world=$_REQUEST["agents_id"];

$sql = "select Agname,ID,language,credit_balance from web_super where Oid='$uid'";

$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$super=$row['Agname'];
$credit_balance = $row['credit_balance'];

if($world==''){
	$winloss=0;
}else{
	$sql="select winloss,winloss_parents,corprator,credit from web_world where agname='$world'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$corprator=$row['corprator'];
	$credit=$row['credit'];
	$winloss=intval($row['winloss_parents']);
/*
	$sql="select winloss from web_corprator where agname='$corprator'";
	$result1 = mysql_query($sql);
	$row1 = mysql_fetch_array($result1);

	$winloss=$row1['winloss'];
*/
}
$credit=intval($credit);
require ("../../member/include/traditional.zh-cn.inc.php");

$keys=$_REQUEST['keys'];
if ($keys=='add'){
	$AddDate=date('Y-m-d H:i:s');
	$memname=$_REQUEST['username'];
	$mempasd=substr(md5(md5($_REQUEST['password']."abc123")),0,16);
	$maxcredit=$_REQUEST['maxcredit'];
	$world=$_REQUEST['world'];
	$wager=$_REQUEST['type'];
	$alias=$_REQUEST['alias'];
	$aid=$_REQUEST['agents_id'];
	$winloss_a=$_REQUEST['winloss_a'];
	$winloss_s=$_REQUEST['winloss_s'];
$chk=chk_pwd($mempasd);

	$mysql="select * from web_agents where Agname='$memname'";

	$result = mysql_query($mysql);
	$count=mysql_num_rows($result);
	if ($count>0){
		echo wterror("Tài khoản bạn đã nhập$memname Đã được sử dụng, vui lòng quay lại trang trước và nhập lại");
		exit();
	}
	$memcount=$_REQUEST['maxmember'];

	if($memcount==''){$memcount=99999;}


	$mysql="select * from web_world where agname='$world'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);
	$credit=$row['Credit'];
	$corprator=$row['corprator'];
	$winloss_ac=$row['winloss_parents'];
	$winloss_as=$row['winloss'];
	$mcount=$row['mcount'];

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

	$kk=$winloss_s+$winloss_a;
	if($kk>$winloss_ac || $kk<$winloss_as){
		echo wterror("Tổng của tổng số đại lý và đại lý phải là".($winloss_as*0.1)."~".($winloss_ac*0.1)."Giữa, vui lòng quay lại và nhập lại");
		exit;
	}

	$mysql="select winloss from web_corprator where agname='$corprator'";
	$result1 = mysql_query($mysql) or exit("error 93 $mysql");
	$row1 = mysql_fetch_array($result1);
	$winloss_c	=$row1['winloss']-$winloss_a-$winloss_s;

	$mysql="select sum(Credit) as credit from web_agents where world='$world'";
	$result = mysql_query($mysql);
	$row = mysql_fetch_array($result);

	if ($row['credit']+$maxcredit>$credit){
		echo wterror("Hạn mức tín dụng tối đa của đại lý hiện tại là$maxcredit<br>Hiện tại, giới hạn tín dụng tối đa của tổng đại lý là$credit<br>,Giới hạn tín dụng tích lũy của đại lý là".number_format($row[credit],0)."<br>Tổng hạn mức tín dụng đại lý đã bị vượt quá. Vui lòng quay lại và nhập lại");
		exit();
	}
	/*if ($maxmember>$mcount){
		echo wterror("已超出总代理商人数限制，请回上一面重新输入");
		exit();
	}
*/
	$mysql="insert into web_agents(corprator,Agname,Passwd,Credit,Alias,AddDate,Wager,Winloss_c,Winloss_S,Winloss_A,world,super,$skey) values ('$corprator','$memname','$mempasd','$maxcredit','$alias','$AddDate','$wager','$winloss_c','$winloss_s','$winloss_a','$world','$super',$svalue)";

	mysql_query($mysql) or die ("Thao tác thất bại!");
	$mysql="insert into  agents_log (M_DateTime,M_czz,M_xm,M_user,M_jc,Status) values('".date("Y-m-d H:i:s")."','$super','Thêm','$memname','Đại lý',2)";
	mysql_query($mysql) or die ("Thao tác thất bại!");
	/*$mysql="update web_world set agCount=agCount+1 where agname='".$agents_id."'";
	mysql_query($mysql) or die ("绂钎囮啖!");
	*/echo "<script languag='JavaScript'>self.location='./su_agents.php?uid=$uid'</script>";
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
document.all.agents_id.value='<?=$world?>';
}
function SubChk()
{
//if(document.all.agents_id.value=='')
//{ document.all.agents_id.focus(); alert("帐号请务必输入!!"); return false; }
//if(document.all.sname.value=='')
//{ document.all.sname.focus(); alert("帐号请务必输入!!"); return false; }
 if(document.all.password.value=='')
 { document.all.password.focus(); alert("Vui lòng nhập mật khẩu của bạn!!"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("Vui lòng xác nhận mật khẩu và nhập mật khẩu.!!"); return false; }
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("Lỗi xác nhận mật khẩu, vui lòng nhập lại!!"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("Vui lòng nhập tên của đại lý.!!"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("Vui lòng nhập tổng hạn mức tín dụng!!"); return false; }
//document.all.username.value = document.all.ag_count.innerHTML+document.all.sname.value;

  if(document.all.winloss_s.value=='')
 { document.all.winloss_s.focus(); alert("Vui lòng chọn tổng số đại lý!!"); return false; }
  if(document.all.winloss_a.value=='' )
 { document.all.winloss_a.focus(); alert("Vui lòng chọn số lượng đại lý!!"); return false; }
 var winloss_a,winloss_s;
 winloss_s=eval(document.all.winloss_s.value);
 winloss_a=eval(document.all.winloss_a.value);
 if ((winloss_s+winloss_a) > <?=200-$winloss?>) //表示总代理及代理商相加不得大于八成,小于五成 .
 {

 alert("Tổng số lượng nhà phân phối và đại lý phải nhỏ hơn<?=$winloss/10?>Tổng số lượng nhà phân phối và đại lý phải nhỏ hơn... !! ");
 document.all.winloss_s.focus();
 return false;
 }

 if(!confirm("Bạn có chắc chắn để viết các đại lý??"))
 {
  return false;
 }
 }

function roundBy(num,num2) {
	return(Math.floor((num)*num2)/num2);
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

function CheckKey(){
	if(event.keyCode == 13) return false;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("Tổng hạn mức tín dụng chỉ có thể nhập số!!"); return false;}
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
 <FORM NAME="myFORM1" ACTION="" METHOD=POST onSubmit="return SubChk()">
 <input TYPE=HIDDEN NAME="uid" VALUE="<?=$uid?>">
 <input type="hidden" name="checkpay" value="Y">
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="m_tline">&nbsp;&nbsp;<?=$mem_agents?><?=$mem_add?>&nbsp;&nbsp;<select name="agents_id" class="za_select" onChange="document.myFORM1.submit();">
          <option value=""></option>
          	<?
			$mysql="select ID,Agname from web_world where Status=1 and super='".$super."'";
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
 <input TYPE=HIDDEN NAME="world" VALUE="<?=$world?>">
 <input TYPE=HIDDEN NAME="uid" VALUE="<?=$uid?>">

<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
    <td colspan="2" ><?=$mem_accset?></td>
  </tr>
  <tr class="m_bc_ed">
      <td width="120" class="m_ag_ed"><!--input type=button name="chk" value="确认" class="za_button" onclick='ChkMem();'--><?=$sub_user?> </td>
        <td><?=substr($world,0,3)?><input type="hidden" name="username" size=4 maxlength=4 value="<?=substr($world,0,3)?>" class="za_text">
	  <select size="1" name="num_1" style="border-style: solid; border-width: 0" onChange="show_count(1,this.value);" class="za_select_t">
                <option value=""></option>
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
			</select>
              <select size="1" name="num_2" style="border-style: solid; border-width: 0" onChange="show_count(2,this.value);" class="za_select_t">
                <option value=""></option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
              </select>
              <select size="1" name="num_3" style="border-style: solid; border-width: 0" onChange="show_count(3,this.value);" class="za_select_t">
                <option value=""></option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
              </select>
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
      <td colspan="2" ><?=$mem_betset?></td>
    </tr>
    <tr class="m_bc_ed">
      <td width="120" class="m_ag_ed"><?=$real_wager?>:</td>
      <td>
        <select id="type" name="type" class="za_select">
          <option value="0"><?=$mem_disable?></option>
          <option value="1"><?=$mem_enable?></option>
        </select>
      </td>
    </tr>
    <tr class="m_bc_ed">
      <td class="m_ag_ed"><?=$mem_maxcredit?>:</td>
      <td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><input type=TEXT name="maxcredit" value="0" size=10 maxlength=10 class="za_text"></td>
		<td>Sử dụng / Kích hoạt: 0 Tắt: 0 Tạm dừng: 0 Sẵn có: 0
		<? if($credit_balance==1){
		$mysql="select sum(credit) as credit_used from web_agents where world='$world'";
		$result = mysql_query($mysql);
		$row = mysql_fetch_array($result);
		$credit_used = intval($row['credit_used']);
		$credit_canuse = $credit-$credit_used;
			echo "<BR><font color=#FF0000> $world </font>Sử dụng / Kích hoạt: 0 Tắt: 0 Tạm dừng: 0 Sẵn có: 0...:$credit Đã sử dụng:$credit_used  Có sẵn:$credit_canuse";
			}
		?>
		</td>
	</tr>
</table>
      </td>
    </tr>

	<tr class=m_bc_ed>
    <td class=m_ag_ed><?=$wld_percent2?>:</td>
    <td><select class=za_select name=winloss_s>
	<?

	for($i=$winloss;$i>=0;$i=$i-5){
		$abc=$i;
		if ($i==0){
			echo "<option value=$abc selected>".($i/10).$wor_percent."</option>\n";
		}else{
			echo "<option value=$abc>".($i/10).$wor_percent."</option>\n";
		}
	}
	?>
		</select>
    </TD></TR>
    <TR class=m_bc_ed>
      <TD class=m_ag_ed><?=$wld_percent3?>:</TD>
      	<TD><select class=za_select name=winloss_a>
	<?

	for($i=$winloss;$i>=0;$i=$i-5){
		$abc=$i;

			echo "<option value=$abc>".($i/10).$wor_percent."</option>\n";

	}
	?>
		</select>
       <!--[&nbsp;中国甲A佔成：
	<input type=RADIO name="checkpay" value="N" class="za_dot" {WX_N}>NO&nbsp;&nbsp;&nbsp;
	<input type=RADIO name="checkpay" value="Y" class="za_dot" Y>YES&nbsp;]-->

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
