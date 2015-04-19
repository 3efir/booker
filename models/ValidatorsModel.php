<?php
/*
* class used for validate values from forms
* @param er: stores errors in check forms
*/
class ValidatorsModel
{
	// 
	public function FilterFormValues($data)
	{
		return htmlspecialchars(strip_tags(trim($data)));
	}
// verifies that the password matches
	public function checkPass($pass, $conf_pass)
	{
		if($pass !== $conf_pass)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
// checks the entered email
	public function validEmail($email)
	{
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}
?>