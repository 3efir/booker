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
		$file = file_get_contents("resources/templates/small/option.html");
		if($sess['whoIam'] == true)
		{
			$name = $this -> facade -> getEmployees();
			$result = '';
			foreach($name as $value)
			{
				$arr = array('%VALUE%' => $value['id'],
						'%NAME%' => $value['name']);
				$result .= FrontController::templateRender($file, $arr);
			}
		}
		else
		{
			$name = $this -> facade -> getEmployee($event[0]['idEmp']);
			$arr = array('%VALUE%' => $name[0]['id'],
						'%NAME%' => $name[0]['name']);
			$result = FrontController::templateRender($file, $arr);
		}
		if($sess['id'] == $event[0]['idEmp'] || $sess['whoIam'] == true)
		{
			$this -> view -> showEditEventForm($event, $recurring, $result);
		}
		else
        {
			$name = $this -> facade -> getEmployee($sess['id']);
            $name = $name[0]['name'];            
			$this -> view -> showEvent($event, $name);
		}
	}
}
?>
