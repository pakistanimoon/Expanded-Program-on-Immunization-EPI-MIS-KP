<div id="widget-filter-div<?php echo $widget_id; ?>" class="hide div-show widget-filter-div" style="opacity: 0.9;">
	<h5><strong>Widget Selected Filters Detail</strong></h5>
	<?php $old_widget_id="";
		foreach($widgetDetail as $key => $val){
			if(isset($val['dashboard_widget_id']) && $old_widget_id != $val['dashboard_widget_id']){
				echo "<strong> Created Date </strong> : "; echo date("d-m-Y",strtotime(getDashboardWidgetDetail($val['dashboard_widget_id']))); echo"<br>";
			}
			$old_widget_id = $val['dashboard_widget_id'];
		?>
			<strong><?php echo getFilterTitle($val['main_filter_id']); ?></strong> : 
			<span><?php echo getFilterDetailValueText($val['filter_select_value']); ?></span><br>
<?php 	} ?>
</div>
<span  class="filter-info-div" <?php if(!$user){ ?>style="cursor: pointer; margin-top: -4px;" <?php } ?>><i class="fa fa-info-circle" title="Info"></i> Widget Selected Filters Information</span>