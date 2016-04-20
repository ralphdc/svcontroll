<?php
/**
 * 服务管服务和java通信公共数据接口类子类（批量处理）
 * @author zengguangqiu
 *
 */
class TasklookModel extends CommunicationModel {
	var $method = array(
			'index'=>'batch.taskview.getbatch'
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
		$post['pageIndex']=intval($Num);
		$post['pageSize']=intval($numPer);	
		$post['page']=array(
				"pageNo"=> $Num,
				"pageSize"=> $numPer,
		);
		$post['data']['servicename'] = $post['servicename'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		$this->count = $array['total'];
		return $result;
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
}