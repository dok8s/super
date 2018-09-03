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
		echo wterror("Giới hạn lưu ý duy nhất của cổ đông này đã vượt quá giới hạn lưu ý của cổ đông lớn. Vui lòng quay lại bên và nhập lại...");
		exit();
	}
	if ($so>$agbet){
		echo wterror("Giới hạn ghi chú duy nhất của thành viên này đã vượt quá giới hạn ghi chú duy nhất của tác nhân. Vui lòng quay lại bên và nhập lại");
		exit();
	}

	$mysql="update web_member set ".$kind.'_'.$rtype."_Scene='".$sc."',".$kind.'_'.$rtype."_Bet='".$so."',".$kind.'_'."Turn_".$rtype."='".$st."' where id=$mid";
	mysql_query($mysql) or die ("Thao tác thất bại!");
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
    <td class="m_tline">&nbsp;&nbsp;<?=$mnu_member?><?=$mem_setopt?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Số tài khoản:<?=$row['Memname']?>
      -- Tên thành viên:<?=$row['Alias']?> -- Điểm chấp:<?=$row['OpenType']?> -- Sử dụng tiền tệ:<?=$row['CurType']?> -- <?=$rep_pay_type?>: <?
	  if ($row['pay_type']==0){
	  	echo $rep_pay_type_c;
	  }else{
  	  	echo $rep_pay_type_m;
	  }
	  ?> --  <a href="./ag_members.php?uid=<?=$uid?>">Quay lại trang</a></td>
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit"> 
    <td>Bóng đá </td>
    <td width="68">Hãy để bóng</td>
    <td width="68">Kích thước</td>
    <td width="68">Cán bóng</td>
    <td width="68">Kích thước</td>
    <td width="68">Đơn và đôi</td>
    <td width="68">Rolling ball</td>
    <td width="68">Giành chiến</td>
    <td width="68">Tiêu chuẩn</td>
    <td width="68">Để bóng chuyền</td>
    <td width="68">Giải phóng</td>
    <td width="68">Làn sóng</td>
    <td width="68">Mục tiêu</td>
    <td width="68">Trường toàn</td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right" class="m_ag_ed" nowrap>Cài đặt thu hồi nước</td>
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
    <td align="right"class="m_ag_ed">Giới hạn đơn</td>
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
    <td align="right"class="m_ag_ed">Giới hạn ghi</td>
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
	<td><a href='javascript:void(0)' onClick="show_win('Bóng đá - hãy để bóng','R','<?=$row['FT_R_Scene']?>','<?=$row['FT_R_Bet']?>',<?=$row['FT_Turn_R']?>,0.25,<?=$r_turn?>,'FT');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng đá - lớn và nhỏ','OU','<?=$row['FT_OU_Scene']?>','<?=$row['FT_OU_Bet']?>',<?=$row['FT_Turn_OU']?>,0.25,<?=$ou_turn?>,'FT');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng đá - bóng lăn','RE','<?=$row['FT_RE_Scene']?>','<?=$row['FT_RE_Bet']?>',<?=$row['FT_Turn_RE']?>,0.25,<?=$re_turn?>,'FT');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng đá - bóng','ROU','<?=$row['FT_ROU_Scene']?>','<?=$row['FT_ROU_Bet']?>',<?=$row['FT_Turn_ROU']?>,0.25,<?=$rou_turn?>,'FT');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng đá - đơn và đôi','EO','<?=$row['FT_EO_Scene']?>','<?=$row['FT_EO_Bet']?>',<?=$row['FT_Turn_EO']?>,0.25,<?=$eo_turn?>,'FT');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng đá - giành chiến','RM','<?=$row['FT_RM_Scene']?>','<?=$row['FT_RM_Bet']?>',<?=$row['FT_Turn_RM']?>,1,<?=$ag_row['FT_Turn_RM']?>,'FT');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng đá - giành','M','<?=$row['FT_M_Scene']?>','<?=$row['FT_M_Bet']?>',<?=$row['FT_Turn_M']?>,1,<?=$ag_row['FT_Turn_M']?>,'FT');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng đá - giải phóng','P','<?=$row['FT_P_Scene']?>','<?=$row['FT_P_Bet']?>',<?=$row['FT_Turn_P']?>,1,<?=$ag_row['FT_Turn_P']?>,'FT');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng đá - để bóng chuyền','PR','<?=$row['FT_PR_Scene']?>','<?=$row['FT_PR_Bet']?>',<?=$row['FT_Turn_PR']?>,1,<?=$ag_row['FT_Turn_PR']?>,'FT');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng đá - giải phóng','PC','<?=$row['FT_PC_Scene']?>','<?=$row['FT_PC_Bet']?>',<?=$row['FT_Turn_PC']?>,1,<?=$ag_row['FT_Turn_PC']?>,'FT');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng đá - Làn sóng','PD','<?=$row['FT_PD_Scene']?>','<?=$row['FT_PD_Bet']?>',<?=$row['FT_Turn_PD']?>,1,<?=$ag_row['FT_Turn_PD']?>,'FT');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng đá - mục tiêu','T','<?=$row['FT_T_Scene']?>','<?=$row['FT_T_Bet']?>',<?=$row['FT_Turn_T']?>,1,<?=$ag_row['FT_Turn_T']?>,'FT');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng đá - bán toàn sân','F','<?=$row['FT_F_Scene']?>','<?=$row['FT_F_Bet']?>',<?=$row['FT_Turn_F']?>,1,<?=$ag_row['FT_Turn_F']?>,'FT');">Sửa đổi</a></td>
  </tr>
