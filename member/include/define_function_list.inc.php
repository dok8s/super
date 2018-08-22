<?

foreach ($_GET as $get_key=>$get_var)
{
    if (is_numeric($get_var))
 if (is_numeric($get_var)) {
  $get[strtolower($get_key)] = get_int($get_var);
 } else {
  $get[strtolower($get_key)] = get_str($get_var);
 }
}

/* 过滤所有POST过来的变量 */
foreach ($_POST as $post_key=>$post_var)
{
 if (is_numeric($post_var)) {
  $post[strtolower($post_key)] = get_int($post_var);
 } else {
  $post[strtolower($post_key)] = get_str($post_var);
 }
}

//判断编码utf8
function is_utf8($liehuo_net) 
{ 
	if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$liehuo_net) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$liehuo_net) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$liehuo_net) == true) { 
		return true; 
	} 
	else 
	{ 
		return false; 
	}
}
/* 过滤函数 */
//整型过滤函数
function get_int($number)
{
    return intval($number);
}
//字符串型过滤函数
function get_str($string)
{
    if (!get_magic_quotes_gpc()) {
 return addslashes($string);
    }
    return $string;
}
function TDate(){
	//$rq = array("2008-12-29","2009-01-26","2009-02-23","2009-03-23","2009-04-20","2009-05-18","2009-06-15","2009-07-13","2009-08-10","2009-09-07","2009-10-05","2009-11-02","2009-11-30","2009-12-28");
	$rq = array();
	$timestart = strtotime('2015-12-28');
	$D = 3600*24;
	$Q = $D*7*4;
	for($i=0; $i<13; $i++){
			$Q = $D*7*4;
			$rq[] = date('Y-m-d', $timestart+$i*$Q);
	}

	$t=date('Y-m-d',time()-3*24*3600);
	for($i=1;$i<=count($rq);$i++){
		if($rq[$i]>$t){
			$mon=$i;
			$nowday[0]=$rq[$mon-1];
			$Date_List_1=explode("-",$rq[$mon]);
			$d1=mktime(0,0,0,$Date_List_1[1],$Date_List_1[2],$Date_List_1[0]);
			$nowday[1]=date('Y-m-d',$d1-24*60*60);
			$nowday[2]='Y_'.$mon;
			return $nowday;
		}
	}
}

function change_rate($c_type,$c_rate){
	switch($c_type){
	case 'A':
		$t_rate='0.03';
		break;
	case 'B':
		$t_rate='0.01';
		break;
	case 'C':
		$t_rate='0';
		break;
	case 'D':
		$t_rate='-0.015';
		break;
	}

	$change_rate=number_format($c_rate-$t_rate,3);
	if ($change_rate<=0){
		$change_rate='';
	}
	return $change_rate;
}

