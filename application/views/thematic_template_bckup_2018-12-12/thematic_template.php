<?php if(!isset($_REQUEST['export_excel']))
{
?>
<!DOCTYPE html>
<html>
	<?php
		$this -> load -> view('thematic_template/style', $data);
	?>
	<body>
	    <div class="flypanels-container preload">
			<?php
			$this -> load -> view('thematic_template/main_menu');
} ?>
		<?php
			$this->load->view($fileToLoad,$data); ?>
			
			
			
			<div class="footer_copyrights">
				<i class="fa fa-copyright" aria-hidden="true"></i> CopyRight All Rights Reserve.Health Department Government of <?php echo $this -> session -> provincename; ?>.
			</div>
	</body>
</html>