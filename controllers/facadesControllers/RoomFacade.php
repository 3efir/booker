<?php
/*
* @param DB: stores Data Base object
* @param session: stores session object
*/
class RoomFacade
{
	protected $DB;
	protected $session, $valid, $eventFacade;
	protected $errors = '', $desc = '', $newDate = '', $start = '', $end = '';
	// construct object
	public function __construct()
	{
		$this -> DB = DataBase::getInstance();
		$this -> session = new SessionInterface();
		$this -> valid = new ValidatorsModel();
		$this -> eventFacade = new EventFacade();
	}
	// select and return all id rooms and rooms name from table 'room'
	public function getRooms()
	{
		$result = $this -> DB -> SELECT(" idRoom, name ") -> from(" room ") ->
		selected();
		return $result;
	}
	// use session interface for get id current room
	public function getCurrentRoom()
	{
		$id = $this -> session -> getRoom();
		$name = $this -> DB -> SELECT(" name ") -> from(" room ") -> where(
		" idRoom = $id ") -> selected();
		return $name;
	}
	// return array for render book it form
	public function getArray()
	{
		$room = $this -> getCurrentRoom();
		$sess = $this -> session -> getSession();
		$file = file_get_contents('resources/templates/small/option.html');
		if($sess['whoIam'] == true)
		{
			$optionName = '';
			$emp = $this -> eventFacade -> getEmployees();
			foreach($emp as $v)
			{
				$opt = array('%VALUE%' => $v['id'],
							'%NAME%' => $v['name']);
				$optionName .= FrontController::templateRender($file, $opt);
			}
		}
		else
		{
			$opt = array('%VALUE%' => $sess['id'],
						'%NAME%' => $sess['user']);
			$optionName = FrontController::templateRender($file, $opt);
		}
		$arr = array('%ROOM%' => $room[0]['name'],
					'%OPTIONS%' => $optionName,
					'%ERRORS%' => $this->errors,
					'%DESC%' => $this -> desc,
					'%DATE%' => $this -> newDate,
					'%START%' => $this -> start,
					'%END%' => $this -> end);
		return $arr;
	}
	// incoming params values from book it form
	public function addEvent($arr)
	{
		$this -> desc = $this -> valid -> FilterFormValues($arr['description']);
		$this -> newDate = $this -> valid -> FilterFormValues($arr['date']);
		$this -> start = $this -> valid -> FilterFormValues($arr['start']);
		$this -> end = $this -> valid -> FilterFormValues($arr['end']);
		$now = date("Y-m-j H:i");
		// can not be booked on the past time
		if ($now < $arr['date']." ".$arr['start'])
		{
			//End time cant be biggest then start time
			if($arr['start'] < $arr['end'])
			{
				$day = date("N",strtotime($arr['date']));
				// day off cant be booked
				if($day < 6)
				{
					if($arr['isRecurring'] == 'no')
					{
						// call method for not recurring event
						$this -> addNotRecurring($arr);
						return true;
					}
					else
					{
						//call method for recurring event
						$this -> addRecurring($arr);
						return true;
					}
				}
				else
				{
					$this -> errors = "<h3>this day - a day off, choose better
					another day</h3>";
					return true;
				}
			}
			else
			{
				$this -> errors = "<h3>End time cant be biggest then start time!
				Its not Hogwarts!</h3>";
				return true;
			}
		}
		else
		{
			$this -> errors = "<h3>you cant book a past time</h3>";
			return true;
		}

	}
	// method for not recurring event 
	// incoming array values from book it form
	public function addNotRecurring($arr)
	{
		$date = $this -> valid -> FilterFormValues($arr['date']);
		$start = $this -> valid -> FilterFormValues($arr['start']);
		$end = $this -> valid -> FilterFormValues($arr['end']);
		$idRoom = $this -> session -> getRoom();
		$user = $this -> session -> getSession();
		$idUser = $user['id'];
		// fields cant be empty
		if($date !== '' && $start !== '' && $end !== '' && $this -> desc !== '')
		{
			// check freely entered time
			$r = $this -> checkTime($date, $start, $end, $idRoom);
			// if free book it !
			if(empty($r))
			{
				$arr = array($date, $start, $end, $idUser, $idRoom, $this->desc);
				$this -> DB -> INSERT(" appointments ") -> keys(" date, start, 
				end, idEmp, idRoom, description ") -> values(" ?, ?, ?, ?, ?, ?
				 ") -> insertUpdate($arr);
				$this -> errors = "<h3>The event $start - $end has been
					added.</br>The text for this event is ".$this->desc."</h3>";
				$this -> newDate = '';
				$this -> start = '';
				$this -> end = '';
				$this -> desc = '';
				return true;
			}
			else
			{
				$this -> errors = "<h3>select another time, this time is
					busy - $date $start - $end</h3>";
				return true;
			}
		}
	}
	// method for check freely entered time
	public function checkTime($date, $start, $end, $idRoom)
	{
		$r = $this -> DB -> SELECT(" idApp ") -> from(" appointments ") ->
			where(" ((start <= '".$start."' AND '".$start."' < end) OR 
					(start < '".$end."' AND '".$end."' <= end) OR 
				('".$start."' <= start AND end <= '".$end."')) ") -> whereAnd(" 
					date = '".$date."'") -> whereAnd(" idRoom = $idRoom ") ->
				selected();
		return $r;
	}
	// method for book it recurring event
	public function addRecurring($arr)
	{
		$date = $this -> valid -> FilterFormValues($arr['date']);
		$start = $this -> valid -> FilterFormValues($arr['start']);
		$end = $this -> valid -> FilterFormValues($arr['end']);
		$recurring = $this -> valid -> FilterFormValues($arr['recurring']);
		$duration = $this -> valid -> FilterFormValues($arr['duration']);
		$idRoom = $this -> session -> getRoom();
		$user = $this -> session -> getSession();
		$idUser = $user['id'];
		$dateForCheck = $date;
		// if recurring weekly
		if("weekly" == $recurring)
		{
			// check freely entered time
			for($i=0; $i <= $duration; $i++)
			{
				$r = $this -> checkTime($dateForCheck, $start, $end, $idRoom);
				if(!empty($r))
				{
					$this -> errors = "you can not book these dates because one
					of them is already occupied";
					return true;
				}
				$dateForCheck = strtotime($dateForCheck);
				// add 7 days to entered time
				$dateForCheck = $dateForCheck + 60 * 60 * 24 * 7;
				$dateForCheck = date("Y-m-j", $dateForCheck);
			}
			// insert first event and get insert id 
			$this -> insertEvent($date, $start, $end, $idUser, $idRoom);
			$parent = $this -> DB -> getLastInsertId();
			// insert others events with parent id
			for($i=1; $i <= $duration; $i++)
			{
				$date = strtotime($date);
				$date = $date + 60 * 60 * 24 * 7;
				$date = date("Y-m-j", $date);
				$this -> insertEvent($date, $start, $end, $idUser, $idRoom,
				$parent);
			}
			$this -> errors = "successfully booked a room, you can see this by
			looking at the calendar";
			$this -> newDate = '';
			$this -> start = '';
			$this -> end = '';
			$this -> desc = '';
			return true;
		}
		// if bi-weekly
		elseif("bi-weekly" == $recurring)
		{
			// duration cant be more then 2 times
			if($duration <= 2)
			{
				// check freely entered time
				for($i=0; $i <= $duration; $i++)
				{
					$r = $this -> checkTime($dateForCheck, $start, $end,
					$idRoom);
					if(!empty($r))
					{
						$this -> errors = "you can not book these dates because
						one of them is already occupied";
						return true;
					}
					$dateForCheck = strtotime($dateForCheck);
					// add 14 days to entered time
					$dateForCheck = $dateForCheck + 60 * 60 * 24 * 14;
					$dateForCheck = date("Y-m-j", $dateForCheck);
				}
				//insert first event and get last insert id
				$this -> insertEvent($date, $start, $end, $idUser, $idRoom);
				$parent = $this -> DB -> getLastInsertId();
				// insert other events with parent id
				for($i=1; $i <= $duration; $i++)
				{
					$date = strtotime($date);
					$date = $date + 60 * 60 * 24 * 14;
					$date = date("Y-m-j", $date);
					$this -> insertEvent($date, $start, $end, $idUser, $idRoom,
					$parent);
				}
				$this -> errors = "successfully booked a room, you can see this
				by looking at the calendar";
				$this -> newDate = '';
				$this -> start = '';
				$this -> end = '';
				$this -> desc = '';
				return true;
			}
			else
			{
				$this -> errors = "sorry, but duration can be maximum 2 times";
				return true;
			}
		}
		// if monthly recurring
		elseif("monthly" == $recurring)
		{
			// duration cant be more then 2 times
			if($duration <= 2)
			{
				// check freely entered time
				for($i=0; $i < $duration; $i++)
				{
					$r = $this -> checkTime($dateForCheck, $start, $end,
					$idRoom);
					if(!empty($r))
					{
						$this -> errors = "you can not book these dates because
						one of them is already occupied";
						return true;
					}
					$day = date("N", strtotime($dateForCheck));	
					if($day > 5)
					{
						$this -> errors = "you can not book these dates because
						one of them is day off";
						return true;
					}
					$dateForCheck = strtotime($dateForCheck);
					// add 1 month to entered time
					$dateForCheck = strtotime("next month", $dateForCheck);
					$dateForCheck = date("Y-m-j", $dateForCheck);
				}
				//insert first event and get last insert id
				$this -> insertEvent($date, $start, $end, $idUser, $idRoom);
				$parent = $this -> DB -> getLastInsertId();
				// insert other events with parent id
				for($i=1; $i < $duration; $i++)
				{
					$date = strtotime($date);
					$date = strtotime("next month", $date);
					$date = date("Y-m-j", $date);
					$this -> insertEvent($date, $start, $end, $idUser, $idRoom,
					$parent);
				}
				$this -> errors = "successfully booked a room, you can see this
				by looking at the calendar";
				$this -> newDate = '';
				$this -> start = '';
				$this -> end = '';
				$this -> desc = '';
				return true;
			}
			else
			{
				$this -> errors = "sorry, but duration can be maximum 2 times";
				return true;
			}
		}
	}
	// method for insert new event into DB
	// @param parent: null for not recurring events
	public function insertEvent($date, $start, $end, $idUser, $idRoom, 
	$parent=NULL)
	{
			$arr = array($date, $start, $end, $idUser, $idRoom, $this->desc,
			$parent);
			$this -> DB -> INSERT(" appointments ") -> keys(" date, start, 
			end, idEmp, idRoom, description, idParent ") -> values(" ?, ?, ?,
			?, ?, ?, ? ") -> insertUpdate($arr);
			return true;
	}
	// select and return all events for print in calendar
	public function getEvents()
    {
		$ses = $this -> session -> getSession();
		$month = $ses['month'];
		$year = date("Y", mktime(0,0,0,1,1,$ses['year']));
		$idRoom = $this -> session -> getRoom();
		$result = $this -> DB -> SELECT(" idApp, day(date) as day,
		date_format(start, '%H:%i') as start, date_format(end, '%H:%i') as end,
		idEmp ") -> from(" appointments ") -> where(" month(date) =
		'".$month."' ") -> whereAnd(" year(date) = '".$year."' ") -> whereAnd("
		 idRoom = $idRoom ") -> selected();
		return $result;
	}
}
?>