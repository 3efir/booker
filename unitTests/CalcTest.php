<?php
class CalcTest extends PHPUnit_Framework_TestCase
{
	public function testAttribute()
	{
		$calc = new Calc();
		$this->assertClassHasAttribute('a', 'Calc');
		$this->assertClassHasAttribute('b', 'Calc');
	}
	public function testSetA()
	{
		$calc = new Calc();
		$calc->setA($a);
		$this->assertAttributeNotEmpty();
	}
	public function testSetB()
	{
		$calc = new Calc();
		$calc->setB($b);
		$this->assertAttributeNotEmpty();
	}
}
