<?php
/**
 * 服务管制--监控管理服务监控-批量重启和关闭服务
 * @author zengguangqiu
 *
 */
class ServolumeswitchController extends CommonController {
	var $navTab = 'D9000';
	
	// 控制器首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$tempresult = json_decode(S('moni_service'),true);
		if(is_array($tempresult) && count($tempresult))
		{
			//从接口获取到对应的通过服务管制发布的服务
			$Sermonitor = new SermonitorModel($_POST,$_GET);
			$SernameArr  = $Sermonitor->getServiceInfo(null,null);
			$tempreturnArr = array();
			foreach ($tempresult as $key =>$val)
			{
				if(is_array($val) && count($val) > 0)
				{
					foreach ($val as $keys=>$vals)
						if(in_array($keys, $SernameArr))
						{
							
							foreach ($vals as $valss)
							{
								$tempreturnArr[] =  $valss;
							}
						}
				}
		
			}
		}
		//dump($tempreturnArr);
		$this->assign ( 'list', $tempreturnArr );
		//dump($result);
		//$this->assign ( 'map', array('arName'=>''));
		cookie('_currentUrl_', __SELF__);
		$this->display();
	}
	
	/**
	 * 批量关闭和重启服务
	 * 
	 */
	function restartShutdown()
	{
		$ids =$_POST['ids'];
		$opmtype = trim($_GET['opmtype']);
		$idsArr = explode(",", $ids);
		$postArr = array();
		foreach ($idsArr as $key=>$val)
		{	
			$tempArr = explode("|", $val);
			$postArr[$key]['servicename'] = $tempArr[0];
			$postArr[$key]['version'] = $tempArr[1];
			$postArr[$key]['ipv'] = $tempArr[2];
			$postArr[$key]['path'] = $tempArr[3];
			$postArr[$key]['processpid'] = $tempArr[4];
			$postArr[$key]['iselegant'] = $tempArr[5];
			$postArr[$key]['person'] = $_SESSION['cUserNo'];
			$postArr[$key]['environment'] = trim($_SESSION['WEB_ENVIRONMENT']);
			$postArr[$key]['plantype'] = $opmtype;
		}
		$Servolumeswitch = new ServolumeswitchModel();
		$result = $Servolumeswitch->restartShutdown($postArr);
		if($result['errorCode'] == 0){
			$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab,//$this->navTab
					"rel"=>"","forwardUrl"=>"");
			echo json_encode($ret);	return;
		}else{
			$msg = $result['errorMessage'];
			$ret = array("statusCode"=>"0","message"=>$msg,"navTabId"=>'',//$this->navTab
					"rel"=>"","forwardUrl"=>"");
			echo json_encode($ret);	return;
		}
	}
	
}