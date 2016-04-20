<?php if (!defined('THINK_PATH')) exit();?><script src="/Public/jqueryplugins/jquery-Contextmenu.js" type="text/javascript"></script>


<div layouth="0">
	<div class="side_tree repertory_tree js_drag_width" style="border-top:none;width:310px;overflow:auto;">
		<ul id="ice_tree" class="tree treeFolder expand" layouth="15" style="overflow:auto;width:310px;">
			<?php if(count($menu_db) > 0): ?><li><a tname="name" tvalue="">数据库组</a>
				<ul id="db-menu">
					<?php if(is_array($menu_db)): $i = 0; $__LIST__ = $menu_db;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo_db): $mod = ($i % 2 );++$i;?><li><a tname="name" tvalue="test1.1.1" onclick="showGroup('<?php echo ($vo_db); ?>')" style="color:#0347ad"><?php echo ($vo_db); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				</li><?php endif; ?>
			
			<?php if(count($menu_zk) > 0): ?><li><a tname="name" tvalue="">ZK组</a>
				<ul id="zk-menu">
					<?php if(is_array($menu_zk)): $i = 0; $__LIST__ = $menu_zk;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo_zk): $mod = ($i % 2 );++$i;?><li><a tname="name" tvalue="test1.1.1" onclick="showGroup('<?php echo ($vo_zk); ?>')" style="color:#ff0000"><?php echo ($vo_zk); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				</li><?php endif; ?>
			
			<?php if(count($menu_db) < 1 && count($menu_zk) < 1): ?><li>暂无可用信息</li><?php endif; ?>
			
			
			<!-- <li><a tname="name" tvalue="">组</a>
				<ul>
					<?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a tname="name" tvalue="test1.1.1" onclick="showGroup('<?php echo ($vo); ?>')"><?php echo ($vo); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>	
			</li> -->
		</ul>
	</div>
	<div id="Group_list" layouth="0">

	</div>
	
	<div class="contextMenu" id="myMenu2">
        <ul>
          <li id="item_1">选项一</li>
          <li id="item_2">选项二</li>
          <li id="item_3">选项三</li>
          <li id="item_4">选项四</li>
        </ul>
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
					$("#ice_tree").css("width",310);
				}else{
					$("#ice_tree").css("width",e_w);
				}
				console.log(e_w);
				area.width(e_w+'px');
			}
		}).mouseup(function(){
			drag_move=false;
			$('body').unbind('selectstart').removeClass('unselect');
		});
	});
	
	
	
	
	if($("#db-menu").length > 0){
		$("#db-menu").find("a").each(function(e){
			$(this).contextMenu('myMenu2',{
			      //菜单样式
			      menuStyle: {
			        border: '2px solid #000'
			      },
			      //菜单项样式
			      itemStyle: {
			        fontFamily : 'verdana',
			        backgroundColor : 'green',
			        color: 'white',
			        border: 'none',
			        padding: '1px'
			      },
			      //菜单项鼠标放在上面样式
			      itemHoverStyle: {
			        color: 'blue',
			        backgroundColor: 'red',
			        border: 'none'
			      },
			      //事件    
			      bindings: 
			          {
			            'item_1': function(t) {
			              alert('Trigger was '+t.id+'\nAction was item_1');
			            },
			            'item_2': function(t) {
			              alert('Trigger was '+t.id+'\nAction was item_2');
			            },
			            'item_3': function(t) {
			              alert('Trigger was '+t.id+'\nAction was item_3');
			            },
			            'item_4': function(t) {
			              alert('Trigger was '+t.id+'\nAction was item_4');
			            }
			          }
			    })
		})
	}
});

function showGroup(id){
	var url =  '/index.php?s=/Admin/IceWeight/showGroup/servicename/'+id;
	$("#Group_list").loadUrl(url);
}

</script>