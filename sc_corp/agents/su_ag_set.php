<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require ("../../member/include/config.inc.php");
require ("../../member/include/define_function_list.inc.php");
require ("../../inc/ag_set.inc.php");

$uid=$_REQUEST["uid"];

$sql = "select Agname,ID,language,Credit from web_super where Oid='$uid'";
$result = mysql_query($sql);
$cou=mysql_num_rows($result);

if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}

$langx='zh-cn';
require ("../../member/include/traditional.$langx.inc.php");

$mid=$_REQUEST["id"];
$wid=$_REQUEST["wid"];
$act=$_REQUEST["act"];
$rtype=$_REQUEST['rtype'];
$sc=$_REQUEST['SC'];
$so=$_REQUEST['SO'];
$st=$_REQUEST['war_set'];
$kind=$_REQUEST['kind'];

$id=$_REQUEST["id"];

$sql = "select * from web_agents where ID=$mid";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agents_name=$row["Agname"];
$alias=$row["Alias"];

$mysql = "select * from web_world where agname='$wid'";
$wd_result = mysql_query($mysql);

$cou=mysql_num_rows($wd_result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$wd_row = mysql_fetch_array($wd_result);
$agents_id=$wd_row["ID"];

$war_set_1=$_REQUEST["war_set_1"];
$war_set_2=$_REQUEST["war_set_2"];
$war_set_3=$_REQUEST["war_set_3"];
$war_set_4=$_REQUEST["war_set_4"];
if ($war_set_2!=''){
	$sc=$_REQUEST['SC'];
	$so=$_REQUEST['SO'];
	$updsql=$kind."_Turn_".$rtype."_A='".$war_set_1."',".$kind."_Turn_".$rtype."_B='".$war_set_2."',".$kind."_Turn_".$rtype."_C='".$war_set_3."',".$kind."_Turn_".$rtype."_D='".$war_set_4."'";
}else{
	$sc=$_REQUEST['SC_2'];
	$so=$_REQUEST['SO_2'];
	$updsql=$kind."_Turn_".$rtype."='".$war_set_1."'";
}
$st=$war_set;
if ($act=='Y'){

	$ag_scene=$kind.'_'.$rtype."_Scene";
	$ag_bet=$kind.'_'.$rtype."_Bet";
	$agscene=$wd_row[$ag_scene];
	$agbet=$wd_row[$ag_bet];
	
	if ($sc>$agscene){
		echo wterror("此代理商的单场限额已超过总代理商的单场限额，请回上一面重新输入");
		exit;
	}
	if ($so>$agbet){
		echo wterror("此代理商的单注限额已超过总代理商的单注限额，请回上一面重新输入");
		exit;
	}


	$mysql="update web_agents set ".$kind.'_'.$rtype."_Scene='".$sc."',".$kind.'_'.$rtype."_Bet='".$so."',".$updsql." where ID=$id";	
	mysql_query($mysql) or die ("操作失败!");
	
	$sql_w="select * from web_member where Agents='".$agents_name."'";
	$result_w = mysql_query($sql_w);
	while($row_w = mysql_fetch_array($result_w)){
		$agscene_w=$row_w[$ag_scene];
		$agbet_w=$row_w[$ag_bet];
		$upd="";
		if($row_w['OpenType']=='A' ){
			$upd=$kind."_Turn_".$rtype."='".$war_set_1."',".$upd;
		}
		if($row_w['OpenType']=='B' ){
			$upd=$kind."_Turn_".$rtype."='".$war_set_2."',".$upd;
		}
		if($row_w['OpenType']=='C'){
			$upd=$kind."_Turn_".$rtype."='".$war_set_3."',".$upd;
		}
		if($row_w['OpenType']=='D'){
			$upd=$kind."_Turn_".$rtype."='".$war_set_4."',".$upd;
		}
		$sl="";
		if($agscene_w>$sc){
			$sl=$sl.$ag_scene."='".$sc."', ";
		}
		if($agbet_w>$so){
			$sl=$sl.$ag_bet."='".$so."', ";
		}
		$upd=$upd.$sl;
		
		
		echo $mysql_w="update web_member set ".$upd." Agents='".$agents_name."' where ID='".$row_w['ID']."'";
		mysql_query($mysql_w) or die ("操作失败!");
		
	}
	
	echo "<script language='javascript'>self.location='su_ag_set.php?uid=$uid&id=$mid&wid=$wid';</script>";
}

?>
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
<script language="javascript1.2" src="/js/ag_set.js"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF">
 <INPUT TYPE=HIDDEN NAME="id" VALUE="<?=$mid?>">
  <INPUT TYPE=HIDDEN NAME="sid" VALUE="<?=$agents_id?>">
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="m_tline">&nbsp;&nbsp;代理商详细设定&nbsp;&nbsp;&nbsp;<?=$sub_user?>:<?=$agents_name?> -- 
      <?=$sub_name?>:<?=$alias?> -- <a href="./su_agents.php?uid=<?=$uid?>">回上一页</a></td>
    <td width="30"><img src="/images/control/zh-tw/top_04.gif" width="30" height="24"></td>
  </tr>
  <tr> 
    <td colspan="2" height="4"></td>
  </tr>
</table>
<?
echo get_set_table($row,$wd_row);
echo get_rs_window($sid,$mid);
?>
<BR><BR><BR>
</body>
</html>
