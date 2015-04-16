<?php
/*
* class for work with languages files
* @param file: stores object xml file
*/
class langInterface
{
	protected $file;
	public function __construct($lang)
	{
		$this -> file = simplexml_load_file('resources/langs/'.$lang.'.strings');
	}
	public function loadLang()
	{
		$result = array();
		foreach($this -> file as $value)
		{
			$key = $value -> KEY;
			$val = $value -> VALUE;
			$result["$key"] = "$val";
		}
		return $result;
	}
}
?>