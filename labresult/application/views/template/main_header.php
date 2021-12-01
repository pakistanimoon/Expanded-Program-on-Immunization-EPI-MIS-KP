<!--<style>

li:hover {
  border-color: blue;
}

</style>-->
<style>
.nav>li>a:focus, .nav>li>a:hover{
	color: #fff;
    background-color: #286090;
    border-color: #204d74;
}
</style>
<header class="main-header">
<section id="header">
      <div class="container">
      <div class="row">
        <div class="col-md-3">
        <img src="<?php echo base_url(); ?>includes/image/logo/epi.png" class="img-responsive" alt="EPI Logo">
        <img src="<?php echo base_url(); ?>includes/image/logo/logo6.png" class="img-responsive" alt="KPK Logo">
		<nav class="navbar navbar-static-top" role="navigation">
      </div>
      <div class="col-md-6">
        <h2>EPI Surveillance Lab Results</h2>
      </div>
      <div class="col-md-3">
        <label>Login as <?php echo $this-> session -> userdata('username'); ?></label>
        <span>
          <a href="<?php echo base_url(); ?>Login/logout"><i class="fa fa-sign-out" aria-hidden="true" style="color:red;">
          </i></a> 
        </span>
      </div>
      </div>
    </div>
    </section>
  </div>
	<div class="container">
	<div class="row">
		<div class="col-md-12" style="background: #3c8dbc;">
			<?php if ( $this-> session -> userdata('utype')=='LRDEO'); { ?>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
			<li class="dropdown user user-menu">
				<a href="<?php echo base_url(); ?>Measles_Case/search_by_epid" style="color:#fff">Search by EPID Number</a>
			</li>
			<li class="dropdown user user-menu">
				<a href="<?php echo base_url(); ?>Measles_Case/add_data" style="color:#fff">List All Cases</a>
			</li>
				<?php }?>
			</ul>	
		
		</div>
		</div>
	</div>
	</div>
	</nav>
</header>