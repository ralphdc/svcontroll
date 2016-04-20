<?php
/**
 * 按日期统计日志控制器
 * @author zengguangqiu
 *
 */
use Think\Cache;

class AlarmDateStatController extends CommonController {

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
		$AlarmDateStat = new AlarmDateStatModel();
		$staticsData = $AlarmDateStat->findByPost($_POST, $_GET);
		$showdata = 0;
		if(is_array($staticsData) && count($staticsData))
		{
			$showdata = 1;
			$temDataArr = array();
			foreach ($staticsData as $key => $val )
			{
				$temDataArr[] = "['{$val['date']}',  {$val['count']}]";
			}
			$data =implode(",", $temDataArr);
			cookie('datas',$data,array('expire'=>3600,'prefix'=>'date_'));
		}
		$this->assign("showdata",$showdata);
		$this->assign('map',array('startTime '=>'','endTime'=>''));
		$this->display ();
	}
	public function showDateStatics()
	{
		$this->assign('data',cookie('date_datas'));
		$this->display ();
	}

}