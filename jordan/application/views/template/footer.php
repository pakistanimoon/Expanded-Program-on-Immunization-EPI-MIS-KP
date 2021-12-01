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