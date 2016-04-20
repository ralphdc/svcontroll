<?php

class IndexController extends CommonController {

    // 框架首页
	public function index() {		
		if (isset ( $_SESSION[C('USER_AUTH_KEY')])) {
			//start
			//$volist=M("GroupClass")->where(array('status'=>1))->order("sort desc, id desc")->select();
			//$this->volist=$volist;
			//end
			
			//读取数据库模块列表生成菜单项
			$menu = array ();
			/*$header = array("destServID"=>16002,'messageID'=>'queryMenuOfUserService');
	      	$reqs = array("userId"=>$_SESSION[C('USER_AUTH_KEY')],"productId"=>"100",);
	      	
	      	$SendMessage= new SendMessage;
	      	$menulist = $SendMessage ->send($header,$reqs);
	      	$result = $menulist['menuList'];

			if(!empty($result)){
			 	foreach($result as $k1=>$v1){
			 		$upMenuId = $v1['upMenuId'];
			 		if($upMenuId !=""||$upMenuId !="0"){
			 			foreach($result as $k2 =>$v2 ){
			 				if($upMenuId == $v2['menuId']){
			 					$result[$k2]['sub'] = array();
			 					array_push($result[$k2]['sub'],$result[$k1]);
			 					unset($result[$k1]);
			 				}
			 			}
			 		}
			 	}
			}
			*/
			//start
			//$groups=M("Group")->where(array('group_menu'=>"{$volist[0]['menu']}",'status'=>"1"))->order("sort desc,id desc")->select();	
			//$this->assign("groups",$groups);
			//end
			$this->assign ( 'menu', $result );
		}

		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$this->display ();
	}

}