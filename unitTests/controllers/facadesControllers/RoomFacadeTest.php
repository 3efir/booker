<?php
require_once("../controllers/facadesControllers/RoomFacade.php");
require_once("../models/interfaces/DataBase.php");
require_once("../models/validators/ValidatorsModel.php");
require_once("../models/utilities/EncoderDecoder.php");
require_once("../config/config.php");
require_once("../controllers/facadesControllers/EventFacade.php");

class AdminFacadeTest extends PHPUnit_Framework_TestCase
{
	protected $roomFacade;
    protected $DB;
	public function __construct()
	{
		$this -> roomFacade = new RoomFacade();
		$this -> DB = DataBase::getInstance();
	}
    public function testAttribute()
    {
        $this -> assertClassHasAttribute('DB', 'RoomFacade');
        $this -> assertClassHasAttribute('session', 'RoomFacade');
        $this -> assertClassHasAttribute('valid', 'RoomFacade');
    }
	public function testGetRooms()
	{
		$r = $this -> roomFacade -> getRooms();
		$this -> assertTrue(is_array($r));
		$this -> assertNotEmpty($r);
	}
	public function testGetCurrentRoom()
	{
		$r = $this -> roomFacade -> getCurrentRoom();
		$this -> assertTrue(is_array($r));
		$this -> assertNotEmpty($r);
	}
	public function testGetArray()
	{
		$r = $this -> roomFacade -> getArray();
		$this -> assertTrue(is_array($r));
		$this -> assertNotEmpty($r);
		$this->assertCount(7, $r);
	}
	public function testAddEvent()
	{
		$arr = array('description' => 'test',
					'date' => '2000-01-01',
					'start' => '02:00',
					'end' => '03-00');
		$this -> assertEquals('<h3>you cant book a past time</h3>', $this ->
		roomFacade -> addEvent($arr));
		$arr = array('description' => 'test',
					'date' => '2020-01-01',
					'start' => '05:00',
					'end' => '03-00');
		$this -> assertEquals('<h3>End time cant be biggest then start time!Its
		not Hogwarts!</h3>', $this ->
		roomFacade -> addEvent($arr));
	}
	public function testGetEvents()
	{
		$r = $this -> roomFacade -> getEvents();
		$this -> assertTrue(is_array($r));
		$this -> assertNotEmpty($r);
	}
}