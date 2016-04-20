<?php
/**
 * 日志服务和java通信公共数据接口类子类（实时监控总数）
 * @author zengguangqiu
 *
 */
class RealTimeDetectionModel extends CommunicationModel {
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
	 * 根据IP地址返回监控的相关的详细信息
	 * @param string $ip
	 */
	public function showMoitorDetail($post,$get)
	{
		$post['ip'] = $post['ip'];
		$post['method'] = $this->method['showDetail'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['rtndata'];
	}
}