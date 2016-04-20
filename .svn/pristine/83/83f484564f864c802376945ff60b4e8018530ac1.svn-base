<?php

//角色管理
class RoleController extends CommonController {
	var $navTab = 'L10003';
	var $pageSize = "16";
	var $pageNumShown = "2";

    function index(){
    	//产品
    	$header = C('queryProducts');
    	$reqs = array("pageNo"=>1,"pageSize"=>20);
    	 
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$products = $data['datalist'];
    	//print_r($products);
    	$this->assign ('products', $products );
    	
    	//角色
    	$header = C('queryRoles');
    	$pageNum = ($_POST['pageNum'] == "" )?"1":$_POST['pageNum'];
    	$reqs = array("pageNo"=>$pageNum,"pageSize"=>$this->pageSize);
    	$reqs['queryCon']['productId'] = ($_COOKIE['productId'] == "")? $products[0]['id']:$_COOKIE['productId'];
    	if($_POST['roleName']){
    		$reqs['queryCon']['roleName'] = $_POST['roleName'];
    	}
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$role = $data['datalist'];
    	//print_r($role);
    	
    	$this->assign ('rolenum', $data['totalnum']);
    	$this->assign ('role', $role );
    	$this->assign ('currentPage', $pageNum );
    	$this->assign ('pageSize', $this->pageSize );
    	$this->assign ('pageNumShown', $this->pageNumShown );
    	$this->assign ('numStart', ($pageNum-1)*$this->pageSize );
    	$this->display();
    }
   
    function add(){
    	if($_POST){
    		$request = array();
    	    if(!empty($_POST)){
	    		foreach($_POST as $k =>$v){
	    				$request[$k]= $v;
	    			}
	    	}
    		
    		$header = C('addRole');
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
    	$header = C('queryProducts');
    	$reqs = array("pageNo"=>1,"pageSize"=>20);
    	 
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$products = $data['datalist'];
    	$this->assign ('products', $products );
    	$this->display();
    }
    
    function detail(){
    	$this->display();
    }
    
    function edit($id){
    	if($_POST){
    		$header = C('updateRole');
    		$request = array();
    		foreach($_POST as $k =>$v){
    			$request[$k] = $v;
    			 
    		}
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
    		$getid = array();
    		$getid = explode(",", $id);
    		$id = $getid[0];
    		$productid = $getid[1];
	    	$roleinfo = $this->_getRoleById($id);
	    	$this->assign ('roleinfo', $roleinfo );
			//print_r($roleinfo);
	    	/*$header = C('queryProducts');
	    	$reqs = array("pageNo"=>1,"pageSize"=>20);
	    	$SendMessage= new SendMessage;
	    	$data = $SendMessage ->send($header,$reqs);
	    	$products = $data['datalist'];
	    	$this->assign ('products', $products );*/
	    	$this->display();
    	}
    }
    
    function delete($id){
    	if($id != ""){
    		$getid = array();
    		$getid = explode(",", $id);
    		$ids = $getid[0];
    		$productid = $getid[1];
    		$header = C('deleteRole');
    		$request = array('ids'=>$ids,"productId"=>$productid );
    		 
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
    

    
    function editjur($id){
    	$getid = array();
    	$getid = explode(",", $id);
    	$ids = $getid[0];
    	$productid = $getid[1];
    	$roleinfo = $this->_getRoleById($ids);
    	$this->assign ('roleinfo', $roleinfo );
    	//print_r($roleinfo);
    	
    	$productid = $roleinfo['productId'];
    	$header = C('queryMenus');
    	$request = array("productId"=>$productid);
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	$menu = $data['menuList'];
    	$this->assign ('menu', $menu);
    	
    	
    	$ele_request = array();
    	$header = C('queryElements');
    	$ele_request['pageNo'] = ($_POST['pageNo'] == "")? 1:$_POST['pageNo'];
    	$ele_request['pageSize'] = ($_POST['pageSize'] == "")?$this->pageSize:$_POST['pageSize'];
    	$ele_request['queryCon']['productId'] = ($ele_request['queryCon']['productId'] == "")? $productid:$ele_request['queryCon']['productId'];
    	 
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$ele_request);
    	$Elements = $data['datalist'];
    	//print_r($data);
    	$totalnum = $data['totalnum'];
    	$this->assign ('totalnum', $totalnum);
    	$this->assign ('elements', $Elements);
    	$this->display();
    }
    
    protected function _getRoleById($id){
    	$header = C('queryRole');
    	$request = array('roleId'=>$id);
    
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	 
    	//print_r($data);
    	if($data['code'] == 0){
    		$roleinfo = $data['roleinfo'];
    	}else{
    		$roleinfo = array();
    	}
    	return $roleinfo;
    }
    
    function getActofMenu(){
    	$header = C('queryMenuAction');
    	$ids = array_unique(explode(",",$_POST['ids']));
    	$ids = implode(",",$ids);
    	$request = array('menuIds'=>$ids);
    
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	 
    	if($data['code'] == 0){
    		$actsofmenu = $data['menuList'];
    	}else{
    		$actsofmenu = array();
    	}
    	//echo json_encode(array(1,2,3,4,5));
    	echo json_encode($actsofmenu);
    }
    //保存角色的元素
    function saveElement(){
    	$header = C('elementToRole');
    	$request = array('resourceIds'=>$_POST['ids'],"roleId"=>$_POST['roleID']);
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);

    	if($data['code'] == 0){
    		$result = 1;
    	}else{
    		$result = 0;
    	}
    	
    	echo $result ;
    }
    
    //保存角色的菜单和动作
    function saveMenuAct(){
    	$header = C('menuActionToRole');
    	$menuids = array_unique(explode(',', $_POST['menuids']));
    	$menuids = implode(",", $menuids);
    	$request = array('menuIds'=>$menuids,"actionIds"=>$_POST['actids'],"roleId"=>$_POST['roleId']);
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	
    	if($data['code'] == 0){
    		$result = 1;
    	}else{
    		$result = 0;
    	}
    	 
    	echo $result ;
    	
    }
    
    //查看单个角色所拥有的菜单，动作，元素，工作流的接口
    function queryRoleDetail(){
    	$header = C('queryRoleDetail');
    	$request = array('roleId'=>$_POST['roleId']);
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	 
    	if($data['code'] == 0){
    		$menuList = $data['menuTree'];
    		$actList = $data['actionList'];
    		$elementList = $data['elementList'];
    		
    		$this->assign ('menuList', $menuList);
    		$this->assign ('actList', $actList);
    		$this->assign ('elementList', $elementList);
    		
    		$this->display();
    	}
    }
    //查看哪些用户有这些角色
    function queryUserList(){
    	$header = C('queryUsersOfRole');
    	$request = array('roleId'=>$_POST['roleId']);
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	
    	if($data['code'] == 0){
    		$userList = $data['userList'];
    		$this->assign ('userList', $userList);
    		//print_r($userList);
    		$this->display('allUserOfRole');
    	}
    	
    }
    
     
    
}