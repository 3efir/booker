<?php
/*
* @param DB: stores Data Base object
* @param session: stores session object
* @param valid: stores valid object
*/
class EventFacade
{
	protected $session, $valid, $DB;
	// construct object
	public function __construct()
	{
		$this -> DB = DataBase::getInstance();
		$this -> session = new SessionInterface();
		$this -> valid = new ValidatorsModel();
	}
	// method for select event by incoming id
	public function getEvent($id)
	{
		$result = $this -> DB -> SELECT(" idApp, date, 
		date_format(start, '%H:%i') as start, date_format(end, '%H:%i') as end,
		idEmp, description ") -> from(" appointments ") -> where(" idApp =
		$id ") -> selected();
		return $result;
	}
	// method for check recurring empty time for add new event or not
	public function checkRecurring($id)
	{
		$result = $this -> DB -> SELECT(" idApp ") -> from(" appointments ") ->
		where(" idParent = $id ") -> selected();
		if(empty($result))
		{
			$result = $this -> DB -> SELECT(" idParent ") -> from(" 
			appointments ") -> where(" idApp = $id ") -> selected();
			if(NULL == $result[0]['idParent'])
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return true;
		}
	}
	//method for select all employees
	public function getEmployees()
	{
		$result = $this -> DB -> SELECT(" id, name ") -> from(" employees") ->
		selected();
		return $result;
	}
	// method for select employee by id
	public function getEmployee($id)
	{
		$result = $this -> DB -> SELECT(" id, name ") -> from(" employees") ->
		where(" id = $id") -> selected();
		return $result;
	}
	// method for delete recurring events by incoming id
	public function deleteEventRecurring($id)
	{
		$r = $this -> DB -> SELECT(" idParent ") -> from(" appointments ") -> where(" idApp =
		 $id ") -> selected();
		// if idParent == null - its parent
		if($r[0]['idParent'] == NULL)
		{
			$this -> DB -> DELETE(" appointments ") -> where(" idApp = $id OR 
			idParent = $id ") -> deleted();
			return true;
		}
		else
		{
			$this -> DB -> DELETE(" appointments ") -> where(" idApp = $id OR 
			idApp = ".$r[0]['idParent']." OR idParent = ".$r[0]['idParent']) ->
			deleted();
			return true;
		}
	}
	// method for delete event not recurring
	public function deleteEvent($id)
	{
		$res = $this -> DB -> SELECT(" idParent ") -> from(" appointments ") ->
		where(" idApp = $id ") -> selected();
		// if null - its parent or not recurring event
		if($res[0]['idParent'] == NULL)
		{
			$r = $this -> DB -> SELECT(" idApp ") -> from(" appointments ") ->
			where(" idParent = $id") -> selected();
			// if empty - not recurring method
			if(empty($r))
			{
				goto end;
			}
			// else make first event parent
			else
			{
				$newParent = array(NULL);
				$arr = array($r[0]['idApp']);
				$this -> DB -> UPDATE(" appointments ") -> SET(" idParent ") ->
				where(" idApp = ".$r[0]['idApp']) -> insertUpdate($newParent);
				$this -> DB -> UPDATE(" appointments ") -> SET(" idParent ") ->
				where(" idParent = $id ") -> insertUpdate($arr);
				goto end;
			}
		}
		else
		{
			goto end;
		}
		end:
		$this -> DB -> DELETE(" appointments ") -> where(" idApp = $id ") -> 
		deleted();
		return true;
	}
	//method for update event incoming params id and $_POST
	public function updateEvent($id, $arr)
	{
		$start = $this -> valid -> FilterFormValues($arr['start']);
		$end = $this -> valid -> FilterFormValues($arr['end']);
		$desc = $this -> valid -> FilterFormValues($arr['description']);
		// select date and id room for this event
		$date = $this -> DB -> SELECT(" date, idRoom ") -> from(" appointments ") -> 
		where(" idApp = $id ") -> selected();
		// check freely time for update
		$r = $this -> checkTime($date[0]['date'], $start, $end, $date[0]['idRoom'],
		$id);
		// if empty - update
		if(empty($r))
		{
			$ins = array($start);
			$this -> DB -> UPDATE(" appointments ") -> SET(" start ") ->
			where(" idApp = $id ") -> insertUpdate($ins);
			$ins = array($end);
			$this -> DB -> UPDATE(" appointments ") -> SET(" end ") ->
			where(" idApp = $id ") -> insertUpdate($ins);
			$ins = array($desc);
			$this -> DB -> UPDATE(" appointments ") -> SET(" description ") ->
			where(" idApp = $id ") -> insertUpdate($ins);
			return "Now new time for this event is $start : $end with notes - 
			$desc ";
		}
		else
		{
			return false;
		}
	}
		// method for check freely entered time
	public function checkTime($date, $start, $end, $idRoom, $id)
	{
		$r = $this -> DB -> SELECT(" idApp ") -> from(" appointments ") ->
			where(" ((start <= '".$start."' AND '".$start."' < end) OR 
					(start < '".$end."' AND '".$end."' <= end) OR 
					('".$start."' <= start AND end <= '".$end."')) ") -> whereAnd(" 
					date = '".$date."'") -> whereAnd(" idRoom = $idRoom ") ->
				whereAnd(" idApp <> $id") -> selected();
		return $r;
	}
	//method for update event recurring
	public function updateEventRecurring($id, $arr)
	{
		$start = $this -> valid -> FilterFormValues($arr['start']);
		$end = $this -> valid -> FilterFormValues($arr['end']);
		$desc = $this -> valid -> FilterFormValues($arr['description']);
		$day = $this -> DB -> SELECT(" idApp, date, idRoom, idParent ") ->
		from(" appointments ") -> where(" idApp = $id ") -> selected();
		// if null - parent
		if($day[0]['idParent'] == NULL)
		{
			$days = $this -> getDatesForUpdate($id);
		}
		else
		{
			$days = $this -> getDatesForUpdate($day[0]['idParent']);
		}
		// check time for update
		foreach($days as $v)
		{
			$r = $this -> checkTime($v['date'], $start, $end, $v['idRoom'],
			$v['idApp']);
			if(!empty($r))
			{
				return false;
			}
		}
		// update and prepare message for echo
		$message = 'Now new time for this events is';
		foreach($days as $v)
		{
			$ins = array($start);
			$this -> DB -> UPDATE(" appointments ") -> SET(" start ") ->
			where(" idApp = ".$v['idApp']) -> insertUpdate($ins);
			$ins = array($end);
			$this -> DB -> UPDATE(" appointments ") -> SET(" end ") ->
			where(" idApp = ".$v['idApp']) -> insertUpdate($ins);
			$ins = array($desc);
			$this -> DB -> UPDATE(" appointments ") -> SET(" description ") ->
			where(" idApp = ".$v['idApp']) -> insertUpdate($ins);
			$message .= $v['date']." - $start : $end</br>";
		}
		$message .= "with notes - $desc ";
		return $message;
	}
	// method for select dates by id
	public function getDatesForUpdate($id)
	{
		$days = $this -> DB -> SELECT(" idApp, date, idRoom, idParent ") ->
		from(" appointments ") -> where(" idParent = $id OR idApp = $id ") ->
		selected();
		return $days;
	}
}
?>