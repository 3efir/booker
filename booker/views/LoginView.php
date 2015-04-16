<?php
class LoginView
{
	protected $err = '';
	public function showLoginForm()
	{
		$view = FrontController::render('../resources/templates/loginForm.html',
		$this -> err);
		FrontController::setBody($view);
		return true;
	}
	public function setError($err)
	{
		$this -> err = $err;
	}
}
?>