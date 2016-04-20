<?php

class EnvironmentController extends CommonController {
	var $navTab = 'L30803';
    // 框架首页
	public function index() {		
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		if($_POST)
		{
				$_SESSION['WEB_ENVIRONMENT'] = $_POST['environment'];
				$this->redirect('index/index');
				exit;
				/* $ret = array("statusCode"=>"1","message"=>'设置成功。',"navTabId"=>$this->navTab,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return; */
			
		}
		$this->assign('environment',C('CONST_ENVIRONMENT'));
		if(empty($_SESSION['WEB_ENVIRONMENT']))
		{
			$_SESSION['WEB_ENVIRONMENT'] = 5;
		}
		$this->assign('nowenvironment',$_SESSION['WEB_ENVIRONMENT']);
		$this->display ();
	}

}