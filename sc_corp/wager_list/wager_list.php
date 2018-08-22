<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
echo "<script>if(self == top) location='/'</script>\r\n";
require( "../../member/include/config.inc.php" );
require( "../../member/include/define_function_list.inc.php" );
$ODDS=Array(
	'H'=>'香港盘<br>',
	'M'=>'马来盘<br>',
	'I'=>'印尼盘<br>',
	'E'=>'欧洲盘<br>'
);
$username = $_REQUEST['username'];
$active = $_REQUEST['active'];
$id = $_REQUEST['id'];
$gid = $_REQUEST['gid'];
$pay_type = $_REQUEST['pay_type'];
$score = $_REQUEST['score'];
$result = 0 - $_REQUEST['result'];
$gdate = $_REQUEST['gdate'];
if ( empty( $gdate ) )
{
				$gdate = date( "Y-m-d" );
}
$uid = $_REQUEST['uid'];
$sql = "select agname,setdata,edit from web_super where oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['agname'];
$edit=$row['edit'];
$setdata = @unserialize($row['setdata']);
$cou = mysql_num_rows( $result );
if ( $cou == 0 )
{
				echo "<script>window.open('".$site."/index.php','_top')</script>";
				exit( );
}
if($setdata['d0_wager_add']!=1 && $edit!=1){
	exit();
}
switch ( $active )
{
case 1 :
				$mysql = "select * from web_db_io where super='$agname' and id=".$id;
				$result = mysql_db_query( $dbname, $mysql );
				$row = mysql_fetch_array( $result );
				$middle = explode( "<br>", $row['Middle'] );
				$middle_tw = explode( "<br>", $row['Middle_tw'] );
				$middle_en = explode( "<br>", $row['Middle_en'] );
				
				$arr = explode('.', $row['M_Rate']);
				$ratelen = strlen($arr[1])==2 ? 2 : 3;

				$count = count( $middle );
				if ( $count == 4 )
				{
								$sid = explode( "vs", $middle[1] );
								$middle1 = $middle[0]."<br>".$sid[1]."vs".$sid[0]."<br>".$middle[2]."<br>";
								$middle_tw1 = $middle_tw[0]."<br>".$sid[1]."vs".$sid[0]."<br>".$middle_tw[2]."<br>";
								$middle_en1 = $middle_en[0]."<br>".$sid[1]."vs".$sid[0]."<br>".$middle_en[2]."<br>";
				}
				else
				{
								$middle1 = $middle[0]."<br>".$middle[1]."<br>";
								$middle_tw1 = $middle_tw[0]."<br>".$middle_tw[1]."<br>";
								$middle_en1 = $middle_en[0]."<br>".$middle_en[1]."<br>";
				}
				switch ( $row['OpenType'] )
				{
				case "A" :
								$rate = 1.84 - $row['M_Rate'];
								break;
				case "B" :
								$rate = 1.86 - $row['M_Rate'];
								break;
				default :
								$rate = 1.9 - $row['M_Rate'];
				}
				$gold_d = $row['BetScore'];
				$wtype = $row['Mtype'];
				$rate = number_format($rate,$ratelen,'.','');
				$gwin = $row['BetScore'] * $rate;
				switch ( $row['LineType'] )
				{
				case 2 :
								$gwin = $row['BetScore'] * $rate;
								$team = explode( "&nbsp;&nbsp;", $middle[$count - 2] );
								$team_tw = explode( "&nbsp;&nbsp;", $middle_tw[$count - 2] );
								$team_en = explode( "&nbsp;&nbsp;", $middle_en[$count - 2] );
												$mb_team = $team[0];
												$tg_team = $team[2];
												$mb_team_tw = $team_tw[0];
												$tg_team_tw = $team_tw[2];
												$mb_team_en = $team_en[0];
												$tg_team_en = $team_en[2];
								if ( $row[ShowType] == "H" )
								{
												if ( $row[Mtype] == "H" )
												{
																$mtype = "C";
																$m_place = $tg_team;
																$m_place_tw = $tg_team_tw;
																$m_place_en = $tg_team_en;
												}
												else
												{
																$mtype = "H";
																$m_place = $mb_team;
																$m_place_tw = $mb_team_tw;
																$m_place_en = $mb_team_en;
																$mb_team = $team[0];
																$tg_team = $team[2];
																$mb_team_tw = $team_tw[0];
																$tg_team_tw = $team_tw[2];
																$mb_team_en = $team_en[0];
																$tg_team_en = $team_en[2];
												}
								}
								else if ( $row[Mtype] == "H" )
								{
												$mtype = "C";
												$m_place = $mb_team;
												$m_place_tw = $mb_team_tw;
												$m_place_en = $mb_team_en;
								}
								else
								{
												$mtype = "H";
												$m_place = $tg_team;
												$m_place_tw = $tg_team_tw;

												$m_place_en = $tg_team_en;
								}
								$team = $middle[$count - 1];
								if ( strstr( $team, "上半" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[1st Half]</font>&nbsp;";
								}
								else if ( strstr( $team, "下半" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[下半]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[下半]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[2st Half]</font>&nbsp;";
								}
								else if ( strstr( $team, "第1节" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[第1節]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[第1节]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[Q1]</font>&nbsp;";
								}
								else if ( strstr( $team, "第2节" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[第2節]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[第2节]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[Q2]</font>&nbsp;";
								}
								else if ( strstr( $team, "第3节" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[第3節]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[第3节]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[Q3]</font>&nbsp;";
								}
								else if ( strstr( $team, "第4节" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[第4節]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[第4节]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[Q4]</font>&nbsp;";
								}
								else
								{
												$bottom1_tw = "";
												$bottom1 = "";
												$bottom1_en = "";
								}
								$lines2 = $middle1."<FONT color=#cc0000>".$m_place."</FONT>&nbsp;".$bottom1."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$lines2_tw = $middle_tw1."<FONT color=#cc0000>".$m_place_tw."</FONT>&nbsp;".$bottom1_tw."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$lines2_en = $middle_en1."<FONT color=#cc0000>".$m_place_en."</FONT>&nbsp;".$bottom1_en."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$auth_code = md5( trim( $lines2_tw ).$gold_d.$mtype );
								$mysql = "update web_db_io set auth_code='$auth_code',vgold=0,result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='{$gwin}',m_rate='{$rate}',mtype='$mtype',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en. "' where super='$agname' and id='$id'" ;
								mysql_db_query( $dbname, $mysql );
								break;
				case 3 :
								$pan = substr( $row['M_Place'], 1, strlen( $row['M_Place'] ) );
								if ( $row[Mtype] == "C" )
								{
												$mtype = "H";
												$m_place = "小".$pan;
												$m_place_tw = "小".$pan;
												$m_place_en = "Under".$pan;
								}
								else
								{
												$mtype = "C";
												$m_place = "大".$pan;
												$m_place_tw = "大".$pan;
												$m_place_en = "Over".$pan;
								}
								$team = $middle[$count - 1];
								if ( strstr( $team, "上半" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[1st Half]</font>&nbsp;";
								}
								else if ( strstr( $team, "下半" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[下半]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[2st Half]</font>&nbsp;";
								}
								else if ( strstr( $team, "第1节" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[第1節]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[第1节]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[Q1]</font>&nbsp;";
								}
								else if ( strstr( $team, "第2节" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[第2節]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[第2节]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[Q2]</font>&nbsp;";
								}
								else if ( strstr( $team, "第3节" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[第3節]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[第3节]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[Q3]</font>&nbsp;";
								}
								else if ( strstr( $team, "第4节" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[第4節]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[第4节]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[Q4]</font>&nbsp;";
								}
								else
								{
												$bottom1_tw = "";
												$bottom1 = "";
												$bottom1_en = "";
								}
								$lines2 = $middle1."<FONT color=#cc0000>".$m_place."</FONT>&nbsp;".$bottom1."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$lines2_tw = $middle_tw1."<FONT color=#cc0000>".$m_place_tw."</FONT>&nbsp;".$bottom1_tw."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$lines2_en = $middle_en1."<FONT color=#cc0000>".$m_place_en."</FONT>&nbsp;".$bottom1_en."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$auth_code = md5( $lines2_tw.$gold_d.$mtype );
								$mysql = "update web_db_io set auth_code='".$auth_code."',vgold=0,m_place='{$m_place_en}',result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='{$gwin}',m_rate='{$rate}',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en.( "' where super='$agname' and id=".$id );
								mysql_db_query( $dbname, $mysql );
								break;
				case 9 :
								$team = explode( "&nbsp;&nbsp;", $middle[$count - 2] );
								$team_tw = explode( "&nbsp;&nbsp;", $middle_tw[$count - 2] );
								$team_en = explode( "&nbsp;&nbsp;", $middle_en[$count - 2] );
								$mb_team = $team[0];
								$tg_team = $team[2];
								$mb_team_tw = $team_tw[0];
								$tg_team_tw = $team_tw[2];
								$mb_team_en = $team_en[0];
								$tg_team_en = $team_en[2];
								if ( $row[ShowType] == "H" )
								{
												if ( $row[Mtype] == "H" )
												{
																$mtype = "C";
																$m_place = $tg_team;
																$m_place_tw = $tg_team_tw;
																$m_place_en = $tg_team_en;
												}
												else
												{
																$mtype = "H";
																$m_place = $mb_team;
																$m_place_tw = $mb_team_tw;
																$m_place_en = $mb_team_en;
																$mb_team = $team[0];
																$tg_team = $team[2];
																$mb_team_tw = $team_tw[0];
																$tg_team_tw = $team_tw[2];
																$mb_team_en = $team_en[0];
																$tg_team_en = $team_en[2];
												}
								}
								else if ( $row[Mtype] == "H" )
								{
												$mtype = "C";
												$m_place = $mb_team;
												$m_place_tw = $mb_team_tw;
												$m_place_en = $mb_team_en;
								}
								else
								{
												$mtype = "H";
												$m_place = $tg_team;
												$m_place_tw = $tg_team_tw;
												$m_place_en = $tg_team_en;
								}
								$team = $middle[$count - 1];
								if ( strstr( $team, "上半" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[1st Half]</font>&nbsp;";
								}
								else if ( strstr( $team, "下半" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[下半]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[2st Half]</font>&nbsp;";
								}
								else if ( strstr( $team, "第1节" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[第1節]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[第1节]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[Q1]</font>&nbsp;";
								}
								else if ( strstr( $team, "第2节" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[第2節]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[第2节]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[Q2]</font>&nbsp;";
								}
								else if ( strstr( $team, "第3节" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[第3節]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[第3节]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[Q3]</font>&nbsp;";
								}
								else if ( strstr( $team, "第4节" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[第4節]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[第4节]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[Q4]</font>&nbsp;";
								}
								else
								{
												$bottom1_tw = "";
												$bottom1 = "";
												$bottom1_en = "";
								}
								$lines2 = $middle1."<FONT color=#cc0000>".$m_place."</FONT>&nbsp;".$bottom1."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$lines2_tw = $middle_tw1."<FONT color=#cc0000>".$m_place_tw."</FONT>&nbsp;".$bottom1_tw."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$lines2_en = $middle_en1."<FONT color=#cc0000>".$m_place_en."</FONT>&nbsp;".$bottom1_en."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$auth_code = md5( $lines2_tw.$gold_d.$mtype );
								$mysql = "update web_db_io set auth_code='".$auth_code."',vgold=0,result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='{$gwin}',m_rate='{$rate}',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en.( "' where super='$agname' and id=".$id );
								mysql_db_query( $dbname, $mysql );
								break;
				case 19 :
								$gwin = $row['BetScore'] * $rate;
								$team = explode( "&nbsp;&nbsp;", $middle[$count - 2] );
								$team_tw = explode( "&nbsp;&nbsp;", $middle_tw[$count - 2] );
								$team_en = explode( "&nbsp;&nbsp;", $middle_en[$count - 2] );
												$mb_team = $team[0];
												$tg_team = $team[2];
												$mb_team_tw = $team_tw[0];
												$tg_team_tw = $team_tw[2];
												$mb_team_en = $team_en[0];
												$tg_team_en = $team_en[2];
								if ( $row[ShowType] == "H" )
								{
												if ( $row[Mtype] == "H" )
												{
																$mtype = "C";
																$m_place = $tg_team;
																$m_place_tw = $tg_team_tw;
																$m_place_en = $tg_team_en;
												}
												else
												{
																$mtype = "H";
																$m_place = $mb_team;
																$m_place_tw = $mb_team_tw;
																$m_place_en = $mb_team_en;
																$mb_team = $team[0];
																$tg_team = $team[2];
																$mb_team_tw = $team_tw[0];
																$tg_team_tw = $team_tw[2];
																$mb_team_en = $team_en[0];
																$tg_team_en = $team_en[2];
												}
								}
								else if ( $row[Mtype] == "H" )
								{
												$mtype = "C";
												$m_place = $mb_team;
												$m_place_tw = $mb_team_tw;
												$m_place_en = $mb_team_en;
								}
								else
								{
												$mtype = "H";
												$m_place = $tg_team;
												$m_place_tw = $tg_team_tw;
												$m_place_en = $tg_team_en;
								}
								$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
								$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
								$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[1st Half]</font>&nbsp;";
								$lines2 = $middle1."<FONT color=#cc0000>".$m_place."</FONT>&nbsp;".$bottom1."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$lines2_tw = $middle_tw1."<FONT color=#cc0000>".$m_place_tw."</FONT>&nbsp;".$bottom1_tw."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$lines2_en = $middle_en1."<FONT color=#cc0000>".$m_place_en."</FONT>&nbsp;".$bottom1_en."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$auth_code = md5( $lines2_tw.$gold_d.$mtype );
								$mysql = "update web_db_io set auth_code='".$auth_code."',vgold=0,result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='{$gwin}',m_rate='{$rate}',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en.( "' where super='$agname' and id=".$id );
								mysql_db_query( $dbname, $mysql );
								break;
				case 10 :
								$pan = substr( $row['M_Place'], 1, strlen( $row['M_Place'] ) );
								if ( $row[Mtype] == "C" )
								{
												$mtype = "H";
												$m_place = "小".$pan;
												$m_place_tw = "小".$pan;
												$m_place_en = "Under".$pan;
								}
								else
								{
												$mtype = "C";
												$m_place = "大".$pan;
												$m_place_tw = "大".$pan;
												$m_place_en = "Over".$pan;
								}
								$team = $middle[$count - 1];
								if ( strstr( $team, "上半" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[1st Half]</font>&nbsp;";
								}
								else if ( strstr( $team, "下半" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[下半]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[2st Half]</font>&nbsp;";
								}
								else if ( strstr( $team, "第1节" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[第1節]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[第1节]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[Q1]</font>&nbsp;";
								}
								else if ( strstr( $team, "第2节" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[第2節]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[第2节]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[Q2]</font>&nbsp;";
								}
								else if ( strstr( $team, "第3节" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[第3節]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[第3节]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[Q3]</font>&nbsp;";
								}
								else if ( strstr( $team, "第4节" ) )
								{
												$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[第4節]</font>&nbsp;";
												$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[第4节]</font>&nbsp;";
												$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[Q4]</font>&nbsp;";
								}
								else
								{
												$bottom1_tw = "";
												$bottom1 = "";
												$bottom1_en = "";
								}
								$lines2 = $middle1."<FONT color=#cc0000>".$m_place."</FONT>&nbsp;".$bottom1."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$lines2_tw = $middle_tw1."<FONT color=#cc0000>".$m_place_tw."</FONT>&nbsp;".$bottom1_tw."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$lines2_en = $middle_en1."<FONT color=#cc0000>".$m_place_en."</FONT>&nbsp;".$bottom1_en."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$auth_code = md5( $lines2_tw.$gold_d.$mtype );
								$mysql = "update web_db_io set auth_code='".$auth_code."',vgold=0,m_place='{$m_place_en}',result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='{$gwin}',m_rate='{$rate}',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en.( "' where super='$agname' and id=".$id );
								mysql_db_query( $dbname, $mysql );
								break;
				case 30 :
								$pan = substr( $row['M_Place'], 1, strlen( $row['M_Place'] ) );
								if ( $row[Mtype] == "C" )
								{
												$mtype = "H";
												$m_place = "小".$pan;
												$m_place_tw = "小".$pan;
												$m_place_en = "Under".$pan;
								}
								else
								{
												$mtype = "C";
												$m_place = "大".$pan;
												$m_place_tw = "大".$pan;
												$m_place_en = "Over".$pan;
								}
								$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
								$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
								$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[1st Half]</font>&nbsp;";
								$lines2 = $middle1."<FONT color=#cc0000>".$m_place."</FONT>&nbsp;".$bottom1."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$lines2_tw = $middle_tw1."<FONT color=#cc0000>".$m_place_tw."</FONT>&nbsp;".$bottom1_tw."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$lines2_en = $middle_en1."<FONT color=#cc0000>".$m_place_en."</FONT>&nbsp;".$bottom1_en."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$auth_code = md5( $lines2_tw.$gold_d.$mtype );
								$mysql = "update web_db_io set auth_code='".$auth_code."',vgold=0,m_place='{$m_place_en}',result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='{$gwin}',m_rate='{$rate}',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en.( "' where super='$agname' and id=".$id );
								mysql_db_query( $dbname, $mysql );
								break;
				case 12 :
								$gwin = $row['BetScore'] * $rate;
								$team = explode( "&nbsp;&nbsp;", $middle[$count - 2] );
								$team_tw = explode( "&nbsp;&nbsp;", $middle_tw[$count - 2] );
								$team_en = explode( "&nbsp;&nbsp;", $middle_en[$count - 2] );
												$mb_team = $team[0];
												$tg_team = $team[2];
												$mb_team_tw = $team_tw[0];
												$tg_team_tw = $team_tw[2];
												$mb_team_en = $team_en[0];
												$tg_team_en = $team_en[2];
								if ( $row[ShowType] == "H" )
								{
												if ( $row[Mtype] == "H" )
												{
																$mtype = "C";
																$m_place = $tg_team;
																$m_place_tw = $tg_team_tw;
																$m_place_en = $tg_team_en;
												}
												else
												{
																$mtype = "H";
																$m_place = $mb_team;
																$m_place_tw = $mb_team_tw;
																$m_place_en = $mb_team_en;
																$mb_team = $team[0];
																$tg_team = $team[2];
																$mb_team_tw = $team_tw[0];
																$tg_team_tw = $team_tw[2];
																$mb_team_en = $team_en[0];
																$tg_team_en = $team_en[2];
												}
								}
								else if ( $row[Mtype] == "H" )
								{
												$mtype = "C";
												$m_place = $mb_team;
												$m_place_tw = $mb_team_tw;
												$m_place_en = $mb_team_en;
								}
								else
								{
												$mtype = "H";
												$m_place = $tg_team;
												$m_place_tw = $tg_team_tw;
												$m_place_en = $tg_team_en;
								}
								$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
								$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
								$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[1st Half]</font>&nbsp;";
								$lines2 = $middle1."<FONT color=#cc0000>".$m_place."</FONT>&nbsp;".$bottom1."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$lines2_tw = $middle_tw1."<FONT color=#cc0000>".$m_place_tw."</FONT>&nbsp;".$bottom1_tw."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$lines2_en = $middle_en1."<FONT color=#cc0000>".$m_place_en."</FONT>&nbsp;".$bottom1_en."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$auth_code = md5( $lines2_tw.$gold_d.$mtype );
								$mysql = "update web_db_io set auth_code='".$auth_code."',vgold=0,result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='{$gwin}',m_rate='{$rate}',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en.( "' where super='$agname' and id=".$id );
								mysql_db_query( $dbname, $mysql );
								break;
				case 13 :
								$pan = substr( $row['M_Place'], 1, strlen( $row['M_Place'] ) );
								if ( $row[Mtype] == "C" )
								{
												$mtype = "H";
												$m_place = "小".$pan;
												$m_place_tw = "小".$pan;
												$m_place_en = "Under".$pan;
								}
								else
								{
												$mtype = "C";
												$m_place = "大".$pan;
												$m_place_tw = "大".$pan;
												$m_place_en = "Over".$pan;
								}
								$bottom1_tw = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
								$bottom1 = "<font color=red>-&nbsp;</font><font color=#666666>[上半]</font>&nbsp;";
								$bottom1_en = "<font color=red>-&nbsp;</font><font color=#666666>[1st Half]</font>&nbsp;";
								$lines2 = $middle1."<FONT color=#cc0000>".$m_place."</FONT>&nbsp;".$bottom1."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$lines2_tw = $middle_tw1."<FONT color=#cc0000>".$m_place_tw."</FONT>&nbsp;".$bottom1_tw."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$lines2_en = $middle_en1."<FONT color=#cc0000>".$m_place_en."</FONT>&nbsp;".$bottom1_en."@&nbsp;<FONT color=#cc0000><b>".$rate."</b></FONT>";
								$auth_code = md5( $lines2_tw.$gold_d.$mtype );
								$mysql = "update web_db_io set auth_code='".$auth_code."',vgold=0,m_place='{$m_place_en}',result_type=0,m_result=0,a_result=0,result_c=0,result_a=0,result_s=0,status=0,gwin='{$gwin}',m_rate='{$rate}',mtype='".$mtype."',middle='".$lines2."',middle_tw='".$lines2_tw."',middle_en='".$lines2_en.( "' where super='$agname' and id=".$id );
								mysql_db_query( $dbname, $mysql );
				}
				if ( $row['result_type'] == 1 && $row['pay_type'] == 1 )
				{
								$aa = $row['BetScore'] + $row['M_Result'];
								$sql = "update web_members set money=".$money."-{$aa} where super='$agname' and m_name='".$row['M_Name']."'";
								mysql_db_query( $dbname, $sql );
				}
				
				$edit = $row['edit']==1 ? 0 : 1;
				$sql = "update web_db_io set edit='$edit' where super='$agname' and id='$id'";
				mysql_db_query( $dbname, $sql );
				echo "<script languag='JavaScript'>self.location='wager_list.php?uid=".$uid."&username={$username}&gdate={$gdate}'</script>";
				break;
case 2 :
				$sql = "select result_type,betscore,m_result,m_name,pay_type from web_db_io where super='$agname' and id=".$id;
				$result = mysql_db_query( $dbname, $sql );
				$row = mysql_fetch_array( $result );
				if ( $row['pay_type'] == 1 )
				{
								if ( $row['result_type'] == 0 )
								{
												$sql = "update web_member set money=money+".$row['betscore']." where memname='".$row[m_name]."'";
								}
								else
								{
												$sql = "update web_member set money=money-".$row['m_result']." where memname='".$row[m_name]."'";
								}
								mysql_db_query( $dbname, $sql );
				}
				$sql = "update web_db_io set vgold=0,m_result=0,result_c=0,a_result=0,cancel=1,result_a=0,result_s=0,result_type=1 where super='$agname' and id=".$id;
				mysql_db_query( $dbname, $sql );
				echo "<script languag='JavaScript'>self.location='wager_list.php?uid=".$uid."&username={$username}&gdate={$gdate}'</script>";
				break;
case 3 :
				$sql = "select result_type,betscore,m_result,m_name,pay_type from web_db_io where super='$agname' and id=".$id;
				$result = mysql_db_query( $dbname, $sql );
				$row = mysql_fetch_array( $result );
				if ( $row['pay_type'] == 1 )
				{
								if ( $row['result_type'] == 0 )
								{
												$sql = "update web_member set money=money+".$row['betscore']." where super='$agname' and memname='".$row[m_name]."'";
								}
								else
								{
												$sql = "update web_member set money=money-".$row['m_result']." where super='$agname' and memname='".$row[m_name]."'";
								}
								mysql_db_query( $dbname, $sql );
				}
				else
				{
								$sql = "update web_member set money=money+".$row['betscore']." where super='$agname' and memname='".$row[m_name]."'";
								mysql_db_query( $dbname, $sql );
				}
				$mysql = "delete from web_db_io where super='$agname' and id=".$id;
				mysql_db_query( $dbname, $mysql );
				echo "<script languag='JavaScript'>self.location='wager_list.php?uid=".$uid."&username={$username}&gdate={$gdate}'</script>";
				break;
case 4 :
				$sql = "select betscore,m_name,pay_type from web_db_io where super='$agname' and id=".$id;
				$result = mysql_db_query( $dbname, $sql );
				$row = mysql_fetch_array( $result );
				if ( $row['pay_type'] == 1 )
				{
								$sql = "update web_member set money=money-".$row['betscore']." where super='$agname' and memname='".$row[m_name]."'";
								mysql_db_query( $dbname, $sql );
				}
				$sql = "update web_db_io set vgold=0,m_result=0,result_c=0,a_result=0,status=0,result_a=0,result_s=0,result_type=0 where super='$agname' and id=".$id;
				mysql_db_query( $dbname, $sql );
				echo "<script languag='JavaScript'>self.location='wager_list.php?uid=".$uid."&username={$username}&gdate={$gdate}'</script>";
}
$mysql = "select date_format(BetTime,'%m%d%H%i%s')+id as WID,danger,QQ526738,result_type,cancel,id,date_format(BetTime,'%m-%d <br> %H:%i:%s') as BetTime,M_Name,TurnRate,BetType,M_result,Middle,BetScore,pay_type,active,linetype,edit,odd_type from web_db_io where super='$agname' and m_name='".trim( $username )."' and m_date='".$gdate."' order by bettime desc,linetype,mtype";
$result = mysql_db_query( $dbname, $mysql );
echo "<html>\r\n<head>\r\n<title></title>\r\n<META http-equiv=Content-Type content=\"text/html; charset=utf-8\">\r\n<link rel=\"stylesheet\" href=\"/style/control/control_main.css\" type=\"text/css\">\r\n<META content=\"Microsoft FrontPage 4.0\" name=GENERATOR>\r\n<SCRIPT>\r\n<!--\r\n function onLoad()\r\n {\r\n  var gdate = document.getElementById('gdate');\r\n  gdate.value = '";
echo $gdate;
echo "';\r\n }\r\nfunction CheckCLOSE(str)\r\n {\r\n  if(confirm(\"确实要取消本场比赛吗?\"))\r\n  document.location=str;\r\n }\r\n function reload()\r\n{\r\n\r\n\tself.location.href='wager_list.php?uid=";
echo $uid;
echo "&username=";
echo $username;
echo "&gdate=";
echo $gdate;
echo "';\r\n}\r\nfunction Del(str)\r\n {\r\n  if(confirm(\"确实要删除比投注纪录吗?\"))\r\n  document.location=str;\r\n }\r\n\r\n// -->\r\n</SCRIPT>\r\n</HEAD>\r\n<body bgcolor=\"#FFFFFF\" text=\"#000000\" leftmargin=\"0\" topmargin=\"0\" vlink=\"#0000FF\" alink=\"#0000FF\"  onload=\"onLoad()\";>\r\n<form name=\"myFORM\" method=\"post\" action=\"\">\r\n<table width=\"769\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n  <tr>\r\n          <td class=\"m_tline\" width=\"744\">注单管理&nbsp;&nbsp;<input name=button type=button class=\"za_button\" onclick=\"reload()\" value=\"更新\"> &nbsp;&nbsp;投注日期：<font color=\"#cc0000\">\r\n                    <select class=za_select onchange=document.myFORM.submit(); name=gdate>\r\n\t\t\t\t<option value=\"\"></option>\r\n\t\t\t\t";
$dd = 86400;
$t = time( );
$aa = 0;
$bb = 0;
$i = 0;
for ( ;	$i < 10;	++$i	)
{
				$today = date( "Y-m-d", $t );
				if ( $gdate == date( "Y-m-d", $t ) )
				{
								echo "<option value='".$today."' selected>".date( "Y-m-d", $t )."</option>";
				}
				else
				{
								echo "<option value='".$today."'>".date( "Y-m-d", $t )."</option>";
				}
				$t -= $dd;
}
echo "\t\t\t</select>\r\n            </font>&nbsp;&nbsp;&nbsp;&nbsp;帐号:<font color=\"cc0000\">\r\n            ";
echo $username;
echo "            </font>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:history.go( -1 );\"> 回上一页</a>&nbsp;&nbsp;</font></font></td>\r\n    <td width=\"32\"><img src=\"/images/control/top_04.gif\" width=\"30\" height=\"24\"></td>\r\n  </tr>\r\n  <tr>\r\n    <td colspan=\"2\" height=\"4\" width=\"778\">\r\n<table width=\"769\" border=\"0\" align=\"left\" cellPadding=\"0\" cellSpacing=\"0\" background=\"/images/body_title_ph12b.gif\" class=\"b_title\">\r\n  <tbody>\r\n\r\n    <tr>\r\n       <td width=\"394\"><div align=\"right\"></div></td>\r\n                  <td width=\"375\">&nbsp;</td>\r\n    </tr>\r\n\r\n  </tbody>\r\n</table>\r\n    </td>\r\n  </tr>\r\n</table>\r\n      <table width=\"810\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" class=\"m_tab\" bgcolor=\"#000000\">\r\n  <tr class=\"m_title_ft\">\r\n          <td width=\"60\"align=\"center\">投注时间</td>\r\n          <td width=\"90\" align=\"center\">用户名称</td>\r\n          <td width=\"100\" align=\"center\">球赛种类</td>\r\n          <td width=\"230\" align=\"center\">内容</td>\r\n          <td width=\"70\" align=\"center\">投注</td>\r\n          <td width=\"70\" align=\"center\">会员</td>\r\n          <td width=\"180\" align=\"center\">功能</td>\r\n        </tr>\r\n        ";
while ( $row = mysql_fetch_array( $result ) )
{
				$url = "wager_list.php?uid=".$uid."&id=".$row[id]."&active=1&username=".$username."&gdate=".$gdate;
				$editbg = '';//$row['edit']==1 ? 'style="background-color:#FFFF99"' : '';
				echo "        <tr class=\"m_rig\" $editbg>\r\n          <td align=\"center\">";
				echo $row['BetTime'];
				echo "</td>\r\n          <td align=\"center\">";
				echo $row['M_Name'];
				echo "&nbsp;&nbsp;<font color=\"#cc0000\"> ";
				echo $row['TurnRate'];
				echo "</font><br><font color=blue>";
				echo show_voucher( $row['linetype'], $row['WID'] );
				echo "</td>\r\n          <td align=\"center\">";
				echo $row['BetType'];
				echo " <br><font color=green>".$ODDS[$row['odd_type']]."</font>";
				switch ( $row['danger'] )
				{
				case 1 :
								echo "<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;确认中&nbsp;</b></font></font>";
								break;
				case 2 :
								echo "<br><font color=#ffffff style=background-color:#ff0000><b>未确认</b></font></font>";
								break;
				case 3 :
								echo "<br><font color=#ffffff style=background-color:#ff0000><b>&nbsp;确认&nbsp;</b></font></font>";
				}
				echo "</td>\r\n  <td align=\"right\">\r\n  ";
				if ( $row['linetype'] == 7 || $row['linetype'] == 8 )
				{
								$midd = explode( "<br>", $row['Middle'] );
								$ball = explode( "<br>", $row['QQ526738'] );
								$t = 0;
								for ( $t = 0; $t < ( sizeof( $midd ) - 1 ) / 2;	$t++	)
								{
									echo $midd[2 * $t]."<br>";
									if ( $row['result_type'] == 1 )
									{
										echo "<font color=\"#009900\"><b>".$ball[$t]."</b></font>  ";
									}
									echo $midd[2 * $t + 1]."<br>";
								}
								
				}
				else
				{
								$midd = explode( "<br>", $row['Middle'] );
									for ( $t = 0;	$t < sizeof( $midd ) - 1;	++$t	)
								{
												echo $midd[$t]."<br>";
								}
								if ( $row['result_type'] == 1 )
								{
												echo "<font color=\"#009900\"><b>".$row['QQ526738']."</b></font>  ";
								}
								echo $midd[sizeof( $midd ) - 1];
				}
				echo "\t</td>\r\n  <td align=\"center\">";
				echo $row['BetScore'];
				echo "</td>\r\n  <td>";
				echo number_format( $row['M_result'], 1 );
				echo "</td>\r\n  <td align=\"left\">&nbsp;&nbsp;\r\n  \t";

				
				$htmlarr = array();
				if ($setdata['d0_edit_list_re']==1 && in_array($row['linetype'], array(2,3,12,13,9,10,19,30)) ){
					$htmlarr[]="<a href='$url'>对调</a>";
				}
				if($setdata['d0_edit_list_edit']==1){
					$htmlarr[]="<a href='wager_edit.php?uid=$uid&id=$row[id]&username=$username&gdate=$gdate'>修改</a>";
				}
				if($setdata['d0_edit_list_del']==1){
					$htmlarr[]="<a href='javascript:Del(\"?uid=$uid&id=$row[id]&active=3&username=$username&gdate=$gdate\")'>删除</a>";
				}
				echo join('&nbsp;/&nbsp;', $htmlarr);
				echo "</td>\r\n        </tr>\r\n        ";
}
echo "      </table>\r\n</form>\r\n</BODY>\r\n</html>\r\n";

	$loginfo='注单管理列表';
	$ip_addr = $_SERVER['REMOTE_ADDR'];
	$mysql="insert into web_mem_log(username,logtime,context,logip,level) values('$agname',now(),'$loginfo','$ip_addr','0')";
	mysql_query($mysql);
?>