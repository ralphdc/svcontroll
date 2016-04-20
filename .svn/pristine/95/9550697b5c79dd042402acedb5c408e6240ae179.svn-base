<?php
/**
 * 服务管制-配置中心-配置模型
 * @author zengguangqiu
 *
 */
class SermonitorModel extends CommunicationModel {
	var $method = array(
			'getAll'=>'monitor.service.tree',
			'serviceinfo'=>'monitor.servicename.get',
			'getpnid'=>'plansid.get'
	);

	
	/**
	 * 根据POST过来的数据提取查询条件查询记录
	 * @param array $post
	 * @return array
	 */
	function findByPost ($post, $get) {

		$post['key']=$this->method['getAll'];
		$post['data']['serviceName']=$post['serviceName'];
		$post['data']['ip']=$post['ip'];
		$post['data']['istool']=$post['istool'];
		$post['data']['environment']= trim($_SESSION['WEB_ENVIRONMENT']);
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);		
		$array = json_decode($array,true);
		$result = $array['data'];
		//显示配置项
		$tmp_result['result']['config_nodes']	= '{"name":"服务","rel":"D9000","url":"/index.php/Service/Servolumeswitch","target":"navTab","open":true';
		if(is_array($result) && count($result))
		{
			$tmp_result['result']['config_nodes']	.=',"children": [';
			foreach($result as $k1 => $v1 ){
				$tmp_result['result']['config_nodes']	.= '{"name":"' . $v1["productName"] . '","open":true';
				if(is_array($v1['child']) && count($v1['child'])){
					$tmp_result['result']['config_nodes']	.=',"children": [';
					foreach($v1['child'] as $k2 => $v2 ){
						$tmp_result['result']['config_nodes']	.= '{"name":"' . $v2['serviceName'] . '","url":"/index.php/Service/Sermonitor/detail?type=a&name=' . $v2['serviceName'] . '","target":"ajax","open":true';
						if(is_array($v2['child']) && count($v2['child'])){
							$tmp_result['result']['config_nodes']	.=',"children": [';
							foreach($v2['child'] as $k3 => $v3 ){
								$tmp_result['result']['config_nodes']	.= '{"name":"' . $v3['ip'] . '","url":"/index.php/Service/Sermonitor/detail?type=b&name=' . $v2['serviceName'].'&ip='.$v3['ip'].'&serviceid='.$v2['serviceid'] . '","target":"ajax"},';
							}
							$tmp_result['result']['config_nodes']	.= ']';
						}

						$tmp_result['result']['config_nodes']	.= '},';
					}
					$tmp_result['result']['config_nodes']	.= ']';
				}
				$tmp_result['result']['config_nodes']	.= '},';
			}
			$tmp_result['result']['config_nodes']	.= ']';
		}
		$tmp_result['result']['config_nodes']	.= '}';

		//显示配置实例
/*  		$result['result']['examples_nodes']	='{"name":"服务","open":true,"children":[
		{"name":"Mpay","open":true,"children":[
			{"name":"nac_sz_cup","open":true,"url":"/index.php/Service/Sermonitor/detail_a","target":"ajax","path":"\Application\Service\Controller","children":[
				{"name":"172.17.0.2","url":"/index.php/Service/Sermonitor/detail_b","target":"ajax"},
				{"name":"172.17.0.2","url":"/index.php/Service/Sermonitor/detail_b","target":"ajax"}
			]},
			{"name":"nac_jl_cup","open":true,"url":"/index.php/Service/Sermonitor/detail_a","target":"ajax",}
		]},
		{"name":"monitor","open":true,"children":[
			{"name":"monitor_main","url":"/index.php/Service/Sermonitor/detail_a","target":"ajax",},
			{"name":"monitor_agent","url":"/index.php/Service/Sermonitor/detail_a","target":"ajax",}
		]}
	]}'; */

