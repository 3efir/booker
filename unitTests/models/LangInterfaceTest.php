<?php
require_once("../models/interfaces/LangInterface.php");

class LangInterfaceTest extends PHPUnit_Framework_TestCase
{
	protected $langInterface;
	public function __construct()
	{
		$this -> langInterface = new LangInterface('eng');
	}
    public function testAttribute()
    {
        $this -> assertClassHasAttribute('file', 'LangInterface');
    }
	public function testLoadLang()
	{
		$r = $this -> langInterface -> loadLang();
		$this -> assertTrue(is_array($r));
		$this -> assertNotEmpty($r);
	}
}