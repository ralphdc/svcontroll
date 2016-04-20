<?php
/**
 * 服务管制--仓库中心历史记录
 * @author zengguangqiu
 *
 */
class ReperthistoryController extends CommonController {
	var $navTab = 'D60635';
	var $opratetype = array('1'=>'导入','2'=>'发布');
	
// 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		if($_GET['mwId']> 0)
		{
			$_POST['mwId'] = $_GET['mwId'];
			$_REQUEST['mwId'] = $_GET['mwId'];
		}
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$Reperthistory = new ReperthistoryModel($_POST,$_GET);
		$result = $Reperthistory->findByPost($_POST,$_GET);
		$count = $Reperthistory->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result ); 
		$this->assign ( 'opratetype', $this->opratetype ); 
		//dump($result);
		$this->assign ( 'map', array('operationtype'=>'','person'=>'','begintime'=>'','endtime'=>'','mwId'=>'') );
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
	
	/**
	 * 删除
	 * @see CommonController::foreverdelete()
	 */
	function foreverdelete()
	{
		$ids =$_POST['ids'];
		$Reperthistory = new ReperthistoryModel();
		$result = $Reperthistory->deleteAll($ids);
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
		$Reperthistory = new ReperthistoryModel();
		$result = $Reperthistory->delete($id);
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