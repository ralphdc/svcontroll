<?php
use Think\Crypt\Driver\Base64;

/**
 * 服务管制-配置中心-配置控制器
 * @author zengguangqiu
 *
 */
class ConfigureController extends CommonController {
	//var $navTab = 'D60601';
	var $navTab = '2c948cfb51ebb03c0151ebb73feb0011';
	
// 框架首页
	public function index() {
		header("Cache-Control: no-cache, must-revalidate");
		//header("Pragma: no-cache");
		$Configure = new ConfigureModel($_POST,$_GET);
		$resultconfig = $Configure->findByPost($_POST,$_GET);
		$resultexamples = $Configure->findByexamplesPost($_POST,$_GET);
		$this->assign ( 'config_nodes', $resultconfig['config_nodes'] );
		$this->assign ( 'examples_nodes', $resultexamples['examples_nodes'] );		
		$this->display();
	}
	
	
	/**
	 * 根据get过来的type参数展示对应的类型的页面的详细信息
	 * type=a  配置项详情
	 * type=b  配置实例分类详情
	 * type=c  配置实例详情
	 */
	public function detail()
	{
		$Configure = new ConfigureModel($_POST,$_GET);
		$type = $_GET['type'];
		if($type == 'a')
		{
			$result = $Configure->findByItem($_POST,$_GET);
			$tempres = array();
			$aftertempres['content'] = array();
			if(is_array($result['content']) && count($result['content']))
			{
				foreach ($result['content'] as $ckey=>$cval)
				{
					$tempres[$cval['id']] = $cval;
				}
				ksort($tempres);
				foreach ($tempres as $mekey=>$meval)
				{
					$aftertempres['content'][] = $meval;
				}
			}
			$this->assign ( 'result', $aftertempres );
			$this->assign ( 'remark', $result['remark'] );
		}elseif($type == 'b')
		{
			$_POST['id'] = intval($_GET['id']);
			$result = $Configure->getInstanceRelation($_POST,$_GET);
			$this->assign ( 'result', $result );
			
		}elseif($type == 'c')
		{
			$_POST['id'] = $_GET['id'];
			$result = $Configure->getInstanceInfo($_POST,$_GET);
			$this->assign('data', $result);
		}elseif($type == 'd')
		{
			$_POST['id'] = $_GET['id'];
			$result = $Configure->getHistroyInfo($_POST,$_GET);
			$this->assign('data', $result);
		}
		$disTpl = 'detail_'.$type;
		$this->display($disTpl);
	}
	/**
	 * 编辑配置项分类
	 */
	public function edit_a() {
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
			}
		
			//组织要保存的数据
			$propArr  = $request['prop'];
			
