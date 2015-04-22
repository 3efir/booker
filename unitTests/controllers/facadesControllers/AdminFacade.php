<?php
require_once("../controllers/facadesControllers/AdminFacade.php");
require_once("../models/DataBase.php");
require_once("../models/ValidatorsModel.php");
require_once("../models/EncoderDecoder.php");
require_once("../config/config.php");
require_once("../controllers/facadesControllers/RoomFacade.php");

class AdminFacadeTest extends PHPUnit_Framework_TestCase
{
    protected $adminFacade;
    protected $DB;
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
       $this -> assertTrue($this -> adminFacade -> checkRegister('name', 'email@mail.ru', 'pass', 'pass'));
       $this -> assertFalse($this -> adminFacade -> checkRegister('name', 'email', 'pass', 'pass'));
       $this -> assertFalse($this -> adminFacade -> checkRegister('name', 'email@mail.ru', 'pass', '1pass1')); 
    }
    public function testGetArray()
    {
        $this -> assertTrue(is_array($this -> adminFacade -> getArray()));
    }
    public function testAddUser()
    {
        $arr = array('test', '123', 'unit@test.de');
        $this -> assertTrue(is_array($arr));
        $this -> assertNotEmpty($arr);
        $this -> assertContains(3, array(1, 2, 3));
        $this -> assertTrue($this -> adminFacade -> DB -> INSERT(" employees ") -> keys(" name, pass, email ") -> values(" ?, ?, ? ") -> insertUpdate($arr));
    }
}
