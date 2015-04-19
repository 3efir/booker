<?php
/*
* @param RussMonth: stores the names of Russian months
* @param RussDays: stores the names of Russian days
* @param EngDays: stores the names of English days
*/
class htmlHelper
{
	protected $RussMonth = array( 
		"01" => "январь", 
		"02" => "февраль", 
		"03" => "март", 
		"04" => "апрель", 
		"05" => "май", 
		"06" => "июнь", 
		"07" => "июль", 
		"08" => "август", 
		"09" => "сентябрь", 
		"10" => "октябрь", 
		"11" => "ноябрь", 
		"12" => "декабрь"); 
	protected $RussDays = array('Понедельник','Вторник','Среда','Четверг',
								'Пятница', 'Субота','Воскресенье'); 
	protected $EngDays =  array('Sunday','Monday','Tuesday','Wednesday',
								'Thursday','Friday','Saturday');

	// render and return Li elements for header menu
	public function headerMenu($rooms)
	{
		$result = '';
		$file = file_get_contents(
		'resources/templates/small/headerLi.html');
		foreach($rooms as $value)
		{
			$arr = array('%ROOM%' => $value['idRoom'],
						'%NAME%' => $value['name']);
			$result .= FrontController::templateRender($file, $arr);
		}
		return $result;
    }
	// create calendar
	// incoming params selected month, year, language and array with events 
    public function getCalendar($month, $year, $lang, $events)
    {
		// select header for calendar 
		if('eng' == $lang)
		{
			$monthName = date('F', mktime(0,0,0,$month));
			$headings = $this -> EngDays;
		}
		else
		{
			$monthName = $this -> RussMonth[$month];
			$headings = $this -> RussDays;
		}
		// start header calendar with names of days
		$calendar = '<tr class="calendar-row">';
		$file = file_get_contents(
		'resources/templates/small/td.html');
		foreach($headings as $value)
		{
			$arr = array('%CLASS%' => 'calendar-day-head',
						'%VALUE%' => $value);
			$calendar .= FrontController::templateRender($file, $arr);
		}
		$calendar .= '</tr>';
		// Serial number of the day of the week
        $running_day = date('w',mktime(0,0,0,$month,1,$year));
        if('russ' == $lang)
		{
			$running_day = $running_day - 1;
		}
		// count days in this month
        $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
        $days_in_this_week = 1;
        $day_counter = 0;
        $dates_array = array();
        $calendar.= '<tr class="calendar-row">';
		// paint over the week prior to the first day of the month
        for($x = 0; $x < $running_day; $x++)
		{
			$arr = array('%CLASS%' => 'calendar-day-np',
						'%VALUE%' => '');
			$calendar .= FrontController::templateRender($file, $arr);
			$days_in_this_week++;
		}
		$href = file_get_contents('resources/templates/small/eventHref.html');
		// td with days of month
		for($list_day = 1; $list_day <= $days_in_month; $list_day++)
		{
			$value = '<div class="day-number">'.$list_day.'</div>
			<div class="layer">';
			//render events for current day
			foreach($events as $v)
			{
				if($v['day'] == $list_day)
				{
					$eve = array('%ID%' => $v['idApp'],
								'%NAME%' => $v['start'].' - '.$v['end']);
					$value .= FrontController::templateRender($href, $eve);
				}
			}
			$value .= "</div>";
			$arr = array('%CLASS%' => 'calendar-day',
				'%VALUE%' => $value);
			$calendar .= FrontController::templateRender($file, $arr);
			//if the last day of the week to wrap lines
			if($running_day == 6)
			{
				$calendar.= '</tr>';
				if(($day_counter+1) != $days_in_month)
				{
					$calendar.= '<tr class="calendar-row">';
				}
				$running_day = -1;
				$days_in_this_week = 0;
			}
			$days_in_this_week++; $running_day++; $day_counter++;
		}
		// paint the end of the calendar with empty cells
		if($days_in_this_week < 8)
		{
			for($x = 1; $x <= (8 - $days_in_this_week); $x++)
			{
				$arr = array('%CLASS%' => 'calendar-day-np',
						'%VALUE%' => '');
				$calendar .= FrontController::templateRender($file, $arr);
			}	
		}
		$calendar.= '</tr>';
		// render calendar and return
		$file = file_get_contents(
		'resources/templates/calendar.html');
		$arr = array('%DATE%' => $monthName.' '.date('Y', mktime(0,0,0,1,1,$year)),
					'%BODY%' => $calendar);
		$result = FrontController::templateRender($file, $arr);
		return $result;
    }
	// method for render employee list
	public function employeesList($list)
	{
		$result = '<table class="table table-bordered">';
		$file = file_get_contents('resources/templates/small/empoyeesList.html');
		foreach($list as $val)
		{
			$arr = array('%EMAIL%' => $val['email'],
						'%NAME%' => $val['name'],
						'%ID%' => $val['id']);
			$result .= FrontController::templateRender($file, $arr);
		}
		$result .= '</table>';
		return $result;
	}
}
?>