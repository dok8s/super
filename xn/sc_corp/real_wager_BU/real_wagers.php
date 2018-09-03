<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$retime=$_REQUEST['retime'];
$rtype=strtoupper(trim($_REQUEST['rtype']));
$sql = "select * from web_super where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
}
$row = mysql_fetch_array($result);
$id=$row['ID'];
$agname=$row['Agname'];
$langx=$row['language'];
require ("../../member/include/traditional.$langx.inc.php");

if ($rtype==''){
	$rtype='OU';
}
if ($retime==''){
	$retime=-1;
}

switch ($rtype){
case "ALL":
	$caption='Độc thân tất cả';
	$width="848";
	$back_all="#3399ff";
    $table = '<td width = "38"> Thời gian </td>
<td width = "52" nowrap> Liên minh </td>
<td width = "28"> Sự kiện </td>
<td width = "200"> Nhóm </td>
<td width = "200"> Bàn tay / Ghi chú </td>
<td width = "200"> Kích thước / ghi chú nhỏ </td>
<! - td width = "130"> giành chiến thắng một mình </td ->
<td width = "130"> Đơn và đôi </td> ';
	$rtype2='OU';
	break;
case "OU":
	$caption=$rel_straight;
	$width="848";
	$back_ou="#3399ff";
    $table = '<td width = "38"> Thời gian </td>
<td width = "52" nowrap> Liên minh </td>
<td width = "28"> Sự kiện </td>
<td width = "200"> Nhóm </td>
<td width = "200"> Bàn tay / Ghi chú </td>
<td width = "200"> Kích thước / ghi chú nhỏ </td>
<! - td width = "130"> giành chiến thắng một mình </td ->
<td width = "130"> Đơn và đôi </td> ';
	$rtype2='OU';
	break;
case "R4":
	$caption='单节';
	$width="848";
	$back_rq4="#3399ff";
    $table = '<td width = "38"> Thời gian </td>
<td width = "52" nowrap> Liên minh </td>
<td width = "28"> Sự kiện </td>
<td width = "200"> Nhóm </td>
<td width = "200"> Bàn tay / Ghi chú </td>
<td width = "200"> Kích thước / ghi chú nhỏ </td>
<! - td width = "130"> giành chiến thắng một mình </ td ->
<td width = "130"> Đơn và đôi </td> ';
	$rtype2='OU';
	break;
case "RE":
	$caption='单节';
	$width="708";
	$back_re="#3399ff";
    $table = '<td width = "38"> Thời gian </td>
<td width = "52" nowrap> Liên minh </td>
<td width = "28"> Sự kiện </td>
<td width = "200"> Nhóm </td>
<td width = "200"> Bàn tay / Ghi chú </td>
<td width = "200"> Kích thước / ghi chú nhỏ </td>';
	$rtype2='RE';
	break;
case "PAR":
	$caption=$rel_parlay;
	$width="438";
	$back_par="#3399ff";
    $table = '<td width = "38"> Thời gian </td>
<td width = "52" nowrap> Liên minh </td>
<td width = "28"> Sự kiện </td>
<td width = "200"> Nhóm </td>
<td width = "120"> vượt qua </td> ';
	$rtype2='P';
	break;
case "P":
	$caption=$rel_haveopen;
	$back_p="#3399ff";
	$width="1000";
    $table = '<td width = "38"> Thời gian </td>
<td width = "40" nowrap> Liên minh </td>
<td width = "28"> Sự kiện </td>
<td width = "200"> Nhóm </td>
<td width = "200"> Tặng điểm </td>
<td nowrap> đĩa kích thước </td>
<td nowrap> Đi tới mặt đất </td>
<td nowrap> Kích thước go </td>
<td nowrap> Đơn và đôi </td>
<td nowrap> giải phóng mặt bằng </td> ';
	$rtype2='PL';
	break;
}
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<SCRIPT LANGUAGE="JAVASCRIPT1.2">
 var ReloadTimeID;
 function onLoad()
 {
  parent.loading = 'N';
  parent.ShowType = '<?=$rtype2?>';
  var obj_ltype = document.getElementById('ltype');
  obj_ltype.value = parent.ltype;
  var obj_retime = document.getElementById('retime');
  obj_retime.value =  <?=$retime?>;
  parent.pg=0;
  parent.body_var.location = "./real_wagers_var.php?uid=<?=$uid?>&rtype=<?=$rtype?>&page_no=0";
  if(obj_retime.value != -1)
   ReloadTimeID = setInterval("parent.body_var.location.reload()",obj_retime.value*1000);
 }

  function reload_var()
 {
  parent.body_var.location.reload();
 }
 function chg_ltype()
 {
  var obj_ltype = document.getElementById('ltype');
  var obj_set_account = document.getElementById('set_account');
  parent.body_var.location="./real_wagers_var.php?uid=<?=$uid?>&rtype=<?=$rtype?>&ltype="+obj_ltype.value+"&page_no="+parent.pg+"&league_id="+parent.sel_league+"&set_account="+obj_set_account.value;
 }
 function chg_retime()
 {
  var obj_retime = document.getElementById('retime');
  TimeValue = obj_retime.value;
  if(ReloadTimeID)
   clearInterval(ReloadTimeID);
  if(TimeValue != -1)
  {
   parent.body_var.location.reload();
   ReloadTimeID = setInterval("parent.body_var.location.reload()",TimeValue*1000);
  }
 }
 function chg_page(page_type)
 {
  var obj_retime = document.getElementById('retime');
  var url_str = 'real_wagers.php?uid=<?=$uid?>&rtype='+page_type+'&retime='+obj_retime.value;
  self.location = url_str;
 }
