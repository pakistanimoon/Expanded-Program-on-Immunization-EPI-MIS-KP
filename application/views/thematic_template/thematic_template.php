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
			if(isset($_ccmMenu) && $_ccmMenu=TRUE){
				$data['_ccmMenu']=$_ccmMenu;
				$this -> load -> view('thematic_template/main_menu',$data);
			}else{
				$this -> load -> view('thematic_template/main_menu');
			}
			
} ?>
		<?php
			$this->load->view($fileToLoad,$data); ?>
			
			
			
			<div class="footer_copyrights">
				<?php if($this -> uri -> segment(2) == 'ThematicMapJordan'){ ?>
				<i class="fa fa-copyright" aria-hidden="true"></i> CopyRight All Rights Reserve.Health Department Government of Jordan.
				<?php }else{ ?>
				<i class="fa fa-copyright" aria-hidden="true"></i> CopyRight All Rights Reserve.Health Department Government of <?php echo $this -> session -> provincename; ?>.
				<?php } ?>
			</div>
	</body>
</html>