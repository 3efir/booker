<?php
/*
* controller for work with events
* @param view: stores view object
* @param facade: stores event facade object 
* @param session: stores object for work with session class
*/
class EventController
{
	protected $view, $facade, $session;
	// construct objects
	public function __construct()
	{
		$this -> view = new EventView();
		$this -> facade = new EventFacade();
		$this -> session = new SessionInterface();
	}
	// method for show event by id 
	public function showEventAction()
	{
		$id = FrontController::getParams();
		// select event info
		$event = $this -> facade -> getEvent($id);
		// check recurring for this event
		$recurring = $this -> facade -> checkRecurring($id);
		$sess = $this -> session -> getSession();
		$file = file_get_contents("resources/templates/small/option.html");
		// if admin prepare <option> with all employee
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
			$result = str_replace('value="'.$event[0]['idEmp'].'"', 
							'value="'.$event[0]['idEmp'].'" selected', $result);
		}
		// else option only with one employee
		else
		{
			$name = $this -> facade -> getEmployee($event[0]['idEmp']);
			if(empty($name))
			{
				$name[0]['id'] = '';
				$name[0]['name'] = 'deleted employee';
			}
			$arr = array('%VALUE%' => $name[0]['id'],
						'%NAME%' => $name[0]['name']);
			$result = FrontController::templateRender($file, $arr);
		}
        $now = date("Y-m-j H:i");
		//the past date can not be changed
		if ($now < $event[0]['date']." ".$event[0]['start'])
		{
			// if logged admin or employee who book it show form for edit
			if($sess['id'] == $event[0]['idEmp'] || $sess['whoIam'] == true)
			{
                $this -> view -> showEditEventForm($event, $recurring, $result);
                return true;
			}
			// show just show event
			else
			{
				$name = $this -> facade -> getEmployee($event[0]['idEmp']);
				if(empty($name))
				{
					$name = 'deleted employee';
				}
				else
				{
					$name = $name[0]['name'];
				}					
                $this -> view -> showEvent($event, $name);
                return true;
			}
		}
		// if past event just show event
		else
		{
			$name = $this -> facade -> getEmployee($event[0]['idEmp']);
			if(empty($name))
			{
				$name = 'deleted employee';
			}
			else
			{
				$name = $name[0]['name'];
			}	 			
            $this -> view -> showEvent($event, $name);
            return true;
		}
	}
	// handler for edit event form
	public function HandleFormAction()
	{
		$id = FrontController::getParams();
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_POST['update']))
			{
				if($_POST['start'] < $_POST['end'])
				{
					if(isset($_POST['recurring']))
					{
						$result = $this -> facade -> updateEventRecurring($id,
						$_POST);
						goto end;
					}
					else
					{
						$result = $this -> facade -> updateEvent($id, $_POST);
						goto end;
					}
				}
			}
			else
			{
				if(isset($_POST['recurring']))
				{
					$this -> facade -> deleteEventRecurring($id);
                    $this -> view -> showMessage("Events deleted succes!");
                    return true;
				}
				else
				{
                    $this -> facade -> deleteEvent($id);
                    $this -> view -> showMessage("Event deleted succes!");   
                    return true;                 
				}
			}
		}
		end:
		if($result == false)
		{
			$buttonYes = "<a class='btn btn-default' 
			href='/~user8/booker/event/showEvent/$id'> YES </a>";
			$message = " Sorry but this time".$_POST['start'].": 
			".$_POST['end']." is busy. Try again ?$buttonYes";
            $this -> view -> showMessage($message);
            return true;
		}
		else
		{
            $this -> view -> showMessage($result);
            return true;
		}
	}
}
?>