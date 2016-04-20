<?php
//ini_set('default_socket_timeout', -1); //不超时
//流水质量监控
class SysMonitorController extends CommonController {
	var $navTab = 'L30301';
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
			'RTL_TERMNO'     => array('W'=>100,'T'=>'渠道终端号','C'=>'1'),
			'RTL_DEMO'       => array('W'=>100,'T'=>'渠道应答码','C'=>'1'),
			'RTL_VOUCHNO'    => array('W'=>100,'T'=>'渠道流水号','C'=>'1'),
			'RM_MERCHCODE'   => array('W'=>120,'T'=>'渠道商户号','C'=>'1'),
			'RM_MERCHNAME'   => array('W'=>220,'T'=>'渠道商户名','C'=>'1'),
			'RTL_RECKON'     => array('W'=>100,'T'=>'渠道端清算时间','C'=>'1'),
			'RTL_AUTOID'     => array('W'=>60,'T'=>'渠道ID','C'=>'1'),
	);
	function  Index(){
		$model = CM("SysMonitor");
		$result = $model->sendWatermoniBase('listSetting','');
		if($result['errorCode'] == 0){
			$setRes = $result['data'];
		}
		/////////////////////////////////////////////////
		/*
		$post = array('method' => 'xgd.crm.getTermAppIDInfo');
		
		$rs = $model->sendTermAppIdData($post);
		$apps = array();
		if($rs['rtn'] == 'OK'){
			$apps = $rs['object'];
			foreach($apps as $v){
				$app[$v['appid']] = $v['appname'];
			}
		}
		*/
		/////////////////////////////////////////////////
		$this->assign('appname',$this->appname);
		$this->assign('setRes',$setRes);
		$this->assign('list',$this->list);
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
	
	function InvokRedis(){
		$this->redis=new Redis();
		$RedisServer = C('RedisServer');
		$this->redis->connect($RedisServer,6379);
		function ff($redis, $chan, $msg){
			$trdtype = array(
					'0'  => '签到',
					'1'  => '消费',
					'2'  => '消费冲正',
					'3'  => '消费撤销',
					'4'  => '消费撤销冲正',
					'5'  => '余额查询',
					'a'  => '预授权',
					'A'  => '消费、撤销确认',
					'b'  => '预授权冲正',
					'B'  => 'IC卡公钥/参数下载查询、请求',
					'c'  => '预授权撤销',
					'C'  => 'IC卡公钥/参数圈存冲正',
					'd'  => '预授权撤销冲正',
					'D'  => '批上送',
					'E'  => '脚本结果通知',
					'e'  => '预授权完成(请求)',
					'f'  => '预授权完成(通知)',
					'F'  => '批结算',
					'g'  => '预授权完成冲正',
					'h'  => '预授权完成撤销',
					'i'  => '预授权完成撤销冲正',
					'j'  => '缴费',
					'NULL'  => '未知交易',
					'Q'  => '电子现金圈存',
					'R'  => '电子现金圈存冲正',
					'S'  => '电子现金转账圈存',
					'T'  => '电子现金转账圈存冲正',
					'U'  => '电子现金现金充值',
					'V'  => '电子现金现金充值冲正',
					'W'  => '短信认证确认包0700',
			);
			$row = explode("\x01", $msg);
			$response = array();
			if(empty($row) || $row[0] == '0000'){
				$response = array('id' => '0000');
				echo json_encode($response);
				exit;
			}
			
			$response['id'] = $row[14].$row[29];
			$response['v_ltl_status'] = $row[0];
			$response['ltl_time'] = ($row[1]=='undefine' || $row[1]=='') ? '' : date('Y-m-d H:i:s',strtotime($row[1]));
			$response['ltl_reckon'] = ($row[2]=='undefine' || $row[2]=='') ? '' : date('Y-m-d',strtotime($row[2]));
			$response['ltl_cardno'] = ($row[3]=='undefine' || $row[3]=='') ? '' :'123123';// $db->hideCardNo($row[3],6,4);
			$response['card_type'] = ($row[4]=='undefine' || $row[4]=='') ? '' : $row[4];
			$response['card_name'] = ($row[5]=='undefine' || $row[5]=='') ? '' : $row[5];
			$response['ltl_cardflag'] = ($row[6]=='undefine' || $row[6]=='') ? '' : $row[6];
			$response['rsd_bicc'] = ($row[7]=='undefine' || $row[7]=='') ? '' : $row[7];
			$response['v_ltl_type'] = ($row[8]=='undefine' || $row[8]=='') ? '' : $trdtype[$row[8]];
			$response['ltl_amount'] = ($row[9]=='undefine' || $row[9]=='') ? '' : number_format($row[9]/100,2);
			$response['lm_merchcode'] = ($row[10]=='undefine' || $row[10]=='') ? '' : $row[10];
			$response['lm_merchname'] = ($row[11]=='undefine' || $row[11]=='') ? '' : $row[11];
			$response['ltl_termno'] = ($row[12]=='undefine' || $row[12]=='') ? '' : $row[12];
			$response['ltl_refno'] = ($row[14]=='undefine' || $row[14]=='') ? '' : $row[14];
			$response['ltl_autoid'] = ($row[15]=='undefine' || $row[15]=='') ? '' : $row[15];
			$response['rulename'] = ($row[16]=='undefine' || $row[16]=='') ? '' : $row[16];
			$response['rr_name'] = ($row[17]=='undefine' || $row[17]=='') ? '' : $row[17];
			$response['ltl_msg_status'] = ($row[18]=='undefine' || $row[18]=='') ? '' : $row[18];
			$response['ltl_appid'] = ($row[19]=='undefine' || $row[19]=='') ? '' : $row[19];
			$response['rtl_reckon'] = ($row[20]=='undefine' || $row[20]=='') ? '' : date('Y-m-d',strtotime($row[20]));
			$response['rm_merchcode'] = ($row[21]=='undefine' || $row[21]=='') ? '' : $row[21];
			$response['rm_merchname'] = ($row[22]=='undefine' || $row[22]=='') ? '' : $row[22];
			$response['rtl_termno'] = ($row[23]=='undefine' || $row[23]=='') ? '' : $row[23];
			$response['rtl_autoid'] = ($row[24]=='undefine' || $row[24]=='') ? '' : $row[24];
			$response['rtl_vouchno'] = ($row[26]=='undefine' || $row[26]=='') ? '' : $row[26];
			$response['rtl_demo'] = ($row[27]=='undefine' || $row[27]=='') ? '' : $row[27];
			$response['ltl_vouchno'] = ($row[29]=='undefine' || $row[29]=='') ? '' : $row[29];
			$response['term_ver'] = ($row[32]=='undefine' || $row[32]=='') ? '' : $row[32];
			$response['ltl_demo'] = ($row[13]=='undefine' || $row[13]=='') ? '' : $row[13];
			if($row[38]!='undefine' && $row[38]!=''){
				$response['ltl_demo'] .= $row[38];
			}
			
			echo json_encode($response);
			exit;
		}
		$this->redis->subscribe(array('tradelist'), 'ff');
		
		//$result = '{"id":"171142290230000561","v_ltl_status":"1","ltl_time":"2015-05-28 17:03:36","ltl_reckon":"","ltl_cardno":"123123","card_type":"\u501f\u8bb0\u5361","card_name":"\u6c11\u751f\u94f6\u8054\u501f\u8bb0\u5361\uff0d\u91d1\u5361","ltl_cardflag":"0","rsd_bicc":"0","v_ltl_type":"\u6d88\u8d39","ltl_amount":"0.01","lm_merchcode":"849441359772002","lm_merchname":"\u60e0\u5dde\u5e02\u60e0\u57ce\u533a\u4e1c\u5347\u65ed\u65e5\u5546\u884c","ltl_termno":"84920270","ltl_refno":"171142290230","ltl_autoid":"28684638","rulename":"","rr_name":"\u8fd4\u56de\u53f3\u7aef\u7ec8\u7aef\u53f7","ltl_msg_status":"0","ltl_appid":"1002","rtl_reckon":"2015-12-03","rm_merchcode":"849441359772002","rm_merchname":"\u60e0\u5dde\u5e02\u60e0\u57ce\u533a\u4e1c\u5347\u65ed\u65e5\u5546\u884c","rtl_termno":"84920270","rtl_autoid":"24281767","rtl_vouchno":"290230","rtl_demo":"00","ltl_vouchno":"000561","term_ver":"3104","ltl_demo":"00\u4ea4\u6613\u6210\u529f "}';
		//echo $result;
	}
	
	function Setting(){
		$model = CM("SysMonitor");
		$result = $model->sendWatermoniBase('listSetting','');
		if($result['errorCode'] == 0){
			$setRes = $result['data'];
		}
		$this->assign('setRes',$setRes);
		$this->assign('list',$this->list);
		$this->display();
	}
	
	function Save(){
		$temp = '';
		foreach ($_POST['listSetting'] as $k=>$v){
			$temp .= $v.'|';
		}
		unset($_POST['listSetting']);
		$_POST['listSetting'] = trim($temp,'|');
		$model = CM("SysMonitor");
		$data = $_POST;

		$list = $model->sendWatermoniBase('updateSetting',$data);
		if($list['errorCode'] == 0){
			 $this->success('设置成功!',cookie('_currentUrl_'),true);
		}
		else {
			$this->error('设置失败!');
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
		$result = $model->sendWatermoniBase('strategyCreate',$data);
		if($result['errorCode'] == 0){
			$ret = array("statusCode"=>"1","message"=>'设置成功',"navTabId"=>'strategy',
					"forwardUrl"=>cookie('_currentUrl_'),"callbackType"=>"");
			//$this->success('设置成功!',cookie('_currentUrl_'),true);
			echo json_encode($ret);return;
		}
		else {
			$ret = array("statusCode"=>"0","message"=>$result['errorMessage'],"navTabId"=>'',
					"forwardUrl"=>'',"callbackType"=>"");
			echo json_encode($ret);return;
		}
	}
	
	function delStrategy(){
		$model = CM("SysMonitor");
		$data = $_POST;
		$result = $model->sendWatermoniBase('strategyDelete',$data);
		if($result['errorCode'] == 0){
			$ret = array("statusCode"=>"1","message"=>'删除成功',"navTabId"=>'strategy',
					"forwardUrl"=>cookie('_currentUrl_'),"callbackType"=>"");
			echo json_encode($ret);return;
			//$this->success('删除成功!',cookie('_currentUrl_'),true);
			
		}
		else {
			$this->error('设置失败!');
		}
	}
	
}