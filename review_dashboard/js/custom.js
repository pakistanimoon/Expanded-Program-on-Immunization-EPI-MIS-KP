window.onload = function () {
	
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	
	title:{
//		text:"Fortune 500 Companies by Country"
	},
	axisX:{
		interval: 1
	},
	axisY2:{
		interlacedColor: "rgba(1,77,101,.2)",
		gridColor: "rgba(1,77,101,.1)",
//		title: "Number of Companies"
	},
	data: [{
		type: "bar",
		name: "companies",
		axisYType: "secondary",
		color: "#980894",
		dataPoints: [
		{ y: 83, label: "Chakwal" },
			{ y: 37, label: "Rawalpindi" },
			{ y: 70, label: "Attock" },
			{ y: 97, label: "Lahore" },
			{ y: 75, label: "Mandi Bahauddin" },
			{ y: 84, label: "Sialkot" },
			{ y: 135, label: "Shikupura" },
			{ y: 98, label: "Narowal" },
			{ y: 91, label: "Jhalem" },
			{ y: 15, label: "Faisalabad" },
			{ y: 43, label: "Toba tek Singh" },
			{ y: 89, label: "Gujarnwala" },
			{ y: 65, label: "Sargodha" },
			{ y: 68, label: "Hafizabad" },
			{ y: 29, label: "Liyyah" },
			{ y: 52, label: "Kasur" },
			{ y: 103, label: "Sahiwal" },
            { y: 70, label: "Gujrat" },
			{ y: 97, label: "Khanewal" },
			{ y: 75, label: "Mianwali" },
			{ y: 84, label: "Jhang" },
			{ y: 135, label: "Bhakar" },
            { y: 43, label: "Okara" },
			{ y: 89, label: "Khusab" },
			{ y: 65, label: "Vehari" },
			{ y: 68, label: "Pakpattan" },
			{ y: 29, label: "Multan" },
			{ y: 52, label: "Nankana Sahib" },
			{ y: 103, label: "Bahawalpur" },
            { y: 70, label: "Chinot" },
			{ y: 97, label: "D G Khan" },
            { y: 97, label: "Muzaffargarh" },
			{ y: 75, label: "Rahim Yar Khan" },
			{ y: 84, label: "RajanPur" },
			{ y: 135, label: "Shikupura" },
    
			{ y: 134, label: "BahawalNagar" }
		]
	}]
});
chart.render();

    
    /// Container id 2
    var chart2 = new CanvasJS.Chart("chartContainer2", {
	animationEnabled: true,
	
	title:{
//		text:"Fortune 500 Companies by Country"
	},
	axisX:{
		interval: 2
	},
	axisY2:{
		interlacedColor: "rgba(1,77,101,.2)",
		gridColor: "rgba(1,77,101,.1)",
//		title: "Number of Companies"
	},
	data: [{
		type: "bar",
		name: "companies",
		axisYType: "secondary",
		color: "#f53a03",
		dataPoints: [
		{ y: 83, label: "Chakwal" },
			{ y: 37, label: "Rawalpindi" },
			{ y: 70, label: "Attock" },
			{ y: 97, label: "Lahore" },
			{ y: 75, label: "Mandi Bahauddin" },
			{ y: 84, label: "Sialkot" },
			{ y: 135, label: "Shikupura" },
			{ y: 98, label: "Narowal" },
			{ y: 91, label: "Jhalem" },
			{ y: 15, label: "Faisalabad" },
			{ y: 43, label: "Toba tek Singh" },
			{ y: 89, label: "Gujarnwala" },
			{ y: 65, label: "Sargodha" },
			{ y: 68, label: "Hafizabad" },
			{ y: 29, label: "Liyyah" },
			{ y: 52, label: "Kasur" },
			{ y: 103, label: "Sahiwal" },
            { y: 70, label: "Gujrat" },
			{ y: 97, label: "Khanewal" },
			{ y: 75, label: "Mianwali" },
			{ y: 84, label: "Jhang" },
			{ y: 135, label: "Bhakar" },
            { y: 43, label: "Okara" },
			{ y: 89, label: "Khusab" },
			{ y: 65, label: "Vehari" },
			{ y: 68, label: "Pakpattan" },
			{ y: 29, label: "Multan" },
			{ y: 52, label: "Nankana Sahib" },
			{ y: 103, label: "Bahawalpur" },
            { y: 70, label: "Chinot" },
			{ y: 97, label: "D G Khan" },
            { y: 97, label: "Muzaffargarh" },
			{ y: 75, label: "Rahim Yar Khan" },
			{ y: 84, label: "RajanPur" },
			{ y: 135, label: "Shikupura" },
    
			{ y: 134, label: "BahawalNagar" }
		]
	}]
});
chart2.render();
    
     /// Container id 3
    var chart3 = new CanvasJS.Chart("chartContainer3", {
	animationEnabled: true,
	
	title:{
//		text:"Fortune 500 Companies by Country"
	},
	axisX:{
		interval: 2
	},
	axisY2:{
		interlacedColor: "rgba(1,77,101,.2)",
		gridColor: "rgba(1,77,101,.1)",
//		title: "Number of Companies"
	},
	data: [{
		type: "bar",
		name: "companies",
		axisYType: "secondary",
		color: "#25924c",
		dataPoints: [
		{ y: 83, label: "Chakwal" },
			{ y: 37, label: "Rawalpindi" },
			{ y: 70, label: "Attock" },
			{ y: 97, label: "Lahore" },
			{ y: 75, label: "Mandi Bahauddin" },
			{ y: 84, label: "Sialkot" },
			{ y: 135, label: "Shikupura" },
			{ y: 98, label: "Narowal" },
			{ y: 91, label: "Jhalem" },
			{ y: 15, label: "Faisalabad" },
			{ y: 43, label: "Toba tek Singh" },
			{ y: 89, label: "Gujarnwala" },
			{ y: 65, label: "Sargodha" },
			{ y: 68, label: "Hafizabad" },
			{ y: 29, label: "Liyyah" },
			{ y: 52, label: "Kasur" },
			{ y: 103, label: "Sahiwal" },
            { y: 70, label: "Gujrat" },
			{ y: 97, label: "Khanewal" },
			{ y: 75, label: "Mianwali" },
			{ y: 84, label: "Jhang" },
			{ y: 135, label: "Bhakar" },
            { y: 43, label: "Okara" },
			{ y: 89, label: "Khusab" },
			{ y: 65, label: "Vehari" },
			{ y: 68, label: "Pakpattan" },
			{ y: 29, label: "Multan" },
			{ y: 52, label: "Nankana Sahib" },
			{ y: 103, label: "Bahawalpur" },
            { y: 70, label: "Chinot" },
			{ y: 97, label: "D G Khan" },
            { y: 97, label: "Muzaffargarh" },
			{ y: 75, label: "Rahim Yar Khan" },
			{ y: 84, label: "RajanPur" },
			{ y: 135, label: "Shikupura" },
    
			{ y: 134, label: "BahawalNagar" }
		]
	}]
});
chart3.render();
}