<?php
class AdminController
{
	protected $view;
	public function __construct()
	{
		$this -> view = new AdminView();
		return true;
	}
	public function indexAction()
	{
		$this -> view -> IndexAction();
		return true;
	}
	public function RightMenuAction()
	{
		$this -> view -> rightMenuAction();
		return true;
	}
}
?>