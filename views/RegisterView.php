<?php
class RegisterView
{
	public function ShowForm($data)
	{
		$file = file_get_contents('resources/templates/RegisterForm.html');
		$form = FrontController::templateRender($file, $data);
		$view = FrontController::render('../resources/templates/admin.html',
		$form);
        FrontController::setBody($view);		
		return true;
	}
	public function showRoomForm($data)
	{
		$file = file_get_contents('resources/templates/addRoomForm.html');
		$form = FrontController::templateRender($file, $data);
		$view = FrontController::render('../resources/templates/admin.html',
		$form);
        FrontController::setBody($view);		
		return true;
	}
	public function editForm($arr, $err = '')
	{
		$data = array('%NAME%' => $arr[0]['name'],
					'%ID%' => $arr[0]['id'],
					'%EMAIL%' => $arr[0]['email'],
					'%ERRORS%' => $err);
		$file = file_get_contents('resources/templates/editForm.html');
		$form = FrontController::templateRender($file, $data);
		$view = FrontController::render('../resources/templates/admin.html',
		$form);
        FrontController::setBody($view);
	}
}
?>