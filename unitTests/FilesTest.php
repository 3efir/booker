<?php
class FilesTest extends PHPUnit_Framework_TestCase
{
    public function testModelsFiles()
    {
        $this->assertFileExists('../models/interfaces/DataBase.php');
        $this->assertFileExists('../models/interfaces/SessionInterface.php');
        $this->assertFileExists('../models/validators/ValidatorsModel.php');
    }
}
?>
