<?php
/**
 * 服务管服务和java通信公共数据接口类子类（机器类型管理）
 * @author zengguangqiu
 *
 */
class MechinetypeModel extends CommunicationModel {
	var $server = '/omp/asset';
	var $method = array(
			'index'=>'asset.servermodel.search',
			'add'=>'asset.servermodel.create',
			'update'=>'asset.servermodel.update',
			'delete'=>'asset.servermodel.delete',
			'deleteall'=>'asset.servermodel.deletebatch',
			'getrow'=>'asset.servermodel.get',
			'getall'=>'asset.servermodel.list',
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
		$post['data']['stChar']=$post['stChar'];
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
		$post['id'] = $id;
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
}