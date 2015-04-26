<?php
require_once("../controllers/facadesControllers/userFacade.php");
require_once("../models/interfaces/DataBase.php");
require_once("../models/validators/ValidatorsModel.php");
require_once("../models/utilities/EncoderDecoder.php");
require_once("../config/config.php");

class UserFacadeTest extends PHPUnit_Framework_TestCase
{
	protected $userFacade;
    protected $DB;
    public $id;
    public function __construct()
    {
        $this -> userFacade = new userFacade();
        $this -> DB = DataBase::getInstance();
    }
    public function testAttribute()
    {
        $this -> assertClassHasAttribute('DBmodel', 'AdminFacade');
        $this -> assertClassHasAttribute('encoder', 'AdminFacade');
        $this -> assertClassHasAttribute('ValidModel', 'AdminFacade');
    }
	public function testCheckLogin()
	{
		$this -> assertEquals('fields email and password cant be empty',
		$this -> userFacade -> checkLogin('',''));
	}
}