<?php
/**
 * 服务管制--仓库中心-批量处理-配置预览
 * @author zengguangqiu
 *
 */
class SeeconfigsController extends CommonController {
	var $navTab = 'D61623';
	var $opttype = array('1'=>'启动','2'=>'关闭','3'=>'新增','4'=>'迭代','5'=>'部署');
	// 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$Seeconfigs = new SeeconfigsModel($_POST,$_GET);
		$result = $Seeconfigs->findByPost($_POST,$_GET);
		$count = $Seeconfigs->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		$this->assign ( 'opttype', $this->opttype );
		$this->assign ( 'map', array('arName'=>''));
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
}