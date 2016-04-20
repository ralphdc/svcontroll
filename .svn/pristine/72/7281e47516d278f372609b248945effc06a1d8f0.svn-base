<?php
/**
 * 付款通道
 * @author zengguangqiu
 *
 */
class UkeyController extends CommonController {
    //var $navTab = 'D60620';
	var $navTab = '2c948cfb51ebb03c0151ebbd5347001e';
	var $ukAlarm = array('0'=>'不报警','1'=>'报警');
	
// 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$Ukey = new UkeyModel($_POST,$_GET);
		$result = $Ukey->findByPost($_POST,$_GET);
		$count = $Ukey->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		$this->assign('ukAlarm',$this->ukAlarm);
		$this->assign ( 'map', array('ukAlarm'=>'') );
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
			$post['data']['ukId'] = trim($_POST['ukId']);
			$post['data']['ukName'] = trim($_POST['ukName']);
			$post['data']['ukStart'] = trim($_POST['ukStart']);
			$post['data']['ukEnd'] = trim($_POST['ukEnd']);
			$post['data']['ukAlarm'] = trim($_POST['ukAlarm']);
			$post['data']['ukAhead'] = trim($_POST['ukAhead']);
			$post['data']['ukRemark'] = trim($_POST['ukRemark']);
			$post['form_act'] = 'create';
			//调用java接口进行数据的操作
			$Ukey = new UkeyModel($_POST,$_GET);
			$result = $Ukey->postSave($post);
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
		$this->assign('ukAlarm',$this->ukAlarm);
		$this->display();
	}
	
	function edit() {
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
	
			}
			//组织要保存的数据
			$post['data']['id'] = trim($_POST['id']);
			$post['data']['ukId'] = trim($_POST['ukId']);
			$post['data']['ukName'] = trim($_POST['ukName']);
			$post['data']['ukStart'] = trim($_POST['ukStart']);
			$post['data']['ukEnd'] = trim($_POST['ukEnd']);
			$post['data']['ukAlarm'] = trim($_POST['ukAlarm']);
			$post['data']['ukAhead'] = trim($_POST['ukAhead']);
			$post['data']['ukRemark'] = trim($_POST['ukRemark']);
			$post['form_act'] = 'update';
			$Ukey = new UkeyModel($_POST,$_GET);
			$result = $Ukey->postSave($post);
			
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
		$Ukey = new UkeyModel($_POST,$_GET);
		$vo = $Ukey->getRowInfo($id);
		$this->assign('row', $vo);
		$this->assign('ukAlarm',$this->ukAlarm);
		$this->display();
	}
	
	/**
	 * 删除
	 * @see CommonController::foreverdelete()
	 */
	function foreverdelete()
	{
		$ids =$_POST['ids'];
		$Ukey = new UkeyModel();
		$result = $Ukey->deleteAll($ids);
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
		$Ukey = new UkeyModel();
		$result = $Ukey->delete($id);
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