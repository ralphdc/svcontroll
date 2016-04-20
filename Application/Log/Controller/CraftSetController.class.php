<?php
/**
 * 分析配置器控制器
 * @author zengguangqiu
 *
 */
class CraftSetController extends CommonController {
	var $navTab = 'L30802';
	
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
		$CraftSet = new CraftSetModel($_POST,$_GET);
		$result = $CraftSet->findByPost($_POST,$_GET);
		$count = $CraftSet->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		//dump($result);
		$this->assign ( 'map', array('service'=>'','level'=>'','startTime'=>'','endTime'=>'') );
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
	public function add(){	
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
	
			}
			$analyserArr = $_POST['analyser'];
			$analyser = json_encode($analyserArr);
			//组织要保存的数据
			$post['name'] = trim($_POST['name']);
			$post['analyser'] = $analyser;
			$post['dir'] = trim($_POST['dir']);
			$post['type'] = trim($_POST['type']);
			$post['interval'] = trim($_POST['interval']);
			$post['desc'] = trim($_POST['desc']);
			$post['form_act'] = 'create';
			//调用java接口进行数据的操作
			$CraftSet = new CraftSetModel($_POST,$_GET);
			$result = $CraftSet->postSave($post);
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
			$analyserArr = array();
			$analyserArr = $_POST['analyser'];
			$analyser = json_encode($analyserArr);
			//组织要保存的数据
			$post['name'] = trim($_POST['name']);
			$post['analyser'] = $analyser;
			$post['dir'] = trim($_POST['dir']);
			$post['type'] = trim($_POST['type']);
			$post['interval'] = trim($_POST['interval']);
			$post['desc'] = trim($_POST['desc']);
			$post['id'] = $_GET['id'];
			$post['form_act'] = 'update';
			//调用java接口进行数据的操作
			$CraftSet = new CraftSetModel($_POST,$_GET);
			$result = $CraftSet->postSave($post);
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
		$CraftSet = new CraftSetModel($_POST,$_GET);
		$vo = $CraftSet->getRowInfo($id);
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
		$serviceArr = array();
		if(is_array($idsArr) && count($idsArr))
		{
			foreach ($idsArr as $key=>$val)
			{
				$tempArr = explode('|', $val);
				$serviceArr[$key]['id'] = $tempArr[0];
				$serviceArr[$key]['name'] = $tempArr[1];
			}
		}
		$service = json_encode($serviceArr);
		$CraftSet = new CraftSetModel();
		$result = $CraftSet->deleteAll($service);
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
		$name = trim($_GET['name']);
		$serviceArr = array(array('id'=>$id,'name'=>$name));
		$service = json_encode($serviceArr);
		$CraftSet = new CraftSetModel();
		$result = $CraftSet->delete($service);
		if($result['rtn'] == 'OK'){
			$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab,"forwardUrl"=>""/* ,"callbackType"=>"closeCurrent" */);
			exit(json_encode($ret));
		}else{
			$ret = array("statusCode"=>"0","message"=>"操作失败","forwardUrl"=>"","callbackType"=>"closeCurrent");
			exit(json_encode($ret));
		}
	}
	/**
	 * 查找带回
	 */
	function search()
	{
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$Search = new SearchModel($_POST,$_GET);
		$result = $Search->findByPost($_POST,$_GET);
		$count = $Search->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		
		$this->assign ( 'map', array('service'=>'') );
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
}