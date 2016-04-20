<?php
/**
 * 日志服务和java通信公共数据接口类子类（收集器配置）
 * @author zengguangqiu
 *
 */
class CollectSetModel extends CommunicationModel {
		var $method = array(
			'update'=>'xgd.log.collector.addupt',
			'getrow'=>'xgd.log.collector.get'
	);

	function getRowInfo()
	{
		$post['method']=$this->method['getrow'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		//dump($array);
		return $array['rtndata'];
	}
	
	function saveRowInfo($post)
	{
		$post['method']=$this->method['update'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);		
		$array = json_decode($array,true);
		return $array;
	}
}