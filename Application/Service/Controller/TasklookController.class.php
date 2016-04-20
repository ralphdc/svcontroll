<?php
/**
 * 服务管制--仓库中心-批量处理查看对应的控制器
 * @author zengguangqiu
 *
 */
class TasklookController extends CommonController {
	var $navTab = 'D60621';
	
	// 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		
		//从cookie中获取对应批量任务中的服务ID
		$metaids =cookie('metaid_datas');
		if(empty($metaids))
		{
			$count = 0;
			$result = array();
		}else
		{
			$_POST['ids'] = $metaids;
			$Tasklook = new TasklookModel($_POST,$_GET);
			$result = $Tasklook->findByPost($_POST,$_GET);
			$count = $Tasklook->countByPost($_POST,$_GET);
		}
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		//dump($result);
		$this->assign ( 'map', array('servicename'=>''));
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
	
	/**
	 * 删除
	 * @see CommonController::foreverdelete()
	 */
	function foreverdelete()
	{
		$ids =$_POST['metadataids'];
		$idsArr = explode(',', $ids);
		$metaIDArr =explode(',',cookie('metaid_datas'));
		$temDataArr = array_flip($metaIDArr);
		if(is_array($idsArr) &&  count($idsArr))
		{
			foreach ($idsArr as $id)
			{
				if(in_array($id, $metaIDArr))
				{
					unset($temDataArr[$id]);
					$data =implode(",", array_flip($temDataArr));
					if($data)
					{
						cookie('datas',$data,array('expire'=>360000,'prefix'=>'metaid_'));
					}else
					{
						cookie('datas',null,array('expire'=>360000,'prefix'=>'metaid_'));
					}
				}
			}
			$result['errorCode'] = 0;
			$result['errorMessage'] = '操作失败';
		}
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
		$metaIDArr =explode(',',cookie('metaid_datas'));
		if(in_array($id, $metaIDArr))
		{
			$temDataArr = array_flip($metaIDArr);
			unset($temDataArr[$id]);
			$data =implode(",", array_flip($temDataArr));
			if($data)
			{
				cookie('datas',$data,array('expire'=>360000,'prefix'=>'metaid_'));
			}else
			{
				cookie('datas',null,array('expire'=>360000,'prefix'=>'metaid_'));
			}
			$result['errorCode'] = 0;
		}else
		{
			$result['errorMessage'] = '删除失败!';
		}
		
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