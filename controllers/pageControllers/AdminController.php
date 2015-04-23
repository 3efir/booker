<?php
/*
* class for work with admin 
* @param view: stores view object
* @param lang: stores array with keys and values for render 
* @param session: stores object for work with session class
*/
class AdminController
{
	protected $view, $lang, $session, $facade, $roomFacade;
	public function __construct()
	{
		$this -> view = new AdminView();
		$this -> session = new SessionInterface();
        $this -> facade = new AdminFacade();
        $this -> roomFacade = new RoomFacade();
		$lang = $this -> session -> getLang();
		$sess = $this -> session -> getSession();
		if($sess['whoIam'] == 0)
		{
			header('location: /~user8/booker/admin/wtf', true, 301);
		}
		$this -> lang = new LangInterface($lang);
		return true;
	}
	// 
	public function indexAction()
    {
        $events = $this -> roomFacade -> getEvents();
		$t = new CalendarController();
        $calendar = $t -> getCalendar($events);
		$this -> view -> IndexAction($calendar);
		return true;
	}
	public function RightMenuAction()
	{
		$data = $this -> lang -> loadLang();
		$this -> view -> rightMenuAction($data);
		return true;
	}
	public function employeeListAction()
	{
        $list = $this -> facade -> getEmployeesList();
		$this -> view -> employeesList($list);
	}
	public function deleteEmployeeAction()
	{
		$id = FrontController::getParams();
		$this -> facade -> deleteEmployee($id);
	}
}
?>