		return $tmp_result['result'];
	}
	
	/**
	 * 根据POST过来的数据提取查询条件查询记录
	 * @param array $post
	 * @return array
	 */
	function findByexamplesPost ($post, $get) {
	
		$post['key']=$this->method['getAllInstance'];
		$post['data']="";
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		//dump($result);
	
		//显示配置项
		$tmp_result['result']['examples_nodes']	= '{"name":"配置实例","open":true';
		if(is_array($result) && count($result))
		{
			$tmp_result['result']['examples_nodes']	.=',"children": [';
			foreach($result as $k1 => $v1 ){
				$tmp_result['result']['examples_nodes']	.=
				'{"id":"' . $result[$k1]["id"] . '","name":"' . $result[$k1]["kindName"] . '","url":"/index.php/Service/Configure/detail?type=b&id='.$result[$k1]["id"].'","target":"ajax","open":true,"children":[';
				if($result[$k1]['child']){
					foreach($result[$k1]['child'] as $k2 => $v2 ){
						$tmp_result['result']['examples_nodes']	.= '{"id":"' . $result[$k1]['child'][$k2]['id'] . '","name":"' . $result[$k1]['child'][$k2]['configInstanceName'] . '","url":"/index.php/Service/Configure/detail?type=c&id=' . $result[$k1]['child'][$k2]['id'] . '","target":"ajax"},';
					}
				}
				$tmp_result['result']['examples_nodes']	.= ']},';
			}
			$tmp_result['result']['examples_nodes']	.= ']';
		}
			$tmp_result['result']['examples_nodes'].='}';
			
			
		/* {"name":"组合实例","open":true,"children":[
			{"name":"as_pos","open":true,"url":"/index.php/Service/Configure/detail_b","target":"ajax","children":[
				{"name":"A","url":"/index.php/Service/Configure/detail_c","target":"ajax"}
			]},
			{"name":"monitor","open":true,"url":"/index.php/Service/Configure/detail_b","target":"ajax","children":[
				{"name":"redis2-1","url":"/index.php/Service/Configure/detail_c","target":"ajax"},
				{"name":"redis2-2","url":"/index.php/Service/Configure/detail_c","target":"ajax"},
				{"name":"redis2-3","url":"/index.php/Service/Configure/detail_c","target":"ajax"}
			]},
			{"name":"nac_sz_cup","open":true,"url":"/index.php/Service/Configure/detail_b","target":"ajax","children":[
				{"name":"memcache3-1","url":"/index.php/Service/Configure/detail_c","target":"ajax"},
				{"name":"memcache3-2","url":"/index.php/Service/Configure/detail_c","target":"ajax"}
			]}
			]
		} */
			
		return $tmp_result['result'];
	}
	

	/**
	 * 根据POST过来的数据提取配置项分类数据
	 * @param array $post
	 * @return array
	 */
	function findByItemKind ($post, $get) {
	
		$post['data']=array(
			"id"=>$get['id']
		);
		$post['key']=$this->method['getItemKind'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
	
		return $result;
	}	
	
	/**
	 * 根据POST过来的数据提取配置项数据
	 * @param array $post
	 * @return array
	 */
	function findByItem ($post, $get) {
		
		$post['id']=$get['id'];
		$post['key']=$this->method['getItem'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];	
	
		return $result;
	}
	
	/**
	 * 根据POST过来的数据提取对应的所有配置项的列表数据
	 * @param array $post
	 * @return array $get
	 */
	function getInstanceInfo ($post, $get) {
	
		$post['key']=$this->method['getInstance'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		return $result;
	}
	
	function getEditInstanceinfo($post, $get) {
	
		$post['key']=$this->method['getEditInstanceinfo'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		return $result;
	}
	
	/**
	 * 根据POST过来的数据提取对应的单个配置项下所有的配置实例的数据
	 * @param array $post
	 * @return array $get
	 */
	function getConfigItemInfo ($post, $get) {
	
		$post['key']=$this->method['getItemList'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		return $result;
	}
	
	/**
	 * 根据POST过来的数据提取对应的配置实例数据
	 * @param array $post
	 * @return array $get
	 */
	function getInstanceRelation ($post, $get) {
	
		$post['id']=$get['id'];
		$post['key']=$this->method['getInstancerelation'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		//dump($array);
		$result = $array['data'];
		return $result;
	}
	
	/**
	 * 根据POST过来的数据提取对应的单个配置实例数据
	 * @param array $post
	 * @return array $get
	 */
	function getAllItemKindList($post, $get) {
	
		$post['key']=$this->method['getAllItemKindList'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		return $result;
	}
	
	function getAllItemContent($post, $get)
	{
		$post['key']=$this->method['getAllItemContent'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		echo $result;
	}
	

	
	/**
	 * 删除单个的接口
	 * @param string $idname
	 */
	function deleteByItemKind($idname)
	{
		$post['key']=$this->method['deleteItemKind'];
		$post['id'] = $idname;
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}

	/**
	 * 删除单个的接口
	 * @param string $idname
	 */
	function deleteByItem($idname)
	{
		$post['key']=$this->method['deleteItem'];
		$post['id'] = $idname;
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}

	/**
	 * 删除单个的接口
	 * @param string $idname
	 */
	function deleteByInstanceKind($idname)
	{
		$post['key']=$this->method['deleteInstanceKind'];
		$post['id'] = $idname;
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}	

	/**
	 * 删除单个的接口
	 * @param string $idname
	 */
	function deleteByInstance($idname)
	{
		$post['key']=$this->method['deleteInstance'];
		$post['data']['configInstanceId'] = $idname;
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}
	/**
	 * 复制粘贴节点对应的后端接口
	 * @param array $post
	 * @param array $get
	 */
	function copyInstance($post, $get)
	{
		$post['key']=$this->method['copyInstance'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}
	
	function getSearchInfo($post, $get)
	{
		$post['key']=$this->method['search'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['data'];
	}
	
	function getServiceInfo($post, $get)
	{
		$post['key']=$this->method['serviceinfo'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['data'];
	}
	
	function getpnid($params)
	{
		$post['key']=$this->method['getpnid'];
		$post['data'] = $params;
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['data'];
	}
}