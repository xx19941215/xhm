<?php 

$r = $_REQUEST['random'];
$path = "./file/".$r.".gif";
if(file_exists($path)){
	unlink($path);
	echo json_encode(array("status"=>"ok"));
}