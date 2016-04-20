<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件
date_default_timezone_set('PRC');

function getIP() {
    if (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
    }
    elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    }
    elseif (getenv('HTTP_X_FORWARDED')) {
        $ip = getenv('HTTP_X_FORWARDED');
    }
    elseif (getenv('HTTP_FORWARDED_FOR')) {
        $ip = getenv('HTTP_FORWARDED_FOR');
    }
    elseif (getenv('HTTP_FORWARDED')) {
        $ip = getenv('HTTP_FORWARDED');
    }
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}



$uri = $_SERVER['REQUEST_URI'];
$uriArr = explode("/",$uri);

if(in_array('Service',$uriArr)){
    define('CURRENTAPP','Service');
    define('VisitorModuleKey','visitor:service:traffic');
    define('VisitorModuleSet','visitor:service:set');

}elseif(in_array('Log',$uriArr)){
    define('CURRENTAPP','Log');
    define('VisitorModuleKey','visitor:log:traffic');
    define('VisitorModuleSet','visitor:log:set');
}else{

    define('CURRENTAPP','Admin');
    define('VisitorModuleKey','visitor:admin:traffic');
    define('VisitorModuleSet','visitor:admin:set');
}

if(in_array('login',$uriArr) || in_array("login.html",$uriArr)){
    if(CURRENTAPP == 'Service'){
        define('VisitorLoginHash','visitor:service:login:hash');
    }elseif(CURRENTAPP == 'Log'){
        define('VisitorLoginHash','visitor:log:login:hash');
    }else{
        define('VisitorLoginHash','visitor:admin:login:hash');
    }
}





define('RedisHost','172.20.0.208');
define('RedisPort','6379');

define('VisitorHash','visitor:ip:hash');
define('VisitorSet','visitor:ip:set');

//每个模块都记录浏览量：


/*$redis = new Redis();
if($conn = $redis->connect(RedisHost,RedisPort)){

    $ip = getIP();

    $redis->incr(VisitorModuleKey,1);  //对应模块访问量加1；
    $redis->sadd(VisitorModuleSet,$ip);//把ip记录对应的访问模块；

    if(defined('VisitorLoginHash')){
        $redis->hincrby(VisitorLoginHash,$ip,1); //记录IP登录次数；
        //$redis->hset(VisitorLoginHash,$ip,strval(date('Y-m-d H:i:s')));
    }

    //单独记录IP地址访问次数；
    $redis->hincrby(VisitorHash,$ip,1);
    //记录系统独立访客；
    $redis->sadd(VisitorSet,$ip);
    //记录当天访客；
    $date =date('Y-m-d');
    $hashDate = $date.":"."ip:hash";
    $redis->hincrby($hashDate,$ip,1);
    $redis->close();
}else{
    print_r("Redis Connection Error!");
}
*/
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',true);//

/**
 * 缓存目录设置
 * 此目录必须可写，建议移动到非WEB目录
 */
define ( 'RUNTIME_PATH', './Runtime/' );

//定义公共模块的目录，放到应用目录外
define('COMMON_PATH','./Common/');

//关闭目录安全文件的生成
define('BUILD_DIR_SECURE', false);

// 定义应用目录
define('APP_PATH','./Application/');

define('BASE_DIR', dirname(__FILE__));
// 定义BASE_DIR(即index.php)相对于DOCMENT ROOT的相对路径前缀
$prefix = str_replace($_SERVER["DOCUMENT_ROOT"],'',str_replace('\\','/',BASE_DIR));
define('PREFIX_DIR',$prefix);

//echo PREFIX_DIR;

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单
