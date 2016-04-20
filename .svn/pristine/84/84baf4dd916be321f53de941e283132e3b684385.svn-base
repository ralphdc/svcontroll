<?php
ini_set('default_socket_timeout',3600);
$redis_remote =new Redis();
//$redis_remote->connect('172.30.2.170','6379');
$redis_remote->connect('172.17.3.153','6379');
$redis_remote->subscribe(array('mpayToOperationChannel'),'redisCallBack');
function redisCallBack($instance,$channel,$message){
	$redis_local =new Redis();
    $redis_local->connect('127.0.0.1','6379');
	$redis_local->lpush('downloadmonitor',$message);
	$redis_local->close();
}