</table>
<BR>
<table width='780' border="0" cellspacing="0" cellpadding="0">
<tr>
<td align='left'>
<table width="580" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit"> 
    <td>Bóng rổ</td>
    <td width="68">Hãy để bóng</td>
    <td width="68">Kích thước</td>
    <td width="68">Cán bóng</td>
    <td width="68">Kích thước</td>
    <td width="68">Đơn và đôi</td>
    <td width="68">Để bóng chuyền</td>
    <td width="68">Giải phóng</td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right" class="m_ag_ed">Cài đặt thu:</td>
    <td><?=$row['BK_Turn_R']?></td>
    <td><?=$row['BK_Turn_OU']?></td>
    <td><?=$row['BK_Turn_RE']?></td>
    <td><?=$row['BK_Turn_ROU']?></td>
    <td><?=$row['BK_Turn_EO']?></td>
    <td><?=$row['BK_Turn_PR']?></td>
    <td><?=$row['BK_Turn_PC']?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">Giới hạn đơn:</td>
    <td><?=$row['BK_R_Scene']?></td>
    <td><?=$row['BK_OU_Scene']?></td>
    <td><?=$row['BK_RE_Scene']?></td>
    <td><?=$row['BK_ROU_Scene']?></td>
    <td><?=$row['BK_EO_Scene']?></td>
    <td><?=$row['BK_PR_Scene']?></td>
    <td><?=$row['BK_PC_Scene']?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">Giới hạn ghi:</td>
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
	<td><a href='javascript:void(0)' onClick="show_win('Bóng rổ - hãy để bóng','R','<?=$row['BK_R_Scene']?>','<?=$row['BK_R_Bet']?>',<?=$row['BK_Turn_R']?>,0.25,<?=$bk_r_turn?>,'BK');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng rổ - lên và xuống','OU','<?=$row['BK_OU_Scene']?>','<?=$row['BK_OU_Bet']?>',<?=$row['BK_Turn_OU']?>,0.25,<?=$bk_ou_turn?>,'BK');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng rổ - bóng lăn','RE','<?=$row['BK_RE_Scene']?>','<?=$row['BK_RE_Bet']?>',<?=$row['BK_Turn_RE']?>,0.25,<?=$bk_re_turn?>,'BK');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng rổ - kích thước bóng','ROU','<?=$row['BK_ROU_Scene']?>','<?=$row['BK_ROU_Bet']?>',<?=$row['BK_Turn_ROU']?>,0.25,<?=$bk_rou_turn?>,'BK');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng rổ - đơn và đôi','EO','<?=$row['BK_EO_Scene']?>','<?=$row['BK_EO_Bet']?>',<?=$row['BK_Turn_EO']?>,0.25,<?=$bk_eo_turn?>,'BK');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng rổ - chuyền bóng','PR','<?=$row['BK_PR_Scene']?>','<?=$row['BK_PR_Bet']?>',<?=$row['BK_Turn_PR']?>,1,<?=$ag_row['BK_Turn_PR']?>,'BK');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng rổ - giải phóng','PC','<?=$row['BK_PC_Scene']?>','<?=$row['BK_PC_Bet']?>',<?=$row['BK_Turn_PC']?>,1,<?=$ag_row['BK_Turn_PC']?>,'BK');">Sửa đổi</a></td>
  </tr>
