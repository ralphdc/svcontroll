<?php
/**
 * 调用链控制器
 * @author zengguangqiu
 *
 */
class CallChainController extends CommonController {

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
			
			$startTime =strtotime(trim($_POST['startTime']));
			$endTime = strtotime(trim($_POST['endTime']));
			$now   = strtotime(date("Y-m-d H:i:s"));
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
		if($_GET['chainId'])
		{
			$_POST['cid'] = $_GET['chainId'];
			$_REQUEST['cid'] =  $_GET['chainId'];
		}
		if($_GET['date'])
		{
			$_POST['startTime'] = $_GET['date'];
			$_REQUEST['date']= $_GET['date'];
			$_POST['endTime'] = $_GET['date'];
			$_REQUEST['endTime']= $_GET['date'];
		}
		if($_GET['fid'])
		{
			$_POST['fid'] = $_GET['fid'];
		}
		if($_GET['startTime'])
		{
			$_POST['startTime'] = $_GET['startTime'];
		}
		if($_GET['endTime'])
		{
			$_POST['endTime'] = $_GET['endTime'];
		}
		if($_GET['type'])
		{
			$_POST['type'] = $_GET['type'];
		}
		
		$_POST['start'] = $_POST['startTime'] = empty($_POST['startTime']) ? date("Y-m-d H:i:s"):$_POST['startTime'];
		$_POST['end'] =$_POST['endTime'] = empty($_POST['endTime']) ? date("Y-m-d H:i:s"):$_POST['endTime'];
		$_REQUEST['startTime'] = $_POST['startTime'];
		$_REQUEST['endTime'] = $_POST['endTime'];
		$_REQUEST['start'] = $_POST['startTime'];
		$_REQUEST['end'] = $_POST['endTime'];
		if($_POST['_sort']=='desc' || $_POST['_sort']=='')
		{
			$_POST['order'] = 1;
		}else
		{
			$_POST['order'] = 0;
		}
		if(empty($_REQUEST['numPerPage']))
		{
			$_REQUEST['numPerPage'] = $_COOKIE['numPerPage'.$_POST['type']];
		}
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$_POST['numPerPage'] = $pageNum;
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		if(empty($_POST['cid']) && empty($_REQUEST['type']))
		{
			$result = array();
			$count = 0;
		}elseif($_REQUEST['type'] == 2)
		{
			if(empty($_POST['cid'])&&empty($_POST['merNo'])&&empty($_POST['tmlNo']))
			{
				$result = array();
				$count = 0;
			}else{
				$CallChain = new CallChainModel($_POST,$_GET);
				$result = $CallChain->findByPost($_POST,$_GET);
				$count = $CallChain->countByPost($_POST,$_GET);
			}
		}elseif($_REQUEST['type'] == 3)
		{
			if(empty($_POST['cid']))
			{
				$result = array();
				$count = 0;
			}else{
				$CallChain = new CallChainModel($_POST,$_GET);
				$result = $CallChain->findByPost($_POST,$_GET);
			}
			
		}elseif($_REQUEST['type'] == 4)
		{
			if(empty($_POST['cid']))
			{
				$result = array();
				$count = 0;
			}else{
				$CallChain = new CallChainModel($_POST,$_GET);
				$result = $CallChain->findByPost($_POST,$_GET);
				$count = $CallChain->countByPost($_POST,$_GET);
			}
		}elseif($_REQUEST['type'] == 5)
		{
			$CallChain = new CallChainModel($_POST,$_GET);
			$result = $CallChain->findByPost($_POST,$_GET);
			$count = $CallChain->countByPost($_POST,$_GET);
		}else
		{
			if($_POST['fromsearch'] == 1)
			{
				if(empty($_REQUEST['merName']) && empty($_REQUEST['fid']))
				{
					$ret = array("statusCode"=>"0","message"=>'商户名和流程ID至少要输入一个',"navTabId"=>$this->navTab,//$this->navTab
							"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
					exit(json_encode($ret));
				}
				$CallChain = new CallChainModel($_POST,$_GET);
				$result = $CallChain->findByPost($_POST,$_GET);
				$count = $CallChain->countByPost($_POST,$_GET);
			}else
			{
				$result = array();
				$count = 0;
			}
		}
		
		
		//============================2015-10-15 林凌舒沟通 交易调用链页面超链接点击跳转到交易调用节点；
		
		$transChain = I('get.from','','htmlspecialchars');
		$transType = I('get.type',0,'htmlspecialchars');
		if(strval($transChain) == 'transchain' && intval($transType) == 3){
		    $_POST['start'] = I('get.startTime',date('Y-m-d H:i:s'));
		    $_POST['end'] = I('get.endTime',date('Y-m-d H:i:s'));
		    $_POST['cid'] = I('get.cid','');
		    $_GET = array();
		    $CallChain = new CallChainModel($_POST,$_GET);
		    $result = $CallChain->findByPost($_POST,$_GET);
		}
		//================================================================================
		
		
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result ); 
		$loglevel = array(''=>'全部','WARN'=>'警告','ERROR'=>'错误','FATAL'=>'紧急','INFO'=>'普通','XGD'=>'XGD');
		$this->assign('level',$loglevel);
		
