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
$id=$_REQUEST["id"];
$sort=$_REQUEST["sort"];
$orderby=$_REQUEST["orderby"];

$page=$_REQUEST["page"];
if ($page==''){
	$page=0;
}
$active=$_REQUEST["active"];
if ($sort==""){
	$sort='bettime';
}

if ($orderby==""){
	$orderby='desc';
}

$active=$_REQUEST["active"];
$sql = "select * from web_super where Oid='$uid' and oid<>''";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$setdata = @unserialize($row['setdata']);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}else{

$agname=$row['Agname'];
$super=$row['super'];

$sql = "select status,odd_type,cancel,danger,id,M_Name,TurnRate,cancel,M_Date,date_format(BetTime,'%m-%d <br> %H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,LineType,BetType,Middle,BetScore,Gwin from web_db_io where super='$agname' and result_type=0  and hidden=0 order by ".$sort." ".$orderby;

$result = mysql_query($sql);
$cou=mysql_num_rows($result);
$page_size=20;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";

$result = mysql_query( $mysql);
$sql = "select wager,wager_sec from web_system";
$result4 = mysql_query($sql);
$row4 = mysql_fetch_array($result4);

$wager_sec=$row4['wager_sec']*1000;

?>
<script>if(self == top) parent.location='/'</script>
<HTML>
<HEAD>
<TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/mem_body_ft.css" type="text/css">
<link rel="stylesheet" href="/style/control/mem_body_his.css" type="text/css">
<META content="Microsoft FrontPage 4.0" name=GENERATOR>
<script src="/js/prototype.js" type="text/javascript"></script>
<SCRIPT>

 function onLoad()
 {

  var obj_page = document.getElementById('page');
  obj_page.value = '<?=$page?>';
  var obj_sort=document.getElementById('sort');
  obj_sort.value='<?=$sort?>';
  var obj_orderby=document.getElementById('orderby');
  obj_orderby.value='<?=$orderby?>';
 }

function refresh(){
	self.location.href='voucher.php?uid=<?=$uid?>&sort=<?=$sort?>&orderby=<?=$orderby?>&page=<?=$page?>';
}
function reload()
{
    var url = './showrecord.php';
    var pars = 'uid=<?=$uid?>';
    var myAjax = new Ajax.Request(
    url,{
        method: 'get',
        parameters: pars,
        onComplete: show3RecordResponse
    }
    );
}
function show3RecordResponse(originalRequest){
    var strRecord = originalRequest.responseText;
    if(strRecord!=0){
 			self.location.href='voucher.php?uid=<?=$uid?>&sort=<?=$sort?>&orderby=<?=$orderby?>&page=<?=$page?>';
    }else{		
    	window.setTimeout("self.reload()",<?=$wager_sec?>);		
    }
}
 function go_web(sw1,sw2,sw3) {
     if(sw1==1 && sw2==5){Go_Chg_pass(1);}
     else{window.open('/sc_corp/trans.php?sw1='+sw1+'&sw2='+sw2+'&sw3='+sw3,'main');}
 }
</script>


<SCRIPT>window.setTimeout("self.reload()",<?=$wager_sec?>);</SCRIPT>


</HEAD>
<link rel=stylesheet type=text/css href="/style/nav/css/zzsc.css">
<script src="/style/nav/js/jquery.min.js" type="text/javascript"></script>
<!--onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false" -->
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" onLoad="onLoad()">
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
<form name="myFORM" method="post" action="voucher.php?uid=<?=$uid?>" style="margin-top:10px;float: left;">
<table width="773" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td width="3">&nbsp;
          </td>
    <td class="">Cá cược nước --
	  <input name=button type=button class="za_button" onClick="refresh()" value="Cập nhật"></td>
    <td class="m_tline"> Sắp xếp：            <select name="sort" onChange="document.myFORM.submit();" class="za_select">
            <option value="bettime">Thời gian</option>
            <option value="betscore">Số tiền</option>
            <option value="m_name">Tên thành viên</option>
            <option value="bettype">Loại cược</option>

          </select>
              <select name="orderby" onChange="self.myFORM.submit()" class="za_select">
            <option value="asc">Tăng dần(Từ nhỏ đến lớn)</option>
            <option value="desc">Giảm dần(Lớn đến nhỏ)</option>
          </select>
</td>
        <td class="m_tline" align="right">Hiển thị<?=($page)*20?>-<?=($page+1)*20?>Ghi lại，Tổng <?=$cou?> Ghi lại　Đến đầu <select name='page' onChange="self.myFORM.submit()">
<?
		if ($page_count==0){$page_count=1;}
		for($i=0;$i<$page_count;$i++){
			if ($i==$page){
				echo "<option selected value='$i'>".($i+1)."</option>";
			}else{
				echo "<option value='$i'>".($i+1)."</option>";
			}
		}
		?></select>
            Trang，Tổng <?=$page_count?> Trang </td>
  </tr>
  <tr>
    <td colspan="3" height="4"></td>
  </tr>
</table>
<table width="778" border="0" cellspacing="1" cellpadding="0" class="m_tab" bgcolor="#000000">

        <tr class="m_title_ft">
            <td width = "61" align = "center"> Thời gian đặt cược </td>
            <td width = "90" align = "center"> Số đang chạy </td>
            <td width = "90" align = "center"> Tên người dùng </td>
            <td width = "60" align = "center"> Các loại trò chơi </td>
            <td width = "200" align = "center"> Nội dung </td>
            <td width = "100" align = "center"> Đặt cược </td>
            <td width = "100" align = "center"> Số tiền có thể thắng </td>
        </tr>
<?
$ODDS=Array(
	'H'=>'Tấm Hồng Kông<br>',
	'M'=>'Món ăn Malay<br>',
	'I'=>'Tấm Indonesia<br>',
	'E'=>'Đĩa châu Âu<br>'
);
while ($row = mysql_fetch_array($result))
{
?>
	<tr class="m_rig">
          <td align="center"><?=$row['BetTime'];?></td>
	  <td align="center"><?=show_voucher($row['LineType'],$row['ID'])?><br><font color=green><?=$ODDS[$row['odd_type']]?></font></td>
          <td align="center"><?=$row['M_Name']?>&nbsp;&nbsp;<font color="#cc0000"> <?=$row['TurnRate']?></font></td>
          <td align="center"><?=str_replace(" ","",$row['BetType']);?>
<?
switch($row['danger']){
case 1:
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;Xác nhận&nbsp;</b></font></font>';
	break;
case 2:
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>Chưa được</b></font></font>';
	break;
case 3:
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;Xác nhận&nbsp;</b></font></font>';
	break;
default:
	break;

}

?>
</td>
          <td align="right"><?=$row['ShowTop'];?><?=$row['Middle'];?></td>
<td><?
$wager_vars_re=array('Đặt cược thông thường',
    'Đặt cược không bình thường',
    'Hủy mục tiêu',
    'Hủy thẻ đỏ',
    'Vòng eo sự kiện',
    'Tiện ích mở rộng sự kiện',
    'Lỗi tỷ lệ cược',
    'Sự kiện không có pk / giờ làm thêm',
    'Player abstaining',
    'Lỗi tên nhóm',
    'lưu ý xác nhận',
    'Đặt cược chưa được xác nhận',
    'Hủy');
    	if($row['status']>0){
    		echo '<s>'.number_format($row['BetScore'],1).'</s>';
    	}else{
    		echo number_format($row['BetScore'],1);
    	}?></td>

      <td>
      	<?
    	if($row['status']>0){
    		echo '<b><font color=red>['.$wager_vars_re[$row['status']].']</td>';
    	}else{
    		echo number_format($row['Gwin'],1);
    	}?>
		</td>
        </tr>
<?
}
?>
     </table>
</form>
</BODY>
</html>
<?
}
$loginfo='<font color=red>Luồng truy vấn</font>';
$ip_addr = $_SERVER['REMOTE_ADDR'];
$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','0')";
mysql_query($mysql);

?>
