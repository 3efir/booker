<?php
class EventView
{
	protected $htmlHelper, $session;
	public function __construct()
	{
		$this -> htmlHelper = new htmlHelper();
		$this -> session = new SessionInterface();
	}
	public function showEvent($event)
	{
		$arr = array('%START%' => $event[0]['start'],
					'%END%' => $event[0]['end'],
					'%NOTES%' => $event[0]['description'],
					'%WHO%' => $event[0]['name']);
		$file = file_get_contents("resources/templates/event.html");
		$view = FrontController::templateRender($file, $arr); 
		FrontController::setBody($view);
		return true;
	}
}
?>