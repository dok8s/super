<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require_once( "../../member/include/config.inc.php" );
require_once( "../../member/include/define_function_list.inc.php" );

$id = intval($_REQUEST['id']);
$active = $_REQUEST['active'];

$username = $_REQUEST['username'];
$gdate = $_REQUEST['gdate'];

$uid = $_REQUEST['uid'];
$result=mysql_query( "select agname,edit,setdata from web_super where oid='$uid'" );
$row = mysql_fetch_array($result);
$edit=$row['edit'];
$agname=$row['agname'];
$admin_name="总后台/".$agname;
$setdata = @unserialize($row['setdata']);
$cou = mysql_num_rows($result);
if ( $cou == 0 ){
	exit( );
}
if($setdata['d0_wager_add_edit']!=1 && $setdata['d0_wager_hide_edit']!=1 && $edit!=1){
	exit();
}
$notshowip = $setdata['d0show_memip']!=1;

$mysql = "select *,date_format(BetTime,'%m%d%H%i%s')+id as WID from web_db_io where id='$id'";
$result = mysql_db_query( $dbname, $mysql );
$row = mysql_fetch_array( $result );

$is_r = in_array($row['LineType'],array(1,4,11,51,52,2,3,12,13,9,10,19,30));
$is_p = in_array($row['LineType'],array(17));

if (!$is_r){
	echo "<script>alert('此类不支持修改');location='javascript:history.back(1)';</script>";
}

if($row['LineType']==4){
$score=explode('<FONT COLOR=#0000BB><b>',$row['Middle']);
$msg=explode("</b></FONT>",$score[1]);
$bcd=$msg[0];
}
else{
$score=explode('<FONT color=red><b>',$row['Middle']);
$msg=explode("</b></FONT><br>",$score[1]);
$bcd=explode(":",$msg[0]);
}

