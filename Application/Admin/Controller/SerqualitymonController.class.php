<?php
/**
 * 质量监控-服务质量
 *
 */
class SerqualitymonController extends HostSerqCommonController {
	var $navTab = 'D60701';
	
	// 框架首页
	public function index() {
		$model = CM("Serqualitymon");
		$urlpath = "/service/tree";
		$data = $model->sendHostSerqualitBase($urlpath);
		$treelist = $data['data'];
		
		$this->assign("menu",$treelist);
		$this->display();
	}
	
	//展示服务组列表
	function showQualityTotal() {
		$model = CM("Serqualitymon");
		$urlpath = "/service/errorinfo";
		$result = $model->sendHostSerqualitBase($urlpath);
		$data = $result['data'];
		$this->assign("list",$data);
		$this->display();
	}
	
	//展示服务详细信息
	function showQualityDetail(){
		$model = CM("Serqualitymon");
		$urlpath = "/service/warnings";
		if($_REQUEST['beginTime']){
			$_REQUEST['beginTime'] = date("YmdHis",strtotime($_REQUEST['beginTime']));
		}
		if($_REQUEST['endTime']){
			$_REQUEST['endTime'] = date("YmdHis",strtotime($_REQUEST['endTime']));
		}
		$result = $model->sendHostSerqualitBase($urlpath);
		$data = $result['data'];
		$this->assign("list",$data);
		$this->display();
	}
	
	//展示服务错误弹出框
	function showDetailWindow(){
		$ip = "172.17.3.86";//$_REQUEST['ip'];
		$urlpath = "/service/warning/detail/".$ip."/";
		$model = CM("Serqualitymon");
		$result = $model->sendHostSerqualitBase($urlpath);
		$list = $result['data'];
		$this->assign("list",$list);
		
		$this->getNetCpuMemchartData();
		
		$this->display();
	}
	
	
	
	
	
	
		
}
