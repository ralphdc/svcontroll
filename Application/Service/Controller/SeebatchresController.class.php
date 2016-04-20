<?php
/**
 * 服务管制--仓库中心-批量处理-配置预览
 * @author zengguangqiu
 *
 */
class SeebatchresController extends CommonController {
	var $navTab = 'D61624';
	var $status = array('1'=>'启动','2'=>'关闭','3'=>'新增','4'=>'迭代','5'=>'部署');
	var	$distype = array('1'=>'实时','2'=>'定时');
	var	$resultArr = array('1'=>'未完成','2'=>'已完成');
	// 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		if($_GET['ptaskid'] > 0)
		{
			$_POST['ptaskid'] = $_GET['ptaskid'];
		}
		$pageNum =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
		$this->assign ( 'numPerPage', $pageNum ); //每页显示多少条
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		$Seebatchres = new SeebatchresModel($_POST,$_GET);
		$result = $Seebatchres->findByPost($_POST,$_GET);
		$count = $Seebatchres->countByPost($_POST,$_GET);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'list', $result );
		$this->assign ( 'ptaskid', $_POST['ptaskid'] );
		$this->assign ( 'status', $this->status );
		$this->assign ( 'distype', $this->distype );
		$this->assign ( 'resultArr', $this->resultArr );
		$this->assign ( 'map', array('servicename'=>'','ptaskid'=>''));
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
}