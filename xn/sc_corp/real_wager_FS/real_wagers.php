<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
$uid=$_REQUEST['uid'];
$sql = "select Agname,ID,language from web_super where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$row = mysql_fetch_array($result);
$agname=$row['Agname'];
$agid=$row['ID'];
$langx=$row['language'];
require ("../../member/include/traditional.$langx.inc.php");
?>
<html>
<head>
<title>main</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<style>
<!--
.za_text_f {background-color: #FFFFFF;font-size: 12px;border-style: solid; border-width: 0; padding: 0 0; margin:  2px}
.za_text_f_close {background-color: #CCCCCC;font-size: 12px;border-style: solid; border-width: 0; padding: 0 0; margin: 2px}
-->
</style>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<SCRIPT>
var ReloadTimeID;
function onLoad(){
	parent.loading = 'N';
	parent.ShowType = 'FS';
	var obj_ltype = document.getElementById('ltype');
	obj_ltype.value = parent.ltype;
	var obj_retime = document.getElementById('retime');
	obj_retime.value = -1;
	parent.body_var.location = "./real_wagers_var.php?uid=<?=$uid?>&rtype=fs";
	if(obj_retime.value != -1)
		ReloadTimeID = setInterval("parent.body_var.location.reload()",obj_retime.value*1000);
}

function reload_var(){
	parent.body_var.location.reload();
}

function chg_ltype(){
	var obj_ltype = document.getElementById('ltype');
	var obj_set_account = document.getElementById('set_account');
	parent.body_var.location="./real_wagers_var.php?uid=<?=$uid?>&rtype=fs&ltype="+obj_ltype.value+"&set_account="+obj_set_account.value;
}

function chg_retime(){
	var obj_retime = document.getElementById('retime');
	TimeValue = obj_retime.value;
	if(ReloadTimeID) {clearInterval(ReloadTimeID);}
	if(TimeValue != -1){
		parent.body_var.location.reload();
		ReloadTimeID = setInterval("parent.body_var.location.reload()",TimeValue*1000);
	}
}

function chg_page(page_type){
	var obj_retime = document.getElementById('retime');
	var url_str = 'real_wagers.php?uid=<?=$uid?>&rtype='+page_type+'&retime='+obj_retime.value;
	self.location = url_str;
}

function show_bet(bet_str) {
	document.all["bet_title"].innerHTML ="<font color=#FFFFFF>"+bet_str+"</font>";
	bet_window.style.top=document.body.scrollTop+event.clientY-50;
	bet_window.style.left=document.body.scrollLeft+event.clientX-20;
	document.all["bet_window"].style.display = "block";
	setTimeout("close_win(2)", 10000);
}

function close_win(cw) {
	switch(cw){
		case(1):document.all["rs_window"].style.display = "none";
		break;
		case(2):document.all["bet_window"].style.display = "none";
		break;
	}
}

function onUnload(){
	if(ReloadTimeID) clearInterval(ReloadTimeID);
	parent.loading = 'Y';
	parent.ShowType = '';
}

function chg_account(set_account){
	parent.body_var.location="./real_wagers_var.php?uid=<?=$uid?>&rtype="+parent.stype_var+"&set_account="+set_account;
}

function chg_gtype(){
	var gametype = document.getElementById("game_type").value;
	top.game_type = gametype;
	parent.ShowGameList();
}

function get_new_top(){
	top.game_type = document.getElementById("game_type").value;
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
<div id="main_body" style="margin-top:10px;float: left;">
  <table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="">
        <table border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="60" >&nbsp;&nbsp;�u�W�޽L:</td>
            <td>
              <select id="ltype" name="ltype" onChange="chg_ltype()" class="za_select">
                <option value="1">�a�xA</option>
                <option value="2">�a�xB</option>
                <option value="3">�a�xC</option>
                <option value="4">�a�xD</option>
              </select>
            </td>
            <td width="65">&nbsp;--&nbsp;���s��z:</td>
            <td>
              <select id="retime" name="retime" onChange="chg_retime()" class="za_select">
                <option value="-1">����s</option>
				<option value="180" >180 sec</option>
              </select>
            </td>
            <td id="dt_now"></td>
            <td>&nbsp;--&nbsp;</td>
            <td>
            	<select id="game_type" name="game_type" onchange="chg_gtype();" class="za_select">
            		<option value="">����</option>
            		<option value="FT">���y</option>
            		<option value="BK">�x�y</option>
            		<option value="TN">���y</option>
            		<option value="VB">�Ʋy</option>
            	</select>
            </td>
            <!--td> -- <A HREF="#" onClick="chg_page('ou');" onMouseOver="window.status='�榡'; return true;" onMouseOut="window.status='';return true;" style="background-color:">�榡</a>
              &nbsp;<A HREF="#" onClick="chg_page('hou');" onMouseOver="window.status='�W�b��'; return true;" onMouseOut="window.status='';return true;"style="background-color:">�W�b��</a>
              &nbsp;<A HREF="#" onClick="chg_page('re');" onMouseOver="window.status='���a'; return true;" onMouseOut="window.status='';return true;"style="background-color:">�u�y</a>
              &nbsp;<A HREF="#" onClick="chg_page('pd');" onMouseOver="window.status='�i�x'; return true;" onMouseOut="window.status='';return true;"style="background-color:">�i�x</a>
              &nbsp;<A HREF="#" onClick="chg_page('eo');" onMouseOver="window.status='�`�J�y'; return true;" onMouseOut="window.status='';return true;"style="background-color:">�`�J�y</a>
              &nbsp;<A HREF="#" onClick="chg_page('f');" onMouseOver="window.status='�b����'; return true;" onMouseOut="window.status='';return true;"style="background-color: ">�b����</a>
              &nbsp;<A HREF="#" onClick="chg_page('par');" onMouseOver="window.status='�L��'; return true;" onMouseOut="window.status='';return true;"style="background-color:">�L��</a>
              &nbsp;<A HREF="#" onClick="chg_page('fs');" onMouseOver="window.status='�S��'; return true;" onMouseOut="window.status='';return true;"style="background-color:#3399FF">�S��</a>
              &nbsp;<A HREF="#" onClick="chg_page('p');" onMouseOver="window.status='�w�}��'; return true;" onMouseOut="window.status='';return true;"style="background-color:">�w�}��</a>
            </td-->
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2" height="4"></td>
    </tr>
    <tr>
      <td colspan="2"><font color="#000099">&nbsp;&nbsp;�S��&nbsp;&nbsp;</font>
		�[�ݤ覡&nbsp;<select id="set_account" name="set_account" onchange="chg_account(this.value);" class="za_select">
        		<option value="0">����</option>
			<option value="1">�ۤv</option>
		</select></td>
    </tr>
  </table>
  <div id="LoadLayer" style="position:absolute; width:1020px; height:500px; z-index:1; background-color: #F3F3F3; layer-background-color: #F3F3F3; border: 1px none #000000; visibility: visible">
    <div align="center" valign="middle">
    loading...............................................................................
  </div>
</div>
  <table id="glist_table" width="835" border="0" cellspacing="1" cellpadding="0"  bgcolor="006255" class="m_tab">
    <tr class="m_title_ft"  >
    <td width="38" >�ɶ�</td>
    <td width="100">�p��</td>
    <td>����/�߲v</td>
    </tr>
  </table>
</div>
<div id="update_msg" style="display: none"><br><br><center>��s��............</center></div>
</body>
</html>