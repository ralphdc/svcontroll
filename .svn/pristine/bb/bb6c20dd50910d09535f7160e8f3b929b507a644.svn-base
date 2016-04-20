<?php
//Vendor('Hprose.SendMessage');
class IndexController extends CommonController {

    // 框架首页
	public function index() {
	    
	   /* 
	    *   Redis存储数据；
	    *  if(!$menuInfo = hashGet('ServiceLoginMenu',$jsid)){
	        $request = new CommunicationModel();
	        $getMenu = array('domain'=>'SERVICE_MANAGE');
	        $menuInfo = $request->curl_set_message(C('loginMenu'),$getMenu,true);
	        
	        hashSet('ServiceLoginMenu', array($jsid=>$menuInfo));
	    } */
	    
	   if(!$menus = $_SESSION['ServiceLoginMenu']){
	       $request = new CommunicationModel();
	       $getMenu = array('domain'=>C('LoginMark'));
	       $menuInfo = $request->do_service(C('loginMenu'),$getMenu);
	        
	       $res = strval($menuInfo);
	       
	       if(strlen($res) > 0){
	           $first = substr($res,strpos($res,"["));
	           $end = strrpos($first,"]");
	           $end ++;
	           $res_json = substr($first,0,$end);
	           $menus = json_decode($res_json,true);
	           $_SESSION['ServiceLoginMenu'] = $menus;
	           \Think\Log::write("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\获取菜单解析后的结果是：".print_r($menus,true));
	       }else{
	           $this->error("菜单未能获取，请重新登录！");
	       }
	   }
	   
	    
	    $this->assign ( 'menu', $menus);
	    $this->assign ( 'enviroment', C('CONST_ENVIRONMENT') );
	     C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
	     C ( 'SHOW_PAGE_TRACE', false );
	     $this->display ();
	}

}