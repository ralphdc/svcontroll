<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" action="/index.php/Service/Operatmember" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>


<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/index.php/Service/Operatmember" method="post">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
			<label>联系人：</label>
			<input type="text" value="<?php echo ($_REQUEST['name']); ?>" id="name" name="name" class="textInput">
			</li>
			<li>
			<label>手机号码：</label>
			<input type="text" value="<?php echo ($_REQUEST['mobile']); ?>" id="mobile" name="mobile" class="textInput">
			</li>
		</ul>
		<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div></li>
			</ul>
		</div>
	</div>
	</form>
	<div class="monitor_des">黑色标记为未同步到微信后台用户数据；橙色为已经同步但未关注用户数据；蓝色为关注成功用户数据</div>
</div>

<div class="pageContent">
	<div class="panelBar" style="height:29px;">
		<ul class="toolBar">
			<li><a class="add" href="/index.php/Service/Operatmember/add" title="新增" target="dialog" mask="true" height="298" width="440"><span>新增</span></a></li>
			<li><a posttype="string" title="确实要删除选中记录吗？" rel="ids" target="selectedTodo" class="delete" href="/index.php/Service/Operatmember/foreverdelete/id/{sid_user}"><span>批量删除选中</span></a></li>
			<li class="line">line</li>
			<li><a warn="请选择要分配权限的人" title="分配权限给运维人员" rel="SetPrivate" max="true" target="dialog" href="/index.php/Service/Operatmember/setprivate/staffId/{sid_user}" class="add"><span>分配权限</span></a></li>
			<li class=""><a warn="请选中要复制权限的人" title="复制权限" max="true" rel="CopyPrivate" target="dialog" href="/index.php/Service/Operatmember/copyprivate/staffId/{sid_user}" class="add"><span>复制权限</span></a></li>
			<li class=""><a title="群组管理"  rel="" target="dialog" href="/index.php/Service/Operatmember/groupManage" class="edit" width="600" height="400"><span>群组管理</span></a></li>
		</ul>
	</div>

	<table class="table" width="100%" layoutH="178">
		<thead>
		<tr>
			<th class="center" style="width: 43px; cursor: default;"><div title="" class="gridCol"><input type="checkbox" class="checkboxCtrl" group="ids"></div></th>
			<th width="60">序号</th>
			<th>联系人</th>
			<th>运维账号</th>
			<th>手机号码</th>
			<th>邮箱</th>
			<th>微博帐号</th>
			<th>微信帐号</th>
			<th>操作</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="sid_user" rel="<?php echo ($vo['staffId']); ?>">
				<td class="center" style="width: 43px;"><div><input type="checkbox" value="<?php echo ($vo['staffId']); ?>" name="ids"></div></td>
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td <?php echo ($vo['color']); ?>><?php echo ($vo['staffName']); ?></td>
				<td <?php echo ($vo['color']); ?>><?php echo ($vo['staffAccount']); ?></td>
				<td <?php echo ($vo['color']); ?>><?php echo ($vo['staffPhoneNo']); ?></td>
				<td <?php echo ($vo['color']); ?>><?php echo ($vo['staffEmail']); ?></td>
				<td <?php echo ($vo['color']); ?>><?php echo ($vo['microBlogId']); ?></td>
				<td <?php echo ($vo['color']); ?>><?php echo ($vo['wechatId']); ?></td>
				<td>
				<a class="btnDel" target="ajaxTodo" title="确实要删除这条记录吗" href="/index.php/Service/Operatmember/delete/id/<?php echo ($vo['staffId']); ?>/wechatid/<?php echo ($vo['wechatId']); ?>">删除</a>
				<a height="298" width="440" target="dialog" rel="fitting_index1" class="btnEdit" title="编辑" href="/index.php/Service/Operatmember/edit/id/<?php echo ($vo['staffId']); ?>">编辑</a>
				<a height="298" width="440" target="dialog" rel="fitting_index1" class="btnWechat" title="同步至微信平台" href="/index.php/Service/Operatmember/syncWechat/idwe/<?php echo ((isset($vo['wechatId']) && ($vo['wechatId'] !== ""))?($vo['wechatId']):"0"); ?>/staffid/<?php echo ($vo['staffId']); ?>">同步至微信平台</a>
				<a height="298" width="440" target="ajaxTodo"  rel="fitting_index1" class="btnFollow" title="邀请关注?" href="/index.php/Service/Operatmember/inviteFollow/weid/<?php echo ($vo['wechatId']); ?>">邀请关注</a>
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
	
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
				<?php
 $numPerPageArr = array(20,50,100,200); foreach($numPerPageArr as $val) { if($val == $numPerPage) $selected = 'selected'; echo '<option value="'.$val.'" '.$selected.'>'.$val.'</option>'; $selected = ''; } ?>
			</select>
			<span>条，共<?php echo ($totalCount); ?>条</span>
		</div>
		<div class="pagination" targetType="navTab" totalCount="<?php echo ($totalCount); ?>" numPerPage="<?php echo ($numPerPage); ?>" pageNumShown="5" currentPage="<?php echo ($currentPage); ?>"></div>
	</div>


</div>