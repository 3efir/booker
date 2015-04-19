<?php
class EventController
{
	protected $view, $facade, $session;
	public function __construct()
	{
		$this -> view = new EventView();
		$this -> facade = new EventFacade();
		$this -> session = new SessionInterface();
	}
	public function showEventAction()
	{
		$id = FrontController::getParams();
		$event = $this -> facade -> getEvent($id);
		$recurring = $this -> facade -> checkRecurring($id);
		$sess = $this -> session -> getSession();
		if($sess['id'] !== $event[0]['idEmp'])
		{
			$this -> view -> showEditEventForm($event, $recurring);
		}
		else
		{
			$this -> view -> showEvent($event);
		}
	}
}
?>