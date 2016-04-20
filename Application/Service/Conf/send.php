<?php
return array(

		
		/*工作流*/
		'showWorkProcess' => array("destServID"=>17000,'messageID'=>'request'),
		//登录类
		'loginIn' => array("destServID"=>16000,'messageID'=>'loginIn'),
		'loginOut' => array("destServID"=>16000,'messageID'=>'loginOut'),
		/*用户管理类*/
		'queryMenuListOfUser' =>array("destServID"=>16100,'messageID'=>'queryMenuListOfUser'),
		'addUser' => array("destServID"=>16100,'messageID'=>'addUser'),
		'queryUsers' => array("destServID"=>16100,'messageID'=>'queryUserListByPage'),
		'queryUser' => array("destServID"=>16100,'messageID'=>'queryUserById'),
		'resetPwd' => array("destServID"=>16100,'messageID'=>'resetPassword'),
		'updateUser' => array("destServID"=>16100,'messageID'=>'updateUser'),
		'deleteUser' => array("destServID"=>16100,'messageID'=>'disableUserById'),
		'assignRole' => array("destServID"=>16100,'messageID'=>'assignRoleToUser'),
		'Role2User' => array("destServID"=>16100,'messageID'=>'queryRoleListOfUserByPage'),
		'getDetailOfUser' => array("destServID"=>16100,'messageID'=>'queryAllResourceByUserId'),
		'getGrantUser' => array("destServID"=>16100,'messageID'=>'queryAllResourceByUserId'),
		'queryGroupListOfUserByPage' => array("destServID"=>16100,'messageID'=>'queryGroupListOfUserByPage'),		
		'queryRoleListOfUserByPage' => array("destServID"=>16100,'messageID'=>'queryRoleListOfUserByPage'),	
		'queryElementListOfUserByPage' => array("destServID"=>16100,'messageID'=>'queryElementListOfUserByPage'),
		'queryGroupListOfUserByPage'=> array("destServID"=>16100,'messageID'=>'queryGroupListOfUserByPage'),
		'modifyPassword'=> array("destServID"=>16100,'messageID'=>'modifyPassword'),
		'queryToAssignRoleListOfUserByPage'=> array("destServID"=>16100,'messageID'=>'queryToAssignRoleListOfUserByPage'),
		'removeRoleFromUser'=> array("destServID"=>16100,'messageID'=>'removeRoleFromUser'),
		'queryAssignedRoleListOfUserByPage'=> array("destServID"=>16100,'messageID'=>'queryAssignedRoleListOfUserByPage'),
		'queryUserListOfTaskByPage' =>array("destServID"=>16100,'messageID'=>'queryUserListOfTaskByPage'),
		//检查帐号的唯一性
		'checkUserExist' =>array("destServID"=>16100,'messageID'=>'checkUserExist'),

		
		/*用户组管理类*/
		'addUserGroup' => array("destServID"=>16101,'messageID'=>'addUserGroup'),
		'queryUserGroups' => array("destServID"=>16101,'messageID'=>'queryUserGroupListByPage'),
		'queryUserGroup' => array("destServID"=>16101,'messageID'=>'queryUserGroupById'),
		'deleteUserGroup' => array("destServID"=>16101,'messageID'=>'deleteUserGroupById'),
		'updateUserGroup' => array("destServID"=>16101,'messageID'=>'updateUserGroup'),
		'addUserToGroup' => array("destServID"=>16101,'messageID'=>'addUserToGroup'),
		'assignRoleToUserGroup' => array("destServID"=>16101,'messageID'=>'assignRoleToUserGroup'),
		'queryAllResourceByGroupId' => array("destServID"=>16101,'messageID'=>'queryAllResourceByGroupId'),
		'queryUserListOfGroupByPage' => array("destServID"=>16101,'messageID'=>'queryUserListOfGroupByPage'),
		'queryRoleListOfGroupByPage' => array("destServID"=>16101,'messageID'=>'queryRoleListOfGroupByPage'),
		'queryElementListOfGroupByPage' => array("destServID"=>16101,'messageID'=>'queryElementListOfGroupByPage'),
		'delUserFromGroup'=> array("destServID"=>16101,'messageID'=>'removeUserFromGroup'),
		'removeRoleFromGroup'=> array("destServID"=>16101,'messageID'=>'removeRoleFromGroup'),
		'queryToAssignRoleListOfProductByPage'=> array("destServID"=>16101,'messageID'=>'queryToAssignRoleListOfProductByPage'),
		'queryToAssignUserListOfGroupByPage'=> array("destServID"=>16101,'messageID'=>'queryToAssignUserListOfGroupByPage'),
		'queryGroupListOfTaskByPage'=>array("destServID"=>16101,'messageID'=>'queryGroupListOfTaskByPage'),
		//用户待授权的产品
		'queryProductforUserschose' =>array("destServID"=>16101,'messageID'=>'queryProductforUser'),
		//用户已经授权的产品
		'queryProductofUsers' =>array("destServID"=>16101,'messageID'=>'queryProductofUser'),
		/*角色管理类*/
		'addRole' => array("destServID"=>16102,'messageID'=>'addRole'),
		'deleteRole' => array("destServID"=>16102,'messageID'=>'deleteRoleByIds'),
		'updateRole' => array("destServID"=>16102,'messageID'=>'updateRole'),
		'queryRoles' => array("destServID"=>16102,'messageID'=>'queryRoleListByPage'),
		'queryRole' => array("destServID"=>16102,'messageID'=>'queryRoleById'),
		'elementToRole' => array("destServID"=>16102,'messageID'=>'assignElementToRole'),
		'menuActionToRole' => array("destServID"=>16102,'messageID'=>'assignMenuToRole'),
		//查看单个角色详细信息
		'queryRoleDetail' => array("destServID"=>16102,'messageID'=>'queryAllResourceByRoleId'),
		//查看多个角色详细信息
		'queryRolesDetail' => array("destServID"=>16102,'messageID'=>'queryAllResourceByRoleIds'),
		'queryUsersOfRole' => array("destServID"=>16102,'messageID'=>'queryUserListOfRoleByPage'),
		//
		'queryUsersOfRole' => array("destServID"=>16102,'messageID'=>'queryUserListOfRoleByPage'),
		//查看多个角色粗略信息
		'queryAllResource' => array("destServID"=>16102,'messageID'=>'queryAllResourceListByRoleIds'),
		'queryGroupListOfRoleByPage' => array("destServID"=>16102,'messageID'=>'queryGroupListOfRoleByPage'),
		'queryTaskNodeOfRole' => array("destServID"=>16102,'messageID'=>'queryTaskNodeOfRole'),
		'grantTaskNodeToRole' => array("destServID"=>16102,'messageID'=>'grantTaskNodeToRole'),
		'assignActionToRole' => array("destServID"=>16102,'messageID'=>'assignActionToRole'),
		'queryElementListOfRoleByPage'=> array("destServID"=>16102,'messageID'=>'queryElementListOfRoleByPage'),
		'queryToAssignElementListOfRoleByPage'=>array("destServID"=>16102,'messageID'=>'queryToAssignElementListOfRoleByPage'),
		'removeElementFromRole'=>array("destServID"=>16102,'messageID'=>'removeElementFromRole'),
		'queryRoleListOfTaskByPage'=>array("destServID"=>16102,'messageID'=>'queryRoleListOfTaskByPage'),
		'queryActionListOfRoleByPage'=>array("destServID"=>16102,'messageID'=>'queryActionListOfRoleByPage'),
		'queryElementListOfRoleByPage'=>array("destServID"=>16102,'messageID'=>'queryElementListOfRoleByPage'),
		/*授权管理类*/
		//分页查询
		'authUserQuery' => array("destServID"=>16106,'messageID'=>'authUserQueryByPageService'),
		//授权给用户服务入口 
		'authUserGrant' => array("destServID"=>16106,'messageID'=>'authUserGrantService'),
		//收回授权给用户的权限相关服务
		'authUserInvoke' => array("destServID"=>16106,'messageID'=>'authUserInvokeService'),
		//查看授权
		'queryPrivilege' => array("destServID"=>16106,'messageID'=>'queryPrivilegeOfUser'),
		//给用户授权
		'grantToUser' => array("destServID"=>16106,'messageID'=>'grantPrivilegeToUser'),
		'invokePrivilegeFromUser' =>array("destServID"=>16106,'messageID'=>'invokePrivilegeFromUser'),
		
		
		/*产品管理类*/
		'addProduct' => array("destServID"=>16107,'messageID'=>'addProduct'),
		'deleteProduct' => array("destServID"=>16107,'messageID'=>'deleteProductByIds'),
		'updateProduct' => array("destServID"=>16107,'messageID'=>'updateProduct'),
		'queryProducts' => array("destServID"=>16107,'messageID'=>'queryProductListOfUser'),
		//产品管理页面，展示产品
		'showProducts' => array("destServID"=>16107,'messageID'=>'queryProductListByPage'),
		'queryProduct' => array("destServID"=>16107,'messageID'=>'queryProductById'),
		'assigOpProductToUser' => array("destServID"=>16107,'messageID'=>'assigOpProductToUser'),
		'invokeOpProductFromUser' => array("destServID"=>16107,'messageID'=>'invokeOpProductFromUser'),
		'queryOpProductListOfUserByPage' =>array("destServID"=>16107,'messageID'=>'queryUserListOfOpProductByPage'),
		'queryToAssignUserListByPage'=>array("destServID"=>16107,'messageID'=>'queryToAssignUserListByPage'),
		//用户编辑权限页，用户待授权的产品
		'queryToAssignProductListOfUserByPage' =>array("destServID"=>16107,'messageID'=>'queryToAssignProductListOfUserByPage'),
		//用户编辑权限页，用户已经授权的产品
		'queryAssignedProductListOfUserByPage' =>array("destServID"=>16107,'messageID'=>'queryAssignedProductListOfUserByPage'),
		//删除用户的产品
		'removeProductFromUser' =>array("destServID"=>16107,'messageID'=>'removeProductFromUser'),
		//增加用户的产品
		'assigProductToUser' =>array("destServID"=>16107,'messageID'=>'assigProductToUser'),
		//主页展示用户权限页
		'queryProductListOfUserByPage' =>array("destServID"=>16107,'messageID'=>'queryProductListOfUserByPage'),
		//用户组编辑权限页，用户组待授权的产品
		'queryToAssignProductListOfUserGroupByPage' =>array("destServID"=>16107,'messageID'=>'queryToAssignProductListOfUserGroupByPage'),
		//用户组编辑权限页，用户组已经授权的产品
		'queryAssignedProductListOfUserGroupByPage'=>array("destServID"=>16107,'messageID'=>'queryAssignedProductListOfUserGroupByPage'),
		//用户组编辑权限页，给用户组授权产品
		'assigProductToUserGroup'=>array("destServID"=>16107,'messageID'=>'assigProductToUserGroup'),
		//用户组编辑权限页，删除用户组的产品
		'removeProductFromUserGroup' =>array("destServID"=>16107,'messageID'=>'removeProductFromUserGroup'),
		/*参数管理类*/
		'addParam' => array("destServID"=>16108,'messageID'=>'addParam'),
		'deleteParam' => array("destServID"=>16108,'messageID'=>'deleteParamByIds'),
		'updateParam' => array("destServID"=>16108,'messageID'=>'updateParam'),
		'queryParams' => array("destServID"=>16108,'messageID'=>'queryParamListByPage'),
		'queryParam' => array("destServID"=>16108,'messageID'=>'queryParamById'),
		'queryParamListOfItemByPage' =>array("destServID"=>16108,'messageID'=>'queryParamListOfItemByPage'),
		/*菜单管理类*/
		'addMenu' => array("destServID"=>16103,'messageID'=>'addMenu'),
		'queryMenus' => array("destServID"=>16103,'messageID'=>'queryMenuTreeByProductId'),
		'queryMenu' => array("destServID"=>16103,'messageID'=>'queryMenuById'),
		'updateMenu' => array("destServID"=>16103,'messageID'=>'updateMenu'),
		'deleteMenu' => array("destServID"=>16103,'messageID'=>'deleteMenuById'),
		'queryMenuAction' => array("destServID"=>16103,'messageID'=>'queryMenuActionTreeByMenuIds'),
		'queryMenuOfRole' => array("destServID"=>16103,'messageID'=>'queryRoleListOfMenuByPage'),
		'queryMenuOfUser' => array("destServID"=>16103,'messageID'=>'queryUserListOfMenuByPage'),
		'queryGroupListOfMenuByPage' => array("destServID"=>16103,'messageID'=>'queryGroupListOfMenuByPage'),
		'exportMenuListSql' =>array("destServID"=>16103,'messageID'=>'exportMenuListSql'),
		/*动作管理类*/
		'addAction' => array("destServID"=>16104,'messageID'=>'addActionList'),
		'deleteAction' => array("destServID"=>16104,'messageID'=>'deleteActionByIds'),
		'updateAction' => array("destServID"=>16104,'messageID'=>'updateAction'),
		'queryActions' => array("destServID"=>16104,'messageID'=>'queryActionListByPage'),
		'queryAction' => array("destServID"=>16104,'messageID'=>'queryActionById'),
		'queryActionOfMenu' => array("destServID"=>16104,'messageID'=>'queryActionListByMenuId'),
		'queryRoleOfAct' => array("destServID"=>16104,'messageID'=>'queryRoleListOfActionByPage'),
		'queryUserOfAct' => array("destServID"=>16104,'messageID'=>'queryUserListOfActionByPage'),
		'queryUserGroupOfAct' => array("destServID"=>16104,'messageID'=>'queryUserGroupListByActionId'),
		'queryGroupListOfActionByPage' => array("destServID"=>16104,'messageID'=>'queryGroupListOfActionByPage'),
		'queryActionListOfProduct' => array("destServID"=>16104,'messageID'=>'queryActionListOfProduct'),
		'exportActionListSql'=> array("destServID"=>16104,'messageID'=>'exportActionListSql'),
		'queryToAssignActionListOfProduct'=>array("destServID"=>16104,'messageID'=>'queryToAssignActionListOfProduct'),
		 /*元素管理类*/
		'addElement' => array("destServID"=>16105,'messageID'=>'addElement'),
		'deleteElement' => array("destServID"=>16105,'messageID'=>'deleteElementByIds'),
		'updateElement' => array("destServID"=>16105,'messageID'=>'updateElement'),
		'queryElements' => array("destServID"=>16105,'messageID'=>'queryElementListByPage'),
		'queryElement' => array("destServID"=>16105,'messageID'=>'queryElementById'),
		'queryRoleOfElement' => array("destServID"=>16105,'messageID'=>'queryRoleListOfElementByPage'),
		'queryUserOfElement' => array("destServID"=>16105,'messageID'=>'queryUserListOfElementByPage'),
		'queryUsrGroupOfElement' => array("destServID"=>16105,'messageID'=>'queryUserGroupListOfElementByPage'),
		'queryGroupListOfElementByPage' => array("destServID"=>16105,'messageID'=>'queryGroupListOfElementByPage'), 
		'exportElementListSql' => array("destServID"=>16105,'messageID'=>'exportElementListSql'), 
		/*机构管理类*/
		'addOrg' => array("destServID"=>16109,'messageID'=>'addOrg'),
		'deleteOrg' => array("destServID"=>16109,'messageID'=>'deleteOrgById'),
		'updateOrg' => array("destServID"=>16109,'messageID'=>'updateOrg'),
		'queryOrgs' => array("destServID"=>16109,'messageID'=>'queryOrgTreeList'),
		'queryOrg' => array("destServID"=>16109,'messageID'=>'queryOrgById'),

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
);
?>