</table>
</td>
<td align='right'>
<table width="150" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit"> 
    <td>Quán quân</td>
    <td width="68">Quán quân</td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right" class="m_ag_ed">Cài đặt thu:</td>
    <td><?=$row['FS_Turn_R']?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">Giới hạn đơn:</td>
    <td><?=$row['FS_R_Scene']?></td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right"class="m_ag_ed">Giới hạn ghi:</td>
    <td><?=$row['FS_R_Bet']?></td>
  </tr>
  <tr  class="m_cen">
    <td align="right"class="m_ag_ed">&nbsp;</td>
    <td><a href='javascript:void(0)' onClick="show_win('Quán quân - Quán quân','R','<?=$row['FS_R_Scene']?>','<?=$row['FS_R_Bet']?>',<?=$row['FS_Turn_R']?>,1,<?=$ag_row['FS_Turn_R']?>,'FS');"> Sửa đổi</a></td>
  </tr>
</table>
</td>
</tr>
</table>
<BR>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
      <td> quần vợt </td>
      <td width = "68"> Đưa bóng </td>
      <td width = "68"> Kích thước </td>
      <td width = "68"> Lăn bóng </td>
      <td width = "68"> Kích thước bi lăn </td>
      <td width = "68"> Đơn và đôi </td>
      <td width = "68"> Chỉ giành chiến thắng </td>
      <td width = "68"> Giải phóng mặt bằng tiêu chuẩn </td>
      <td width = "68"> Để bóng đi qua </td>
      <td width = "68"> Giải phóng mặt bằng toàn diện </td>
      <td width = "68"> Làn sóng </td>
      <td width = "68"> Đi vào bóng </td>
      <td width = "68"> Half full court </td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right" class="m_ag_ed" nowrap>Cài đặt thu</td>
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
    <td align="right"class="m_ag_ed">Giới hạn đơn</td>
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
    <td align="right"class="m_ag_ed">Giới hạn ghi</td>
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
	<td><a href='javascript:void(0)' onClick="show_win('Tennis - để bóng','R','<?=$row['TN_R_Scene']?>','<?=$row['TN_R_Bet']?>',<?=$row['TN_Turn_R']?>,0.25,<?=$tn_r_turn?>,'TN');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Tennis - lớn và nhỏ','OU','<?=$row['TN_OU_Scene']?>','<?=$row['TN_OU_Bet']?>',<?=$row['TN_Turn_OU']?>,0.25,<?=$tn_ou_turn?>,'TN');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Quần vợt - bóng lăn','RE','<?=$row['TN_RE_Scene']?>','<?=$row['TN_RE_Bet']?>',<?=$row['TN_Turn_RE']?>,0.25,<?=$tn_re_turn?>,'TN');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Quần vợt - kích thước','ROU','<?=$row['TN_ROU_Scene']?>','<?=$row['TN_ROU_Bet']?>',<?=$row['TN_Turn_ROU']?>,0.25,<?=$tn_rou_turn?>,'TN');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Tennis - đơn và đôi','EO','<?=$row['TN_EO_Scene']?>','<?=$row['TN_EO_Bet']?>',<?=$row['TN_Turn_EO']?>,0.25,<?=$tn_eo_turn?>,'TN');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Tennis - thắng','M','<?=$row['TN_M_Scene']?>','<?=$row['TN_M_Bet']?>',<?=$row['TN_Turn_M']?>,1,<?=$ag_row['TN_Turn_M']?>,'TN');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Tennis - giải phóng','P','<?=$row['TN_P_Scene']?>','<?=$row['TN_P_Bet']?>',<?=$row['TN_Turn_P']?>,1,<?=$ag_row['TN_Turn_P']?>,'TN');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Tennis - để bóng chuyền','PR','<?=$row['TN_PR_Scene']?>','<?=$row['TN_PR_Bet']?>',<?=$row['TN_Turn_PR']?>,1,<?=$ag_row['TN_Turn_PR']?>,'TN');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Tennis - giải phóng','PC','<?=$row['TN_PC_Scene']?>','<?=$row['TN_PC_Bet']?>',<?=$row['TN_Turn_PC']?>,1,<?=$ag_row['TN_Turn_PC']?>,'TN');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Tennis - Làn sóng','PD','<?=$row['TN_PD_Scene']?>','<?=$row['TN_PD_Bet']?>',<?=$row['TN_Turn_PD']?>,1,<?=$ag_row['TN_Turn_PD']?>,'TN');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Tennis - mục tiêu','T','<?=$row['TN_T_Scene']?>','<?=$row['TN_T_Bet']?>',<?=$row['TN_Turn_T']?>,1,<?=$ag_row['TN_Turn_T']?>,'TN');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Sân quần - bán toàn','F','<?=$row['TN_F_Scene']?>','<?=$row['TN_F_Bet']?>',<?=$row['TN_Turn_F']?>,1,<?=$ag_row['TN_Turn_F']?>,'TN');">Sửa đổi</a></td>
  </tr>
 </table>
