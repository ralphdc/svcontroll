<?php
/**
 * 显示调用链详细信息
 * @author zengguangqiu
 *
 */
class ShowPidDetailController extends CommonController {
	var $navTab = 'L30901';
    // 框架首页
	public function index(){
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		if($_GET['pid'] > 0)
		{
			$_POST['cid'] = trim($_GET['pid']);
			$_REQUEST['cid'] = trim($_GET['pid']);
		}
			
		$_POST['type'] = 2;
		$_POST['fromid'] = 150;	
		$_REQUEST['fromid'] = 150;
		if(!empty($_GET['startTime']))
		{
			$_POST['startTime'] = trim($_GET['startTime']);
			$_REQUEST['startTime'] = trim($_GET['startTime']);
		}
		if(!empty($_GET['endTime']))
		{
			$_POST['endTime'] = trim($_GET['endTime']);
			$_REQUEST['endTime'] = trim($_GET['endTime']);
		}
		if(empty($_REQUEST['numPerPage']))
		{
			$_REQUEST['numPerPage'] = $_COOKIE['numPerPage'.$_POST['fromid']];
		}
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$_POST['numPerPage'] = $pageNum;
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$Pidlink = new PidlinkModel($_POST,$_GET);
		$result = $Pidlink->findByPost($_POST,$_GET);
		$count = $Pidlink->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		$this->assign ( 'map', array('cid'=>'','startTime'=>'','endTime'=>'','fromid'=>'') );
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}

}