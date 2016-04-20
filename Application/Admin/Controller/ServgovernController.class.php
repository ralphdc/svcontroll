<?php
class ServgovernController extends CommonController {
	var $pageSize = "17";
	var $pageNumShown = "5";
	
	public function index(){
		/*$vo = array( array('id'=>1,'name'=>"root",'open'=>true,'children'=>array(
				array('id'=>'100','rel'=>'aaaa','name'=>"No right-click menu 1",'open'=>true,
						'children'=>array(
								array('id'=>'123','rel'=>'aa','name2'=>'qwer', 'name'=>"Leaf Node 1-1",'open'=>true,
										'children'=>array(array("id"=>111,'click'=>'alert(123);', 'open'=>true,'name'=>"三级菜单",'children'=>array(array("id"=>1111,'open'=>true,'name'=>"四级菜单",) ) ))),
								array('id'=>'12','name'=>"Leaf Node 1-2"))),
				array('id'=>2,'name'=>"No right-click menu 2",'open'=>true,
						'children'=>array(
								array('id'=>21,'name'=>"Leaf Node 2-1",'open'=>true,),
								array('id'=>22,'name'=>"Leaf Node 2-2")
						)
						)))
						);//'children'=>array('id'=>111,'name'=>"Leaf Node 1-1-1")
		//$vo = json_encode($vo,true);
		$tree = $vo;
		Think\Log::write('/////////////////////// tree is '.$vo);
		*/
		
		$model = CM("Servgovern");
		
		$data = $model->getDataBase('gettree');
		$tree = array();
		$treelist = $data['data'];
		//print_r($treelist);
		foreach($treelist as $k => $arr){
			foreach($arr as $j=>$val){//二级
				if($j == "groupName"){
					$tree[$k]['name'] = $val;
				}else{
					$tree[$k][$j] = $val;
					$childrenNode = $arr['children'];
					if(!empty($childrenNode)){
						$tree[$k]['open']= true;
						foreach($childrenNode as $p =>$arrp){//三级
							foreach($arrp as $pp =>$varp){
								if($pp == "typeName"){
									$tree[$k]['children'][$p]['name'] = $varp;
								}else{
									
									$childrenNode2 = $arrp['children'];
									if(!empty($childrenNode2)){
										$tree[$k]['children'][$p]['open']= true;
										foreach($childrenNode2 as $q =>$arrq){//四级
											foreach($arrq as $qq =>$varq){
													$tree[$k]['children'][$p]['children'][$q]['click']= "showPLservice(".$arrq['id']." ,'".$arrq['appId']."')";
													
												if($qq == "machineName"){
													$tree[$k]['children'][$p]['children'][$q]['name'] = $varq ."_". $arrq['appId'] ;
												}else{
													
												
													$childrenNode3 = $arrq['children'];
													if(!empty($childrenNode3)){
														$tree[$k]['children'][$p]['children'][$q]['open']= false;
														foreach($childrenNode3 as $m =>$arrm){//四级
															foreach($arrm as $mm =>$varm){
																    $bizType = $arrm["bizType"];
																   
																	$tree[$k]['children'][$p]['children'][$q]['children'][$m]['click']= 'showSubscribeRef('. $arrm["id"] .',\''. $bizType .'\',\' '.$arrm["appId"].'\')';//"showSubscribeRef2(".$arrm['id'].",".$arrm['bizType'].")";
																if($mm == "bizType"){
																	$tree[$k]['children'][$p]['children'][$q]['children'][$m]['name'] = $varm;
																}
															}}}
													
												}
									
									
									
											}
										}
									}
									
					}
					}}}}}}

		$tree = array('id'=>1,'name'=>"root",'open'=>true,'children'=>$tree);
		
		$tree = json_encode($tree);
		
		$this->assign("menu",$tree);
		$this->display();
	}
	
	//function addServerType(){
	//	$this->display();
	//}
	
	function addInstance(){
		$model = CM("Servgovern");
		$appId = $model->getTradeData();
		$len = strlen($appId);
		$lenmore = 5-$len;
		for($i = 0; $i<$lenmore; $i++){
			$appIdHead .= "0"; 
		}
		$appId = $appIdHead . $appId;
		$this->assign('appId',$appId);//
		$this->display();
	}
	
