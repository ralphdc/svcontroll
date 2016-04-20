<?php
/**
 * 日志服务和java通信公共数据接口类子类（按调用次数统计）
 * @author zengguangqiu
 *
 */
class ChainCountModel extends CommunicationModel {
	var $method = array(
			'index'=>'xgd.log.statistic.tntc',
			'getmaxmin'=>'xgd.log.statistic.tntcd',
	);
	
	public function findByPost($post, $get)
	{
		if(!Empty($post)){
			foreach ($post as $key=>$valus){
				$post[$key]=trim($valus," ");
			}
		}
		$post['method']=$this->method['index'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		return $array['rtndata']['respList'];
	}
	
	public function getMaxMin($post, $get)
	{
		$post['method']=$this->method['getmaxmin'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		return $array['rtndata']['respList'];
	}
}