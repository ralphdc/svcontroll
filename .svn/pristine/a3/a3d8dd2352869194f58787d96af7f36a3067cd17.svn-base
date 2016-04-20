<?php
//流水质量监控
class SysMonitorController extends CommonController {
	var $navTabId = 'D702';
	var $redis;
	var $appname = '';
	var $list = array(
			'LTL_TIME'       => array('W'=>150,'T'=>'接入端交易时间','C'=>'0'),
			'LTL_TERMNO'     => array('W'=>100,'T'=>'接入终端号','C'=>'0'),
			'TERM_VER'       => array('W'=>80,'T'=>'终端版本号','C'=>'0'),
			'V_LTL_TYPE'     => array('W'=>80,'T'=>'交易类型','C'=>'0'),
			'LTL_AMOUNT'     => array('W'=>80,'T'=>'交易金额','C'=>'0'),
			'V_LTL_STATUS'   => array('W'=>80,'T'=>'交易状态','C'=>'0'),
			'LTL_DEMO'       => array('W'=>180,'T'=>'接入端应答码','C'=>'0'),
			'LTL_CARDNO'     => array('W'=>150,'T'=>'卡号','C'=>'0'),
			'LTL_VOUCHNO'    => array('W'=>100,'T'=>'接入端流水号','C'=>'0'),
			'LM_MERCHCODE'   => array('W'=>120,'T'=>'接入商户号','C'=>'0'),
			'LM_MERCHNAME'   => array('W'=>220,'T'=>'接入商户名','C'=>'0'),
			'LTL_RECKON'     => array('W'=>100,'T'=>'接入端清算时间','C'=>'0'),
			'LTL_AUTOID'     => array('W'=>80,'T'=>'接入端流水ID','C'=>'0'),
			'RR_NAME'        => array('W'=>250,'T'=>'路由规则名','C'=>'1'),
			'CARD_NAME'      => array('W'=>150,'T'=>'卡名称','C'=>'0'),
			'CARD_TYPE'      => array('W'=>60,'T'=>'卡类型','C'=>'0'),
			'LTL_CARDFLAG'   => array('W'=>60,'T'=>'是否外卡','C'=>'0'),
			'LTL_MSG_STATUS' => array('W'=>60,'T'=>'短信认证','C'=>'1'),
			'RULENAME'       => array('W'=>150,'T'=>'风控规则名','C'=>'1'),
			'LTL_APPID'      => array('W'=>120,'T'=>'应用ID','C'=>'0'),
			'LTL_REFNO'      => array('W'=>100,'T'=>'系统参考号','C'=>'0'),
			'RSD_BICC'       => array('W'=>60,'T'=>'是否IC卡','C'=>'0'),
			'RTL_TERMNO'     => array('W'=>100,'T'=>'渠道终端号','C'=>'0'),//'C'=>'1'
			'RTL_DEMO'       => array('W'=>100,'T'=>'渠道应答码','C'=>'0'),//'C'=>'1'
			'RTL_VOUCHNO'    => array('W'=>100,'T'=>'渠道流水号','C'=>'0'),//'C'=>'1'
			'RM_MERCHCODE'   => array('W'=>120,'T'=>'渠道商户号','C'=>'0'),//'C'=>'1'
			'RM_MERCHNAME'   => array('W'=>220,'T'=>'渠道商户名','C'=>'0'),//'C'=>'1'
			'RTL_RECKON'     => array('W'=>100,'T'=>'渠道端清算时间','C'=>'0'),//'C'=>'1'
			//'RTL_AUTOID'     => array('W'=>60,'T'=>'渠道自增ID','C'=>'0'),//'C'=>'1'
			'CHANNELId'      => array('W'=>60,'T'=>'渠道ID新','C'=>'0'),//'C'=>'1'
			'ISSUEBANK'      => array('W'=>60,'T'=>'发卡行','C'=>'0'),//'C'=>'1'
	);
	
	var $PageSize = 11;
	var $pageNumShown = 5;
	
