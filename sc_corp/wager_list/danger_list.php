<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$uid			=	$_REQUEST["uid"];
$id				=	$_REQUEST["id"];
$sort			=	$_REQUEST["sort"];
$gdate			=	$_REQUEST["gdate"];
$orderby	=	$_REQUEST["orderby"];
$page			=	$_REQUEST["page"]+0;
$danger		=	$_REQUEST["danger"]+0;
$active		=	$_REQUEST["active"]+0;
$result_type		=	$_REQUEST["result"]+0;

if($gdate==''){$gdate=date('Y-m-d');}
if($danger==0){$danger=1;}

if ($sort==""){
	$sort='bettime';
}

if ($orderby==""){
	$orderby='desc';
}

$sql = "select id,subuser,agname,subname,status from web_super where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
$agname=$row['agname'];


switch($active){
case 3:
	$sql='select betscore,m_result,m_name,pay_type from web_db_io where id='.$id;
	$result = mysql_query( $sql);
	$row = mysql_fetch_array($result);
	if ($row['pay_type']==1){
		if ($row['m_result']==''){
			$sql="update web_member set money=money+$row[betscore] where memname='".$row[m_name]."'";
		}else{
			$sql="update web_member set money=money-$row[m_result] where memname='".$row[m_name]."'";
		}
		mysql_query( $sql);
	}else{
		$sql="update web_member set money=money+$row[betscore] where memname='".$row[m_name]."'";
		mysql_query( $sql);
	}

	$mysql="delete from web_db_io where id=".$id;
	mysql_query($mysql);
	break;
case 2:
	$sql='select betscore,m_result,m_name,pay_type from web_db_io where id='.$id;
	$result = mysql_query( $sql);
	$row = mysql_fetch_array($result);
	if ($row['pay_type']==1){
		if ($row['m_result']==''){
			$sql="update web_member set money=money+$row[betscore] where memname='".$row[m_name]."'";
		}else{
			$sql="update web_member set money=money-$row[m_result] where memname='".$row[m_name]."'";
		}
		mysql_query( $sql);
	}

	$sql='update web_db_io set vgold=0,m_result=0,a_result=0,result_c=0,cancel=1 where id='.$id;
	mysql_query( $sql);
	break;
case 4:
	$sql="update web_db_io set danger=3 where id=$id";
	mysql_query( $sql);
	break;
case 5:
	$sql="update web_db_io set danger=3 where id=$id";
	mysql_query( $sql);
	break;
case 7:
	$sql="update web_db_io set danger=2 where id=$id";
	mysql_query( $sql);
	break;
case 6:
	$sql="update web_db_io set danger=2 where id=$id";
	mysql_query( $sql);
	break;
}


$sql = "select odd_type,danger,id,M_Name,TurnRate,cancel,M_Date,date_format(BetTime,'%m-%d <br> %H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as ID,LineType,BetType,Middle,BetScore,Gwin from web_db_io where danger=$danger and result_type=$result_type and m_date='$gdate' and super='$agname' and hidden=0 order by ".$sort." ".$orderby;
$result = mysql_query($sql);
$cou=mysql_num_rows($result);
$page_size=20;
$page_count=ceil($cou/$page_size);
$offset=$page*$page_size;
$mysql=$sql."  limit $offset,$page_size;";

$result = mysql_query( $mysql);

