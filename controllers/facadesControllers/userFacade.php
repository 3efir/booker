<?php
class UserFacade
{
	private $DBmodel, $ValidModel, $encoder;
// create objects DB, Validator and Encoder classes
	public function __construct()
	{
		$this -> DBmodel = DataBase::getInstance();
		$this -> ValidModel = new ValidatorsModel();
		$this -> encoder = new EncoderDecoder();
		return true;
	}
	//method for check login
	public function checkLogin($email, $pass)
	{
		$email = strip_tags(trim($email));
		$pass = strip_tags(trim($pass));
		if($email !== '' && $pass !== '')
		{
			$result = $this -> DBmodel -> SELECT("  pass ") -> 
			from(" employees ") -> where(" email = '".$email."'") ->
			selected();
			if(empty($result))
			{
				return "<h2>Email or password not correct</h2>";
			}
			if($this -> encoder -> validPass($result[0]['pass'], $pass) === true)
			{
				$result = $this -> DBmodel -> SELECT(" id, name, isAdmin ") ->
				from(" employees ") -> where(" email = '".$email."'") ->
				selected();
				return $result;
			}
			else
			{
				return "<h2>Email or password not correct</h2>";
			}
		}
		else
		{
			return "fields email and password cant be empty";
		}
	}
}
?>