<?php
//ICE权重设置
class IceWeightController extends CommonController {
	//public $navTabId = "D703";
	public $navTabId = "2c948cfb51ec5db00151ec9ea69e0043";
	public function index() {
		$model = CM("IceWeight");
		$result = $model->sendJavaData('icegroupTree','');
		if($result['errorCode'] == 0){
		    //2015-11-17 李超群对接，修改数据结构；
			$weightTree = $result['data'];
			if(count($weightTree[1])){
			    $streedbStr='';
			    for($i=0; $i<count($weightTree[1]); $i++){
			        
			        
			        $tagStr = $i==(count($weightTree[1])-1) ? "" : ',';
			        $keyStr = '{name:';
			        $keyStr .= "'".$weightTree[1][$i]['groupName']."'";
			        $keyStr .= ",groupid:'".$weightTree[1][$i]['groupId']."'";
			        $keyStr .= ",grouptl:'".$weightTree[1][$i]['groupDescription']."'";
			        $keyStr .= ",grouptype:'db'";
			        $keyStr .= ",font:{'color':'red'}";
			        $keyStr .= ',click:"onLeftClick(\''.$weightTree[1][$i]['groupName'].'\')"}';
			        $keyStr .= $tagStr;
			        
			        $streedbStr .= $keyStr;
			    }
			    $streedbStr2 = "[".$streedbStr."]";
			}else{
			    $streedbStr = "";
			}
			
			if(count($weightTree[0])){
			    $streezkStr='';
			    for($i=0; $i<count($weightTree[0]); $i++){
			         
			         
			        $tagStr = $i==(count($weightTree[0])-1) ? "" : ',';
			        $keyStr = '{name:';
			        $keyStr .= '"'.$weightTree[0][$i].'"';
			        $keyStr .= ",grouptype:'zk'";
			        $keyStr .= ',click:"onLeftClick(\''.$weightTree[0][$i].'\')"}';
			        $keyStr .= $tagStr;
			         
			        $streezkStr .= $keyStr;
			    }
			    $streezkStr2 = "[".$streezkStr."]";
			}else{
			    $streezkStr = "";
			}
			
			$treeStr = "{name:'组',grouptype:'gpt',children:[";
			$treeMenu = $streedbStr ? ($streezkStr ? $streedbStr.','.$streezkStr : $streedbStr) : ($streezkStr ? $streezkStr : '');
			$treeStr = $treeStr.$treeMenu."]}";
			
			$dbTree = "{name:'数据库组',children:".$streedbStr2."}";
			$zkTree = "{name:'ZK组',children:".$streezkStr2."}";
			$this->assign("treeMenu",$treeStr);
			
		}
		
		$this->display('icetree');
	}
	
	public function showGroup(){
		$model = CM("IceWeight");
		$result = $model->sendJavaData('icegroupGet',$_REQUEST);
		if($result['errorCode'] == 0){
			$conproGet = $result['data'];
		}
		$this->assign("lists",$conproGet);
		$this->display();
	}
	
	public function groupCreateShow()
	{
	    $this->display();
	}
	
	public function groupCreate()
	{
	   $groupName = I("post.dbGroupName","");
	   $groupDes = I("post.dbGroupDes","");
	   if(!empty($groupName)){
	       $model = CM("IceGroupService");
	       
	       $result = $model->sendJavaData('ice_group_create',array('groupName'=>$groupName,'groupDescription'=>$groupDes,'operaterPerson'=>'admin'));
    	    if(isset($result['errorCode']) && $result['errorCode'] == 0){
    	        $ret = array("statusCode"=>"1","message"=>'新增成功',"nodeid"=>$result['data']['id'],"navTabId"=>$this->navTabId,"nodename"=>$groupName,
					"forwardUrl"=>cookie('_currentUrl_'),"callbackType"=>"");
			echo json_encode($ret);return;
    	    }else{
    	        $ret = array("statusCode"=>"0","message"=>$result['errorMessage'],
    	            "forwardUrl"=>cookie('_currentUrl_'),"callbackType"=>"");
    	        echo json_encode($ret);return;
    	    }
	   }
	}
	
	public function groupDelete()
	{
	    if(IS_AJAX){
	        $gpId = I("post.id");
	        $gpName = I("post.gpname");
	        if($gpId && $gpName){
	            $gpModel = CM("IceGroupService");
	            $result = $gpModel->sendJavaData('ice_group_delete',array('groupName'=>$gpName,'groupId'=>$gpId));
	            if(isset($result['errorCode']) && $result['errorCode'] == 0 ){
	                $ret = array("statusCode"=>"200","message"=>'删除成功！',"navTabId"=>$this->navTabId, "forwardUrl"=>cookie('_currentUrl_'),"callbackType"=>"");
	            }else{
	                $ret = array("statusCode"=>"0","message"=>$result['errorMessage'],"navTabId"=>$this->navTabId, "forwardUrl"=>cookie('_currentUrl_'),"callbackType"=>"");
	            }
	        }else{
	            $ret = array("statusCode"=>"0","message"=>'参数传入有误！',"navTabId"=>$this->navTabId,
	                "forwardUrl"=>cookie('_currentUrl_'),"callbackType"=>"");
	        }
	        echo json_encode($ret);
	        exit;
	    }
	}
}