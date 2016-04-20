<?php
/**
 * 日志服务和java通信公共数据接口类子类（实时监控总数）
 * @author zengguangqiu
 *
 */


class DownloadModel extends CommunicationModel {
	var $method = array(
			'index'=>'xgd.log.monitor.rtmonitor',
			'showDetail'=>'xgd.log.monitor.rtdetail',
	);
	
	
	function __construct(){
	    //ini_set('default_socket_timeout', -1);
	    $this->redis = new Redis();
	    $this->redis->connect(C('RedisToggle.host'),C('RedisToggle.port'));
	    
	    
	}
	
	/**
	 * 根据POST过来的数据提取查询条件查询记录条数
	 * @param array $post
	 * @return int
	 */
	
	
	function countByPost ($post, $get) {
		if(empty($this->count)){
		   $this->count = 0;
		}
		return $this->count;	
	}
	
	/**
	 * 根据POST过来的数据提取查询条件查询记录
	 * @param array $post
	 * @return array
	 */
	function findByPost ($post, $get) {
		if(!Empty($post)){
			foreach ($post as $key=>$valus){
				$post[$key]=trim($valus," ");
			}
		}
		$Num = $post['pageNum']!='' ? $post['pageNum'] : 1;
		if ($post['numPerPage']!='') {
			setcookie('numPerPage',$post['numPerPage']);
			$numPer = $post['numPerPage'];
		}
		else {
			$numPer = $_COOKIE['numPerPage']!=0 ?$_COOKIE['numPerPage'] : 20;
		}
		$limit1 = (intval($Num)-1)*intval($numPer);
		$limit = array(intval($numPer),$limit1);
		$post['method']=$this->method['index'];
		$post['pageIndex']=intval($Num);
		$post['pageSize']=intval($numPer);
		$post = $this->formatPost($post,$get);
		//dump($post);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['rtndata'];
		$this->count = $result['count'];
		return $result['respList'];
	}
	/**
	 * ICE下载开始和停止的接口
	 * @param unknown $post
	 * @param unknown $get
	 */
	function startorstopdown($post,$get)
	{
		if(!Empty($post)){
			foreach ($post as $key=>$valus){
				$post[$key]=trim($valus," ");
			}
		}
		//$url = "http://172.20.0.89:51007";
		//$url = "http://172.20.0.98:51007";
		$url = C('ICEDOWN_START_STOP');
		$post1['data']['messageType'] = "controlAidCapk";
		$post1['data']['message']['command'] = $post['iscloseStr'];
		//$post = $this->formatPost($post,$get);
		$result = $this->request_by_otherUrl($url,$post1);
		return $result;
	}
	
	/**
	 * 2015-12-10 和廖生宋、於权沟通，通过MQ-TCP协议通信，开启关闭；
	 * @param unknown $post
	 * @param unknown $get
	 * @return unknown
	 * 
	 * {
          "result":
            {
              "errorCode":"00",
              "errorDesc":"success"
              "ip":""
              "timestamp":""
              "state":""
              "mark":""
            }
        }

	 */
	function startStopToggle($post,$get)
	{
	    if(!Empty($post)){
	        foreach ($post as $key=>$valus){
	            $post[$key]=trim($valus," ");
	        }
	    }
	   
	    $post1['data']['messageType'] = "controlAidCapk";
	    $post1['data']['message']['command'] = $post['iscloseStr'];
	    $json_str = json_encode($post1);
	    
	    \Think\Log::write("===========================================发布开始====================");
	    
	    $this->redis->publish(C('RedisToggle.sendChannel'),$json_str);
	    
	    
	    \Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\发布地址：".C('RedisToggle.host'));
	    \Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\发布端口：".C('RedisToggle.port'));
	    \Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\发布频道：".C('RedisToggle.sendChannel'));
	    \Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\发布内容：".$json_str);
	    \Think\Log::write("===========================================发布完毕====================");
	    
	    return true;
	}
	
	function  modelGetRedisResponse(){
	   
           $redis =new Redis();
           $redis->connect('127.0.0.1','6379');
			$length = $redis->llen('downloadmonitor');
			if($length > 0){
				$data = $redis->lrange('downloadmonitor',0,-1);
				$fs=array();
				foreach($data as $dk=>$dv){
					$data[$dk] = json_decode($data[$dk],true);
					$fs[]=$data[$dk]['result'];
				}
			}else{
				$fs=NULL;
			}
        return $fs;	    
	}
	
	
	function webscoketRequest($post,$get)
	{
		$soap_url =C("ICEDOWN_LIST_URL");
		$soap = new SoapClient($soap_url);
		$soap->soap_defencoding = 'utf-8';
		$soap->xml_encoding = 'utf-8';
		$option = array('startTime'=>$post['start'],'endTime'=>$post['end']);
		$fucname = 'queryCapkUpgradeByTime';
		try{
			$ret = $soap->queryCapkUpgradeByTime($option);
			$response = $this->obj2array($ret);
			return $response;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}
	
	private function obj2array($obj) {
		$out = array();
		foreach ($obj as $key => $val) {
			switch(true) {
				case is_object($val):
					$out[$key] = $this->obj2array($val);
					break;
				case is_array($val):
					$out[$key] = $this->obj2array($val);
					break;
				default:
					$out[$key] = $val;
			}
		}
		return $out;
	}
}
