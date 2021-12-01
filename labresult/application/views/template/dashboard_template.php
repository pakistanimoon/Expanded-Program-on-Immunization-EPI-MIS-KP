<!DOCTYPE html>
<html lang="en">
    <?php $this -> load -> view('template/dashboard_style',$data); ?>
<body>
    <?php 
        $this-> load-> view('template/main_header', $data);
        $this-> load-> view($fileToLoad,$data); 
        $this-> load-> view('template/main_footer');
	?>
</body>
</html>