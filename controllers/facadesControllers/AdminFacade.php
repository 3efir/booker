<?php
class AdminFacade
{
    protected $valid;
    protected $DB;
    protected $name = '';
    protected $email = '';
    public function __construct()
    {
        $this -> valid = new ValidatorsModel();
        $this -> DB = new DataBase();
        return true;
    }
    public function checkRegister($name, $email, $pass, $confPass)
    {
       $nres = $this -> valid -> NotNull($name);  
    }
}
?>
