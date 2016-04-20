<?php

//用户管理
class UserController extends CommonController {
	var $navTab = 'L10000';
	var $pageSize = "16";
	var $pageNumShown = "2";
	
    function index(){
    	$header = C('queryUsers');
    	
    	$pageNum = ($_POST['pageNum'] == "" )?"1":$_POST['pageNum'];
    	$reqs = array('userStatus'=>'1', "pageNo"=>$pageNum,"pageSize"=>$this->pageSize);
    	if($_POST['userName']){
    		$reqs['queryCon']['userName'] = $_POST['userName'];
    	}
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
		$users = $data['datalist'];
		//print_r($users);
		$this->assign ('usernum', $data['totalnum']);
		$this->assign ('users', $users );
		$this->assign ('currentPage', $pageNum );
		$this->assign ('pageSize', $this->pageSize );
		$this->assign ('pageNumShown', $this->pageNumShown );
		$this->assign ('numStart', ($pageNum-1)*$this->pageSize );
    	$this->display();
    }
   
    function add(){
    	if($_POST){
    		$request = array();
    		foreach($_POST as $k =>$v){
    			$request[$k] = $v;
    			 
    		}
    		
    		$header = C('addUser');
    		//$request = array("userName"=>$userName,"userType"=>$userType,"upUserId"=>$upUserId,"orgId"=>$orgId,"userStatus"=>$userStatus,"remark"=>$remark);
    		 
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
    
    function detail($id){
    	$header = C('queryUser');
    	$request = array('userId'=>$id);
    	 
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	if($data['code'] == 0){
    		$userinfo = $data['userinfo'];
    	}else{
    		$userinfo = array();
    	}
    	$this->assign ('userinfo', $userinfo );
    	$this->display();
    }
    
    function edit($id){
    	if($_POST){
    		$request = array();
    		foreach($_POST as $k =>$v){
    			$request[$k] = $v;
    			
    		}
    		$header = C('updateUser');
    		//$request = array("userName"=>$userName,"upUserId"=>$upUserId,"upUserId"=>$upUserId,"userType"=>$userType,"userStatus"=>$userStatus,"remark"=>$remark);
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
	    	$userinfo = $this->_getUseById($id);
	    	$this->assign ('userinfo', $userinfo );
	    	//print_r($userinfo);
	    	$this->display();
    	}
    }
    
    function delete($ids){
    	if($ids != "" ){
    		$header = C('deleteUser');
    		$request = array('ids'=>$ids);
    		 
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
    
    function resetPwd($id){
    	if($id != "" ){
    		$header = C('resetPwd');
    		$request = array('ids'=>$id);
    		 
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
    }
    
    //编辑权限
    function editgrant($id){
    	//产品
    	$header = C('queryProducts');
    	$reqs = array("pageNo"=>1,"pageSize"=>20);
    	
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$products = $data['datalist'];
    	$this->assign ('products', $products );
    	
    	$header = C('queryRoles');
    	$pageNum = ($_POST['pageNum'] == "" )?"1":$_POST['pageNum'];
    	$reqs = array("pageNo"=>$pageNum,"pageSize"=>$this->pageSize);
    	if($_POST['productId']){
    		$reqs['queryCon']['productId'] = $_POST['productId'];
    	}else{
    		$reqs['queryCon']['productId'] = $products[0]['id'];
    	}
    	if($_POST['roleName']){
    		$reqs['queryCon']['roleName'] = $_POST['roleName'];
    	}
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$role = $data['datalist'];
    	
    	$userinfo = $this->_getUseById($id);
    	//print_r($userinfo);
    	$this->assign ('userinfo', $userinfo );
    	$this->assign ('roleList', $role );
    	$this->display();
    }
    
    function getRoleofUser(){
    	$userid = $_POST['id'];
    	$header = C('Role2User');
    	$request = array('id'=>$userid,"pageNo"=>1,"pageSize"=>10);
    	
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	if($data['code'] == 0){
    		$roleofUser = $data['datalist'];
    	}else{
    		$roleofUser = array();
    	}
    	echo json_encode($roleofUser) ;
    }
    
    protected  function _getUseById($id){
    	$header = C('queryUser');
    	$request = array('userId'=>$id);
    	 
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	if($data['code'] == 0){
    		$userinfo = $data['userinfo'];
    	}else{
    		$userinfo = array();
    	}
    	return $userinfo;
    }
    
    function showRoleOfProduct(){
    	$header = C('queryRoles');
    	
    	$reqs = array("pageNo"=>1,"pageSize"=>20);
    	if($_POST['productId'] !=""){
    		$reqs['queryCon']['productId'] = $_POST['productId'];
    	}
		if($_POST['roleName'] !=""){
			$reqs['queryCon']['roleName'] = $_POST['roleName'];
		}
    		

    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$role = $data['datalist'];
    	$this->assign('roleList',$role);
    
    	$this->display();
    	
    }
    /*
    function getResourOfRole(){
    	$roleIds = $_POST['roleIds'];
    	
    	$header = C('queryAllResource');
    	$reqs = array("pageNo"=>1,"pageSize"=>20);
    	if($_POST['productId'] !=""){
    		$reqs['queryCon']['productId'] = $_POST['productId'];
    	}
    	if($_POST['roleName'] !=""){
    		$reqs['queryCon']['roleName'] = $_POST['roleName'];
    	}
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$role = $data['datalist'];
    	$this->assign('roleList',$role);
    	$this->display();
    	
    }*/
    
    //点击角色返回角色的所有权限     粗略查看
    function showResourOfRoles(){
    	$roleIds = $_POST['roleIds'];
    	$header = C('queryAllResource');
    	$reqs = array();
    	$reqs['roleIds'] = $roleIds;
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$role = $data['resourceList'];
    	$this->assign('resource',$role);
    	//print_r($data);
    	$this->display();
    	
    }
    
    //对选中后的角色点击查看      详细查看
    function queryRolesDetail(){
    	$header = C('queryRolesDetail');
    	$request = array('roleIds'=>$_POST['roleIds']);
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	 
    	if($data['code'] == 0){
    		$menuTree = $data['menuTree'];
    		$actionTree = $data['actionTree'];
    		$elementList = $data['elementList'];
    		
    		$this->assign ('menuTree', $menuTree);
    		$this->assign ('actionTree', $actionTree);
    		$this->assign ('elementList', $elementList);
    		
    		$this->display();
    	}
    	 
    }
    
    //保存用户的角色
    function saveRolesToUser(){
    	$header = C('assignRole');
    	$reqs = array();
    	$reqs['roleIds'] = $_POST['roleIds'];
    	$reqs['userId'] = $_POST['userId'];
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	if($data['code'] == 0){
    		echo 1;
    	}else{
    		echo 0;
    	}
    	
    }
    
    
    //点击用户查看其拥有的角色，菜单，动作，工作流
    function getDetailOfUser(){
    	$header = C('getDetailOfUser');
    	$request = array('userId'=>$_POST['userId']);
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	//print_r($data);
    	if($data['code'] == 0){
    		$roleList = $data['roleList'];
    		$menuActionTree = $data['menuActionTree'];
    		$elementList = $data['elementList'];
    	
    		$this->assign ('roleList', $roleList);
    		$this->assign ('menuActionTree', $menuActionTree);
    		$this->assign ('elementList', $elementList);
    	
    		$this->assign ('totalnumRole', 100);
			$this->assign ('currentPageRole', 1 );
			$this->assign ('numPerPageRole', $this->pageSize );
			$this->assign ('pageNumShownRole', $this->pageNumShown );
			$this->assign ('numStartRole', 1 );
    		$this->display();
    	}
    	
    }
    
    //点击用户查看其授权的用户
    function showGrantUser(){
    	$header = C('queryPrivilege');
    	$request = array('authorizerId'=>$_POST['authorizerId'],'pageNo'=>1,'pageSize'=>20);
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	//$users = $data['datalist'];
    	
    	//print_r($data['dataList']);
    	if($data['code'] == 0){
    		$userList = $data['dataList'];
    		$this->assign ('userList', $userList);
    		
    		$this->display();
    	}
    	
    }
     
    
}