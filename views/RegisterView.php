<?php
class RegisterView
{
	protected $err = '';
	public function ShowForm()
	{
		$form = FrontController::render(
		'../resources/templates/RegisterForm.html', $this -> err);
		$view = FrontController::render('../resources/templates/admin.html', $form);
        FrontController::setBody($view);		
		return true;
	}
	public function setError($err)
	{
		$this -> err = $err;
	}
}
?>
