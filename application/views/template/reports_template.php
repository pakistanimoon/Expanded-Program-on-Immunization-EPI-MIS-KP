<?php 
if(!$this -> input -> post('export_excel')){?>
	<!DOCTYPE html>
	<html>
	<head>
		<title><?php echo $pageTitle; ?></title>
		<meta name="description" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="noindex, nofollow" />
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" type="image/png" href="<?php echo base_url()."includes/assets/img/epi.png" ?>">
		<link href="<?php echo base_url();?>includes/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url();?>includes/dist/css/custom.css" rel="stylesheet" type="text/css">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css" rel="stylesheet" type="text/css">
		<script src="<?php echo base_url(); ?>includes/js/bootstrap-tooltip.js"></script>
		<style>
			html {
				  position: relative;
				  min-height: 100%;
			}
			body {
				margin-bottom: 60px;
				<?php 
				if($this -> uri -> segment(2) == "flcf_wise_vaccination_malefemale_coverage" || $this -> uri -> segment(2) == "flcf_wise_vaccination"){ ?>
					overflow-y: hidden;<?php 
				}?>
			}
			.tooltip > .tooltip-inner
			 {
				background-color: #008D4C;
			 }
			.footer {
				position: absolute;
				bottom: 0;
				width: 100%;
				margin-top:70px;
			}<?php 
			if($this -> uri -> segment(2) == "flcf_wise_vaccination_malefemale_coverage" || $this -> uri -> segment(2) == "flcf_wise_vaccination"){ ?>
				#women{
					position: fixed !important;
					top: inherit !important;
					left: 707px;
					z-index: 1;
					height: 75px;
				}
				.women{
					position: fixed !important;
					top: inherit !important;
				
					z-index: 1;
					height: 75px;
				}
				#fixTable>tbody>tr>td{
					color: black;
					 min-width: 74px;
				}<?php 
			} ?>
			#parent {
				height: 400px;
			}
			#fixTable>thead>tr>th{
				background: #008D4C !important;
				border-color: white;
				border-width: 1px;
				text-align: center;

			}
			#fixTable{
				color: white;	 
			}
			<?php 
			if($this -> uri -> segment(2) != "flcf_wise_vaccination_malefemale_coverage" && $this -> uri -> segment(2) != "flcf_wise_vaccination"){ ?>
				#fixTable>tbody>tr>td{
					color: black;					
				}<?php 
			} ?>
			#fixTable{
				border-collapse: separate;
			}
			.table-bordered{
				border: none !important;
			}
		</style>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-87913592-1', 'auto');
			ga('send', 'pageview');
		</script>
	</head>
	<body>
		<div class="container bodycontainer">
			<div class="row">
				<div class="col-xs-1">
					<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>includes/images/epi.png" style="height: 60px;margin-top: 14px;" alt="img-excel" data-toggle="tooltip" title="Home" data-placement="bottom"></a>
				</div>
				<div class="col-xs-9">
					<h3 style="font-weight: bold;margin-top: 30px;margin-left:112px;" class="text-center">EPI - MIS | <?php echo $this -> session -> provincename; ?></h3>
				</div>
				<?php echo $data['exportIcons']; ?>
			</div>
			<hr><?php  
} ?> 
			<?php $this->load->view($fileToLoad,$data); ?>
		</div>
		<?php $this->load->view('template/login_footer'); ?>		
	</body>
</html>
<?php echo "";exit; ?>