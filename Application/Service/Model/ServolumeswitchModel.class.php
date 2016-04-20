<?php
/**
 * 服务管服务和java通信公共数据接口类子类（批量关闭和重启）
 * @author zengguangqiu
 *
 */
class ServolumeswitchModel extends CommunicationModel {
	var $method = array(
			'restartshutdown'=>'dispatch.batchrestart.shutdown',
	);
	
	/**
	 * 批量关闭和重启的接口
	 * @param string $idsArr
	 */
	function restartShutdown($idsArr)
	{
		$post['key']=$this->method['restartshutdown'];
		$post['data'] = $idsArr;
		$post['data']['msgcount'] = trim(count($idsArr));
		$post['data']['person'] = $_SESSION['cUserNo'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}
	
}