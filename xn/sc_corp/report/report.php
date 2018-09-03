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
$sql="select agname,id,language,subname,subuser from web_super where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$week1=date('w+1');
$row = mysql_fetch_array($result);
$subuser=$row['subuser'];
if ($row['subuser']==1){
	$agname=$row['subname'];
	$loginfo=$agname.'Tài khoản phụ:'.$row['Agname'].'Báo cáo kỳ truy vấn';
}else{
	$agname=$row['agname'];
	$loginfo='Thời gian truy vấn'.$date_start.'Để'.$date_end.'Báo cáo';
}
$agid=$row['ID'];
$super=$row['super'];

$langx=$row['language'];
require ("../../member/include/traditional.$langx.inc.php");

$langx=$row['language'];
$date_s=date('Y-m-d');//,time()-24*3600
$date_e=date('Y-m-d');//,time()-24*3600

$today=date('Y-m-d');
$nowday=TDate();

$week1=date('w');
if($week1==0){
	$week1=6;
}else{
	$week1=$week1-1;
}

?>
<html>
<head>
<title>reports</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.m_title_re {  background-color: #577176; text-align: right; color: #FFFFFF}
.m_bc { background-color: #C9DBDF; padding-left: 7px }
.small {
	font-size: 11px;
	background-color: #7DD5D2;
	text-align: center;
}
.small_top {
	font-size: 11px;
	color: #FFFFFF;
	background-color: #669999;
	text-align: center;
}
.show_ok {background-color: gold; color: blue}
.show_no {background-color: yellow; color: red}
-->
</style>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/calendar.css">
<SCRIPT>
<!--
function onSubmit(){
	kind_obj = document.getElementById("report_kind");
	form_obj = document.getElementById("myFORM");
	//if(kind_obj.value == "A")
		form_obj.action = "report_all.php";
	//else
	//	form_obj.action = "report_all.php?report_kind="+kind_obj.value;
	return true;
}
-->
</SCRIPT>
<style type="text/css">
<!--
.m_title_ce {background-color: #669999; text-align: center; color: #FFFFFF}
-->
</style>
</head>
<script language="JavaScript" src="/js/simplecalendar.js"></script>
<script language="JavaScript">

function chg_date(range,num1,num2){
	//alert(num1+'-'+num2);
	if(range=='t' || range=='w' || range=='lw' || range=='r'){
		FrmData.date_start.value ='<?=$today?>';
		FrmData.date_end.value =FrmData.date_start.value;
	}

	if(range!='t'){
		if(FrmData.date_start.value!=FrmData.date_end.value){
			FrmData.date_start.value ='<?=$today?>';
			FrmData.date_end.value =FrmData.date_start.value;
		}
		var aStartDate = FrmData.date_start.value.split('-');
		var newStartDate = new Date(parseInt(aStartDate[0], 10),parseInt(aStartDate[1], 10) - 1,parseInt(aStartDate[2], 10) + num1);
		FrmData.date_start.value = newStartDate.getFullYear()+ '-' + padZero(newStartDate.getMonth() + 1)+ '-' + padZero(newStartDate.getDate());
		var aEndDate = FrmData.date_end.value.split('-');
		var newEndDate = new Date(parseInt(aEndDate[0], 10),parseInt(aEndDate[1], 10) - 1,parseInt(aEndDate[2], 10) + num2);
		FrmData.date_end.value = newEndDate.getFullYear()+ '-' + padZero(newEndDate.getMonth() + 1)+ '-' + padZero(newEndDate.getDate());
	}
}
function report_bg(){
	document.getElementById(date_num).className="report_c";
}
</script>
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
<body  bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">Đang tải...</div>
</div>
<FORM id="myFORM" ACTION="" METHOD=POST onSubmit="return onSubmit();" name="FrmData" style="padding-top: 10px;">
<input type=HIDDEN name="uid" value="<?=$uid?>">
<table width="780" border="0" cellspacing="0" cellpadding="0" style="margin-left:20px;margin-bottom: 10px;">
	<tr>
		<td class="m_tline">
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="60">&nbsp;&nbsp;Quản lý:</td>
					<td>
						<select name="gtype" class="za_select">
																
								<option value="">Tất cả</option>
								<option value="FT">Bóng đá</option>
								<option value="BK">Bóng rổ</option>
								<option value="TN">Quần vợt</option>
								<option value="VB">Bóng chuyền</option>
								<option value="BS">Bóng chày</option>
								<option value="OP">Khác</option>
								<option value="FS">Quán quân</option>
						</select>
					</td>
<td width="80"></td>
						<td nowrap>
							&nbsp;<a href="./report.php?uid=<?=$uid?>" onMouseOver="window.status='Báo cáo'; return true;" onMouseOut="window.status='';return true;"style="background-color:#3399FF">Báo cáo</a>
							&nbsp;<a href="./report_cancel_wager.php?uid=<?=$uid?>" onMouseOver="window.status='Hủy phân tích'; return true;" onMouseOut="window.status='';return true;"style="background-color:">Hủy phân tích</a>
						</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table><tr><td>

<table width="660" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed" style="margin-left:20px;margin-bottom: 10px;">
	<tr class="m_bc">
		<td width="100" class="m_title_re"> Khoảng ngày: </td>
		<td colspan="5">
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><input type=TEXT name="date_start" value="<?=$date_s?>" size=10 maxlength=11 class="za_text"></td>
					<td><a href="javascript: void(0);" onMouseOver="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onMouseOut="if (timeoutDelay) calendarTimeout();window.status='';" onClick="g_Calendar.show(event,'FrmData.date_start',true,'yyyy-mm-dd'); return false;">&nbsp;&nbsp;<img src="/images/control/calendar.gif" name="imgCalendar" width="34" height="21" border="0"></a></td>
					<td width="20" align="center"> ~</td>
					<td><input type=TEXT name="date_end" value="<?=$date_e?>" size=10 maxlength=10 class="za_text"></td>
					<td><a href="javascript: void(0);" onMouseOver="if (timeoutId) clearTimeout(timeoutId);window.status='Show Calendar';return true;" onMouseOut="if (timeoutDelay) calendarTimeout();window.status='';" onClick="g_Calendar.show(event,'FrmData.date_end',true,'yyyy-mm-dd'); return false;">&nbsp;&nbsp;<img src="/images/control/calendar.gif" name="imgCalendar" width="34" height="21" border="0"></a></td>
					<td>&nbsp;</td>
					<td>
						<input name="Submit" type="Button" class="za_button" onClick="chg_date('t',0,0)" value="Hôm">
						<input name="Submit" type="Button" class="za_button" onClick="chg_date('l',-1,-1)" value="Hôm qua">
						<input name="Submit" type="Button" class="za_button" onClick="chg_date('n',1,1)" value="Ngày">
						<input name="Submit" type="Button" class="za_button" onClick="chg_date('w',-<?=$week1?>,6-<?=$week1?>)" value="Tuần này">
						<input name="Submit" type="Button" class="za_button" onClick="chg_date('lw',-<?=$week1?>-7,6-<?=$week1?>-7)" value="Tuần trước">
						<input name="Submit" type="Button" class="za_button" onClick="FrmData.date_start.value='<?=$nowday[0]?>';FrmData.date_end.value='<?=$nowday[1]?>'" value="Vấn đề">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="m_bc">
		<td class="m_title_re"> Phân loại báo: </td>
		<td colspan="4">
			<select name="report_kind" class="za_select">
				<option value="A" SELECTED>Sổ cái chung</option>
				
				<!--option value="C">分类帐</option-->
			</select>
		</td>
	</tr>
	<!--tr class="m_bc">
		<td class="m_title_re"> 币值: </td>
		<td colspan="4">
			<select name="currency" class="za_select"-->
				<!-- BEGIN DYNAMIC BLOCK: currency -->
				<!--option value="{CUR_VALUE}">{CUR_NAME}</option-->
				<!-- END DYNAMIC BLOCK: currency -->
			<!--/select>
		</td>
	</tr-->
	<tr class="m_bc">
		<td class="m_title_re"> Phương thức: </td>
		<td colspan="4">
			<select name="pay_type" class="za_select">
				<option value="" SELECTED>Tất cả</option>
				<option value="0">Hạn mức tín</option>
				<option value="1">Tiền mặt</option>
			</select>
		</td>
	</tr>
	<tr class="m_bc">
		<td class="m_title_re"> Loại cược: </td>
		<td colspan="4">
			<select name="wtype" class="za_select">
				<option value="" SELECTED>Tất cả</option>
				<option value="R">Hãy để bóng (phút)</option>
				<option value="RE">Cán bóng</option>
				<option value="P">Tiêu chuẩn giải</option>
				<option value="PR">Để bóng chuyền</option>
				<option value="PC">Giải phóng mặt</option>
				<option value="OU">Kích thước</option>
				<option value="ROU">Kích thước bóng</option>
				<option value="PD">Làn sóng</option>
				<option value="T">Mục tiêu</option>
				<option value="M">Giành chiến</option>
				<option value="F">Trường toàn</option>
				<option value="HR">Nửa đầu (phút)</option>
				<option value="HOU">Kích thước nửa</option>
				<option value="HM">Nửa chiến thắng</option>
				<option value="HRE">Nửa đầu (phút)</option>
				<option value="HROU">Kích thước</option>
                                <option value="HPD">Nửa trên</option>
			</select>
		</td>
	</tr>
	<?
	$mdate_t=date('m-d');
	$mdate_y=date('m-d',time()-24*60*60);
	$mysql="select * from foot_match where mid%2=1 and m_Date='$mdate_t' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$ft_cou=mysql_num_rows($result)+0;

	$mysql="select * from foot_match where mid%2=1 and m_Date='$mdate_t' and MB_Inball=''";
	$result = mysql_query($mysql);
	$ft_cou1=mysql_num_rows($result)+0;

	$mysql="select * from foot_match where mid%2=1 and m_Date='$mdate_y' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$ft_cou2=mysql_num_rows($result)+0;

	$mysql="select * from foot_match where mid%2=1 and m_Date='$mdate_y' and MB_Inball=''";
	$result = mysql_query($mysql);
	$ft_cou3=mysql_num_rows($result)+0;

	$mysql="select * from bask_match where m_Date='$mdate_t' and MB_Inball<>'' and mb_mid<100000";
	$result = mysql_query($mysql);
	$bk_cou=mysql_num_rows($result)+0;

	$mysql="select * from bask_match where m_Date='$mdate_t' and MB_Inball='' and mb_mid<100000";
	$result = mysql_query($mysql);
	$bk_cou1=mysql_num_rows($result)+0;

	$mysql="select * from bask_match where m_Date='$mdate_y' and MB_Inball<>'' and mb_mid<100000";
	$result = mysql_query($mysql);
	$bk_cou2=mysql_num_rows($result)+0;

	$mysql="select * from bask_match where m_Date='$mdate_y' and MB_Inball='' and mb_mid<100000";
	$result = mysql_query($mysql);
	$bk_cou3=mysql_num_rows($result)+0;

	$mysql="select * from tennis where m_Date='$mdate_t' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$tn_cou=mysql_num_rows($result)+0;

	$mysql="select * from tennis where m_Date='$mdate_t' and MB_Inball=''";
	$result = mysql_query($mysql);
	$tn_cou1=mysql_num_rows($result)+0;

	$mysql="select * from tennis where m_Date='$mdate_y' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$tn_cou2=mysql_num_rows($result)+0;

	$mysql="select * from tennis where m_Date='$mdate_y' and MB_Inball=''";
	$result = mysql_query($mysql);
	$tn_cou3=mysql_num_rows($result)+0;

	$mysql="select * from volleyball where m_Date='$mdate_t' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$vb_cou=mysql_num_rows($result)+0;

	$mysql="select * from volleyball where m_Date='$mdate_t' and MB_Inball=''";
	$result = mysql_query($mysql);
	$vb_cou1=mysql_num_rows($result)+0;

	$mysql="select * from volleyball where m_Date='$mdate_y' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$vb_cou2=mysql_num_rows($result)+0;

	$mysql="select * from volleyball where m_Date='$mdate_y' and MB_Inball=''";
	$result = mysql_query($mysql);
	$vb_cou3=mysql_num_rows($result)+0;

	$mysql="select * from baseball where m_Date='$mdate_t' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$bs_cou=mysql_num_rows($result)+0;

	$mysql="select * from baseball where m_Date='$mdate_t' and MB_Inball=''";
	$result = mysql_query($mysql);
	$bs_cou1=mysql_num_rows($result)+0;

	$mysql="select * from baseball where m_Date='$mdate_y' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$bs_cou2=mysql_num_rows($result)+0;

	$mysql="select * from baseball where m_Date='$mdate_y' and MB_Inball=''";
	$result = mysql_query($mysql);
	$bs_cou3=mysql_num_rows($result)+0;


	$mysql="select * from sp_match where date_format(mstart,'%m-%d')='$mdate_t' and QQ526738=1 group by mid";
	$result = mysql_query($mysql);
	$sp_cou=mysql_num_rows($result)+0;


	$mysql="select * from sp_match where date_format(mstart,'%m-%d')='$mdate_t' and QQ526738=0 group by mid";
	$result = mysql_query($mysql);
	$sp_cou1=mysql_num_rows($result)+0;

	$mysql="select * from sp_match where date_format(mstart,'%m-%d')='$mdate_y' and QQ526738=1 group by mid";
	$result = mysql_query($mysql);
	$sp_cou2=mysql_num_rows($result)+0;


	$mysql="select * from sp_match where date_format(mstart,'%m-%d')='$mdate_y' and QQ526738=0 group by mid";
	$result = mysql_query($mysql);
	$sp_cou3=mysql_num_rows($result)+0;

$mysql="select * from other_play where m_Date='$mdate_t' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$op_cou=mysql_num_rows($result)+0;

	$mysql="select * from other_play where m_Date='$mdate_t' and MB_Inball=''";
	$result = mysql_query($mysql);
	$op_cou1=mysql_num_rows($result)+0;

	$mysql="select * from other_play where m_Date='$mdate_y' and MB_Inball<>''";
	$result = mysql_query($mysql);
	$op_cou2=mysql_num_rows($result)+0;

	$mysql="select * from other_play where m_Date='$mdate_y' and MB_Inball=''";
	$result = mysql_query($mysql);
	$op_cou3=mysql_num_rows($result)+0;
	if(($ft_cou1+$bk_cou1+$tn_cou1+$vb_cou1+$bs_cou1+$sp_cou1+$op_cou1)==0){
		$kkk1="<b><font class='show_ok'>Hoàn thành</font></b>";
	}else{
		$kkk1="<b><font class='show_no'>Chưa hoàn thành</font></b>";
	}
	if(($ft_cou3+$bk_cou3+$tn_cou3+$vb_cou3+$bs_cou3+$sp_cou3+$op_cou3)==0){
		$kkk3="<b><font class='show_ok'>Hoàn thành</font></b>";
	}else{
		$kkk3="<b><font class='show_no'>Chưa hoàn</font></b>";
	}
	?>
    <tr class="m_bc">
      <td class="m_title_re">Ngày tháng</td>
      <td colspan="2" class="m_title_ce"><?=date('Y-m-d',time()-24*60*60)?><?=$kkk3?></td>
      <td colspan="2" class="m_title_ce"><?=date('Y-m-d')?><?=$kkk1?></td>
    </tr>
    <tr class="m_bc">
      <td class="m_title_re">Trạng thái hiện tại</td>
      <td style="color:#FF0000">Có kết quả</td>
      <td style="color:#FF0000">Không có kết</td>
      <td>Có kết quả</td>
      <td>Không có kết</td>
    </tr>
    <tr class="m_bc">
      <td class="m_title_re">Bóng đá</td>
      <td style="color:#FF0000"><?=$ft_cou2?></td>
      <td style="color:#FF0000"><?=$ft_cou3?></td>
      <td><?=$ft_cou?></td>
      <td><?=$ft_cou1?></td>
    </tr>

    <tr class="m_bc">
      <td class="m_title_re">Bóng rổ</td>
      <td style="color:#FF0000"><?=$bk_cou2?></td>
      <td style="color:#FF0000"><?=$bk_cou3?></td>
      <td><?=$bk_cou?></td>
      <td><?=$bk_cou1?></td>
    </tr>

    <tr class="m_bc">
      <td class="m_title_re">Quần vợt</td>
      <td style="color:#FF0000"><?=$tn_cou2?></td>
      <td style="color:#FF0000"><?=$tn_cou3?></td>
      <td><?=($tn_cou+0)?></td>
      <td><?=$tn_cou1?></td>
    </tr>

    <tr class="m_bc">
      <td class="m_title_re">Bóng chuyền</td>
      <td style="color:#FF0000"><?=$vb_cou2?></td>
      <td style="color:#FF0000"><?=$vb_cou3?></td>
      <td><?=$vb_cou?></td>
      <td><?=$vb_cou1?></td>
    </tr>
	<tr class="m_bc">
		<td class="m_title_re">Bóng chày</td>
		<td style="color:#FF0000"><?=$bs_cou2?></td>
		<td style="color:#FF0000"><?=$bs_cou3?></td>
		<td><?=$bs_cou?></td>
		<td><?=$bs_cou1?></td>
	</tr>
    <tr class="m_bc">
      <td class="m_title_re">Đặc biệt</td>
      <td style="color:#FF0000"><?=$sp_cou2?></td>
		<td style="color:#FF0000"><?=$sp_cou3?></td>
		<td><?=$sp_cou?></td>
		<td><?=$sp_cou1?></td>
    </tr>

<tr class="m_bc">
						<td class="m_title_re">Cuộc thi quốc tế</td>
						<td style="color:#FF0000"><?=$op_cou2?></td>
						<td style="color:#FF0000"><?=$op_cou3?></td>
						<td><?=$op_cou?></td>
						<td><?=$op_cou1?></td>
		  </tr>
	<tr bgcolor="#FFFFFF">
		<td height="30" colspan="6">
			<table>
				<tr>
					<td align="right" width="60"> Trạng thái: </td>
					<td width="250">
						<select name="result_type" class="za_select">
							<OPTION VALUE="Y">Có kết quả</OPTION>
							<? if($subuser<>1){?>
							<OPTION VALUE="N">Không có kết</OPTION>
							<? } ?>
						</select>
					</td>
					<td>
						<input type=SUBMIT name="SUBMIT" value="Truy vấn" class="za_button">
						&nbsp;&nbsp;&nbsp;
						<input type=BUTTON name="CANCEL" value="Hủy bỏ" onClick="javascript:history.go(-1)" class="za_button">
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

 </td><td>
<table width=246 border=0 cellpadding=0 cellspacing=1 class="m_tab_ed">
					<tr>
						<td height="9" colspan=2 class="small_top">Giai đoạn tài khoản 2016</td>
					</tr>
<?
$timestart = strtotime('2015-12-28');
$D = 3600*24;
$Q = $D*7*4;
for($i=1; $i<=13; $i++){
	$d_s = date('Y/m/d', $timestart+($i-1)*$Q);
	$d_e = date('Y/m/d', $timestart+$i*$Q-$D);
	echo "
<tr><td width='70' height='10' class='small'>Đầu {$i} Thời kỳ</td><td width='174' class='m_cen_top' id='Y_{$i}'>$d_s ~ $d_e</td></tr>";
}
?>
				</table>
</td>

</td></tr></table>
</form>
</body>
</html>

<?
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','0')";
mysql_query($mysql);
mysql_close();
?>