function onUnload()
 {
  if(ReloadTimeID) clearInterval(ReloadTimeID);
  parent.loading = 'Y';
  parent.ShowType = '';
  parent.pg=0;
  parent.sel_league='';
 }


 function chg_account(set_account){
	var obj_league = document.getElementById('sel_lid');
 	parent.body_var.location="./real_wagers_var.php?uid=<?=$uid?>&rtype="+parent.stype_var+"&set_account="+set_account+"&league_id="+obj_league.value+"&page_no="+parent.pg;
 }
 function go_web(sw1,sw2,sw3) {
     if(sw1==1 && sw2==5){Go_Chg_pass(1);}
     else{window.open('/sc_corp/trans.php?sw1='+sw1+'&sw2='+sw2+'&sw3='+sw3,'main');}
 }
</SCRIPT>
</head>
<link rel=stylesheet type=text/css href="/style/nav/css/zzsc.css">
<script src="/style/nav/js/jquery.min.js" type="text/javascript"></script>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()" onUnload="onUnload()">
<div id="firstpane" class="menu_list" style="float:left;padding-right: 10px;width: 230px;">
    <p class="menu_head current" style="width: 223px;">Đặt cược tức thì</p>
    <div style="display:block" class=menu_body >
        <a onClick="go_web(0,0,'/sc_corp/real_wager/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Bóng đá</a>
        <a onClick="go_web(0,1,'/sc_corp/real_wager_BK/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Bóng rổ/sắc đẹp</a>
        <a onClick="go_web(0,0,'/sc_corp/real_wager_TN/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Quần vợt</a>
        <a onClick="go_web(0,0,'/sc_corp/real_wager_VB/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Bóng chuyền</a>
        <a onClick="go_web(0,0,'/sc_corp/real_wager_BS/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Bóng chày</a>
    </div>
    <p class="menu_head" style="width: 223px;">Ghi chú bữa sáng</p>
    <div style="display:none" class=menu_body >
        <a onClick="go_web(0,1,'/sc_corp/real_wager_FU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Bữa sáng bóng đá</a>
        <a onClick="go_web(0,1,'/sc_corp/real_wager_BU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Ăn sáng/làm đẹp</a>
        <a onClick="go_web(0,1,'/sc_corp/real_wager_BSFU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Bữa sáng bóng chày</a>
        <a onClick="go_web(0,0,'/sc_corp/real_wager_TU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Bữa sáng quần vợt</a>
        <a onClick="go_web(0,0,'/sc_corp/real_wager_VU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Bữa sáng bóng</a>
    </div>
    <p class="menu_head" style="width: 223px;">Quản lý ghi chú</p>
    <div style="display:none" class=menu_body >
        <a onClick="go_web(1,1,'/sc_corp/wager_list/voucher.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Hóa đơn chảy</a>
        <a onClick="go_web(1,1,'/sc_corp/wager_list/aceept.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Ghi chú bất thường</a>
        <a onClick="go_web(1,2,'/sc_corp/wager_list/danger_list.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Nguy hiểm khi</a>
        <a onClick="go_web(1,3,'/sc_corp/wager_list/real_list.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">Lưu ý</a>
    </div>
