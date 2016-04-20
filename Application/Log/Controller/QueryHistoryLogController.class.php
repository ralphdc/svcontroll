<?php
/**
 * 日志历史查询控制器
 * @author zengguangqiu
 *
 */
class QueryHistoryLogController extends CommonController {
	var $navTab = 'L30601';
	//用全局数组保存所有的字段和显示的汉字名字
	 var $listArr = array(
			'id'=>'编号',
			'logTime'=>'发生时间',
			'serviceType'=>'服务类型',
			'service'=>'服务',
			'ip'=>'发生地址',
			'level'=>'日志等级',
			'head'=>'head头',
			'msg'=>'信息',
			'baseTime'=>'入库时间',/* 
			'cpu'=>'CPU(%)',
			'memory'=>'内存(%)',  */
			'chainId'=>'查看调用链',
	);
	/* var $listArr = array(
			'id'=>'编号',
			'cid'=>'调用链',
			'srv'=>'服务名',
			'lvl'=>'等级',
			'msg'=>'信息',
			'rel'=>' 调用关系',
			'fn'=>'方法名称',
			'mn'=>'商户名',
			'ltime'=>'记录时间',
			'mno'=>'商户号',
			'bt'=>'任务名称',
			'fid'=>'流程实例',
			'act'=>'动作',
			'ft'=>'流程名',
			'ip'=>'发生地址',
			'level'=>'日志等级',
			'head'=>'head头',
			'msg'=>'信息',
			'baseTime'=>'入库时间',
			'cpu'=>'CPU(%)',
	'memory'=>'内存(%)', 
			'chainId'=>'查看调用链',
	); */
	
