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
    public function testContructSingleton()
    {
        $obj1 = $this->instance->getInstance();
        $obj2 = $this->instance->getInstance();

        $this->assertSame($obj1, $obj2);
    }
    function testINSERT() {   
       // try {
        //    // ... Code that is expected to raise an exception
       //     $this -> instance -> INSERT(''); 
      //  }
     //   catch (InvalidArgumentException $expected) {
     //       return;
     //   }

      //  $this->fail('An expected exception has not been raised.');
    $this -> setExpectedException('Exception', $this -> instance -> INSERT(''));
    }
}
