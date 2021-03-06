<?php
/**
 * 服务管制--监控配置管理--实时监控
 * @author zengguangqiu
 *
 */
class RealmonitorController extends CommonController {
	//var $navTab = 'D60609';
	var $navTab = '2c948cfb51ec5db00151ec9344b30023';
	var $redis;
	
// 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$Realmonitor = new RealmonitorModel($_POST,$_GET);
		$result = $Realmonitor->findByPost($_POST,$_GET);
		$count = $Realmonitor->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		//dump($result);
		$this->assign ( 'map', array('service'=>'','level'=>'','startTime'=>'','endTime'=>'') );
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
	/**
	 * 开启或者关闭监控并从频道读取最新的报警信息传递到到前端页面展示
	 */
	function Invokredis(){
		$this->redis=new Redis();
		$RedisServer = C('REDISSERVER');
		$RedisPort = C('REDISSERVER_PORT');
		$this->redis->connect($RedisServer,$RedisPort);
		function fredis($redis, $chan, $msg){
				$response = array();
				$response['msg'] = $msg;
				echo json_encode($response);
				exit;
		}
		$this->redis->subscribe(array('PUB:MONITOR:SEND'), 'fredis');
	}
	
	/**
	 * 监控开关
	 */
	function OnOff(){
		$id = $_POST['id'];
		$str = '02'.$id.$_POST['opty'];
		$post_str = array('pBuffer'=>$str,'iLen'=>strlen($str));
		$Channelswitch = new ChannelswitchModel($_POST,$_GET);
		$ret = $Channelswitch->requestBySoapForMoni('DealCmd',$post_str);
		if($ret == '1'){
			echo 'true';
		}else{
			echo 'false';
		}
		return;
	}
	
}