			//组织要保存的数据
			$propArr  = $request['prop'];
			$temppropArr = array();
			if(is_array($propArr) && count($propArr))
			{
				foreach ($propArr as $key=>$val)
				{
					$temppropArr[$key] = trim($val);
				}
				$temppropArr = array_unique($temppropArr);
			}
			if(count($propArr) != count($temppropArr))
			{
				$ret = array("statusCode"=>"0","message"=>'属性不能重复',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}
			$tidArr = $request['tid'];
			$tempArr = array();
			$tempStrArr = '';
			if(is_array($propArr) && count($propArr))
			{
				for ($i=0;$i < sizeof($propArr);$i++)
				{
					if(!empty($propArr[$i]))
					{
						$tempArr[$propArr[$i]] = $tidArr[$i];
						$tempStrArr[] = $propArr[$i];
					}
				}
			}
			if(is_array($tempStrArr) && count($tempStrArr))
			{
				$tempStr = implode(',', $tempStrArr);
			}
			if(empty($tempArr))
			{
				$array= array(
						'configItemKindName' => "{$request['propName']}",
				);
			}else
			{
				$array= array(
						'configItemKindName' => "{$request['propName']}",
						'propertyKeys'=>$tempArr,
						'keysorted'=>$tempStr,
				);
			}
			
			$post['data']=$array;
			$post['id']="{$request['id']}";
			$post['form_act']='updateItemKind';
			//调用java接口进行数据的操作
			$Configure = new ConfigureModel($_POST,$_GET);
			$result = $Configure->postSave($post);
			if($result['errorCode'] == "0"){
				$ret = array("statusCode"=>"200","message"=>'操作成功。',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent","id"=>$result['data']['id']);
				echo json_encode($ret);	return;
			}else{
				$msg = $result['errorMessage'];
				$ret = array("statusCode"=>"0","message"=>$msg,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}
		}
		
		$Configure = new ConfigureModel($_POST,$_GET);
		$result = $Configure->findByItemKind($_POST,$_GET);
		asort($result["propertyKeys"]);
		$this->assign ( 'propName', $result["configItemKindName"] );
		$this->assign ( 'result', $result["propertyKeys"]);
				
		$this->display();
	}
	/**
	 * 编辑配置项
	 */
	public function edit_b() {
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
			}
	
			//组织要保存的数据
			$propArr  = $request['prop'];
			$tidArr	= $request['tid']; 
			$tempArr = '';
			if(is_array($propArr) && count($propArr))
			{
				$pattern = "/&/i";
				$replacement = "|1@2|";
				for ($i=0;$i < sizeof($propArr);$i++)
				{
					$tempval = $tidArr[$i];
					$tempvalue = iconv("utf-8","gb2312",$tempval);
					$tempvalue64 =base64_encode($tempvalue);
					$tempArr[$propArr[$i]] =preg_replace($pattern, $replacement, $tempvalue64);
				}
			}
			$post['name']=$request['propName'];
			$post['remark']=$request['remark'];
			$post['data']=$tempArr;
			$post['id']="{$request['id']}";
			$post['form_act']='updateItem';
	
			//调用java接口进行数据的操作
			$Configure = new ConfigureModel($_POST,$_GET);
			$result = $Configure->postSave($post);
			if($result['errorCode'] == "0"){
				$ret = array("statusCode"=>"200","message"=>'操作成功。',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent","id"=>$result['data']['id']);
				echo json_encode($ret);	return;
			}else{
				$msg = $result['errorMessage'];
				$ret = array("statusCode"=>"0","message"=>$msg,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}
		}
	
		$Configure = new ConfigureModel($_POST,$_GET);
		$result = $Configure->findByItem($_POST,$_GET);
		//dump($result['content']);
		$tempres = array();
		$aftertempres = array();
		if(is_array($result['content']) && count($result['content']))
		{
			foreach ($result['content'] as $ckey=>$cval)
			{
				$tempres[$cval['id']] = $cval;
			}
			ksort($tempres);
			foreach ($tempres as $mekey=>$meval)
			{
				$aftertempres[] = $meval;
			}
		}
		$this->assign ( 'propName', $result["name"] );
		$this->assign ( 'remark', $result["remark"] );
		$this->assign ( 'result', $aftertempres );
	
		$this->display();
	}
	/**
	 * 编辑配置实例
	 */
	public function edit_c() {
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
			}
	
			//组织要保存的数据
			$itemArr = $_POST['itemChild'];
			$itemStr = '';
			$tempitemArr = array();
			if(is_array($itemArr) && count($itemArr))
			{
				foreach ($itemArr as $val)
				{
					if($val!= 0)
					{
						$tempitemArr[] = $val;
					}
				}
				if(is_array($tempitemArr) && count($tempitemArr))
					$itemStr = implode(",", $tempitemArr);
			}
			$post['data']['configInstanceName'] = trim($_POST['configInstanceName']);
			$post['data']['configInstanceId'] = intval($_POST['configInstanceId']);
			$content = iconv("utf-8","gb2312",$_POST['content2']);
			$post['customProperty'] =base64_encode($content);
			$post['data']['configItemIds'] = $itemStr;
			$post['data']['description'] = trim($_POST['desc']);
			$post['data']['check'] = trim($_POST['check']);
			$post['form_act'] = 'updateInstance';
	
			//调用java接口进行数据的操作
			$Configure = new ConfigureModel($_POST,$_GET);
			$result = $Configure->postSave($post);
			if($result['errorCode'] == "0"){
				$ret = array("statusCode"=>"200","message"=>'操作成功。',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent","id"=>$result['data']['configInstanceId']);
				echo json_encode($ret);	return;
			}else{
				$msg = $result['errorMessage'];
				$ret = array("statusCode"=>"0","message"=>$msg,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}
		}
		
		
		$Configure = new ConfigureModel($_POST,$_GET);
		$itemList = $Configure->getAllItemKindList($_POST,$_GET);
		$itemListStr = '<option value="0">请选择</option>';
		if(is_array($itemList) && count($itemList))
		{
			foreach ($itemList as $key=>$val)
			{
				$itemListStr .= '<option value="'.$val['id'].'">'.$val['configItemKindName'].'</option>';
			}
		}
		$this->assign('itemListStr',$itemListStr);
		
		//获取配置实例编辑前的相关的数据
		$post['data']['instanceId'] = $_GET['id'];
		$result = $Configure->getEditInstanceinfo($post,$_GET);
		$configItemIdArr = explode(",", $result['configItemIds']);
		$itemMap = $result['itemMap'];
		$addInstanceStr  = '';
		if(is_array($configItemIdArr) && count($configItemIdArr))
		{
			
			foreach ($configItemIdArr as $key =>$val)
			{
				//根据父类ID获取到所有该父类下的子类
				$parentID = $itemMap[$val];
				$tempitemStr = $this->returnItemList($parentID,$val);
				//echo $tempitemStr;
				//获取对应的父节点并展示选中的那个父节点
				$tempitemListStr = '<option value="0">请选择</option>';
				if(is_array($itemList) && count($itemList))
				{
					foreach ($itemList as $keyitem=>$value)
					{
						if($value['id'] == $parentID)
							$selected = 'selected';
						$tempitemListStr .= '<option value="'.$value['id'].'" '.$selected.'>'.$value['configItemKindName'].'</option>';
						$selected = '';
					}
				}
				
				$addInstanceStr.='<div class="config_info_item itemlistnum"><div class="num">'.++$key.'</div><span class="pro">配置项分类：</span> <select style="width:100px;" id="parentid" name="item[]" class="textInput" onchange="showItemChilds(this);">'.$tempitemListStr.'</select> <span class="pro ml30">配置项：</span> <select style="width:100px;" id="childId" name="itemChild[]" class="textInput itemchild" onchange="showItemChildcontent(this);">'.$tempitemStr.'</select> <a href="javascript:;" class="ui_btn_del">删除</a></div>';
			}
		}
		$this->assign('addInstanceStr',$addInstanceStr);
		$this->assign('configInstanceId',$post['data']['instanceId']);
		$this->assign('configInstanceName',$result['configInstanceName']);
		$this->assign('kindId',$result['kindId']);
		$this->assign('customProperty',$result['customProperty']);
		$this->assign('description',$result['description']);
		$this->assign('content',$result['content']);
		$this->assign("instancessid",$_GET['id']);
		
		$this->display();
	}
	/**
	 * 编辑配置实例分类
	 */
	public function edit_d() {
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
			}
			
			$post['data']['kindName']="{$request['kindName']}";
			$post['data']['kindId']=$request['kindId'];
			$post['form_act']='updateInstanceKind';
	
			//调用java接口进行数据的操作
			$Configure = new ConfigureModel($_POST,$_GET);
			$result = $Configure->postSave($post);
			//dump($result);
			if($result['errorCode'] == "0"){
				$ret = array("statusCode"=>"200","message"=>'操作成功。',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}else{
				$msg = $result['errorMessage'];
				$ret = array("statusCode"=>"0","message"=>$msg,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			} 
		}
	
		$Configure = new ConfigureModel($_POST,$_GET);
		$result = $Configure->findByItemKind($_POST,$_GET);
		$this->assign ( 'propName', $result["configItemKindName"] );
		$this->assign ( 'result', $result["propertyKeys"] );
	
		$this->display();
	}
	/**
	 * 新增配置项分类
	 */
	public function add_a() {	
		
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;	
			}

			//组织要保存的数据
			$propArr  = $request['prop'];
			if(is_array($propArr) && count($propArr))
			{
				foreach ($propArr as $key=>$val)
				{
					$temppropArr[$key] = trim($val);
				}
			}
			$temppropArr = array_unique($temppropArr);
			if(count($propArr) != count($temppropArr))
			{
				$ret = array("statusCode"=>"0","message"=>'属性不能重复',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}
			$propArr = $temppropArr;
			
			$tempArr = '';
			$tempStrArr = '';
			if(is_array($propArr) && count($propArr))
			{
				foreach ($propArr as $key=>$val)
				{
					if(!empty($val))
					{
						$tempArr[$val] = '';
						$tempStrArr[]=trim(trim($val),',');
					}
						
				}
			}
			if(is_array($tempStrArr) && count($tempStrArr))
			{
				$tempStr = implode(',', $tempStrArr);
			}
			if(empty($tempArr))
			{
				$array= array(
						'configItemKindName' => "{$request['propName']}"
				);
			}else
			{
				$array= array(
						'configItemKindName' => "{$request['propName']}",
						'propertyKeys'=>$tempArr,
						'keysorted'=>$tempStr,
				);
			}
				
			$post['data']=$array;
			$post['form_act']='addItemKind';
			
			//调用java接口进行数据的操作
			$Configure = new ConfigureModel($_POST,$_GET);
			$result = $Configure->postSave($post);
			if($result['errorCode'] == "0"){
				$ret = array("statusCode"=>"200","message"=>'操作成功。',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent","id"=>$result['data']['id']);
				echo json_encode($ret);	return;
			}else{
				$msg = $result['errorMessage'];
				$ret = array("statusCode"=>"0","message"=>$msg,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}
		}

		$Configure = new ConfigureModel($_POST,$_GET);
		$result = $Configure->findByItemKind($_POST,$_GET);
// 		$this->assign ( 'propName', $result["configItemKindName"] );
		$this->assign ( 'result', $result["propertyKeys"] );
				
		$this->display();		
	}
	/**
	 * 新增配置项
	 */
	public function add_b() {
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;	
			}
			
			//组织要保存的数据;
			$propArr  = $request['prop'];
			$valueArr = $request['value'];
			$tempArr = '';
			if(is_array($propArr) && count($propArr))
			{
				$pattern = "/&/i";
				$replacement = "|1@2|";
				for($i=0; $i<sizeof($propArr);++$i)
				{
					$tempval = $valueArr[$i];
					$tempvalue = iconv("utf-8","gb2312",$tempval);
					$tempvalue64 =base64_encode($tempvalue);
					$tempArr[$propArr[$i]] = preg_replace($pattern, $replacement, $tempvalue64);
				}
			}
			if(empty($tempArr))
			{
				$array= array(
						'configItemName' => "{$request['propName']}",
						'remark' => "{$request['remark']}",
						'configItemKindId'=> "{$request['id']}"
				);
			}else
			{
				$array= array(
						'configItemName' => "{$request['propName']}",
						'remark' => "{$request['remark']}",
						'configItemKindId'=> "{$request['id']}",
						'key_value'=>$tempArr
				);
			}
			$post['data']=$array;
			$post['form_act'] = 'addItem';
			
			//调用java接口进行数据的操作
			$Configure = new ConfigureModel($_POST,$_GET);
			$result = $Configure->postSave($post);
			if($result['errorCode'] == "0"){
				$ret = array("statusCode"=>"200","message"=>'操作成功。',"id"=>$result['data']['id'],
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}else{
				$msg = $result['errorMessage'];
				$ret = array("statusCode"=>"0","message"=>$msg,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}
		}
		
		$Configure = new ConfigureModel($_POST,$_GET);
		$result = $Configure->findByItemKind($_POST,$_GET);
		asort($result["propertyKeys"]);
		$this->assign ( 'propName', $result["configItemKindName"] );
		$this->assign ( 'result', $result["propertyKeys"] );
		
		$this->display();	
	}
	/**
	 * 新增配置实例
	 */
	public function add_c() {
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;	
			}
			
			//组织要保存的数据
			$itemArr = $_POST['itemChild'];
			$itemStr = '';
			$tempitemArr = array();
			if(is_array($itemArr) && count($itemArr))
			{
				foreach ($itemArr as $val)
				{
					if($val!= 0)
					{
						$tempitemArr[] = $val;
					}
				}
				if(is_array($tempitemArr) && count($tempitemArr))
					$itemStr = implode(",", $tempitemArr);
			}
			$postdata['configInstanceName'] = trim($_POST['configInstanceName']);
			$postdata['kindId'] = intval($_POST['kindId']);
			$content = iconv("utf-8","gb2312",$_POST['content2']);
			$post['customProperty'] =base64_encode($content);
			$postdata['configItemIds'] = $itemStr;
			$postdata['description'] = trim($_POST['desc']);
			$postdata['check'] = trim($_POST['check']);
			$post['data'] = $postdata;
			$post['form_act'] = 'addInstance';
			//调用java接口进行数据的操作
			$Configure = new ConfigureModel($_POST,$_GET);
			$result = $Configure->postSave($post);
			if($result['errorCode'] == "0"){
				$ret = array("statusCode"=>"200","message"=>'操作成功。',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent","id"=>$result['data']['configInstanceId']);
				echo json_encode($ret);	return;
			}else{
				$msg = $result['errorMessage'];
				$ret = array("statusCode"=>"0","message"=>$msg,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}
		}
		//获取所有的配置项列表
		$Configure = new ConfigureModel($_POST,$_GET);
		$itemList = $Configure->getAllItemKindList($_POST,$_GET);
		$itemListStr = '<option value="0">请选择</option>';
		if(is_array($itemList) && count($itemList))
		{
			foreach ($itemList as $key=>$val)
			{
				$itemListStr .= '<option value="'.$val['id'].'">'.$val['configItemKindName'].'</option>';
			}
		}
		$this->assign('itemListStr',$itemListStr);
		$this->display();
	}
	/**
	 * 增加配置实例分类
	 */
	public function add_d() {
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
			}
				
			//组织要保存的数据
			$post['kindName'] = trim($_POST['kindName']);
			$post['data'] = array('kindName'=>$post['kindName']);
			$post['form_act'] = 'addInstanceKind';
				
			//调用java接口进行数据的操作
			$Configure = new ConfigureModel($_POST,$_GET);
			$result = $Configure->postSave($post);
			//dump($result);
			if($result['errorCode'] == "0"){
				$ret = array("statusCode"=>"200","message"=>'操作成功。',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent","id"=>$result['data']['kindId']);
				echo json_encode($ret);	return;
			}else{
				$msg = $result['errorMessage'];
				$ret = array("statusCode"=>"0","message"=>$msg,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}
		}
		$this->display();
	}
	/**
	 * 配置实例和配置项的相关的删除操作
	 */
	public function delete(){
		
 		//dump($_POST);
		$Configure = new ConfigureModel($_POST,$_GET);
		$treeid = $_POST['treeid'];
		if($treeid == 'config_tree')
		{
			if($_POST['type'] == 'itemKind'){
				$result=$Configure->deleteByItemKind($_POST['id']);
			}elseif ($_POST['type'] == 'item'){
				$result=$Configure->deleteByItem($_POST['id']);
			}
		}elseif($treeid == 'examples_tree')
		{
			if($_POST['type'] == 'itemKind'){
				$result=$Configure->deleteByInstanceKind($_POST['id']);
			}elseif ($_POST['type'] == 'item'){
				$result=$Configure->deleteByInstance($_POST['id']);
			}
		}
		//dump($result);
		if($result['errorCode'] == "0"){
			$ret = array("statusCode"=>"200","message"=>'操作成功。');
			echo json_encode($ret);	return;
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"0","message"=>$msg);
			echo json_encode($ret);	return;
		}
	}
	
	/**
	 * 根据ID获取对应的具体配置实例的相关详细的信息
	 */
	public function getInstanceInfo()
	{
		$_POST['id'] = intval($_POST['id']);
		$Configure = new ConfigureModel($_POST,$_GET);
		$result = $Configure->getInstanceInfo($_POST,$_GET);
		echo $result;
	}
	
	/**
	 * 获取单个配置项下的所有的配置实例的信息并组合成下拉列表
	 */
	public function getItemList()
	{
		$_POST['data']['configItemKindId'] = intval($_POST['id']);
		$Configure = new ConfigureModel($_POST,$_GET);
		$result = $Configure->getConfigItemInfo($_POST,$_GET);
		$tempStr = '<option value="0">请选择</option>';
		if(is_array($result) && count($result))
		{
			foreach ($result as $key => $val)
			{
				$tempStr .= '<option value="'.$val['id'].'">'.$val['configItemName'].'</option>';
			}
		}
		echo $tempStr;
	}
	
	/**
	 * 获取对应的配置项的信息
	 */
	public function getItemInfo()
	{
		$_POST['ids'] = rtrim($_POST['ids'],',');
		$Configure = new ConfigureModel($_POST,$_GET);
		$result = $Configure->getAllItemContent($_POST,$_GET);
		echo empty($result) ? '':$result;
	}
	
	/**
	 * 复制和粘贴节点动作
	 */
	public function copyInstance()
	{
		$post['data']['fromKindId'] = intval($_POST['fromKindId']);
		$post['data']['fromInstanceId'] = intval($_POST['fromInstanceId']);
		$post['data']['toKindId'] = intval($_POST['toKindId']);
		$Configure = new ConfigureModel($_POST,$_GET);
		$result = $Configure->copyInstance($post,$_GET);
		unset($post);
		if($result['errorCode'] == "0"){
			$ret = array("statusCode"=>"200","message"=>'操作成功。','id'=> $result['data']['configInstanceId']);
			echo json_encode($ret);	
			return;
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"0","message"=>$msg);
			echo json_encode($ret);
			return;
		}
	}
	/**
	 * 查询对应动作的接口
	 */
	public function getSearchInfo()
	{
		$type = intval($_POST['type']);
		$text = trim($_POST['key']);
		$post['data'] = array('type'=>$type,'text'=>$text);
		$Configure = new ConfigureModel($_POST,$_GET);
		$result = $Configure->getSearchInfo($post);
		if($type == 1)
		{
			//显示配置项
			$tmp_result['result']['config_nodes']	= '[{"name":"配置项","open":true,"children": [';
			
			foreach($result as $k1 => $v1 ){
				$tmp_result['result']['config_nodes']	.=
				'{"id":"' . $result[$k1]["id"] . '","name":"' . $result[$k1]["configItemKindName"] . '","open":true,"children":[';
				if($result[$k1]['child']){
					foreach($result[$k1]['child'] as $k2 => $v2 ){
						$tmp_result['result']['config_nodes']	.= '{"id":"' . $result[$k1]['child'][$k2]['id'] . '","name":"' . $result[$k1]['child'][$k2]['configItemName'] . '","url":"/index.php/Service/Configure/detail?type=a&id=' . $result[$k1]['child'][$k2]['id'] . '","target":"ajax"},';
					}
				}
				$tmp_result['result']['config_nodes']	.= ']},';
			}
			
			$tmp_result['result']['config_nodes']	.= ']}]';
			echo  $tmp_result['result']['config_nodes'];
		}else
		{
			$tmp_result['result']['examples_nodes']	= '[{"name":"配置实例","open":true';
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
				$tmp_result['result']['examples_nodes'].='}]';
				
			echo  $tmp_result['result']['examples_nodes'];
			
		}
	}
	