	function serviceList(){
		//$dwz_db_name=$dwz_db_name ? $dwz_db_name : $this->getActionName();
        $model = CM("Servgovern");  
        $map = $this->_search("Servgovern");
        $_REQUEST['pageSize'] = 10;

        if (!empty($model)) {
           $this->_list($model, $map);
        }

        //在界面显示状态
        if (false === $model->create()) {
        	$this->error($model->getError());
        }
        $traderet = $model->getTradeData('showInstanceStatus');
        $data = $traderet['data'];
        $this->assign('desc',$data[0]['desc']);//
        
        $this->display();
	}
	
	function insertPLService(){
		$model = CM("Servgovern");		
		if (false === $model->create()) {//添加主键和键值校验
			$this->error($model->getError());
		}

		$provideName = $_REQUEST['provideName'];
		$bizType = $_REQUEST['bizType'];
		if($provideName == ''||$bizType==''){
			$ret = array("statusCode"=>"0","message"=>'请选择业务类型！',"navTabId"=>'',//$this->navTab
        				"rel"=>"","forwardUrl"=>"","callbackType"=>"");
        		echo json_encode($ret);	
        		return;
		}

		if($_REQUEST['routeRule'] !=''){
			$check = $this->checkRule($_REQUEST['routeRule']);
			if($check == 1){
				$ret = array("statusCode"=>"0","message"=>'路由规则输入不正确!',"navTabId"=>'',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"");
				echo json_encode($ret);return;
			}
		}
		if($_REQUEST['expandCondition'] !=''){
			$check = $this->checkRule($_REQUEST['expandCondition']);
			if($check == 1){
				$ret = array("statusCode"=>"0","message"=>'扩展条件输入不正确!',"navTabId"=>'',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"");
				echo json_encode($ret);return;
			}
			
		}
		
		if(!empty($_REQUEST['tradeMethod'])){
			$result = $model->getTradeData();
			if($result['resposeCode'] == 'success'){
				$ret = $model->add();
				if($ret['errorCode'] === 0){
					$this->success('新增成功!');
				}else{
					$this->error('新增失败!'.$ret['errorMessage']);
				}
			}else{
				$this->error('调用容器服务失败!'.$result['errorMessage']);
			}
		}else{
			$ret = $model->add();
			if($ret['errorCode'] === 0){
				$this->success('新增成功!');
			}else{
				$this->error('新增失败!'.$ret['errorMessage']);
			}
		}
		
		
		
		
	}
	
	function subscribeList(){
		$model = CM("Servgovern");
		$map = $this->_search("Servgovern");
		$_REQUEST['pageSize'] = 10;
		
		if (!empty($model)) {
			$this->_list($model, $map);
		}
		
		$ServerTypedata = $model->getDataBase('getServerType');
		$ServerTypelist = $ServerTypedata['data'];
		$this->assign("ServerTypelist",$ServerTypelist);
		
		$this->display();
	}
	
	function editPLService(){
		$model = CM("Servgovern");
		$map = $this->_search("Servgovern");
		$_REQUEST['pageSize'] = 10;
		
		if (!empty($model)) {
			$this->_list($model, $map);
		}
		
		$this->display();
	}
	
	function showSubscribes(){
		$model = CM("Servgovern");
		$map = $this->_search("Servgovern");
		$_REQUEST['pageSize'] = 10;
		
		if (!empty($model)) {
			$this->_Tradelist($model, $map);
		}

		$this->display();
	}
	
	function addPLService(){
		$model = CM("Servgovern");
		$data = $model->getDataBase();
		
		$this->assign("list",$data['data']);
		
		$this->display();
		
	}
	
	//修改服务组名
	function editGroup(){
		$model = CM("Servgovern");
		$data = $model->getDataBase();
		
		$this->assign("list",$data['data']);
		
		$this->display();
		
	}
	
	//修改服务类型名
	function editServiceType(){
		$model = CM("Servgovern");
		$data = $model->getDataBase();
		
		$this->assign("list",$data['data']);
		
		$this->display();
	}
	
	//修改服务实例
	function editInstance(){
		$model = CM("Servgovern");
		$data = $model->getDataBase();
	
		$this->assign("list",$data['data']);
	
		$this->display();
	}
	
