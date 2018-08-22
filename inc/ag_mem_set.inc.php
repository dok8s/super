<?

$action=$_REQUEST["act"];
$rtype=strtoupper($_REQUEST['rtype']);
$sc=$_REQUEST['SC'];
$so=$_REQUEST['SO'];
$st=$_REQUEST['war_set'];
$kind=$_REQUEST['kind'];

$mysql = "select * from web_agents where Agname='$aid'";

$ag_result = mysql_query($mysql);
$ag_row = mysql_fetch_array($ag_result);
$agents_id=$ag_row["ID"];
$agents_name=$ag_row["Agname"];


if ($action=='Y'){	
	$ag_scene=$kind.'_'.$rtype."_Scene";
	$ag_bet=$kind.'_'.$rtype."_Bet";
	$agscene=$ag_row[$ag_scene];
	$agbet=$ag_row[$ag_bet];
	
	if ($sc>$agscene){
		echo wterror("此会员的单场限额已超过代理商的单场限额，请回上一面重新输入");
		exit();
	}
	if ($so>$agbet){
		echo wterror("此会员的单注限额已超过代理商的单注限额，请回上一面重新输入");
		exit();
	}

	$mysql="update web_member set ".$kind.'_'.$rtype."_Scene='".$sc."',".$kind.'_'.$rtype."_Bet='".$so."',".$kind.'_'."Turn_".$rtype."='".$st."' where id=$mid";
	mysql_query($mysql) or die ("操作失败!");
}

$sql = "select * from web_member where ID=$mid";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$opentype=$row['OpenType'];

$r_turn='FT_Turn_R_'.$opentype;
$r_turn=$ag_row[$r_turn];
$ou_turn='FT_Turn_OU_'.$opentype;
$ou_turn=$ag_row[$ou_turn];
$re_turn='FT_Turn_RE_'.$opentype;
$re_turn=$ag_row[$re_turn];
$rou_turn='FT_Turn_ROU_'.$opentype;
$rou_turn=$ag_row[$rou_turn];
$eo_turn='FT_Turn_EO_'.$opentype;
$eo_turn=$ag_row[$eo_turn];

//////////////////////////////
$vb_r_turn='VB_Turn_R_'.$opentype;
$vb_turn=$ag_row[$vb_r_turn];
$vb_ou_turn='VB_Turn_OU_'.$opentype;
$vb_ou_turn=$ag_row[$vb_ou_turn];
$vb_re_turn='VB_Turn_RE_'.$opentype;
$vb_re_turn=$ag_row[$vb_re_turn];
$vb_rou_turn='VB_Turn_ROU_'.$opentype;
$vb_rou_turn=$ag_row[$vb_rou_turn];
$vb_eo_turn='VB_Turn_EO_'.$opentype;
$vb_eo_turn=$ag_row[$vb_eo_turn];
////////////////////////
$bs_r_turn='BS_Turn_R_'.$opentype;
$bs_r_turn=$ag_row[$bs_r_turn];
$bs_ou_turn='BS_Turn_OU_'.$opentype;
$bs_ou_turn=$ag_row[$bs_ou_turn];
$bs_re_turn='BS_Turn_RE_'.$opentype;
$bs_re_turn=$ag_row[$bs_re_turn];
$bs_rou_turn='BS_Turn_ROU_'.$opentype;
$bs_rou_turn=$ag_row[$bs_rou_turn];
$bs_eo_turn='BS_Turn_EO_'.$opentype;
$bs_eo_turn=$ag_row[$bs_eo_turn];
////////////////////////
$tn_r_turn='TN_Turn_R_'.$opentype;
$tn_r_turn=$ag_row[$tn_r_turn];
$tn_ou_turn='TN_Turn_OU_'.$opentype;
$tn_ou_turn=$ag_row[$tn_ou_turn];
$tn_re_turn='TN_Turn_RE_'.$opentype;
$tn_re_turn=$ag_row[$tn_re_turn];
$tn_rou_turn='TN_Turn_ROU_'.$opentype;
$tn_rou_turn=$ag_row[$tn_rou_turn];
$tn_eo_turn='TN_Turn_EO_'.$opentype;
$tn_eo_turn=$ag_row[$tn_eo_turn];

/////////////////////
$bk_r_turn='BK_Turn_R_'.$opentype;
$bk_r_turn=$ag_row[$bk_r_turn];
$bk_ou_turn='BK_Turn_OU_'.$opentype;
$bk_ou_turn=$ag_row[$bk_ou_turn];
$bk_eo_turn='BK_Turn_EO_'.$opentype;
$bk_eo_turn=$ag_row[$bk_eo_turn];

$bk_re_turn='BK_Turn_RE_'.$opentype;
$bk_re_turn=$ag_row[$bk_re_turn];

