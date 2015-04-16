<?php
/*
*@param facade: stores facade object
*@param view: stores view object
*/
class RegisterController
{
	private $facade;
	private $view;
// construct objects
	public function __construct()
	{
		$this -> facade = new formFacade();
		$this -> view = new RegisterView();
		return true;
	}
// call view for show register form
// if form submit call check form
	public function IndexAction()
	{
		$this -> view -> showForm();
		if(isset($_POST['submit']))
		{
			$this -> checkForm();
		}
		return true;
	}
// use facade for validate comming params from register form
// use facade for add new user 
	public function checkForm()
	{
		$name = strip_tags(trim($_POST['name']));
		$email = strip_tags(trim($_POST['email']));
		$pass = strip_tags(trim($_POST['pass']));
		$conf_pass = strip_tags(trim($_POST['conf_pass']));
		$result = $this -> facade -> checkRegister($name, $email, $pass,
		$conf_pass);
		if($result === true)
		{
			$add = $this -> facade -> addUser($name, $email, $pass, $conf_pass);
			if($add === true)
			{
				$this -> view -> setError("Thanks for registration. Now u 
				can login");
				$this -> view -> showForm();
				return true;
			}
			else
			{
				$this -> view -> setError("this email already exists");
				$this -> view -> showForm();
				return true;
			}
		}
		else
		{
			$this -> view -> setError($result);
			$this -> view -> showForm();
			return true;
		}
	}
}
?>