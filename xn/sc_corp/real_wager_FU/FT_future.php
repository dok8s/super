<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$retime=$_REQUEST['retime'];
$gdate=$_REQUEST['gdate'];

$rtype=strtoupper(trim($_REQUEST['rtype']));
$sql = "select * from web_super where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
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
case "OU":
	$caption=$rel_straight;
	$width="838";
	$back_ou="#3399ff";
	$table='    <td width = "38"> Thời gian </td>
     <td width = "52" nowrap> Liên minh </td>
     <td width = "28"> Sự kiện </td>
     <td width = "200"> Nhóm </td>
     <td width = "195"> Đưa bóng / ghi chú </td>
     <td width = "195"> Kích thước / ghi chú nhỏ </td>
     <td width = "130"> giành chiến thắng một mình </td>';
	break;
case "V":
	$caption=$rel_hsthalf;
	$rtype='HOU';
	$width="838";
	$back_hou="#3399ff";
    $table = '<td width = "38"> Thời gian </td>
     <td width = "52" nowrap> Liên minh </td>
     <td width = "28"> Sự kiện </td>
     <td width = "200"> Nhóm </td>
     <td width = "195"> Đưa bóng / ghi chú </td>
     <td width = "195"> Kích thước / ghi chú nhỏ </td>
     <td width = "130"> giành chiến thắng một mình </td> ';
	break;
case "PD":
	$caption=$rel_correct;
	$back_pd="#3399ff";
	$width="835";
    $table = '<td width = "38"> Thời gian </td>
     <td width = "28"> Liên minh </td>
     <td width = "151"> Máy chủ và nhóm khách </td>
     <td width = "80"> Ghi chú / Số tiền </td>
    <td>1:0</td>
    <td>2:0</td>
    <td>2:1</td>
    <td>3:0</td>
    <td>3:1</td>
    <td>3:2</td>
    <td>4:0</td>
    <td>4:1</td>
    <td>4:2</td>
    <td>4:3</td>
    <td>0:0</td>
    <td>1:1</td>
    <td>2:2</td>
    <td>3:3</td>
    <td>4:4</td>
    <td width="25">up5</td>';
	break;
case "HPD":
	$caption='Nửa trên';
	$back_hpd="#3399ff";
	$width="835";
    $table = '<td width = "38"> Thời gian </td>
     <td width = "28"> Liên minh </td>
     <td width = "151"> Máy chủ và nhóm khách </td>
     <td width = "80"> Ghi chú / Số tiền </td>
    <td>1:0</td>
    <td>2:0</td>
    <td>2:1</td>
    <td>3:0</td>
    <td>3:1</td>
    <td>3:2</td>
    <td>4:0</td>
    <td>4:1</td>
    <td>4:2</td>
    <td>4:3</td>
    <td>0:0</td>
    <td>1:1</td>
    <td>2:2</td>
    <td>3:3</td>
    <td>4:4</td>
    <td width="25">up5</td>';
	break;
case "EO":
	$caption=$rel_total;
	$back_eo="#3399ff";
	$width="718";
    $table = '<td width = "38"> Thời gian </td>
     <td width = "200"> Máy chủ và nhóm khách </td>
     <td width = "80"> Đơn </td>
     <td width = "80"> đôi </td>
    <td width="80">0~1</td>
    <td width="80">2~3</td>
    <td width="80">4~6</td>
    <td width="80">7up</td>';
	break;
case "F":
	$caption=$rel_halffull;
	$width="835";
	$back_f="#3399ff";
    $table = '<td width = "38"> Thời gian </td>
     <td width = "52" nowrap> Liên minh </td>
     <td width = "200"> Máy chủ và nhóm khách </td>
     <td width = "80"> Ghi chú / Số tiền </td>
     <td> Thạc sĩ / Thạc sĩ </td>
     <td> Chính / và </td>
     <td> Máy chủ / Khách </td>
     <td> và / chính </td>
     <td> và / và </td>
     <td> và / khách </td>
     <td> Khách / Chúa </td>
     <td> Khách / và </td>
     <td> Khách / Khách </td> ';
	break;
