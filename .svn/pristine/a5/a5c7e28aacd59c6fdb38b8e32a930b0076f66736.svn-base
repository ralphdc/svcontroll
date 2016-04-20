<?php
/**
 *
 * 系统流水监控
 *
 */
//use Think\Model;
class SysMonitorModel extends CommonModel {//Model{ //
	
	public $tableName = 'SYS_MONITOR_SETTING';
	public $method = array(
			"listSetting"=>"watermoni.setting.list",
			"updateSetting"=>"watermoni.setting.update",
			"strategyList"=>"strategy.setting.list",
			"strategyDelete"=>"strategy.setting.delete",
			"strategyCreate"=>"strategy.setting.create",
			"batchstrategyList"=>"batchstrategy.setting.list",
			"batchstrategyDelete"=>"batchstrategy.setting.delete",
			"batchstrategyCreate"=>"batchstrategy.setting.create",
			"iphost"=>'systemchange.iphost.list',
			"setIp"=>"systemchange.setip.update",
			"setuseable"=>"systemchange.setuseable.update",
			"getuseable"=>"systemchange.setuseable.get",
			"arrange"=>"systemchange.change.arrange",
			
	);
	public $TermAppMethod=array(
			'method' => 'xgd.crm.getTermAppIDInfo',
			);
	
	function sendTermAppIdData($post_string)
	{
		$str = json_encode($post_string);
		Think\Log::write("////////////////////////////// sendTermAppIdData post is ".$str);
		// 		dump($str);
		$context = array(
				'http' => array(
						'method' => 'POST',
						'timeout'=>600,
						'header' =>
						'Content-type: application/x-www-form-urlencoded' .
						'\r\n'.'User-Agent : Jimmy\'s POST Example beta' .
						'\r\n'.'Content-length:' . strlen($str) + 8,
						'content' => 'json='.$str.'&sign='.md5($str),
				)
		);
	
		$stream_context = stream_context_create($context);
		$data = file_get_contents(C('merchantServerName'), false, $stream_context);
		Think\Log::write("file_get_contents data is".$data);
		$data = json_decode($data,true);
		return $data;
	}
	


}