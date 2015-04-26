<?php
require_once("../controllers/facadesControllers/AdminFacade.php");
require_once("../models/interfaces/DataBase.php");
require_once("../models/validators/ValidatorsModel.php");
require_once("../models/utilities/EncoderDecoder.php");
require_once("../config/config.php");
require_once("../controllers/facadesControllers/RoomFacade.php");

class AdminFacadeTest extends PHPUnit_Framework_TestCase
{
    protected $adminFacade;
    protected $DB;
    public $id;
	public function __construct()
	{
		$this -> adminFacade = new AdminFacade();
		$this -> DB = DataBase::getInstance();
	}
    public function testAttribute()
    {
        $this -> assertClassHasAttribute('DB', 'AdminFacade');
        $this -> assertClassHasAttribute('encode', 'AdminFacade');
        $this -> assertClassHasAttribute('valid', 'AdminFacade');
    }
    public function testCheckRegister()
    {
       $this -> assertTrue($this -> adminFacade -> checkRegister('name',
	   'email@mail.ru', 'pass', 'pass'));
       $this -> assertFalse($this -> adminFacade -> checkRegister('name',
	   'email', 'pass', 'pass'));
       $this -> assertFalse($this -> adminFacade -> checkRegister('name',
	   'email@mail.ru', 'pass', '1pass1')); 
    }
    public function testGetArray()
    {
        $this -> assertTrue(is_array($this -> adminFacade -> getArray()));
    }
    public function testAddUser()
    {
        $arr = array('test', 'dsaas', 'unit@test.de');
        $this -> assertTrue(is_array($arr));
        $this -> assertNotEmpty($arr);
        $this -> assertCount(3, $arr);
        $this -> assertTrue($this -> DB -> INSERT(" employees ") -> keys(" 
		name, pass, email ") -> values(" ?, ?, ? ") -> insertUpdate($arr));
        $this -> id = $this -> DB -> getLastInsertId();
        $this -> assertTrue(is_int($this -> id));
    }
    public function testGetEmployeesList()
    {
        $result = $this -> adminFacade -> getEmployeesList();
        $this -> assertNotEmpty($result);
        $this -> assertTrue(is_array($result));
    }
    public function testSelectEmployee()
    {
        //$this -> assertTrue(is_int($this -> id));        
        //echo "$this -> id";
        //$id = (int) $this -> id;
        $result = $this -> adminFacade -> selectEmployee($id);
        print $result;
        $this -> assertNotEmpty($result);
        $this -> assertTrue(is_array($result)); 
    }
    public function testUpdateEmployee()
    {
/* 		$this -> assertEquals('Information about employee was changed',$this 
		-> adminFacade -> updateEmployee($this -> id, 'rename test', 
		'test@unit.de'));
 */    }
}
