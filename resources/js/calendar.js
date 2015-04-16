var month = '';
var year = '';
var start = '';
var theadRuss = '<table><tr><th>Понедельник</th><th>Вторник</th><th>Среда</th><th>четверг</th><th>пятница</th><th>суббота</th><th>воскресенье</th></tr><tr>';
var theadEng = '<table><tr><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th></tr><tr>';
Date.prototype.getMonthName = function () {
    var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    return month[this.getMonth()];
}

function createCalendar() {

    var elem = $("#cal");

    var mon = month - 1; // месяцы в JS идут от 0 до 11, а не от 1 до 12
    var d = new Date(year, mon);
    var monthName = d.getMonthName();
    $('#curDate').html(monthName + ' ' + year);

    var table = thead;

    // заполнить первый ряд от понедельника
    // и до дня, с которого начинается месяц
    // * * * | 1  2  3  4
    for (var i = 0; i < getDay(d); i++) {
        table += '<td></td>';
    }
	if(getDay(d) == 7) {
		table += '</tr>';
	}
    // ячейки календаря с датами
    while (d.getMonth() == mon) {
        table += '<td><div class="day">' + d.getDate() + '</div></td>';

        if (getDay(d) % 7 == 6) { // вс, последний день - перевод строки
            table += '</tr><tr>';
        }

        d.setDate(d.getDate() + 1);
    }

    // добить таблицу пустыми ячейками, если нужно
    if (getDay(d) != 0) {
        for (var i = getDay(d); i < 7; i++) {
            table += '<td></td>';
        }
    }

    // закрыть таблицу
    table += '</tr></table>';

    // только одно присваивание innerHTML
    //elem.innerHTML = table;
    $(table).appendTo(elem);
}

function getDay(date) { // получить номер дня недели, от 0(пн) до 6(вс)
    var day = date.getDay();
    if (day == 0) day = 7;
    if(start == 'eng') {
		return day;
	}
	else {
		return day - 1;
	}
	//return day - 1;
}

function minus() {
    $('#cal').empty();
    month = month - 1;
    if (month == 0) {
        month = 12;
        year = year - 1;
        createCalendar();
    } else {
        createCalendar();
    }
}

function plus() {
    $('#cal').empty();
    month = month + 1;
    if (month == 13) {
        month = 1;
        year = year + 1;
        createCalendar();
    } else {
        createCalendar();
    }
}

function eng() {
	start = 'eng';
	thead = theadEng;
	$('#cal').empty();
	createCalendar();
}

function russ() {
	start = 'russ';
	thead = theadRuss;
	$('#cal').empty();
	createCalendar();
}

$(document).ready(function () {
	thead = theadRuss;
	start = 'russ';
    month = new Date().getMonth() + 1;
    year = new Date().getFullYear();
    createCalendar();
});
//window.addEventListener('load', createCalendar(2015, 3), false);