<?php 
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 囚鸟先生
// +----------------------------------------------------------------------
// $Id: ArticleController.class.php 2014-05-17 23:58:02 $
use Think\Controller;
use Org\Util\Rbac;
use Think;

class CommonController extends Controller {

    function _initialize() {
        // 用户权限检查
       /* if (C('USER_AUTH_ON') && !in_array(MODULE_NAME, explode(',', C('NOT_AUTH_MODULE')))) { 
           if (!RBAC::AccessDecision()) { 
            	if(!$_SESSION[C('USER_AUTH_KEY')]){
            		$ret = array(
			    		"statusCode"=>"301",
			    		"message"=>"登录超时，请重新登录",
			    		"navTabId"=>"",
			    		"callbackType"=>"",
			    		"forwardUrl"=>"",
			    	);
            		echo  json_encode($ret); exit;
            	}
              
            }
        }*/
    }
     
    /**
      +----------------------------------------------------------
     * Index页显示
     * 
     */    
    public function index($dwz_db_name = '') {
        //列表过滤器，生成查询Map对象
        $dwz_db_name=$dwz_db_name ? $dwz_db_name : $this->getActionName();
        $model = CM($dwz_db_name);
        $map = $this->_search($dwz_db_name); 
        $this->assign("map",$map);         
        if (method_exists($this, '_filter')) {
           $this->_filter($map);
        }        
        if (!empty($model)) {
           $this->_list($model, $map);
        }

        $this->display();
    }


    /**
      +----------------------------------------------------------
     * 根据表单生成查询条件
     * 进行列表过滤
      +----------------------------------------------------------
     * @access protected
      +----------------------------------------------------------
     * @param string $dwz_db_name 数据对象名称
      +----------------------------------------------------------
     * @return HashMap
      +----------------------------------------------------------
     * @throws ThinkExecption
      +----------------------------------------------------------
     */
    protected function _search($dwz_db_name = '') {
        $dwz_db_name=$dwz_db_name ? $dwz_db_name : $this->getActionName();
        //生成查询条件
        $model = CM($dwz_db_name);
        $map = array();
        foreach ($model->getDbFields() as $key => $val) {
            if (isset($_REQUEST [$val]) && $_REQUEST [$val] != '') {
                $map [$val] = $_REQUEST [$val];
            }
        }
        return $map;
    }

