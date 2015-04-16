<?php
session_start();
/*
* class for work with session
* 
*/
class SessionInterface
{
	public function __construct()
	{
		if(empty($_SESSION['room']))
		{
			$_SESSION['room'] = 1;
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
	public function setRoom($id)
	{
		$_SESSION['room'] = $id;
		return true;
	}
	public function sessionClose()
	{
		session_unset();
		return true;
	}
}
?>