<html>
<head>
<TITLE></TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="style/index.css" rel="stylesheet" type="text/css">
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
	LoginForm.action="sc_corp/login.php?langx=zh-cn";
}
//-->
</script>
</head>
<body onLoad="onload();">
<div class="lang">
  <div class="link">
    <ul>
      <li><img name="link_tw" src="images/2004/link_tw.gif"  border="0" alt=""></li><li><a href="./index.php?langx=zh-cn"><img name="link_cn" src="images/2004/link_cn.gif"  border="0" alt=""></a></li><li><a href="./index.php?langx=en-us"><img name="link_us" src="images/2004/link_us.gif"  border="0" alt=""></a></li><li><a href="./index.php?langx=jis-jp"><img name="link_jp" src="images/2004/link_jp.gif"  border="0" alt=""></a></li><li><img src="images/2004/index_top1.gif" width="33" height="25"></li>
    </ul>
  </div>
</div>

<div class="main_bg">
  <form name="LoginForm" method="post" action="">
   <!--<form name="LoginForm" method="post" action="./login.php">-->
    <INPUT TYPE=HIDDEN NAME="langx" VALUE="zh-cn">

  <div class="main">
    <!-- 登入123 -->
	<h1>
	  <input name="radiobutton" type="radio" value="radiobutton" checked >登0
	  <!--input name="radiobutton" type="radio" value="radiobutton">登2
	  <input name="radiobutton" type="radio" value="radiobutton">登3-->
    </h1>

	<p>帳號 : <INPUT ID="Forms Edit Field2" TYPE=TEXT NAME="username" VALUE="" SIZE=8 MAXLENGTH=16></p>
	<p>密碼 : <INPUT ID="Forms Edit Field1" TYPE=PASSWORD NAME="passwd" VALUE="" SIZE=8 MAXLENGTH=16>
	<input class="login" name="Submit" type="image" id="Forms Button1" src="images/2004/button.jpg" align="middle" border="0" onClick="chk_type();">
	</p>
  </div>

  </form>
</div>

  <br>
</body>
</html>
