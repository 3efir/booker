<?php
session_start();
/*
* class for work with session
* 
*/
class SessionInterface
{
	// if object create first time set room 1 and language English 
	public function __construct()
    {
        //date_default_timezone_set('Europe/Kiev');        
		if(empty($_SESSION['room']))
		{
			$_SESSION['room'] = 1;
		}
		if(empty($_SESSION['lang']))
		{
			$_SESSION['lang'] = 'eng';
		}
		if(empty($_SESSION['month']))
        {        
            $month = date("m");
            $year = date("y");
            $this -> setMonth($month);
            $this -> setYear($year);            
        }
		return true;
	}
	// call if logged
	public function sessionStart($arr)
	{
		$_SESSION['id'] = $arr[0]['id'];
		$_SESSION['user'] = $arr[0]['name'];
		$_SESSION['whoIam'] = $arr[0]['isAdmin'];
		return true;
	}
	// call for check session
	public function getSession()
	{
		return $_SESSION;
	}
	// return number of selected room
	public function getRoom()
	{
		return $_SESSION['room'];
	}
	// set selected room
	public function setRoom($id)
	{
		$_SESSION['room'] = $id;
		return true;
	}
	// close session
	public function sessionClose()
	{
		session_unset();
		session_destroy();
		return true;
    }
	// set selected month
    public function setMonth($month)
    {
        $_SESSION['month'] = $month;
        return true;
    }
	// set selected year
    public function setYear($year)
    {
        $_SESSION['year'] = $year;
        return true;
    }
	// return selected month
    public function getMonth()
    {
		return $_SESSION['month'];
    }
	// return selected year
    public function getYear()
    {
        return $_SESSION['year'];
    }
	// return selected lang
	public function getLang()
	{
		return $_SESSION['lang'];
	}
	// set selected lang
	public function setLang($lang)
	{
		$_SESSION['lang'] = $lang;
		return true;
	}
}
?>
