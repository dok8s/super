<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
echo "<script>if(self == top) parent.location='/'</script>\r\n";
require( "../../member/include/config.inc.php" );
require( "../../member/include/define_function_list.inc.php" );
$uid = $_REQUEST['uid'];
$level=$_REQUEST['level']?$_REQUEST['level']:5;
$sql = "select agname,setdata from web_super where oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['agname'];
$setdata = @unserialize($row['setdata']);
$cou=mysql_num_rows($result);
if ( $cou == 0 || $setdata['d0_wager_add']!=1)
{
	echo "<script>window.open('".$site."/index.php','_top')</script>";
	exit( );
}
$enable = $_REQUEST['enable'];
$enabled = $_REQUEST['enabled'];
$sort = $_REQUEST['sort'];
$orderby = $_REQUEST['orderby'];
$mid = $_REQUEST['id'];
$active = $_REQUEST['active'];
$page = $_REQUEST['page'];
if ( $page == "" )
{
				$page = 0;
}
if ( $enable == "" )
{
				$enable = "Y";
}
if ( $sort == "" )
{
				$sort = "alias";
}
if ( $orderby == "" )
{
				$orderby = "asc";
}
if ( $enable == "Y" )
{
				$enabled = 1;
				$memstop = "N";
				$stop = 1;
				$start_font = "";
				$end_font = "";
				$caption1 = "停用";
				$caption2 = "启用";
}
else
{
				$enable = "N";
				$memstop = "Y";
				$enabled = 0;
				$stop = 0;
				$start_font = "";
				$end_font = "</font>";
				$caption2 = "<SPAN STYLE='background-color: rgb(255,255,0);'>停用</SPAN>";
				$caption1 = "启用";
}
if ( $active==2 ){
	$mysql = "update web_member set Status='".$stop."' where super='".$agname."' and id='$mid'";
	mysql_query( $mysql );
}
elseif( $active==3 ){
	if($setdata['d0_wager_add_deluser']==1){
		$sql = "update web_member set edtvou=0 where super='".$agname."' and id='$mid'";
		mysql_query( $sql );
	}
}
?>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a1.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a2.css" type="text/css">
<link rel="stylesheet" href="../css/loader.css" type="text/css">
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="/js/ClassSelect_ag.js" type="text/javascript"></script>
<SCRIPT language="javascript" src="/js/member.js"></script>
<SCRIPT language=javaScript>
    var uid='<?=$uid?>';
    function ch_level(i)
    {
        if(i === 1) {
            self.location = '/sc_corp/super_agent/body_super_agents.php?uid='+uid+'&level='+i;
        } else if(i === 2) {
            self.location = '/sc_corp/agents/su_agents.php?uid='+uid+'&level='+i;
        } else if(i === 3) {
            self.location = '/sc_corp/members/ag_members.php?uid='+uid+'&level='+i;
        } else if(i === 5) {
            self.location = '/sc_corp/wager_list/wager_add.php?uid='+uid+'&level='+i;
        } else if(i === 6) {
            self.location = '/sc_corp/wager_list/wager_hide.php?uid='+uid+'&level='+i;
        } else  {
            self.location = '/sc_corp/su_subuser.php?uid='+uid+'&level='+i;
        }

    }
</SCRIPT>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/calendar.css">
<link rel="stylesheet" href="/style/control/control_main1.css" type="text/css">
<link rel="stylesheet" href="/style/home.css" type="text/css">
<script type="text/javascript">
    // 等待所有加载
    $(window).load(function(){
        $('body').addClass('loaded');
        $('#loader-wrapper .load_title').remove();
    });
