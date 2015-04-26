<?php
//session_start();
/*
*@param view: store view obj
*@param facade: store facade obj
*/
class LoginController
{
	protected $view, $facade;
	private $session;
// construct objects
	public function __construct()
	{
		$this -> view = new LoginView();
		$this -> facade = new userFacade();
		$this -> session = new SessionInterface();
		return true;
	}
// call view for show login form
// if form submit call check login
	public function IndexAction()
	{
		$this -> view -> showLoginForm();
		if(isset($_POST['submitLogin']))
		{
			$this -> checkLogin();
			return true;
		}
	}
// check login form if correct start session
	public function checkLogin()
	{
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$result = $this -> facade -> checkLogin($email, $pass);
		if(is_array($result))
		{
				$this -> session -> sessionStart($result);
				header("Location: /~user8/booker/", true, 301);
				exit();
		}
		else
		{
			$this -> view -> setError($result);
			$this -> view -> showLoginForm();
			return true;
		}
	}
// logout, close session
	public function closeSessionAction()
	{
		$this -> session -> sessionClose();
		header("Location: /~user8/booker/login/", true, 301);
		exit();
	}
}
?>