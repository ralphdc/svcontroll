<?php
/**
 * 服务管制--资产管理---物理机查找带回
 * @author zengguangqiu
 *
 */
class SearchmecController extends CommonController {
	var $navTab = 'D60699';
	
// 框架首页
	public function index() 
	{
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$_POST['isVirtual'] = 1;
		$Servermanage = new ServermanageModel($_POST,$_GET);
		$result = $Servermanage->findByPost($_POST,$_GET);
		$count = $Servermanage->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		//dump($result);
		$this->assign ( 'map', array('hostname'=>''));
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
	
	
}