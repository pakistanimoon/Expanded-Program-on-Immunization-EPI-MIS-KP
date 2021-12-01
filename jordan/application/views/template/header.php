<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="main_assets/img/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="main_assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<link rel="stylesheet" href="main_assets/css/style.css">
	<!-- For Arabic Styling -->
	<link rel="stylesheet" href="main_assets/css/arabicstyle.css">
	<title>Health | Jordan</title>
</head>
  <body>
   <section id="header">
        <div class="container">
            <div class="row row-english">
                <div class="col-lg-1 text-right">
                    <img src="main_assets/img/jlogo.svg" alt="">
                </div>
                <div class="col-lg-10">
                    <!-- <h4><span class="top-heading">Ministry of Health Services</span> <br><span class="sub-heading-top"> Government of Jordan</span></span> </h4> -->
					 <h4 style="position:relative;">Ministry of Health <br> Hashemite Kingdom of Jordan </h4>
				</div>
                <div class="col-lg-1">
                    <!-- <span><a href=""><i class="fas fa-user-tie"></i> Login</a> </span> -->
					<div class="btn-group">
						<button type="button" class="btn btn-primary" data-toggle="dropdown"><i class="fas fa-user-tie"></i> Login</button>
						<div class="dropdown-menu dropdown-english">
							<form class="text-center">
								<input type="text" placeholder="Username" id="username_e" name="username_e" class="form-control" required>
								<input type="password" placeholder="Password" id="password_e" name="username_e" class="form-control" required><span class="cst-error">Sorry Wrong Username/Password</span>
								<p>You are not authorised to access</p>
								<input type="submit" id="submite_e" value="Submit" class="login-btn">
							</form>
						</div>
					</div>
                </div>
            </div>
			 <div class="row row-arabic" style="margin-top: 5px;">
				 <div class="col-lg-2 text-right">
                    <img src="main_assets/img/jlogo.svg" alt="">
                </div>
                <div class="col-lg-9 text-right" style="padding-right: 0px;">
                    <!-- <h4>وزارة الخدمات الصحية <br> حكومة الأردن </h4> -->
					 <!-- <h4 style="position: relative; top: 10px;s">وزارة الخدمات الصحية  حكومة الأردن </h4> -->
					 <img src="main_assets/img/jordanarabic.png" alt="" >
				</div>
                <div class="col-lg-1">
                    <!-- <span class="text-nowrap"><a href=""><i class="fas fa-user-tie"></i> تسجيل الدخول</a> </span> -->
					<div class="btn-group">
						<button type="button" class="btn btn-primary" data-toggle="dropdown"><i class="fas fa-user-tie"></i>  تسجيل الدخول </button>
						<div class="dropdown-menu">
							<form class="text-center">
								<input type="text" placeholder="اسم المستخدم" id="username_a" name="username_a" class="form-control" required>
								<input type="password" placeholder="كلمه السر" id="password_a" name="password_a" class="form-control" required><span class="cst-error">آسف اسم المستخدم / كلمة المرور خاطئة</span>
								<p>غير مصرح لك بالوصول</p>
								<input type="submit" id="submit_a" value="خضع" class="login-btn">
							</form>
						</div>
					</div>
                </div>
            </div>
        </div>
   </section>
    <section id="banner">
        <div class="container">
            <div class="row row-english">
                <div class="col-lg-12 banner">
                    Health Information System (HIS) - Integrated health services, logistic and surveillance dashboard
					<button class="btn btn-custom float-right" id="lang-change">اللغة العربية</button>
                </div>
            </div>
			<div class="row row-arabic">
                <div class="col-lg-12 banner">
						نظام المعلومات الصحية (HIS) - الخدمات الصحية المتكاملة ولوحة المعلومات اللوجستية والمراقبة
					<button class="btn btn-custom float-left" id="lang-change1">English</button>
                </div>
            </div>
        </div>
    </section>