function wterror($msg){
$test='<html>
<head>
<title>error</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<STYLE> A:visit {color="#6633cc"; text-decoration: none ;}
tr {font-family: "Arial"; font-size: 12px; color: #CC0000}
.b_13set {font-size: 15px; font-family: "Arial"; color: #FFFFFF; padding-top: 2px; padding-left: 5px}
.b_tab {border: 1px #000000 solid; background-color: #D2D2D2}
.b_back {height: 20px; padding-top: 5px; color: #FFFFFF; cursor: hand; padding-left: 50px}
a:link {color: #0000FF}
a:hover {color: #CC0000}
a:visited {color: #0000FF}
</STYLE>
</head>

<body oncontextmenu="window.event.returnValue=false" text="#000000" leftmargin="0" topmargin="10" bgcolor="#535E63" vlink="#0000FF" alink="#0000FF">
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td width="36"><img src="/images/control/error_p11.gif" width="36" height="63"></td>
		<td background="/images/control/error_p12b.gif">&nbsp;</td>
		<td width="160"><img src="/images/control/error_p13.gif" width="160" height="63"></td>
	</tr>
</table>
<table width="598" border="0" cellspacing="0" cellpadding="0" align="center" class="b_tab">
	<tr bgcolor="#000000">
		<td><img src="/images/control/error_dot.gif" width="23" height="22"></td>
		<td class="b_13set" width="573">错&nbsp;误&nbsp;讯&nbsp;息</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><br>'.$msg.'<br>
			&nbsp; </td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="598" border="0" cellspacing="0" cellpadding="0" bgcolor="#A0A0A0">
				<tr>
					<td>&nbsp;</td>
					<td background="/images/control/error_p3.gif" width="120"><a href="javascript:window.history.go(-3)"><span class="b_back">回上一页</span></a></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>';
	return $test;
}

function odds_dime($mbin1,$tgin1,$dime,$mtype){

	$dime=str_replace('大','',$dime);
	$dime=str_replace('小','',$dime);
	$dime=str_replace('o','',$dime);
	$dime=str_replace('u','',$dime);
	$dime=str_replace('O','',$dime);
	$dime=str_replace('U','',$dime);
	$total_inball=$mbin1+$tgin1;

	$dime_odds=explode("/",$dime);
	switch (sizeof($dime_odds)){
	case 1:
		$odds_inball=$total_inball-$dime_odds[0];
		switch ($mtype){//下大
		case 'C':
			if ($odds_inball>0){
				$grape=1;
			}else if ($odds_inball<0){
				$grape=-1;
			}else{
				$grape=0;
			}
			break;
		case 'H':
			if ($odds_inball>0){
				$grape=-1;
			}else if ($odds_inball<0){
				$grape=1;
			}else{
				$grape=0;
			}
			break;
		}
		break;
	case 2:
		if (ceil($dime_odds[0])==$dime_odds[0]){
			$odds_inball=$total_inball-$dime_odds[0];
			switch ($mtype){
			case "C":
				if ($odds_inball>0){
					$grape=1;
				}else if($odds_inball<0){
					$grape=-1;
				}else if($odds_inball==0){
					$grape=-0.5;
				}
				break;
			case "H":
				if ($odds_inball>0){
					$grape=-1;
				}else if($odds_inball<0){
					$grape=1;
				}else if($odds_inball==0){
					$grape=0.5;
				}
				break;
			}
		}else{
			$odds_inball=$total_inball-$dime_odds[1];
			switch ($mtype){
			case "C":
				if ($odds_inball>0){
					$grape=1;
				}else if($odds_inball<0){
					$grape=-1;
				}else if($odds_inball==0){
					$grape=0.5;
				}
				break;
			case "H":
				if ($odds_inball>0){
					$grape=-1;
				}else if($odds_inball<0){
					$grape=1;
				}else if($odds_inball==0){
					$grape=-0.5;
				}
				break;
			}
		}
		break;
	}
	$odds_dime=$grape;
	return $odds_dime;
}
//让球计算:
function odds_letb($mbin,$tgin,$showtype,$dime,$mtype){
	$letb_odds=explode("/",$dime);
	switch (sizeof($letb_odds)){
	case 1:
		if (strlen($letb_odds[0])>2){

			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'H':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				case 'C':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin-$letb_odds[0];
				switch ($mtype){
				case 'H':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}
					break;
				case 'C':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}
					break;
				}
				break;
			}
		}else{
			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'H':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'C':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin-$letb_odds[0];
				switch ($mtype){
				case 'H':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				case 'C':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0;
					}
					break;
				}
				break;
			}


		}
		break;
	case 2:
		if (strlen($letb_odds[1])>2){
		//半球在后1/1.5

			switch ($showtype){
			case "H"://让球方是主队
				$abcd=$mbin-$tgin-$letb_odds[0];
				switch ($mtype){
				case 'H':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=-0.5;
					}
					break;
				case 'C':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0.5;
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin-$letb_odds[0];
				switch ($mtype){
				case 'H':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=0.5;
					}
					break;
				case 'C':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=-0.5;
					}
					break;
				}
				break;
			}
		}else{

			switch ($showtype){

			case "H"://让球方是主队0.5/1

				$abcd=$mbin-$tgin-$letb_odds[1];

				switch ($mtype){
				case 'H':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0.5;
					}
					break;
				case 'C':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=-0.5;
					}
					break;
				}
				break;
			case "C"://让球方是客队
				$abcd=$tgin-$mbin-$letb_odds[1];
				switch ($mtype){
				case 'H':
					if ($abcd<0){
						$grade=1;
					}else if($abcd>0){
						$grade=-1;
					}else if($abcd==0){
						$grade=-0.5;
					}
					break;
				case 'C':
					if ($abcd<0){
						$grade=-1;
					}else if($abcd>0){
						$grade=1;
					}else if($abcd==0){
						$grade=0.5;
					}
					break;
				}
				break;
			}
		}
		break;
	}

	$odds_letb=$grade;
	return $odds_letb;
}

