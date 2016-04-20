<?php
/**
 * 服务管制--监控管理---挂载资源查找带回
 * @author zengguangqiu
 *
 */
class SearchipresController extends CommonController {
	//var $navTab = 'D60622';
	var $navTab = '2c948cfb51ebb03c0151ebbaba760018';
	var $virtual = array('1'=>'物理机','2'=>'虚拟机');
	
// 框架首页
	public function index() 
	{
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$Servermanage = new ServermanageModel($_POST,$_GET);
		$result = $Servermanage->findByPost($_POST,$_GET);
		$count = $Servermanage->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		//dump($result);
		$this->assign('virtual',$this->virtual);
		$this->assign('environment',C('CONST_ENVIRONMENT'));
		$this->assign ( 'map', array('hostname'=>'','environment'=>''));
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
	
	
}