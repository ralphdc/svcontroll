<?php
/**
 * 最新告警日志控制器
 * @author zengguangqiu
 *
 */
class LatestWarningLogController extends CommonController {

    // 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$LatestWarningLog = new LatestWarningLogModel();
		$_POST['range'] = empty($_POST['range']) ? 1 : $_POST['range'];
		$_POST['size'] = empty($_POST['size']) ? 20 : $_POST['size'];
		$result = $LatestWarningLog->findByPost($_POST, $_GET);
		$this->assign('range',array(1,3,6,12,24));
		$this->assign('size',array(20,30,40,50,100));
		$this->assign('map',array('range'=>'','size'=>''));
		$this->assign('list',$result);
		$this->display();
	}

}