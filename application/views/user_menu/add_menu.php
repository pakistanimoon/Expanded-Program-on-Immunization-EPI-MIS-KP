<?php //$utype=$_SESSION['utype']; 
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

<div class="container bodycontainer">
	<div class="row">
        <?php if($this->session->flashdata('message')) { ?>
        <div class="alert alert-success text-center" role="alert">
            <strong> <?php echo $this->session->flashdata('message'); ?> </strong>
        </div> <?php   } ?>
  		<div class="panel panel-primary"> 
    		<ol class="breadcrumb">
          		<?php  echo $this->breadcrumbs->show();?>
       		</ol>
    		<div class="panel-heading">EPI-MIS | Create Menu Form</div>
  	   		    <div class="panel-body">
    	   		    <form name="dataform" id="dataform" action="<?php echo base_url();?>User_menu/save_menu" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
			    		<div class="row">
			    		   <div class="form-group">
						   	<label class="col-xs-2 control-label col-md-offset-1" for = "menu_item" >Menu Title</label>
							   	<div class="col-xs-3">
								   <input class="jsfields_id" type="hidden" name="jsfields_id" id="jsfields_id">
								   <input class="jsfields_parent" type="hidden" name="jsfields_parent" id="jsfields_parent">
								   <input class="jsfields" type="hidden" name="jsfields" id="jsfields">
								   <!-- <input  id="utype" name="utype[]" multiple class="utype" type="hidden">
								   <input  id="level" name="level[]" multiple class="level" type="hidden"> -->
									<input class="node_id" type="hidden" name="node_id" id="node_id">
									<input class="node_Parent_id" type="hidden" name="node_Parent_id" id="node_Parent_id">
									<input type="hidden" name="id" id="id" placeholder="id"  class="form-control " value="<?php echo isset($menu)?$menu[0]["id"]:""; ?>"/>
								   <input required name="menu_item" id="menu_item" placeholder="Menu Title"  class="form-control " value="<?php echo isset($menu)?$menu[0]["menu_item"]:""; ?>"/>
								   <?php echo form_error('menu_item'); ?>
							  	</div>
								  <label class="col-xs-2 control-label" for = "menu_url" >Menu Url</label>
							  	<div class="col-xs-3">
									<input required name="menu_url" id="menu_url" placeholder="Menu Url"  class="form-control " value="<?php echo isset($menu)?$menu[0]["menu_url"]:""; ?>"/>
									<?php echo form_error('menu_url'); ?>
							  	</div> 
                            </div>
                        </div>
						<div class="row">
						  	<div class="form-group">
								  <label class="col-xs-2 control-label unameUC col-md-offset-1" for = "menu_icon" >Menu Icon</label>
							  	<div class="col-xs-3 unameUC">
									<input name="menu_icon" id="menu_icon" placeholder="Menu Icon"  class="form-control " value='<?php echo isset($menu)?$menu[0]["icon"]:""; ?>'/>
							  	</div> 
							  	
								  <label class="col-xs-2 control-label unameFLCF"for = "menu_temp" >Menu Template</label>
							  	<div class="col-xs-3 unameFLCF">
								  <select id="menu_temp" required name="menu_temp" class="form-control" size="1" >
										<option value="0">--- Select Template ---</option>
										<option <?php if($menu[0]['template'] == 'main') { echo 'selected="selected"'; } else { echo ''; } ?> value="main">main</option>
                        				<option  <?php if($menu[0]['template'] == 'dashboard') { echo 'selected="selected"'; } else { echo ''; } ?> value="dashboard">dashboard</option>										
									</select>
									<?php echo form_error('menu_temp'); ?>
							  	</div>
								  </div>
						</div> 
						<div class="row">
						  	<div class="form-group">
						  		<label class="col-xs-2 control-label col-md-offset-1" for = "active" >Active</label>
							   <div class="col-xs-3">
									<input type="radio" name="active" value= '1' checked> YES &nbsp;&nbsp;
									<input type="radio" name="active" value= '0'> NO
							  	</div>
						   </div>
				<hr>
				<div id="showw" class="row cluster">							
								<div class="col-lg-5 col-lg-offset-1" style="padding: 0;">
								<p>Parent Menu:</p>
									<div class="treeview_div">
									
										<div class="row">
											<div class="col-lg-2"><label class="mb-0">Search&nbsp;:</label></div>
											<div class="col-lg-7">
												<input type="text" id="search" class="form-control" />
											</div>
											<div class="col-lg-3 text-left">
												<button class="btn btn-success" id="clear">Search</button>
											</div>
										</div>
										<div id="jstree"></div>
									</div>
								</div>
								<div class="col-lg-5" style="padding-right: 0;">
								<p><br></p>
									<div class="treeview_div">										
										<p>Selected Menu Item:</p>										
										<ul id="output"></ul>										
									</div>									
								</div>
						</div>
						<hr> 
						<div class="row cluster">							
								<div class="col-lg-5 col-lg-offset-1" style="padding: 0;">
								<p>User Type/Role:</p>
									<div class="treeview_div">
										<div class="row">
											<div class="col-lg-2"><label class="mb-0">Search&nbsp;:</label></div>
											<div class="col-lg-7">
												<input type="text" id="search" class="form-control" />
											</div>
											<div class="col-lg-3 text-left">
												<button class="btn btn-success" id="clear">Search</button>
											</div>
										</div>
										<div id="jstree_users"></div>
									</div>
								</div>
								<div class="col-lg-5" style="padding-right: 0;">
								<p><br></p>
									<div class="treeview_div">										
										<p>Selected Users:</p>										
										<ul id="output_users"></ul>										
									</div>									
								</div>
						</div>
						</div>
						</div>	
						</div>
						<hr>
						<div class="row">
		               		<div class="col-xs-7 cmargin22" >
							   <?php if(isset($menu)){?>
									<button type="submit" id="UpdateMenu" name="UpdateMenu" class="btn btn-md btn-success defaultSaveButton"><i class="fa fa-floppy-o"></i> Update Menu </button>
								<?php }else{?> 
									<button type="submit" id="AddMenu" name="AddMenu" onClick="" class="btn btn-md btn-success clusterSaveButton"><i class="fa fa-floppy-o"></i> Create Menu </button>
								<?php }?>
								<button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset Form </button>
								<a href="<?php echo base_url();?>User_menu/menu_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
							</div>
						</div>
					</form>
        	</div>
    	</div>
	</div>
