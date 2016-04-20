<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" action="/index.php/Log/LatestWarningLog" method="post">
	<input type="hidden" name="pageNum" value="1"/>
	<input type="hidden" name="numPerPage" value="<?php echo ($_REQUEST["numPerPage"]); ?>"/>
	<input type="hidden" name="_order" value="<?php echo ($_REQUEST["_order"]); ?>"/>
	<input type="hidden" name="_sort" value="<?php echo ($_REQUEST["_sort"]); ?>"/>
	<?php if(is_array($map)): $i = 0; $__LIST__ = $map;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><input type="hidden" name="<?php echo ($key); ?>" value="<?php echo ($_REQUEST[$key]); ?>"/><?php endforeach; endif; else: echo "" ;endif; ?>
</form>

<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/index.php/Log/LatestWarningLog" method="post">
	<div class="searchBar">
		<ul class="searchContent">
			<li>
				<label>范围：时间（小时）</label>
				<select class="combox" name="range">
				<?php if(is_array($range)): foreach($range as $key=>$vo): if( $vo == $_REQUEST['range'] ): ?><option value="<?php echo ($vo); ?>" selected><?php echo ($vo); ?></option>
					<?php else: ?>
						<option value="<?php echo ($vo); ?>"><?php echo ($vo); ?></option><?php endif; endforeach; endif; ?>
				</select>
			</li>
			<li>
				<label>且记录数量为：（条）</label>
				<select class="combox" name="size">
				<?php if(is_array($size)): foreach($size as $key=>$vo): if( $vo == $_REQUEST['size'] ): ?><option value="<?php echo ($vo); ?>" selected><?php echo ($vo); ?></option>
					<?php else: ?>
						<option value="<?php echo ($vo); ?>"><?php echo ($vo); ?></option><?php endif; endforeach; endif; ?>
				</select>
			</li>
		</ul>
		<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">刷新</button></div></div></li>
			</ul>
		</div>
	</div>
	</form>
</div>

<div class="pageContent">
	<table class="table" width="100%" layoutH="138">
		<thead>
		<tr>
			<th>序号</th>
			<th>服务</th>
			<th>发生时间</th>
			<th>查看调用链</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr target="sid_user" rel="<?php echo ($vo['cid']); ?>">
				<td>
					<?php
 $listnums = $numPerPage * ($currentPage-1) + $key+1; echo $listnums; ?>
				</td>
				<td><?php echo ($vo['srv']); ?></td>
				<td><?php echo ($vo['logtime']); ?></td>
				<td><a rel="L30602" target="navTab" href="/index.php?s=/Log/CallChain/index/chainId/<?php echo ($vo['cid']); ?>/fid/<?php echo ($vo['fid']); ?>/type/<?php echo ($vo['type']); ?>"><?php if($vo['type'] == 1) echo '基础服务链' ;else echo '查看调用链';?></a></td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>


</div>