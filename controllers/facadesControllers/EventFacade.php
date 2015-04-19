<?php
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
	public function getEvent($id)
	{
		$result = $this -> DB -> SELECT(" date_format(start, '%H:%i') as start,
		date_format(end, '%H:%i') as end, idEmp, description, e.name ") ->
		from(" appointments ") -> inner(" employees e ") -> on(" 
		appointments.idEmp = e.id ") -> where(" idApp = $id ") -> selected();
		return $result;
	}
	public function checkRecurring($id)
	{
		$result = $this -> DB -> SELECT(" idApp ") -> from(" appointments ") ->
		where(" idParent = $id ") -> selected();
		if(empty($result))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}
?>