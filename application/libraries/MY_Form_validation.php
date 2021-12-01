<?php
/**
 * MY_Form_validation Class
 *
 * This class is extention of form validation library to handle some scenarios like date format validation etc
 * @author 			Raja Imrqan Qamer <rajaimranqamer@gmail.com>
 * @last updated 	2018-03-15 by Imran
 */
class MY_Form_validation extends CI_Form_validation{
	public function __construct($rules = array())
	{
		parent::__construct($rules);
	}
	public function valid_date($date,$format = 'Y-m-d')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) === $date;
	}
	public function lessEqualTo_date($date,$comparewith)
	{
		if ($comparewith >= $date)
			return True;
		else {
			return False;
		}
	}
	/*
 * This Function not Allow number in system setup, Manage HR in which Have All Table (user name and Father name)
 * @author 			Zeeshan Ahmad <zsa.kpk@gmail>
 * @last updated 	2019-06-20 by  Zeeshan
 */
	public function alpha_spaces($str)
	{
		return (bool)preg_match("/^[a-z .,\-]+$/i",$str);
	}
/*
 * This Function Allow number in system setup, Manage HR in which Have All Table Banking Details (Branch Code,Basic Pay,Bank Account Number)
 * @author 			Zeeshan Ahmad <zsa.kpk@gmail>
 * @last updated 	2019-06-20 by  Zeeshan
 */	
	public function numeric_spaces($str)
	{
		return (bool) preg_match('/^[0-9 .,\-]+$/i',$str);
	}
}