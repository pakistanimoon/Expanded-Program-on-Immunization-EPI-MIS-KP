<!DOCTYPE html>
<html lang="en">
    <?php $this -> load -> view('template/style',$data); ?>
<body>
    <?php 
    //print_r($data);exit();
        $this-> load-> view('template/main_header', $data);
        $this-> load-> view($fileToLoad,$data); 
        $this-> load-> view('template/main_footer'); 
    ?> 
    <?php if(!isset($_REQUEST['export_excel']))
        { if(isset($data['edit'])){ $this->load->view('template/script',$data['edit']); }
        else{ $this->load->view('template/script'); } 
        } 
    ?>

</body>
</html>