	function index(){
		$model = CM("SysMonitor");
		$result = $model->sendWatermoniBase('listSetting','');
		if($result['errorCode'] == 0){
			$setRes = $result['data'];
		}
		$this->assign('appname',$this->appname);
		$this->assign('setRes',$setRes);
		$this->assign('list',$this->list);
		//cookie('_currentUrl_', __SELF__);

		$this->display();
	}
	
	function showStrategy(){
		$model = CM("SysMonitor");
		$result = $model->sendWatermoniBase('listSetting','');
		if($result['errorCode'] == 0){
			$setRes = $result['data'];
		}
		$this->assign('appname',$this->appname);
		$this->assign('setRes',$setRes);
		$this->assign('list',$this->list);
		$this->display();
	} 
	
	
	function setting(){
		$model = CM("SysMonitor");
		$result = $model->sendWatermoniBase('listSetting','');
		if($result['errorCode'] == 0){
			$setRes = $result['data'];
		}
		
		$this->assign('setRes',$setRes);
		$this->assign('list',$this->list);
		$this->display();
	}
	
	function save(){
		$temp = '';
		foreach ($_POST['listSetting'] as $k=>$v){
			$temp .= $v.'|';
		}
		unset($_POST['listSetting']);
		$_POST['listSetting'] = trim($temp,'|');
		$model = CM("SysMonitor");
		$data = $_POST;

		$list = $model->sendWatermoniBase('updateSetting',$data);
		if($list['errorCode'] === 0){
			$ret = array("statusCode"=>"1","message"=>'设置成功',"navTabId"=>$this->navTabId,
					"forwardUrl"=>'',"callbackType"=>"");///index.php?s=/Admin/SysMonitor/
			echo json_encode($ret);return;
		}
		else {
			$ret = array("statusCode"=>"0","message"=>$list['errorMessage'],"navTabId"=>$this->navTabId,
					"forwardUrl"=>'',"callbackType"=>"");///index.php?s=/Admin/SysMonitor/
			echo json_encode($ret);return;
		}

	}
	
