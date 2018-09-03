<html>
<head>
<TITLE></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!--<link href="style/index.css" rel="stylesheet" type="text/css">-->
    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/form-elements.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="shortcut icon" href="assets/ico/favicon.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function onload(){

}

function chk_type(){
	LoginForm.action="./sc_corp/login.php?langx=zh-vn";
}
//-->
</script>
</head>
<body onLoad="onload();">
<div class="top-content">

    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1><strong>Đăng nhập</strong> Hệ thống quản lý nền</h1>
                    <div class="description">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3>Login to our site</h3>
                            <a href="../new_index.php?langx=zh-cn"><span name="link_cn" class="lan_word">简体版</span></a>
                            |
                            <a href="./new_index.php?langx=vi_VN"><span name="link_us" class="lan_word_on">Người việt </span></a>
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form role="form" name="LoginForm" method="post" action="../sc_corp/login.php" class="login-form">
                            <INPUT TYPE=HIDDEN NAME="langx" VALUE="zh-vn">
                            <div class="form-group">
                                <label class="sr-only" for="form-username">Username</label>
                                <input type="text" name="username" placeholder="Vui lòng nhập tên người dùng" class="form-username form-control" id="form-username">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-password">Password</label>
                                <input type="password" name="passwd" placeholder="Vui lòng nhập mật khẩu" class="form-password form-control" id="form-password">
                            </div>
                            <button type="submit" class="btn" onClick="chk_type();">Đăng nhập</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.backstretch.min.js"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>
