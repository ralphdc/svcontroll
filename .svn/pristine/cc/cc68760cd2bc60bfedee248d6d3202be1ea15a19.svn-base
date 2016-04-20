<?php
/**
 *
 * 对组进行操作；
 * 对接人：李超群   | 唐春苗
 * 2015-11-16
 */
//use Think\Model;
class IceGroupServiceModel extends CommonModel {//Model{ //
	
	public $method = array(
	    
	         // 获取ICE分组信息
			'ice_group_info'         =>  'service.weight.group.search', 
	         //创建ICE新组
			'ice_group_create'       =>  'service.weight.group.create', 
	         //删除ICE组
			'ice_group_delete'       =>  'service.weight.group.delete', 
	         //批量删除ICE组
			'ice_group_delete_batch' =>  'service.weight.groupbatch.delete' 
	);
    
	//给权重服务和ice服务发送消息
	public function sendJavaData($method,$senddata=''){
	    $data = $senddata ;
	    $data['key'] = $this->method[$method];
	    $result = $this->ice_sendmessage($data);
	    return $result;
	
	}
	
	
	
	
	
	
}