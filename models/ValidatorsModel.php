<?php
/*
* class used for validate values from forms
* @param er: stores errors in check forms
*/
class ValidatorsModel
{
	protected $er = '';
// validate register form, use method NotNull for check params on null given
// use validEmail for check entered email on correct
// return true or error
	public function checkRegister($name, $email, $pass, $conf_pass)
	{
		$notNull = $this -> NotNull($name, $pass, $conf_pass);
		if ($notNull == '')
		{
			$checkPass = $this -> checkPass($pass, $conf_pass);
			if($checkPass == '')
			{
				$validEmail = $this -> validEmail($email);
				if($validEmail == '')
				{
					return true;
				}
				else
				{
					return $validEmail;
				}
			}
			else
			{
				return $checkPass;
			}
		}
		else
		{
			return $notNull;
		}
	}
// checks the input parameters to empty 
	public function NotNull($name, $pass, $conf_pass)
	{
		$this -> er = '';
		if ('' == $name)
		{
			$this -> er .= 'Enter name</br>';
		}
		if ('' == $pass)
		{
			$this -> er .= 'Enter password</br>';
		}
		if ('' == $conf_pass)
		{
			$this -> er .= 'Enter confirm password</br>';
		}
		return $this -> er;
	}
// verifies that the password matches
	public function checkPass($pass, $conf_pass)
	{
		if($pass !== $conf_pass)
		{
			$this -> er .= 'passwords must match</br>';
		}
		return $this -> er;
	}
// checks the entered email
	public function validEmail($email)
	{
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$this -> er .= 'email not valid</br>';
		}
		return $this -> er;
	}
// checks the input parameters from book form to empty 
	public function notNullBook($title, $desc, $autors, $genres, $price)
	{
		$err = '';
		if('' == $title)
		{
			$err .= 'Enter book title </br>';
		}
		if('' == $desc)
		{
			$err .= 'Enter book desctiption </br>';
		}
		if('' == $price OR !is_numeric($price))
		{
			$err .= 'Not Correct price </br>';
		}
		if(empty($autors))
		{
			$err .= 'Select autors for book</br>';
		}
		if(empty($genres))
		{
			$err .= 'Select genres for book</br>';
		}
		return $err;
	}
}
?>