<BR>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit"> 
    <td>Bóng chuyền </td>
      <td width = "68"> Đưa bóng </td>
      <td width = "68"> Kích thước </td>
      <td width = "68"> Lăn bóng </td>
      <td width = "68"> Kích thước bi lăn </td>
      <td width = "68"> Đơn và đôi </td>
      <td width = "68"> Chỉ giành chiến thắng </td>
      <td width = "68"> Giải phóng mặt bằng tiêu chuẩn </td>
      <td width = "68"> Để bóng đi qua </td>
      <td width = "68"> Giải phóng mặt bằng toàn diện </td>
      <td width = "68"> Làn sóng </td>
      <td width = "68"> Đi vào bóng </td>
      <td width = "68"> Half full court </td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right" class="m_ag_ed" nowrap>Cài đặt thu</td>
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
    <td align="right"class="m_ag_ed">Giới hạn đơn</td>
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
    <td align="right"class="m_ag_ed">Giới hạn ghi</td>
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
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chuyền - để bóng','R','<?=$row['VB_R_Scene']?>','<?=$row['VB_R_Bet']?>',<?=$row['VB_Turn_R']?>,0.25,<?=$r_turn?>,'VB');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chuyền - lớn và nhỏ','OU','<?=$row['VB_OU_Scene']?>','<?=$row['VB_OU_Bet']?>',<?=$row['VB_Turn_OU']?>,0.25,<?=$vb_ou_turn?>,'VB');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chuyền','RE','<?=$row['VB_RE_Scene']?>','<?=$row['VB_RE_Bet']?>',<?=$row['VB_Turn_RE']?>,0.25,<?=$vb_re_turn?>,'VB');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chuyền - kích thước bóng','ROU','<?=$row['VB_ROU_Scene']?>','<?=$row['VB_ROU_Bet']?>',<?=$row['VB_Turn_ROU']?>,0.25,<?=$vb_rou_turn?>,'VB');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chuyền - đơn và đôi','EO','<?=$row['VB_EO_Scene']?>','<?=$row['VB_EO_Bet']?>',<?=$row['VB_Turn_EO']?>,0.25,<?=$vb_eo_turn?>,'VB');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chuyền - giành chiến thắng','M','<?=$row['VB_M_Scene']?>','<?=$row['VB_M_Bet']?>',<?=$row['VB_Turn_M']?>,1,<?=$ag_row['VB_Turn_M']?>,'VB');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chuyền-Tiêu chuẩn giải','P','<?=$row['VB_P_Scene']?>','<?=$row['VB_P_Bet']?>',<?=$row['VB_Turn_P']?>,1,<?=$ag_row['VB_Turn_P']?>,'VB');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chuyền-Để bóng chuyền','PR','<?=$row['VB_PR_Scene']?>','<?=$row['VB_PR_Bet']?>',<?=$row['VB_Turn_PR']?>,1,<?=$ag_row['VB_Turn_PR']?>,'VB');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chuyền-Giải phóng mặt','PC','<?=$row['VB_PC_Scene']?>','<?=$row['VB_PC_Bet']?>',<?=$row['VB_Turn_PC']?>,1,<?=$ag_row['VB_Turn_PC']?>,'VB');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chuyền-Làn sóng','PD','<?=$row['VB_PD_Scene']?>','<?=$row['VB_PD_Bet']?>',<?=$row['VB_Turn_PD']?>,1,<?=$ag_row['VB_Turn_PD']?>,'VB');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chuyền-Mục tiêu','T','<?=$row['VB_T_Scene']?>','<?=$row['VB_T_Bet']?>',<?=$row['VB_Turn_T']?>,1,<?=$ag_row['VB_Turn_T']?>,'VB');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chuyền-Trường toàn','F','<?=$row['VB_F_Scene']?>','<?=$row['VB_F_Bet']?>',<?=$row['VB_Turn_F']?>,1,<?=$ag_row['VB_Turn_F']?>,'VB');">Sửa đổi</a></td>
  </tr>
