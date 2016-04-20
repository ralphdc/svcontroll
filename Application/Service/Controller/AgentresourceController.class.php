<?php
/**
 * 服务管制--监控配置管理-代理资源层
 * @author zengguangqiu
 *
 */
class AgentresourceController extends CommonController {
	//var $navTab = 'D60607';
	var $navTab = '2c948cfb51ec5db00151ec9042b1001b';
	
// 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$Agentresource = new AgentresourceModel($_POST,$_GET);
		$result = $Agentresource->findByPost($_POST,$_GET);
		$count = $Agentresource->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		//dump($result);
		$this->assign ( 'map', array('agentIp'=>'','resIp'=>'') );
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
	public function add(){
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
	
			}
			//获取代理资源层id和IP地址
			$ipids = explode(",", $_POST['prtv_id']);
			$ips = explode(",", $_POST['prtv_name']);
			if(is_array($ipids) && count($ipids))
			{
				foreach ($ipids as $ipkey=>$ipval)
				{
					$tempArr[$ipkey]['resId'] =  $ipval;
					$tempArr[$ipkey]['hostIp'] =  $ips[$ipkey];
				}
			}
			//组织要保存的数据
			$post['data']['ip'] = trim($_POST['ip']);
			$post['data']['port'] = trim($_POST['port']);
			$post['data']['otInterval'] = trim($_POST['otInterval']);
			$post['data']['mountList'] = $tempArr;
			$post['form_act'] = 'create';
			//调用java接口进行数据的操作
			$Agentresource = new AgentresourceModel($_POST,$_GET);
			$result = $Agentresource->postSave($post);
			if($result['errorCode'] == 0){
				$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}else{
				$msg = $result['errorMessage'];
				$ret = array("statusCode"=>"0","message"=>$msg,"navTabId"=>'',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}
		}
		$this->display();
	}
	
	function edit() {
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
		
			}
			//获取代理资源层id和IP地址
			$ipids = explode(",", $_POST['prtv_id']);
			$ips = explode(",", $_POST['prtv_name']);
			if(is_array($ipids) && count($ipids))
			{
				foreach ($ipids as $ipkey=>$ipval)
				{
					$tempArr[$ipkey]['resId'] =  $ipval;
					$tempArr[$ipkey]['hostIp'] =  $ips[$ipkey];
				}
			}
			//组织要保存的数据
			$post['data']['id'] = intval($_POST['id']);
			$post['data']['ip'] = trim($_POST['ip']);
			$post['data']['port'] = trim($_POST['port']);
			$post['data']['otInterval'] = $_POST['otInterval'];
			$post['data']['mountList'] = $tempArr;
			$post['form_act'] = 'update';
			//调用java接口进行数据的操作
			$Agentresource = new AgentresourceModel($_POST,$_GET);
			$result = $Agentresource->postSave($post);
			if($result['errorCode'] == 0){
				$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}else{
				$msg = $result['errorMessage'];
				$ret = array("statusCode"=>"0","message"=>$msg,"navTabId"=>'',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}
		}
		$id = $_REQUEST ['id'];
		$Agentresource = new AgentresourceModel($_POST,$_GET);
		$vo = $Agentresource->getRowInfo($id);
		$this->assign('row', $vo);
		$this->display();
	}
	
	/**
	 * 删除
	 * @see CommonController::foreverdelete()
	 */
	function foreverdelete()
	{
		$ids =$_POST['ids'];
		$Agentresource = new AgentresourceModel();
		$result = $Agentresource->deleteAll($ids);
		if($result['errorCode'] == 0){
			$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab,//$this->navTab
					"rel"=>"","forwardUrl"=>"");
			echo json_encode($ret);	return;
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"0","message"=>$msg,"navTabId"=>'',//$this->navTab
					"rel"=>"","forwardUrl"=>"");
			echo json_encode($ret);	return;
		}
	}
	/**
	 * 删除单个
	 */
	function delete()
	{
		$id =$_GET['id'];
		$Agentresource = new AgentresourceModel();
		$result = $Agentresource->delete($id);
		if($result['errorCode'] == 0){
			$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab,//$this->navTab
					"rel"=>"","forwardUrl"=>"");
			echo json_encode($ret);	return;
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"0","message"=>$msg,"navTabId"=>'',//$this->navTab
					"rel"=>"","forwardUrl"=>"");
			echo json_encode($ret);	return;
		}
	}
	
	
}