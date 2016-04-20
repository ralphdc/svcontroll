<?php
/**
 * 服务管服务和java通信公共数据接口类子类（分区管理）
 * @author zengguangqiu
 *
 */
class PartitionmanageController extends CommonController {
	var $navTab = 'D60616';
	
	// 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$Partitionmanage = new PartitionmanageModel($_POST,$_GET);
		$result = $Partitionmanage->findByPost($_POST,$_GET);
		$count = $Partitionmanage->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		//dump($result);
		$this->assign ( 'map', array('stChar'=>''));
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
			$post['name'] = trim($_POST['name']);
			$post['qname'] = trim($_POST['qname']);
			$post['desc'] = trim($_POST['desc']);
			$post['date'] = date("Y-m-d H:i:s");
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
			$post['name'] = trim($_POST['name']);
			$post['qname'] = trim($_POST['qname']);
			$post['desc'] = trim($_POST['desc']);
			$post['date'] = date("Y-m-d H:i:s");
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
		$id = $_REQUEST ['id'];
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
		$idsArr = explode(",", $ids);
		$craftsetArr = array();
		if(is_array($idsArr) && count($idsArr))
		{
			foreach ($idsArr as $key=>$val)
			{
				$tempArr = explode('|', $val);
				$craftsetArr[$key]['id'] = $tempArr[0];
				$craftsetArr[$key]['qname'] = $tempArr[1];
			}
		}
		$craftset = json_encode($craftsetArr);
		$AnalysisRule = new AnalysisRuleModel();
		$result = $AnalysisRule->deleteAll($craftset);
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
		$qname =trim($_GET['qname']);
		$idarr = array(array('id'=>$id,'qname'=>$qname));
		$idjson = json_encode($idarr);
		$AnalysisRule = new AnalysisRuleModel();
		$result = $AnalysisRule->delete($idjson);
		if($result['rtn'] == 'OK'){
			$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab,"forwardUrl"=>""/* ,"callbackType"=>"closeCurrent" */);
			exit(json_encode($ret));
		}else{
			$ret = array("statusCode"=>"0","message"=>"操作失败","forwardUrl"=>"","callbackType"=>"closeCurrent");
			exit(json_encode($ret));
		}
	}
	
	
}