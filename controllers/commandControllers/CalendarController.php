<?php
/*
* class for work with calendar
* @param htmlHelper: stores htmlHelper class object
* @param session: stores session interface class object
*/
class CalendarController
{
    protected $htmlHelper;
    protected $session;
	// set default time zone, construct objects
	// if user login first set current month and year
    public function __construct()
    {
        //date_default_timezone_set('America/Los_Angeles');
        $this -> session = new SessionInterface();
        $this -> htmlHelper = new htmlHelper();
        return true;
    }
	// use session class for get selected month, year and language
	// call and return calendar
    public function getCalendar($events)
    {
        $month = $this -> session -> getMonth();
        $year = $this -> session -> getYear();
		$lang = $this -> session -> getLang();
		$format = $this -> session -> getFormat();
        $calendar = $this -> htmlHelper -> getCalendar($month, $year, $lang,
		$events, $format);
        return $calendar;
    }
	// method for increase month and year
    public function increastAction()
    {
        $year = $this -> session -> getYear();
        $month = $this -> session -> getMonth() + 1;
         if($month > 12)
         {
			$newMonth = date("m" , mktime(0,0,0,1));            
            $year = $year + 1;
            $this -> session -> setYear($year);
            $this -> session -> setMonth($newMonth);
        }
        else
        {
            $newMonth = date("m", mktime(0,0,0,$month));
            $this -> session -> setMonth($newMonth);
        }
        header("location: /~user8/booker/");
        return true;
    }
	// method for decrease month and year
    public function decreastAction()
    {
        $year = $this -> session -> getYear();
        $month = $this -> session -> getMonth() -1;
        if($month == 0)
        {
        $month = date("m" , mktime(0,0,0,12));                        
            $year = $year - 1;
            $this -> session -> setYear($year);
            $this -> session -> setMonth($month);            
        }
        else
        {
            $month = date("m", mktime(0,0,0,$month));            
            $this -> session -> setMonth($month);
        }
        header("location: /~user8/booker/");
        return true;
    }
}
?>