if($active=='save'){
	$BetTime = trim($_REQUEST['BetTime']);
	$Betbcd = explode(":",trim($_REQUEST['Betbcd']));
	$BetScore = trim($_REQUEST['BetScore']);
	$new_place = trim($_REQUEST['M_Place']);
	$new_rate = trim($_REQUEST['M_Rate']);
	$BetIP = trim($_REQUEST['BetIP']);	
	if(count($bcd)==2 && count($Betbcd)==2){
		$bcd[0]=intval($bcd[0]);
		$bcd[1]=intval($bcd[1]);
		$Betbcd[0]=intval($Betbcd[0]);
		$Betbcd[1]=intval($Betbcd[1]);
		if($bcd[0]==$Betbcd[0] && $bcd[1]==$Betbcd[1]){
		}else{
			$old = "<FONT color=red><b>$bcd[0]:$bcd[1]</b></FONT>";
			$new = "<FONT color=red><b>$Betbcd[0]:$Betbcd[1]</b></FONT>";
			
			$row['Middle']    = str_replace($old, $new, $row['Middle']);
			$row['Middle_tw'] = str_replace($old, $new, $row['Middle_tw']);
			$row['Middle_en'] = str_replace($old, $new, $row['Middle_en']);
			
			$row['Middle1']    = str_replace($old, $new, $row['Middle1']);
			$row['Middle1_tw'] = str_replace($old, $new, $row['Middle1_tw']);
			$row['Middle1_en'] = str_replace($old, $new, $row['Middle1_en']);
			
			$row['Middle2']    = str_replace($old, $new, $row['Middle2']);
			$row['Middle2_tw'] = str_replace($old, $new, $row['Middle2_tw']);
			$row['Middle2_en'] = str_replace($old, $new, $row['Middle2_en']);
			$bcd = $Betbcd;
		}
	}
	if(strlen($row['M_Place'])>0){
		$P0 = strtoupper($row['M_Place'][0]);
		if($P0=='U' or $P0=='O'){
			if($P0=='U'){
				if(substr($row['M_Place'],0,5)=='Under')
				{
					$P0='Under';
				}
			}
			if($P0=='O'){
				if(substr($row['M_Place'],0,4)=='Over')
				{
					$P0='Over';
				}
		 	
			}
			$new_place = $P0.$new_place;
		}
		if(strpos($new_place, '/')){
			$arr=explode('/', $new_place);
			$new_place = trim($arr[0]).' / '.trim($arr[1]);
		}
		if($new_place!='' && $new_place != $row['M_Place']){
			$sql_place = ",M_Place='$new_place'";
			if($P0=='O' or $P0=='U' or $P0=='Over' or $P0=='Under'){
				$arrcn['Over']='大';
				$arrcn['Under']='小';
				$arrtw['Over']='大';
				$arrtw['Under']='小';
				$arrcn['O']='大';
				$arrcn['U']='小';
				$arrtw['O']='大';
				$arrtw['U']='小';
				
				$old = trim_OU($row['M_Place']);
				$new = trim_OU($new_place);
				
				$row['Middle']=str_replace($arrcn[$P0].$old, $arrcn[$P0].$new, $row['Middle']);
				$row['Middle_tw'] = str_replace($arrtw[$P0].$old, $arrtw[$P0].$new, $row['Middle_tw']);
				$row['Middle_en'] = str_replace($P0.$old, $P0.$new, $row['Middle_en']);
				
				$row['Middle1']=str_replace($arrcn[$P0].$old, $arrcn[$P0].$new, $row['Middle1']);
				$row['Middle1_tw'] = str_replace($arrtw[$P0].$old, $arrtw[$P0].$new, $row['Middle1_tw']);
				$row['Middle1_en'] = str_replace($P0.$old, $P0.$new, $row['Middle1_en']);
				
				$row['Middle2']=str_replace($arrcn[$P0].$old, $arrcn[$P0].$new, $row['Middle2']);
				$row['Middle2_tw'] = str_replace($arrtw[$P0].$old, $arrtw[$P0].$new, $row['Middle2_tw']);
				$row['Middle2_en'] = str_replace($P0.$old, $P0.$new, $row['Middle2_en']);
				
				
				
			}else{
				$old = "<FONT COLOR=#cc0000><b>$row[M_Place]</b></FONT>";
				$new = "<FONT COLOR=#cc0000><b>$new_place</b></FONT>";
				$old1 = "<FONT COLOR=#0000BB><b>$row[M_Place]</b></FONT>";
				$new1 = "<FONT COLOR=#0000BB><b>$new_place</b></FONT>";
				$old2 = "<FONT COLOR=#CC0000><b>$row[M_Place]</b></FONT>";
				$new2 = "<FONT COLOR=#CC0000><b>$new_place</b></FONT>";
				
				$row['Middle']    = str_replace($old, $new, $row['Middle']);
				$row['Middle_tw'] = str_replace($old, $new, $row['Middle_tw']);
				$row['Middle_en'] = str_replace($old, $new, $row['Middle_en']);
				
				$row['Middle']    = str_replace($old2, $new2, $row['Middle']);
				$row['Middle_tw'] = str_replace($old2, $new2, $row['Middle_tw']);
				$row['Middle_en'] = str_replace($old2, $new2, $row['Middle_en']);
				
				$row['Middle1']    = str_replace($old, $new, $row['Middle1']);
				$row['Middle1_tw'] = str_replace($old, $new, $row['Middle1_tw']);
				$row['Middle1_en'] = str_replace($old, $new, $row['Middle1_en']);
				
				$row['Middle1']    = str_replace($old2, $new2, $row['Middle1']);
				$row['Middle1_tw'] = str_replace($old2, $new2, $row['Middle1_tw']);
				$row['Middle1_en'] = str_replace($old2, $new2, $row['Middle1_en']);
				
				$row['Middle2']    = str_replace($old1, $new1, $row['Middle2']);
				$row['Middle2_tw'] = str_replace($old1, $new1, $row['Middle2_tw']);
				$row['Middle2_en'] = str_replace($old1, $new1, $row['Middle2_en']);
				
			}			
		}
	}
	
	
	$new_rate_tmp = in_array($row['LineType'],array(1,4,11,51,52)) ? $new_rate-1 : $new_rate;
	$gwin = $new_rate>0 ? $BetScore*$new_rate_tmp : $BetScore;
	$gwin = round($gwin,2);
	
	$old_rate_middle = "@&nbsp;<FONT color=#cc0000><b>".$row['M_Rate']."</b></FONT>";
	$new_rate_middle = "@&nbsp;<FONT color=#cc0000><b>".$new_rate."</b></FONT>";
	$old_rate_middle1 = "@&nbsp;<FONT COLOR=#cc0000><b>".$row['M_Rate']."</b></FONT>";
	
	$lines2 = str_replace($old_rate_middle, $new_rate_middle, $row['Middle']);
	$lines2_tw = str_replace($old_rate_middle, $new_rate_middle, $row['Middle_tw']);
	$lines2_en = str_replace($old_rate_middle, $new_rate_middle, $row['Middle_en']);
	
	$lines3 = str_replace($old_rate_middle, $new_rate_middle, $row['Middle1']);
	$lines3_tw = str_replace($old_rate_middle, $new_rate_middle, $row['Middle1_tw']);
	$lines3_en = str_replace($old_rate_middle, $new_rate_middle, $row['Middle1_en']);
	
	$lines4 = str_replace($old_rate_middle, $new_rate_middle, $row['Middle2']);
	$lines4_tw = str_replace($old_rate_middle, $new_rate_middle, $row['Middle2_tw']);
	$lines4_en = str_replace($old_rate_middle, $new_rate_middle, $row['Middle2_en']);
	
	$lines2 = str_replace($old_rate_middle1, $new_rate_middle, $lines2);
	$lines2_tw = str_replace($old_rate_middle1, $new_rate_middle, $lines2_tw);
	$lines2_en = str_replace($old_rate_middle1, $new_rate_middle, $lines2_en);
	
	$lines3 = str_replace($old_rate_middle1, $new_rate_middle, $lines3);
	$lines3_tw = str_replace($old_rate_middle1, $new_rate_middle, $lines3_tw );
	$lines3_en = str_replace($old_rate_middle1, $new_rate_middle, $lines3_en );
	
	$lines4 = str_replace($old_rate_middle1, $new_rate_middle, $lines4);
	$lines4_tw = str_replace($old_rate_middle1, $new_rate_middle, $lines4_tw);
	$lines4_en = str_replace($old_rate_middle1, $new_rate_middle, $lines4_en);
	
	$auth_code = md5( trim( $lines2_tw ).$BetScore.$row['Mtype'] );
	if($row['LineType']==4){
				$old1 = "<FONT COLOR=#cc0000><b>$bcd</b></FONT>";
				$new1 = "<FONT COLOR=#cc0000><b>$new_place</b></FONT>";
				$old2 = "<FONT COLOR=#0000BB><b>$bcd</b></FONT>";
				$new2 = "<FONT COLOR=#0000BB><b>$new_place</b></FONT>";
			
				$lines2    = str_replace($old1, $new1, $lines2);
				$lines2_tw= str_replace($old1, $new1, $lines2_tw);
				$lines2_en = str_replace($old1, $new1, $lines2_en);
				
				$lines3    = str_replace($old1, $new1, $lines3);
				$lines3_tw= str_replace($old1, $new1, $lines3_tw);
				$lines3_en = str_replace($old1, $new1, $lines3_en);
				
				$lines4    = str_replace($old2, $new2, $lines4);
				$lines4_tw= str_replace($old2, $new2, $lines4_tw);
				$lines4_en = str_replace($old2, $new2, $lines4_en);
				
				$ss=explode(':',$new_place);
				$mtype='MB'.$ss[0].'TG'.$ss[1];
				$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=2,edit='1',auth_code='{$auth_code}',vgold=0,result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0, BetTime='{$BetTime}',BetScore='{$BetScore}',gwin='{$gwin}'  $sql_place,m_rate='{$new_rate}',mtype='$mtype',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."',middle1='".$lines3."',middle1_tw='".$lines3_tw."',middle1_en='".$lines3_en."',middle2='".$lines4."',middle2_tw='".$lines4_tw."',middle2_en='".$lines4_en."',BetIP='$BetIP' where id='$id' ";
	}
	else
	{
		if($row['m_result']==''){
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=2,edit='1',auth_code='{$auth_code}',vgold=0,result_type=0,m_result='',a_result='',result_c='',result_a='',result_s='',status=0, BetTime='{$BetTime}',BetScore='{$BetScore}',gwin='{$gwin}'  $sql_place,m_rate='{$new_rate}',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."',middle1='".$lines3."',middle1_tw='".$lines3_tw."',middle1_en='".$lines3_en."',middle2='".$lines4."',middle2_tw='".$lines4_tw."',middle2_en='".$lines4_en."',BetIP='$BetIP' where id='$id' ";
		}
	else{
			$mysql="update web_db_io set  G_Name='".$admin_name."',G_Type=2,edit='1',auth_code='{$auth_code}',vgold=0,result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0, BetTime='{$BetTime}',BetScore='{$BetScore}',gwin='{$gwin}'  $sql_place,m_rate='{$new_rate}',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en."',middle1='".$lines3."',middle1_tw='".$lines3_tw."',middle1_en='".$lines3_en."',middle2='".$lines4."',middle2_tw='".$lines4_tw."',middle2_en='".$lines4_en."',BetIP='$BetIP' where id='$id' ";
		}
	
	}
	mysql_query( $mysql );
	
	if($row['result_type']==1 and $row['pay_type']==1){
		$aa=$row['BetScore']+$row['M_Result'];
		$sql="update web_members set money=$money-$aa where m_name='".$row['M_Name']."'";
		mysql_db_query($dbname, $sql);
	}
	
	$mysql = "select *,date_format(BetTime,'%m%d%H%i%s')+id as WID from web_db_io where id='$id'";
	$result = mysql_query( $mysql );
	$row = mysql_fetch_array( $result );

	echo "<script>alert('修改成功');</script>";
	//$bcd=$new_place;
}