case "P":
	$caption=$rel_parlay;
	$width="438";
	$back_par="#3399ff";
    $table = '<td width = "38"> Thời gian </td>
     <td width = "52" nowrap> Liên minh </td>
     <td width = "28"> Sự kiện </td>
     <td width = "200"> Nhóm </td>
     <td width = "120"> vượt qua </td> ';
	break;
}
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<SCRIPT LANGUAGE="JAVASCRIPT1.2">
document.onkeypress=checkfunc;
function checkfunc(e) {
	switch(event.keyCode){

	}
}

 var ReloadTimeID;
 function onLoad()
 {
  parent.loading = 'N';
  parent.ShowType = '<?=$rtype?>';
  var obj_ltype = document.getElementById('ltype');
  obj_ltype.value = parent.ltype;
  var obj_gdate = document.getElementById('gdate');
  obj_gdate.value = parent.gdate;
  var obj_retime = document.getElementById('retime');
  obj_retime.value = <?=$retime?>;
  parent.body_var.location = "./FT_future_var.php?uid="+parent.uid+"&rtype=<?=$rtype?>&page_no=<?=$page?>&gdate="+obj_gdate.value;
  parent.pg=0;
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
  parent.body_var.location="./FT_future_var.php?uid="+parent.uid+"&rtype=<?=$rtype?>&gdate="+obj_gdate.value+"&ltype="+obj_ltype.value+"&page_no="+parent.pg+"&league_id="+parent.sel_league+"&set_account="+obj_set_account.value;
 }

  function chg_gdate()
 {
  var obj_gdate = document.getElementById('gdate');
  var obj_set_account = document.getElementById('set_account');
  parent.body_var.location="./FT_future_var.php?uid="+parent.uid+"&rtype=<?=$rtype?>&gdate="+obj_gdate.value+"&ltype="+parent.ltype+"&set_account="+obj_set_account.value;
  parent.pg=0;
  parent.sel_league="";
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
  var obj_gdate = document.getElementById('gdate');
  var url_str = 'FT_future.php?uid='+parent.uid+'&rtype='+page_type+'&retime='+obj_retime.value+'&gdate='+obj_gdate.value;
  self.location = url_str;
 }

 function onUnload()
 {
  if(ReloadTimeID) clearInterval(ReloadTimeID);
  parent.loading = 'Y';
  parent.ShowType = '';
  parent.pg=0;
  parent.sel_league="";
 }