</div>

<script type="text/javascript">
function cluster()
{
    var checked_ids = new Array(); 
   	var selected_flcf = $('#jstree').jstree("get_selected", true);
	$.each(selected_flcf,function () { 
        checked_ids.push(this.id); 
    });
	console.log(checked_ids);
	document.getElementById('jsfields').value = checked_ids.join(",");
}

function cluster_user()
{
	var checked_ids = new Array();
	var checked_parent = new Array();  
   	var selected_flcf = $('#jstree_users').jstree("get_selected", true);
	$.each(selected_flcf,function () { 
		checked_ids.push(this.id);
		checked_parent.push(this.parent);
    });
	console.log(checked_ids);
	console.log(checked_parent);
	document.getElementById('jsfields_id').value = checked_ids.join(",");
	document.getElementById('jsfields_parent').value = checked_parent.join(",");
}

$(document).ready(function()
{
	<?php if(isset($menu)) 
		{
		?>
			var menu_temp = $('#menu_temp').val();
			var menu = "<?php echo $_REQUEST['menu']; ?>";
			$.ajax({
				type: "POST",
				data: "menu_temp="+menu_temp+"&menu="+menu,
				url: "<?php echo base_url(); ?>User_menu/edit_menu",
				success: function(result){			 		
					$('#jstree').jstree("destroy");					
					$('#jstree').jstree({
						'checkbox': { 
							three_state: true
						},
						'plugins': ['search', 'radio', 'wholerow'],
						'core': { 
							'data':JSON.parse(result),
							'animation': false,
							'themes': {
								'icons': false,
							}
						},
						'search': {
							'show_only_matches': true,
							'show_only_matches_children': true
						}
					});
				}
			});

			$('#search').on("keyup change", function () {
			$('#jstree').jstree(true).search($(this).val())
		})

		$('#clear').click(function (e) {
			$('#search').val('').change().focus()
		})

		$('#jstree').on('changed.jstree', function (e, data) {
			var objects = data.instance.get_selected(true)
			var leaves = $.grep(objects, function (o) 
			{ 
				return data.instance.is_leaf(e)
			})
			var list = $('#output')
			list.empty()
			$.each(leaves, function (i, o) {
				$('<li/>').text(o.text).appendTo(list)
				var menu_id = o.id;
				var menu_parent_id = o.parent;
				document.getElementById('node_id').value = menu_id;
				document.getElementById('node_Parent_id').value = menu_parent_id;
			})
		});	

		$.ajax({
			type: "POST",
			data: "&menu="+menu,
			url: "<?php echo base_url(); ?>User_menu/editUsers",
			success: function(result){			 		
				$('#jstree_users').jstree("destroy");					
				$('#jstree_users').jstree({
					'checkbox': { 
						three_state: true
					},
					'plugins': ['search', 'checkbox', 'wholerow'],
					'core': { 
						'data':JSON.parse(result),
						'animation': false,
						'themes': {
							'icons': false,
						}
					},
					'search': {
						'show_only_matches': true,
						'show_only_matches_children': true
					}
				});
			}
		});

		$('#search').on("keyup change", function () {
			$('#jstree_users').jstree(true).search($(this).val())
		})

		$('#clear').click(function (e) {
			$('#search').val('').change().focus()
		})

		$('#jstree_users').on('changed.jstree', function (e, data) {
			var objects = data.instance.get_selected(true)
			var leaves = $.grep(objects, function (o) 
			{ 
				return data.instance.is_leaf(e)
			})
			var list = $('#output_users')
			list.empty()
			$.each(leaves, function (i, o) {
				$('<li/>').text(o.text).appendTo(list)
				cluster_user()			
			})
		});	
			
		$('.cluster').removeClass('hide');
	<?php }
		else 
		{
	?>
		$(document).on('change','#menu_temp', function(){
			var menu_temp = $('#menu_temp').val();
			$.ajax({
				url: "<?php echo base_url(); ?>User_menu/getMenu",
				type: "POST",
				data: "menu_temp="+menu_temp,
				success: function(result)
				{						
					$('#jstree').jstree("destroy");					
					$('#jstree').jstree({
						'plugins': ['search', 'radio', 'wholerow'],
						'core': {
							'data': JSON.parse(result),
							'animation': false,
							'themes': {
								'icons': false,
							}
						},
						'search': {
							'show_only_matches': true,
							'show_only_matches_children': true
						}
					});
				}
			});
			$('.cluster').removeClass('hide');
		});
		
		$('#search').on("keyup change", function () {
			$('#jstree').jstree(true).search($(this).val())
		})

		$('#clear').click(function (e) {
			$('#search').val('').change().focus()
		})

		$('#jstree').on('changed.jstree', function (e, data) {
			var objects = data.instance.get_selected(true)
			var leaves = $.grep(objects, function (o) 
			{ 
				return data.instance.is_leaf(e)
			})
			var list = $('#output')
			list.empty()
			$.each(leaves, function (i, o) {
				$('<li/>').text(o.text).appendTo(list)
				var menu_id = o.id;
				document.getElementById('node_id').value = menu_id;
			})
		});	

		$.ajax({
			url: "<?php echo base_url(); ?>User_menu/getUsers",
			type: "POST",
			success: function(result)
			{						
				$('#jstree_users').jstree("destroy");					
				$('#jstree_users').jstree({
					'plugins': ['search', 'checkbox', 'wholerow'],
					'core': {
						'data': JSON.parse(result),
						'animation': false,
						'themes': {
							'icons': false,
						}
					},
					'search': {
						'show_only_matches': true,
						'show_only_matches_children': true
					}
				});
			}
		});
		$('.cluster').removeClass('hide');
		
			$('#search').on("keyup change", function () {
				$('#jstree_users').jstree(true).search($(this).val())
			})

			$('#clear').click(function (e) {
				$('#search').val('').change().focus()
			})

			$('#jstree_users').on('changed.jstree', function (e, data) {
				var objects = data.instance.get_selected(true)
				var leaves = $.grep(objects, function (o) 
				{ 
					return data.instance.is_leaf(e)
				})
				var list = $('#output_users')
				list.empty()
				$.each(leaves, function (i, o) {
					$('<li/>').text(o.text).appendTo(list)
					cluster_user()			
				})
			});			
	<?php
		}
	?>
});
</script>