<?php if (!defined('THINK_PATH')) exit();?><div layouth="0">
	<div class="side_tree repertory_tree js_drag_width" style="border-top:none;width:310px;overflow:auto; position:relative;">
		<ul id="Serquality_tree" class="tree treeFolder expand" layouth="15" style="postion:relative;overflow:auto;" >
			<li><a tname="name" tvalue="">服务</a>
				<ul>
					<?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a onclick="showGroup(<?php echo ($vo['pdId']); ?>)"><?php echo ($vo['product']); ?></a>
					
					<?php if(!empty($vo['services'])): ?><ul>
							<?php if(is_array($vo['services'])): $i = 0; $__LIST__ = $vo['services'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$services): $mod = ($i % 2 );++$i;?><li><a class="treenode" onclick="showService('<?php echo ($services[ssName]); ?>')" ><?php echo ($services['ssName']); ?></a>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul><?php endif; ?>
					
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>	
			</li>
		</ul>
	</div>
	<div id="detail_list" layouth="0">
		

	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	////////////////////
		$('.js_drag_width').each(function(){
		if($('.mouse_area',this).length!=0){
			return;
		}
		var area=$(this),
			handle=$('<div class="mouse_area" style="position:absolute;top:0;right:0;width:5px;height:100%;cursor:e-resize;"></div>')
		$(this).css('position','relative').append(handle);
		var drag_move=false,
			s_x,
			s_w;
		handle.mousedown(function(event){
			drag_move=true;
			s_x=event.pageX;
			s_w=area.width();
			$('body').bind('selectstart',function(){return false;}).addClass('unselect');
		});
		$(document).mousemove(function(event){
			if(drag_move){
				var e_x=event.pageX,
					dist=e_x-s_x,
					e_w=s_w+dist;
				if(e_w<100){
					e_w=100
				}else if(e_w>800){
					e_w=800;
				}
				if(e_w<=310){
					$("#Serquality_tree").css("width",310);
				}else{
					$("#Serquality_tree").css("width",e_w);
				}
				console.log(e_w);
				area.width(e_w+'px');
			}
		}).mouseup(function(){
			drag_move=false;
			$('body').unbind('selectstart').removeClass('unselect');
		});
	});
});

//显示服务组列表
function showGroup(id){
	var url =  '/index.php?s=/Admin/Serqualitymon/showQualityTotal/productId/'+id;
	$("#detail_list").loadUrl(url);
}

//显示服务详细信息
function showService(name){
	var url =  '/index.php?s=/Admin/Serqualitymon/showQualityDetail/service/'+name;
	$("#detail_list").loadUrl(url);
}


</script>