	/**
	 * 根据传递过来的id和所选的值获取对应的后半段的数据
	 * @param int $id
	 * @param int $value
	 * @return string
	 */
	public function returnItemList($id,$value)
	{
		$_POST['data']['configItemKindId'] = $id;
		$Configure = new ConfigureModel($_POST,$_GET);
		$result = $Configure->getConfigItemInfo($_POST,$_GET);
		$tempStr = '<option value="0">请选择</option>';
		if(is_array($result) && count($result))
		{
			foreach ($result as $key => $val)
			{
				if($val['id'] == $value)
					$selected = 'selected';
				$tempStr .= '<option value="'.$val['id'].'" '.$selected.'>'.$val['configItemName'].'</option>';
					$selected='';
			}
		}
		return $tempStr;
	}
	
	function utf8_unicode($name){
		$name = iconv('UTF-8', 'UCS-2', $name);
		$len  = strlen($name);
		$str  = '';
		for ($i = 0; $i < $len - 1; $i = $i + 2){
			$c  = $name[$i];
			$c2 = $name[$i + 1];
			if (ord($c) > 0){   //两个字节的文字
				$str .= '\u'.base_convert(ord($c), 10, 16).str_pad(base_convert(ord($c2), 10, 16), 2, 0, STR_PAD_LEFT);
				//$str .= base_convert(ord($c), 10, 16).str_pad(base_convert(ord($c2), 10, 16), 2, 0, STR_PAD_LEFT);
			} else {
				$str .= '\u'.str_pad(base_convert(ord($c2), 10, 16), 4, 0, STR_PAD_LEFT);
				//$str .= str_pad(base_convert(ord($c2), 10, 16), 4, 0, STR_PAD_LEFT);
			}
		}
		$str = strtoupper($str);//转换为大写
		return $str;
	}
	
	
	function importinfo()
	{
		//获取配置实例编辑前的相关的数据
		$post['data']['instanceId'] = $_GET['id'];
		$Configure = new ConfigureModel($_POST,$_GET);
		$result = $Configure->getEditInstanceinfo($post,$_GET);
		$this->assign('customProperty',$result['customProperty']);
		$this->display();
		
	}
	
	//2015-11-23 韦庆丁对接，设置为最新；
	function setNew()
	{
	   if(IS_AJAX){
	        $id = I("post.id","0","intval");
	        if($id > 0){
	            $Configure = new ConfigureModel();
	            $ajaxData = $Configure->modelSetNew(array('id'=>$id));
	            $array = json_decode($ajaxData,true);
	            if(isset($array['errorCode']) && $array['errorCode'] == 0){
	                echo  json_encode(array('statusCode'=>16888,'message'=>'操作成功！'));
	                exit;
	            }else{
	                echo  json_encode(array('statusCode'=>16889,'message'=>$array['errorMessage']));
	                exit;
	            }
	        }
	    }
	}
	
}