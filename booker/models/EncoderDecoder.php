<?php
/*
*class for encode and decode
*/
class EncoderDecoder
{
// incoming param: password
// return hash password
	public function getHashPass($pass)
	{
		return password_hash($pass, PASSWORD_DEFAULT);
	}
// incoming params: hash and pass
// return true if hash = pass or false
	public function validPass($hash, $pass)
	{
		return password_verify($pass, $hash);
	}
}
?>