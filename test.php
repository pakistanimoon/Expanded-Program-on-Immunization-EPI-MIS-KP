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
//print_r($level);
//print_r($year); exit();
//if post level = 1 then get data from db for that level and year and display
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
//if post level = 2 then get data from db for that level and year and display
//if post level = 3 then get data from db for that level and year and display