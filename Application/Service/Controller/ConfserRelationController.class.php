<?php
/**
 * 服务管制-配置中心-（查看引用配置实例的服务实例）
 * @author zengguangqiu
 *
 */
class ConfserRelationController extends CommonController {
	var $navTab = 'D60699';
	
// 框架首页
	public function index() 
	{
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		if($_GET['id']> 0)
		{
			$_POST['cfginstanceid'] = $_GET['id'];
			$_REQUEST['cfginstanceid'] = $_GET['id'];
		}
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$ConfserRelation = new ConfserRelationModel($_POST,$_GET);
		$result = $ConfserRelation->findByPost($_POST,$_GET);
		$count = $ConfserRelation->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		//dump($result);
		$this->assign ( 'map', array('cfginstanceid'=>'','servicename'=>'','ipv'=>''));
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
	
}