function chg_pg(pg)
{
	var obj_set_account = document.getElementById('set_account');
	if (pg==parent.pg)return;
	parent.pg=pg;
	parent.loading_var = 'Y';
	parent.body_var.location = "./FT_future_var.php?uid="+parent.uid+"&rtype="+parent.stype_var+"&langx="+parent.langx+"&ltype="+parent.ltype+"&page_no="+parent.pg+"&set_account="+obj_set_account.value+"&gdate="+parent.gdate;
}
function chg_league(){
	var obj_set_account = document.getElementById('set_account');
	obj_pg = document.getElementById('pg_txt');
	var obj_league = document.getElementById('sel_lid');
	parent.sel_league=obj_league.value;
	parent.ShowGameList();
	parent.body_var.location = "./FT_future_var.php?uid="+parent.uid+"&rtype="+parent.stype_var+"&langx="+parent.langx+"&ltype="+parent.ltype+"&league_id="+obj_league.value+"&set_account="+obj_set_account.value+"&gdate="+parent.gdate;
	parent.pg=0;
}

 function chg_account(set_account){
	var obj_league = document.getElementById('sel_lid');
 	parent.body_var.location="./FT_future_var.php?uid="+parent.uid+"&rtype="+parent.stype_var+"&set_account="+set_account+"&league_id="+obj_league.value+"&page_no="+parent.pg+"&gdate="+parent.gdate;
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
<FORM NAME="REFORM" ACTION="" METHOD=POST  style="margin-top:10px;float: left;">
  <table width="780" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="60" nowrap>&nbsp;&nbsp;Giao dịch trực tuyến:</td>
            <td>
              <select id="ltype" name="ltype" onChange="chg_ltype()" class="za_select">
                <option value="1">Chân A</option>
                <option value="2">Chân B</option>
                <option value="3">Chân C</option>
                <option value="4">Chân D</option>
              </select>
            </td>
            <td width="65" nowrap> -- Sắp xếp lại:</td>
            <td>
              <select id="retime" name="retime" onChange="chg_retime()" class="za_select">
                <option value="-1" >Chưa cập</option>
                <option value="180" >180 sec</option>
              </select>
            </td>
            <td nowrap> --Ngày tháng:
              <select id="gdate" name="gdate" onChange="chg_gdate()" class="za_select">
<?
for ($i=1;$i<12;$i++){
	echo '<option value="'.date('Y-m-d',time()+$i*24*60*60).'">'.date('Y-m-d',time()+$i*24*60*60).'</option>';

}
?>

              </select>
            </td>
            <td id="dt_now" nowrap> -- Giờ miền đông:</td>
            <td nowrap> -- <A HREF="#" onClick="chg_page('ou');" onMouseOver="window.status='<?=$rel_straight?>'; return true;" onMouseOut="window.status='';return true;" style="background-color: <?=$back_ou?>"><?=$rel_straight?></a>
              &nbsp;<A HREF="#" onClick="chg_page('v');" onMouseOver="window.status='<?=$rel_hsthalf?>'; return true;" onMouseOut="window.status='';return true;" style="background-color:<?=$back_hou?>"><?=$rel_hsthalf?></a>
              &nbsp;<A HREF="#" onClick="chg_page('pd');" onMouseOver="window.status='<?=$rel_correct?>'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_pd?>"><?=$rel_correct?></a>
              &nbsp;<A HREF="#" onClick="chg_page('hpd');" onMouseOver="window.status='Nửa trên'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_hpd?>">Nửa trên</a>
              &nbsp;<a href="#" onClick="chg_page('f');" onMouseOver="window.status='<?=$rel_halffull?>'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_f?>"><?=$rel_halffull?></a>
              &nbsp;<A HREF="#" onClick="chg_page('eo');" onMouseOver="window.status='Tổng số điểm'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_eo?>">Tổng số điểm</a>
              &nbsp;<A HREF="#" onClick="chg_page('p');" onMouseOver="window.status='<?=$rel_parlay?>'; return true;" onMouseOut="window.status='';return true;"style="background-color:<?=$back_par?>"><?=$rel_parlay?></a>
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
			<!--<option value="2">公司</option>-->
		</select></td>
		<td>&nbsp;Chọn liên minh <span id="show_h"></span></td>
		<td width='450'>&nbsp;&nbsp;<span id="pg_txt"></span></td>
	</tr>
  </table>
  <div id="LoadLayer" style="position:absolute; width:1020px; height:500px; z-index:1; background-color: #F3F3F3; layer-background-color: #F3F3F3; border: 1px none #000000; visibility: visible">
    <div align="center" valign="middle">
    loading...............................................................................
  </div>
</div>
  <table id="glist_table" border="0" cellspacing="1" cellpadding="0"  bgcolor="C2C2A6" class="m_tab" width="<?=$width?>">
    <tr class="m_title_ft_future">
    <?=$table?>
    </tr>
  </table>
</form>

<span id="bowling" style="position:absolute; display: none">
	<option value="*LEAGUE_ID*" *SELECT*>*LEAGUE_NAME*</option>
</span>
<span id="bodyH" style="position:absolute; display: none">
        <select id="sel_lid" name="sel_lid" onChange="chg_league();" class="za_select">
        <option value="">Tất cả</option>
		*SHOW_H*
       	</select>
</span>
<span id="bodyP" style="position:absolute; display: none">
  Trang:&nbsp;*SHOW_P*
</span>

</body>
</html>