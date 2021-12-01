<?php
$widget = getWidgetType(true,$widget_type_id);
?>
<div class="col-md-6 create-div1 component-container ui-sortable" data-widgetidupd="<?php echo $pk_id; ?>" data-width="col-md-6 col-sm-6 col-xs-12" style="overflow:scroll !important; height:600px;">
	<?php echo getWidgetSelectedFiltersDetail(true,$pk_id); ?>
	<h4><?php echo ($widget_title!='')?$widget_title:'Widget'; ?></h4>
	<?php if($user){ ?>
	<a class="btn ibtnDel-col" type="button" data-widgetid="<?php echo $pk_id; ?>" id="del-widget">
		<i class="fa fa-times"></i>
	</a>
	<?php } ?>
	<?php
	if($widget != 'Table'){ ?>
	<div id="widgetname<?php echo $pk_id; ?>" style="display:inline-block;overflow:scroll!important; width:100%;"></div>
<?php
	}
switch($widget){
	case 'Metric':
		$this -> load -> view('customdashboard/metric');
		break;
	case 'Timeline':
		if($multiseries == 1)
			$this -> load -> view('customdashboard/mstimeline');
		else
			$this -> load -> view('customdashboard/timeline');
		break;
	case 'Thematic Map':
		$this -> load -> view('customdashboard/thematicmap');
		break;
	case 'Table':
		$this -> load -> view('customdashboard/table');
		break;
	case 'Pie':
		$this -> load -> view('customdashboard/pie');
		break;
	case 'Bar':
		if($multiseries == 1)
			$this -> load -> view('customdashboard/bar');
		else
			$this -> load -> view('customdashboard/column');
		break;
}
?>
</div>