    /**
      +----------------------------------------------------------
     * 根据表单生成查询条件
     * 进行列表过滤
      +----------------------------------------------------------
     * @access protected
      +----------------------------------------------------------
     * @param Model $model 数据对象
     * @param HashMap $map 过滤条件
     * @param string $sortBy 排序
     * @param boolean $asc 是否正序
      +----------------------------------------------------------
     * @return void
      +----------------------------------------------------------
     * @throws ThinkExecption
      +----------------------------------------------------------
     */
    protected function _list($model, $map='', $sortBy = '', $asc = false) {
        {           
            //创建分页对象  ,默认10条记录
            if (! empty ( $_REQUEST ['listRows'] )) {
              $listRows = $_REQUEST ['listRows'];
            } else {
              $listRows = '10';
            }                       
           
            $pageSize =empty($_REQUEST['numPerPage']) ? $this->pageSize : $_REQUEST['numPerPage'];            
            //分页查询数据          
            $pageNum = !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1;
            $data = array();
            $data['data']['pageNum'] = $pageNum;   
            $data['data']['pageSize'] = $pageSize;
            if($_REQUEST){
            	foreach($_REQUEST as $k=>$v){
            		if($v !=''){
            			if($k != 'method'){
            				$data['data'][$k] = $v;
            			}
            		}
            	}
            }
            $voList = $model->findall($data);
            $result = $voList['data'];
            $count = $voList['total'];
            //分页跳转的时候保证查询条件
            $p = new Think\Page($count, $listRows);         
            //分页显示
            $page = $p->show();            
            //模板赋值显示
            $this->assign('list', $result);                     
            $this->assign("page", $page);
        }
		//print_r($result);
        //囚鸟先生
        $this->assign ( 'numStart', ($pageNum-1)*$pageSize );
        $this->assign ( 'totalCount', $count );
        $this->assign ( 'pageSize', $pageSize ); //每页显示多少条
        $this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
        cookie('_currentUrl_', __SELF__);
        return;
    }
    
    
    protected function _Tradelist($model, $map, $sortBy = '', $asc = false) {
    	{
    		//创建分页对象  ,默认10条记录
    		if (! empty ( $_REQUEST ['listRows'] )) {
    			$listRows = $_REQUEST ['listRows'];
    		} else {
    			$listRows = '10';
    		}
    		 
    		$pageSize =empty($_REQUEST['numPerPage']) ? $this->pageSize : $_REQUEST['numPerPage'];
    		//分页查询数据
    		$pageNum = !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1;
    		$data = array();
    		$data['pageNum'] = $pageNum;
    		$data['pageSize'] = $pageSize;
    		if($_REQUEST){
    			foreach($_REQUEST as $k=>$v){
    				if($v !=''){
    					if($k != 'method'){
    						$data[$k] = $v;
    					}
    				}
    			}
    		}
    		$voList = $model->findallTrade($data);
    		
    		$result = $voList['data'];
    		$count = $voList['total'];
    		//分页跳转的时候保证查询条件
    		$p = new Think\Page($count, $listRows);
    		foreach ( $map as $key => $val ) {
    			if (! is_array ( $val )) {
    				$p->parameter .= "$key=" . urlencode ( $val ) . "&";
    			}
    		}
    		//分页显示
    		$page = $p->show();
    		//模板赋值显示
    		$this->assign('list', $result);
    		$this->assign("page", $page);
    	}
    	//print_r($result);
    	//囚鸟先生
    	$this->assign ( 'numStart', ($pageNum-1)*$pageSize );
    	$this->assign ( 'totalCount', $count );
    	$this->assign ( 'pageSize', $pageSize ); //每页显示多少条
    	$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
    	cookie('_currentUrl_', __SELF__);
    	return;
    }
    
    function _find($model){
    	//创建分页对象  ,默认10条记录
    	if (! empty ( $_REQUEST ['listRows'] )) {
    		$listRows = $_REQUEST ['listRows'];
    	} else {
    		$listRows = '10';
    	}
    	 
    	$pageSize =empty($_REQUEST['numPerPage']) ? $this->pageSize : $_REQUEST['numPerPage'];
    	//分页查询数据
    	$pageNum = !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1;
    	$data = array();
    	$data['data']['pageNum'] = $pageNum;
    	$data['data']['pageSize'] = $pageSize;
    	if($_REQUEST){
    		foreach($_REQUEST as $k=>$v){
    			if($v !=''){
    				if($k != 'method'){
    					$data['data'][$k] = $v;
    				}
    			}
    		}
    	}
    	$result = $model->findall($data);
    	return $result;
    }
    //insert
    function insert($dwz_db_name = '') {
        $dwz_db_name=$dwz_db_name ? $dwz_db_name : $this->getActionName();
        $model = CM($dwz_db_name);
        if (false === $model->create()) {//添加主键和键值校验
            $this->error($model->getError());
        }

        if(!empty($_REQUEST['tradeMethod'])){
        	//添加机器（实例）的时候先判断机器名称是否存在
        	if($_REQUEST['tradeMethod'] == 'addMachine' ){
        		$check = $model->getDataBase('checkmachinename');
        		if($check['errorCode'] == '-1'){
        			//失败提示
        			$this->error('机器名称已存在!');return;
        		}
        	}
        	$result = $model->getTradeData();
        	if($result['resposeCode'] == 'success'){
	        	$ret = $model->add();
	        	if($ret['errorCode'] === 0) { //保存成功
	        		$ret = array("statusCode"=>"1","message"=>'新增成功',"navTabId"=>'',//$this->navTab
	        				"rel"=>"","forwardUrl"=>"","callbackType"=>"");
	        		echo json_encode($ret);	return;
	        	}else{
	        		//失败提示
	        		$this->error('新增失败!'.$ret['errorMessage']);
	        	}
        	}else{
        		$this->error('调用容器服务失败!'.$result['errorMessage'],cookie('_currentUrl_'));
        	}
        }else{
        	$ret = $model->add();
        	if($ret['errorCode'] === 0) { //保存成功
        		$ret = array("statusCode"=>"1","message"=>'新增成功',"navTabId"=>'',//$this->navTab
        				"rel"=>"","forwardUrl"=>"","callbackType"=>"");
        		echo json_encode($ret);	return;
        	}else{
        		//失败提示
        		$this->error('新增失败!'.$ret['errorMessage']);
        	}
        }
        
        
    }

