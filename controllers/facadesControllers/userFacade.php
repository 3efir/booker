<?php
class UserFacade
{
	private $DBmodel;
	private $ValidModel;
	private $encoder;
// create objects DB, Validator and Encoder classes
	public function __construct()
	{
		$this -> DBmodel = DataBase::getInstance();
		$this -> ValidModel = new ValidatorsModel();
		$this -> encoder = new EncoderDecoder();
		return true;
	}
	public function checkLogin($email, $pass)
	{
		$email = strip_tags(trim($email));
		$pass = strip_tags(trim($pass));
		if($email !== '' && $pass !== '')
		{
			try{
				$result = $this -> DBmodel -> SELECT("  pass ") -> 
				from(" empoyees ") -> where(" email = '".$email."'") ->
				selected();
			}
			catch (Exception $e)
			{
				return $e -> getMessage().". Email or password not correct.";
			}
			if($this -> encoder -> validPass($result[0]['pass'], $pass) === true)
			{
				$result = $this -> DBmodel -> SELECT(" id, name, isAdmin ") ->
				from(" empoyees ") -> where(" email = '".$email."'") -> selected();
				return $result;
			}
		}
		else
		{
			return "fields email and password cant be empty";
		}
	}
}
?>