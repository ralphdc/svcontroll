<?php
/**
 * 按日期统计日志控制器
 * @author zengguangqiu
 *
 */

class ChainCountController extends CommonController {

    // 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		//获取对应的交易调用链的节点相关的数据
		$AnalysisRule = new AnalysisRuleModel($_POST,$_GET);
		$result = $AnalysisRule->getAll($_POST, $_GET);
		$chainnodeArr = array();
		if(is_array($result) && count($result))
		{
			foreach ($result as $rkey=>$rval)
			{
				$chainnodeArr[$rval['node']] = $rval['node'];
			}
		}
		if(empty($_POST['node']))
		{
			$staticsData = array();
		}else
		{
			$ChainCount = new ChainCountModel();
			$staticsData = $ChainCount->findByPost($_POST, $_GET);
		}
		$showdata = 0;
		if(is_array($staticsData) && count($staticsData))
		{
			$showdata = 1;
			$temDataArr = array();
			$temDataArr2 = array();
			$temDataArr3 = array();
			foreach ($staticsData as $key => $val )
			{
				$temDataArr[] = "{$val['date']}";
				$temDataArr1[] = "{$val['min']}";
				$temDataArr2[] = "{$val['avg']}";
				$temDataArr3[] = "{$val['max']}";
			}
			$data =implode(",", $temDataArr);
			cookie('datas',$data,array('expire'=>3600,'prefix'=>'chain_'));
			
			$data1 =implode(",", $temDataArr1);
			cookie('datas1',$data1,array('expire'=>3600,'prefix'=>'chain_'));
			
			$data2 =implode(",", $temDataArr2);
			cookie('datas2',$data2,array('expire'=>3600,'prefix'=>'chain_'));
			
			$data3 =implode(",", $temDataArr3);
			cookie('datas3',$data3,array('expire'=>3600,'prefix'=>'chain_'));
		}
		
		$this->assign("showdata",$showdata);
		$this->assign('dateArr',explode(",", cookie('chain_datas')));
		$this->assign("chainnode",$chainnodeArr);
		$this->assign('map',array('node '=>''));
		$this->display ();
	}
	public function showDateStatics()
	{
		$this->assign('node',$_GET['node']);
		$this->assign('date',$_GET['date']);
		$this->assign('data',cookie('chain_datas'));
		$this->assign('data1',cookie('chain_datas1'));
		$this->assign('data2',cookie('chain_datas2'));
		$this->assign('data3',cookie('chain_datas3'));
		$this->assign('data',cookie('chain_datas'));
		$this->display ();
	}
	
	public function maxMin()
	{

		$ChainCount = new ChainCountModel();
		$_POST['node'] = $_GET['node'];
		$_POST['date'] = $_GET['date'];
		$MaxMinData = $ChainCount->getMaxMin($_POST, $_GET);
		$this->assign('node',$_GET['node']);
		$this->assign('date',$_GET['date']);
		$this->assign('list',$MaxMinData);
		$this->display ();
	}

}