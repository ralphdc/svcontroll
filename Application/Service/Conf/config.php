<?php

define('KAIFA',0);
define('CHAO_QUN_HOST','http://172.20.0.115:8080');     //李超群；
define('YUN_KUN_HOST','http://172.20.0.94:8080');       //蒋运昆
define('QING_DING_HOST','http://172.20.0.245:8080');    //韦庆丁；
define('QING_DING_HOST2','http://172.20.12.51:8080');    //韦庆丁；

define('DEVELOP_HOST','http://172.17.6.180:8080');      //开发环境；

define('CHUN_MIAO_HOST','http://172.20.0.33:8080');     // 唐春苗；
//define('LIU_YI_HOST','http://172.17.6.131:3310');     // 刘义连接的Mysql数据库地址；
define('LIU_YI_HOST','http://172.17.3.97:10056');       // 刘义连接的Java服务地址；


$javahome = DEVELOP_HOST;

return array(
	//与后台通讯地址
	//登录0
	'ProxyLogin' =>"SeraSap:tcp -h 172.20.4.221  -p 10001",//李海丰本地172.20.0.143//测试机172.17.3.131 //开发环境 //新的登录地址 // 172.20.4.221
	//权限验证
	'ProxyComp' => "SeraSap:tcp -h 172.20.4.221  -p 10002",
	//工作流
	'ProxyWorkProcess' => "SeraSap:tcp -h 172.20.4.221 -p 10003",//包晓亮本地172.20.0.13 -p 10001//测试机 172.17.3.131 -p 10003
	
	//ralasafe地址
	'ralasafeIP' => 'http://172.20.0.143:8081/',
		
		
    'URL_MODEL'                 =>  1, // 如果你的环境不支持PATHINFO 请设置为3
	//数据库配置
    'DB_TYPE'                   =>  'mysql',
    'DB_HOST'                   =>  '172.20.0.208',
    'DB_NAME'                   =>  'mysql',
    'DB_USER'                   =>  'jtopo',
    'DB_PWD'                    =>  'Jtopo12!@',
    'DB_PORT'                   =>  '3306',
    'DB_PREFIX'                 =>  'sv_',
    
    //囚鸟先生
    'VAR_PAGE'=>'pageNum',
    'PAGE_LISTROWS'=>20,  //分页 每页显示多少条
    'PAGE_NUM_SHOWN'=>5, //分页 页标数字多少个
	
    'SESSION_AUTO_START'        =>  true,
    'TMPL_ACTION_ERROR'         =>  'Public:success', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'       =>  'Public:success', // 默认成功跳转对应的模板文件
    'USER_AUTH_ON'              =>  true,
    'USER_AUTH_TYPE'			=>  2,		// 默认认证类型 1 登录认证 2 实时认证
    'USER_AUTH_KEY'             =>  'authId',	// 用户认证SESSION标记
    'ADMIN_AUTH_KEY'			=>  'administrator',
    'USER_AUTH_MODEL'           =>  'User',	// 默认验证数据表模型
    'AUTH_PWD_ENCODER'          =>  'md5',	// 用户认证密码加密方式
    'USER_AUTH_GATEWAY'         =>  'Serivice/Public/login',// 默认认证网关
    'NOT_AUTH_MODULE'           =>  'Serivice/Public',	// 默认无需认证模块
    'REQUIRE_AUTH_MODULE'       =>  '',		// 默认需要认证模块
    'NOT_AUTH_ACTION'           =>  '',		// 默认无需认证操作
    'REQUIRE_AUTH_ACTION'       =>  '',		// 默认需要认证操作
    'GUEST_AUTH_ON'             =>  false,    // 是否开启游客授权访问
    'GUEST_AUTH_ID'             =>  0,        // 游客的用户ID
    'DB_LIKE_FIELDS'            =>  'title|remark',
    'RBAC_ROLE_TABLE'           =>  'think_role',
    'RBAC_USER_TABLE'           =>  'think_role_user',
    'RBAC_ACCESS_TABLE'         =>  'think_access',
    'RBAC_NODE_TABLE'           =>  'think_node',
    'SHOW_PAGE_TRACE'           =>  false ,   //显示调试信息
    'LOAD_EXT_CONFIG'           =>array('Contact'=>'contact'),
    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static'
    ),
    
    //应用类库不再需要使用命名空间
    'APP_USE_NAMESPACE'    =>    false,
		
	//日志服务相关的java访问的地址
	'SERVICE_JAVA_NAME'=>$javahome,
    'SERVICE_JAVA_NEW_NAME'=>'http://172.17.6.180:8888',
    //'SERVICE_JAVA_NAME'=>'http://172.20.12.245:8080',  //韦庆丁环境，配置中心设置最新功能对接 2015-11-23
	//'SERVICE_JAVA_NAME'=>'http://172.17.6.180:8080',
	//'SERVICE_JAVA_NAME'=>'http://172.20.0.94:8080',
	//memcache 配置
	'DATA_CACHE_TIME'       =>  0,      // 数据缓存有效期 0表示永久缓存
	'DATA_CACHE_COMPRESS'   =>  false,   // 数据缓存是否压缩缓存
	'DATA_CACHE_CHECK'      =>  false,   // 数据缓存是否校验缓存
	'DATA_CACHE_PREFIX'     =>  '',     // 缓存前缀
	'DATA_CACHE_TYPE'       =>  'Memcache',  // 数据缓存类型,支持:File|Db|Apc|Memcache|Shmop|Sqlite|Xcache|Apachenote|Eaccelerator
	//'MEMCACHE_HOST'   =>  'tcp://172.20.0.206:11211',
	'MEMCACHE_HOST'   =>  'tcp://172.17.6.180:11211',
		
		
		
	//C++监控服务地址
	'MNT_GSOAP_SERVER_DealNotice' => 'http://172.17.3.153:19334/DealNotice.wsdl',
	'MNT_GSOAP_SERVER' => 'http://172.17.3.153:8334/DealCmd.wsdl',
		
	//redis服务器和端口配置
	'REDISSERVER' => '172.17.6.148',
	'REDISSERVER_PORT' => '9003',
	/*'REDISSERVER' => '172.17.3.154',
	'REDISSERVER_PORT' => '6379',*/
	//运维环境数组配置
	'CONST_ENVIRONMENT'=>array('1'=>'运维镜像','2'=>'生产','3'=>'测试镜像','4'=>'测试','5'=>'开发',),//1-运维镜像，2--生产，3--测试镜像，4--测试，5--开发 
	/* 新增加菜单权限对应的产品ID*/
	'PRIVATE_PRODUCTID' => '10003',
		
	/*新增加ICE下载开始和结束的接口的URL访问地址*/
	'ICEDOWN_START_STOP' => 'http://172.20.0.98:51007',
	'ICEDOWN_LIST_URL' => 'http://172.20.0.34:8080/rcs/jaxws/services/SposWebService?wsdl',
		
		
	//简单的账号权限控制
	'AccountPassword'=>array(
			array('account'=>'jialian','password'=>'aaaaaa','USER_AUTH_KEY'=>'嘉联用户'),//嘉联用户，用户名不可改(只显示流水质量监控页面)
			array('account'=>'admin','password'=>'123456','USER_AUTH_KEY'=>'系统管理员'),//管理员，用户名不可改（设置切换设置用）
			array('account'=>'ceshi','password'=>'aaaaaa','USER_AUTH_KEY'=>'测试帐号'),
				
	),
	
    //Mpay-CAPK码，於权对接； 2015-12-11；
    'MessageQueue'=>array(
        'send_stompUri'=>'tcp://172.30.2.170:61616',
        'send_topic'=>'operationToMpay.icapk.notification',
        'gain_stompUri'=>'tcp://172.30.2.170:61616',
        'gain_queue'=>'mpayToOperation.icapk.notification'
    ),
    
    //2015-12-15 於权对接，MQ转Redis;
    'RedisToggle'=>array(
       // 'host'=>'172.30.2.170',
        'host'=>'172.17.3.153',
        'port'=>'6379',
        'sendChannel'=>'operationToMayChannel',
        'acceptChannel'=>'mpayToOperationChannel'
    ),
    
    'URL_HTML_SUFFIX'=>'',
    'LoginMark'=>'SERVICE_MANAGE',
    
    //韦工测试环境
    //'loginRequest'=>'http://172.30.2.154:8080/kms/login/ajaxsubmit.do' , 
    //韦工测试环境；
    //'loginMenu'=>'http://172.30.2.154:8080/kms/actiontree/myMenus.do',
    //'loginPWD'=>'hhttp://172.30.2.154:8080/kms/user/modifyPassword.do' ,
    
    'loginRequest'=>'http://172.17.3.97:8080/kms/login/ajaxsubmit.do' ,
    'loginMenu'=>'http://172.17.3.97:8080/kms/actiontree/myMenus.do',
    'loginPWD'=>'http://172.17.3.97:8080/kms/user/modifyPassword.do' ,
    
    
    
    
    //存储登录菜单;
    'REDIS_HOST'=>'172.17.4.203',
    'REDIS_PORT'=>'6379',

    //2016-01-14 拓扑图；
    'TPmonitor'=>array(
    	'editNode'=>'http://172.17.6.180:8080/omp/topo'
    )
    
);