function odds_pd($mb_in_score,$tg_in_score,$m_place){

	$betplace='MB'.$mb_in_score.'TG'.$tg_in_score;
	if ($m_place=='OVMB' and $mb_in_score-$tg_in_score>4){
		$grade=1;
	}elseif ($m_place=='OVTG' and $tg_in_score-$mb_in_score>4){
		$grade=1;
	}elseif ($m_place==$betplace){
		$grade=1;
	}else{
		$grade=-1;
	}

	$odds_pd=$grade;
	return $odds_pd;
}

function odds_half($mb_in_score_hr,$tg_in_score_hr,$mb_in_score,$tg_in_score,$m_place){
	$grade=0;
	if ($mb_in_score_hr>$tg_in_score_hr){
		$m_w1="H";
	}elseif ($mb_in_score_hr==$tg_in_score_hr){
		$m_w1="N";
	}else{
		$m_w1="C";
	}

	if ($mb_in_score>$tg_in_score){
		$m_w2="H";
	}elseif ($mb_in_score==$tg_in_score){
		$m_w2="N";
	}else{
		$m_w2="C";
	}
	$m_w="F$m_w1$m_w2";
	if ($m_place==$m_w){
		$grade=1;
	}else{
		$grade=-1;
	}
	$odds_half=$grade;
	return $odds_half;
}

