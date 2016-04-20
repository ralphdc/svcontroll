<?php
/**
 * 收集器配置控制器
 * @author zengguangqiu
 *
 */
class CollectSetController extends CommonController {
	var $navTab = 'L30803';
	
// 框架首页
	public function index() {
		if($_POST){
				$request = array();
				foreach($_POST as $k =>$v){
					$request[$k] = $v;
				}
				//组织要保存的数据
				//$post['id'] = $_GET['id'];
				$post['appPath'] = trim($_POST['appPath']);
				$post['sysPath'] = trim($_POST['sysPath']);
				$post['sqlPath'] = trim($_POST['sqlPath']);
				$post['form_act'] = 'update';
				
				//调用java接口进行数据的操作
				$CollectSet = new CollectSetModel($_POST,$_GET);
				$result = $CollectSet->saveRowInfo($post);
				if($result['rtn'] == "OK"){
					$ret = array("statusCode"=>"1","message"=>'操作成功。',"navTabId"=>$this->navTab,//$this->navTab
							"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
					echo json_encode($ret);	return;
				}else{
					$ret = array("statusCode"=>"0","message"=>"操作失败","navTabId"=>'',//$this->navTab
							"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
					echo json_encode($ret);	return;
				}
		}
		
		$CollectSet = new CollectSetModel($_POST,$_GET);
		$vo = $CollectSet->getRowInfo();
		$this->assign('vo', $vo);
		$this->display();
		
		
	}
	

}