function trim_OU($str){	
	$str=str_replace('over','',$str);
	$str=str_replace('under','',$str);
	$str=str_replace('Over','',$str);
	$str=str_replace('Under','',$str);
	$str=str_replace('o','',$str);
	$str=str_replace('u','',$str);
	$str=str_replace('O','',$str);
	$str=str_replace('U','',$str);
	return $str;
}
?>
<html>
<head>
<title></title>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
</HEAD>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
<form name="myFORM" method="post" action=""><BR><BR>
<table width="660" border="0" cellspacing="1" cellpadding="0" class="m_tab" bgcolor="#000000">
  <tr class="m_title_ft">
	  <td width="60" align="center">投注时间</td>
	  <td width="90" align="center">用户名称</td>
	  <td width="100" align="center">球赛种类</td>
	  <td width="230" align="center">內容</td>
	  <td width="70" align="center">投注</td>
	  <td width="70" align="center">可赢金额</td>
  </tr>
  <tr class="m_rig">
	  <td align="center"><?=str_replace(' ','<BR>',$row['BetTime'])?></td>
	  <td align="center"><?=$row['M_Name']?>&nbsp;&nbsp;<font color="#cc0000"> <?=$row['TurnRate']?></font>
	  <br><font color=blue><?=show_voucher( $row['linetype'], $row['WID'] )?></font></td>
	  <td align="center"><?=$row['BetType']?></td>
	  <td align="right"><?=$row['Middle']?></td>
	  <td align="center"><?=$row['BetScore']?></td>
	  <td align="center"><?=$row['Gwin']?></td>
  </tr>
