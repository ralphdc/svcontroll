<?php
/**
 * 服务管服务和java通信公共数据接口类子类（运维成员管理）
 * @author zengguangqiu
 *
 */
class OperatmemberModel extends CommunicationModel {
	var $method = array(
			'index'=>'monitor.staff.search',
			'add'=>'monitor.staff.create',
			'update'=>'monitor.staff.update',
			'delete'=>'monitor.staff.deletebatch',
			'deleteall'=>'monitor.staff.deletebatch',
			'getrow'=>'monitor.staff.get',
			'createprivate'=>'monitor.staff.rights.create',
			'copyprivate'=>'monitor.staff.rights.copy',
			'getright'=>'monitor.staff.rights.get',
			'getall' =>'monitor.staff.load',
	        'getTree'=>'monitor.group.tree.get',
	        'createGroup'=>'monitor.elem.group.create',
	        'getUnaddedStaff'=>'monitor.elem.groupstaff.get',
	        'submitStaff'=>'monitor.elem.groupstaff.create',
	         //删除群组；
	        'deleteGroup'=>'monitor.elem.group.delete',
	         //删除群组下联系人；
	        'deleteGroupStaff'=>'monitor.group.staff.delete',
	        //获取监控元素联系人与群组
	        'getGroupAndStaff'=>'monitor.groupstaff.load',
	        'updateStaffNotice'=>'group_staff_notice_update',
	        'updateGroupName'=>'monitor.elem.group.update',
	        'invite'=>'monitor.staff.invite.create',
	        //同步至微信平台，获取所有部门列表；
	        'getdeparts'=>'monitor.departments.get',
	        //获取成员部门列表
	        'getstaffdeparts'=>'monitor.staff.departments.get',
	        'syncwechat'=>'monitor.staff.weixin.create'
	        
			
	);
	/**
	 * 保存和更新操作重写父类的方法
	 * @see CommunicationModel::postSave()
	 */
	function postSave($post,$get=null){
		$result = '';
		if($post['form_act']=='create'){
			$post['key'] = $this->method['add'];
			$post = $this->formatPost($post,$get);
			$result =$this->request_by_other( $post);
		}elseif($post['form_act']=='update'){
			$post['key'] = $this->method['update'];
			$post = $this->formatPost($post,$get);
			$result = $this->request_by_other($post);
		}
		return json_decode($result,true);
	}
	/**
	 * 保存和更新权限
	 * @param array $post
	 * @param array $get
	 * @return array
	 */
	function postSavePrivate($post,$get=null){
		$result = '';
		if($post['form_act']=='create'){
			$post['key'] = $this->method['createprivate'];
			$post = $this->formatPost($post,$get);
			$result =$this->request_by_other( $post);
		}elseif($post['form_act']=='copy'){
			$post['key'] = $this->method['copyprivate'];
			$post = $this->formatPost($post,$get);
			$result = $this->request_by_other($post);
		}
		return json_decode($result,true);
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
	
	/**
	 * 根据POST过来的数据提取查询条件查询记录
	 * @param array $post
	 * @return array
	 */
	function findByPost ($post, $get) {
		if(!empty($post)){
			foreach ($post as $key=>$valus){
				$post[$key]=trim($valus," ");
			}
		}
		$Num = $post['pageNum']!='' ? $post['pageNum'] : 1;
		if ($post['numPerPage']!='') {
			setcookie('operate_numPerPage',$post['numPerPage']);
			$numPer = $post['numPerPage'];
		}
		else {
			$numPer = $_COOKIE['operate_numPerPage']!=0 ?$_COOKIE['operate_numPerPage'] : 20;
		}
		$limit1 = (intval($Num)-1)*intval($numPer);
		$limit = array(intval($numPer),$limit1);
		$post['key']=$this->method['index'];
		$post['data']['name'] = $post['name'];
		$post['data']['mobile'] = $post['mobile'];
		$post['page']['pageNo']=intval($Num);
		$post['page']['pageSize']=intval($numPer);
		$post = $this->formatPost($post,$get);
		$array = $this->request_by_other($post,$get);
		$array = json_decode($array,true);
		$result = $array['data'];
		$this->count = $array['total'];
		return $result;
	}
	/**
	 * 根据ID获取一行记录
	 * @param int $id
	 */
	function getRowInfo($id)
	{
		$post['id'] = $id;
		$post['key']=$this->method['getrow'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['data'];
	}
	/**
	 * 删除单个的接口
	 * @param string $id
	 */
	function delete($ids)
	{
		$post['key']=$this->method['delete'];
		$post['data']['ids'] = $ids[0];
		$post['data']['userIds'] = $ids[1];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}
	/**
	 * 删除多个的接口
	 * @param string $ids
	 */
	function deleteAll($idinfo)
	{
		$post['key']=$this->method['deleteall'];
		$post['data']['ids'] = $idinfo[0];
		$post['data']['userIds'] = $idinfo[1];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array;
	}
	/**
	 * 
	 * 获取对应的选中的玩家的所有的权限
	 * @param int $id
	 */
	function getAllrights($id)
	{
		$post['key']=$this->method['getright'];
		$post['id'] = $id;
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['data'][0]['rights'];
	}
	/**
	 * 获取所有的运维成员信息
	 * @see CommunicationModel::getAll()
	 */
	function getAll($post, $get)
	{
		$post['key']=$this->method['getall'];
		$post = $this->formatPost($post);
		$array = $this->request_by_other($post);
		$array = json_decode($array,true);
		return $array['data'];
	}
	
	/**
	 * 展示所创建群组联系人树
	 * 2015-11-30
	 */
	
	function getGroupTree()
	{
	    $post['key']=$this->method['getTree'];
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    return $array['data'];
	}
	
	function modelCreateGroup($post)
	{
	    $post['key']=$this->method['createGroup'];
	    $post['data']['groupName']=$post['group'];
	    $post['data']['groupDescription']=$post['des'];
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    return $array;
	}
	
	//monitor.elem.group.update；
	// 更新组名；
	function modelEditGroup($post)
	{
	    $post['key']=$this->method['updateGroupName'];
	    $post['data']['groupId']=$post['groupid'];
	    $post['data']['groupName']=$post['group'];
	    $post['data']['groupDescription']=$post['des'];
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    return $array;
	}
	
	function modelGetStaffList($id)
	{
	    $post['key']=$this->method['getUnaddedStaff'];
	    $post['id'] = $id;
	    $post['page']['pageSize'] =empty($_REQUEST['numPerPage']) ? C('PAGE_LISTROWS') : $_REQUEST['numPerPage'];
	    $post['page']['pageNo'] =!empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1;
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    $this->count = $array['total'];
	    return $array;
	}
	
	function modelSubmitStaff($data)
	{
	    $post['key']=$this->method['submitStaff'];
	    $post['data']=$data;
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    return $array;
	}
	
	//删除群组；
	function modelDeleteGroup($id)
	{
	    $post['key']=$this->method['deleteGroup'];
	    $post['id']=$id;
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    return $array;
	}
	
	//删除群组下联系人；
	function modelDeleteStaff( $data )
	{
	    $post['key']=$this->method['deleteGroupStaff'];
	    $post['data']=$data;
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    return $array;
	}
	
	//获取联系人和群组；
	function modelGetGroupAndStaff()
	{
	    $post['key']=$this->method['getGroupAndStaff'];
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    return $array;
	}
	//更新成员通知方式；
	function modelUpdateStaffNotice($data)
	{
	    $post['key']=$this->method['updateStaffNotice'];
	    $post['data'] = $data;
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    return $array;
	}
	
	function modelInviteFollow($id){
	    $post['key']=$this->method['invite'];
	    $post['id']=$id;
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    return $array;
	}
	
	//获取成员已经选择的部门；
	function modelGetStaffDepart($wechatid)
	{
	    $post['key']=$this->method['getstaffdeparts'];
	    $post['id']=$wechatid;
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    return $array;
	}
	
	//获取所有部门；
	function modelGetDeparts($id)
	{
	    $post['key']=$this->method['getdeparts'];
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    return $array['data']['department'];;
	    
	}
	
	function modelSyncSubmit($ids,$info)
	{
	    $post['key']=$this->method['syncwechat'];
	    $post['id']=$ids;
	    
	    $post['data']['staffName']=$info['staffName'];
	    $post['data']['staffPhoneNo']=$info['staffPhoneNo'];
	    $post['data']['staffEmail']=$info['staffEmail'];
	    $post['data']['wechatId']=$info['wechatId'];
	    
	    $post = $this->formatPost($post);
	    $array = $this->request_by_other($post);
	    $array = json_decode($array,true);
	    return $array;
	}
}