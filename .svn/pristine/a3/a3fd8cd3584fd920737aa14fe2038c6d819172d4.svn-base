<?php
/**
 * 日志服务和java通信公共数据接口类子类（最新告警日志）
 * @author zengguangqiu
 *
 */
class LatestWarningLogModel extends CommunicationModel {
	var $method = array(
			'index'=>'xgd.log.monitor.newwarn',
	);
	var $primaryKey = 'seqid';
	var $pareTable = array(
			'getColumns'=>array('seqid','actid','actcode','actname','remark'),
			'conColumns'=>array('actid','actcode','actname','remark'),
	);
	
	public function findByPost($post, $get)
	{
		if(!Empty($post)){
			foreach ($post as $key=>$valus){
				$post[$key]=trim($valus," ");
			}
		}
		$post['method']=$this->method['index'];
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		return $array['rtndata'];
	}
}