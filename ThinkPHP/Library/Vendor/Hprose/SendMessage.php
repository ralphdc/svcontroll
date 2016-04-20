<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2013 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
/**
 * ThinkPHP SendMessage类
 */


require_once('XGD_iceintf_base.php');

class SendMessage {
    
	public $ic = null;
	public $serversap = null;
	/**
	 * 构造函数
	 * 请求连接
	 *
	 */
    public function __construct() {
        $this->ic = Ice_initialize();
		$base = $this->ic->stringToProxy(C('ProxyComp'));//

		$Helper = new core_ServerSapPrxHelper;
	    $this->serversap =  core_ServerSapPrxHelper::checkedCast($base);
	  
	    if(!$this->serversap)
	        die("Invalid proxy");
    	
    }
    
    public function send($Header,$Param){
    	$ServiceID = $Header['destServID'];
    	$messageID = $Header['messageID'];
    	if($ServiceID < 16000 ||$ServiceID > 16999 ){
    		die("destServID is wrong");
    	}
    	if(!is_array($Param)){
    		die("Param is wrong");
    	}    
    	
    	$Param['curUserId'] = $_SESSION['login_count'];//大UID
    	$Param['curUserNo'] = $_SESSION['cUserNo'];//传登录帐号
    	//$Param['xgdSessionId'] = $_SESSION['xgdSessionId'];//传登录帐号
    			
    	Think\Log::write("//////////////发送信息 ////////////////////");
    	
    	$xgdsession = array('xgdSessionId'=>$_SESSION['xgdSessionId']);
    	$header = new core_SrvMsgHeader($ServiceID,$messageID,0,'',0,'',0,'','',0,'',0,$xgdsession); 
    	$reqs = json_encode($Param);
    	Think\Log::write("头信息".json_encode($header,true));
    	$this->serversap->InvokeTxtSync($header,$reqs,$ret);
    	
    	
    	Think\Log::write("发送参数".$reqs);
    	Think\Log::write("返回结果".$ret);
    	Think\Log::write("//////////////发送参数完 ////////////////////");
    	$ret = json_decode($ret,true);
    	return $ret;
    	
    }
    
    public function __destruct(){
    	try
    	{
    		Think\Log::write("***************销毁**************************");
    		$this->ic->destroy();
    	}
    	catch(Exception $ex)
    	{
    		echo $ex;
    	}
    }

}