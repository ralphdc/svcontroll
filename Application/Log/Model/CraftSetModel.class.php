<?php
/**
 * 日志服务和java通信公共数据接口类子类（分析器配置）
 * @author zengguangqiu
 *
 */
class CraftSetModel extends CommunicationModel {
	var $method = array(
			'index'=>'xgd.log.analyser.getanalyser',
			'add'=>'xgd.log.analyser.adduptanalyser',
			'update'=>'xgd.log.analyser.adduptanalyser',
			'delete'=>'xgd.log.analyser.delanalyser',
			'deleteall'=>'xgd.log.analyser.delanalysers',
			'getrow'=>'xgd.log.analyser.analyserdetail',
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
		//dump($post);
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['rtndata'];
		$this->count = $result['count'];
		return $result['result'];
	}
	/**
	 * 根据ID获取一行记录
	 * @param int $id
	 */
	function getRowInfo($id)
	{
		$post['id'] = $id;
		$post['method']=$this->method['getrow'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['rtndata'];
	}
	/**
	 * 删除一个的接口
	 * @param string $service
	 */
	function delete($service)
	{
		$post['service'] = $service;
		$post['method']=$this->method['delete'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}
	/**
	 * 删除多个的接口
	 * @param string $service
	 */
	function deleteAll($service)
	{
		$post['service'] = $service;
		$post['method']=$this->method['deleteall'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}
}