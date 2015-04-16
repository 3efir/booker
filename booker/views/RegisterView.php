<?php
class RegisterView
{
	protected $err = '';
	public function ShowForm()
	{
		$view = FrontController::render(
		'../resources/templates/RegisterForm.html', $this -> err);
		FrontController::setBody($view);
		return true;
	}
	public function setError($err)
	{
		$this -> err = $err;
	}
}
?>