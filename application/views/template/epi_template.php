<?php if(!isset($_REQUEST['export_excel']) AND !isset($export_excel) )
{
?>
<!DOCTYPE html>
<html>
	<?php
		$this -> load -> view('template/style',$data);
	?>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 hidden-md hidden-sm hidden-xs" style="text-align: right;">
					<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>includes/images/epi.png" style="width: 72px; height: 81px; margin-top: 5px;"></a>
				</div>
				<div class="col-lg-6 col-md-10 col-sm-10" style="padding-left: 0px;">
					<h1 class="" style="font-weight: bold; color: green; text-align: center; margin-top: 14px;">Expanded Program On Immunization</h1>
					<h3 class="subtittle" style="color: green; font-weight: bold; font-size: 19px; margin-top: -8px; text-align: center;">Department of Health, <?php echo $this -> session -> provincename; ?></h3> 
				</div>
				<div class="col-lg-1  hidden-md hidden-sm hidden-xs" style="text-align: left;">
					<img src="<?php echo base_url(); ?>includes/images/province_logo.png" style="width: 81px; margin-top: 2px; margin-bottom: 1px;" >
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2">
					<div class="row" style="padding-top: 2px;">
						<div class="col-xs-12 zp">
							<ul class="userinfo">
								<li><a href="<?php echo base_url(); ?>Downloads"><i class="fa fa-download"><span class="splbl">Downloads</span></i></a></li>
								<li><a href="#"><i class="fa fa-book"><span class="splbl">User Manuals</span></i></a></li>
							</ul>
						</div>
					</div>       
				</div>
			</div>
	    </div>
	    <div class="wrapper">
			<?php
			$this -> load -> view('template/main_header', $data); ?>
			<div class="loading hide" id="loading_icon" style="top: -125px;">
				<button class="btn btn-primary" style="
					position: relative;
					top: 66px;
					left: -179px;
					background: #ffffffc2;
					border: none;
					color: black;
					font-size: 20px;
					font-weight: 600;
					font-family: sans-serif;
					">
					<span id="loading" class="spinner-border spinner-border-sm">
					Please Wait! It may take some time</span>
				</button>
			</div>
			<?php
			$this -> load -> view('template/main_menu');
} ?>
			<div class="content-wrapper">
				<section class="content">
		<?php
		$this->load->view($fileToLoad,$data); ?>
				</section>
			</div>
		<?php 
		if(!isset($_REQUEST['export_excel']) AND !isset($export_excel))
		{
			$this->load->view('template/main_footer');
			?>
		</div>
		<!-- ./wrapper -->
			<?php
		} ?>
		<?php 
		if(!isset($_REQUEST['export_excel']) AND !isset($export_excel) ){
			if(isset($data['edit'])){
				$this->load->view('template/script',$data['edit']);
			}else{
				$this->load->view('template/script');
			}
		} ?>
	</body>
</html>