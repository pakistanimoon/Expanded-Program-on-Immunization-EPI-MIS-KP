<?php
class Widgetfunctions_model extends CI_Model {

	
	public function getHeaderContent($title='LHW - Information System'){
		
		echo '<title>'.$title.'</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >
		<link href="'.base_url().'includes/css/fooTable/footable.core.css" rel="stylesheet" type="text/css" />
		<link href="'.base_url().'includes/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="'.base_url().'includes/css/plugins.css" />
		<link rel="stylesheet" href="'.base_url().'includes/css/main.css" />
		<style type="text/css">
			.ajax_overlay {}
			.ajax_loader {background: url("'.base_url().'includes/images/ajax-loader_blue.gif") no-repeat center center transparent;
			width:100%;height:100%;}
		</style>';
	}
	
	public function getIncludedJs(){
		
		echo '<script src="'.base_url().'includes/js/jquery-1.11.0.min.js"></script>
			  <script src="'.base_url().'includes/js/bootstrap.min.js"></script>
			  <script src="'.base_url().'includes/js/fooTable/footable.js" type="text/javascript"></script>
			  <script src="'.base_url().'includes/js/ajaxLoader.js" type="text/javascript"></script>
			  <script src="'.base_url().'includes/js/fooTable/footable.filter.js" type="text/javascript"></script>
			  <script type="text/javascript">
				$(function () {
					$(\'.footable\').footable();
				});
			  </script>
			';
	}
	
	public function getContentHeader($subTitle){
		
		echo '<div class="content-header">
				<div class="header-section">
					<h1>
						LHW-MIS<br /><small>'.$subTitle.'</small>
					</h1>
				</div>
			</div>
			';
	}
}
?>