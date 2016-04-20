<?php

//用户组管理
class UserGroupController extends CommonController {
	var $navTab = 'L10001';
	var $pageSize = "16";
	var $pageNumShown = "2";
    function index(){
    	$header = C('queryUserGroups');
    	 
    	$pageNum = ($_POST['pageNum'] == "" )?"1":$_POST['pageNum'];
    	$reqs = array("pageNo"=>$pageNum,"pageSize"=>$this->pageSize);
    	 
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$usergroup = $data['datalist'];
        //print_r($usergroup);
    	$this->assign ('userGroupnum', $data['totalnum']);
    	$this->assign ('userGroup', $usergroup );
    	$this->assign ('currentPage', $pageNum );
    	$this->assign ('pageSize', $this->pageSize );
    	$this->assign ('pageNumShown', $this->pageNumShown );
    	$this->assign ('numStart', ($pageNum-1)*$this->pageSize );
    	$this->display();
    }
   
    function add(){
    	if($_POST){
    		$groupName = $_POST["groupName"];
    		$groupStatus = $_POST["groupStatus"];
    		$remark  = $_POST["remark"];

    		$header = C('addUserGroup');
    		$request = array("groupName"=>$groupName,"groupStatus"=>$groupStatus,"remark"=>$remark);
    		 
    		$SendMessage= new SendMessage;
    		$data = $SendMessage ->send($header,$request);
    		if($data['code'] == "0"){
	    		$ret = array("statusCode"=>"1","message"=>'正确',"navTabId"=>'',//$this->navTab
						"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
				echo json_encode($ret);	return;
    		}else{
    			$ret = array("statusCode"=>"300","message"=>$data['msg'],"navTabId"=>'',//$this->navTab
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
    			echo json_encode($ret);	return;
    		}
    	}
    	$this->display();
    }
    
    function detail(){
    	$this->display();
    }
    
    function edit($groupid){
    	if($_POST){
    		$groupName = $_POST["groupName"];
    		$groupStatus = $_POST["groupStatus"];
    		$remark  = $_POST["remark"];
    		
    		$remark = $_POST['remark'];
    		$header = C('updateUserGroup');
    		$request = array('groupId'=>$groupid,"groupName"=>$groupName,"groupStatus"=>$groupStatus,"remark"=>$remark);
    		$SendMessage= new SendMessage;
    		$data = $SendMessage ->send($header,$request);
    		if($data['code'] == 0){
    			$ret = array("statusCode"=>"1","message"=>'正确',"navTabId"=>'',//$this->navTab
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"");
    			echo json_encode($ret);	return;
    		}else{
    			$ret = array("statusCode"=>"300","message"=>$data['msg'],"navTabId"=>'',//$this->navTab
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"");
    			echo json_encode($ret);	return;
    		}
    		
    	}else{
	    	$header = C('queryUserGroup');
	    	$request = array('groupId'=>$groupid);
	    	 
	    	$SendMessage= new SendMessage;
	    	$data = $SendMessage ->send($header,$request);
	    	
	    	if($data['code'] == 0){
	    		$groupinfo = $data['userGroupInfo'];    		
	    	}else{
	    		$groupinfo = array();
	    	}
	    	
	    	$this->assign ('groupinfo', $groupinfo );
	    	$this->display();
    	}
    }
    
    function delete($groupid){
    	if($groupid != ""){
    		$header = C('deleteUserGroup');
    		$request = array('ids'=>$groupid);
    		 
    		$SendMessage= new SendMessage;
    		$data = $SendMessage ->send($header,$request);
    		if($data['code'] == "0"){
    			$ret = array("statusCode"=>"1","message"=>'正确',"navTabId"=>'',//$this->navTab
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"");
    			echo json_encode($ret);	return;
    		}else{
    			$ret = array("statusCode"=>"300","message"=>$data['msg'],"navTabId"=>'',//$this->navTab
    					"rel"=>"","forwardUrl"=>"","callbackType"=>"closeCurrent");
    			echo json_encode($ret);	return;
    		}
    	}
    	$this->display();
    }
    
    function password(){
    	$this->display();
    }
     
    
}