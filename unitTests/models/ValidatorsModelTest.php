<?php
require_once("../models/validators/ValidatorsModel.php");

class ValidatorModelTest extends PHPUnit_Framework_TestCase
{
	protected $validatorsModel;
	public function __construct()
	{
		$this -> validatorsModel = new validatorsModel();
	}
	public function testCheckPass()
	{
		$this -> assertTrue($this -> validatorsModel -> checkPass('123', '123')
		);
		$this -> assertFalse($this -> validatorsModel -> checkPass('12', '123')
		);
	}
	public function testValidEmail()
	{
		$this -> assertTrue($this -> validatorsModel -> validEmail(
			'test@unit.de'));
		$this -> assertFalse($this -> validatorsModel -> validEmail(
			'test'));
	}
}