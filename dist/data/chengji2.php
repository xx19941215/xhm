
<?php

header("Content-type:text/json;charset=utf-8");
require_once 'function.php';

$url = login();
$url = substr($url,0,strrpos($url,'/')+1);
$xuehao = $_REQUEST['u'];;
$xm = $_REQUEST['xm'];
//http://211.67.191.45/(osnm3na1h3ax5145plfbmt55)/xscj.aspx?xh=5004130022&xm=%D0%A4%E4%EC&gnmkdm=N121608
$url = $url.'xscj.aspx?xh='.$xuehao.'&xm='.$xm.'&gnmkdm=N121608';
$result = curl_request($url);
//echo $res=mb_convert_encoding($result, "UTF-8","GB2312");
$pattern = '/<input type="hidden" name="__VIEWSTATE" value="(.*?)" \/>/is';
preg_match_all($pattern, $result, $matches);
$res = $matches[1][0];
$pattern2='/<span id="Label5">(.*?)<\/span>/is';
preg_match_all($pattern2,$result,$name);
$nameinfo = mb_convert_encoding($name[1][0], "UTF-8","GB2312");
$name=substr($nameinfo,9,6);
$post['__VIEWSTATE'] = $res;
$post['txtQSCJ'] = 0;
//iconv('utf-8', 'gb2312', '查询');
$post['txtZZCJ'] = 100;
//iconv('utf-8', 'gb2312', '全部');
$post['Button2'] = iconv('utf-8','gb2312','在校学习成绩查询');
//$post['ddl_kcxz'] = "";
$chengji = curl_request($url,$post);
$chengji = mb_convert_encoding($chengji, "UTF-8", "GB2312");  //编码转换
//echo $chengji;
preg_match_all('/<table class="datelist" cellspacing="0" cellpadding="3" border="0" id="DataGrid1" width="100%">([\s\S]*?)<\/table>/',$chengji,$table1);//用正则表达式将课表的表格取出
$result1=$table1;
$table2=$result1;
$arr1 = getarray($table2[0][0]);

//print_r($arr1);
//删除验证码图片
$r = $_REQUEST['random'];
$delpath="./file/".$r.".gif";
if(file_exists($delpath)){
unlink($delpath);
}

//echo $arr1[0][0];
if(trim($arr1[0]["data"][0])!==trim("课程代码"))
{
	$arr = array("status"=>"fail");
	echo json_encode($arr);
}

else
{
	$arr = array(
		"status"=>"ok",
		"data"=>$arr1
	);
	echo json_encode($arr);
}
