<?php 
/*
* @param htmlHelper: stores html helper object
*/
class IndexView
{
	protected $htmlHelper;
	public function __construct()
	{
		$this -> htmlHelper = new htmlHelper();
	}
	// incoming param calendar
	public function indexAction($t)
	{
		$view = FrontController::render('../resources/templates/index.html', $t);
		FrontController::setBody($view);
		return true;
	}
	//incoming param rooms array, 'curr' - name of current room
	// use htmlHelper for render rooms li
	public function headerAction($rooms, $curr)
	{
		$li = $this -> htmlHelper -> headerMenu($rooms);
		$file = file_get_contents(
		'resources/templates/header.html');
		$arr = array('%CURRENT%' => $curr[0]['name'], 
					'%LI%' => $li);
		$result = FrontController::templateRender($file, $arr); 
		FrontController::setBody($result);
		return true;
	}
	// incoming param array with key and values for render public menu
	public function leftMenuAction($data)
	{
		$file = file_get_contents(
		'resources/templates/leftMenu.html');
		$view = FrontController::templateRender($file, $data);
		FrontController::setBody($view);
		return true;
	}
	public function showAddForm($arr)
	{
		$file = file_get_contents(
		'resources/templates/addEventForm.html');
		$result = FrontController::templateRender($file, $arr); 
		$view = FrontController::render('../resources/templates/index.html', $result);
		FrontController::setBody($view);
		return true;
	}
}
?>