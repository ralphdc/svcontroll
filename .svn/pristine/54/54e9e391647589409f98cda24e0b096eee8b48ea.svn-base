<?php
/**
 * 服务管制--资源中心-分区管理对应的控制器
 * @author zengguangqiu
 *
 */
class AreamanageController extends CommonController {
	//var $navTab = 'D60615';
	var $navTab = '2c948cfb51ec5db00151ec993e620031';
	
	// 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$Areamanage = new AreamanageModel($_POST,$_GET);
		$result = $Areamanage->findByPost($_POST,$_GET);
		$count = $Areamanage->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		//dump($result);
		$this->assign ( 'map', array('arName'=>''));
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
			$post['data']['arChar'] = trim($_POST['arChar']);
			$post['data']['arName'] = trim($_POST['arName']);
			$post['data']['arDec'] = trim($_POST['arDec']);
			$post['data']['arDemo'] = trim($_POST['arDemo']);
			$post['form_act'] = 'create';
			//调用java接口进行数据的操作
			$Areamanage = new AreamanageModel($_POST,$_GET);
			$result = $Areamanage->postSave($post);
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
			//组织要保存的数据
			$post['id'] = intval($_POST['id']);
			$post['data']['arChar'] = trim($_POST['arChar']);
			$post['data']['arName'] = trim($_POST['arName']);
			$post['data']['arDec'] = trim($_POST['arDec']);
			$post['data']['arDemo'] = trim($_POST['arDemo']);
			$post['form_act'] = 'update';
			//调用java接口进行数据的操作
			$Areamanage = new AreamanageModel($_POST,$_GET);
			$result = $Areamanage->postSave($post);
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
		$Areamanage = new AreamanageModel($_POST,$_GET);
		$vo = $Areamanage->getRowInfo($id);
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
		$Areamanage = new AreamanageModel();
		$result = $Areamanage->deleteAll($ids);
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
		$Areamanage = new AreamanageModel();
		$result = $Areamanage->delete($id);
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