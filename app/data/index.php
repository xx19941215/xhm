<!doctype html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>小红帽校园助手</title>
<link rel="stylesheet" type="text/css" href="res/css/styles.css">
<script type="text/javascript">
function zzcx()
{
	var a = document.getElementById("submit_btn");
	a.innerHTML="正在查询。请稍等";
	}
</script>
</head>
<body>
<div class="htmleaf-container">
	<div class="wrapper">
		<div class="container">
			<h1>Welcome</h1>
			<h1 style="font-size:30px;">请正确填写</h1>
<?php 
	require_once'function.php';
?>

<form action="chengji2.php" method="POST">
	<input type="text" name="u" placeholder="学号"/><br/>
	<input type="password" name="p" placeholder="密码"/><br/>
	<?php getRondom();?><br/>
	<input type="text" name="txtSecretCode" placeholder="验证码">
	<button type="submit" id="submit_btn" onclick="zzcx()">查询成绩</button>
</form>
</div>
		
		<ul class="bg-bubbles">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
</div>

<script src="res/js/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="res/js/bm.js"></script>
<footer id="footer"> 
<h5 class="text-success"> &nbsp;吐槽考试戳 <a href="http://vzan.cc/f/s-5053" >这里</a></h5>
<span style="display:none;"><script src="http://s4.cnzz.com/stat.php?id=1256602501&web_id=1256602501" language="JavaScript"></script></span>
</footer> 
</body>
</html>