    function add() {
        $this->display();
    }

    function edit($dwz_db_name = ''){ 
        $dwz_db_name=$dwz_db_name ? $dwz_db_name : $this->getActionName();        
        $model = CM($dwz_db_name);
        $result = $model->findbypk();
        $vo = $result['dataList'];
        //print_r($vo);
        $this->assign('vo', $vo);
        $this->display();
       
    }

    function update($dwz_db_name = '') {  
    	//一键修改配置参数
    	if($_REQUEST['method'] == 'batUpdate'){
    		$expandCondition = '';
    		$count = count($_REQUEST['params']);
    		for($i=0;$i<$count;$i++){
    			if($_REQUEST['paramsvalue'][$i] == ''){
    				$this->error('配置项值不能为空!');
    			}
    			$expandCondition .= $_REQUEST['params'][$i].':'.$_REQUEST['paramsvalue'][$i].';';
    		}
    		unset($_REQUEST['params']); 
    		unset($_REQUEST['paramsvalue']);
    		$_REQUEST['expandCondition'] = $expandCondition;
    	}
    	
        $dwz_db_name=$dwz_db_name ? $dwz_db_name : $this->getActionName();       
        $model = CM($dwz_db_name);
        if (false === $model->create()) {
            $this->error($model->getError());
        }

        //验证 修改路由规则和扩展条件
        if($_REQUEST['method'] == 'updateExposeService'){
        	if($_REQUEST['routeRule'] !=''){
	        	$check = $this->checkRule($_REQUEST['routeRule']);
				if($check == 1){
					$ret = array("statusCode"=>"0","message"=>'路由规则输入不正确!',"navTabId"=>'',//$this->navTab
							"rel"=>"","forwardUrl"=>"","callbackType"=>"");
					echo json_encode($ret);return;
				}
        			
        	}
        	if($_REQUEST['expandCondition'] !=''){
        		$check = $this->checkRule($_REQUEST['expandCondition']);
        		if($check == 1){
        			$ret = array("statusCode"=>"0","message"=>'扩展条件输入不正确!',"navTabId"=>'',//$this->navTab
        					"rel"=>"","forwardUrl"=>"","callbackType"=>"");
        			echo json_encode($ret);return;
        		}
        	}

        }
        

        if(!empty($_REQUEST['tradeMethod'])){
        	$result = $model->getTradeData();
        	if($result['resposeCode'] == 'success'){
        		$ret = $model->save();
	        	if ($ret['errorCode'] == 0) { //保存成功
	        		$this->success('修改成功!',cookie('_currentUrl_'));
	        	}else{
	        		//失败提示
	        		$this->error('修改失败!'.$ret['errorMessage']);
	        	}
        	}else{
        		$this->error('调用容器服务失败!'.$result['errorMessage'],cookie('_currentUrl_'));
        	}
        }else{
        	$ret = $model->save();
        	if ($ret['errorCode'] == 0) { //保存成功
        		$this->success('修改成功!',cookie('_currentUrl_'));
        	}else{
        		//失败提示
        		$this->error('修改失败!'.$ret['errorMessage']);
        	}
        }
    }