	function strategy(){
		$model = CM("SysMonitor");
		$strategyList = $model->sendWatermoniBase('strategyList','');
		if($strategyList['errorCode'] == 0){
			$list = $strategyList['data'];
		}
		$this->assign("list",$list);
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
	
	function saveStrategy(){
		$model = CM("SysMonitor");
		$data = $_POST;
		//判断策略名
		$ret1 = preg_match("/&/",$_POST['strategy_name'],$matches1);
		$ret2 = preg_match("/%/",$_POST['strategy_name'],$matches2);
		if(!empty($matches1)){
			$ret = array("statusCode"=>"0","message"=>'策略名不能包含&特殊字符',"navTabId"=>'strategy',//
					"forwardUrl"=>'',"callbackType"=>"");
			echo json_encode($ret);return;
		}
		if(!empty($matches2)){
			$ret = array("statusCode"=>"0","message"=>'策略名不能包含%特殊字符',"navTabId"=>'strategy',//
					"forwardUrl"=>'',"callbackType"=>"");
			echo json_encode($ret);return;
		}
		//发卡行判断
		$issuebank = $_POST['issuebank'];
		$pos = strpos($issuebank,"，");
		if($pos>0){
			$ret = array("statusCode"=>"0","message"=>'发卡行格式格式有误，各发卡行请用英文分号隔开',"navTabId"=>'strategy',//
					"forwardUrl"=>'',"callbackType"=>"");
			echo json_encode($ret);return;
		}
		//返回码判断
		$returnCode = $_POST['returnCode'];
		$pos = strpos($returnCode,"，");
		if($pos>0){
			$ret = array("statusCode"=>"0","message"=>'返回码格式格式有误，多个返回码请用英文分号隔开',"navTabId"=>'strategy',//
					"forwardUrl"=>'',"callbackType"=>"");
			echo json_encode($ret);return;
		}
		//不等于的返回码判断
		$rtncode_notinclude = $_POST['rtncode_notinclude'];
		$pos = strpos($rtncode_notinclude,"，");
		if($pos>0){
			$ret = array("statusCode"=>"0","message"=>'不等于的返回码格式格式有误，多个返回码请用英文分号隔开',"navTabId"=>'strategy',//
					"forwardUrl"=>'',"callbackType"=>"");
			echo json_encode($ret);return;
		}
		
		$result = $model->sendWatermoniBase('strategyCreate',$data);
		if($result['errorCode'] === 0){
			$ret = array("statusCode"=>"1","message"=>'设置成功',"navTabId"=>'strategy',
					"forwardUrl"=>cookie('_currentUrl_'),"callbackType"=>"");
			echo json_encode($ret);return;
		}
		else {
			$ret = array("statusCode"=>"0","message"=>$result['errorMessage'],"navTabId"=>'strategy',
					"forwardUrl"=>'',"callbackType"=>"");
			echo json_encode($ret);return;
		}
	}
	
	function delStrategy(){
		$model = CM("SysMonitor");
		$data = $_REQUEST;
		$result = $model->sendWatermoniBase('strategyDelete',$data);
		if($result['errorCode'] === 0){
			$ret = array("statusCode"=>"1","message"=>'删除成功',"navTabId"=>'strategy',
					"forwardUrl"=>cookie('_currentUrl_'),"callbackType"=>"");
			echo json_encode($ret);return;
			
		}
		else {
			$ret = array("statusCode"=>"0","message"=>$result['errorMessage'],"navTabId"=>'strategy',
					"forwardUrl"=>cookie('_currentUrl_'),"callbackType"=>"");
			echo json_encode($ret);return;
		}
	}
	
	function strategyBat(){//批量策略设置
		$model = CM("SysMonitor");
		$strategyList = $model->sendWatermoniBase('batchstrategyList','');
		if($strategyList['errorCode'] == 0){
			$list = $strategyList['data'];
		}
		$this->assign("list",$list);
		$this->display();
	}
	
	function saveStrategyBat(){
		$StrategyBat = $_POST['batchmerSetting'];
		$StrategyBatArr = explode(";", $StrategyBat);
		foreach($StrategyBatArr as $k=>$v){
			if(strlen(trim($v))>23){//长度不能超过23
				$ret = array("statusCode"=>"0","message"=>'格式有误，各商户间请用英文分号隔开',"navTabId"=>'strategybat',//
						"forwardUrl"=>'',"callbackType"=>"");
				echo json_encode($ret);return;
			}
		}
		
		$model = CM("SysMonitor");
		$data = $_POST;
		$result = $model->sendWatermoniBase('batchstrategyCreate',$data);
		if($result['errorCode'] === 0){
			$ret = array("statusCode"=>"1","message"=>'设置成功',"navTabId"=>'strategybat',
					"forwardUrl"=>'',"callbackType"=>"");
			echo json_encode($ret);return;
		}else {
			$ret = array("statusCode"=>"0","message"=>$result['errorMessage'],"navTabId"=>'strategybat',//
					"forwardUrl"=>'',"callbackType"=>"");
			echo json_encode($ret);return;
		}
	}
	
	function delStrategyBat(){
		$model = CM("SysMonitor");
		$data = $_POST;
		$result = $model->sendWatermoniBase('batchstrategyDelete',$data);
		if($result['errorCode'] === 0){
			$ret = array("statusCode"=>"1","message"=>'删除成功',"navTabId"=>'strategybat',
					"forwardUrl"=>'',"callbackType"=>"");
			echo json_encode($ret);return;
		}else{
			$ret = array("statusCode"=>"0","message"=>$result['errorMessage'],"navTabId"=>'strategybat',
					"forwardUrl"=>'',"callbackType"=>"");
			echo json_encode($ret);return;
		}
	}
	
	//监控页面
	function showStrategyBat(){
		$model = CM("SysMonitor");
		$result = $model->sendWatermoniBase('listSetting','');
		if($result['errorCode'] == 0){
			$setRes = $result['data'];
		}
		$this->assign('appname',$this->appname);
		$this->assign('setRes',$setRes);
		$this->assign('list',$this->list);
		$this->display();
	}
	
	//查看当前系统
	function showVers(){
		$model = CM("SysMonitor");
		$data['cmdarg'] = "1";
		$result = $model->sendWatermoniBase('arrange',$data);
		$vers = $result['data'];
		if($result['errorCode'] === 0){
			$ret = array("statusCode"=>"1","message"=>"版本号为:".$vers,"navTabId"=>'show',
					"forwardUrl"=>'',"callbackType"=>"");
		}else{//
			$ret = array("statusCode"=>"0","message"=>$result['errorMessage'],"navTabId"=>'',
					"forwardUrl"=>'',"callbackType"=>"");
		}
		echo json_encode($ret);return;
		
	}
	
	function toggle(){
		$model = CM("SysMonitor");
		$data['cmdarg'] = "2";
		$result = $model->sendWatermoniBase('arrange',$data);
		if($result['errorCode'] === 0){
			$ret = array("statusCode"=>"1","message"=>$result['data'],"navTabId"=>'toggle',
				         "forwardUrl"=>'',"callbackType"=>"");
		}else{//
			$ret = array("statusCode"=>"0","message"=>$result['errorMessage'],"navTabId"=>'',
					"forwardUrl"=>'',"callbackType"=>"");
		}
		echo json_encode($ret);return;
	}
	
	function showIp(){
		$model = CM("SysMonitor");
		$page = array();
		$page['pageNo'] = $_REQUEST['pageNum']?$_REQUEST['pageNum']:1;
		$page['pageSize'] = $this->PageSize;
		$_REQUEST['page'] = $page;
		$_REQUEST['selected'] = 1;
		$result = $model->sendWatermoniBase('iphost',$_REQUEST);
		if($result['errorCode'] == 0){
			$setRes = $result['data'];
		}
		$this->assign('list',$setRes);
		
		$this->assign('totalCount',$result['total']);
		$this->assign('numPerPage',$result['totalPage']);
		$this->assign('currentPage',$page['pageNo']);
		$this->assign('pageSize',$page['pageSize']);
		//////////////////////////////////
		$result = $model->sendWatermoniBase('getuseable','');
		if($result['errorCode'] == 0){
			$useable = $result['data'];
		}
		$this->assign('useable',$useable);
		//////////////////////////////////
		$this->display();
	}

	function showIplist(){
		$model = CM("SysMonitor");
		$page = array();
		$page['pageNo'] = $_REQUEST['pageNum']?$_REQUEST['pageNum']:1;
		$page['pageSize'] = $this->PageSize;
		$_REQUEST['page'] = $page;
		$result = $model->sendWatermoniBase('iphost',$_REQUEST);
		if($result['errorCode'] == 0){
			$setRes = $result['data'];
		}
		$this->assign('list',$setRes);
		$this->assign('totalCount',$result['total']);
		$this->assign('numPerPage',$result['totalPage']);
		$this->assign('currentPage',$page['pageNo']);
		$this->assign('pageSize',$page['pageSize']);
		
		$this->display();
	}
	
	
	
	function setIp(){
		$model = CM("SysMonitor");
		$result = $model->sendWatermoniBase('setIp',$_REQUEST);
		if($result['errorCode'] === 0){
			$ret = array("statusCode"=>"1","message"=>'设置成功',"navTabId"=>'D60614',
					"forwardUrl"=>'',"callbackType"=>"");
			echo json_encode($ret);return;
		}else{//
			$ret = array("statusCode"=>"0","message"=>$result['errorMessage'],"navTabId"=>'',
					"forwardUrl"=>'',"callbackType"=>"");
			echo json_encode($ret);return;
		}
	}
	
	function setUseable(){
		$model = CM("SysMonitor");
		$result = $model->sendWatermoniBase('setuseable',$_REQUEST);
		if($result['errorCode'] === 0){
			$ret = array("statusCode"=>"1","message"=>'设置成功',"navTabId"=>'',
					"forwardUrl"=>'',"callbackType"=>"");
			echo json_encode($ret);return;
		}else{//
			$ret = array("statusCode"=>"0","message"=>$result['errorMessage'],"navTabId"=>'',
					"forwardUrl"=>'',"callbackType"=>"");
			echo json_encode($ret);return;
		}
	}
	
}