<?php
$url=isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:"http://www.eeyes.net";
?>
<!DOCTYPE HTML>
<html>
<head>
<title>
Oops!您指定的页面没有找到...5秒钟之后将会带您返回首页.
</title>
<link rel="stylesheet" href="style.css" type="text/css"/>
<meta charset="utf-8"></meta>
<meta http-equiv="Refresh" content="5; url=<?php  echo $url; ?>" />
</head>
<body>
<div id="notfound">
<img src="http://www.eeyes.net/404.png" width="100%" height="100%"/>
</div>
<div id="frog">
<img src="http://www.eeyes.net/frog.gif" width="100%" height="70%"/>
</div>
</body>
</html>