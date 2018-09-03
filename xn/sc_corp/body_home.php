<?
Session_start();
if (!$_SESSION["tktk"])
{
echo "<script>window.open('/index.php','_top')</script>";
exit;
}
require_once('../member/include/config.inc.php');
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$langx='zh-vn';
require ("../member/include/traditional.$langx.inc.php");

$sql = "select agname from web_super where Oid='$uid'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$agname=$row['agname'];

$sql = "select agname from web_super where subuser=1 and subname='$agname'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
	$ag=" M_czz='".$row['agname']."' or ";
}


$sql = "select * from web_system";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$messages=$row['msg_member'];

?>
<html>
<head> 
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.m_title_re {  background-color: #577176; text-align: right; color: #FFFFFF}
.m_bc { background-color: #C9DBDF; padding-left: 7px }
-->
</style>
    <link rel="stylesheet" href="/style/control/announcement/a1.css" type="text/css">
    <link rel="stylesheet" href="/style/control/announcement/a2.css" type="text/css">
    <link rel="stylesheet" href="./css/loader.css" type="text/css">
    <script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
    <script src="/js/ClassSelect_ag.js" type="text/javascript"></script>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/calendar.css">
<link rel="stylesheet" href="/style/control/control_main1.css" type="text/css">
    <link rel="stylesheet" href="/style/home.css" type="text/css">
    <link rel=stylesheet type=text/css href="/style/nav/css/zzsc.css">
    <script type="text/javascript">
        // 等待所有加载
        $(window).load(function(){
            $('body').addClass('loaded');
            $('#loader-wrapper .load_title').remove();
        });
        function go_web(sw1,sw2,sw3) {
            if(sw1==1 && sw2==5){Go_Chg_pass(1);}
            else{window.open('trans.php?sw1='+sw1+'&sw2='+sw2+'&sw3='+sw3,'main');}
        }
    </script>
<style type="text/css">
<!--
.m_title_ce {background-color: #669999; text-align: center; color: #FFFFFF}
-->
</style>
<body bgcolor="#edcbcb" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">Đang tải...</div>
</div>
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
<div id="body_show" style="float:left;"><div>
    <div name="MaxTag" id="home" src="/js/home.js" linkage="home">

        <div id="home_contain" class="home_contain" onresize="setDivSize(this)" style="width: 67%;min-width: 1200px;">
            <div id="home_box" class="home_box">
                <div id="top_title" class="top_title"><span>Lời nhắc thay đổi mật khẩu và thay đổi mật khẩu</span></div>
                <div id="status_contain" class="status_contain" style="width: 67%;float:left;">
                    <div id="status_title" class="status_title">
                        <span class="title_box" style="min-width: 150px;">Thời gian</span>
                        <span class="title_box2 margin_right" style="min-width: 60px;">Nhà điều hành</span>
                        <span class="title_box2" style="min-width: 60px;">Dự án</span>
                        <span class="title_box2" style="min-width: 60px;">Số tài khoản</span>
                        <span class="title_box3" style="min-width: 60px;">Lớp</span>
                    </div>
                    <div id="member" class="acc_box">
                        <div style="height:205px;overflow-y:auto">
                            <?
                            if($ag==""){
                                $sql="select  * from agents_log  where Status=2 and M_czz='$agname' order by M_DateTime desc";
                            }else{
                                $sql="select  * from agents_log  where Status=2 and (".$ag." M_czz='$agname') order by M_DateTime desc";
                            }
                            $result = mysql_query($sql);
                            while ($row = mysql_fetch_array($result)){
                                ?>
                                <div id="last_login" class="acc_box">
                                    <span class="info_box" style="min-width: 150px;"><?=$row["M_DateTime"]?></span>
                                    <span class="info_box2 margin_right red" style="min-width: 60px;"><font id="member_suspended"><?=$row["M_czz"]?></font></span>
                                    <span class="info_box2 black" style="min-width: 60px;"><font id="member_view"><?=$row["M_xm"]?></font></span>
                                    <span class="info_box2 gray" style="min-width: 60px;"><font id="member_inactive"><?=$row["M_user"]?></font></span>
                                    <span class="info_box3 green" style="min-width: 60px;"><font id="member_active"><?=$row["M_jc"]?></font></span>
                                </div>
                                <?
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>
<?
mysql_close();
?>