?>
<script>if(self == top) parent.location='/'</script>
<HTML>
<HEAD>
<TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<META content="Microsoft FrontPage 4.0" name=GENERATOR>
<SCRIPT>

 function onLoad()
 {

  var obj_page = document.getElementById('page');
  obj_page.value = '<?=$page?>';
  //var obj_sort=document.getElementById('sort');
  //obj_sort.value='<?=$sort?>';
  //var obj_orderby=document.getElementById('orderby');
  //obj_orderby.value='<?=$orderby?>';
  var obj_orderby=document.getElementById('gdate');
  obj_orderby.value='<?=$gdate?>';
 var obj_result=document.getElementById('result');
  obj_result.value='<?=$result_type?>';

 var obj_danger=document.getElementById('danger');
  obj_danger.value='<?=$danger?>';
 }

 function CheckSTOP(str)
{
if(confirm("确认更改本注单状态吗?"))
 		document.location=str;
	}
	function CheckDEL(str)
	{
		if(confirm("确实删除本注单吗?"))
		document.location=str;
	}
	function reload()
{

	self.location.href='danger_list.php?uid=<?=$uid?>&gdate=<?=$gdate?>&result=<?=$result_type?>&danger=<?=$danger?>&orderby=<?=$orderby?>&page=<?=$page?>';
}
 function go_web(sw1,sw2,sw3) {
     if(sw1==1 && sw2==5){Go_Chg_pass(1);}
     else{window.open('/sc_corp/trans.php?sw1='+sw1+'&sw2='+sw2+'&sw3='+sw3,'main');}
 }
</script>
<SCRIPT>window.setTimeout("self.location.href='danger_list.php?uid=<?=$uid?>&gdate=<?=$gdate?>&result=<?=$result_type?>&sort=<?=$sort?>&orderby=<?=$orderby?>&page=<?=$page?>&danger=<?=$danger?>'", 15000);</SCRIPT>
</HEAD>
<link rel=stylesheet type=text/css href="/style/nav/css/zzsc.css">
<script src="/style/nav/js/jquery.min.js" type="text/javascript"></script>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" onLoad="onLoad()">
<div id="firstpane" class="menu_list" style="float:left;padding-right: 10px;width: 230px;">
    <p class="menu_head current" style="width: 185px;">即时注单</p>
    <div style="display:block" class=menu_body >
        <a onClick="go_web(0,0,'/sc_corp/real_wager/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">足球</a>
        <a onClick="go_web(0,1,'/sc_corp/real_wager_BK/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">篮球/美足</a>
        <a onClick="go_web(0,0,'/sc_corp/real_wager_TN/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">网球</a>
        <a onClick="go_web(0,0,'/sc_corp/real_wager_VB/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">排球</a>
        <a onClick="go_web(0,0,'/sc_corp/real_wager_BS/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">棒球</a>
    </div>
    <p class="menu_head" style="width: 185px;">早餐注单</p>
    <div style="display:none" class=menu_body >
        <a onClick="go_web(0,1,'/sc_corp/real_wager_FU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">足球早餐</a>
        <a onClick="go_web(0,1,'/sc_corp/real_wager_BU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">篮球/美足早餐</a>
        <a onClick="go_web(0,1,'/sc_corp/real_wager_BSFU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">棒球早餐</a>
        <a onClick="go_web(0,0,'/sc_corp/real_wager_TU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">网球早餐</a>
        <a onClick="go_web(0,0,'/sc_corp/real_wager_VU/index.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">排球早餐</a>
    </div>
    <p class="menu_head" style="width: 185px;">注单管理</p>
    <div style="display:none" class=menu_body >
        <a onClick="go_web(1,1,'/sc_corp/wager_list/voucher.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">流水注单</a>
        <a onClick="go_web(1,1,'/sc_corp/wager_list/aceept.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">异常注单</a>
        <a onClick="go_web(1,2,'/sc_corp/wager_list/danger_list.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">走地危险</a>
        <a onClick="go_web(1,3,'/sc_corp/wager_list/real_list.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">注单查询</a>
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
<form name="myFORM" method="post" action="danger_list.php?uid=<?=$uid?>" style="margin-top:10px;float: left;">
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td width="3">&nbsp;
          </td>
    <td class="">走地危险球 --
	  <input name=button type=button class="za_button" onClick="reload()" value="更新"></td>
    <td class="m_tline">        日期:
        <select class=za_select onchange=document.myFORM.submit(); name=gdate>
				<option value=""></option>
				<?
