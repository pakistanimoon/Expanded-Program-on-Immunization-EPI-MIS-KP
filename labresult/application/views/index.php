<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EPI Surveillance Lab Results</title>
    <link href="<?php echo base_url(); ?>includes/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>includes/css/style.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>includes/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>includes/js/jquery.min.js"></script>
    <!-- fontAwesome -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>
<body id="full-body">
    <?php
    if ($this->session->flashdata('message')) {
    ?>
    
    <?php
    }
?>
    <div class="container">
        <section id="login-section">
            <div class="row"> <div class="col-md-6"> <img src="<?php echo base_url(); ?>includes/image/logo/logo6.png" class="img-responsive logo-login" alt="kpk Logo" title="kpk Logo"> <img src="<?php echo base_url(); ?>includes/image/logo/epi.png" class="img-responsive logo-login" alt="EPI Logo" title="EPI Logo" style="margin-left:57%;"> </div> </div>
            <div class="row">
                <div class="col-md-6">
                    <h1 class="heading">EPI Surveillance <br>Lab Results</h1>
                </div>
            </div>
        </section>
        <section id="login-form">
            <div class="row signin-row">
                <div class="col-md-4 col-md-offset-8 col-sm-4 col-sm-offset-8 col-xs-4 col-xs-offset-8">
                    <h3>Sign In</h3>
                    <form action="<?php echo base_url(); ?>Login/login" method="post">
                        <div class="row">
                            <div class="col-md-1">
                                <label><i class="fa fa-user"></i></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="username" placeholder="Login ID">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                <label><i class="fa fa-lock"></i></label>
                            </div>
                            <div class="col-md-10">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                            </div>
                        </div>
                        <div class="row btn-row" >
                            <span id="msg">
                            <?php echo $this->session->flashdata('message'); ?>
                        </span>
                            <div class="col-md-12">
                                <button class="btn btn-primary">Login </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
  