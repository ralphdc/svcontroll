<?php
/**
 * 服务管制--监控配置中心--监控过滤
 * @author zengguangqiu
 *
 */
class MonitorfilterController extends CommonController {
	//var $navTab = 'D60611';
	var $navTab = '2c948cfb51ec5db00151ec94aa210027';
	var $type = array('1'=>'终端号','2'=>'交易返回码');
	
// 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$Monitorfilter = new MonitorfilterModel($_POST,$_GET);
	 	$result = $Monitorfilter->findByPost($_POST,$_GET);
		$count = $Monitorfilter->countByPost($_POST,$_GET); 
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		$this->assign ( 'type', $this->type );
		//dump($result);
		$this->assign ( 'map', array('type'=>'','value'=>'') );
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
	public function add(){
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
	
			}
			//组织要保存的数据
			$post['data']['type'] = trim($_POST['type']);
			$post['data']['value'] = trim($_POST['value']);
			$post['form_act'] = 'create';
			//调用java接口进行数据的操作
			$Monitorfilter = new MonitorfilterModel($_POST,$_GET);
			$result = $Monitorfilter->postSave($post);
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

		$this->assign ( 'type', $this->type );
		$this->display();
	}
	
	function edit() {
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
	
			}
			//组织要保存的数据
			$post['data']['id'] = intval($_POST['id']);
			$post['data']['type'] = trim($_POST['type']);
			$post['data']['value'] = trim($_POST['value']);
			$post['form_act'] = 'update';
			//调用java接口进行数据的操作
			$Monitorfilter = new MonitorfilterModel($_POST,$_GET);
			$result = $Monitorfilter->postSave($post);
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
		$Monitorfilter = new MonitorfilterModel($_POST,$_GET);
		$vo = $Monitorfilter->getRowInfo($id);
		$this->assign('row', $vo);
		$this->assign ( 'type', $this->type );
		$this->display();
	}
	
	/**
	 * 删除
	 * @see CommonController::foreverdelete()
	 */
	function foreverdelete()
	{
		$ids =$_POST['ids'];
		$Monitorfilter = new MonitorfilterModel();
		$result = $Monitorfilter->deleteAll($ids);
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
		$Monitorfilter = new MonitorfilterModel();
		$result = $Monitorfilter->delete($id);
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