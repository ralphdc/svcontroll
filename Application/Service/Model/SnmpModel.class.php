<?php

class SnmpModel extends CommunicationModel{
	

	private $urls = array(
	    //六、	新增snmp配置模板
	    'add'=>'/monitor/snmp/templatecreate',
	    //七、	分页获取snmp配置模板列表
	    'search'=>'/monitor/snmp/templatelistget',
	    //八、	获取单个snmp模板配置信息
	    'get'=>'/monitor/snmp/templateget',
	    //九、	删除单个snmp模板配置信息
	    'delete'=>'/monitor/snmp/templatedelete',
	    //十、	更新单个snmp模板配置信息
	    'update'=>'/monitor/snmp/templateupdate',
	    //十一、	批量删除snmp模板配置信息
	    'deletebatch'=>'/monitor/snmp/templatedeletebatch'
	);
	
	function findByPost ($post, $get) {
	
	    $Num = $post['pageNum']!='' ? $post['pageNum'] : 1;
	    if ($post['numPerPage']!='') {
	        setcookie('smnpPerPage',$post['numPerPage']);
	        $numPer = $post['numPerPage'];
	    }
	    else {
	        $numPer = $_COOKIE['smnpPerPage']!=0 ?$_COOKIE['smnpPerPage'] : C('PAGE_LISTROWS');
	    }
	
	    $pdata = $post ? json_encode($post) : "";
	    $reqStr = 'json='.$pdata.'&pageNo='.intval($Num).'&pageSize='.intval($numPer);
	    $request = array(
	        'content'=>$reqStr,
	        'length'=>strlen($reqStr),
	        'path'=>$this->urls['search']
	    );
	    $array = $this->request_by_other_v2($request);
	    $array = json_decode($array,true);
	    $result = $array['data'];
	    $this->count = $array['total'];
	    return $result;
	}
	
	/*
	 * 为其他模块弹出带回准备数据；
	 * 2016-04-05；
	 */
	function findByPostForQuery ($post, $get) {
	
	    $Num = $post['pageNum']!='' ? $post['pageNum'] : 1;
	    if ($post['numPerPage']!='') {
	        setcookie('querySnmpPerPage',$post['numPerPage']);
	        $numPer = $post['numPerPage'];
	    }
	    else {
	        $numPer = $_COOKIE['querySnmpPerPage']!=0 ?$_COOKIE['querySnmpPerPage'] : C('PAGE_LISTROWS');
	    }
	
	    $pdata = $post ? json_encode($post) : "";
	    $reqStr = 'json='.$pdata.'&pageNo='.intval($Num).'&pageSize='.intval($numPer);
	    $request = array(
	        'content'=>$reqStr,
	        'length'=>strlen($reqStr),
	        'path'=>$this->urls['search']
	    );
	    $array = $this->request_by_other_v2($request);
	    $array = json_decode($array,true);
	    $result = $array['data'];
	    $this->count = $array['total'];
	    return $result;
	}
	
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
	//删除一条记录；
	function delete($id)
	{
	    $request = array(
	        'content'=>"templateId=".$id,
	        'length'=>strlen("templateId=".$id),
	        'path'=>$this->urls['delete']
	    );
	    $result = $this->request_by_other_v2($request);
	    $result = json_decode($result,true);
	    return $result;
	}
	//获取一条信息；
	function get($id)
	{
	    $request = array(
	        'content'=>"templateId=".$id,
	        'length'=>strlen("nodeId=".$id),
	        'path'=>$this->urls['get']
	    );
	    $result = $this->request_by_other_v2($request);
	    $result = json_decode($result,true);
	    return $result;
	}
	
	//新增操作；
	function add($post)
	{
	    $request = array(
	        'content'=>"json=".json_encode($post),
	        'length'=>strlen("json=".json_encode($post)),
	        'path'=>$this->urls['add']
	    );
	    $result = $this->request_by_other_v2($request);
	    $result = json_decode($result,true);
	    return $result;
	}
	
	//编辑操作；
	function update($post)
	{
	    $request = array(
	        'content'=>"json=".json_encode($post),
	        'length'=>strlen("json=".json_encode($post)),
	        'path'=>$this->urls['update']
	    );
	    $result = $this->request_by_other_v2($request);
	    $result = json_decode($result,true);
	    return $result;
	}
	
	//批量删除；
	function batchdel($ids)
	{
	    $request = array(
	        'content'=>"templateIds=".$ids,
	        'length'=>strlen("templateIds=".$ids),
	        'path'=>$this->urls['deletebatch']
	    );
	    $result = $this->request_by_other_v2($request);
	    $result = json_decode($result,true);
	    return $result;
	}
	
}