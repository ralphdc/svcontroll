<?php
/**
 * 服务管制--监控中心管理---元素查找带回
 * @author zengguangqiu
 *
 */
class SearchelemController extends CommonController {
	var $navTab = 'D60692';
	
// 框架首页
	public function index() 
	{
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$Searchelem = new SearchelemModel($_POST,$_GET);
		$result = $Searchelem->findByPost($_POST,$_GET);
		$count = $Searchelem->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		//dump($result);
		$this->assign ( 'map', array('elemId'=>'','elemName'=>''));
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
	
	
}