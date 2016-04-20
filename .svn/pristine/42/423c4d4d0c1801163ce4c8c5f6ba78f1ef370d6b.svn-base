<?php
/**
 * 服务管制--监控中心管理---测试参数查找带回
 * @author zengguangqiu
 *
 */
class SearchparamController extends CommonController {
	var $navTab = 'D60693';
	
// 框架首页
	public function index() 
	{
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$Searchparam = new SearchparamModel($_POST,$_GET);
		$result = $Searchparam->findByPost($_POST,$_GET);
		$count = $Searchparam->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		//dump($result);
		$this->assign ( 'map', array('query'=>''));
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
	
	
}