<?php
/**
 * 服务管服务和java通信公共数据接口类子类（增加元素）
 * @author zengguangqiu
 *
 */
class AddmonelementModel extends CommunicationModel {
	var $method = array(
			'index'=>'monitor.elem.search',
			'add'=>'monitor.elem.create',
			'update'=>'monitor.elem.update',
			'delete'=>'monitor.elem.deletebatch',
			'deleteall'=>'monitor.elem.deletebatch',
			'getrow'=>'monitor.elem.get',
			'getall'=>'monitor.elem.load',
			'getcheckinfo'=>'monitor.elem.auth.search',
			'savecheckinfo'=>'monitor.elem.auth.create',
			'getpersonrights'=>'monitor.elem.right.search',
			'savepersonrights'=>'monitor.elem.rights.create',
	        'getgrouprights'=>'monitor.group.right.get'
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
		if(!empty($post)){
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
		$post['data']['type'] = $post['type'];
		$post['data']['elemId'] = $post['elemId'];
		$post['data']['elemName'] = $post['elemName'];
		$post['page']['pageNo']=intval($Num);
		$post['page']['pageSize']=intval($numPer);
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		$this->count = $array['total'];
		return $result;
	}
	/**
	 * 根据ID获取一行记录
	 * @param int $id
	 */
	function getRowInfo($id)
	{
		$post['id'] = $id;
		$post['key']=$this->method['getrow'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['data'];
	}
	/**
	 * 删除单个的接口
	 * @param string $id
	 */
	function delete($id)
	{
		$post['key']=$this->method['delete'];
		$post['ids'] = $id;
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}
	/**
	 * 删除多个的接口
	 * @param string $ids
	 */
	function deleteAll($ids)
	{
		$post['key']=$this->method['deleteall'];
		$post['ids'] = $ids;
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}
	function getAll($post, $get)
	{
		$post['key']=$this->method['getall'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['data'];
	}
	
	/**
	 * 根据元素ID获取对应的调试环境的已经分配的运维人员和对应的通知方式的信息
	 * @param string $elementID
	 */
	function getCheckedInfo($elementID)
	{
		$post['key']=$this->method['getcheckinfo'];
		$post['data']['elemId'] = $elementID;
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['data'];
	}
	

	
	function postSavecheckinfo($post,$get=null){
		$post['key'] = $this->method['savecheckinfo'];
		$post = $this->formatPost($post,$get);
		$result =$this->request_by_other( $post);
		return json_decode($result,true);
	} 
	
	/**
	 * 根据元素ID获取对应的调试环境的已经分配的运维人员和对应的通知方式的信息
	 * @param string $elementID
	 */
	function getPersonRights($elementID)
	{
		$post['key']=$this->method['getpersonrights'];
		$post['id'] = $elementID;
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['data'];
	}
	
	function getGroupRights($id)
	{
	   $post['key']=$this->method['getgrouprights'];
	   $post['id']=$id;
	   $post = $this->formatPost($post);
	   $array = $this->request_by_other($post);
	   $array = json_decode($array,true);
	   return $array['data'];
	}
	
	function postSavepersonrights($post,$get=null){
		$post['key'] = $this->method['savepersonrights'];
		$post = $this->formatPost($post,$get);
		$result =$this->request_by_other( $post);
		return json_decode($result,true);
	}
}