$dd = 24*60*60;
$t = time();
$aa=0;
$bb=0;
for($i=0;$i<=7;$i++)
{
	$today=date('Y-m-d',$t);
	if ($date_start==date('Y-m-d',$t)){
		echo "<option value='$today' selected>".date('Y-m-d',$t)."</option>";
	}else{
		echo "<option value='$today'>".date('Y-m-d',$t)."</option>";
	}
$t -= $dd;
}
?>
			</select><!-- 排序：            <select name="sort" onChange="document.myFORM.submit();" class="za_select">
            <option value="bettime">投注时间</option>
            <option value="betscore">投注金额</option>
            <option value="m_name">会员名称</option>
            <option value="bettype">投注种类</option>

          </select>
              <select name="orderby" onChange="self.myFORM.submit()" class="za_select">
            <option value="asc">升序(由小到大)</option>
            <option value="desc">降序(由大到小)</option>
          </select--><select name="danger" onChange="self.myFORM.submit()" class="za_select">
            <option value="1">确认中</option>
            <option value="3">确认</option>
            <option value="2">未确认</option>
          </select>
          <select name="result" onChange="self.myFORM.submit()" class="za_select">
            <option value="0">未结算</option>
            <option value="1">已结算</option>
          </select>
</td>
        <td class="m_tline" align="right">显示第1-25条记录，共 <?=$cou?> 条记录　到第 <select name='page' onChange="self.myFORM.submit()">
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
页，共 <?=$page_count?> 页 </td>
  </tr>
  <tr>
    <td colspan="3" height="4"></td>
  </tr>
</table>
<table width="770" border="0" cellspacing="1" cellpadding="0" class="m_tab" bgcolor="#000000">

        <tr class="m_title_ft">
          <td width="61"align="center">投注时间</td>
          <td width="99" align="center">流水号</td>
          <td width="99" align="center">用户名称</td>
          <td width="72" align="center">球赛种类</td>
          <td width="189" align="center">內容</td>
          <td width="80" align="center">投注</td>
          <td width="80" align="center">结果</td>
        </tr>
<?
while ($row = mysql_fetch_array($result))
{
?>
	<tr class="m_rig">
          <td align="center"><?=$row['BetTime'];?></td>
	  <td align="center"><?=show_voucher($row['LineType'],$row['ID'])?><br><font color=green><?=$ODD[$row['odd_type']]?></font></td>
          <td align="center"><?=$row['M_Name']?>&nbsp;&nbsp;<font color="#cc0000"> <?=$row['TurnRate']?></font></td>
          <td align="center"><?=str_replace(" ","",$row['BetType']);?>
<?
switch($row['danger']){
case 1:
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;确认中&nbsp;</b></font></font>';
	$url1="<a href=javascript:CheckSTOP('danger_list.php?uid=$uid&id=$row[id]&active=4')>转确认</a> / <a href=javascript:CheckSTOP('danger_list.php?uid=$uid&id=$row[id]&active=7')>转未确认</a>";
	break;
case 2:
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>未确认</b></font></font>';
	$url1="<a href=javascript:CheckSTOP('danger_list.php?uid=$uid&id=$row[id]&active=5')>转确认</a>";
	break;
case 3:
	echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;确认&nbsp;</b></font></font>';
	$url1="<a href=javascript:CheckSTOP('danger_list.php?uid=$uid&id=$row[id]&active=6')>转未确认</a>";
	break;
default:
	break;

}
?>
</td>
          <td align="right"><?=$row['ShowTop'];?><?=$row['Middle'];?></td>
          <td align="center"><?=number_format($row['BetScore'],2);?></td>
          <td align="center"><?=number_format($row['m_result'],2);?></td>
       </tr>
<?
}
?>
     </table>
</form>
</BODY>
</html>
<?

	$loginfo='查询走地危险球列表';
	$ip_addr = $_SERVER['REMOTE_ADDR'];
	$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','0')";
	mysql_query($mysql);
?>