<?php
/**
 * 服务管制-部署脚本
 * @author zengguangqiu
 *
 */
class DeploymentModel extends CommunicationModel {
	var $method = array(
			"index"=>"repertory.shellscript.search",
			"findShellscript"=>"repertory.shellscript.get",
			"createShellscript"=>"repertory.shellscript.create",
			"updateShellscript"=>"repertory.shellscript.update",
			"deleteShellscript"=>"repertory.shellscript.delete",
			"searchShellscript"=>"repertory.shellscript.search"
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
		$post['pageIndex']=intval($Num);
		$post['pageSize']=intval($numPer);
		$post['page']=array(
				"pageNo"=> $Num,
				"pageSize"=> $numPer,
		);
		//dump($post);
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		$this->count = $array['total'];
		return $result;
	}	
	
	function deleteById($id)
	{
		$post['key']=$this->method['deleteShellscript'];
		$post['id'] = $id;
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}
	
	function findById($id)
	{
		$post['key']=$this->method['findShellscript'];
		$post['id'] = $id;
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
// 		dump($array);
		return $array;
	}	
}