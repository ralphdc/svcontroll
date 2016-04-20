<?php
/**
 *
 * 系统流水监控
 *
 */
//use Think\Model;
class WeightServiceModel extends CommonModel {//Model{ //
	
	public $method = array(
			"weightTree"=>"service.weight.tree",
			"weightConproGet"=> "service.weight.conpro.get",
			"weightConproUpdate"=>"service.weight.conpro.update",
			"weightConproDelete"=> "service.weight.conpro.delete",
			"conprobyinstanceGet"=> "service.weight.conprobyinstance.get",
	);
	
	


}