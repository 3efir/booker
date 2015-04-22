<?php
class EventFacade
{
	protected $session, $valid, $DB, $roomFacade;
	// construct object
	public function __construct()
	{
		$this -> DB = DataBase::getInstance();
		$this -> session = new SessionInterface();
		$this -> valid = new ValidatorsModel();
	}
	public function getEvent($id)
	{
		$result = $this -> DB -> SELECT(" idApp, date, 
		date_format(start, '%H:%i') as start, date_format(end, '%H:%i') as end,
		idEmp, description ") -> from(" appointments ") -> where(" idApp =
		$id ") -> selected();
		return $result;
	}
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
	public function getEmployees()
	{
		$result = $this -> DB -> SELECT(" id, name ") -> from(" employees") ->
		selected();
		return $result;
	}
	public function getEmployee($id)
	{
		$result = $this -> DB -> SELECT(" id, name ") -> from(" employees") ->
		where(" id = $id") -> selected();
		return $result;
	}
}
?>

