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
	public function indexAction()
	{
		$view = FrontController::render('../resources/templates/index.html');
		FrontController::setBody($view);
		return true;
	}
	//incoming param rooms array, 'curr' - name of current room
	// use htmlHelper for render rooms li
	public function headerAction($rooms, $curr)
	{
		$li = $this -> htmlHelper -> headerMenu($rooms);
		$file = file_get_contents(
		'C:\xampp\htdocs\~user8\booker\resources\templates\header.html');
		$arr = array('%CURRENT%' => $curr[0]['name'], 
					'%LI%' => $li);
		$result = FrontController::templateRender($file, $arr); 
		FrontController::setBody($result);
		return true;
	}
	public function leftMenuAction()
	{
		$view = FrontController::render('../resources/templates/leftMenu.html');
		FrontController::setBody($view);
		return true;
	}
}
?>