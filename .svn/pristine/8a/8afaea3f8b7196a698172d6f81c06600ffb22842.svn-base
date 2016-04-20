<?php
/**
 * 日志服务和java通信公共数据接口类子类（调用链）
 * @author zengguangqiu
 *
 */
class CallChainModel extends CommunicationModel {
	var $method = array(
			'index'=>'xgd.log.history.chain',
			'getall'=>'xgd.log.history.allchain',
			'cmuse'=>'xgd.log.statistic.cmuse',
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
			setcookie('numPerPage'.$post['type'],$post['numPerPage']);
			$numPer = $post['numPerPage'];
		}
		else {
			$numPer = $_COOKIE['numPerPage'.$post['type']]?$_COOKIE['numPerPage'.$post['type']] : 20;
		}
		$limit1 = (intval($Num)-1)*intval($numPer);
		$limit = array(intval($numPer),$limit1);
		$post['method']=$this->method['index'];
		$post['pageIndex']=intval($Num);
		$post['type']=$post['type'];
		$post['pageSize']=intval($numPer);
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array["rtndata"];
		$this->count = $result['count'];
		if($post['type'] == 1)
		{
			return $result['respList'];
		}elseif($post['type'] == 2)
		{
			return $result['respList'];
		}elseif($post['type'] == 3)
		{
			return $result['respList'];
		}elseif($post['type'] == 4)
		{
			return $result['respList'];
		}elseif($post['type'] == 5)
		{
			return $result['respList'];
		}
		else 
		{
			return $result['result'];
		}
	}
	
	function getLineGraph($post, $get)
	{
		if(!Empty($post)){
			foreach ($post as $key=>$valus){
				$post[$key]=trim($valus," ");
			}
		}
		$post['method']=$this->method['cmuse'];
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		//dump($array);
		$result = $array["rtndata"];
		return $result;
	}
	/**
	 * 根据POST过来的数据提取查询条件查询记录
	 * @param array $post
	 * @return array
	 */
	function findAllByPost ($post, $get) {
		if(!Empty($post)){
			foreach ($post as $key=>$valus){
				$post[$key]=urlencode(trim($valus," "));
			}
		}
		$post['method']=$this->method['getall'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['rtndata'];
		return $result;
	}
}