		cookie('_currentUrl_', __SELF__);
		
		if($_REQUEST['type'] == 1)
		{
			$this->assign ( 'map',array('fid'=>'','merName'=>'','srv'=>'','tskdef'=>'','ft'=>'','startTime'=>'','endTime'=>'','type'=>''));
			$this->display('index1');
		}elseif($_REQUEST['type'] == 2)
		{
			$this->assign ( 'map',array('cid'=>'','startTime'=>'','endTime'=>'','type'=>'','merNo'=>'','tmlNo'=>''));
			$this->display('index2');
		}elseif($_REQUEST['type'] == 3)
		{
			$this->assign ( 'map',array('cid'=>'','startTime'=>'','endTime'=>'','type'=>''));
			$this->display('index3');
		}elseif($_REQUEST['type'] == 4)
		{
			$this->assign ( 'map',array('cid'=>'','type'=>'','startTime'=>'','endTime'=>''));
			$this->display('index4');
		}elseif($_REQUEST['type'] == 5)
		{
			$this->assign ( 'map',array('user'=>'','type'=>'','ctype'=>'','startTime'=>'','endTime'=>'','mname'=>'','mno'=>'','tno'=>''));
			$this->display('index5');
		}else
		{
			$this->assign ( 'map',array('level'=>'','cid'=>'','srv'=>'','startTime'=>'','endTime'=>'','type'=>''));
			$this->display();
		}
		
	}
	function showLine()
	{	
		//获取参数传递给后端通过java接口获取对应的数据传递给页面的js展示图表
		//$post['chainId'] = trim($_GET['chainId']);
		$post['ip'] = trim($_GET['ip']);
		$post['time'] = trim($_GET['time']);
		$CallChain = new CallChainModel($_POST,$_GET);
		$result = $CallChain->getLineGraph($post);
		$cpuDataArr = array();
		$memoryData = array();
		if(is_array($result) && count($result))
		{
			foreach ($result as $key=>$val)
			{
				$cpuDataArr[] = $val['cpu'];
				$memoryData[] = $val['memory'];
			}
		}
		$cpuData = implode(",", $cpuDataArr);
		$memoryData = implode(",", $memoryData);
		//$cpuData = '7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6,7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6,7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6,80,88,90,87,100';
		//$memoryData = '3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8,3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8,3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8,56,84,31,96,50';
		$title = date("Y年m月d日H点i分s秒",strtotime(substr($post['time'],0,-4))).'前后20秒的Cpu，Memory数据';
		$this->assign('title',$title);
		$this->assign('cpuData',$cpuData);
		$this->assign('memoryData',$memoryData);
		$this->display();
	}
	
	/**
	 * 导出excell
	 */
	function exportexcell()
	{
		$param = json_decode(base64_decode($_GET['param']),true);
		$filename = '调用链';
		$CallChain = new CallChainModel($param,$_GET);
		$OrdersData = $CallChain->findAllByPost($param,$_GET);
	
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
		$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'B' )->setWidth ( 50 );
		$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'C' )->setWidth ( 20 );
		$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'D' )->setWidth ( 80 );
		$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'E' )->setWidth ( 20 );
		$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'F' )->setWidth ( 20 );
		$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'G' )->setWidth ( 20 );
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
		->setCellValue ( 'B2', '调用链ID' )
		->setCellValue ( 'C2', '日志等级' )
		->setCellValue ( 'D2', '信息' )
		->setCellValue ( 'E2', 'IP地址' )
		->setCellValue ( 'F2', '服务名称' )
		->setCellValue ( 'G2', '服务类型' )
		->setCellValue ( 'H2', '进程ID' )
		->setCellValue ( 'I2', '耗时' )
		->setCellValue ( 'J2', '发生时间' );
		// Miscellaneous glyphs, UTF-8
		for($i = 0; $i <= count ( $OrdersData ) - 1; $i ++) {
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'A' . ($i + 3), $i + 1 );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'B' . ($i + 3), " {$OrdersData [$i] ['chainId']}");
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'C' . ($i + 3), $OrdersData [$i] ['level'] );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'D' . ($i + 3), $OrdersData [$i] ['msg'] );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'E' . ($i + 3), $OrdersData [$i] ['ip'] );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'F' . ($i + 3), $OrdersData [$i] ['service'] );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'G' . ($i + 3), $OrdersData [$i] ['serviceType'] );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'H' . ($i + 3), $OrdersData [$i] ['pid'] );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'I' . ($i + 3), $OrdersData [$i] ['elapseTime'] );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'J' . ($i + 3), $OrdersData [$i] ['logTime'] );
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