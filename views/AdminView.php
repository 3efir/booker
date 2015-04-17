<?php
class AdminView
{
	// incoming param calendar
	public function IndexAction($calendar)
	{
		$view = FrontController::render('../resources/templates/admin.html', $calendar);
		FrontController::setBody($view);
		return true;
	}
	// incoming param array with keys and values for admin menu
	public function rightMenuAction($data)
	{
		$file = file_get_contents(
		'resources/templates/rightMenu.html');
		$view = FrontController::templateRender($file, $data);
		FrontController::setBody($view);
		return true;
	}
}
?>
