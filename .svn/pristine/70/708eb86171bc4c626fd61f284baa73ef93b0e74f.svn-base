<?php

class GraphlogicModel extends CommunicationModel {


	public $server = "/omp/topo";
	private  $topoType = 2;
	
	private $device = array(
		'server'=>'服务器',
		'router'=>'路由器',
		'transfer'=>'交换机',
		'firewall'=>'防火墙',
		'desktop'=>'桌面机',
		'web'=>'WEB站点',
		'virtual'=>'虚拟主机',
		'balance'=>'负载均衡',
		'other'=>'其他'
	);

	
	
	
	var $method = array(
	       'list' => 'topo.listinfo.get',          // 显示拓扑图列表信息
		   'batchdel'=>'topo.info.deletebatch',	  //批量删除拓扑图
		   'delbyid'=>'topo.info.delete',          //根据ID删除拓扑图
		   'getinfobyid'=>'topo.info.get',         //根据ID查询拓扑图详细信息
		   'update'=>'topo.info.update',
	       'save'=>'topo.info.create',
	       'monitor_summary'=>'topo.info.summary',
	       'monitor_summary_lg'=>'topo.info.summary.logic',
	       'monitor_node_summary'=>'topo.node.summary',
	       'monitor_node_detail'=>'topo.node.detail',
	       'lg_monitor_node_detail'=>'topo.node.detail.logic'
	);
	
	
	function getDevicePattern()
	{
	    return $this->device;
	}
	
	
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

	    $Num = $post['pageNum']!='' ? $post['pageNum'] : 1;
	    if ($post['numPerPage']!='') {
	        setcookie('topolgnumPerPage',$post['numPerPage']);
	        $numPer = $post['numPerPage'];
	    }
	    else {
	        $numPer = $_COOKIE['topolgnumPerPage']!=0 ?$_COOKIE['topolgnumPerPage'] : C('PAGE_LISTROWS');
	    }

	    $post['key']=$this->method['list'];
	    $post['data']['topoType']=$this->topoType;
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
	 * 根据POST过来的数据提取查询条件查询记录，查询子拓扑图专用；
	 * @param array $post
	 * @return array
	 */
	function findByPostForLogicChildTP ($post, $get) {
	
	    $Num = $post['pageNum']!='' ? $post['pageNum'] : 1;
	    if ($post['numPerPage']!='') {
	        setcookie('topolgChildnumPerPage',$post['numPerPage']);
	        $numPer = $post['numPerPage'];
	    }
	    else {
	        $numPer = $_COOKIE['topolgChildnumPerPage']!=0 ?$_COOKIE['topolgChildnumPerPage'] : C('PAGE_LISTROWS');
	    }
	
	    $post['key']=$this->method['list'];
	    $post['data']['topoType']=$this->topoType;
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
	 * 保存拓扑图；
	 * @param int $id
	 */
	function save($post)
	{
	    $post['key']=$this->method['save'];
	    $post['data']['topoType']=$this->topoType;
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    return $array;
	}
	
	/**
	 * 编辑拓扑图；
	 * @param int $id
	 */
	function edit($post)
	{
	    $post['key']=$this->method['update'];
	    $post['data']['topoType']=$this->topoType;
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    return $array;
	}
	
	
	
	/**
	 * 删除拓扑图；
	 * @param int $id
	 */
	function delete($post)
	{
	    $post['key']=$this->method['delbyid'];
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    return $array;
	}
	
	
	/**
	 * 批量删除拓扑图；
	 * @param int $id
	 */
	function batchdelete($post)
	{
	    $post['key']=$this->method['batchdel'];
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    return $array;
	}
	
	/**
	 * 根据ID查询拓扑图信息；
	 * @param int $id
	 */
	function findbyid($post)
	{
	    $post['key']=$this->method['getinfobyid'];
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    return $array;
	}
	
	/**
	 * 获取拓扑图基本信息；
	 * @param  [type] $post [description]
	 * @param  [type] $get  [description]
	 * @return [type]       [description]
	 */
	public function monitor_summary($post)
	{
		$post['key']=$this->method['monitor_summary_lg'];
	    $post = $this->formatPost($post);
	    $preturn = $this->request_by_other($post);
	    $array = json_decode($preturn,true);
	    return $array;
	}

	/**
	 * [monitor_node_summary description]
	 * @param  [type] $post [description]
	 * @return [type]       [description]
	 */
	public function monitor_node_summary($post)
	{
		$post['key']=$this->method['monitor_node_summary'];
	    $post = $this->formatPost($post);
	    $preturn = $this->request_by_other($post);
	    $array = json_decode($preturn,true);
	    return $array;
	}

	public function monitor_node_detail($post)
	{
		$post['key']=$this->method['monitor_node_detail'];
	    $post = $this->formatPost($post);
	    $preturn = $this->request_by_other($post);
	    $array = json_decode($preturn,true);
	    return $array;
	}
	
	public function lg_monitor_node_detail($post)
	{
	    $post['key']=$this->method['lg_monitor_node_detail'];
	    $post = $this->formatPost($post);
	    $preturn = $this->request_by_other($post);
	    $array = json_decode($preturn,true);
	    return $array;
	}
}