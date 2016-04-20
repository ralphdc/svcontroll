<?php
/**
 * 服务管制-仓库中心-仓库模型
 * @author zengguangqiu
 *
 */
class BatchprocessModel extends CommunicationModel {
	var $method = array(
		
		"updateTreedata"=>"batch.batchdesploy.update",
		//"getTreedata"=>"repertory.metadata.tree",
		"getTreedata"=>"batch.batchdesploy.tree",
		"getMetadata"=>"batch.batchdesploy.meta.search",
		"createMetadata"=>"repertory.metadata.create",
		"deleteMetadata"=>"batch.batchdesploy.meta.delete",
		"getMetadataById"=>"batch.batchdesploy.meta.search",
		"getMetadataByTime"=>"batch.batchdesploy.meta.search",
		"getdefaultdesploy"=>"batch.batchdesploy.planmsg.search",
		"getMetadataByProduct"=>"batch.batchdesploy.meta.search",	
		"getIpProductTree"=>"dispatch.ipproduct.tree",
		"getInstanceDetail"=>"config.instance.get",
		"getRepConfigTree"=>"config.instance.tree",
		"createPlans"=>"plans.create",
		"createTask"=>"batch.batchdesploy.create",
		"deleteTask"=>"batch.batchdesploy.delete",
		"gobatchprocess"=>"batch.batchdesploy.desploy",
		"createconfig" =>"batch.batchdesploy.arrange",
		"createElementDB" =>'batch.batchdesploy.add.create',
			
			
			
	);

	/**
	 * 根据POST过来的数据提取查询条件查询树
	 * @param array $post
	 * @return array
	 */
	function defaultTree ($post, $get) {
	
		$post['key']=$this->method['getTreedata'];
		$post['data']['taskstate'] = $post['taskstatetree'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		return $result;
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
			"flag" =>$post['flag'],
			"ptaskid" =>$post['ptaskid'],
			"taskstate" =>$post['taskstate'],
			/* 
			"serviceversion"=>$post['serviceversion'],
			"md5"=>$post['md5'],
			"deploymentFlag"=>$post['deploymentFlag'],				
			"productname"=>$post['productname'],
			"deploymentFlag" =>	$post['deploymentFlag'], 
			*/
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
		
		$post['data']['mwid']=$get['id'];
		$post['data']['ptaskid']=$get['ptaskid'];
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
				"taskstate"=>$get['taskstate'],
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
		$post['data']['ptaskid']=$post['id'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		$this->count = $array['total'];
	
		return $result;
	}
	
	function deleteById ($taskid,$mwid) {
		$post['key']=$this->method['deleteMetadata'];
		$post['data']['ptaskid'] = $taskid;
		$post['data']['mwid'] = $mwid;
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;	
	}

	function deleteByTaskId ($id) {
		$post['key']=$this->method['deleteTask'];
		$post['id'] = $id;
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}

	function update ($_post,$_get) {
		$post['key']=$this->method['updateTreedata'];
		$post['id'] = $_post['taskId'];
		$post['data'] = array(
			"taskname"=>$_post['taskname'],
			"submitpeople"=>$_SESSION['cUserNo']
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
	 * @param int $ptaskid
	 */
	function getdefaultdesploy($id,$ptaskid)
	{
		$post['data']['mwid'] = $id;
		$post['data']['ptaskid'] = $ptaskid;
		$post['key']=$this->method['getdefaultdesploy'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		$result = $array['data'];
		return $result;
	}

	function createtask($idstr)
	{
		$post['data']['taskname'] = '';
		$post['data']['meataid'] = $idstr;
		$post['data']['submitpeople'] = $_SESSION['cUserNo'];
		$post['key']=$this->method['createTask'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}
	
	//添加元数据
	function createElementDB($ptaskid,$idstr)
	{
		$post['data']['ptaskid'] = $ptaskid;
		$post['data']['meataid'] = $idstr;
		$post['data']['submitpeople'] = $_SESSION[C('USER_AUTH_KEY')];
		$post['key']=$this->method['createElementDB'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}
	
	function gobatchprocess($post,$get)
	{
		$post['data']['mwid'] = $post['mwid'];
		$post['data']['ptaskid'] = $get['ptaskid'];
		$post['data']['person'] = $_SESSION['cUserNo'];
		$post['key']=$this->method['gobatchprocess'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}
}