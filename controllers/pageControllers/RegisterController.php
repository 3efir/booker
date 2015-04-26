<?php
/*
*@param facade: stores facade object
*@param view: stores view object
*/
class RegisterController
{
	private $facade, $view;
// construct objects
	public function __construct()
	{
		$this -> facade = new AdminFacade();
		$this -> view = new RegisterView();
		return true;
	}
// call view for show register form
// if form submit call check form
	public function IndexAction()
	{
		$data = $this -> facade -> getArray();
		$this -> view -> showForm($data);
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
		$name = $_POST['name'];
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$conf_pass = $_POST['conf_pass'];
		$result = $this -> facade -> checkRegister($name, $email, $pass,
		$conf_pass);
		if($result === true)
		{
			$add = $this -> facade -> addUser();
			$data = $this -> facade -> getArray();
			$this -> view -> showForm($data);
			return true;
		}
		else
		{
			$data = $this -> facade -> getArray();
			$this -> view -> showForm($data);
			return true;
		}
	}
	// method for add room
	public function addRoomAction()
	{
		$data = $this -> facade -> getArray();
		$this -> view -> showRoomForm($data);
		if(isset($_POST['room']))
		{
			$this -> facade -> addRoom($_POST['room']);
		}
		return true;
	}
	// method for edit info about employee
	public function editEmployeeAction()
	{
		$id = Frontcontroller::getParams();
		$arr = $this -> facade -> selectEmployee($id);
		if(isset($_POST['update']))
		{
			$result = $this -> facade -> updateEmployee($id, $_POST);
			$this -> view -> editForm($arr, $result);
			return true;
		}
		else
		{
			$this -> view -> editForm($arr);
			return true;
		}
	}
}
?>