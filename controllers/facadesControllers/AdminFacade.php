<?php
/*
* @param valid: stores object of class validator
* @param DB: stores data base object
* @param encode: stores object of class encode/decode
* @params name, email, errors, roomName: stores filtered values coming from form
*/
class AdminFacade
{
    protected $valid, $DB, $name = '', $email = '', $errors = '',
			$roomName = '', $encode;
	private $pass;
    public function __construct()
    {
        $this -> valid = new ValidatorsModel();
        $this -> DB = DataBase::getInstance();
		$this -> encode = new EncoderDecoder();
        return true;
    }
	// method for filter and validate values from register form
    public function checkRegister($name, $email, $pass, $confPass)
    {
		$this -> errors = '';
		// filter name coming from register form
		$name = $this -> valid -> FilterFormValues($name);
       if($name !== '')
	   {
		   $this -> name = $name;
	   }
	   else
	   {
		   $this -> name = '';
		   $this -> errors .= "Field name cant be empty</br>";
	   }
	   // filter email coming from register form, if not empty - validate
	   $email = $this -> valid -> FilterFormValues($email);
       if($email !== '')
	   {
		   if($this -> valid -> validEmail($email) === true)
		   {
				$this -> email = $email;
		   }
		   else
		   {
			   $this -> errors .= "Not correct email </br>";
		   }
	   }
	   else
	   {
		   $this -> errors .= "Field email cant be empty </br>";
	   }
	   // filter passwords coming from register form
	   $pass = $this -> valid -> FilterFormValues($pass);
	   $confPass = $this -> valid -> FilterFormValues($confPass);
	    if($pass !== '' && $confPass !== '')
	   {
			if($this -> valid -> checkPass($pass, $confPass) === false)
			{
				$this -> errors .= "Passwords must match </br>";
			}
			else
			{
				$this -> pass = $this -> encode -> getHashPass($pass);
			}
	   }
	   if('' == $this -> errors)
	   {
			return true;
	   }
	   else
	   {
		   return false;
	   }
    }
	// array for render register form and add room form
	public function getArray()
	{
		return $data = array('%NAME%' => $this -> name,
							'%EMAIL%' => $this -> email,
							'%ROOM%' => $this -> roomName,
							'%ERRORS%' => $this -> errors);
	}
	// method try add new user to DB if true clear values for render
	public function addUser()
	{
		try
		{
			$arr = array($this -> name, $this -> pass, $this -> email);
			$this -> DB -> INSERT(" employees ") -> keys(" name, pass, email ")
				-> values( " ?, ?, ? " ) -> insertUpdate($arr);
			$this -> name = '';
			$this -> email = '';
			$this -> pass = '';
			$this -> errors = 'New user added!';
			return true;
		}
		catch( Exception $e)
		{
			$this -> errors = $e->getMessage();
		}
	}
	// method for add new room
	public function addRoom($room)
	{
		$room = $this -> valid -> FilterFormValues($room);
		$this -> roomName = $room;
		try
		{
			$arr = array($this -> roomName);
			$this -> DB -> INSERT(" room ") -> keys(" name ") -> values(" ? ")
			-> insertUpdate($arr);
			$this -> roomName = '';
			$this -> errors = 'New room added!';
			return true;
		}
		catch(Exception $e)
		{
			$this -> errors = $e -> getMessage();
			return true;
		}
	}
	// select and return all employees
	public function getEmployeesList()
	{
		$result = $this -> DB -> SELECT(" id, name, email ") -> from(" employees
		") -> selected();
		return $result;
	}
	// method for delete employee
	public function deleteEmployee($id)
	{
		$id = $this -> valid -> FilterFormValues($id);
		$this -> DB -> DELETE(" employees ") -> where(" id = $id ") -> 
		deleted();
		$this -> DB -> DELETE(" appointments ") -> where(" idEmp = $id ") ->
		whereAnd(" date > CURDATE() ") -> deleted();
		header("location: /~user8/booker/admin/employeeList", true, 301);
		return true;
	}
	// method for select employee by incoming id
	public function selectEmployee($id)
	{
        $result = $this -> DB -> SELECT(" id, name, email ") -> 
            from(" employees ") -> where(" id = $id ") -> selected();
		return $result;
	}
	// method for update information about registered employee
	public function updateEmployee($id, $arr)
	{
		$id = $this -> valid -> FilterFormValues($id);
		$name = $this -> valid -> FilterFormValues($arr['name']);
        $email = $this -> valid -> FilterFormValues($arr['email']);
		$OldPass = $this -> valid -> FilterFormValues($arr['Oldpass']);
		$pass = $this -> valid -> FilterFormValues($arr['pass']);
		$conf_pass = $this -> valid -> FilterFormValues($arr['conf_pass']);
        if($this -> valid -> validEmail($email))
        {
		    if('' == $name || '' == $email || '' == $OldPass || '' == $pass ||
			'' == $conf_pass)
		    {
			    return "fields cant be empty";
		    }
		    else
		    {
				$DBpass = $this -> DB -> SELECT(" pass ") -> from(" 
				employees ") -> where(" id = $id ") -> selected();
				if($this -> encode -> validPass($DBpass[0]['pass'], $OldPass) 
					== true)
				{
					if($this -> valid -> checkPass($pass, $conf_pass) === false)
					{
						return "Passwords must match </br>";
					}
					else
					{
						$pass = $this -> encode -> getHashPass($pass);
						try
						{
							$arr = array($name);
							$this -> DB -> UPDATE(" employees ") -> SET(" name 
							") -> where(" id = $id ") -> insertUpdate($arr);
							$arr = array($email);
							$this -> DB -> UPDATE(" employees ") -> SET(" email
							 ") -> where(" id = $id ") -> insertUpdate($arr);
							$arr = array($pass);
							$this -> DB -> UPDATE(" employees ") -> SET(" pass 
							 ") -> where(" id = $id ") -> insertUpdate($arr);
							return "Information about employee was changed";
						}
						catch(Exception $e)
						{
							return $e->getMessage();
						}
					}
				}
				else
				{
					return "not correct old password";
				}
		    }
        }
        else
        {
            return "not correct email";
        }
    }
}
?>