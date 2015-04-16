<?php
/*
* @param DB: stores Data Base object
* @param session: stores session object
*/
class RoomFacade
{
	protected $DB;
	protected $session;
	// construct object
	public function __construct()
	{
		$this -> DB = DataBase::getInstance();
		$this -> session = new SessionInterface();
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
}
?>