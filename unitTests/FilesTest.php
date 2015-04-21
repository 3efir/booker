<?php
class FilesTest extends PHPUnit_Framework_TestCase
{
    public function testModelsFiles()
    {
        $this->assertFileExists('../models/DataBase.php');
        $this->assertFileExists('../models/SessionInterface.php');
        $this->assertFileExists('../models/ValidatorsModel.php');
    }
}
?>
