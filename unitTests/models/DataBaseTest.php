<?php
require_once("../models/DataBase.php");
require_once("../config/config.php");
class DataBaseTest extends \PHPUnit_Framework_TestCase
{
    protected $className;
    protected $instance;

    public function __construct()
    {
        $this->className = DataBase;
        $this->instance = DataBase::getInstance();
    }
    public function testHasIntance()
    {
        $this->assertClassHasStaticAttribute('instance', $this->className);
    }
    public function testHasAttribute()
    {
        $this->assertClassHasAttribute('dbh', $this->className);
        $this->assertClassHasAttribute('sql', $this->className);
        $this->assertClassHasStaticAttribute('instance', $this->className); 
    }
    public function testContructSingleton()
    {
        $obj1 = $this->instance->getInstance();
        $obj2 = $this->instance->getInstance();

        $this->assertSame($obj1, $obj2);
    }
    public function testINSERT() {   
        $this -> setExpectedException('Exception', $this -> instance -> INSERT(''));
    }
    public function testInsertUpdate()
    {
        $this -> assertNotEmpty(array('first', 'second')); 
    }
}