    public function foreverdelete($dwz_db_name = '') {
        $dwz_db_name=$dwz_db_name ? $dwz_db_name : $this->getActionName();
        //删除指定记录         
        $model = CM($dwz_db_name);
        if (false === $model->create()) {//将提交的数据保存到this->data中
        	$this->error($model->getError());
        }
        
     	// 更新数据
        if(!empty($_REQUEST['tradeMethod'])){
	        $ret = $model->deleteTradedata();
	    	if ($ret['resposeCode'] == 'success') { //删除成功
	    		if(!empty($_REQUEST['method'])){
	    			$result = $model->delete();
	    			if($result['errorCode'] == '0'){
	    				$this->success('删除成功!',cookie('_currentUrl_'));
	    			}else{
	    				$this->error('删除失败!'.$result['errorMessage'],cookie('_currentUrl_'));
	    			}
	    		}else{
	    			$this->success('删除成功!',cookie('_currentUrl_'));
	    		}
	           
	        } else {
	            //失败提示
	            $this->error('调用容器服务失败!'.$ret['errorMessage']);
	        }
        }else{
        	$result = $model->delete();
        	if($result['errorCode'] == '0'){
        		$this->success('删除成功!',cookie('_currentUrl_'));
        	}else{
        		$this->error('删除失败!'.$result['errorMessage'],cookie('_currentUrl_'));
        	}
        }
    }
    
    public function show($dwz_db_name = '') {
        //列表过滤器，生成查询Map对象
        $dwz_db_name=$dwz_db_name ? $dwz_db_name : $this->getActionName();
        $model = CM($dwz_db_name);
        $map = $this->_search($dwz_db_name); 
        $this->assign("map",$map);         
        if (method_exists($this, '_filter')) {
           $this->_filter($map);
        }        
        if (!empty($model)) {
          // $this->_list($model, $map);
           $result = $this->_find($model, $map);
        }

        echo $result;
    }
    
    public function checkRule($rule,$title){
    	$preg = '/(\w+:\w+)+(;\w+:\w+)?/';
    	$rule_preg = preg_match($preg,$rule);
    	$pos1  =  strpos ( $rule ,  "：" );
    	$pos2  =  strpos ( $rule ,  "；" );
    	if($rule_preg == 0 || $pos1 == true||$pos2 == true){
    		return 1;
    	}else{
    		return 0;
    	}
    }
    
    public function stopPLService($dwz_db_name = '') {
    	$dwz_db_name=$dwz_db_name ? $dwz_db_name : $this->getActionName();
    	//删除指定记录
    	$model = CM($dwz_db_name);
    	unset($_POST['serverId']);
    	if (false === $model->create()) {//将提交的数据保存到this->data中
    		$this->error($model->getError());
    	}
    	// 更新数据
    	$ret = $model->deleteTradedata();
    	if ($ret['resposeCode'] == 'success') { //删除成功
    		$returndata = array("statusCode"=>"200","message"=>'停止服务成功!',"navTabId"=>'',//$this->navTab
    			"rel"=>"","forwardUrl"=>"","callbackType"=>"");
    		echo json_encode($returndata);return;
    		 
    	} else {
    		//失败提示
    		$this->error('调用容器服务失败!'.$ret['errorMessage']);
    	}
    }
    
    
    //一键修改配置参数
 /*	public function updateAllPLService($dwz_db_name = '') {
    	$dwz_db_name=$dwz_db_name ? $dwz_db_name : $this->getActionName();
    	//删除指定记录
    	$model = CM($dwz_db_name);
    	if (false === $model->create()) {//将提交的数据保存到this->data中
    		$this->error($model->getError());
    	}
    	//更新数据
    	$ret = $model->deleteTradedata();
    	if ($ret['resposeCode'] == 'success') { //删除成功
    		if(!empty($_REQUEST['method'])){
    			$result = $model->delete();
    			if($result['errorCode'] == '0'){
    				$this->success('一键修改配置成功!',cookie('_currentUrl_'));
    			}else{
    				$this->error('一键修改配置失败'.$result['errorMessage'],cookie('_currentUrl_'));
    			}
    		}else{
    			$this->success('一键修改配置成功!',cookie('_currentUrl_'));
    		}
    		 
    	} else {
    		//失败提示
    		$this->error('调用容器服务失败!'.$ret['errorMessage']);
    	}
    } */
    

  

}