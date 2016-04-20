<?php
use Think\Model;

// 节点模型
class ServgovernModel extends CommonModel{// 
  /*  
   protected $_validate	=	array(
       array('TMK_TEMP','require','分量必须！'),
        );
  	//插入时字段要检测，以防被oracle过滤掉
	public $fields = array( 'SID', 'MERNO','TERMNO','TMKINDEX','TMKLEN','TMK','TMK2','ZMKINDEX','ZMKLEN','PINKLEN','PINK','MACKLEN','MACK','TRACKLEN','TRACK','ISUSE','HSMID','ADDPERSON','ADDDATE','HSM_ID' );
	//主键
	protected $pk = 'groupId';
	// 自动填充设置
	protected $_auto	 =	 array(
		//array('SID','createGuid',self::MODEL_INSERT,'callback','1'),
		//array('TMK','createGuid',self::MODEL_INSERT,'callback','1'),
	);
	*/
	//调用java的接口函数
	public $method=array(
			'gettree'	   =>'admin.show.tree',
			'addGroup'     =>'admin.group.create',//一级group
			'addtype'      =>'admin.type.create',//二级type
			'addinstance'  =>'admin.instance.create',//三级instance
			'addprovide'   =>'admin.provide.create',//四级添加暴露服务
			'subscribe'	   =>'admin.subscribe.server.create',//订阅服务admin.subscribe.server.create
			'getprovidelist'   =>'admin.biztype.instance.list',//下拉框，业务类型
			'showbiztype'  =>'admin.biztype.list',//显示可以订阅的服务类型
			'showsubscribes'=>'admin.biztype.instance.list',//显示已经订阅的服务
			'showbiztypelist'=>'admin.biztype.provide.list',
			'showbiztypeprovide'=>'admin.provide.get',//点击服务显示对应内容
			'updateExposeService'=>'admin.provide.update',//修改暴露服务 
			'getprovide'   =>'admin.provide.instanceid.list',//显示已添加的暴露服务列表
			'delmachine' =>'admin.instance.delete',//删除机器（实例）
			'deleteprovide'=>'admin.provide.delete',//删除暴露服务
			'deleteSubscibers'=>'admin.subscriberef.delete',//删除订阅服务
			
			'getgroup'=> 'admin.group.get',//得到组名
			'gettype'=> 'admin.type.get',//得到类型名
			'getinstance'=> 'admin.instance.get',//得到实例名
			
			'updategroup'=> 'admin.group.update',//修改组名
			'updatetype'=> 'admin.type.update',//修改类型名
			'updateinstance'=> 'admin.instance.update',//修改实例名
			'updateprovide'=> 'admin.provide.update',//修改暴露服务名
			
			'getServerType'=>'admin.servertype.all.list',//订阅服务页面得到服务类型下拉框
					
			'checkmachinename'=>'admin.machinename.repeat.get',
			'stopPLService'=>'admin.machinename.repeat.test',//一键停止服务
			
			'copyInstance'=>'admin.serverinstance.copy',//复制服务实例
			'batUpdate'=>'admin.providecondition.update',//批量修改配置参数
			'delServiceGroup' =>'admin.group.delete',//删除组
			'delServiceType' => 'admin.type.delete',//删除服务类型
	);
	
	public $tradeMethod = array(
			'getAppid' 		=> 'getAppId',
			'addMachine' 	=> 'addMachine',
			'addExposeService'=>'addExposeService',
			'addSubscibers'=> 'addSubscibers',
			'updateExposeService'=>'updateExposeService',
			'getSubscriberProviders'=>'getSubscriberProviders',
			'deleteMachine'=>'deleteMachine',//删除机器（实例）
			'deleteExposeService'=>'deleteExposeService',//删除暴露服务
			'deleteSubscibers'=>'deleteSubscibers',//删除订阅服务
			
			'stopPLService'=>'stopPLService',//一键停止服务
			'copyInstance'=>'copyAppMachine',//一键复制
			'batUpdate'=>'batchModifyExtendParas',//一键修改配置文件
			'showInstanceStatus'=>'getAppMachineStatusInfo',//查看实例运行状态
			'getExposeServiceStatusInfo'=> 'getExposeServiceStatusInfo',//查看服务运行状态
			'getPullServiceInfoByBizType'=>'getPullServiceInfoByBizType',//查看服务详情
			'autoUpgradeAppById'=>'autoUpgradeAppById',//一键灰度升级
			'autoRecoverAppById'=>'autoRecoverAppById',//一键恢复
			
	);
	
	protected  $valueToAliases = array('status','type');
	protected $status = array('1'=>'启用','2'=>'禁用');
	

   
    
}