<?php
use Think\Exception;
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
	    $post1['data']['requestSerial'] = $post['serial'];
	    $post1['data']['message']['command'] = $post['iscloseStr'];
	    $json_str = json_encode($post1);
	    
	    $pubRedis = new Redis();
	    $conn = $pubRedis->connect(C('RedisToggle.host'),C('RedisToggle.port'));
	     if($conn){
	        \Think\Log::write("===========================================发布开始====================");
	        
	        $pubrs = $pubRedis->publish(C('RedisToggle.sendChannel'),$json_str);
	        
	        \Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\发布地址：".C('RedisToggle.host'));
	        \Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\发布端口：".C('RedisToggle.port'));
	        \Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\发布频道：".C('RedisToggle.sendChannel'));
	        \Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\发布内容：".$json_str);
	        \Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\发布结果：".$pubrs);
	        \Think\Log::write("===========================================发布完毕====================");
	        
	        $pubRedis->close();
	        
	        if(!$pubrs){
	            return array('pubrt'=>0,'pubmsg'=>'发布完毕，但接收到消息的客户端数量是零！');
	        }else{
	            return array('pubrt'=>1,'pubmsg'=>'发布成功，请等待返回！');
	        }
	    }else{
	        return array('pubrt'=>0,'pubmsg'=>'发布失败，Redis服务器连接错误！');
	    }
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