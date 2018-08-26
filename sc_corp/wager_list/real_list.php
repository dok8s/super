<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
$active	=	$_REQUEST['active'];
$uid		=	$_REQUEST['uid'];
$id			=	$_REQUEST['id'];
$gdate		=	$_REQUEST["gdate"];

if($gdate==''){$gdate=date('Y-m-d');}

$gtype	=	$_REQUEST['gtype'];
$voucher=strtoupper($_REQUEST["voucher"]);
$sql = "select id,subuser,agname,subname,status,edit from web_super where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
$agname=$row['agname'];
$edit=$row['edit'];

$search=$_REQUEST['search'];
$search_value=$_REQUEST['search_data'];

if($gdate==''){
	$gdate=date('Y-m-d');
}
if ( $active == 10 )
{
				$sql = "update web_db_io set danger=3,(Status=1 or Status=2)0,result_type=0 where id=".$id;
				mysql_db_query( $dbname, $sql );
}
else if ( $active == 11 )
{
				$sql = "update web_db_io set danger=2,(Status=1 or Status=2)1,result_type=0 where id=".$id;
				mysql_db_query( $dbname, $sql );
}
else
{
				$sql = "update web_db_io set status=".$active.",result_type=0 where id={$id}";
				mysql_db_query( $dbname, $sql );
}

switch($search){
case 2:
	$sql=" corprator='$search_value'";
	break;
case 3:
	$sql=" world='$search_value'";
	break;
case 4:
	$sql=" agents='$search_value'";
	break;
case 5:
	$sql=" m_name='$search_value'";
	break;
case 6:
	$voucher=strtoupper($search_value);
	if(substr($voucher,0,1)=='P'){
		if(substr($voucher,0,2)=='PR'){
			$id=substr($voucher,2,strlen($voucher)-2)+965782;
		}else{
			$id=substr($voucher,1,strlen($voucher)-1)+988782;
		}
	}else if(substr($voucher,0,2)=='OU'){
		$id=substr($voucher,2,strlen($voucher)-2);
	}else if(substr($voucher,0,2)=='DT'){
		$id=substr($voucher,2,strlen($voucher)-2)+902714;
	}
	$id=$id+100000000;
	$sql="	date_format(BetTime,'%m%d%H%i%s')+id=$id";
	break;
case 7:
	$sql=" result_type=1 ";
	break;
case 8:
	$sql=" bettime='$search_value' ";
	break;
}
$tt=" m_date='$gdate' and super='$agname' and ".$sql;

