<?php
class AdminView
{
	public function IndexAction()
	{
		$view = FrontController::render('../resources/templates/admin.html');
		FrontController::setBody($view);
		return true;
	}
	public function rightMenuAction()
	{
		$view = FrontController::render('../resources/templates/rightMenu.html');
		FrontController::setBody($view);
		return true;
	}
}
?>