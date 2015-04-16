<?php
/*
* @param session: stores session object
* @param view: stores view object
* @param facade: stores facade object
*/
class IndexController
{
	protected $view;
	protected $session;
	protected $facade;
	// construct objects
	public function __construct()
	{
		$this -> view = new IndexView();
		$this -> session = new SessionInterface();
		//$this -> facade = new RoomFacade();
		return true;
	}
	// call indexView for show index page
	public function IndexAction()
    {
        $t = new CalendarController();
        $calendar = $t -> getCalendar();
		$sess = $this -> session -> getSession();
		if($sess['whoIam'] == true)
		{
			header('location: /~user8/booker/admin', true, 301);
		}
		else
		{
			$this -> view -> indexAction($calendar);
		}
	}
	// use Room Facade for select all rooms
	// call indexView for show Header
	public function HeaderAction()
	{
		//$rooms = $this -> facade -> getRooms();
	//	$curr = $this -> facade -> getCurrentRoom();
	//	$this -> view -> headerAction($rooms, $curr);
		return true;
	}
	// method for change selected room
	public function selectRoomAction()
	{
		$id = FrontController::getParams();
		$this -> session -> setRoom($id);
		$r = $_SERVER['HTTP_REFERER'];
		header('location: '.$r, true, 301);
	}
	public function LeftMenuAction()
	{
		$this -> view -> leftMenuAction();
		return true;
	}
}
?>