</table>
<BR>
<table width="780" border="0" cellspacing="1" cellpadding="0" class="m_tab_ed">
  <tr class="m_title_edit">
      <td> Bóng chày </td>
      <td width = "68"> Đưa bóng </td>
      <td width = "68"> Kích thước </td>
      <td width = "68"> Lăn bóng </td>
      <td width = "68"> Kích thước bi lăn </td>
      <td width = "68"> Đơn và đôi </td>
      <td width = "68"> Chỉ giành chiến thắng </td>
      <td width = "68"> Giải phóng mặt bằng tiêu chuẩn </td>
      <td width = "68"> Để bóng đi qua </td>
      <td width = "68"> Giải phóng mặt bằng toàn diện </td>
      <td width = "68"> Làn sóng </td>
      <td width = "68"> Tổng điểm </td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right" class="m_ag_ed" nowrap>Cài đặt thu</td>
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
    <td align="right"class="m_ag_ed">Giới hạn đơn</td>
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
    <td align="right"class="m_ag_ed">Giới hạn ghi</td>
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
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chày-Hãy để bóng','R','<?=$row['BS_R_Scene']+0?>','<?=$row['BS_R_Bet']+0?>',<?=$row['BS_Turn_R']+0?>,0.25,<?=$bs_r_turn?>,'BS');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chày-Tấm kích thước','OU','<?=$row['BS_OU_Scene']+0?>','<?=$row['BS_OU_Bet']+0?>',<?=$row['BS_Turn_OU']+0?>,0.25,<?=$bs_ou_turn?>,'BS');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chày-Cán bóng','RE','<?=$row['BS_RE_Scene']+0?>','<?=$row['BS_RE_Bet']+0?>',<?=$row['BS_Turn_RE']+0?>,0.25,<?=$bs_re_turn?>,'BS');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chày-Kích thước','ROU','<?=$row['BS_ROU_Scene']+0?>','<?=$row['BS_ROU_Bet']+0?>',<?=$row['BS_Turn_ROU']+0?>,0.25,<?=$bs_rou_turn?>,'BS');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chày-Đơn và đôi','EO','<?=$row['BS_EO_Scene']+0?>','<?=$row['BS_EO_Bet']+0?>',<?=$row['BS_Turn_EO']+0?>,0.25,<?=$bs_eo_turn?>,'BS');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chày-Giành chiến thắng','M','<?=$row['BS_M_Scene']+0?>','<?=$row['BS_M_Bet']+0?>',<?=$row['BS_Turn_M']+0?>,1,<?=$ag_row['BS_Turn_M']+0?>,'BS');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chày-Tiêu chuẩn','P','<?=$row['BS_P_Scene']+0?>','<?=$row['BS_P_Bet']+0?>',<?=$row['BS_Turn_P']+0?>,1,<?=$ag_row['BS_Turn_P']+0?>,'BS');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chày-Để bóng chuyền','PR','<?=$row['BS_PR_Scene']+0?>','<?=$row['BS_PR_Bet']+0?>',<?=$row['BS_Turn_PR']+0?>,1,<?=$ag_row['BS_Turn_PR']+0?>,'BS');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chày-Giải phóng','PC','<?=$row['BS_PC_Scene']+0?>','<?=$row['BS_PC_Bet']+0?>',<?=$row['BS_Turn_PC']+0?>,1,<?=$ag_row['BS_Turn_PC']+0?>,'BS');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chày-Làn sóng','PD','<?=$row['BS_PD_Scene']+0?>','<?=$row['BS_PD_Bet']+0?>',<?=$row['BS_Turn_PD']+0?>,1,<?=$ag_row['BS_Turn_PD']+0?>,'BS');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Bóng chày-Tổng số điểm','T','<?=$row['BS_T_Scene']+0?>','<?=$row['BS_T_Bet']+0?>',<?=$row['BS_Turn_T']+0?>,1,<?=$ag_row['BS_Turn_T']+0?>,'BS');">Sửa đổi</a></td>
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
    <td>Khác  </td>
      <td width = "68"> Đưa bóng </td>
      <td width = "68"> Kích thước </td>
      <td width = "68"> Lăn bóng </td>
      <td width = "68"> Kích thước bi lăn </td>
      <td width = "68"> Đơn và đôi </td>
      <td width = "68"> Chỉ giành chiến thắng </td>
      <td width = "68"> Giải phóng mặt bằng tiêu chuẩn </td>
      <td width = "68"> Để bóng đi qua </td>
      <td width = "68"> Giải phóng mặt bằng toàn diện </td>
      <td width = "68"> Làn sóng </td>
      <td width = "68"> Đi vào bóng </td>
      <td width = "68"> Half full court </td>
  </tr>
  <tr  class="m_cen"> 
    <td align="right" class="m_ag_ed" nowrap>Cài đặt thu</td>
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
    <td align="right"class="m_ag_ed">Giới hạn đơn</td>
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
    <td align="right"class="m_ag_ed">Giới hạn ghi</td>
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
	<td><a href='javascript:void(0)' onClick="show_win('Khác -Hãy để bóng','R','<?=$row['OP_R_Scene']+0?>','<?=$row['OP_R_Bet']+0?>',<?=$row['OP_Turn_R']+0?>,0.25,<?=$op_r_turn?>,'OP');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Khác -Tấm kích thước','OU','<?=$row['OP_OU_Scene']+0?>','<?=$row['OP_OU_Bet']+0?>',<?=$row['OP_Turn_OU']+0?>,0.25,<?=$op_ou_turn?>,'OP');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Khác -Cán bóng','RE','<?=$row['OP_RE_Scene']+0?>','<?=$row['OP_RE_Bet']+0?>',<?=$row['OP_Turn_RE']+0?>,0.25,<?=$op_re_turn?>,'OP');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Khác -Kích thước','ROU','<?=$row['OP_ROU_Scene']+0?>','<?=$row['OP_ROU_Bet']+0?>',<?=$row['OP_Turn_ROU']+0?>,0.25,<?=$op_rou_turn?>,'OP');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Khác -Đơn và đôi','EO','<?=$row['OP_EO_Scene']+0?>','<?=$row['OP_EO_Bet']+0?>',<?=$row['OP_Turn_EO']+0?>,0.25,<?=$op_eo_turn?>,'OP');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Khác -Giành chiến','M','<?=$row['OP_M_Scene']+0?>','<?=$row['OP_M_Bet']+0?>',<?=$row['OP_Turn_M']+0?>,1,<?=$ag_row['OP_Turn_M']+0?>,'OP');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Khác -Tiêu chuẩn','P','<?=$row['OP_P_Scene']+0?>','<?=$row['OP_P_Bet']+0?>',<?=$row['OP_Turn_P']+0?>,1,<?=$ag_row['OP_Turn_P']+0?>,'OP');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Khác -Để bóng chuyền','PR','<?=$row['OP_PR_Scene']+0?>','<?=$row['OP_PR_Bet']+0?>',<?=$row['OP_Turn_PR']+0?>,1,<?=$ag_row['OP_Turn_PR']+0?>,'OP');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Khác -Giải phóng','PC','<?=$row['OP_PC_Scene']+0?>','<?=$row['OP_PC_Bet']+0?>',<?=$row['OP_Turn_PC']+0?>,1,<?=$ag_row['OP_Turn_PC']+0?>,'OP');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Khác -Làn sóng','PD','<?=$row['OP_PD_Scene']+0?>','<?=$row['OP_PD_Bet']+0?>',<?=$row['OP_Turn_PD']+0?>,1,<?=$ag_row['OP_Turn_PD']+0?>,'OP');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Khác -Mục tiêu','T','<?=$row['OP_T_Scene']+0?>','<?=$row['OP_T_Bet']+0?>',<?=$row['OP_Turn_T']+0?>,1,<?=$ag_row['OP_Turn_T']+0?>,'OP');">Sửa đổi</a></td>
	<td><a href='javascript:void(0)' onClick="show_win('Khác -Trường toàn','F','<?=$row['OP_F_Scene']+0?>','<?=$row['OP_F_Bet']+0?>',<?=$row['OP_Turn_F']+0?>,1,<?=$ag_row['OP_Turn_F']+0?>,'OP');">Sửa đổi</a></td>
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
                <td  id=r_title width="200"><font color="#FFFFFF">Vui lòng nhập</font></td>
                <td align="right" valign="top"><a style="cursor:hand;" onClick="close_win();"><img src="/images/control/zh-tw/edit_dot.gif" width="16" height="14"></a></td>
              </tr>
              <tr> 
                <td colspan="2" height="1" bgcolor="#000000"></td>
              </tr>
              <tr> 
                <td colspan="2">Cài đặt thu&nbsp;&nbsp;
                <select class="za_select" name="war_set">
                </select>
                </td>
              </tr>
              <tr bgcolor="#000000"> 
                <td colspan="2" height="1"></td>
              </tr>
              <tr> 
                <td colspan="2">Giới hạn đơn&nbsp;&nbsp;
                <input type=TEXT id=ft_b4_1 name="SC" value="" size=12 maxlength=12 class="za_text" onKeyUp="Chg_Sc_Mcy();count_so();Chg_So_Mcy();">
                    Đô la Mỹ:<font color="#FF0033" id="mcy_sc">0</font></td>
              </tr>
              <tr bgcolor="#000000"> 
                <td colspan="2" height="1"></td>
              </tr>
              <tr> 
                <td colspan="2">Giới hạn ghi&nbsp;&nbsp;
                <input type=TEXT id=ft_b4_1 name="SO" value="" size=12 maxlength=12 class="za_text" onKeyUp="Chg_So_Mcy();">
                    Đô la Mỹ: <font color="#FF0033" id="mcy_so">0</font></td>
              </tr>
              <tr bgcolor="#000000"> 
                <td colspan="2" height="1"></td>
              </tr>
              
            <tr align="center"> 
              <td colspan="2"> 
                <input type=submit name=rs_ok value="Xác định" class="za_button">
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

