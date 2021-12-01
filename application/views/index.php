<!doctype html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>EPI Login</title>
		<link href="<?php echo base_url();?>includes/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>includes/css/login.css">
		<!-- Anti-flicker snippet (recommended)  --
		<style>.async-hide { opacity: 0 !important} </style>
		<script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
		h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
		(a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
		})(window,document.documentElement,'async-hide','dataLayer',4000,
		{'GTM-NWKGRLT':true});</script>
		<!-- Google Analytics --
		<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-100961453-2', 'auto');
		ga('require', 'GTM-NWKGRLT');
		ga('send', 'pageview');
		</script>
		<!-- End Google Analytics -->
	</head>
	<body style="max-height:100vh;overflow:hidden">
		<div class="container-fluid">
			<img src="<?php echo base_url(); ?>includes/images/back.jpg" class="bg">
			<!--<div id="covidinfo" style="">
				<div id="covidContainer" style="position: absolute; left: 0px; top: -246px;">
					<iframe src="https://www.worldometers.info/coronavirus/country/pakistan/" scrolling="no" style="width:300px;height:750px; border:none;">
					<p>Your browser does not support iframes.</p>
					</iframe>
				</div>
			</div>-->
			<div style="margin-top: 1px;" class="row">
				<div class="col-md-1 col-md-offset-1 col-sm-1"><img src="<?php echo base_url(); ?>includes/images/epi.png"></div>
				<div class="col-lg-8 col-md-8 col-sm-8 text-center">
					<h1 style="color: rgb(0, 153, 0); font-family: exo-bold; font-size: 48px;">Expanded Program On Immunization</h1>
					<div style="" class="row">
						<div class="col-lg-12 text-center">
							<h3 style="color: rgb(0, 153, 0); font-family: exo-medium; font-size: 29px; margin-top: -5px;">Department of Health, Khyber Pakhtunkhwa</h3>
						</div>
					</div>
				</div>
				<div class="col-md-1 col-sm-1"><img style="width: 85px;" src="<?php echo base_url(); ?>includes/images/kpk.png"></div>
			</div>
			<div class="empty"></div>
			<div class="row" style="padding-top: 219px;">
				<div class="col-lg-3 col-md-3 col-md-offset-3 col-sm-3 col-sm-offset-3 col-xs-5 col-xs-offset-3">
					<h2 class="text-center" style="font-family:exo-extrabold;color:#009900;">EPI - MIS</h2>
					<form role="form" action="<?php echo base_url(); ?>Home" method="post" class="login-form">
						<div class="form-group">
							<input name="username" placeholder="User Name" class="form-control" id="username" style="border-radius: 0px; border: 3px solid rgb(22, 141, 0);" type="text">
						</div>
						<div class="form-group">
							<input name="password" placeholder="Password" class="form-password form-control" id="password" style="border: 3px solid rgb(22, 141, 0); border-radius: 0px;" type="password">
						</div>
						<button type="submit" class="btn btnlogin" style="font-family:exo-extrabold;color:white;">Login</button>
						<p style="color: red;"><?php if($this -> session -> message){ echo $this -> session -> message;} ?></p>
					</form>
				</div>
			</div>
		</div> 
		<br><br><br><br><br>
		<footer class="footer" style="margin-top:50px;">
			<div class="row" style="background: rgb(22, 141, 0) none repeat scroll 0% 0%; width: 100%; margin-left: 0px ! important;">
				<div class="col-lg-2 col-lg-offset-10 col-md-3 col-md-offset-9 col-sm-4 col-sm-offset-8 col-xs-5 col-xs-offset-7">
					<a href="http://www.trfpakistan.org/" target="blank">
					<img style="display: inline-block; float: left;width: 40px;" src="<?php echo base_url(); ?>includes/images/trf.png"><h4 class="ftext" style="font-family:exo-light;color:white;"> &nbsp;Powered by<span style="font-weight: bold;font-style: italic;font-family: exo-bold;">TRF+</span></h4></a>
				</div>
			</div>
		</footer>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>