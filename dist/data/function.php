<?php
header("Content-type:text/json;charset=utf-8");
error_reporting(E_ALL&~E_NOTICE);
define("URL","http://211.67.191.99");
$url_length = strlen(URL);
function curl_request($url,$post='',$cookie='',$returnCookie=0){
	$curl=curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
	curl_setopt($curl, CURLOPT_REFERER, URL.'/default2.aspx');
	if($post){
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
	}
	if($cookie){
		curl_setopt($curl, CURLOPT_COOKIE, $cookie);
	}
	curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
	curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$data=curl_exec($curl);
	if(curl_errno($curl)){
		return curl_error($curl);
	}
	curl_close($curl);
	if($returnCookie){
		list($header,$body)=explode("\r\n\r\n", $data,2);
		preg_match_all("/Set\-Cookie:([^;]*);/",$header,$matches);
		$info['cookie']=substr($matches[1][0], 1);
		$info['content']=$body;
		return $info;
	}else{
		return $data;
	}
	
}
//取得cookie的url地址
function getUrl(){
	$url= URL.'/default2.aspx';
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);//设置请求的url
	curl_setopt($curl, CURLOPT_HEADER, 1);//将头文件的信息作为数据流输出
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //将curl_exec获取的信息以文件流输出
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	$header = curl_exec($curl);
	//echo nl2br($header);
	curl_close($curl);
	$Location = substr($header,strpos($header,'Location:')+9,42);//strpos()查找字符串首次出现的位置
	$Location = trim($Location);//去除字符串首尾处的空白字符
	$url = URL.$Location;
	return $url;
}
//取得__VIEWSTATE值
function getView(){
	$url= URL.'/default2.aspx';
	$result=curl_request($url,'','','');
	$pattern='/<input type="hidden" name="__VIEWSTATE" value="(.*?)" \/>/is';
	//echo $result;
	preg_match_all($pattern, $result,$matches);
	return $matches[1][0];
}
function login(){
	$parameter=getView();
	$post['__VIEWSTATE']=$parameter;
	$post['txtUserName']=$_REQUEST['u'];
	$post['TextBox2'] = $_REQUEST['p'];
	$post['RadioButtonList1'] = iconv('utf-8', 'gb2312', '学生');
	$post['Button1'] = iconv('utf-8', 'gb2312', '登录');
	$post['txtSecretCode']=$_REQUEST['txtSecretCode'];
	$url= URL."/(".$_REQUEST['random'].")/default2.aspx";

	$result = curl_request($url,$post,'');
	return $url;
	
}

function getRondom(){
	global $url_length;
	$url=getUrl();
	$verifyurl=substr($url,0,$url_length+28)."CheckCode.aspx";
	//echo $verifyurl;
	//echo '<img src='.$verifyurl.'/>';
	//$result = curl_request($url,$post,'');
	//echo $result;
	//获取一段类似 cwm2ruev32x0o4553u5avhyy 的值
	$random=substr($url,$url_length+2,24);
	//echo $random;

	$img=file_get_contents($verifyurl);
	$imgurl="./file/".$random.".gif";
	file_put_contents($imgurl, $img);
	$imgurl2="./file/".$random.".gif";
	if(file_exists($imgurl2)){
		echo json_encode(array("url"=>$imgurl2,"random"=>$random,"status"=>"ok"));
		}
	else{
		echo json_encode(array("status"=>"fail"));
	}
}
//表格变数组
function getarray($table) {
	$table = preg_replace("'<table[^>]*?>'si","",$table);
	$table = preg_replace("'<tr[^>]*?>'si","",$table);
	$table = preg_replace("'<td[^>]*?>'si","",$table);
	$table = str_replace("</tr>","{tr}",$table);
	$table = str_replace("</td>","{td}",$table);
	//去掉 HTML 标记
	$table = preg_replace("'<[/!]*?[^<>]*?>'si","",$table);
	//去掉空白字符
	$table = preg_replace("'([rn])[s]+'","",$table);
	$table = preg_replace('/&nbsp;/',"",$table);
	$table = str_replace(" ","",$table);
	$table = str_replace(" ","",$table);
	$table = explode('{tr}', $table);
	array_pop($table);
	$index = 0;
	foreach ($table as $key=>$tr) {
		$td = explode('{td}', $tr);
		array_pop($td);
		$arr["index"] = $index++;
		$arr["data"] = $td;
		$td_array[] = $arr;
	}
	return $td_array;
}
?>