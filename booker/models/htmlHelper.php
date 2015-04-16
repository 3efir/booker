<?php
class htmlHelper
{
	// render and return Li elements for header menu
	public function headerMenu($rooms)
	{
		$result = '';
		$file = file_get_contents(
		'C:\xampp\htdocs\~user8\booker\resources\templates\small\headerLi.html');
		foreach($rooms as $value)
		{
			$arr = array('%ROOM%' => $value['idRoom'],
						'%NAME%' => $value['name']);
			$result .= FrontController::templateRender($file, $arr);
		}
		return $result;
	}
}
?>