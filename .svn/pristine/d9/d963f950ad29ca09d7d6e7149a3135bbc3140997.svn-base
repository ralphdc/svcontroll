<?php
/**
 * 主机事件统计控制器
 * @author zengguangqiu
 *
 */
class HostEventStatController extends CommonController {
	
	//定义消息类型的类全局变量
	var $messageInfoArr = array('FATAL'=>'致命消息','ERROR'=>'错误消息','WARN'=>'警告消息','INFO'=>'普通消息');
	//定义每种错误显示消息的图表的颜色
	var $messagecolorArr = array('FATAL'=>'#FF0000','ERROR'=>'#ff9966','WARN'=>'#FFFF00','INFO'=>'#7cb5ec'); 

    // 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		if((empty($_POST['startTime']) && !empty($_POST['endTime'])))
		{
			$ret = array("statusCode"=>"0","message"=>'开始时间不能为空',"navTabId"=>$this->navTab,//$this->navTab
					"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
			exit(json_encode($ret));
		}
		if((!empty($_POST['startTime']) && empty($_POST['endTime'])))
		{
			$ret = array("statusCode"=>"0","message"=>'结束时间不能为空',"navTabId"=>$this->navTab,//$this->navTab
					"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
			exit(json_encode($ret));
		}
		if(!empty($_POST['startTime']) && !empty($_POST['endTime']))
		{
			$startTime =strtotime(trim($_POST['startTime']).' 00:00:00');
			$endTime = strtotime(trim($_POST['endTime']).' 23:59:59');
			$now   = strtotime(date("Y-m-d").' 23:59:59');
			$endTime = $endTime > $now ?  $now: $endTime;
			$days  = ceil(($endTime - $startTime)/86400);
			if($startTime > $endTime)
			{
				$ret = array("statusCode"=>"0","message"=>'开始时间不能大于结束时间',"navTabId"=>$this->navTab,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				exit(json_encode($ret));
			}elseif($days > 30 )
			{
				$ret = array("statusCode"=>"0","message"=>'查询时间跨度不能超过30天',"navTabId"=>$this->navTab,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				exit(json_encode($ret));
			}
		}
		$HostEventStat = new HostEventStatModel();
		$statics = $HostEventStat->findByPost($_POST, $_GET);
		//$statics = array('0'=>array('level'=>'ERROR','count'=>15),'1'=>array('level'=>'FATAL','count'=>20),'2'=>array('level'=>'WARN','count'=>30),'3'=>array('level'=>'INFO','count'=>2));
		$tempArr = array();
		foreach ($statics as $key=>$val)
		{
			if($val['count'] > 0)
			{
				$tempArr[$val['level']]= $val[count];
			}
		}
		$showPie = 0;
		if(!empty($tempArr))
		{
			$showPic = 1;
			cookie('params',$tempArr,array('expire'=>3600,'prefix'=>'pic_'));
		}
		$this->assign('showPic',$showPic);
		$this->assign('map',array('ip'=>'','startTime'=>'','endTime'=>''));
		$this->display ();
	}
	//显示饼图
	public function showPie()
	{
		$params = cookie('pic_params');
		$dataArr = array();
		if(is_array($params) && count($params))
		{
			foreach ($this->messageInfoArr as $key=>$val)
			{
				$ynums = $params[$key]-0;
				if($ynums > 0)
				{
					$color = $this->messagecolorArr[$key];
					if($key == 'ERROR')
						$dataArr[] = "{name: '$val',color:'$color',y: $ynums, sliced: true,selected: true,}";
					else
						$dataArr[] = "{name: '$val',color:'$color',y: $ynums}";
				}
			}
		}
		$data = implode(',', $dataArr);
		$this->assign('data',$data);
		$this->display ();
	}
	//显示柱状图
	public function showBarchart()
	{
		$params = cookie('pic_params');
		
		$dataArr = array();
		if(is_array($params) && count($params))
		{
			foreach ($this->messageInfoArr as $key=>$val)
			{
				$ynums = $params[$key]-0;
				if($ynums > 0)
				{
					$color = $this->messagecolorArr[$key];
					$dataArr[] = "{name: '$val',color:'$color',y: $ynums,sliced: true}";
				}
			}
		}
		$data = implode(',', $dataArr);
		$this->assign('data',$data);
		$this->display ();
	}

}