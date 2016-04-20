<?php
/**
 * 日志服务和java通信公共数据接口类子类（调用链详细情况页面）
 * @author zengguangqiu
 *
 */
class PidlinkModel extends CommunicationModel {
	var $method = array(
			'index'=>'xgd.log.history.chaindetail',
	);
	
	/**
	 * 根据POST过来的数据提取查询条件查询记录条数
	 * @param array $post
	 * @return int
	 */
	function countByPost ($post, $get) {
		if(empty($this->count)){
		   $this->count = 0;
		}
		return $this->count;	
	}
	
	/**
	 * 根据POST过来的数据提取查询条件查询记录
	 * @param array $post
	 * @return array
	 */
	function findByPost ($post, $get) {
		if(!Empty($post)){
			foreach ($post as $key=>$valus){
				$post[$key]=trim($valus," ");
			}
		}
		$Num = $post['pageNum']!='' ? $post['pageNum'] : 1;
		if ($post['numPerPage']!='') {
			setcookie('numPerPage'.$post['fromid'],$post['numPerPage']);
			$numPer = $post['numPerPage'];
		}
		else {
			$numPer = $_COOKIE['numPerPage'.$post['fromid']] ?$_COOKIE['numPerPage'.$post['fromid']] : 20;
		}
		$limit1 = (intval($Num)-1)*intval($numPer);
		$limit = array(intval($numPer),$limit1);
		$post['method']=$this->method['index'];
		$post['pageIndex']=intval($Num);
		$post['pageSize']=intval($numPer);
		$post = $this->formatPost($post,$get);
		//var_dump($post);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['rtndata'];
		$this->count = $result['count'];
		return $result['respList'];
	}
	
}