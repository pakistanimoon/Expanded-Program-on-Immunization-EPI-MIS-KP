	<head>
		<title><?php echo $pageTitle; ?></title>
		<!--****************************************Meta Tags Start Here***********************************-->
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">	
        <!--****************************************Style Files Start Here***********************************-->
        <link href="<?php echo base_url()."includes/assets/img/epi.png" ?>" rel="shortcut icon" type="image/png">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link href="<?php echo base_url();?>includes/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url();?>includes/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
		
		
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    	<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">    
		<link href="<?php echo base_url();?>includes/dist/css/AdminLTE.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url();?>includes/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url();?>includes/dist/css/custom.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url();?>includes/dist/css/customdashboard.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url();?>includes/dist/css/loader.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url();?>includes/dist/css/dashboard.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url();?>includes/dist/css/animate.min.css" rel="stylesheet" type="text/css">
		
		<!--<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">-->
		<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/b-1.5.1/b-html5-1.5.1/datatables.min.css"/>-->
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.2.1/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/fh-3.1.3/r-2.2.1/sl-1.2.5/datatables.min.css"/>
		<link href="<?php echo base_url();?>includes/dist/css/style.css" rel="stylesheet" type="text/css">		
		<link href="<?php echo base_url();?>includes/css/new_form_style.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url();?>includes/redrec/css/custom.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>includes/css/dropmeanu.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/cerv/popup-css.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>includes/css/dropzone.css">
		<link href="https://static.jstree.com/3.2.1/assets/dist/themes/default/style.min.css" rel="stylesheet">
	   <!--****************************************Style Files Ends Here***********************************-->
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
		
		
		<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script> 
		
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<!--<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.2.1/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/fh-3.1.3/r-2.2.1/sl-1.2.5/datatables.min.js"></script>-->

		<script src="https://static.jstree.com/3.2.1/assets/dist/jstree.js"></script>
		
		

	
		<style>
			#pop1{
				top: inherit;
				left: 0px !important;
				/*background: #4B4B4B;*/
				position: relative !important;
			}
			.simplePopup {
				display:none;
				position:relative;
				border: 1px solid #FFF;
				background:#fff;
				z-index:3;    
				padding-left: 12px;
				padding-top: 12px;
				padding-right: 12px;
				padding-bottom: 0px;
				width:100%  !important;    
			}
			.simplePopup>.header{
				text-align: center;
				background: #0E6EAB;
				color: white;
				padding-top: 15px;
				padding-bottom: 15px;
				margin: -12px;
				margin-bottom: 8px;
			}
			.simplePopup>.header>span{
				font-size: 13px;
				font-weight: bold;
			}
			.simplePopupClose {
				float: right;
				cursor: pointer;
				margin-left: 10px;	 
				color: white;
				font-size: 30px;	 
				float: right;
				margin-top: -9px;
			}
			.simplePopupBackground {
				display:none;
				background:#000;
				position:fixed;
				height:100%;
				width:100%;
				top:0;
				left:0;
				z-index:1;
			}	
		</style>
		<style>
		div.centered{
		margin-left:45%;
		 position: relative;
			top:50px;
		}

		.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper no-footer  {
			position: relative;
			top: 27px;
			
		}
		.dataTables_wrapper .dataTables_length label
		{
			display:initial;
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
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-100961453-2"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-100961453-2');
		</script>
		<!--Start of Tawk.to Script-->
		<script type="text/javascript">
			/* var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
			(function(){
			var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
			s1.async=true;
			s1.src='https://embed.tawk.to/5eb3db2781d25c0e5849a548/default';
			s1.charset='UTF-8';
			s1.setAttribute('crossorigin','*');
			s0.parentNode.insertBefore(s1,s0);
			})(); */
		</script>
		<!--End of Tawk.to Script-->
		<script data-ad-client="ca-pub-9103117154454112" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	</head>
	