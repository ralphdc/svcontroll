<?php
/**
 * 质量监控-主机质量监控
 *
 */
class HostqualitymonController extends HostSerqCommonController {
	var $navTab = 'D60702';
   // 框架首页
	public function index() {
	
		$urlpath = "/hostree/".$_SESSION['WEB_ENVIRONMENT'];
		$model = CM("Hostqualitymon");
		$result = $model->sendHostSerqualitBase($urlpath);
		$list = $result['data'];
		$this->assign("menu",$list);
		$this->display();
	}
	
	//展示主机资源列表
	function showHostResourceList() {
		$serverId = $_REQUEST['serverId'];
		$urlpath ="/hostlist/".$serverId;
		$model = CM("Hostqualitymon");
		
		$result = $model->sendHostSerqualitBase($urlpath);
		$list = $result['data'];
		$this->assign("list",$list);
		$this->display();

	}
	
	//展示主机详细信息
	function showHostResourceDetail(){
		$ip = "172.17.3.86";//$_REQUEST['ip'];
		$urlpath = "/service/warning/detail/".$ip."/";
		$model = CM("Serqualitymon");
		$result = $model->sendHostSerqualitBase($urlpath);
		$list = $result['data'];
		$this->assign("list",$list);
		$this->getNetCpuMemchartData();
		$this->display();
	}
	
	function getChartData(){
		
	}
	
	function showhighchart(){
		$this->display();
	}
	
	function testHightchart(){
		$this->display();
	}
	
	
		
}
