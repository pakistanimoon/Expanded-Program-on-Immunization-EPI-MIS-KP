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
							<form class="text-center" action="Login/login" method="post" id="form-login">
								<input type="text" placeholder="Username" id="username_e" name="username_e" class="form-control" required>
								<input type="password" placeholder="Password" id="password_e" name="password_e" class="form-control" required><span class="cst-error">Sorry Wrong Username/Password</span>
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
   <section id="content">
        <div class="container">
            <div class="row mt-2 mb-2 row-english">
                <div class="col-lg-3 pl-custom">
                    <!-- <div class="heading"> -->
                        <!-- Others -->
                    <!-- </div> -->
                    <div class="row m-0 mt-1">
                        <div class="col-lg-12 inside">
                            <div class="row m-0 p-0">
                                <div class="col-lg-4 p-0">
                                    <img src="main_assets/img/surveys/ps.png" alt="">
                                </div>
                                <div class="col-lg-8 p-0 text-center margin-auto">
                                    <span class="title">
                                Human Resources
                            </span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                     <div class="row m-0 mt-1">
                        <div class="col-lg-12 inside">
                            <div class="row m-0 p-0">
                                <div class="col-lg-4 p-0">
                                    <img src="main_assets/img/surveys/iers.png" alt="">
                                </div>
                                <div class="col-lg-8 p-0 text-center margin-auto">
                                    <span class="title">
                                Birth and Death Notification System
                            </span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row m-0 mt-1">
                        <div class="col-lg-12 inside">
                            <div class="row m-0 p-0">
                                <div class="col-lg-4 p-0">
                                    <img src="main_assets/img/surveys/stamp.png" alt="">
                                </div>
                                <div class="col-lg-8 p-0 text-center margin-auto">
                                    <span class="title">
                               Licenses for Health Professions and Institutions 
                            </span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
					<div class="row m-0 mt-1">
                        <div class="col-lg-12 inside">
                            <div class="row m-0 p-0">
                                <div class="col-lg-4 p-0">
                                    <img src="main_assets/img/surveys/bb.png" alt="">
                                </div>
                                <div class="col-lg-8 p-0 text-center margin-auto">
                                    <span class="title">
                              Blood Bank System
                            </span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
					<div class="row m-0 mt-1">
                        <div class="col-lg-12 inside">
                            <div class="row m-0 p-0">
                                <div class="col-lg-4 p-0">
                                    <img src="main_assets/img/surveys/fin.png" alt="">
                                </div>
                                <div class="col-lg-8 p-0 text-center margin-auto">
                                    <span class="title">
                               Financial System
                            </span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 pr-custom p-0">
                    <!-- <div class="heading"> -->
                        <!-- Health Management Information System (MIS) Dashboards -->
                    <!-- </div> -->
                    <div class="row">
						<div class="col-lg-4">
							<div class="row m-0 mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											<img src="main_assets/img/surveys/demographics.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
												Performance Management System
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="row mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											<img src="main_assets/img/surveys/sur.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
												IERS
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="row m-0 mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											<img src="main_assets/img/surveys/hakeem.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
												Hakeem
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="row m-0 mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											<img src="main_assets/img/surveys/chain.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
												<!-- Mortality System -->
												MCH & Logistic System
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="row mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											<img src="main_assets/img/surveys/maternity.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
											   Maternal Mortality System 
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="row m-0 mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											<img src="main_assets/img/surveys/kidney.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
												 Kidney Failure System
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						 <div class="col-lg-4">
							<div class="row m-0 mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											<img src="main_assets/img/surveys/st.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
											   Statistical System 
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="row mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											<img src="main_assets/img/surveys/inventory.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
												Inventory and Procurements System
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="row m-0 mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											 <img src="main_assets/img/surveys/hiv.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
												Cancer Registry 
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                     <div class="col-lg-4">
                          <div class="row m-0 mt-1">
                            <div class="col-lg-12 inside">
                                <div class="row m-0 p-0">
                                    <div class="col-lg-4 p-0">
                                        <img src="main_assets/img/surveys/hc.png" alt="">
                                    </div>
                                    <div class="col-lg-8 p-0 text-center margin-auto">
                                        <span class="title">
											Health Insurance Card System
										</span>
                                    </div>
                                </div>
							</div>
                        </div>
                    </div>
					<div class="col-lg-4">
                          <div class="row  mt-1">
                            <div class="col-lg-12 inside">
                                <div class="row m-0 p-0">
                                    <div class="col-lg-4 p-0">
										<img src="main_assets/img/surveys/md.png" alt="">
                                    </div>
                                    <div class="col-lg-8 p-0 text-center margin-auto">
                                        <span class="title">
											<!-- MCH & Logistic System -->
												 Mortality System
										</span>
                                    </div>
                                </div>
							</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                          <div class="row m-0 mt-1">
                            <div class="col-lg-12 inside">
                                <div class="row m-0 p-0">
                                    <div class="col-lg-4 p-0">
                                        <img src="main_assets/img/surveys/flasks.png" alt="">
                                    </div>
                                    <div class="col-lg-8 p-0 text-center margin-auto">
                                        <span class="title">
											Foreigners Medical Test
										</span>
                                    </div>
                                </div>
							</div>
                        </div>
                    </div>
                     <div class="col-lg-4">
                          <div class="row m-0 mt-1">
                            <div class="col-lg-12 inside">
                                <div class="row m-0 p-0">
                                    <div class="col-lg-4 p-0">
                                        <img src="main_assets/img/surveys/nh.png" alt="">
                                    </div>
                                    <div class="col-lg-8 p-0 text-center margin-auto">
                                        <span class="title">
											GP System
										</span>
                                    </div>
                                </div>	
							</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                          <div class="row mt-1">
                            <div class="col-lg-12 inside">
                                <div class="row m-0 p-0">
                                    <div class="col-lg-4 p-0">
                                        <img src="main_assets/img/surveys/eq.png" alt="">
                                    </div>
                                    <div class="col-lg-8 p-0 text-center margin-auto">
                                        <span class="title">
										Medical Equipment Maintenance System
										</span>
                                    </div>
                                </div>
							</div>
                        </div>
                    </div>
					 <div class="col-lg-4">
                          <div class="row m-0 mt-1">
                            <div class="col-lg-12 inside">
                                <div class="row m-0 p-0">
                                    <div class="col-lg-4 p-0">
                                      <img src="main_assets/img/surveys/organs.png" alt="">
                                    </div>
                                    <div class="col-lg-8 p-0 text-center margin-auto">
                                        <span class="title">
										Organ Transplant System
										</span>
                                    </div>
                                </div>
							</div>
                        </div>
                    </div>
					</div>
                </div>
            </div>
			
			
			<!-- row Arabic -->
			<div class="row mt-2 mb-2 row-arabic">
                <div class="col-lg-3 pl-custom">
                    <!-- <div class="heading"> -->
                       <!-- الدراسات الاستقصائية -->

                    <!-- </div> -->
                    <div class="row m-0 mt-1">
                        <div class="col-lg-12 inside">
                            <div class="row m-0 p-0">
                                <div class="col-lg-4 p-0">
                                    <img src="main_assets/img/surveys/ps.png" alt="">
                                </div>
                                <div class="col-lg-8 p-0 text-center margin-auto">
                                    <span class="title">
									نظام شؤون الموظفين 
                            </span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                     <div class="row m-0 mt-1">
                        <div class="col-lg-12 inside">
                            <div class="row m-0 p-0">
                                <div class="col-lg-4 p-0">
                                    <img src="main_assets/img/surveys/iers.png" alt="">
                                </div>
                                <div class="col-lg-8 p-0 text-center margin-auto">
                                    <span class="title">
                           نظام تبليغ الولادات والوفيات 
                            </span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row m-0 mt-1">
                        <div class="col-lg-12 inside">
                            <div class="row m-0 p-0">
                                <div class="col-lg-4 p-0">
                                    <img src="main_assets/img/surveys/stamp.png" alt="">
                                </div>
                                <div class="col-lg-8 p-0 text-center margin-auto">
                                    <span class="title">
                            نظام لاصدار تراخيص المهن والمؤسسات الصحية
                            </span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
					<div class="row m-0 mt-1">
                        <div class="col-lg-12 inside">
                            <div class="row m-0 p-0">
                                <div class="col-lg-4 p-0">
                                     <img src="main_assets/img/surveys/bb.png" alt="">
                                </div>
                                <div class="col-lg-8 p-0 text-center margin-auto">
                                    <span class="title">
								نظام بنك الدم الوطني
                            </span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
					<div class="row m-0 mt-1">
                        <div class="col-lg-12 inside">
                            <div class="row m-0 p-0">
                                <div class="col-lg-4 p-0">
                                   <img src="main_assets/img/surveys/fin.png" alt="">
                                </div>
                                <div class="col-lg-8 p-0 text-center margin-auto">
                                    <span class="title">
                           نظام الرواتب والشؤون المالية 
                            </span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 pr-custom">
                    <!-- <div class="heading"> -->
                        <!-- نظام معلومات إدارة الصحة (MIS) -->
                    <!-- </div> -->
                    <div class="row">
						<div class="col-lg-4">
							<div class="row m-0 mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											<img src="main_assets/img/surveys/demographics.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
												نظام مؤشرات الاداء 
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="row mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											<img src="main_assets/img/surveys/sur.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
												نظام التبليغ عن الامراض 
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="row m-0 mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											<img src="main_assets/img/surveys/hakeem.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
												حكيم
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="row m-0 mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											<img src="main_assets/img/surveys/chain.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
												نظام الامومة والطفولة 
												نظام تزويد وسائل تنظيم الاسرة

											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="row mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											<img src="main_assets/img/surveys/maternity.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
											  نظام وفيات الامهات 
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="row m-0 mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											<img src="main_assets/img/surveys/kidney.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
											نظام سجل وحدة الكلى
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						 <div class="col-lg-4">
							<div class="row m-0 mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											<img src="main_assets/img/surveys/st.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
											  نظام المعلومات 
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="row mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											<img src="main_assets/img/surveys/inventory.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
											نظام المستودعات والتزويد
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="row m-0 mt-1">
								<div class="col-lg-12 inside">
									<div class="row m-0 p-0">
										<div class="col-lg-4 p-0">
											 <img src="main_assets/img/surveys/hiv.png" alt="">
										</div>
										<div class="col-lg-8 p-0 text-center margin-auto">
											<span class="title">
												سجل مرضى السرطان 
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                     <div class="col-lg-4">
                          <div class="row m-0 mt-1">
                            <div class="col-lg-12 inside">
                                <div class="row m-0 p-0">
                                    <div class="col-lg-4 p-0">
                                        <img src="main_assets/img/surveys/hc.png" alt="">
                                    </div>
                                    <div class="col-lg-8 p-0 text-center margin-auto">
                                        <span class="title">
										نظام لاصدار بطاقات التأمين الصحي 
										</span>
                                    </div>
                                </div>
							</div>
                        </div>
                    </div>
					<div class="col-lg-4">
                          <div class="row  mt-1">
                            <div class="col-lg-12 inside">
                                <div class="row m-0 p-0">
                                    <div class="col-lg-4 p-0">
										<img src="main_assets/img/surveys/md.png" alt="">
                                    </div>
                                    <div class="col-lg-8 p-0 text-center margin-auto">
                                        <span class="title">
										نظام الوفيات
										</span>
                                    </div>
                                </div>
							</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                          <div class="row m-0 mt-1">
                            <div class="col-lg-12 inside">
                                <div class="row m-0 p-0">
                                    <div class="col-lg-4 p-0">
                                        <img src="main_assets/img/surveys/flasks.png" alt="">
                                    </div>
                                    <div class="col-lg-8 p-0 text-center margin-auto">
                                        <span class="title">
											نظام تسجيل حالات الامراض الصدرية 
										</span>
                                    </div>
                                </div>
							</div>
                        </div>
                    </div>
                     <div class="col-lg-4">
                          <div class="row m-0 mt-1">
                            <div class="col-lg-12 inside">
                                <div class="row m-0 p-0">
                                    <div class="col-lg-4 p-0">
                                        <img src="main_assets/img/surveys/analytics.png" alt="">
                                    </div>
                                    <div class="col-lg-8 p-0 text-center margin-auto">
                                        <span class="title">
										نظام الطب العام
										</span>
                                    </div>
                                </div>	
							</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                          <div class="row mt-1">
                            <div class="col-lg-12 inside">
                                <div class="row m-0 p-0">
                                    <div class="col-lg-4 p-0">
                                        <img src="main_assets/img/surveys/nh.png" alt="">
                                    </div>
                                    <div class="col-lg-8 p-0 text-center margin-auto">
                                        <span class="title">
										نظام صيانة الاجهزة الطبية
										</span>
                                    </div>
                                </div>
							</div>
                        </div>
                    </div>
					 <div class="col-lg-4">
                          <div class="row m-0 mt-1">
                            <div class="col-lg-12 inside">
                                <div class="row m-0 p-0">
                                    <div class="col-lg-4 p-0">
                                      <img src="main_assets/img/surveys/organs.png" alt="">
                                    </div>
                                    <div class="col-lg-8 p-0 text-center margin-auto">
                                        <span class="title">
										نظام مديرية المركز الاردني لزراعة الاعضاء
										</span>
                                    </div>
                                </div>
							</div>
                        </div>
                    </div>
					</div>
                </div>
            </div>
			
			
			<!-- row Arabic End -->
        </div>
    </section>
	<section id="copyright">
        <div class="container-fluid">
            <div class="row row-english">
                <div class="col-lg-12">
                    Copyright &copy; <span id="year"></span>. All Right Reserved.
                </div>
            </div>
			<div class="row row-arabic">
                <div class="col-lg-12">
                   حقوق النشر &copy; <span id="year"></span>. جميع الحقوق محفوظة
                </div>
            </div>
        </div>
    </section>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="main_assets/js/jquery-3.2.1.slim.min.js"></script>
    <script src="main_assets/js/popper.min.js"></script>
    <script src="main_assets/js/bootstrap.min.js"></script>
    <script>
    document.getElementById("year").innerHTML = new Date().getFullYear();
	
	// Onclick change screen language
	$(document).ready(function(){  
    $("#lang-change").click(function(){  
        $("body").addClass("div_rtl");  
    }); 
 $("#lang-change1").click(function(){  
        $("body").removeClass("div_rtl");  
    });  	
});
</script>
</body>
</html>