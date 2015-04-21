<?php
class EventView
{
	protected $htmlHelper, $session;
	public function __construct()
	{
		$this -> htmlHelper = new htmlHelper();
		$this -> session = new SessionInterface();
	}
	public function showEvent($event, $name)
	{
		$arr = array('%START%' => $event[0]['start'],
					'%END%' => $event[0]['end'],
					'%NOTES%' => $event[0]['description'],
					'%WHO%' => $name);
		$file = file_get_contents("resources/templates/event.html");
		$view = FrontController::templateRender($file, $arr); 
		FrontController::setBody($view);
		return true;
	}
	public function showEditEventForm($event, $recurring, $name)
	{
		if($recurring === true)
		{
			$rec =  "<p class='detailsNames'><input type='checkbox' 
			value='recurring'>Apply to all occurences?</p>";
		}
		else
		{
			$rec = '';
		}
		$arr = array('%START%' => $event[0]['start'],
			'%END%' => $event[0]['end'],
			'%NOTES%' => $event[0]['description'],
			'%WHO%' => $name,
			'%REC%' => $rec,
			'%ID%' => $event[0]['idApp']);
		$file = file_get_contents("resources/templates/editEventForm.html");
		$view = FrontController::templateRender($file, $arr); 
		FrontController::setBody($view);
		return true;
	}
}
?>
