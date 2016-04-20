<?php
use Think\Controller;
class IndexController  extends CommonController {
	
    // 框架首页
	public function index() {
		if($_SESSION[C('USER_AUTH_KEY')]){
			C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
			C ( 'SHOW_PAGE_TRACE', false );
			$this->display ();
		}else{
			header('Location:'. __MODULE__.'/Public/login/');
		}
	}

}