	//显示一键复制页面
	function copyinstance(){
		$model = CM("Servgovern");
		$appId = $model->sendTradeData('getAppid');
		$len = strlen($appId);
		$lenmore = 5-$len;
		for($i = 0; $i<$lenmore; $i++){
			$appIdHead .= "0";
		}
		$appId = $appIdHead . $appId;
		$this->assign('appId',$appId);//
		$this->display();
		
	}
	//一键复制
	function copyMachine(){
		$dwz_db_name=$dwz_db_name ? $dwz_db_name : $this->getActionName();
		$model = CM($dwz_db_name);
		if (false === $model->create()) {
			$this->error($model->getError());
		}
		
		$ret = $model->add();
		if ($ret['errorCode'] == 0) { //保存成功
			$data = $ret['data'];
			$traderet = $model->sendTradeData('copyInstance',$data);
			if($traderet['resposeCode'] == 'success'){
				$this->success('一键复制成功!',cookie('_currentUrl_'));
			}else{
				$id = $data['ServerTypeInstance'][0]['id'];
				$senddata = array('id'=>$id);
				$result =  $model->sendDataBase('delmachine',$senddata);
				$this->error('一键复制机器实例失败!'.$traderet['errorMessage'],cookie('_currentUrl_'));
			}
			
		}else{
			//失败提示
			$this->error('一键复制失败!'.$ret['errorMessage']);
		}
	}
	
	//查看实例状态
	function showInstanceStatus(){
		$dwz_db_name=$dwz_db_name ? $dwz_db_name : $this->getActionName();
		$model = CM($dwz_db_name);
		if (false === $model->create()) {
			$this->error($model->getError());
		}
		
		$traderet = $model->getTradeData('showInstanceStatus');
		$list = $traderet['data'];
		$this->assign('list',$list);
		$this->display();
		
		
	}
	
	//查看服务状态
	function showServiceStatus(){
		$dwz_db_name=$dwz_db_name ? $dwz_db_name : $this->getActionName();
		$model = CM($dwz_db_name);
		if (false === $model->create()) {
			$this->error($model->getError());
		}
	
		$traderet = $model->getTradeData('getExposeServiceStatusInfo');
		$data = $traderet['data'];
		$this->assign('list',$data);//
		$this->display();
	
	}
	
	//查看服务详情
	function showPullServiceInfo(){
		$dwz_db_name=$dwz_db_name ? $dwz_db_name : $this->getActionName();
		$model = CM($dwz_db_name);
		if (false === $model->create()) {
			$this->error($model->getError());
		}
	
		$traderet = $model->getTradeData('getPullServiceInfoByBizType');
		$data = $traderet['data'];
		if($traderet['resposeCode'] == 'error'){
			$this->assign('error',$traderet['errorMessage']);//
		}
		$this->assign('list',$data);//
		$this->display();
	
	}
	
	//一键灰度升级
	function autoUpgrade(){
		$dwz_db_name=$dwz_db_name ? $dwz_db_name : $this->getActionName();
		$model = CM($dwz_db_name);
		if (false === $model->create()) {
			$this->error($model->getError());
		}
		
		$traderet = $model->getTradeData('autoUpgradeAppById');
		//$data = $traderet['data'];
		
		
		//在界面显示状态
		$statusret = $model->getTradeData('showInstanceStatus');
		$data = $statusret['data'];
		//$this->assign('desc',$data[0]['desc']);//
		
		if($traderet['resposeCode'] == 'success'){
			$ret = array("statusCode"=>"200","message"=>'一键灰度升级成功!',"navTabId"=>'',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"",'desc'=>$data[0]['desc']);
				echo json_encode($ret);return;
		}else{
			$this->error('一键灰度升级失败!'.$traderet['errorMessage'],cookie('_currentUrl_'));
		}

	}
	
	//一键恢复
	function autoRecover(){
		$dwz_db_name=$dwz_db_name ? $dwz_db_name : $this->getActionName();
		$model = CM($dwz_db_name);
		if (false === $model->create()) {
			$this->error($model->getError());
		}
	
		$traderet = $model->getTradeData('autoRecoverAppById');
		//$data = $traderet['data'];
	
		//在界面显示状态
		$statusret = $model->getTradeData('showInstanceStatus');
		$data = $statusret['data'];
		
		if($traderet['resposeCode'] == 'success'){
			$ret = array("statusCode"=>"200","message"=>'一键恢复成功!',"navTabId"=>'',//$this->navTab
					"rel"=>"","forwardUrl"=>"","callbackType"=>"",'desc'=>$data[0]['desc']);
			echo json_encode($ret);return;
		}else{
			$this->error('一键恢复失败!'.$traderet['errorMessage'],cookie('_currentUrl_'));
		}
	
	}


}
?>