$mysql="select status,QQ526738,result_type,danger,cancel,id,mid,linetype,date_format(BetTime,'%m-%d <br> %H:%i:%s') as BetTime,date_format(BetTime,'%m%d%H%i%s')+id as bid,M_Name,TurnRate,BetType,M_result,Middle,BetScore,gwin,odd_type from web_db_io where $tt order by bettime desc";
//echo $mysql;
$result = mysql_query( $mysql);

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/css.css" type="text/css">
<style type="text/css">
<!--
.m_ag_ed {  background-color: #bdd1de; text-align: right}
-->
</style>
<SCRIPT>
function onLoad()
 {
  var obj_enable = document.getElementById('search');
  obj_enable.value = '<?=$search?>';
 }
function reload()
{

	self.location.href='real_list.php?uid=<?=$uid?>&search=<?=$search?>&search_data=<?=$search_value?>&gdate=<?=$gdate?>';
}
function go_web(sw1,sw2,sw3) {
    if(sw1==1 && sw2==5){Go_Chg_pass(1);}
    else{window.open('/sc_corp/trans.php?sw1='+sw1+'&sw2='+sw2+'&sw3='+sw3,'main');}
}
</script></head>
<SCRIPT>window.setTimeout("reload()", 60000);</SCRIPT>
<link rel=stylesheet type=text/css href="/style/nav/css/zzsc.css">
<script src="/style/nav/js/jquery.min.js" type="text/javascript"></script>
<body oncontextmenu="window.event.returnValue=false" bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" onLoad="onLoad()";>

<div id="firstpane" class="menu_list" style="padding-right: 10px;width: 230px;margin-top:10px;float: left;">
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
<form name=FTR action="" method=post style="margin-top:10px;float: left;">
<table width="880" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="" width="850">&nbsp;线上操盘－
      	<input name=button type=button class="za_button" onClick="reload()" value="更新"><font color="#cc0000">请输入查询条件:</font>
      	<select name="search" class="za_select">
            <option value="">不指定</option>
            <option value="2">股东</option>
            <option value="3">总代理</option>
            <option value="4">代理商</option>
            <option value="5">会员</option>
            <option value="6">注单号</option>
            <option value="7">已结算</option>
            <option value="8">投注时间</option>
          </select>
          <input type="text" size=16 name="search_data" value="<?=$search_value?>">
					投注日期
					<select name="gdate" class="za_select">
					<?
					$dd = 24*60*60;
					$t = time();
					for($i=0;$i<=28;$i++)
					{
						$today=date('Y-m-d',$t);
						if ($gdate==date('Y-m-d',$t)){
							echo "<option value='$today' selected>".date('Y-m-d',$t)."</option>";
						}else{
							echo "<option value='$today'>".date('Y-m-d',$t)."</option>";
						}
					$t -= $dd;
					}
					?>
          </select>

					<INPUT class=za_button type=submit value=查询 name=SUBMIT>
        	</td>
    </tr>
  </table>
</form><BR>
<table width="910" border="0" cellspacing="1" cellpadding="0" class="m_tab" bgcolor="#000000">
 <tr class="m_title_ft">
  <td width="70"align="center">投注时间</td>
  <td width="100" align="center">流水单号</td>
  <td width="100" align="center">用户名称</td>
  <td width="100" align="center">球赛种类</td>
  <td width="230" align="center">內容</td>
  <td width="70" align="center">投注</td>
  <td width="70" align="center">可赢金额</td>
  <td width="70" align="center">结果</td>
  <td width="100" align="center">操作</td>
</tr>
        <?

				//	while ($row = mysql_fetch_array($result))
				{
						$url1='';
					?>
        <tr class="m_rig">
          <td align="center"><?=$row['BetTime']?></td>
 					<td align="center"><?=show_voucher($row['linetype'],$row['bid'])?></td>
          <td align="center"><?=$row['M_Name']?>&nbsp;&nbsp;<font color="#cc0000"> <?=$row['TurnRate']?></font></td>
          <td align="center"><?=$row['BetType']?><br><font color=green><?=$ODDS[$row['odd_type']]?></font>
          	<?
						switch($row['danger']){
						case 1:
							echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;确认中&nbsp;</b></font></font>';
							break;
						case 2:
							echo '<br><font color=#ffffff style=background-color:#ff0000><b>未确认</b></font></font>';
							break;
						case 3:
							echo '<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;确认&nbsp;</b></font></font>';
							break;
						default:
							break;
						}
						?>
					</td>
					<td align="right"><?
						if ($row['linetype']==7 or $row['linetype']==8){
							$midd=explode('<br>',$row['Middle']);
							$ball=explode('<br>',$row['QQ526738']);

							for($t=0;$t<(sizeof($midd)-1)/2;$t++){
								echo $midd[2*$t].'<br>';
								if($row['result_type']==1){
									echo '<font color="#009900"><b>'.$ball[$t].'</b></font>  ';
															}else{
								echo getscore($row['mid'],$row['active'],$row['showtype'],$row['LineType'],$dbname);
}
								echo $midd[2*$t+1].'<br>';
							}
						}else{
							$midd=explode('<br>',$row['Middle']);
							for($t=0;$t<sizeof($midd)-1;$t++){
								echo $midd[$t].'<br>';
							}
							if($row['result_type']==1){
								echo '<font color="#009900"><b>'.$row['QQ526738'].'</b></font>  ';
							}
							echo $midd[sizeof($midd)-1];
						}
						?></td>
          <td align="center"><?=$row['BetScore']?></td>
          <td align="center"><?=$row['gwin']?></td>
          <td align="center"><?=number_format($row['M_result'],1)?></td>
          <td align="center">
		  <?php
		if($edit==1){
				echo "<DIV class=menu2 onMouseOver=\"this.className='menu1'\" onmouseout=\"this.className='menu2'\">\r\n          <div align=\"center\"><FONT color=red><b>";
				echo $wager_vars[$row['status']];
				echo "<b></FONT></div>\r\n          <UL style=\"LEFT: 28px\">\r\n\t\t\t\t\t";
				if ( $row['LineType'] == 9 || $row['LineType'] == 10 || $row['LineType'] == 19 || $row['LineType'] == 30 )
				{
								$wager = $wager_vars_re;
				}
				else if ( $row['LineType'] == 7 || $row['LineType'] == 8 )
				{
								$wager = $wager_vars_p;
				}
				else
				{
								$wager = $wager_vars;
				}
			foreach($wager as $key=>$value){
				if ( $value != "" ) {
					echo "             <LI><A href=\"real_list.php?uid=";
					echo $uid;
					echo "&id=";
					echo $row['id'];
					echo "&active=";
					echo $key;
					echo "&search_data=";
					echo $search_value;
					echo "&gdate=";
					echo $gdate;
					echo "&search=";
					echo $search;
					echo "\" target=_self>";
					echo $value;
					echo "</A>";
				}
			}
			echo "</UL></DIV>";
		}
		else{
			echo "<div align=\"center\"><b>";
			echo $wager_vars[$row['status']];
			echo "<b></div>";
		}
		  ?>
		  
		  </td>
        </tr>
<?
}
?>
</table>
</BODY>
</html>

</html>