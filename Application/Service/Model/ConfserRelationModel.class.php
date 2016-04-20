<?php
/**
 * 服务管服务和java通信公共数据接口类子类（查看引用配置实例的服务实例）
 * @author zengguangqiu
 *
 */
class ConfserRelationModel extends CommunicationModel {
	var $method = array(
			'index'=>'config.serviceinstance.search',
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
		$post['key']=$this->method['index'];
		$post['data']['cfginstanceid']=$post['cfginstanceid'];
		$post['data']['ipv']=$post['ipv'];
		$post['data']['servicename']=$post['servicename'];
		$post['data']['envtype']= trim($_SESSION['WEB_ENVIRONMENT']);
		$post['page']['pageNo']=intval($Num);
		$post['page']['pageSize']=intval($numPer);
		$post = $this->formatPost($post,$get);
		//dump($post);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		//dump($array);
		$result = $array['data'];
		$this->count = $array['total'];
		return $result;
	}
}