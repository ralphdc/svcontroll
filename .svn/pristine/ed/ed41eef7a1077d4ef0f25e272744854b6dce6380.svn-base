<?php
/**
 * 分析规则控制器
 * @author zengguangqiu
 *
 */
class AnalysisRuleController extends CommonController {
	var $navTab = 'L30801';
    // 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		/* $ret = array('statusCode'=>'0','message'=>'asdsadsad');
		exit(json_encode($ret)); */
		/*  $ret['status'] = '0';
		$ret['info']  = 'asdsadasds';
		$this->ajaxReturn($ret); */
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$AnalysisRule = new AnalysisRuleModel($_POST,$_GET);
		$result = $AnalysisRule->findByPost($_POST,$_GET);
		$count = $AnalysisRule->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		//dump($result);
		$this->assign ( 'map', array('node'=>''));
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
			$post['node'] = trim($_POST['node']);
			$post['form_act'] = 'create';
			//调用java接口进行数据的操作
			$AnalysisRule = new AnalysisRuleModel($_POST,$_GET);
			$result = $AnalysisRule->postSave($post);
			if($result['rtn'] == "OK"){
				$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}else{
				$msg = $result['rtndata'];
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
			$post['id'] = trim($_GET['id']);
			$post['node'] = trim($_POST['node']);
			$post['form_act'] = 'update';
			//调用java接口进行数据的操作
			$AnalysisRule = new AnalysisRuleModel($_POST,$_GET);
			$result = $AnalysisRule->postSave($post);
			if($result['rtn'] == "OK"){
				$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}else{
				$msg = $result['rtndata'];
				$ret = array("statusCode"=>"0","message"=>$msg,"navTabId"=>'',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}
		}
		$id = $_REQUEST['id'];
		$AnalysisRule = new AnalysisRuleModel($_POST,$_GET);
		$vo = $AnalysisRule->getRowInfo($id);
		$this->assign('vo', $vo);
		$this->display();
	}
	
	/**
	 * 删除
	 * @see CommonController::foreverdelete()
	 */
	function foreverdelete()
	{
		$ids =$_POST['ids'];
		$AnalysisRule = new AnalysisRuleModel();
		$result = $AnalysisRule->deleteAll($ids);
		if($result['rtn'] == 'OK'){
				$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab,"forwardUrl"=>""/* ,"callbackType"=>"closeCurrent" */);
				exit(json_encode($ret));
			}else{
				$ret = array("statusCode"=>"0","message"=>"操作失败","forwardUrl"=>"","callbackType"=>"closeCurrent");
				exit(json_encode($ret));
			}
	}
	/**
	 * 删除单个
	 */
	function delete()
	{
		$id =$_GET['id'];
		$AnalysisRule = new AnalysisRuleModel();
		$result = $AnalysisRule->delete($id);
		if($result['rtn'] == 'OK'){
			$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab,"forwardUrl"=>""/* ,"callbackType"=>"closeCurrent" */);
			exit(json_encode($ret));
		}else{
			$ret = array("statusCode"=>"0","message"=>"操作失败","forwardUrl"=>"","callbackType"=>"closeCurrent");
			exit(json_encode($ret));
		}
	}

}