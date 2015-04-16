<?php
/*
* class for work with admin 
* @param view: stores view object
* @param lang: stores array with keys and values for render 
* @param session: stores object for work with session class
*/
class AdminController
{
	protected $view;
	protected $lang;
	protected $session;
	public function __construct()
	{
		$this -> view = new AdminView();
		$this -> session = new SessionInterface();
		$lang = $this -> session -> getLang();
		$this -> lang = new LangInterface($lang);
		return true;
	}
	public function indexAction()
	{
		$t = new CalendarController();
        $calendar = $t -> getCalendar();
		$this -> view -> IndexAction($calendar);
		return true;
	}
	public function RightMenuAction()
	{
		$data = $this -> lang -> loadLang();
		$this -> view -> rightMenuAction($data);
		return true;
	}
}
?>