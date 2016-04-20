<?php
include './Application/Admin/Conf/config.php';
ini_set('default_socket_timeout',25);
function func($redis, $chan, $msg){
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
	$response['ltl_cardno'] = ($row[3]=='undefine' || $row[3]=='') ? '' :hideCardNo($row[3],6,4);
	$response['card_type'] = ($row[4]=='undefine' || $row[4]=='') ? '' : $row[4];
	$response['card_name'] = ($row[5]=='undefine' || $row[5]=='') ? '' : $row[5];
	$response['ltl_cardflag'] = ($row[6]=='undefine' || $row[6]=='') ? '' : $row[6];
	$response['rsd_bicc'] = ($row[7]=='undefine' || $row[7]=='') ? '' : $row[7];
	$response['v_ltl_type'] = ($row[8]=='undefine' || $row[8]=='') ? '' : $trdtype[$row[8]];
	$response['ltl_amount'] = ($row[9]=='undefine' || $row[9]=='') ? '' : number_format($row[9]/100,2);
	$response['lm_merchcode'] = ($row[10]=='undefine' || $row[10]=='') ? '' :trim($row[10]);
	$response['lm_merchname'] = ($row[11]=='undefine' || $row[11]=='') ? '' : $row[11];
	$response['ltl_termno'] = ($row[12]=='undefine' || $row[12]=='') ? '' : trim($row[12]);
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
	$response['rtl_demo'] = ($row[27]=='undefine' || $row[27]=='') ? '' : trim($row[27]);
	$response['ltl_vouchno'] = ($row[29]=='undefine' || $row[29]=='') ? '' : $row[29];
	$response['term_ver'] = ($row[32]=='undefine' || $row[32]=='') ? '' : $row[32];
	$response['ltl_demo'] = ($row[13]=='undefine' || $row[13]=='') ? '' : $row[13];
	if($row[38]!='undefine' && $row[38]!=''){
		$response['ltl_demo'] .= $row[38];
	}
	//////////////////////////////新增////////////////////////////////////////////////
	$response['CHANNELId'] = ($row[30]=='undefine' || $row[30]=='') ? '' : trim($row[30]);//渠道ID
	if(!empty($row[39])){
		$response['ISSUEBANK'] = ($row[39]=='undefine' || $row[39]=='') ? '' : trim($row[39]);//发卡行
	}else{
		$response['ISSUEBANK'] = '';
	}
	echo json_encode($response);
	exit;
}
/**
 * 隐藏卡号
 */
function hideCardNo($cardno,$showstart=5,$showend=5){
	return substr($cardno,0,$showstart) . str_repeat('*',strlen($cardno)-$showstart-$showend) . substr($cardno, -$showend);
}
$redis=new Redis();
$RedisServer =$GLOBALS['RedisServerConf'];//'172.20.4.20';//C('RedisServer');
$RedisServerPort = $GLOBALS['RedisServerPort'];
$redis->pconnect($RedisServer,$RedisServerPort);
$redis->subscribe(array('tradelist'), 'func');
?>