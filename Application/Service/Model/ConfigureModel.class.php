<?php
/**
 * 服务管制-配置中心-配置模型
 * @author zengguangqiu
 *
 */
class ConfigureModel extends CommunicationModel {
	var $method = array(
			'getAll'=>'config.tree',
			'getAllItem'=>'config.item.tree',
			'getAllItemKindList'=>'config.item.kind.list',
			'getAllItemContent'=>'config.instance.dynamiccontent.getbatch',
			'getItemList'=>'config.item.list',
			'getAllInstance'=>'config.instance.tree',

			'getItemKind'=>'config.property.templet.list',
			'getItem'=>'config.item.get',
			'getInstanceKind'=>'',
			'getEditInstanceinfo'=>'config.instance.load',
			'getInstance'=>'config.instance.get',
			'getInstancerelation'=>'config.instance.relation.get',
			'getHistroy' =>'config.instance.history.get',
			
			'addItemKind'=>'config.item.kind.create',
			'addItem'=>'config.item.create',
			'addInstanceKind'=>'config.instance.kind.create',
			'addInstance'=>'config.instance.create',

			'updateItemKind'=>'config.item.kind.update',
			'updateItem'=>'config.item.update',
			'updateInstanceKind'=>'config.instance.kind.update',
			'updateInstance'=>'config.instance.update',
			
			'deleteItemKind'=>'config.item.kind.delete',
			'deleteItem'=>'config.item.delete',
			'deleteInstanceKind'=>'config.instance.kind.delete',
			'deleteInstance'=>'config.instance.delete',

			'copyInstance' =>'config.instance.copy',
			'search' =>'config.search',
	    
	         //2015-11-24 设置为最新 韦庆丁对接；
	         'setNew'=>'config.instance.current.update'
	);

	
	/**
	 * 根据POST过来的数据提取查询条件查询记录
	 * @param array $post
	 * @return array
	 */
	function findByPost ($post, $get) {

		$post['key']=$this->method['getAllItem'];
		$post['data']="";
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);		
		$array = json_decode($array,true);
		$result = $array['data'];
		
		//显示配置项
		$tmp_result['result']['config_nodes']	= '{"name":"配置项","t":"配置项","open":true,"children": [';
		
		foreach($result as $k1 => $v1 ){
			$tmp_result['result']['config_nodes']	.= 
				'{"id":"' . $result[$k1]["id"] . '","t":"' . $result[$k1]["configItemKindName"] . '","name":"' . $result[$k1]["configItemKindName"] . '","open":true,"children":[';
			if($result[$k1]['child']){				
				foreach($result[$k1]['child'] as $k2 => $v2 ){
					$tmp_result['result']['config_nodes']	.= '{"id":"' . $result[$k1]['child'][$k2]['id'] . '","t":"' . $result[$k1]['child'][$k2]['remark'] . '","name":"' . $result[$k1]['child'][$k2]['configItemName'] . '","url":"/index.php/Service/Configure/detail?type=a&id=' . $result[$k1]['child'][$k2]['id'] . '","target":"ajax"},';					
				}
			}
			$tmp_result['result']['config_nodes']	.= ']},';
		}
		
		$tmp_result['result']['config_nodes']	.= ']}';

		//显示配置实例
// 		$result['result']['examples_nodes']	='{"name":"组合实例","open":true,"children":[
// 			{"name":"as_pos","open":true,"url":"/index.php/Service/Configure/detail_b","target":"ajax","children":[
// 				{"name":"A","url":"/index.php/Service/Configure/detail_c","target":"ajax"}
// 			]},
// 			]
// 		}';

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
		$tmp_result['result']['examples_nodes']	= '{"name":"配置实例","t":"配置实例","open":true';
		if(is_array($result) && count($result))
		{
			$tmp_result['result']['examples_nodes']	.=',"children": [';
			foreach($result as $k1 => $v1 ){
				$tmp_result['result']['examples_nodes']	.=
				'{"id":"' . $result[$k1]["id"] . '","t":"' . $result[$k1]["kindName"] . '","name":"' . $result[$k1]["kindName"] . '","url":"/index.php/Service/Configure/detail?type=b&id='.$result[$k1]["id"].'","target":"ajax","open":true,"children":[';
				if($result[$k1]['child']){
					foreach($result[$k1]['child'] as $k2 => $v2 ){
						$tmp_result['result']['examples_nodes']	.= '{"baseId":"'.$result[$k1]['child'][$k2]['baseId'].'","id":"' . $result[$k1]['child'][$k2]['id'] . '","t":"' . $result[$k1]['child'][$k2]['configInstanceName'] . '","name":"' . $result[$k1]['child'][$k2]['configInstanceName'] . '","url":"/index.php/Service/Configure/detail?type=c&id=' . $result[$k1]['child'][$k2]['id'] . '","target":"ajax"},';
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
			"id"=>$get['id']=='undefined' ? '' : $get['id'],
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
		
		$post['id']=$get['id']=='undefined' ? '' : $get['id'];
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
	
	/**
	 * 根据POST过来的数据提取对应的所有历史版本的列表数据
	 * @param array $post
	 * @return array $get
	 */
	function getHistroyInfo ($post, $get) {
	
		$post['key']=$this->method['getHistroy'];
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
	
		$post['id']=$get['id']=='undefined' ? '' : $get['id'];
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
	
	function modelSetNew($post, $get)
	{
	    $post['key']=$this->method['setNew'];
	    $post = $this->formatPost($post);
	   
		$array = $this->request_by_other($post);
		return $array;
	}
}