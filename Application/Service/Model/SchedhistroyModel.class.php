<?php
/**
 * 服务管服务和java通信公共数据接口类子类（调度作业历史）
 * @author zengguangqiu
 *
 */
class SchedhistroyModel extends CommunicationModel {
	var $method = array(
			'index'=>'dispatch.list',
			'add'=>'dispatch.create',
			'update'=>'dispatch.create',
			'shutdowm'=>'dispatch.shutdown',
			'getrow'=>'dispatch.info',
			'getconfigcontent'	=>'serviceinstance.configcontent.get',
			'getlogcontent'=>'dispatchlog.info',
			'getpiccontent'=>'config.instance.snapshot.get',
			'getmoniconfigcontent'=>'monitor.configinstance.get'
	);
	
	function postSave($post,$get=null){
		$result = '';
		if($post['form_act']=='create'){
			$post['key'] = $this->method['add'];
			$post = $this->formatPost($post,$get);
			$result =$this->request_by_other( $post);
		}elseif($post['form_act']=='update'){
			$post['key'] = $this->method['update'];
			$post = $this->formatPost($post,$get);
			$result = $this->request_by_other($post);
		}elseif($post['form_act']=='shutdowm'){
			$post['key'] = $this->method['shutdowm'];
			$post = $this->formatPost($post,$get);
			$result = $this->request_by_other($post);
		}
		return json_decode($result,true);
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
		$post['key']=$this->method['index'];
		$post['data']['pnid']=$post['pnid'];
		$post['data']['isbatch']=$post['isbatch'];
		$post['data']['status']=$post['status'];
		$post['data']['servicename']=$post['servicename'];
		$post['data']['ipv']=$post['ipv'];
		$post['data']['type']=$post['type'];
		$post['data']['person']=$post['person'];
		$post['data']['result']=$post['result'];
		$post['data']['startTime']=$post['startTime'];
		$post['data']['endTime']=$post['endTime'];
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
	/**
	 * 根据调度计划ID获取一行记录
	 * @param int $id
	 */
	function getRowInfo($id)
	{
		$post['data']['dispatchid'] = $id;
		$post['key']=$this->method['getrow'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['data'];
	}
	/**
	 * 根据服务实例ID获取对应的配置信息
	 * @param int $id
	 */
	function getconfigcontent($id)
	{
		$post['id'] = $id;
		$post['key']=$this->method['getconfigcontent'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['data'];
	}
	
	/**
	 * 获取对应的配置信息
	 * @param array $post
	 */
	function getmoniconfigcontent($post)
	{
		$post['key']=$this->method['getmoniconfigcontent'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['data'];
	}
	/**
	 * 根据调度计划ID获取日志记录
	 * @param int $id
	 */
	function getlogcontent($id)
	{
		$post['data'] = array("dispatchid"=>$id);
		$post['key']=$this->method['getlogcontent'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['data']['disLog'];
	}	
	/**
	 * 根据调度计划ID获取快照
	 * @param int $id
	 */
	function getpiccontent($id)
	{
		$post['id'] = $id;
		$post['key']=$this->method['getpiccontent'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['data'];
	}
}