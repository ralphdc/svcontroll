<?php
/**
 * 日志服务和java通信公共数据接口类子类（日志历史查询）
 * @author zengguangqiu
 *
 */
class QueryHistoryLogModel extends CommunicationModel {
	var $method = array(
			'index'=>'xgd.log.history.history',
			'getall'=>'xgd.log.history.all',
			'getmsg'=>'xgd.log.history.getmsg'
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
				$post[$key]=urlencode(trim($valus," "));
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
	
	function getMsgInfo($id,$type)
	{
		$post['id'] = $id;
		$post['type'] = $type;
		$post['method']=$this->method['getmsg'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['rtndata']['msg'];
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