<?php
/**
 * 实时监控总数控制器
 * @author zengguangqiu
 *
 */
class RealTimeDetectionController extends CommonController {

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
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$_POST['lastsrc'] = cookie('_lastsrc_');
		$RealTimeDetection = new RealTimeDetectionModel($_POST,$_GET);
		$result = $RealTimeDetection->findByPost($_POST,$_GET);
		$count = $RealTimeDetection->countByPost($_POST,$_GET);
		$num = count($result);
		$lastsrc = $result[$num-1]['srv'];
		if($lastsrc)
		{
			cookie('_lastsrc_', $lastsrc);
		}
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		$this->assign ( 'map', array('srv'=>'','start'=>'','end'=>'') );
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}

}