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
        $now = date("Y-m-j H:i");
        echo $now."</br>";
		echo $event[0]['date']." ".$event[0]['start'];
		if ($now < $event[0]['date']." ".$event[0]['start'])
		{
			if($sess['id'] == $event[0]['idEmp'] || $sess['whoIam'] == true)
			{
                $this -> view -> showEditEventForm($event, $recurring, $result);
                return true;
			}
			else
			{
				$name = $this -> facade -> getEmployee($sess['id']);
				$name = $name[0]['name'];            
                $this -> view -> showEvent($event, $name);
                return true;
			}
		}
		else
		{
			$name = $this -> facade -> getEmployee($event[0]['idEmp']);
			$name = $name[0]['name'];            
            $this -> view -> showEvent($event, $name);
            return true;
		}
	}
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
