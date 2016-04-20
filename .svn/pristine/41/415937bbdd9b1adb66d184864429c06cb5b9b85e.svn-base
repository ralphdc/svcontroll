<?php
/**
 * 实时监控总数控制器
 * @author zengguangqiu
 *
 */
class ShowMonitorDetailController extends CommonController {

    // 框架首页
	public function index(){
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		/*
		$ret = array('statusCode'=>'1','message'=>'asdsadsad');
		exit(json_encode($ret));
		 $ret['status'] = '0';
		$ret['info']  = 'asdsadasds';
		$this->ajaxReturn($ret); */		
		$_POST['srv'] = trim($_GET['srv']);
		if(!empty($_GET['start']))
			$_POST['start'] = trim($_GET['start']);
		if(!empty($_GET['end']))
			$_POST['end'] = trim($_GET['end']);
		$RealTimeDetection = new RealTimeDetectionModel($_POST,$_GET);
		$result = $RealTimeDetection->showMoitorDetail($_POST,$_GET);
		$this->assign ( 'list', $result );
		$this->assign ( 'map', array('srv'=>'','start'=>'','end'=>'') );
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}

}