</table>
<BR><BR>
<table width="230" border="0" cellspacing="0" cellpadding="0" class="m_tab" bgcolor="#000000">
  <tr class="m_rig">
	  <td width="80" align="center">下注时间：</td> <td><INPUT TYPE="text" NAME="BetTime" value="<?=$row['BetTime']?>"></td>
  </tr>
  <? if(count($bcd)==2){ ?>
  <tr class="m_rig">
	  <td width="80" align="center">下注比分：</td> <td><INPUT TYPE="text" NAME="Betbcd" value="<?="$bcd[0]:$bcd[1]"?>"></td>
  </tr>
  <? } ?>
  <tr class="m_rig">
	  <td width="80" align="center">交易金额：</td> <td><INPUT TYPE="text" NAME="BetScore" value="<?=$row['BetScore']?>"></td>
  </tr>
  <? if($is_r && strlen($row['M_Place'])>0){ ?>
  <tr class="m_rig">
	  <td width="80" align="center">盘口：</td> <td><INPUT TYPE="text" NAME="M_Place" value="<?=trim_OU($row['M_Place'])?>"></td>
  </tr>
  <? } ?>
  <? if($row['LineType']==4){?>
  <tr class="m_rig">
	  <td width="80" align="center">盘口：</td> <td><INPUT TYPE="text" NAME="M_Place" value="<?=$bcd?>"></td>
  </tr>
  <? }?>
  <? if($is_r){ ?>
  <tr class="m_rig">
	  <td width="80" align="center">赔率：</td> <td><INPUT TYPE="text" NAME="M_Rate" value="<?=$row['M_Rate']?>"></td>
  </tr>  
  <? } ?>
  <tr class="m_rig" <? if($notshowip)echo 'style="display:none"'; ?>>
	  <td width="80" align="center">IP：</td> <td><INPUT TYPE="text" NAME="BetIP" value="<?=$row['BetIP']?>"></td>
  </tr>
</table>
<table width="230" border="0" cellspacing="0" cellpadding="0" class="m_tab" bgcolor="#000000">
  <tr class="m_rig">
	  <td align="center">
		<BR><INPUT TYPE="submit" value="保存修改">
		&nbsp; &nbsp; &nbsp;<INPUT TYPE="button" VALUE=" 返回 " ONCLICK="self.location='hide_list.php?uid=<?=$uid?>&username=<?=$username?>&gdate=<?=$gdate?>'"></td>
  </tr>
</table>
<INPUT TYPE="hidden" NAME="active" value="save">
</form>