<?php
/**
 * 下载管理控制器
 * @author zengguangqiu
 *
 */
class DownloadController extends CommonController {
    
    //private $host = '127.0.0.1';
    private $navTab = '2c948cfb51ec5db00151ec68aa560013';
    private $host = '172.17.3.153';
    private $port = '6379';
    private $listName = 'downloadmonitor';
    
    
    // 框架首页
	public function index(){
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		if((empty($_POST['start']) && !empty($_POST['end'])))
		{
			$ret = array("statusCode"=>"0","message"=>'开始时间不能为空',"navTabId"=>$this->navTab,//$this->navTab
					"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
			exit(json_encode($ret));
		}
		if((!empty($_POST['start']) && empty($_POST['end'])))
		{
			$ret = array("statusCode"=>"0","message"=>'结束时间不能为空',"navTabId"=>$this->navTab,//$this->navTab
					"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
			exit(json_encode($ret));
		}
		if(!empty($_POST['start']) && !empty($_POST['end']))
		{
			$start =strtotime(trim($_POST['start']).' 00:00:00');
			$end = strtotime(trim($_POST['end']).' 23:59:59');
			$now   = strtotime(date("Y-m-d").' 23:59:59');
			$end = $end > $now ?  $now: $end;
			$days  = ceil(($end - $start)/86400);
			if($start > $end)
			{
				$ret = array("statusCode"=>"0","message"=>'开始时间不能大于结束时间',"navTabId"=>$this->navTab,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				exit(json_encode($ret));
			}elseif($days > 7 )
			{
				$ret = array("statusCode"=>"0","message"=>'查询时间跨度不能超过一周',"navTabId"=>$this->navTab,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				exit(json_encode($ret));
			}
		}
		if(empty($_POST['start']) || empty($_POST['end']))
		{
			$result = array();
		}else 
		{
			$Download = new DownloadModel($_POST,$_GET);
			$result = $Download->webscoketRequest($_POST,$_GET);
		}
		
		$this->assign ( 'list', $result['return'] );
		$this->assign ( 'map', array('start'=>'','end'=>'') );
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
	
	public function startStop()
	{
		$isstart = $_POST['isclose'];
		$startArr = array('1'=>'start','2'=>'stop');
		$_POST['iscloseStr'] = $startArr[$isstart]; 
		$Download = new DownloadModel($_POST,$_GET);
		$result = $Download->startorstopdown($_POST,$_GET);
		if($result['result']['errorCode'] == '00'){
			$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab,//$this->navTab
					"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
			echo json_encode($ret);	return;
		}else{
			if(empty($result['result']['errorDesc']))
			{
				$result['result']['errorDesc'] = "服务未开启";
			}
			$msg = '操作失败，errorDesc：'.$result['result']['errorDesc'];
			$ret = array("statusCode"=>"0","message"=>$msg,"navTabId"=>'',//$this->navTab
					"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
			echo json_encode($ret);	return;
		}
	}
	
	public function throwMqs()
	{
	    
	    $isstart = $_POST['isclose'];
	    $startArr = array('1'=>'start','2'=>'stop');
	    $_POST['iscloseStr'] = $startArr[$isstart];
	    
	     $lcRedis = new Redis();
	     $lcoon = $lcRedis->connect($this->host,$this->port);
	     if($lcoon){
	         //如果能顺利连接本地Redis服务；
	         $DataWareLen = $lcRedis->llen($this->listName);
	         if($DataWareLen){
	             for($wi=0; $wi<$DataWareLen; $wi++){
	                 $lcRedis->rpop($this->listName);
	             }
	         }
	         $DataWareLenNew = $lcRedis->llen($this->listName);
	         if(!$DataWareLenNew){
	             $randm = uniqid();
	             $lcRedis->set('downloadrand',$randm);
	             $_POST['serial'] = $randm;
	             $Download = new DownloadModel($_POST,$_GET);
	             $result = $Download->startStopToggle($_POST,$_GET);
	             
	             $lcRedis->close();
	             
	             if($result){
	                 $ret = array("statusCode"=>$result['pubrt'],"message"=>$result['pubmsg'],"navTabId"=>$this->navTab,//$this->navTab
	                     "rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
	                 echo json_encode($ret);	return;
	             }else{
	                 $ret = array("statusCode"=>'0',"message"=>'发布失败！',"navTabId"=>$this->navTab,//$this->navTab
	                     "rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
	                 echo json_encode($ret);	return;
	             }
	         }
	     }else{
	         //否则返回错误；
	         $ret = array("statusCode"=>"0","message"=>'发布失败，本地Redis服务无法连接！',"navTabId"=>$this->navTab,//$this->navTab
	             "rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
	         echo json_encode($ret);	return;
	     }
	    
	}
	
	Public function getRedisInfo(){
		$this->display();
	}
	
	
	public function checkRedisInfo(){
		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');
		
		$ckRedis = new Redis();
		$ckconn = $ckRedis->connect($this->host,$this->port);
		
		if($ckconn){
		    //取得最新请求的序列号；
		    $randStamp = $ckRedis->get('downloadrand');
		    
		    $lens = $ckRedis->llen($this->listName);
		    $want=array();
		    if($lens){
		        $listContent = $ckRedis->lrange($this->listName,0,-1);
		        foreach ($listContent as $content){
		            $tmp = json_decode($content,true);
		            if($tmp['result']['requestSerial'] == strval($randStamp)){
		                $want['cont'][] = $tmp['result'];
		            }
		        }
		        unset($tmp);
		        $want['numbers']=count($want['cont']);
		        $want['errors']=0;
		        $want = json_encode($want);
		    }
		}else{
		    $want = json_encode(array('errors'=>1,'errmsg'=>'本地Redis连接错误！'));
		}
		
		$ckRedis->close();
		
		echo "data: {$want}\n\n";
		flush();
		
	}

}
