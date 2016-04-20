<?php
/**
 * 分析配置器控制器
 * @author zengguangqiu
 *
 */
class JsoneditController extends CommonController {
	var $navTab = 'L308023';
	
    // 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$id = $_GET['id'];
		$type = $_GET['type'];
		$QueryHistoryLog = new QueryHistoryLogModel($_POST,$_GET);
		$result = $QueryHistoryLog->getMsgInfo($id,$type);
		//$search = '/(\t|\r|\n|<br(\/?)>)/i';
		$search = '/(\t|\r|\n)/i';
		$replace = '';
		//echo preg_replace($search, $replace, $result);
		$this->assign('info',preg_replace($search, $replace, $result));
		$this->display();
	}
}