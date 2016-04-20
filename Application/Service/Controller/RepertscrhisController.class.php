<?php
/**
 * 服务管制--获取初始化机器历史记录
 * @author zengguangqiu
 *
 */
class RepertscrhisController extends CommonController {
	var $navTab = 'D60666';
	
// 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		if($_GET['type'])
		{
			$_REQUEST['type'] = $_GET['type'];
		}
		
		if($_REQUEST['type'])
		{
			$html = "index".$_REQUEST['type'];
			$Repertscrhis = new RepertscrhisModel($_POST,$_GET);
			$result = $Repertscrhis->findByPost($_POST,$_GET);
			$count = $Repertscrhis->countByPost($_POST,$_GET);
			$this->assign ( 'totalCount', $count );
			$this->assign ( 'list', $result );
			$this->assign ( 'map', array('ipv'=>'','person'=>'','begintime'=>'','endtime'=>'','type'=>'') );
			cookie('_currentUrl_', __SELF__);
			$this->display($html);
		}
		else
		{
			$Repertscrhis = new RepertscrhisModel($_POST,$_GET);
			$result = $Repertscrhis->findByPost($_POST,$_GET);
			$count = $Repertscrhis->countByPost($_POST,$_GET);
			$this->assign ( 'totalCount', $count );
			$this->assign ( 'list', $result );
			//dump($result);
			$this->assign ( 'map', array('ipv'=>'','person'=>'','begintime'=>'','endtime'=>'') );
			cookie('_currentUrl_', __SELF__);
			$this->display();
		}
		
	}
	
	/**
	 * 查看脚本日志
	 */
	public function Seelog()
	{
		//根据传递过来的调度计划的ID获取对应的一行的数据
		$inId = $_GET['inId'];
		$Repertscrhis = new RepertscrhisModel($_POST,$_GET);
		$logcontent  = $Repertscrhis->getlogcontent($inId);
		//dump($logcontent);
		$this->assign('logcontent',$logcontent);
		$this->display();
	}
	
	
	
}