	//设置增加条件的数组
	var $searchArr = array(
			'zdh'=>'终端号',
			'jylx'=>'交易类型',
			'lsh'=>'流水号',
			'jyzt'=>'交易状态',
			'card'=>'卡号',
			'dbhs'=>'单笔耗时',
			'jyls'=>'交易流水',
			'account'=>'账单号',
			'cfbid'=>'拆分表ID',
			'dzjyls'=>'对账交易流水'
	);
    // 框架首页
	public function index() {
		set_time_limit(600);
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
		$showContent = 0;
		if(empty($_POST['ip']) && empty($_POST['msg']) && empty($_POST['startTime']) && empty($_POST['endTime']) && empty($_POST['service']) && empty($_POST['level'])&& empty($_POST['memory'])&& empty($_POST['cpu']))
		{
			$showContent = 2;
			$this->assign ( 'showContent', $showContent);
		}
		if($_POST['_sort']=='desc' || $_POST['_sort']=='')
		{
			$_POST['order'] = 1;
			$_REQUEST['order'] = 1;
		}else
		{
			$_POST['order'] = 0;
			$_REQUEST['order'] = 0;
		}
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$QueryHistoryLog = new QueryHistoryLogModel($_POST,$_GET);
		$result = $QueryHistoryLog->findByPost($_POST,$_GET);
		$count =  $QueryHistoryLog->countByPost($_POST,$_GET); 
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		$loglevel = array(''=>'全部','WARN'=>'警告','ERROR'=>'错误','FATAL'=>'紧急','INFO'=>'普通','XGD'=>'XGD');
		$this->assign('level',$loglevel);
		
		//设置显示字段的数组
		$listArr = $this->listArr;
		$listtrueArr = json_decode(cookie('list_params'));
		if(is_array($listtrueArr) && count($listtrueArr))
		{
			foreach ($listtrueArr as $key=>$val)
			{
				$templistArr[$val] = $listArr[$val];
			}
		}else
		{
			$templistArr = $listArr;
		}
		$this->assign('showlist',$templistArr);
		
		//设置查询字段的数组
		$slistArr = $this->searchArr;
		$slisttrueArr = array();
		$tempsmapArr = array();
		if(cookie('searchlist_params'))
		{
			$slisttrueArr = json_decode(cookie('searchlist_params'));
		}
		if(is_array($slisttrueArr) && count($slisttrueArr))
		{
			foreach ($slisttrueArr as $key=>$val)
			{
				$tempslistArr[$val] = $slistArr[$val];
				$tempsmapArr[$key] = '';
			}
		}else
		{
			$tempslistArr = array();
		}
		$this->assign('searchlist',$tempslistArr);
		$mapArr = array(/* 'service'=>'', ,'msg'=>''*/'level'=>'','startTime'=>'','endTime'=>'','elapse'=>'','memory'=>'','cpu'=>'');
		if(is_array($tempsmapArr) && count($tempsmapArr))
			$mapArr = array_merge($mapArr,$tempsmapArr);
		$this->assign ( 'map', $mapArr);
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
	
	function setrecord()
	{
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
	
			}
			//组织要保存的数据,暂时用cookie保存对应的数据信息
			$listArr = $_POST['items'];
			if(empty($listArr) && count($listArr) == 0)
			{
				$ret = array("statusCode"=>"0","message"=>"至少要选择一个字段","navTabId"=>'',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}
			$listJsonStr = json_encode($listArr);
			cookie('params',$listJsonStr,array('expire'=>0,'prefix'=>'list_'));
			$result = '';
			if(cookie('list_params'))
			{
				$result = 'OK';
			}
			if($result == "OK"){
				$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}else{
				$ret = array("statusCode"=>"0","message"=>"操作失败","navTabId"=>'',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}
		}
		$list_params = json_decode(cookie('list_params'));
		if(empty($list_params))
		{
			$list_params = array('id','logTime','serviceType','service','ip','level','head','msg','baseTime','cpu','memory','chainId');
		}
		$this->assign("list_params",$list_params);
		$this->assign("list",$this->listArr);
		$this->display();
		
	}
	function addsearch()
	{
		if($_POST){
			$request = array();
			foreach($_POST as $k =>$v){
				$request[$k] = $v;
	
			}
		//组织要保存的数据,暂时用cookie保存对应的数据信息
			$listArr = $_POST['items'];
			if(empty($listArr) && count($listArr) == 0)
			{
				cookie('searchlist_params',null);
				$result = 'OK';
			}else
			{
				$listJsonStr = json_encode($listArr);
				cookie('params',$listJsonStr,array('expire'=>0,'prefix'=>'searchlist_'));
				$result = '';
				if(cookie('searchlist_params'))
				{
					$result = 'OK';
				}
			}
			if($result == "OK"){
				$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab,//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}else{
				$ret = array("statusCode"=>"0","message"=>"操作失败","navTabId"=>'',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
			}
		}
		$list_params =array();
		if(cookie('searchlist_params'))
			$list_params = json_decode(cookie('searchlist_params'));
		$this->assign("list_params",$list_params);
		$this->assign('list',$this->searchArr);
		$this->display();
	}
	/**
	 * 显示查询的日志的信息
	 */
	function showinfo()
	{
		$id = $_GET['id'];
		$type = $_GET['type'];
		$ltype = $_GET['ltype'];
		if($type == 1)
		{
			$this->assign('id',$id);
			$this->assign('type',$type);
			$this->assign('ltype',$ltype);
		}else
		{
			$QueryHistoryLog = new QueryHistoryLogModel($_POST,$_GET);
			$result = $QueryHistoryLog->getMsgInfo($id,$type);
			$this->assign('info',$result);
		}
		$this->display();
	}
	
	/**
	 * 导出excell
	 */
	function exportexcell()
	{
		set_time_limit(0);
		$param = json_decode(base64_decode($_GET['param']),true);
		$filename = '日志历史查询';
		//取出所有符合条件的数据
		$QueryHistoryLog = new QueryHistoryLogModel($param,$_GET);
		$OrdersData = $QueryHistoryLog->findAllByPost($param,$_GET);
		// P($OrdersData);
		// exit;
		Vendor( 'PHPExcel.PHPExcel' );
		Vendor( 'PHPExcel.PHPExcel.IOFactory' );
		Vendor( 'PHPExcel.PHPExcel.Reader.Excel5' );
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		// Set properties
		$objPHPExcel->getProperties ()->setCreator ( "ctos" )->setLastModifiedBy ( "ctos" )->setTitle ( "Office 2007 XLSX Test Document" )->setSubject ( "Office 2007 XLSX Test Document" )->setDescription ( "Test document for Office 2007 XLSX, generated using PHP classes." )->setKeywords ( "office 2007 openxml php" )->setCategory ( "Test result file" );
		
		// set width
		$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'A' )->setWidth ( 8 );
		$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'B' )->setWidth ( 20 );
		$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'C' )->setWidth ( 20 );
		$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'D' )->setWidth ( 20 );
		$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'E' )->setWidth ( 20 );
		$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'F' )->setWidth ( 20 );
		$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'G' )->setWidth ( 80 );
		$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'H' )->setWidth ( 20 );
		$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'I' )->setWidth ( 20 );
		$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'J' )->setWidth ( 20 );
		
		// 设置行高度
		$objPHPExcel->getActiveSheet ()->getRowDimension ( '1' )->setRowHeight ( 22 );
		
		$objPHPExcel->getActiveSheet ()->getRowDimension ( '2' )->setRowHeight ( 20 );
		
		// set font size bold
		$objPHPExcel->getActiveSheet ()->getDefaultStyle ()->getFont ()->setSize ( 10 );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A2:J2' )->getFont ()->setBold ( true );
		
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A2:J2' )->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A2:J2' )->getBorders ()->getAllBorders ()->setBorderStyle ( PHPExcel_Style_Border::BORDER_THIN );
		
		// 设置水平居中
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A1' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_LEFT );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'B' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'C' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'D' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'E' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'F' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'G' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'H' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'I' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'J' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		
		//
		$objPHPExcel->getActiveSheet ()->mergeCells ( 'A1:N1' );
		
		// set table header content
		$objPHPExcel->setActiveSheetIndex ( 0 )
		->setCellValue ( 'A1', $filename . '记录  时间:' . date ( 'Y-m-d H:i:s' ) )
		->setCellValue ( 'A2', '编号' )
		->setCellValue ( 'B2', '发生时间' )
		->setCellValue ( 'C2', '服务类型' )
		->setCellValue ( 'D2', '服务' )
		->setCellValue ( 'E2', '发生IP地址' )
		->setCellValue ( 'F2', '日志等级' )
		->setCellValue ( 'G2', '信息' )
		->setCellValue ( 'H2', '入库时间' )
		->setCellValue ( 'I2', 'CPU(%)' )
		->setCellValue ( 'J2', '内存(%)' );
		
		// Miscellaneous glyphs, UTF-8
		for($i = 0; $i <= count ( $OrdersData ) - 1; $i ++) {
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'A' . ($i + 3), $i + 1 );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'B' . ($i + 3), $OrdersData [$i] ['logTime'] );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'C' . ($i + 3), $OrdersData [$i] ['serviceType'] );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'D' . ($i + 3), $OrdersData [$i] ['service'] );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'E' . ($i + 3), $OrdersData [$i] ['ip'] );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'F' . ($i + 3), $OrdersData [$i] ['level'] );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'G' . ($i + 3), $OrdersData [$i] ['msg'] );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'H' . ($i + 3), $OrdersData [$i] ['baseTime'] );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'I' . ($i + 3), $OrdersData [$i] ['cpu'] );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'J' . ($i + 3), $OrdersData [$i] ['memory'] );
			$objPHPExcel->getActiveSheet ()->getStyle ( 'A' . ($i + 3) . ':J' . ($i + 3) )->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
			$objPHPExcel->getActiveSheet ()->getStyle ( 'A' . ($i + 3) . ':J' . ($i + 3) )->getBorders ()->getAllBorders ()->setBorderStyle ( PHPExcel_Style_Border::BORDER_THIN );
			$objPHPExcel->getActiveSheet ()->getRowDimension ( $i + 3 )->setRowHeight ( 16 );
		}
		// Rename sheet
		$objPHPExcel->getActiveSheet ()->setTitle ( $filename . '记录' );
		
		// Set active sheet index to the first sheet, so Excel opens this as the
		// first sheet
		$objPHPExcel->setActiveSheetIndex ( 0 );
		
		ob_end_clean (); // 清除缓冲区,避免乱码
		                // Redirect output to a client’s web browser (Excel5)
		header ( 'Content-Type: application/vnd.ms-excel' );
		$filenames = $filename . '(' . date ( 'Ymd-His' ) . ').xls';
		header ( "Content-Disposition: attachment;filename={$filenames}" );
		header ( 'Cache-Control: max-age=0' );
		
		$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel5' );
		$objWriter->save ( 'php://output' );
	}
}