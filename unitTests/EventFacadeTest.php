<?php
require_once("../controllers/facadesControllers/EventFacade.php");
require_once("../models/DataBase.php");
require_once("../models/SessionInterface.php");
require_once("../models/ValidatorsModel.php");
require_once("../config/config.php");

class EventFacadeTest extends PHPUnit_Framework_TestCase
{
    public function testAttribute()
    {
        $event = new EventFacade();
        $this -> assertClassHasAttribute('DB', 'EventFacade');
        $this -> assertClassHasAttribute('session', 'EventFacade');
        $this -> assertClassHasAttribute('valid', 'EventFacade');
    }
}
