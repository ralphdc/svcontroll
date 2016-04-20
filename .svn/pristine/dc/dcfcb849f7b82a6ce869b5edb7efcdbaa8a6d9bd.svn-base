<?php
/**
 * 服务管制-监控管理-服务监控中心
 * @author zengguangqiu
 *
 */
class SermonitorController extends CommonController {
	var $navTab = 'D60605';
	
// 框架首页
	public function index() {
		$Sermonitor = new SermonitorModel($_POST,$_GET);
		$resultconfig = $Sermonitor->findByPost($_POST,$_GET);
		//$resultexamples = $Sermonitor->findByexamplesPost($_POST,$_GET);
		$this->assign ( 'config_nodes', $resultconfig['config_nodes'] );
		$this->assign ( 'map', array('ip'=>'','serviceName'=>'','istool'=>''));
		//$this->assign ( 'examples_nodes', $resultexamples['examples_nodes'] );
		$this->display();
	}
	
	/**
	 * 根据get过来的type参数展示对应的服务监控的页面的详细信息
	 * type=a  服务项详情
	 * type=b  机器上监控服务详情
	 */
	public function detail()
	{
		$Configure = new ConfigureModel($_POST,$_GET);
		$type = $_GET['type'];
		if($type == 'a')
		{
			$tempresult = json_decode(S('moni_service'),true);
			$keyName = trim($_GET['name']);
			$result = array();
			if(is_array($tempresult) && count($tempresult))
			{
				foreach ($tempresult as $key=>$val)
				{
					if(is_array($val[$keyName]) && count($val[$keyName]))
					{
						$result = $val[$keyName];
						break;
					}
				}
			}
			$this->assign ( 'result', $result );
		}elseif($type == 'b')
		{
			$tempresult = json_decode(S('moni_serviceandip'),true);
			$keyName = $_GET['name'];
			$ip = trim($_GET['ip']);
			$serviceid = trim($_GET['serviceid']);
			$keyName = $keyName.'#'.$ip;
			$result = array();
			if(is_array($tempresult) && count($tempresult))
			{
				foreach ($tempresult as $key=>$val)
				{
					if(is_array($val[$keyName]) && count($val[$keyName]))
					{
						$result = $val[$keyName];
						break;
					}
				}
			}
			//dump($result);
			$this->assign ( 'result', $result );
			$this->assign ( 'serviceid', $serviceid );
				
		}
		$disTpl = 'detail_'.$type;
		$this->display($disTpl);
	}
	public function getServiceInfo()
	{
		$tempresult = json_decode(S('moni_service'),true);
		//$tempresult = array('面板'=>'asdasd');
		$str = '<ul class="tree"><li><a>未通过服务管制发布的服务名</a><ul>';
		if(is_array($tempresult) && count($tempresult))
		{
			//从接口获取到对应的通过服务管制发布的服务
			$Sermonitor = new SermonitorModel($_POST,$_GET);
			$SernameArr  = $Sermonitor->getServiceInfo(null,null);
			foreach ($tempresult as $key =>$val)
			{
				if(is_array($val) && count($val) > 0)
				{
					foreach ($val as $keys=>$vals)
					if(!in_array($keys, $SernameArr))
					{
						$str.='<li><a href="/index.php/Service/Sermonitor/detail?type=a&name='.$keys.'" target="ajax" rel="sermonitor_content">'.$keys.'</a></li>';
					}
				}
				
			}
		}
		$str .= '</ul></li></ul>';
		echo $str;
	}
	public function getpnid()
	{
		$Sermonitor = new SermonitorModel($_POST,$_GET);
		$params = $_POST['params'];
		$tempparamsArr = array();
		if(!empty($params))
		{
			$tempparamsArr = explode("|", $params);
			$paramsArr['servicename'] = $tempparamsArr[0];
			$paramsArr['ipv'] = $tempparamsArr[1];
			$paramsArr['version'] = $tempparamsArr[2];
			$paramsArr['path'] = $tempparamsArr[3];
			$paramsArr['serviceid'] = $tempparamsArr[4];
		}
		echo $Sermonitor->getpnid($paramsArr);
		
	}
	public function detail_a() {
		$this->display();
	}
	
	public function detail_b() {
		$this->display();
	}
	
	public function detail_c() {
		$this->display();
	}
	
	public function program() {
		$this->display();
	}
		
}