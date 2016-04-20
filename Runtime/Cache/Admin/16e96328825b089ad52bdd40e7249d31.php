<?php if (!defined('THINK_PATH')) exit();?><div layouth="0">
	<div class="side_tree repertory_tree js_drag_width" style="border-top:none;width:310px;overflow:auto;">
		<ul id="Group_tree" class="tree treeFolder expand" layouth="15" style="overflow:auto;">
			<li><a tname="name" tvalue="">服务</a>
				<ul>
					<?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a tname="name" tvalue="test1.1.1" onclick=showService('<?php echo ($vo); ?>')><?php echo ($vo); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>	
			</li>
		</ul>
	</div>
	<div id="Service_list" layouth="0">
		
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
					$("#Group_tree").css("width",310);
				}else{
					$("#Group_tree").css("width",e_w);
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

function showService(name){
	var url =  '/index.php?s=/Admin/WeightService/showService/servicename/'+name;
	$("#Service_list").loadUrl(url);
}

</script>