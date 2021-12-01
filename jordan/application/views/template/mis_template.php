<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	
<!doctype html>
<html lang="en"> 
    <?php $this->load->view('template/style');?>  
    <body>

        <?php $this->load->view('template/header');  ?>
        <section id="content">
            <?php $this->load->view('main'); ?>
        </section>

        <?php $this->load->view('template/footer'); ?>
        <?php $this->load->view('template/script'); ?>
    </body>
 </html>