</div>
<script type=text/javascript>
    $(document).ready(function(){
        $("#firstpane .menu_body:eq(0)").show();
        $("#firstpane p.menu_head").click(function(){
            $(this).addClass("current").next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
            $(this).siblings().removeClass("current");
        });
        $("#secondpane .menu_body:eq(0)").show();
        $("#secondpane p.menu_head").mouseover(function(){
            $(this).addClass("current").next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
            $(this).siblings().removeClass("current");
        });

    });
</script>
<FORM NAME="REFORM" ACTION="" METHOD=POST style="margin-top:10px;float: left;">
  <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="60" >&nbsp;&nbsp;<?=$rel_contorl?>:</td>
            <td>
              <select id="ltype" name="ltype" onChange="chg_ltype()" class="za_select">
                <option value="1">Giỏ A</option>
                <option value="2">Giỏ B</option>
                <option value="3">Giỏ C</option>
                <option value="4">Giỏ D</option>
              </select>
            </td>
            <td width="65"> -- <?=$rel_reload?></td>
            <td>
              <select id="retime" name="retime" onChange="chg_retime()" class="za_select">
                <option value="-1" ><?=$rel_refresh?></option>
				<option value="180" >180 sec</option>
              </select>
            </td>
            <td id="dt_now"> -- <?=$rel_dtnow?>:</td>
						<td>&nbsp;--&nbsp;<a href="#" onClick="chg_page('all');" onMouseOver="window.status='Độc thân tất cả'; return true;" onMouseOut="window.status='';return true;" style="background-color:<?=$back_all?>">Độc thân tất cả</a>
							&nbsp;<a href="#" onClick="chg_page('ou');" onMouseOver="window.status='Độc thân'; return true;" onMouseOut="window.status='';return true;" style="background-color:<?=$back_ou?>">Độc thân</a>
							&nbsp;<a href="#" onClick="chg_page('r4');" onMouseOver="window.status='Một phần'; return true;" onMouseOut="window.status='';return true;" style="background-color:<?=$back_rq4?>">Một phần</a>
							&nbsp;<a href="#" onClick="chg_page('re');" onMouseOver="window.status='Cán bóng'; return true;" onMouseOut="window.status='';return true;" style="background-color:<?=$back_re?>">Cán bóng</a>
							&nbsp;<a href="#" onClick="chg_page('par');" onMouseOver="window.status='Vượt qua'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_par?>">Vượt qua</a>
						</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" height="4"></td>
    </tr>
  </table>
  <table height="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width='70'><font color="#000099">&nbsp;&nbsp;<?=$caption?></font></td>
		<td>Cách xem&nbsp;<select id="set_account" name="set_account" onChange="chg_account(this.value);" class="za_select">
        		<option value="0">Tất cả</option>
			<option value="1">Sở hữu</option>
			<!--option value="2">公司</option-->
		</select></td>
	</tr>
  </table>
  <div id="LoadLayer" style="position:absolute; width:1020px; height:500px; z-index:1; background-color: #F3F3F3; layer-background-color: #F3F3F3; border: 1px none #000000; visibility: visible">
    <div align="center" valign="middle">
    loading...............................................................................
  </div>
</div>
<table id="glist_table" border="0" cellspacing="1" cellpadding="0"  bgcolor="2A73AC" class="m_tab" width="<?=$width?>">
    <tr class="m_title_bk">
    <?=$table?>
    </tr>
</table>
</form>
</body>
</html>