</script>
<?
echo "<html>\r\n<head>\r\n<title>main</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n<style type=\"text/css\">\r\n<!--\r\n.m_title {  background-color: #FEF5B5; text-align: center}\r\n-->\r\n</style>\r\n<link rel=\"stylesheet\" href=\"/style/control/control_main.css\" type=\"text/css\">\r\n<SCRIPT language=\"javascript\" src=\"/js/member.js\"></script>\r\n<SCRIPT>\r\n\r\n function onLoad()\r\n {\r\n  //var obj_sagent_id = document.getElementById('agent_id');\r\n  //obj_sagent_id.value = '";
echo $agid;
echo "';\r\n  var obj_enable = document.getElementById('enable');\r\n  obj_enable.value = '";
echo $enable;
echo "';\r\n  var obj_page = document.getElementById('page');\r\n  obj_page.value = '";
echo $page;
echo "';\r\n  var obj_sort=document.getElementById('sort');\r\n  obj_sort.value='";
echo $sort;
echo "';\r\n  var obj_orderby=document.getElementById('orderby');\r\n  obj_orderby.value='";
echo $orderby;
echo "';\r\n }\r\n// -->\r\n</SCRIPT>\r\n</head>\r\n<body bgcolor=\"#FFFFFF\" text=\"#000000\" leftmargin=\"0\" topmargin=\"0\" vlink=\"#0000FF\" alink=\"#0000FF\" onload=\"onLoad()\";>\r\n";
?>
<div id="loader-wrapper">
	<div id="loader"></div>
	<div class="loader-section section-left"></div>
	<div class="loader-section section-right"></div>
	<div class="load_title">正在加载...</div>
</div>
<div id="top_nav_container" name="fixHead" class="top_nav_container_ann" >
	<div id="general_btn" class="<? if ($level == 1) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(1);">总代理</div>
	<div id="important_btn" class="<? if ($level == 2) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(2);">代理</div>
	<div id="personal_btn" class="<? if ($level == 3) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(3);">会员</div>
	<div id="general_btn1" class="<? if ($level == 4) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(4);">子帐号</div>
    <? if($setdata['d0_wager_add']==1){ ?>
		<div id="important_btn1" class="<? if ($level == 5) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(5);">添单帐号</div>
    <? } ?>
    <? if($setdata['d0_wager_hide']==1){ ?>
		<div id="personal_btn1" class="<? if ($level == 6) {echo 'nav_btn_on';} else {echo 'nav_btn';}?>" onclick="ch_level(6);">隐单帐号</div>
    <? } ?>
</div>
<?
echo "<FORM style=\"padding-top: 62px;\" NAME=\"myFORM\" ACTION=\"?uid=";
echo $uid;
echo "\" METHOD=POST>\r\n<input type=\"hidden\" name=\"agent_id\" value=\"";
echo $agid;
echo "\">\r\n";
$sql = "select passwd,ID,Memname,pay_type,money,Alias,Credit,ratio,date_format(AddDate,'%m-%d / %H:%i') as AddDate,pay_type,Agents,OpenType from web_member where super='".$agname."' and edtvou=1 and Status=".$enabled." order by ".$sort." ".$orderby;
$result = mysql_query( $sql );
$cou = mysql_num_rows( $result );
$page_size = 15;
$page_count = ceil( $cou / $page_size );
$offset = $page * $page_size;
$mysql = $sql.( "  limit ".$offset.",{$page_size};" );
$result = mysql_query( $mysql );
echo "<table style=\"margin-left:20px;margin-bottom: 10px;\" width=\"775\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n  <tr>\r\n\t<td class=\"\">\r\n        <table style=\"margin-left:20px;margin-bottom: 10px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >\r\n          <tr>\r\n            <td>&nbsp;&nbsp;改单会员            <select name=\"enable\" onChange=\"self.myFORM.submit()\" class=\"za_select\" >\r\n                <option value=\"Y\" >启用</option>\r\n                <option value=\"N\" >停用</option></td>\r\n\r\n            <td width=\"40\"> -- 排序</td>\r\n            <td>\r\n              <select id=\"super_agents_id\" name=\"sort\" onChange=\"document.myFORM.submit();\" class=\"za_select\">\r\n                <option value=\"alias\">会员名称</option>\r\n                <option value=\"memname\">会员帐号</option>\r\n                <option value=\"adddate\">加入日期</option>\r\n              </select>\r\n              <select id=\"enable\" name=\"orderby\" onChange=\"self.myFORM.submit()\" class=\"za_select\">\r\n                <option value=\"asc\">升幂(由小到大)</option>\r\n                <option value=\"desc\">降幂(由大到小)</option>\r\n              </select>\r\n            </td>\r\n            <td width=\"52\"> -- 总页数:</td>\r\n            <td>\r\n              <select id=\"page\" name=\"page\" onChange=\"self.myFORM.submit()\" class=\"za_select\">\r\n\t\t\t\t\t\t\t";

