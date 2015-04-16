<?php
class CalendarController
{
    protected $htmlHelper;
    protected $session;
    public function __construct()
    {
        date_default_timezone_set('America/Los_Angeles');
        $this -> session = new SessionInterface();
        $month = $this -> session -> getMonth();
        if(empty($month))
        {        
            $month = date("m");
            $year = date("y");
            $this -> session -> setMonth($month);
            $this -> session -> setYear($year);            
        }
        $this -> htmlHelper = new htmlHelper();
        return true;
    }
    public function getCalendar()
    {
        $month = $this -> session -> getMonth();
        $year = $this -> session -> getYear();
        $c = $this -> htmlHelper -> getCalendar($month, $year);
        return $c;
    }
    public function increastAction()
    {
        $year = $this -> session -> getYear();
        $month = $this -> session -> getMonth() + 1;
         if($month == 13)
         {
        $month = date("m" , mktime(0,0,0,1));            
            $year = $year + 1;
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