$bk_rou_turn='BK_Turn_ROU_'.$opentype;
$bk_rou_turn=$ag_row[$bk_rou_turn];

	
function turn_rate($start_rate,$rate_split,$end_rate,$sel_rate){
	$turn_rate='';
	
	for($i=$start_rate;$i<$end_rate+$rate_split;$i+=$rate_split){
		if ($turn_rate==''){
			$turn_rate='<option>'.$i.'</option>';
		}else if($i==$sel_rate){
			$turn_rate=$turn_rate.'<option selected>'.$i.'</option>';
		}else{
			$turn_rate=$turn_rate.'<option>'.$i.'</option>';
		}
	}
	return $turn_rate;
}
?>
<script>if(self == top) parent.location='/'</script>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<style type="text/css">
<!--
.m_ag_ed {  background-color: #bdd1de; text-align: right}
-->
</style>
<SCRIPT LANGUAGE="JAVASCRIPT1.2" src="/js/mem_set.js"></SCRIPT>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
 <INPUT TYPE=HIDDEN NAME="id" VALUE="228509">
  <INPUT TYPE=HIDDEN NAME="sid" VALUE="{SID}">
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr>  
    <td class="m_tline">&nbsp;&nbsp;<?=$mnu_member?><?=$mem_setopt?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;帐号:<?=$row['Memname']?> 
      -- 会员名称:<?=$row['Alias']?> -- 盘口:<?=$row['OpenType']?> -- 使用币别:<?=$row['CurType']?> -- <?=$rep_pay_type?>: <?
	  if ($row['pay_type']==0){
	  	echo $rep_pay_type_c;
	  }else{
  	  	echo $rep_pay_type_m;
	  }
	  ?> --  <a href="./ag_members.php?uid=<?=$uid?>">回上一页</a></td>
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit"> 
    <td>足球 </td>
    <td width="68">让球</td>
    <td width="68">大小</td>
    <td width="68">滚球</td>
    <td width="68">滚球大小</td>
    <td width="68">单双</td>
    <td width="68">滚球独赢</td>
    <td width="68">独赢</td>
    <td width="68">标准过关</td>
    <td width="68">让球过关</td>
    <td width="68">综合过关</td>
    <td width="68">波胆</td>
    <td width="68">入球</td>
    <td width="68">半全场</td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right" class="m_ag_ed" nowrap>退水设定</td>
    <td><?=$row['FT_Turn_R']?></td>
    <td><?=$row['FT_Turn_OU']?></td>
    <td><?=$row['FT_Turn_RE']?></td>
    <td ><?=$row['FT_Turn_ROU']?></td>
    <td><?=$row['FT_Turn_EO']?></td>
    <td><?=$row['FT_Turn_RM']?></td>
    <td><?=$row['FT_Turn_M']?></td>
    <td><?=$row['FT_Turn_P']?></td>
    <td><?=$row['FT_Turn_PR']?></td>
    <td><?=$row['FT_Turn_PC']?></td>
    <td><?=$row['FT_Turn_PD']?></td>
    <td><?=$row['FT_Turn_T']?></td>
    <td><?=$row['FT_Turn_F']?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">单场限额</td>
	<td><?=$row['FT_R_Scene']?></td>
    <td><?=$row['FT_OU_Scene']?></td>
	<td><?=$row['FT_RE_Scene']?></td>
	<td><?=$row['FT_ROU_Scene']?></td>
    <td><?=$row['FT_EO_Scene']?></td>
    <td><?=$row['FT_RM_Scene']?></td>
    <td><?=$row['FT_M_Scene']?></td>
    <td><?=$row['FT_P_Scene']?></td>
    <td><?=$row['FT_PR_Scene']?></td>
    <td><?=$row['FT_PC_Scene']?></td>
    <td><?=$row['FT_PD_Scene']?></td>
    <td><?=$row['FT_T_Scene']?></td>
    <td><?=$row['FT_F_Scene']?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">单注限额</td>
    <td><?=$row['FT_R_Bet']?></td>
    <td><?=$row['FT_OU_Bet']?></td>
    <td><?=$row['FT_RE_Bet']?></td>
    <td><?=$row['FT_ROU_Bet']?></td>	
    <td><?=$row['FT_EO_Bet']?></td>
    <td><?=$row['FT_RM_Bet']?></td>
    <td><?=$row['FT_M_Bet']?></td>
    <td><?=$row['FT_P_Bet']?></td>
    <td><?=$row['FT_PR_Bet']?></td>
    <td><?=$row['FT_PC_Bet']?></td>
    <td><?=$row['FT_PD_Bet']?></td>
    <td><?=$row['FT_T_Bet']?></td>
    <td><?=$row['FT_F_Bet']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">&nbsp;</td>
	<td><a href='javascript:void(0)' onClick="show_win('足球-让球','R','<?=$row['FT_R_Scene']?>','<?=$row['FT_R_Bet']?>',<?=$row['FT_Turn_R']?>,0.25,<?=$r_turn?>,'FT');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('足球-大小盘','OU','<?=$row['FT_OU_Scene']?>','<?=$row['FT_OU_Bet']?>',<?=$row['FT_Turn_OU']?>,0.25,<?=$ou_turn?>,'FT');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('足球-滚球','RE','<?=$row['FT_RE_Scene']?>','<?=$row['FT_RE_Bet']?>',<?=$row['FT_Turn_RE']?>,0.25,<?=$re_turn?>,'FT');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('足球-滚球大小','ROU','<?=$row['FT_ROU_Scene']?>','<?=$row['FT_ROU_Bet']?>',<?=$row['FT_Turn_ROU']?>,0.25,<?=$rou_turn?>,'FT');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('足球-单双','EO','<?=$row['FT_EO_Scene']?>','<?=$row['FT_EO_Bet']?>',<?=$row['FT_Turn_EO']?>,0.25,<?=$eo_turn?>,'FT');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('足球-独赢','RM','<?=$row['FT_RM_Scene']?>','<?=$row['FT_RM_Bet']?>',<?=$row['FT_Turn_RM']?>,1,<?=$ag_row['FT_Turn_RM']?>,'FT');">修改</a></td>	
	<td><a href='javascript:void(0)' onClick="show_win('足球-独赢','M','<?=$row['FT_M_Scene']?>','<?=$row['FT_M_Bet']?>',<?=$row['FT_Turn_M']?>,1,<?=$ag_row['FT_Turn_M']?>,'FT');">修改</a></td>	
	<td><a href='javascript:void(0)' onClick="show_win('足球-标准过关','P','<?=$row['FT_P_Scene']?>','<?=$row['FT_P_Bet']?>',<?=$row['FT_Turn_P']?>,1,<?=$ag_row['FT_Turn_P']?>,'FT');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('足球-让球过关','PR','<?=$row['FT_PR_Scene']?>','<?=$row['FT_PR_Bet']?>',<?=$row['FT_Turn_PR']?>,1,<?=$ag_row['FT_Turn_PR']?>,'FT');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('足球-综合过关','PC','<?=$row['FT_PC_Scene']?>','<?=$row['FT_PC_Bet']?>',<?=$row['FT_Turn_PC']?>,1,<?=$ag_row['FT_Turn_PC']?>,'FT');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('足球-波胆','PD','<?=$row['FT_PD_Scene']?>','<?=$row['FT_PD_Bet']?>',<?=$row['FT_Turn_PD']?>,1,<?=$ag_row['FT_Turn_PD']?>,'FT');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('足球-入球','T','<?=$row['FT_T_Scene']?>','<?=$row['FT_T_Bet']?>',<?=$row['FT_Turn_T']?>,1,<?=$ag_row['FT_Turn_T']?>,'FT');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('足球-半全场','F','<?=$row['FT_F_Scene']?>','<?=$row['FT_F_Bet']?>',<?=$row['FT_Turn_F']?>,1,<?=$ag_row['FT_Turn_F']?>,'FT');">修改</a></td>
  </tr>
</table>
<BR>
<table width='780' border="0" cellspacing="0" cellpadding="0">
<tr>
<td align='left'>
<table width="580" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit"> 
    <td>篮球</td>
    <td width="68">让球</td>
    <td width="68">大小</td>
    <td width="68">滚球</td>
    <td width="68">滚球大小</td>
    <td width="68">单双</td>
    <td width="68">让球过关</td>
    <td width="68">综合过关</td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right" class="m_ag_ed">退水设定:</td>
    <td><?=$row['BK_Turn_R']?></td>
    <td><?=$row['BK_Turn_OU']?></td>
    <td><?=$row['BK_Turn_RE']?></td>
    <td><?=$row['BK_Turn_ROU']?></td>
    <td><?=$row['BK_Turn_EO']?></td>
    <td><?=$row['BK_Turn_PR']?></td>
    <td><?=$row['BK_Turn_PC']?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">单场限额:</td>
    <td><?=$row['BK_R_Scene']?></td>
    <td><?=$row['BK_OU_Scene']?></td>
    <td><?=$row['BK_RE_Scene']?></td>
    <td><?=$row['BK_ROU_Scene']?></td>
    <td><?=$row['BK_EO_Scene']?></td>
    <td><?=$row['BK_PR_Scene']?></td>
    <td><?=$row['BK_PC_Scene']?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">单注限额:</td>
    <td><?=$row['BK_R_Bet']?></td>
    <td><?=$row['BK_OU_Bet']?></td>
    <td><?=$row['BK_RE_Bet']?></td>
    <td><?=$row['BK_ROU_Bet']?></td>
    <td><?=$row['BK_EO_Bet']?></td>
    <td><?=$row['BK_PR_Bet']?></td>
    <td><?=$row['BK_PC_Bet']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">&nbsp;</td>
	<td><a href='javascript:void(0)' onClick="show_win('篮球-让球','R','<?=$row['BK_R_Scene']?>','<?=$row['BK_R_Bet']?>',<?=$row['BK_Turn_R']?>,0.25,<?=$bk_r_turn?>,'BK');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('篮球-上下','OU','<?=$row['BK_OU_Scene']?>','<?=$row['BK_OU_Bet']?>',<?=$row['BK_Turn_OU']?>,0.25,<?=$bk_ou_turn?>,'BK');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('篮球-滚球','RE','<?=$row['BK_RE_Scene']?>','<?=$row['BK_RE_Bet']?>',<?=$row['BK_Turn_RE']?>,0.25,<?=$bk_re_turn?>,'BK');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('篮球-滚球大小','ROU','<?=$row['BK_ROU_Scene']?>','<?=$row['BK_ROU_Bet']?>',<?=$row['BK_Turn_ROU']?>,0.25,<?=$bk_rou_turn?>,'BK');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('篮球-单双','EO','<?=$row['BK_EO_Scene']?>','<?=$row['BK_EO_Bet']?>',<?=$row['BK_Turn_EO']?>,0.25,<?=$bk_eo_turn?>,'BK');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('篮球-让球过关','PR','<?=$row['BK_PR_Scene']?>','<?=$row['BK_PR_Bet']?>',<?=$row['BK_Turn_PR']?>,1,<?=$ag_row['BK_Turn_PR']?>,'BK');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('篮球-综合过关','PC','<?=$row['BK_PC_Scene']?>','<?=$row['BK_PC_Bet']?>',<?=$row['BK_Turn_PC']?>,1,<?=$ag_row['BK_Turn_PC']?>,'BK');">修改</a></td>
  </tr>
</table>
</td>
<td align='right'>
<table width="150" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit"> 
    <td>冠军</td>
    <td width="68">冠军</td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right" class="m_ag_ed">退水设定:</td>
    <td><?=$row['FS_Turn_R']?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">单场限额:</td>
    <td><?=$row['FS_R_Scene']?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">单注限额:</td>
    <td><?=$row['FS_R_Bet']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">&nbsp;</td>
    <td><a href='javascript:void(0)' onClick="show_win('冠军-冠军','R','<?=$row['FS_R_Scene']?>','<?=$row['FS_R_Bet']?>',<?=$row['FS_Turn_R']?>,1,<?=$ag_row['FS_Turn_R']?>,'FS');"> 修改</a></td>
  </tr>
</table>
</td>
</tr>
</table>
<BR>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit"> 
    <td>网球 </td>
    <td width="68">让球</td>
    <td width="68">大小</td>
    <td width="68">滚球</td>
    <td width="68">滚球大小</td>
    <td width="68">单双</td>
    <td width="68">独赢</td>
    <td width="68">标准过关</td>
    <td width="68">让球过关</td>
    <td width="68">综合过关</td>
    <td width="68">波胆</td>
    <td width="68">入球</td>
    <td width="68">半全场</td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right" class="m_ag_ed" nowrap>退水设定</td>
    <td><?=$row['TN_Turn_R']?></td>
    <td><?=$row['TN_Turn_OU']?></td>
    <td><?=$row['TN_Turn_RE']?></td>
    <td ><?=$row['TN_Turn_ROU']?></td>
    <td><?=$row['TN_Turn_EO']?></td>
    <td><?=$row['TN_Turn_M']?></td>
    <td><?=$row['TN_Turn_P']?></td>
    <td><?=$row['TN_Turn_PR']?></td>
    <td><?=$row['TN_Turn_PC']?></td>
    <td><?=$row['TN_Turn_PD']?></td>
    <td><?=$row['TN_Turn_T']?></td>
    <td><?=$row['TN_Turn_F']?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">单场限额</td>
	<td><?=$row['TN_R_Scene']?></td>
    <td><?=$row['TN_OU_Scene']?></td>
	<td><?=$row['TN_RE_Scene']?></td>
	<td><?=$row['TN_ROU_Scene']?></td>
    <td><?=$row['TN_EO_Scene']?></td>
    <td><?=$row['TN_M_Scene']?></td>
    <td><?=$row['TN_P_Scene']?></td>
    <td><?=$row['TN_PR_Scene']?></td>
    <td><?=$row['TN_PC_Scene']?></td>
    <td><?=$row['TN_PD_Scene']?></td>
    <td><?=$row['TN_T_Scene']?></td>
    <td><?=$row['TN_F_Scene']?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">单注限额</td>
    <td><?=$row['TN_R_Bet']?></td>
    <td><?=$row['TN_OU_Bet']?></td>
    <td><?=$row['TN_RE_Bet']?></td>
    <td><?=$row['TN_ROU_Bet']?></td>	
    <td><?=$row['TN_EO_Bet']?></td>
    <td><?=$row['TN_M_Bet']?></td>
    <td><?=$row['TN_P_Bet']?></td>
    <td><?=$row['TN_PR_Bet']?></td>
    <td><?=$row['TN_PC_Bet']?></td>
    <td><?=$row['TN_PD_Bet']?></td>
    <td><?=$row['TN_T_Bet']?></td>
    <td><?=$row['TN_F_Bet']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">&nbsp;</td>
	<td><a href='javascript:void(0)' onClick="show_win('网球-让球','R','<?=$row['TN_R_Scene']?>','<?=$row['TN_R_Bet']?>',<?=$row['TN_Turn_R']?>,0.25,<?=$tn_r_turn?>,'TN');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('网球-大小盘','OU','<?=$row['TN_OU_Scene']?>','<?=$row['TN_OU_Bet']?>',<?=$row['TN_Turn_OU']?>,0.25,<?=$tn_ou_turn?>,'TN');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('网球-滚球','RE','<?=$row['TN_RE_Scene']?>','<?=$row['TN_RE_Bet']?>',<?=$row['TN_Turn_RE']?>,0.25,<?=$tn_re_turn?>,'TN');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('网球-滚球大小','ROU','<?=$row['TN_ROU_Scene']?>','<?=$row['TN_ROU_Bet']?>',<?=$row['TN_Turn_ROU']?>,0.25,<?=$tn_rou_turn?>,'TN');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('网球-单双','EO','<?=$row['TN_EO_Scene']?>','<?=$row['TN_EO_Bet']?>',<?=$row['TN_Turn_EO']?>,0.25,<?=$tn_eo_turn?>,'TN');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('网球-独赢','M','<?=$row['TN_M_Scene']?>','<?=$row['TN_M_Bet']?>',<?=$row['TN_Turn_M']?>,1,<?=$ag_row['TN_Turn_M']?>,'TN');">修改</a></td>	
	<td><a href='javascript:void(0)' onClick="show_win('网球-标准过关','P','<?=$row['TN_P_Scene']?>','<?=$row['TN_P_Bet']?>',<?=$row['TN_Turn_P']?>,1,<?=$ag_row['TN_Turn_P']?>,'TN');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('网球-让球过关','PR','<?=$row['TN_PR_Scene']?>','<?=$row['TN_PR_Bet']?>',<?=$row['TN_Turn_PR']?>,1,<?=$ag_row['TN_Turn_PR']?>,'TN');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('网球-综合过关','PC','<?=$row['TN_PC_Scene']?>','<?=$row['TN_PC_Bet']?>',<?=$row['TN_Turn_PC']?>,1,<?=$ag_row['TN_Turn_PC']?>,'TN');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('网球-波胆','PD','<?=$row['TN_PD_Scene']?>','<?=$row['TN_PD_Bet']?>',<?=$row['TN_Turn_PD']?>,1,<?=$ag_row['TN_Turn_PD']?>,'TN');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('网球-入球','T','<?=$row['TN_T_Scene']?>','<?=$row['TN_T_Bet']?>',<?=$row['TN_Turn_T']?>,1,<?=$ag_row['TN_Turn_T']?>,'TN');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('网球-半全场','F','<?=$row['TN_F_Scene']?>','<?=$row['TN_F_Bet']?>',<?=$row['TN_Turn_F']?>,1,<?=$ag_row['TN_Turn_F']?>,'TN');">修改</a></td>
  </tr>
 </table>
<BR>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit"> 
    <td>排球 </td>
    <td width="68">让球</td>
    <td width="68">大小</td>
    <td width="68">滚球</td>
    <td width="68">滚球大小</td>
    <td width="68">单双</td>
    <td width="68">独赢</td>
    <td width="68">标准过关</td>
    <td width="68">让球过关</td>
    <td width="68">综合过关</td>
    <td width="68">波胆</td>
    <td width="68">入球</td>
    <td width="68">半全场</td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right" class="m_ag_ed" nowrap>退水设定</td>
    <td><?=$row['VB_Turn_R']?></td>
    <td><?=$row['VB_Turn_OU']?></td>
    <td><?=$row['VB_Turn_RE']?></td>
    <td ><?=$row['VB_Turn_ROU']?></td>
    <td><?=$row['VB_Turn_EO']?></td>
    <td><?=$row['VB_Turn_M']?></td>
    <td><?=$row['VB_Turn_P']?></td>
    <td><?=$row['VB_Turn_PR']?></td>
    <td><?=$row['VB_Turn_PC']?></td>
    <td><?=$row['VB_Turn_PD']?></td>
    <td><?=$row['VB_Turn_T']?></td>
    <td><?=$row['VB_Turn_F']?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">单场限额</td>
	<td><?=$row['VB_R_Scene']?></td>
    <td><?=$row['VB_OU_Scene']?></td>
	<td><?=$row['VB_RE_Scene']?></td>
	<td><?=$row['VB_ROU_Scene']?></td>
    <td><?=$row['VB_EO_Scene']?></td>
    <td><?=$row['VB_M_Scene']?></td>
    <td><?=$row['VB_P_Scene']?></td>
    <td><?=$row['VB_PR_Scene']?></td>
    <td><?=$row['VB_PC_Scene']?></td>
    <td><?=$row['VB_PD_Scene']?></td>
    <td><?=$row['VB_T_Scene']?></td>
    <td><?=$row['VB_F_Scene']?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">单注限额</td>
    <td><?=$row['VB_R_Bet']?></td>
    <td><?=$row['VB_OU_Bet']?></td>
    <td><?=$row['VB_RE_Bet']?></td>
    <td><?=$row['VB_ROU_Bet']?></td>	
    <td><?=$row['VB_EO_Bet']?></td>
    <td><?=$row['VB_M_Bet']?></td>
    <td><?=$row['VB_P_Bet']?></td>
    <td><?=$row['VB_PR_Bet']?></td>
    <td><?=$row['VB_PC_Bet']?></td>
    <td><?=$row['VB_PD_Bet']?></td>
    <td><?=$row['VB_T_Bet']?></td>
    <td><?=$row['VB_F_Bet']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">&nbsp;</td>
	<td><a href='javascript:void(0)' onClick="show_win('排球-让球','R','<?=$row['VB_R_Scene']?>','<?=$row['VB_R_Bet']?>',<?=$row['VB_Turn_R']?>,0.25,<?=$r_turn?>,'VB');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('排球-大小盘','OU','<?=$row['VB_OU_Scene']?>','<?=$row['VB_OU_Bet']?>',<?=$row['VB_Turn_OU']?>,0.25,<?=$vb_ou_turn?>,'VB');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('排球-滚球','RE','<?=$row['VB_RE_Scene']?>','<?=$row['VB_RE_Bet']?>',<?=$row['VB_Turn_RE']?>,0.25,<?=$vb_re_turn?>,'VB');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('排球-滚球大小','ROU','<?=$row['VB_ROU_Scene']?>','<?=$row['VB_ROU_Bet']?>',<?=$row['VB_Turn_ROU']?>,0.25,<?=$vb_rou_turn?>,'VB');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('排球-单双','EO','<?=$row['VB_EO_Scene']?>','<?=$row['VB_EO_Bet']?>',<?=$row['VB_Turn_EO']?>,0.25,<?=$vb_eo_turn?>,'VB');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('排球-独赢','M','<?=$row['VB_M_Scene']?>','<?=$row['VB_M_Bet']?>',<?=$row['VB_Turn_M']?>,1,<?=$ag_row['VB_Turn_M']?>,'VB');">修改</a></td>	
	<td><a href='javascript:void(0)' onClick="show_win('排球-标准过关','P','<?=$row['VB_P_Scene']?>','<?=$row['VB_P_Bet']?>',<?=$row['VB_Turn_P']?>,1,<?=$ag_row['VB_Turn_P']?>,'VB');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('排球-让球过关','PR','<?=$row['VB_PR_Scene']?>','<?=$row['VB_PR_Bet']?>',<?=$row['VB_Turn_PR']?>,1,<?=$ag_row['VB_Turn_PR']?>,'VB');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('排球-综合过关','PC','<?=$row['VB_PC_Scene']?>','<?=$row['VB_PC_Bet']?>',<?=$row['VB_Turn_PC']?>,1,<?=$ag_row['VB_Turn_PC']?>,'VB');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('排球-波胆','PD','<?=$row['VB_PD_Scene']?>','<?=$row['VB_PD_Bet']?>',<?=$row['VB_Turn_PD']?>,1,<?=$ag_row['VB_Turn_PD']?>,'VB');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('排球-入球','T','<?=$row['VB_T_Scene']?>','<?=$row['VB_T_Bet']?>',<?=$row['VB_Turn_T']?>,1,<?=$ag_row['VB_Turn_T']?>,'VB');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('排球-半全场','F','<?=$row['VB_F_Scene']?>','<?=$row['VB_F_Bet']?>',<?=$row['VB_Turn_F']?>,1,<?=$ag_row['VB_Turn_F']?>,'VB');">修改</a></td>
  </tr>
</table>
<BR>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit"> 
    <td>棒球 </td>
    <td width="68">让球</td>
    <td width="68">大小</td>
    <td width="68">滚球</td>
    <td width="68">滚球大小</td>
    <td width="68">单双</td>
    <td width="68">独赢</td>
    <td width="68">标准过关</td>
    <td width="68">让球过关</td>
    <td width="68">综合过关</td>
    <td width="68">波胆</td>
    <td width="68">总得分</td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right" class="m_ag_ed" nowrap>退水设定</td>
    <td><?=$row['BS_Turn_R']+0?></td>
    <td><?=$row['BS_Turn_OU']+0?></td>
    <td><?=$row['BS_Turn_RE']+0?></td>
    <td ><?=$row['BS_Turn_ROU']+0?></td>
    <td><?=$row['BS_Turn_EO']+0?></td>
    <td><?=$row['BS_Turn_M']+0?></td>
    <td><?=$row['BS_Turn_P']+0?></td>
    <td><?=$row['BS_Turn_PR']+0?></td>
    <td><?=$row['BS_Turn_PC']+0?></td>
    <td><?=$row['BS_Turn_PD']+0?></td>
    <td><?=$row['BS_Turn_T']+0?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">单场限额</td>
	<td><?=$row['BS_R_Scene']+0?></td>
    <td><?=$row['BS_OU_Scene']+0?></td>
	<td><?=$row['BS_RE_Scene']+0?></td>
	<td><?=$row['BS_ROU_Scene']+0?></td>
    <td><?=$row['BS_EO_Scene']+0?></td>
    <td><?=$row['BS_M_Scene']+0?></td>
    <td><?=$row['BS_P_Scene']+0?></td>
    <td><?=$row['BS_PR_Scene']+0?></td>
    <td><?=$row['BS_PC_Scene']+0?></td>
    <td><?=$row['BS_PD_Scene']+0?></td>
    <td><?=$row['BS_T_Scene']+0?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">单注限额</td>
    <td><?=$row['BS_R_Bet']+0?></td>
    <td><?=$row['BS_OU_Bet']+0?></td>
    <td><?=$row['BS_RE_Bet']+0?></td>
    <td><?=$row['BS_ROU_Bet']+0?></td>	
    <td><?=$row['BS_EO_Bet']+0?></td>
    <td><?=$row['BS_M_Bet']+0?></td>
    <td><?=$row['BS_P_Bet']+0?></td>
    <td><?=$row['BS_PR_Bet']+0?></td>
    <td><?=$row['BS_PC_Bet']+0?></td>
    <td><?=$row['BS_PD_Bet']+0?></td>
    <td><?=$row['BS_T_Bet']+0?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">&nbsp;</td>
	<td><a href='javascript:void(0)' onClick="show_win('棒球-让球','R','<?=$row['BS_R_Scene']+0?>','<?=$row['BS_R_Bet']+0?>',<?=$row['BS_Turn_R']+0?>,0.25,<?=$bs_r_turn?>,'BS');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('棒球-大小盘','OU','<?=$row['BS_OU_Scene']+0?>','<?=$row['BS_OU_Bet']+0?>',<?=$row['BS_Turn_OU']+0?>,0.25,<?=$bs_ou_turn?>,'BS');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('棒球-滚球','RE','<?=$row['BS_RE_Scene']+0?>','<?=$row['BS_RE_Bet']+0?>',<?=$row['BS_Turn_RE']+0?>,0.25,<?=$bs_re_turn?>,'BS');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('棒球-滚球大小','ROU','<?=$row['BS_ROU_Scene']+0?>','<?=$row['BS_ROU_Bet']+0?>',<?=$row['BS_Turn_ROU']+0?>,0.25,<?=$bs_rou_turn?>,'BS');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('棒球-单双','EO','<?=$row['BS_EO_Scene']+0?>','<?=$row['BS_EO_Bet']+0?>',<?=$row['BS_Turn_EO']+0?>,0.25,<?=$bs_eo_turn?>,'BS');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('棒球-独赢','M','<?=$row['BS_M_Scene']+0?>','<?=$row['BS_M_Bet']+0?>',<?=$row['BS_Turn_M']+0?>,1,<?=$ag_row['BS_Turn_M']+0?>,'BS');">修改</a></td>	
	<td><a href='javascript:void(0)' onClick="show_win('棒球-标准过关','P','<?=$row['BS_P_Scene']+0?>','<?=$row['BS_P_Bet']+0?>',<?=$row['BS_Turn_P']+0?>,1,<?=$ag_row['BS_Turn_P']+0?>,'BS');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('棒球-让球过关','PR','<?=$row['BS_PR_Scene']+0?>','<?=$row['BS_PR_Bet']+0?>',<?=$row['BS_Turn_PR']+0?>,1,<?=$ag_row['BS_Turn_PR']+0?>,'BS');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('棒球-综合过关','PC','<?=$row['BS_PC_Scene']+0?>','<?=$row['BS_PC_Bet']+0?>',<?=$row['BS_Turn_PC']+0?>,1,<?=$ag_row['BS_Turn_PC']+0?>,'BS');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('棒球-波胆','PD','<?=$row['BS_PD_Scene']+0?>','<?=$row['BS_PD_Bet']+0?>',<?=$row['BS_Turn_PD']+0?>,1,<?=$ag_row['BS_Turn_PD']+0?>,'BS');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('棒球-总得分','T','<?=$row['BS_T_Scene']+0?>','<?=$row['BS_T_Bet']+0?>',<?=$row['BS_Turn_T']+0?>,1,<?=$ag_row['BS_Turn_T']+0?>,'BS');">修改</a></td>
  </tr>
</table>
<?
$op_r_turn='OP_Turn_R_'.$opentype;
$op_r_turn=$ag_row[$op_r_turn];
$op_ou_turn='OP_Turn_OU_'.$opentype;
$op_ou_turn=$ag_row[$op_ou_turn];
$op_re_turn='OP_Turn_RE_'.$opentype;
$op_re_turn=$ag_row[$op_re_turn];
$op_rou_turn='OP_Turn_ROU_'.$opentype;
$op_rou_turn=$ag_row[$op_rou_turn];
$op_eo_turn='OP_Turn_EO_'.$opentype;
$op_eo_turn=$ag_row[$op_eo_turn];
?>
<BR>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit"> 
    <td>其它  </td>
    <td width="68">让球</td>
    <td width="68">大小</td>
    <td width="68">滚球</td>
    <td width="68">滚球大小</td>
    <td width="68">单双</td>
    <td width="68">独赢</td>
    <td width="68">标准过关</td>
    <td width="68">让球过关</td>
    <td width="68">综合过关</td>
    <td width="68">波胆</td>
    <td width="68">入球</td>
    <td width="68">半全场</td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right" class="m_ag_ed" nowrap>退水设定</td>
    <td><?=$row['OP_Turn_R']+0?></td>
    <td><?=$row['OP_Turn_OU']+0?></td>
    <td><?=$row['OP_Turn_RE']+0?></td>
    <td ><?=$row['OP_Turn_ROU']+0?></td>
    <td><?=$row['OP_Turn_EO']+0?></td>
    <td><?=$row['OP_Turn_M']+0?></td>
    <td><?=$row['OP_Turn_P']+0?></td>
    <td><?=$row['OP_Turn_PR']+0?></td>
    <td><?=$row['OP_Turn_PC']+0?></td>
    <td><?=$row['OP_Turn_PD']+0?></td>
    <td><?=$row['OP_Turn_T']+0?></td>
    <td><?=$row['OP_Turn_F']+0?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">单场限额</td>
	<td><?=$row['OP_R_Scene']+0?></td>
    <td><?=$row['OP_OU_Scene']+0?></td>
	<td><?=$row['OP_RE_Scene']+0?></td>
	<td><?=$row['OP_ROU_Scene']+0?></td>
    <td><?=$row['OP_EO_Scene']+0?></td>
    <td><?=$row['OP_M_Scene']+0?></td>
    <td><?=$row['OP_P_Scene']+0?></td>
    <td><?=$row['OP_PR_Scene']+0?></td>
    <td><?=$row['OP_PC_Scene']+0?></td>
    <td><?=$row['OP_PD_Scene']+0?></td>
    <td><?=$row['OP_T_Scene']+0?></td>
    <td><?=$row['OP_F_Scene']+0?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">单注限额</td>
    <td><?=$row['OP_R_Bet']+0?></td>
    <td><?=$row['OP_OU_Bet']+0?></td>
    <td><?=$row['OP_RE_Bet']+0?></td>
    <td><?=$row['OP_ROU_Bet']+0?></td>	
    <td><?=$row['OP_EO_Bet']+0?></td>
    <td><?=$row['OP_M_Bet']+0?></td>
    <td><?=$row['OP_P_Bet']+0?></td>
    <td><?=$row['OP_PR_Bet']+0?></td>
    <td><?=$row['OP_PC_Bet']+0?></td>
    <td><?=$row['OP_PD_Bet']+0?></td>
    <td><?=$row['OP_T_Bet']+0?></td>
    <td><?=$row['OP_F_Bet']+0?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">&nbsp;</td>
	<td><a href='javascript:void(0)' onClick="show_win('其它 -让球','R','<?=$row['OP_R_Scene']+0?>','<?=$row['OP_R_Bet']+0?>',<?=$row['OP_Turn_R']+0?>,0.25,<?=$op_r_turn?>,'OP');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('其它 -大小盘','OU','<?=$row['OP_OU_Scene']+0?>','<?=$row['OP_OU_Bet']+0?>',<?=$row['OP_Turn_OU']+0?>,0.25,<?=$op_ou_turn?>,'OP');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('其它 -滚球','RE','<?=$row['OP_RE_Scene']+0?>','<?=$row['OP_RE_Bet']+0?>',<?=$row['OP_Turn_RE']+0?>,0.25,<?=$op_re_turn?>,'OP');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('其它 -滚球大小','ROU','<?=$row['OP_ROU_Scene']+0?>','<?=$row['OP_ROU_Bet']+0?>',<?=$row['OP_Turn_ROU']+0?>,0.25,<?=$op_rou_turn?>,'OP');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('其它 -单双','EO','<?=$row['OP_EO_Scene']+0?>','<?=$row['OP_EO_Bet']+0?>',<?=$row['OP_Turn_EO']+0?>,0.25,<?=$op_eo_turn?>,'OP');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('其它 -独赢','M','<?=$row['OP_M_Scene']+0?>','<?=$row['OP_M_Bet']+0?>',<?=$row['OP_Turn_M']+0?>,1,<?=$ag_row['OP_Turn_M']+0?>,'OP');">修改</a></td>	
	<td><a href='javascript:void(0)' onClick="show_win('其它 -标准过关','P','<?=$row['OP_P_Scene']+0?>','<?=$row['OP_P_Bet']+0?>',<?=$row['OP_Turn_P']+0?>,1,<?=$ag_row['OP_Turn_P']+0?>,'OP');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('其它 -让球过关','PR','<?=$row['OP_PR_Scene']+0?>','<?=$row['OP_PR_Bet']+0?>',<?=$row['OP_Turn_PR']+0?>,1,<?=$ag_row['OP_Turn_PR']+0?>,'OP');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('其它 -综合过关','PC','<?=$row['OP_PC_Scene']+0?>','<?=$row['OP_PC_Bet']+0?>',<?=$row['OP_Turn_PC']+0?>,1,<?=$ag_row['OP_Turn_PC']+0?>,'OP');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('其它 -波胆','PD','<?=$row['OP_PD_Scene']+0?>','<?=$row['OP_PD_Bet']+0?>',<?=$row['OP_Turn_PD']+0?>,1,<?=$ag_row['OP_Turn_PD']+0?>,'OP');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('其它 -入球','T','<?=$row['OP_T_Scene']+0?>','<?=$row['OP_T_Bet']+0?>',<?=$row['OP_Turn_T']+0?>,1,<?=$ag_row['OP_Turn_T']+0?>,'OP');">修改</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('其它 -半全场','F','<?=$row['OP_F_Scene']+0?>','<?=$row['OP_F_Bet']+0?>',<?=$row['OP_Turn_F']+0?>,1,<?=$ag_row['OP_Turn_F']+0?>,'OP');">修改</a></td>
  </tr>
</table><!----------------------结帐视窗2---------------------------->
<div id=rs_window style="display: none;position:absolute">
  <form name=rs_form action="" method=post onSubmit="return Chk_acc();">
<input type=hidden name=rtype value="">
<input type=hidden name=act value="N">
<input type=hidden name=mid value="<?=$mid?>">
<input type=hidden name=id value="<?=$mid?>">
<input type=hidden name=sid value="">
<input type=hidden name=pay_type value="<?=$pay_type?>">
<input type=hidden name=currency value="RMB">
<input type="hidden" name="ratio" value="1">
<input type=hidden name=kind value="">
      <table width="250" border="0" cellspacing="1" cellpadding="2" bgcolor="00558E">
        <tr> 
          <td bgcolor="#FFFFFF"> 
            <table width="250" border="0" cellspacing="0" cellpadding="0" bgcolor="#A4C0CE" class="m_tab_fix">
              <tr bgcolor="0163A2"> 
                <td  id=r_title width="200"><font color="#FFFFFF">请输入</font></td>
                <td align="right" valign="top"><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
              </tr>
              <tr> 
                <td colspan="2" height="1" bgcolor="#000000"></td>
              </tr>
              <tr> 
                <td colspan="2">退水设定&nbsp;&nbsp; 
                <select class="za_select" name="war_set">
                </select>
                </td>
              </tr>
              <tr bgcolor="#000000"> 
                <td colspan="2" height="1"></td>
              </tr>
              <tr> 
                <td colspan="2">单场限额&nbsp;&nbsp; 
                <input type=TEXT id=ft_b4_1 name="SC" value="" size=12 maxlength=12 class="za_text" onKeyUp="Chg_Sc_Mcy();count_so();Chg_So_Mcy();">
				美金:<font color="#FF0033" id="mcy_sc">0</font></td>
              </tr>
              <tr bgcolor="#000000"> 
                <td colspan="2" height="1"></td>
              </tr>
              <tr> 
                <td colspan="2">单注限额&nbsp;&nbsp; 
                <input type=TEXT id=ft_b4_1 name="SO" value="" size=12 maxlength=12 class="za_text" onKeyUp="Chg_So_Mcy();">
				美金: <font color="#FF0033" id="mcy_so">0</font></td>
              </tr>
              <tr bgcolor="#000000"> 
                <td colspan="2" height="1"></td>
              </tr>
              
            <tr align="center"> 
              <td colspan="2"> 
                <input type=submit name=rs_ok value="确定" class="za_button">
                  &nbsp;&nbsp; </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
  </form>
</div>
<!----------------------结帐视窗2----------------------------> 
<BR><BR><BR>
</body>
</html>

