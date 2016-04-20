<?php if (!defined('THINK_PATH')) exit();?><link href="/Public/dwz/themes/css/zTreeStyle/zTreeStyle.css" rel="stylesheet" type="text/css" />
<script src="/Public/dwz/js/jquery.ztree.all-3.5.js" type="text/javascript"></script>
<script src="/Public/dwz/js/jquery.ztree.exhide-3.5.min.js" type="text/javascript"></script>

<div layouth="35">
	<div class="side_tree js_drag_width config_side_tree" layouth="36">
		<div class="config_tree_con" data-size="a">
			<a href="javascript:;" class="config_tree_btn">收起</a>
			<ul id="config_tree" class="ztree"></ul>
		</div>
	</div>
	
</div>

<script type="text/javascript">

var setting = {
		view: {
			dblClickExpand: false,
			selectedMulti: false,
			nameIsHTML:true
		},
		data: {
			key: {
				title:"title"
			},
			simpleData: {
				enable: true
			}
		},
		edit: {
			enable: false,
			showAddBtn: false,
			showRemoveBtn: false,
			showRenameBtn: false
		},
		callback: {
			onRightClick: OnRightClick
		}
	};

	var config_nodes=<?php echo ($config_nodes); ?>;
		
	var config_tree,examples_tree,tree_which_search;

$(document).ready(function(){
	$("#background,#progressBar").hide();
	$.fn.zTree.init($("#config_tree"), setting, config_nodes);
	//$.fn.zTree.init($("#examples_tree"), setting, examples_nodes);
	config_tree = $.fn.zTree.getZTreeObj("config_tree");
	//examples_tree = $.fn.zTree.getZTreeObj("examples_tree");
	updateType();
	$('.config_side_tree a').attr('rel','config_content');
	config_tree.expandAll(false);
	examples_tree.expandAll(false);
	
	$('.head_search .btn_search').click(function(){
		var area=$(this).parents('.head_search'),
			which=$('input[name="config_search_which"]:checked',area).val(),
			key=$('input[name="config_search_key"]',area).val();
		if(which==1){
			var tree_earch='config_tree';
			tree_which_search = 'config_tree';
		}else{
			var tree_earch='examples_tree';
			tree_which_search = 'examples_tree';
		}
		$.post('/index.php/Service/Configure/getSearchInfo',{type:which,key:key},function(data){
			if(data)
			{
				var search_nodes=eval(data);
				resetSearchTree(tree_earch,search_nodes);
				if(key == '' || key == null)
				{
					if(which == 1)
					{
						config_tree.expandAll(false);	
					}else
					{
						examples_tree.expandAll(false);
					}
				}
			}
		})
//		$('.head_search .btn_search_cancel').show();
	});
	
	$('.config_tree_btn').click(function(){
		var con=$(this).parent('.config_tree_con'),
			con_other=con.siblings('.config_tree_con'),
			tree=$(this).siblings('.ztree');
		
		if($(this).hasClass('status_close')){
			$(this).removeClass('status_close').text('收起');
			$('.config_tree_name',con).remove();
			if(con_other.data('size')=='a'){
				con.data('size','a');
			}else if(con_other.data('size')=='b'){
				con.data('size','a');
				con_other.data('size','a');
			}else{
				con.data('size','b');
			}
		}else{
			$(this).addClass('status_close').text('展开');
			con.data('size','c');
			if(con_other.data('size')=='a'){
				con_other.data('size','b')
			}
			if(tree.attr('id')=='config_tree'){
				con.prepend('<div class="config_tree_name">配置项</div>');
			}else{
				con.prepend('<div class="config_tree_name">配置实例</div>');
			}
		}
		$(window).resize();
	});
	
	$(window).resize(function(){
		var h=$('.config_side_tree').height();
		$('.config_tree_con').each(function(){
			var type=$(this).data('size');
			if(type=='a'){
				$(this).height((h/2-1)+'px');
			}else if(type=='b'){
				$(this).height((h-39)+'px');
			}else if(type=='c'){
				$(this).height('38px');
			}
		});
	}).resize();
	
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
				console.log(e_w);
				area.width(e_w+'px');
			}
		}).mouseup(function(){
			drag_move=false;
			$('body').unbind('selectstart').removeClass('unselect');
		});
	});
});

</script>