for ($i=0; $i<$page_count; $i++){
	echo ( "<option value='".$i."'>".( $i + 1 ) )."</option>";
}
echo "              </select>\r\n            </td>\r\n            <td> / ";
echo $page_count;
echo " 页 -- </td>\r\n            <td>\r\n              <input type=BUTTON name=\"append\" value=\"新增\" onClick=\"document.location='./mem_add.php?uid=";
echo $uid;
echo "'\" class=\"za_button\">\r\n            </td>\r\n          </tr>\r\n        </table>\r\n\t\t\t</td>\r\n    <td width=\"30\"><img src=\"\" width=\"30\" height=\"24\"></td>\r\n</tr>\r\n<tr>\r\n\t<td colspan=\"2\" height=\"4\"></td>\r\n</tr>\r\n</table>\r\n";
if ( $cou == 0 )
{
				echo "  <table style=\"margin-left:20px;margin-bottom: 10px;\" width=\"775\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"E3D46E\" class=\"m_tab\">\r\n    <tr class=\"m_title\">\r\n      <td height=\"30\" >";
				echo $mem_nomem;
				echo "</td>\r\n    </tr>\r\n  </table>\r\n\t";
}
else
{
				echo "  <table style=\"margin-left:20px;margin-bottom: 10px;\" width=\"780\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  bgcolor=\"E3D46E\" class=\"m_tab\">\r\n    <tr class=\"m_title\">\r\n      <td width=\"60\">会员名称</td>\r\n      <td width=\"70\">会员帐号</td>\r\n      <td width=\"60\">密码</td>\r\n\t  \t<td width=\"110\">信用额度</td>\r\n\t  \t<td width=\"30\">盘口</td>\r\n      <td width=\"80\">新增日期</td>\r\n      <td width=\"70\">使用状况</td>\r\n      <td width=\"240\">功能</td>\r\n    </tr>\r\n\t";
				while ( $row = mysql_fetch_array( $result ) )
				{
								echo "\t\t<tr class=\"m_cen\">\r\n      <td>";
								echo $start_font;
								echo iconv('big5','gbk',$row['Alias']);
								echo $end_font;
								echo "</td>\r\n      <td>";
								echo $start_font;
								echo $row['Memname'];
								echo $end_font;
								echo "</td>\r\n\t\t\t<td>";
								echo $start_font;
								echo $row['passwd'];
								echo $end_font;
								echo "</td>\r\n\t  \t<td align=\"right\">\r\n      <p align=\"right\">";
								echo $start_font;
								if ( $row['pay_type'] == 1 )
								{
												echo number_format( $row['money'] * $row['ratio'], 2 );
								}
								else
								{
												echo number_format( $row['Credit'] * $row['ratio'], 2 );
								}
								echo $end_font;
								echo "</td>\r\n      <td>";
								echo $start_font;
								echo $row['OpenType'];
								echo $end_font;
								echo "</td>\r\n\t  <td>";
								echo $row['AddDate'];
								echo "</td>\r\n\t  <td>";
								echo $caption2;
								echo "</td>\r\n      <td align=\"left\"><font color=\"#0000FF\"><a style=\"cursor: hand\">\r\n\t\t&nbsp;&nbsp;<a href=\"javascript:CheckSTOP('wager_add.php?uid=";
								echo $uid;
								echo "&active=2&id=";
								echo $row['ID'];
								echo "&enable=";
								echo $memstop;
								echo "','$memstop')\">";
								echo $caption1;
								echo "</a>";
							if($setdata['d0_wager_add_deluser']==1){
								echo "&nbsp;/&nbsp; <a href=\"javascript:CheckDEL('?uid=$uid&active=3&id=$row[ID]')\">删除</a>";
							}
							if($setdata['d0_wager_add_edit']==1){
								echo "&nbsp;/&nbsp; <a href=\"hide_list.php?uid=$uid&username=$row[Memname]\">详细投注</a>";
							}
								echo "</td>\r\n    </tr>\r\n";
				}
				echo "\t</table>\r\n</form>\r\n\r\n";
}
echo "</body>\r\n</html>";
?>
