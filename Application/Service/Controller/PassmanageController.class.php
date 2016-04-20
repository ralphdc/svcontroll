<?php
/**
 * 服务管制--资源中心-分区管理对应的控制器
 * @author zengguangqiu
 *
 */
class PassmanageController extends CommonController {
	var $navTab = '2c948cfb51ec5db00151ec97e9dd002d';
	//var $navTab = 'D60620';
	
	// 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$Passmanage = new PassmanageModel($_POST,$_GET);
		$result = $Passmanage->findByPost($_POST,$_GET);
		$count = $Passmanage->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		//dump($result);
		$this->assign ( 'map', array('hostname'=>'','ipv'=>''));
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
	
	/**
	 * 导出excell表格
	 */
	function exportexcell()
	{
		$param = json_decode(base64_decode($_GET['param']),true);
		$filename = '密码管理';
		$Passmanage = new PassmanageModel($param,$_GET);
		$result = $Passmanage->findByPostToExcel($param,$_GET);
		$OrdersData = array();
		if(is_array($result))
		{
			foreach ($result as $key=>$val)
			{
				$OrdersData[$key]['ipv'] = $val['ipv'];
				$OrdersData[$key]['hostname'] = $val['hostname'];
				if(is_array($val['child']))
				{
					$tempArr = array();
					foreach($val['child'] as $key1=>$val1)
					{
						$tempArr[] =$val1['usr_name'].' : '.$val1['usr_psd'];
					}
					$tempStr = implode(" | ",$tempArr);
				}
				$OrdersData[$key]['child'] = $tempStr;
			}
		}
		
	
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
		$objPHPExcel->getActiveSheet ()->getColumnDimension ( 'D' )->setWidth ( 120 );
	
		// 设置行高度
		$objPHPExcel->getActiveSheet ()->getRowDimension ( '1' )->setRowHeight ( 22 );
	
		$objPHPExcel->getActiveSheet ()->getRowDimension ( '2' )->setRowHeight ( 20 );
	
		// set font size bold
		$objPHPExcel->getActiveSheet ()->getDefaultStyle ()->getFont ()->setSize ( 10 );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A2:D2' )->getFont ()->setBold ( true );
	
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A2:D2' )->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A2:D2' )->getBorders ()->getAllBorders ()->setBorderStyle ( PHPExcel_Style_Border::BORDER_THIN );
	
		// 设置水平居中
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A1' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_LEFT );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'A' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'B' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'C' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		$objPHPExcel->getActiveSheet ()->getStyle ( 'D' )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
	
		//
		$objPHPExcel->getActiveSheet ()->mergeCells ( 'A1:N1' );
	
		// set table header content
		$objPHPExcel->setActiveSheetIndex ( 0 )
		->setCellValue ( 'A1', $filename . '记录  时间:' . date ( 'Y-m-d H:i:s' ) )
		->setCellValue ( 'A2', '编号' )
		->setCellValue ( 'B2', 'IP' )
		->setCellValue ( 'C2', '主机名' )
		->setCellValue ( 'D2', '用户和密码' );
		// Miscellaneous glyphs, UTF-8
		for($i = 0; $i <= count ( $OrdersData ) - 1; $i ++) {
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'A' . ($i + 3), $i + 1 );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'B' . ($i + 3), " {$OrdersData [$i] ['ipv']}");
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'C' . ($i + 3), $OrdersData [$i] ['hostname'] );
			$objPHPExcel->getActiveSheet ( 0 )->setCellValue ( 'D' . ($i + 3), $OrdersData [$i] ['child'] );
			$objPHPExcel->getActiveSheet ()->getStyle ( 'A' . ($i + 3) . ':D' . ($i + 3) )->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
			$objPHPExcel->getActiveSheet ()->getStyle ( 'A' . ($i + 3) . ':D' . ($i + 3) )->getBorders ()->getAllBorders ()->setBorderStyle ( PHPExcel_Style_Border::BORDER_THIN );
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