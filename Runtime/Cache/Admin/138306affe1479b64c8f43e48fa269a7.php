<?php if (!defined('THINK_PATH')) exit();?><div layouth="0">
	<div class="side_tree repertory_tree js_drag_width" style="border-top:none;width:310px;overflow:auto;">
		<ul id="Hostquality_tree" class="tree treeFolder expand" style="postion:relative;overflow:auto;" layouth="15">
		
				<?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a onclick="showGroup(<?php echo ($vo['pdId']); ?>)"><?php echo ($vo['machineRoom']); ?></a><!-----机房----->
				
				<?php if(!empty($vo['cabinets'])): ?><ul>
						<?php if(is_array($vo['cabinets'])): $i = 0; $__LIST__ = $vo['cabinets'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cabinets): $mod = ($i % 2 );++$i;?><!-----机柜----->
						<li><a class="treenode" ><?php echo ($cabinets['cabinetName']); ?></a>
						
								<?php if(!empty($cabinets['machines'])): ?><ul> 
									<?php if(is_array($cabinets['machines'])): $i = 0; $__LIST__ = $cabinets['machines'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$svo): $mod = ($i % 2 );++$i;?><!-----物理机----->
									<li><a class="treenode" onclick="showHostResourceList('<?php echo ($svo[id]); ?>')" ><?php echo ($svo['name']); ?></a>

										<?php if(!empty($svo['virtualMechines'])): ?><ul> 
										<?php foreach($svo['virtualMechines'] as $k=>$v){ echo "<li><a class='treenode' onclick=showService('".$v['ip']."')>". $v['name'] ."</a></li>" ; } ?>
										</ul><?php endif; ?>

									</li><?php endforeach; endif; else: echo "" ;endif; ?>
									</ul><?php endif; ?>
						
						
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul><?php endif; ?>
				
				</li><?php endforeach; endif; else: echo "" ;endif; ?>

		</ul>
	</div>
	<div id="Hostquality_list" layouth="0">
		

	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
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
					$("#Hostquality_tree").css("width",310);
				}else{
					$("#Hostquality_tree").css("width",e_w);
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

//显示主机列表
function showHostResourceList(id){
	var url =  '/index.php?s=/Admin/Hostqualitymon/showHostResourceList/serverId/'+id;
	$("#Hostquality_list").loadUrl(url);
}

//显示主机详细信息
function showService(ip){
	var url =  '/index.php?s=/Admin/Hostqualitymon/showHostResourceDetail/ip/'+ip;
	$("#Hostquality_list").loadUrl(url);
}


</script>