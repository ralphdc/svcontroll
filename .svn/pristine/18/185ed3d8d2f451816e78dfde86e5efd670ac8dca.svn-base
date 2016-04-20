<?php
/**
 * 服务管制-仓库中心-仓库模型
 * @author zengguangqiu
 *
 */
class HistoryqueryModel extends CommunicationModel {
	var $method = array(	
		"getMonHistoryTree"=>"monitor.history.leftmenu.load",
		"searchMonHistory"=>"monitor.history.search",
	);

	function postSave($post,$get=null){
		$result = '';
		if($post['form_act']=='searchMonHistory'){
			$post['key'] = $this->method['searchMonHistory'];
			$post = $this->formatPost($post,$get);
			$result =$this->request_by_other( $post);
		}
		return json_decode($result,true);
	}	
	
	/**
	 * 根据POST过来的数据提取查询条件查询树
	 * @param array $post
	 * @return array
	 */
	function defaultTree ($post, $get) {
	
		$post['key']=$this->method['getMonHistoryTree'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		return $result;
	}	
	
	function count ($post, $get) {
		if(empty($this->count)){
			$this->count = 0;
		}
		return $this->count;
	}	
	
	function search ($post, $get) {	
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
		$post['key']=$this->method['searchMonHistory'];
		$post['pageIndex']=intval($Num);
		$post['pageSize']=intval($numPer);	
		$post['page']=array(
				"pageNo"=> $Num,
				"pageSize"=> $numPer,
		);
		$post['data']=array(
			"ip"=>$post['ip'],
			"serviceName"=>$post['serviceName'],
			"elemId"=>$post['elemId'],
			"elemName"=>$post['elemName'],				
			"start"=>$post['start'],
			"end"=>$post['end'],				
		);
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];	
		$this->count = $array['total'];
		
		return $result;
	}

	function countByServ ($post, $get) {
		if(empty($this->count)){
			$this->count = 0;
		}
		return $this->count;
	}
	
	function findByServ ($post, $get) {
	
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
		$post['key']=$this->method['searchMonHistory'];
		$post['pageIndex']=intval($Num);
		$post['pageSize']=intval($numPer);
		$post['page']=array(
				"pageNo"=> $Num,
				"pageSize"=> $numPer,
		);
		$post['data']=array(
				'serviceName'=>$get['serviceName']
		);
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		$this->count = $array['total'];
	
		return $result;
	}	

	function countByServIp ($post, $get) {
		if(empty($this->count)){
			$this->count = 0;
		}
		return $this->count;
	}
	
	function findByServIp ($post, $get) {
	
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
		$post['key']=$this->method['searchMonHistory'];
		$post['pageIndex']=intval($Num);
		$post['pageSize']=intval($numPer);
		$post['page']=array(
				"pageNo"=> $Num,
				"pageSize"=> $numPer,
		);
		$post['data']=array(
				'serviceName'=>$get['serviceName'],
				'ip'=>$get['ip'],
		);
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		$this->count = $array['total'];
	
		return $result;
	}	
}