<?php
/**
 * 服务管制-仓库中心-仓库模型
 *
 */
class HostqualitymonModel extends CommonModel {
	var $method = array(
		"showHostTree"=>"/hostree/WEB_ENVIRONMENT" ,
		"showHostResource"=>"server.host.gethostresource",
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
	
	
}