<?php
/**
 * 服务管服务和java通信公共数据接口类子类（初始化机器历史记录）
 * @author zengguangqiu
 *
 */
class RepertscrhisModel extends CommunicationModel {
	var $method = array(
			'index'=>'repertory.scripthistory.search',
			'getlogcontent'=>'repertory.scripthistory.get',
			'initmechine' =>'repertory.initscript.create',
			'excuteorder' => 'repertory.executescript.create',
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
		$post['data']['ipv'] = $post['ipv'];
		$post['data']['begintime'] = $post['begintime'];
		$post['data']['endtime'] = $post['endtime'];
		$post['data']['person'] = $post['person'];
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
	 * 根据调度计划ID获取日志记录
	 * @param int $id
	 */
	function getlogcontent($id)
	{
		$post['id'] = $id;
		$post['key']=$this->method['getlogcontent'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['data'];
	}
	
	/**
	 * 初始化服务器
	 * @param array $post
	 */
	public function initmechine($post)
	{
		$post['key']=$this->method['initmechine'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}
	
	/**
	 * 执行命令
	 * @param array $post
	 */
	public function excuteorder($post)
	{
		$post['key']=$this->method['excuteorder'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}
	
	
}