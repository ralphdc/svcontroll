<?php
/**
 * 设置主机环境
 *
 */
class SetSystemController extends CommonController {
	//public $navTab = 'D707';
    public $navTab = '2c948cfb51ec5db00151ec9ccdd8003d';
   // 框架首页
	public function index(){
		if($_POST)
		{
			$_SESSION['SYSTEM_FLAG'] = $_POST['systemflag'];
			
			 $ret = array("statusCode"=>"1","message"=>'设置成功。',"navTabId"=>$this->navTab,//$this->navTab
			 "rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
			echo json_encode($ret);	return; 
				
		}
		$sysEnv = C('TSysName') ? C('TSysName') : array('1'=>"T1系统 ",'2'=>"T2系统");
		$this->assign('systemflag',$sysEnv);
		
		if(empty($_SESSION['SYSTEM_FLAG']))
		{
			$_SESSION['SYSTEM_FLAG'] = '1';
		}
		$this->assign('nowsystemflag',$_SESSION['SYSTEM_FLAG']);
		$this->display ();
	}
	
	
		
}