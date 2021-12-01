<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */

//print_r($_REQUEST); exit();
$level = $_REQUEST['level'];
$year = $_REQUEST['year'];
$indicator = $_REQUEST['indicator']; 
$parentou = $_REQUEST['parentou'];

//print_r($level);
//print_r($year); exit();
//if post level = 1 then get data from db for that level and year and display
if($level==1){
echo '[{
	"indicatorid": "1.1.1",
	"level": 1,
	"year": 2019,
	"disaggragations": [{
		"disaggragationid": "1.1.1",
		"data": [{
			"value": 123
		}]
	},{
		"disaggragationid": "1.1.1a",
		"data": [{
			"value": 123
		}]
	},{
		"disaggragationid": "1.1.1b",
		"data": [{
			"value": 123
		}]
	},{
		"disaggragationid": "1.1.1c",
		"data": [{
			"value": 123
		}]
	},{
		"disaggragationid": "1.1.1d",
		"data": [{
			"value": 124
		}]
	}]
}]';
}
else if($level==2){
echo'[{
	"indicatorid": "1.1.1",
	"level": 2,
	"year": 2018,
	"disaggragations": [{
		"disaggragationid": "1.1.1",
		"data": [{
			"oucode":1,
			"value": 123
		},{
			"oucode":2,
			"value": 56
		},{
			"oucode":3,
			"value": 36
		}]
	},{
		"disaggragationid": "1.1.1a",
		"data": [{
			"oucode":1,
			"value": 123
		},{
			"oucode":2,
			"value": 56
		},{
			"oucode":3,
			"value": 36
		}]
	},{
		"disaggragationid": "1.1.1b",
		"data": [{
			"oucode":1,
			"value": 123
		},{
			"oucode":2,
			"value": 56
		},{
			"oucode":3,
			"value": 36
		}]
	},{
		"disaggragationid": "1.1.1c",
		"data": [{
			"oucode":1,
			"value": 123
		},{
			"oucode":2,
			"value": 56
		},{
			"oucode":3,
			"value": 36
		}]
	},{
		"disaggragationid": "1.1.1d",
		"data": [{
			"oucode":1,
			"value": 123
		},{
			"oucode":2,
			"value": 56
		},{
			"oucode":3,
			"value": 36
		}]
	}]
}]';
} 
else if($level==3){
echo'[{
	"indicatorid": "1.1.1",
	"level": 3,
	"parentou": 2, 
	"year": 2018,
	"disaggragations": [{
		"disaggragationid": "1.1.1",
		"data": [{
			"oucode":211,
			"value": 123
		},{
			"oucode":232,
			"value": 56
		},{
			"oucode":253,
			"value": 36
		}]
	},{
		"disaggragationid": "1.1.1a",
		"data": [{
			"oucode":211,
			"value": 123
		},{
			"oucode":232,
			"value": 56
		},{
			"oucode":263,
			"value": 36
		}]
	},{
		"disaggragationid": "1.1.1b",
		"data": [{
			"oucode":213,
			"value": 123
		},{
			"oucode":233,
			"value": 56
		},{
			"oucode":243,
			"value": 36
		}]
	},{
		"disaggragationid": "1.1.1c",
		"data": [{
			"oucode":221,
			"value": 123
		},{
			"oucode":232,
			"value": 56
		},{
			"oucode":253,
			"value": 36
		}]
	},{
		"disaggragationid": "1.1.1d",
		"data": [{
			"oucode":211,
			"value": 123
		},{
			"oucode":232,
			"value": 56
		},{
			"oucode":233,
			"value": 36
		}]
	}]
}]';
}
//if post level = 2 then get data from db for that level and year and display
//if post level = 3 then get data from db for that level and year and display