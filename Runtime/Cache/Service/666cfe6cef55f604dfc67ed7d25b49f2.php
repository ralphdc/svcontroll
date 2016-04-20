<?php if (!defined('THINK_PATH')) exit();?><div class="config_detail">
	
	<div class="config_detail_table">
		<div class="tableList" layouth="58">
			<table class="list" width="100%">
				<thead>
					<tr>
						<th width="40px"></th>
						<th>序号</th>
						<th>配置名称</th>
						<th>属性类</th>
					</tr>
				</thead>
				<tbody id="instanceparent">
				<?php  foreach($result as $key => $val) { echo '<tr>
						<td><input type="radio" value="'.$val['id'].'" name="instance" /></td>
						<td>'.++$key.'</td>
						<td>'.$val['instancename'].'</td>
						<td>'.implode(',',$val['item']).'</td>
					</tr>'; } ?>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="config_detail_info">
		<!-- <div class="hd">信息预览</div>
		<div class="con" layouth="121">
			<pre >
			
			</pre>
		</div> -->
		
		<textarea readonly class="readonly" id="showInstancecontent" style="width:580px;height:580px;background: none repeat scroll 0 0 black;color: white;font-size: 13px;"></textarea>
		
	</div>
</div>
<script>
$(function(){
	$('#instanceparent tr').each(function(index,dom){
		var instanceValue = $(this).find('input[name="instance"]').val();
		$(this).bind('click',function(){
			
			$.post("/index.php/Service/Configure/getInstanceInfo",{'id':instanceValue},function(data){
				$('#showInstancecontent').html(data);
			})
			
			$(this).find('input').attr('checked','true');
		})
	})
})
</script>