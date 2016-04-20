<?php

//权限资源管理 
class CompetenceResController extends CommonController {
	var $navTab = 'L10005';
	var $pageSize = "16";
	var $pageNumShown = "2";
    function index(){
    	$header = C('queryProducts');
    	$reqs = array("pageNo"=>1,"pageSize"=>20); 
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$products = $data['datalist'];
    	$this->assign ('products', $products );
    	//print_r($products);
    	
    	$productid = ($_COOKIE['productId'] == "")?$products[0]['id']:$_COOKIE['productId'];
    	$header = C('queryMenus');
    	$reqs = array("productId"=>$productid);
    	 
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$menu = $data['menuList'];
    	$this->assign ('menu', $menu);
    	//////////////////数据元素类///////////////////////////
    	$header = C('queryElements');

    	$request['pageNo'] = ($_POST['pageNum'] == "")? 1:$_POST['pageNum'];
    	$request['pageSize'] = $this->pageSize;
    	$request['queryCon']['productId'] = ($_COOKIE['productId'] == "")? $products[0]['id']:$_COOKIE['productId'];
    	 

    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	$Elements = $data['datalist'];
    	//print_r($data);
    	$this->assign ('elements', $Elements );
    	 
    	$this->assign ('totalCount', $data['totalnum']);
    	$this->assign ('currentPage', $request['pageNum'] );
    	$this->assign ('numPerPage', $this->pageSize );
    	$this->assign ('pageNumShown', $this->pageNumShown );
    	///////////////////////////////////////////////////
    	
    	$this->display();
    }
   
    function getMenus(){
    	$productid = $_POST['productId'];
    	$header = C('queryMenus');
    	$reqs = array("productId"=>$productid);
    	
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	$menu = $data['menuList'];
    	$this->assign ('menu', $menu);
    	if($_POST['type'] == "1"){
    		$this->display();
    	}elseif($_POST['type'] == "2"){
    		$header = C('queryActionOfMenu');
    		$reqs = array("MenuName"=>$_POST['menuName']);
    		 
    		$SendMessage= new SendMessage;
    		$data = $SendMessage ->send($header,$reqs);
    		$action = $data['actionList'];
    		$this->assign ('action', $action);
    		$this->display('getMenusAction');
    	}elseif($_POST['type'] == "3"){
    		$header = C('queryElement');
    		$reqs = array("elementName"=>$_POST['elementName']);
    		 
    		$SendMessage= new SendMessage;
    		$data = $SendMessage ->send($header,$reqs);
    		$action = $data['actionList'];
    		$this->assign ('action', $action);
    		$this->assign ('listname', '动作列表');
    		$this->display();
    	}
    }
    
    //根据菜单查询所有的角色
    function showMenuOfRoles(){
    	$header = C('queryMenuOfRole');
    	$reqs = array("menuId"=>$_POST['menuId']);
    	 
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	//print_r($data);
    	$roleList = $data['roleList'];
    	$this->assign ('role', $roleList);
    	$this->display();
    	
    }
    
    //根据菜单查询所有的用户
    function showMenuOfUsers(){
    	$header = C('queryMenuOfUser');
    	$reqs = array("menuId"=>$_POST['menuId']);
    
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$reqs);
    	//print_r($data);
    	$userList = $data['userList'];
    	$this->assign ('user', $userList);
    	$this->display();
    	 
    }
    
    //根据元素查找角色或用户
    function showElementOfRes(){
    	$reqs = array("elementId"=>$_POST['elementid']);
    	$type = $_POST['type'];
    	if($type == "1"){//根据元素查找角色
	    	$header = C('queryRoleOfElement');
	    	$SendMessage= new SendMessage;
	    	$data = $SendMessage ->send($header,$reqs);
	    	$roleList = $data['roleList'];
	    	$this->assign ('role', $roleList);
	    	$this->display('showElementOfRole');
    	}elseif($type == "2"){//根据元素查找用户
    		$header = C('queryUserOfElement');
    		$SendMessage= new SendMessage;
    		$data = $SendMessage ->send($header,$reqs);
    		$userList = $data['userList'];
    		$this->assign ('user', $userList);
    		$this->display('showElementOfUser');
    	}else{
    		//$this->display('showElementOfUser');
    	}
    	
    
    }
    
    //根据动作查找角色或用户
    function showActOfRes(){
    	$reqs = array("actionId"=>$_POST['actionids']);
    	$type = $_POST['type'];
    	if($type == "1"){//根据动作查找角色
    		$header = C('queryRoleOfAct');
    		$SendMessage= new SendMessage;
    		$data = $SendMessage ->send($header,$reqs);
    		$roleList = $data['roleList'];
    		$this->assign ('role', $roleList);
    		$this->display('showActOfRole');
    	}elseif($type == "2"){//根据动作查找用户
    		$header = C('queryUserOfAct');
    		$SendMessage= new SendMessage;
    		$data = $SendMessage ->send($header,$reqs);
    		$userList = $data['userList'];
    		$this->assign ('user', $userList);
    		$this->display('showActOfUser');
    	}else{
    		//$this->display('showElementOfUser');
    	}
    	
    }
    
    //显示元素列表
    function getElementByPro(){
    	$header = C('queryElements');

    	$request['pageNo'] = ($_POST['pageNum'] == "")? 1:$_POST['pageNum'];
    	$request['pageSize'] = $this->pageSize;
    	$request['queryCon']['productId'] = $_POST['productId'];
    	$request['queryCon']['elementName'] = $_POST['elementName'];
    	
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	$elements = $data['datalist'];
    	$this->assign ('elements', $elements);
    	
    	$this->display();
    	
    }
    
    
    //点击菜单获取动作列表
    function showActions(){
    	$header = C('queryActionOfMenu');
    	
    	$request['pageNo'] = ($_POST['pageNum'] == "")? 1:$_POST['pageNum'];
    	$request['pageSize'] = $this->pageSize;
    	$request['menuId'] = $_POST['menuId'];
    	 
    	$SendMessage= new SendMessage;
    	$data = $SendMessage ->send($header,$request);
    	$action = $data['actionList'];
    	$this->assign ('action', $action);
    	 print_r($action);
    	$this->display();
    	
    }
     
    
}