function win_chk($mbin,$tgin,$m_type){
	$grade=0;
	switch ($m_type){
	case 'H':
		if ($mbin>$tgin){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'C':
		if ($mbin<$tgin){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	case 'N':
		if ($mbin==$tgin){
			$grade=1;
		}else{
			$grade=-1;
		}
		break;
	}
	$win_chk=$grade;
	return $win_chk;
}

function odds_p($mid,$mtype,$mrate){
		$winrate=1;
		$mid=explode(',',$mid);
		$mtype=explode(',',$mtype);
		$rate1=explode(',',$mrate);
		for($i=0;$i<sizeof($mid);$i++){
			$sql="select MB_Inball,TG_Inball from foot_match where ID=".$mid[$i];
			$result1 = mysql_query( $sql);
			$rowr = mysql_fetch_array($result1);
			$mb_in=$rowr['MB_Inball'];
			$tg_in=$rowr['TG_Inball'];
			if ($mb_in<>'' and $tg_in<>''){
				$graded=win_chk($mb_in,$tg_in,$mtype[$i]);
				switch ($graded){
				case "1":
					$winrate=$winrate*($rate1[$i]);
					break;
				case "-1":
					$winrate=0;
					break;
				case "0":
					$winrate=0;
					break;
				}
			}else{
					$winrate=0;
			}

		}
		$odd_p=$winrate;
		return $odd_p;
}

function odd_pr($mid,$mtype,$mrate,$mplace,$showtype){
		$winrate=1;
		$mid=explode(',',$mid);
		$mtype=explode(',',$mtype);
		$rate=explode(',',$mrate);
		$letb=explode(',',$mplace);
		$show=explode(',',$showtype);
		$cou=sizeof($mid);
		$count=0;
		for($i=0;$i<$cou;$i++){
			$sql="select MB_Inball,TG_Inball from foot_match where ID=".$mid[$i];
			$result1 = mysql_query( $sql);
			$rowr = mysql_fetch_array($result1);
			$mb_in=$rowr['MB_Inball'];
			$tg_in=$rowr['TG_Inball'];
			$graded=letb_chk($mb_in,$tg_in,$show[$i],$letb[$i],$mtype[$i]);
			switch ($graded){
			case "1":
				$winrate=$winrate*(1+$rate[i]);
				break;
			case "-1":
				$winrate=0;
				break;
			case "0":
				$winrate=$winrate;
				break;
			case "0.5":
				$winrate=$winrate*(1+$rate[i]/2);
				break;
			case "-0.5":
				if ($count>1){
					$winrate=0;
				}else{
					$winrate=$winrate*(1/2);
				}

				$count=$count+1;
				break;
			}
		}
		$odd_pr=$winrate;
		return $odd_pr;
}

function show_voucher($line,$id){

	$id=$id+1000000000;
	switch($line){
	case 4:
		$show_voucher='DT48'.substr(($id-002714),2);
		break;
	case 34:
		$show_voucher='DT48'.substr(($id-002714),2);
		break;
	case 5:
		$show_voucher='DT48'.substr(($id-002714),2);
		break;
	case 15:
		$show_voucher='DT48'.substr(($id-002714),2);
		break;
	case 17:
		$show_voucher='PM48'.substr(($id-002714),2);
		break;
	case 25:
		$show_voucher='DT48'.substr(($id-002714),2);
		break;
	case 104:
		$show_voucher='DT48'.substr(($id-002714),2);
		break;
	case 105:
		$show_voucher='DT48'.substr(($id-002714),2);
		break;
	case 6:
		$show_voucher='DT48'.substr(($id-002714),2);
		break;
	case 7:
		$show_voucher='P48'.substr(($id-088782),2);
		break;
	case 8:
		$show_voucher='PR48'.substr(($id-065782),2);
		break;
	case 14:
		$show_voucher='DT48'.substr(($id-012714),2);
	case 24:
		$show_voucher='DT48'.substr(($id-012714),2);
	case 16:
		$show_voucher='DT48'.substr(($id-012714),2);
		break;
	default:
		$show_voucher='OU48'.substr($id,2);
		break;
	}
	return $show_voucher;
}

function chk_pwd($str=''){
	$r=0;
	$len=strlen($str);
	if($len<6 || $len>32){
		$r=1;
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><script>
  alert(\'⊕密码必须至少4个字符，最多12个字符，并只能有数字(0-9)，及英文大小字母 \')
</script>
<script>
   history.go(-1);</script>';
		exit;
	}
}

function cdate($date_start){
	$Date_List_1=explode("-",$date_start);
	$d1=mktime(0,0,0,$Date_List_1[1],$Date_List_1[2],$Date_List_1[0]);
	return date('Y-m-d',$d1);
}

//function get_report($gtype,$wtype,$result_type,$report_kind,$date_start,$date_end,$subuser){
	function get_report($gtype,$wtype,$result_type,$report_kind,$date_start,$date_end){
	switch($gtype){
	case 'FT':
		$active=' active<3 and ';
		break;
	case 'BK':
		$active=' active=3 and ';
		break;
	case 'TN':
		$active=' active=4 and ';
		break;
	case 'VB':
		$active=' active=5 and ';
		break;
	case 'BS':
		$active=' active=7 and ';
		break;
	case 'FS':
		$active=' active=6 and ';
		break;
	case 'OP':
		$active=' active=8 and ';
		break;
	default:
		$active='';
		break;
	}

	if($wtype!=''){
		$w_type=" wtype='$wtype' and ";
	}else{
		$w_type='';
	}

	//if($subuser==0){
		if ($result_type=='Y'){
			$result_type1=" result_type=1 and ";
		}else{
			$result_type1=" result_type=0 and ";
		}
	//}else{
	//	$result_type1=" result_type=1 and ";
	//}

	switch ($report_kind){
	case "D":
		$cancel=' status>1 and ';
		break;
	case "D4":
		$cancel=' status=1 and ';
		break;
	default:
		$cancel='';
		break;
	}
	return $active.$w_type.$result_type1.$cancel." m_date>='$date_start' and  hidden=0 and m_date<='$date_end' ";
}

function getscore($mid,$active,$showtype,$linetype,$dbname){
	if($active<3){
		$table='foot_match';
	}else if($active==3){
		$table='bask_match';
	}
	$sql='select (mb_ball+0) as balla,(tg_ball+0) as ballb from '.$table.' where mid='.$mid;
	$result1 = mysql_query($sql);
	$row1 = mysql_fetch_array($result1);

		if($showtype=='C'){
			if($linetype==2 || $linetype==12 || $linetype==9 || $linetype==19){
				$score=$row1['ballb'].':'.$row1['balla'];
			}else{
				$score=$row1['balla'].':'.$row1['ballb'];
			}
		}else{
			$score=$row1['balla'].':'.$row1['ballb'];
		}
	return '<font color="#009900"><b>'.$score.'</b></font>  ';

}


function show_message($memname){	
	mysql_query("update message set readcount=readcount+1 where member='$memname' limit 1");
	$sql = "select message,message_tw from message where member='$memname' limit 0,1";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$cou=mysql_num_rows($result);
	echo $memname;
	if($cou!=0){
		$talert=$row['message_tw'];
		if ($talert<>''){
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';				
			echo "<script>alert('$talert');</script>";
		}

	}
}
?>
