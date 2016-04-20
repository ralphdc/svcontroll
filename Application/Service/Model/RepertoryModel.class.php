<?php
/**
 * 服务管制-仓库中心-仓库模型
 * @author zengguangqiu
 *
 */
class RepertoryModel extends CommunicationModel {
	var $method = array(
		
		"updateTreedata"=>"repertory.desploypath.update",
		"getTreedata"=>"repertory.metadata.tree",
		"getMetadata"=>"repertory.metadata.search",
		"createMetadata"=>"repertory.metadata.create",
		"deleteMetadata"=>"repertory.metadata.delete",
		"getMetadataById"=>"repertory.metadatasvr.search",
		"getMetadataByTime"=>"repertory.metadatatime.search",
		"getdefaultdesploy"=>"repertory.defaultdesploy.get",
		"getMetadataByProduct"=>"repertory.metadataproduct.search",	
		"getIpProductTree"=>"dispatch.ipproduct.tree",
		"getInstanceDetail"=>"config.instance.get",
		"getRepConfigTree"=>"config.instance.tree",
		"createPlans"=>"plans.create",
		"createconfig"=>"batch.batchdesploy.arrange",
		'updateFilterPluge'=>'repertory.modules.update',
		'getFilterPlugeData'=>'repertory.modules.search',	
		'getCoverResourceData'=>'repertory.javaremodules.search',
		'updateCoverResource'=>'repertory.javaremodules.update',	
		'getColumsData'=>'repertory.menusetting.search',
		'updateColums'=>'repertory.menusetting.update',
		'getCoverInitData'=>'repertory.javaremodules.search',
		'updateCoverInit'=>'repertory.javaremodules.update',
		'updateprovisible'=>'repertory.provisible.update',
	);

	/**
	 * 根据POST过来的数据提取查询条件查询树
	 * @param array $post
	 * @return array
	 */
	function defaultTree ($post, $get) {
	
		$post['key']=$this->method['getTreedata'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		return $result;
	}	
	
	/**
	 * 根据POST过来的数据提取查询条件查询列表
	 * @param array $post
	 * @return array
	 */
	function defaultList ($post, $get) {

	}	

	function countByReqs ($post, $get) {
		if(empty($this->count)){
			$this->count = 0;
		}
		return $this->count;
	}	
	
	function findByReqs ($post, $get) {	
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
		$post['key']=$this->method['getMetadata'];
		$post['pageIndex']=intval($Num);
		$post['pageSize']=intval($numPer);	
		$post['page']=array(
				"pageNo"=> $Num,
				"pageSize"=> $numPer,
		);
		$post['data']=array(
			"servicename"=>$post['servicename'],
			"serviceversion"=>$post['serviceversion'],
			"md5"=>$post['md5'],
			"deploymentFlag"=>$post['deploymentFlag'],				
			"productname"=>$post['productname'],
			"deploymentFlag" =>	$post['deploymentFlag'],
			"desployenv" =>	$post['desployenv'],
		);
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];	
		$this->count = $array['total'];
		
		return $result;
	}

	function countById ($post, $get) {
		if(empty($this->count)){
			$this->count = 0;
		}
		return $this->count;
	}
	
