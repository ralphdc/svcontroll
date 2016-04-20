<?php

class LogRecordController extends CommonController {

    // 框架首页
	public function index() {
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$this->display ();
	}
	public function craftSet()
	{
		$this->display ();
	}
	
	/* Public function update()
	{
		$this->dwzReturn(null,300,'两次密码不一样');
	} */

}