<?php
/**
 * 服务管制--资产管理---机房查找带回
 * @author zengguangqiu
 *
 */
class SearchroomController extends CommonController {
	var $navTab = 'D60698';
	
// 框架首页
	public function index() 
	{
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$Searchroom = new SearchroomModel($_POST,$_GET);
		$result = $Searchroom->findByPost($_POST,$_GET);
		$count = $Searchroom->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		$this->assign ( 'map', array('arName'=>''));
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
	
	
}