	function findById ($post, $get) {
		
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
		$post['key']=$this->method['getMetadataById'];
		$post['pageIndex']=intval($Num);
		$post['pageSize']=intval($numPer);	
		$post['page']=array(
				"pageNo"=> $Num,
				"pageSize"=> $numPer,
		);
		$post['id']=$get['id'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		$this->count = $array['total'];
	
		return $result;
	}	
	
	function findByNo ($post, $get) {
	
		$post['No']=$get['No'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
	
		return $result;
	}	
	
	function countByTime ($post, $get) {
		if(empty($this->count)){
			$this->count = 0;
		}
		return $this->count;
	}
	
	function findByTime ($post, $get) {
		
	
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
		$post['key']=$this->method['getMetadataByTime'];
		$post['pageIndex']=intval($Num);
		$post['pageSize']=intval($numPer);	
		$post['page']=array(
				"pageNo"=> $Num,
				"pageSize"=> $numPer,
		);
		$post['data']=array(
				"id"=>$get['id'],
				"time"=>$get['time'],
				"deploymentFlag"=>$get['deploymentFlag'],
				"desployenv"=>$get['desployenv'],
		);
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		$this->count = $array['total'];
	
		return $result;
	}
	
	function countByProduct ($post, $get) {
		if(empty($this->count)){
			$this->count = 0;
		}
		return $this->count;
	}
	
	function findByProduct ($post, $get) {
	
	
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
		$post['key']=$this->method['getMetadataByProduct'];
		$post['pageIndex']=intval($Num);
		$post['pageSize']=intval($numPer);
		$post['page']=array(
				"pageNo"=> $Num,
				"pageSize"=> $numPer,
		);
		$post['id']=$get['id'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		$this->count = $array['total'];
	
		return $result;
	}
	
	function deleteById ($id) {
		$post['key']=$this->method['deleteMetadata'];
		$post['id'] = $id;
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;	
	}	
	
	function showiinproduct($id) {
		$post['key']=$this->method['updateprovisible'];
		$post['data']['mwId'] = $id;
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;	
	}	
	
	function update ($_post,$_get) {
		$post['key']=$this->method['updateTreedata'];
		$post['id'] = $_post['mwId'];
		$post['data'] = array(
			"path"=>$_post['path'],
			"cfgid"=>$_post['cfgid'],
		);
		
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}
	
	function importByLink ($svnurl){
		$post['key']=$this->method['createMetadata'];
		$post['data'] = array(
				"svnurl"=>$svnurl,
				"loginname"=>$_SESSION['cUserNo']
			);
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;		
	}
	
	/**
	 * 根据POST过来的数据提取查询条件查询树
	 * @param array $post
	 * @return array
	 */
	function ipProductTree ($post, $get) {
	
		$post['key']=$this->method['getIpProductTree'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		return $result;
	}
	
	/**
	 * 根据POST过来的数据提取查询条件查询树
	 * @param array $post
	 * @return array
	 */
	function ipProductTreeByReqs ($post, $get) {
	
		$post['key']=$this->method['getIpProductTree'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		return $result;
	}	
	

	/**
	 * 根据POST过来的数据提取查询条件查询树
	 * @param array $post
	 * @return array
	 */
	function getInstanceDetail ($post, $get) {
		$post['key']=$this->method['getInstanceDetail'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		return $result;
	}	
	
	/**
	 * 根据POST过来的数据提取查询条件查询树
	 * @param array $post
	 * @return array
	 */
	function repConfigTree ($post, $get) {
	
		$post['key']=$this->method['getRepConfigTree'];
		$post['data']="";
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		//dump($result);
	
		//显示配置项
		$tmp_result['result']	= '{"name":"配置实例","open":true';
		if(is_array($result) && count($result))
		{
			$tmp_result['result']	.=',"children": [';
			foreach($result as $k1 => $v1 ){
				$tmp_result['result']	.=
				'{"id":"' . $result[$k1]["id"] . '","name":"' . $result[$k1]["kindName"] . '","open":true,"children":[';
				if($result[$k1]['child']){
					foreach($result[$k1]['child'] as $k2 => $v2 ){
						$tmp_result['result']	.= '{"id":"' . $result[$k1]['child'][$k2]['id'] . '","name":"' . $result[$k1]['child'][$k2]['configInstanceName'] . '","url":"/index.php/Service/Repertory/config_detail?id=' . $result[$k1]['child'][$k2]['id'] . '","target":"ajax"},';
					}
				}
				$tmp_result['result']	.= ']},';
			}
			$tmp_result['result']	.= ']';
		}
			$tmp_result['result'].='}';
			
		return $tmp_result['result'];
	}
	/**
	 * 根据元素ID获取对应的服务的默认配置
	 * @param int $id
	 */
	function getdefaultdesploy($id)
	{
		$post['id'] = $id;
		$post['key']=$this->method['getdefaultdesploy'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		$result = $array['data'];
		return $result;
	}	
	
	//保存文件过滤或一致
	function updateFilterPluge($post){
		$data['key']=$this->method['updateFilterPluge'];
		$data['data'] = $post;//$this->formatPost($post);
		$data = $this->formatPost($data);
		$array = $this->request_by_other($data);
		$result = json_decode($array,true);
		return $result;
		
	}
	
	//获取文件过滤或一致的列表
	function getFilterPlugeData($post){
		$data['key']=$this->method['getFilterPlugeData'];
		$data['data'] = $post;//$this->formatPost($post);
		$data = $this->formatPost($data);
		$array = $this->request_by_other($data);
		$result = json_decode($array,true);
		return $result;
	}
	
	//获取文件过滤或一致的列表
	function getCoverReaourceData($post){
		$data['key']=$this->method['getCoverResourceData'];
		$post['type'] = 'resources';
		$data['data'] = $post;//$this->formatPost($post);
		$data = $this->formatPost($data);
		$array = $this->request_by_other($data);
		$result = json_decode($array,true);
		return $result;
	}
	
	//保存文件过滤或一致
	function updateCoverReaource($post){
		$data['key']=$this->method['updateCoverResource'];
		$data['data'] = $post;//$this->formatPost($post);
		$data = $this->formatPost($data);
		$array = $this->request_by_other($data);
		$result = json_decode($array,true);
		return $result;
	
	}
	
	//获取是够过滤init.sh下发
	function getCoverInitData($post){
		$data['key']=$this->method['getCoverInitData'];
		$post['type'] = 'init.sh';
		$data['data'] = $post;//$this->formatPost($post);
		$data = $this->formatPost($data);
		$array = $this->request_by_other($data);
		$result = json_decode($array,true);
		return $result;
	}
	
	//保存过滤init.sh下发
	function updateCoverInit($post){
		$data['key']=$this->method['updateCoverInit'];
		$data['data'] = $post;//$this->formatPost($post);
		$data = $this->formatPost($data);
		$array = $this->request_by_other($data);
		$result = json_decode($array,true);
		return $result;
	}
	
	// 保存对应的字段的信息到数据库
	function updatecolum($post,$get)
	{
		$data['key']=$this->method['updateColums'];
		$data['data'] = $post;
		$data = $this->formatPost($data);
		$array = $this->request_by_other($data);
		$result = json_decode($array,true);
		return $result;
	}
	
	/**
	 * 根据POST过来的数据提取查询条件查询树
	 * @param array $post
	 * @return array
	 */
	function getShowColums($post, $get) {
		$post['key']=$this->method['getColumsData'];
		$post['data']['loginname']= $_SESSION['cUserNo'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data']['menuSetting'];
		return $result;
	}
	
}