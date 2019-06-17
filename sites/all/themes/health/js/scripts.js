(function($){  

/**

 * Zabuto Calendar

 *

 * Dependencies

 * - jQuery (2.0.3)

 * - Twitter Bootstrap (3.0.2)

 */



if (typeof jQuery == 'undefined') {

    throw new Error('jQuery is not loaded');

}



/**

 * Create calendar

 *

 * @param options

 * @returns {*}

 */

$.fn.zabuto_calendar = function (options) {

    var opts = $.extend({}, $.fn.zabuto_calendar_defaults(), options);

    var languageSettings = $.fn.zabuto_calendar_language(opts.language);

    opts = $.extend({}, opts, languageSettings);



    this.each(function () {

        var $calendarElement = $(this);

        $calendarElement.attr('id', "zabuto_calendar_" + Math.floor(Math.random() * 99999).toString(36));



        $calendarElement.data('initYear', opts.year);

        $calendarElement.data('initMonth', opts.month);

        $calendarElement.data('monthLabels', opts.month_labels);

        $calendarElement.data('weekStartsOn', opts.weekstartson);

        $calendarElement.data('navIcons', opts.nav_icon);

        $calendarElement.data('dowLabels', opts.dow_labels);

        $calendarElement.data('showToday', opts.today);

        $calendarElement.data('showDays', opts.show_days);

        $calendarElement.data('showPrevious', opts.show_previous);

        $calendarElement.data('showNext', opts.show_next);

        $calendarElement.data('cellBorder', opts.cell_border);

        $calendarElement.data('jsonData', opts.data);

        $calendarElement.data('ajaxSettings', opts.ajax);

        $calendarElement.data('legendList', opts.legend);

        $calendarElement.data('actionFunction', opts.action);

        $calendarElement.data('actionNavFunction', opts.action_nav);



        drawCalendar();



        function drawCalendar() {

            var dateInitYear = parseInt($calendarElement.data('initYear'));

            var dateInitMonth = parseInt($calendarElement.data('initMonth')) - 1;

            var dateInitObj = new Date(dateInitYear, dateInitMonth, 1, 0, 0, 0, 0);

            $calendarElement.data('initDate', dateInitObj);



            var tableClassHtml = ($calendarElement.data('cellBorder') === true) ? ' table-bordered' : '';



            $tableObj = $('<table class="table' + tableClassHtml + '"></table>');

            $tableObj = drawTable($calendarElement, $tableObj, dateInitObj.getFullYear(), dateInitObj.getMonth());



            $legendObj = drawLegend($calendarElement);



            var $containerHtml = $('<div class="zabuto_calendar" id="' + $calendarElement.attr('id') + '"></div>');

            $containerHtml.append($tableObj);

            $containerHtml.append($legendObj);



            $calendarElement.append($containerHtml);



            var jsonData = $calendarElement.data('jsonData');

            if (false !== jsonData) {

                checkEvents($calendarElement, dateInitObj.getFullYear(), dateInitObj.getMonth());

            }

        }



        function drawTable($calendarElement, $tableObj, year, month) {

            var dateCurrObj = new Date(year, month, 1, 0, 0, 0, 0);

            $calendarElement.data('currDate', dateCurrObj);



            $tableObj.empty();

            $tableObj = appendMonthHeader($calendarElement, $tableObj, year, month);

            $tableObj = appendDayOfWeekHeader($calendarElement, $tableObj);

            $tableObj = appendDaysOfMonth($calendarElement, $tableObj, year, month);

            checkEvents($calendarElement, year, month);

            return $tableObj;

        }



        function drawLegend($calendarElement) {

            var $legendObj = $('<div class="legend" id="' + $calendarElement.attr('id') + '_legend"></div>');

            var legend = $calendarElement.data('legendList');

            if (typeof(legend) == 'object' && legend.length > 0) {

                $(legend).each(function (index, item) {

                    if (typeof(item) == 'object') {

                        if ('type' in item) {

                            var itemLabel = '';

                            if ('label' in item) {

                                itemLabel = item.label;

                            }



                            switch (item.type) {

                                case 'text':

                                    if (itemLabel !== '') {

                                        var itemBadge = '';

                                        if ('badge' in item) {

                                            if (typeof(item.classname) === 'undefined') {

                                                var badgeClassName = 'badge-event';

                                            } else {

                                                var badgeClassName = item.classname;

                                            }

                                            itemBadge = '<span class="badge ' + badgeClassName + '">' + item.badge + '</span> ';

                                        }

                                        $legendObj.append('<span class="legend-' + item.type + '">' + itemBadge + itemLabel + '</span>');

                                    }

                                    break;

                                case 'block':

                                    if (itemLabel !== '') {

                                        itemLabel = '<span>' + itemLabel + '</span>';

                                    }

                                    if (typeof(item.classname) === 'undefined') {

                                        var listClassName = 'event';

                                    } else {

                                        var listClassName = 'event-styled ' + item.classname;

                                    }

                                    $legendObj.append('<span class="legend-' + item.type + '"><ul class="legend"><li class="' + listClassName + '"></li></u>' + itemLabel + '</span>');

                                    break;

                                case 'list':

                                    if ('list' in item && typeof(item.list) == 'object' && item.list.length > 0) {

                                        var $legendUl = $('<ul class="legend"></u>');

                                        $(item.list).each(function (listIndex, listClassName) {

                                            $legendUl.append('<li class="' + listClassName + '"></li>');

                                        });

                                        $legendObj.append($legendUl);

                                    }

                                    break;

                                case 'spacer':

                                    $legendObj.append('<span class="legend-' + item.type + '"> </span>');

                                    break;



                            }

                        }

                    }

                });

            }



            return $legendObj;

        }



        function appendMonthHeader($calendarElement, $tableObj, year, month) {

            var navIcons = $calendarElement.data('navIcons');

            var $prevMonthNavIcon = $('<span><span class="glyphicon glyphicon-chevron-left"></span></span>');

            var $nextMonthNavIcon = $('<span><span class="glyphicon glyphicon-chevron-right"></span></span>');

            if (typeof(navIcons) === 'object') {

                if ('prev' in navIcons) {

                    $prevMonthNavIcon.html(navIcons.prev);

                }

                if ('next' in navIcons) {

                    $nextMonthNavIcon.html(navIcons.next);

                }

            }



            var prevIsValid = $calendarElement.data('showPrevious');

            if (typeof(prevIsValid) === 'number' || prevIsValid === false) {

                prevIsValid = checkMonthLimit($calendarElement.data('showPrevious'), true);

            }



            var $prevMonthNav = $('<div class="calendar-month-navigation"></div>');

            $prevMonthNav.attr('id', $calendarElement.attr('id') + '_nav-prev');

            $prevMonthNav.data('navigation', 'prev');

            if (prevIsValid !== false) {

                prevMonth = (month - 1);

                prevYear = year;

                if (prevMonth == -1) {

                    prevYear = (prevYear - 1);

                    prevMonth = 11;

                }

                $prevMonthNav.data('to', {year: prevYear, month: (prevMonth + 1)});

                $prevMonthNav.append($prevMonthNavIcon);

                if (typeof($calendarElement.data('actionNavFunction')) === 'function') {

                    $prevMonthNav.click($calendarElement.data('actionNavFunction'));

                }

                $prevMonthNav.click(function (e) {

                    drawTable($calendarElement, $tableObj, prevYear, prevMonth);

                });

            }



            var nextIsValid = $calendarElement.data('showNext');

            if (typeof(nextIsValid) === 'number' || nextIsValid === false) {

                nextIsValid = checkMonthLimit($calendarElement.data('showNext'), false);

            }



            var $nextMonthNav = $('<div class="calendar-month-navigation"></div>');

            $nextMonthNav.attr('id', $calendarElement.attr('id') + '_nav-next');

            $nextMonthNav.data('navigation', 'next');

            if (nextIsValid !== false) {

                nextMonth = (month + 1);

                nextYear = year;

                if (nextMonth == 12) {

                    nextYear = (nextYear + 1);

                    nextMonth = 0;

                }

                $nextMonthNav.data('to', {year: nextYear, month: (nextMonth + 1)});

                $nextMonthNav.append($nextMonthNavIcon);

                if (typeof($calendarElement.data('actionNavFunction')) === 'function') {

                    $nextMonthNav.click($calendarElement.data('actionNavFunction'));

                }

                $nextMonthNav.click(function (e) {

                    drawTable($calendarElement, $tableObj, nextYear, nextMonth);

                });

            }



            var monthLabels = $calendarElement.data('monthLabels');



            var $prevMonthCell = $('<th></th>').append($prevMonthNav);

            var $nextMonthCell = $('<th></th>').append($nextMonthNav);



            var $currMonthLabel = $('<span>' + monthLabels[month] + ' ' + year + '</span>');

            $currMonthLabel.dblclick(function () {

                var dateInitObj = $calendarElement.data('initDate');

                drawTable($calendarElement, $tableObj, dateInitObj.getFullYear(), dateInitObj.getMonth());

            });



            var $currMonthCell = $('<th colspan="5"></th>');

            $currMonthCell.append($currMonthLabel);



            var $monthHeaderRow = $('<tr class="calendar-month-header"></tr>');

            $monthHeaderRow.append($prevMonthCell, $currMonthCell, $nextMonthCell);



            $tableObj.append($monthHeaderRow);

            return $tableObj;

        }



        function appendDayOfWeekHeader($calendarElement, $tableObj) {

            if ($calendarElement.data('showDays') === true) {

                var weekStartsOn = $calendarElement.data('weekStartsOn');

                var dowLabels = $calendarElement.data('dowLabels');

                if (weekStartsOn === 0) {

                    var dowFull = $.extend([], dowLabels);

                    var sunArray = new Array(dowFull.pop());

                    dowLabels = sunArray.concat(dowFull);

                }



                var $dowHeaderRow = $('<tr class="calendar-dow-header"></tr>');

                $(dowLabels).each(function (index, value) {

                    $dowHeaderRow.append('<th>' + value + '</th>');

                });

                $tableObj.append($dowHeaderRow);

            }

            return $tableObj;

        }



        function appendDaysOfMonth($calendarElement, $tableObj, year, month) {

            var ajaxSettings = $calendarElement.data('ajaxSettings');

            var weeksInMonth = calcWeeksInMonth(year, month);

            var lastDayinMonth = calcLastDayInMonth(year, month);

            var firstDow = calcDayOfWeek(year, month, 1);

            var lastDow = calcDayOfWeek(year, month, lastDayinMonth);

            var currDayOfMonth = 1;



            var weekStartsOn = $calendarElement.data('weekStartsOn');

            if (weekStartsOn === 0) {

                if (lastDow == 6) {

                    weeksInMonth++;

                }

                if (firstDow == 6 && (lastDow == 0 || lastDow == 1 || lastDow == 5)) {

                    weeksInMonth--;

                }

                firstDow++;

                if (firstDow == 7) {

                    firstDow = 0;

                }

            }



            for (var wk = 0; wk < weeksInMonth; wk++) {

                var $dowRow = $('<tr class="calendar-dow"></tr>');

                for (var dow = 0; dow < 7; dow++) {

                    if (dow < firstDow || currDayOfMonth > lastDayinMonth) {

                        $dowRow.append('<td></td>');

                    } else {

                        var dateId = $calendarElement.attr('id') + '_' + dateAsString(year, month, currDayOfMonth);

                        var dayId = dateId + '_day';



                        var $dayElement = $('<div id="' + dayId + '" class="day" >' + currDayOfMonth + '</div>');

                        $dayElement.data('day', currDayOfMonth);



                        if ($calendarElement.data('showToday') === true) {

                            if (isToday(year, month, currDayOfMonth)) {

                                $dayElement.html('<span class="badge badge-today">' + currDayOfMonth + '</span>');

                            }

                        }



                        var $dowElement = $('<td id="' + dateId + '"></td>');

                        $dowElement.append($dayElement);



                        $dowElement.data('date', dateAsString(year, month, currDayOfMonth));

                        $dowElement.data('hasEvent', false);



                        if (typeof($calendarElement.data('actionFunction')) === 'function') {

                            $dowElement.addClass('dow-clickable');

                            $dowElement.click(function () {

                                $calendarElement.data('selectedDate', $(this).data('date'));

                            });

                            $dowElement.click($calendarElement.data('actionFunction'));

                        }



                        $dowRow.append($dowElement);



                        currDayOfMonth++;

                    }

                    if (dow == 6) {

                        firstDow = 0;

                    }

                }



                $tableObj.append($dowRow);

            }

            return $tableObj;

        }



        /* ----- Modal functions ----- */



        function createModal(id, title, body, footer) {

            var $modalHeaderButton = $('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>');

            var $modalHeaderTitle = $('<h4 class="modal-title" id="' + id + '_modal_title">' + title + '</h4>');



            var $modalHeader = $('<div class="modal-header"></div>');

            $modalHeader.append($modalHeaderButton);

            $modalHeader.append($modalHeaderTitle);



            var $modalBody = $('<div class="modal-body" id="' + id + '_modal_body">' + body + '</div>');



            var $modalFooter = $('<div class="modal-footer" id="' + id + '_modal_footer"></div>');

            if (typeof(footer) !== 'undefined') {

                var $modalFooterAddOn = $('<div>' + footer + '</div>');

                $modalFooter.append($modalFooterAddOn);

            }



            var $modalContent = $('<div class="modal-content"></div>');

            $modalContent.append($modalHeader);

            $modalContent.append($modalBody);

            $modalContent.append($modalFooter);



            var $modalDialog = $('<div class="modal-dialog"></div>');

            $modalDialog.append($modalContent);



            var $modalFade = $('<div class="modal fade" id="' + id + '_modal" tabindex="-1" role="dialog" aria-labelledby="' + id + '_modal_title" aria-hidden="true"></div>');

            $modalFade.append($modalDialog);



            $modalFade.data('dateId', id);

            $modalFade.attr("dateId", id);



            return $modalFade;

        }



        /* ----- Event functions ----- */



        function checkEvents($calendarElement, year, month) {

            var jsonData = $calendarElement.data('jsonData');

            var ajaxSettings = $calendarElement.data('ajaxSettings');



            $calendarElement.data('events', false);



            if (false !== jsonData) {

                return jsonEvents($calendarElement);

            } else if (false !== ajaxSettings) {

                return ajaxEvents($calendarElement, year, month);

            }



            return true;

        }



        function jsonEvents($calendarElement) {

            var jsonData = $calendarElement.data('jsonData');

            $calendarElement.data('events', jsonData);

            drawEvents($calendarElement, 'json');

            return true;

        }



        function ajaxEvents($calendarElement, year, month) {

            var ajaxSettings = $calendarElement.data('ajaxSettings');



            if (typeof(ajaxSettings) != 'object' || typeof(ajaxSettings.url) == 'undefined') {

                alert('Invalid calendar event settings');

                return false;

            }



            var data = {year: year, month: (month + 1)};



            $.ajax({

                type: 'GET',

                url: ajaxSettings.url,

                data: data,

                dataType: 'json'

            }).done(function (response) {

                var events = [];

                $.each(response, function (k, v) {

                    events.push(response[k]);

                });

                $calendarElement.data('events', events);

                drawEvents($calendarElement, 'ajax');

            });



            return true;

        }



        function drawEvents($calendarElement, type) {

            var jsonData = $calendarElement.data('jsonData');

            var ajaxSettings = $calendarElement.data('ajaxSettings');



            var events = $calendarElement.data('events');

            if (events !== false) {

                $(events).each(function (index, value) {

                    var id = $calendarElement.attr('id') + '_' + value.date;

                    var $dowElement = $('#' + id);

                    var $dayElement = $('#' + id + '_day');



                    $dowElement.data('hasEvent', true);



                    if (typeof(value.title) !== 'undefined') {

                        $dowElement.attr('title', value.title);

                    }



                    if (typeof(value.classname) === 'undefined') {

                        $dowElement.addClass('event');

                    } else {

                        $dowElement.addClass('event-styled');

                        $dayElement.addClass(value.classname);

                    }



                    if (typeof(value.badge) !== 'undefined' && value.badge !== false) {

                        var badgeClass = (value.badge === true) ? '' : ' badge-' + value.badge;

                        var dayLabel = $dayElement.data('day');

                        $dayElement.html('<span class="badge badge-event' + badgeClass + '">' + dayLabel + '</span>');

                    }



                    if (typeof(value.body) !== 'undefined') {

                        var modalUse = false;

                        if (type === 'json' && typeof(value.modal) !== 'undefined' && value.modal === true) {

                            modalUse = true;

                        } else if (type === 'ajax' && 'modal' in ajaxSettings && ajaxSettings.modal === true) {

                            modalUse = true;

                        }



                        if (modalUse === true) {

                            $dowElement.addClass('event-clickable');



                            var $modalElement = createModal(id, value.title, value.body, value.footer);

                            $('body').append($modalElement);



                            $('#' + id).click(function () {

                                $('#' + id + '_modal').modal();

                            });

                        }

                    }

                });

            }

        }



        /* ----- Helper functions ----- */



        function isToday(year, month, day) {

            var todayObj = new Date();

            var dateObj = new Date(year, month, day);

            return (dateObj.toDateString() == todayObj.toDateString());

        }



        function dateAsString(year, month, day) {

            d = (day < 10) ? '0' + day : day;

            m = month + 1;

            m = (m < 10) ? '0' + m : m;

            return year + '-' + m + '-' + d;

        }



        function calcDayOfWeek(year, month, day) {

            var dateObj = new Date(year, month, day, 0, 0, 0, 0);

            var dow = dateObj.getDay();

            if (dow == 0) {

                dow = 6;

            } else {

                dow--;

            }

            return dow;

        }



        function calcLastDayInMonth(year, month) {

            var day = 28;

            while (checkValidDate(year, month + 1, day + 1)) {

                day++;

            }

            return day;

        }



        function calcWeeksInMonth(year, month) {

            var daysInMonth = calcLastDayInMonth(year, month);

            var firstDow = calcDayOfWeek(year, month, 1);

            var lastDow = calcDayOfWeek(year, month, daysInMonth);

            var days = daysInMonth;

            var correct = (firstDow - lastDow);

            if (correct > 0) {

                days += correct;

            }

            return Math.ceil(days / 7);

        }



        function checkValidDate(y, m, d) {

            return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0)).getDate();

        }



        function checkMonthLimit(count, invert) {

            if (count === false) {

                count = 0;

            }

            var d1 = $calendarElement.data('currDate');

            var d2 = $calendarElement.data('initDate');



            var months;

            months = (d2.getFullYear() - d1.getFullYear()) * 12;

            months -= d1.getMonth() + 1;

            months += d2.getMonth();



            if (invert === true) {

                if (months < (parseInt(count) - 1)) {

                    return true;

                }

            } else {

                if (months >= (0 - parseInt(count))) {

                    return true;

                }

            }

            return false;

        }

    }); // each()



    return this;

};



/**

 * Default settings

 *

 * @returns object

 *   language:          string,

 *   year:              integer,

 *   month:             integer,

 *   show_previous:     boolean|integer,

 *   show_next:         boolean|integer,

 *   cell_border:       boolean,

 *   today:             boolean,

 *   show_days:         boolean,

 *   weekstartson:      integer (0 = Sunday, 1 = Monday),

 *   nav_icon:          object: prev: string, next: string

 *   ajax:              object: url: string, modal: boolean,

 *   legend:            object array, [{type: string, label: string, classname: string}]

 *   action:            function

 *   action_nav:        function

 */

$.fn.zabuto_calendar_defaults = function () {

    var now = new Date();

    var year = now.getFullYear();

    var month = now.getMonth() + 1;

    var settings = {

        language: false,

        year: year,

        month: month,

        show_previous: true,

        show_next: true,

        cell_border: false,

        today: false,

        show_days: true,

        weekstartson: 1,

        nav_icon: false,

        data: false,

        ajax: false,

        legend: false,

        action: false,

        action_nav: false

    };

    return settings;

};



/**

 * Language settings

 *

 * @param lang

 * @returns {{month_labels: Array, dow_labels: Array}}

 */

$.fn.zabuto_calendar_language = function (lang) {

    if (typeof(lang) == 'undefined' || lang === false) {

        lang = 'en';

    }



    switch (lang.toLowerCase()) {

     



        case 'en':

            return {

                month_labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],

                dow_labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"]

            };

            break;



     

    }



};



$(window).load(function(){

    var activeElement = $('.views-slideshow-pager-field-item.active');

    var pcalss = activeElement.find('span').attr('class');



    if(pcalss){

        $('.p'+pcalss).addClass('active theOne');

    }



    $('.views-slideshow-pager-field-item').click(function(){

        activeElement = this;

        $('.pilseta_punkts .active').removeClass('active');

        var p_class = $(this).find('span').attr('class');

        $('.p'+p_class).addClass('active');



      $('.views-slideshow-pager-field-item').removeClass('active');

      $(this).addClass('active');

    });



    $('.views-slideshow-pager-field-item:not(.active)').hover(function(){

        $(this).addClass('active');

    },function(){

        if(this != activeElement)

            $(this).removeClass('active');

    });



    $('#block-views-pilsetas-block-1 .views-row, .views-slideshow-pager-field-item').hover(function(){

            var active_elem = $(this).find('span').attr('class');

            $('.p'+active_elem).addClass('active');

        },

        function() {

            var active_elem = $(this).find('span').attr('class');

            if(this != activeElement)

                $('.p'+active_elem.split(' ')[0]).removeClass('active');

        }

    );



    // Add active class to views-row

    $('.view-display-id-pakalpojumi .views-row').each(function(index) {

        var active_class = $(this).find('.link').attr('class');

        $(this).addClass(active_class);

    });



    $('.view-pilsetas .views-slideshow-pager-field-item').each(function(index) {

        $(this).click(function() {

          $('.views-slideshow-controls-text-pause:not(.views-slideshow-controls-text-status-pause)').trigger('click');

        });

    });





});





   $(document).ready(function () {

    $('span.dropdown-toggle').on('click', function(e) {
      e.stopPropagation();
      $(this).siblings('.dropdown-menu').toggle();
    });

    $("#my-calendar").zabuto_calendar({

      ajax: {

        url: "show_data.php?grade=1"

      }

    });

    if($(window).width() > 767){
        var form_height = $('.contact-form-sidebar').height();
        $('.video-front .embed-responsive').height(form_height);        
    }

    $(".col-half-offset").mouseenter(function(){
        $(this).find('img.blue').show();
        $(this).find('img.green').hide();
    }).mouseleave(function(){
        $(this).find('img.green').show();
        $(this).find('img.blue').hide();
    });

            //scrolling 
         $("a").on('click', function(event) {

        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
          // Prevent default anchor click behavior
          event.preventDefault();

          // Store hash
          var hash = this.hash;

          // Using jQuery's animate() method to add smooth page scroll
          // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
          $('html, body').animate({
            scrollTop: $(hash).offset().top
          }, 800, function(){
       
            // Add hash (#) to URL when done scrolling (default click behavior)
            window.location.hash = hash;
          });
        } // End if
      });

         // resize googel recaptcha
         // var width = $(window).width();
         // if (window.matchMedia('(max-width: 340px)').matches) {

         // }
        // if (window.matchMedia('(max-width: 400px)').matches) {
         // var width = $(window).width();

         var width = $(window).width();

        	if (width < 340) {
            	var scale = width / 328;
            	$('.g-recaptcha').css('transform', 'scale(' + scale + ')');
            	$('.g-recaptcha').css('-webkit-transform', 'scale(' + scale + ')');
            	$('.g-recaptcha').css('transform-origin', '0 0');
            	$('.g-recaptcha').css('-webkit-transform-origin', '0 0');

                var frontp_recptcha = scale - 0.033;
                $('.front .g-recaptcha').css('transform', 'scale(' + frontp_recptcha + ')');
                $('.front .g-recaptcha').css('-webkit-transform', 'scale(' + frontp_recptcha + ')');
        	} 
           else if (width < 400) {
                var scale = width / 325;
                $('.g-recaptcha').css('transform', 'scale(' + scale + ')');
                $('.g-recaptcha').css('-webkit-transform', 'scale(' + scale + ')');
                $('.g-recaptcha').css('transform-origin', '0 0');
                $('.g-recaptcha').css('-webkit-transform-origin', '0 0');

                var frontp_recptcha = scale - 0.033;
                $('.front .g-recaptcha').css('transform', 'scale(' + frontp_recptcha + ')');
                $('.front .g-recaptcha').css('-webkit-transform', 'scale(' + frontp_recptcha + ')');
            }
            else if ( width < 480 ) {
                var scale = width / 320;
                $('.g-recaptcha').css('transform', 'scale(' + scale + ')');
                $('.g-recaptcha').css('-webkit-transform', 'scale(' + scale + ')');
                $('.g-recaptcha').css('transform-origin', '0 0');
                $('.g-recaptcha').css('-webkit-transform-origin', '0 0');
                
                var frontp_recptcha = scale - 0.033;
                $('.front .g-recaptcha').css('transform', 'scale(' + frontp_recptcha + ')');
                $('.front .g-recaptcha').css('-webkit-transform', 'scale(' + frontp_recptcha + ')');
            }



        // }
        // if (window.matchMedia('(max-width: 480px)').matches) {
        //     if (width < 480) {
        //         var scale = width / 320;
        //         $('.g-recaptcha').css('transform', 'scale(' + scale + ')');
        //         $('.g-recaptcha').css('-webkit-transform', 'scale(' + scale + ')');
        //         $('.g-recaptcha').css('transform-origin', '0 0');
        //         $('.g-recaptcha').css('-webkit-transform-origin', '0 0');
        //     } 
        // }   
         //  form load animation
        $('#node-164 form' ).submit(function() {
            $('.menu').prepend('<div class="form_submit_loader"><img src="/sites/lka/files/pictures/loading-animations-preloader.gif"> </div>');
            $('.i18n-en .menu .form_submit_loader').append('<div class="loding_text_main"><h2>Your Form is <span>Sending...</span></h2></div>');
            $('.i18n-lv .menu .form_submit_loader').append('<div class="loding_text_main"><h2>jūsu veidlapa tiek <span>nosūtīšana...</span></h2></div>');
            $('.i18n-ru .menu .form_submit_loader').append('<div class="loding_text_main"><h2>ваша форма <span>отправка...</span></h2></div>');
        });
        $('.form-group .form-item input').attr('required', 'required');
        $('.form-group .form-item textarea').attr('required', 'required');

        $('.container.print-front .video-front .embed-responsive.embed-responsive-16by9').prepend('<img src="/sites/lka/files/pictures/best-travel-2016.png" class="hero_sction_tag_pin" />');
            
        // add class to tables for responsiveness for all three languages
        $( ".view-display-id-block_1 h3:contains('Specialists')" ).parent().addClass('specialists-detail-tables');
        $( ".view-display-id-block_1 h3:contains('Speciālisti')" ).parent().addClass('specialists-detail-tables');
        $( ".view-display-id-block_1 h3:contains('Cпециалисти')" ).parent().addClass('specialists-detail-tables');
        $( ".view-display-id-block_1 h3:contains('Специалисты')" ).parent().addClass('specialists-detail-tables');
        $( ".view-display-id-block_1 h3:contains('Выберите своего специалиста')" ).parent().addClass('specialists-detail-tables');

        // change form title
        $('.i18n-en #webform-client-form-164 h3').text('Question?');
        $('.i18n-lv #webform-client-form-164 h3').text('Jautājums?');
        $('.i18n-ru #webform-client-form-164 h3').text('Вопрос?');
        // change submit button text
        $('.i18n-en #webform-client-form-164 .btn-have .form-submit').val('Contact clinics');
        $('.i18n-lv #webform-client-form-164 .btn-have .form-submit').val('Nosūtīt klīnikām');
        $('.i18n-ru #webform-client-form-164 .btn-have .form-submit').val('Отправить запрос');

        // for new clicnis services block placement 
        var item_list = $('.our_clinics_services').html();

        $('.contact_form_mob_view .right-slider').prepend(item_list);
        $('.i18n-lv .new_clinics_services h2').text('KLĪNIKAS PAKALPOJUMI');
        $('.i18n-ru .new_clinics_services h2').text('УСЛУГИ КЛИНИКИ');


        // window.setTimeout( show_popup, 5000 ); // 5 seconds

        // for new contact form select list
        // English
         $('form#webform-client-form-701 select#edit-submitted-services option').each(function(){
            // $(this).first().attr('value', '19921');
            var options = $(this).val();
            if((options==19921)||(options==1496)||(options==1309)||(options==1307)||(options==1303)||(options==37)||(options==1300)||(options==1302)||(options==1304)||(options==1305)||(options==834)||(options==1306)
                ||(options==1313)||(options==1494)||(options==1310)||(options==1311)||(options==1419)||(options==36)||(options==1312)||(options==33)||(options==1315)||(options==35)||(options==1314)||(options==1308)||(options==1299)
             ){ // EDITED THIS LINE
                $(this).show();
            }
            else {
                $(this).remove();
            }
        });
         // for new contact form select list 
         // Latvian
         $('form#webform-client-form-704 select#edit-submitted-services option').each(function(){
            // $(this).first().attr('value', '19921');
            var options = $(this).val();
            if((options==19921)||(options==1496)||(options==1309)||(options==1307)||(options==1303)||(options==37)||(options==1300)||(options==1302)||(options==1304)||(options==1305)||(options==834)||(options==1306)
                ||(options==1313)||(options==1494)||(options==1310)||(options==1311)||(options==1419)||(options==36)||(options==1312)||(options==33)||(options==1315)||(options==35)||(options==1314)||(options==1308)||(options==1299)
             ){ // EDITED THIS LINE
                $(this).show();
            }
            else {
                $(this).remove();
            }
        });
         // for new contact form select list
         // Russian
         $('form#webform-client-form-705 select#edit-submitted-services option').each(function(){
            // $(this).first().attr('value', '19921');
            var options = $(this).val();
            if((options==19921)||(options==1496)||(options==1309)||(options==1307)||(options==1303)||(options==37)||(options==1300)||(options==1302)||(options==1304)||(options==1305)||(options==834)||(options==1306)
                ||(options==1313)||(options==1494)||(options==1310)||(options==1311)||(options==1419)||(options==36)||(options==1312)||(options==33)||(options==1315)||(options==35)||(options==1314)||(options==1308)||(options==1299)
             ){ // EDITED THIS LINE
                $(this).show();
            }
            else {
                $(this).remove();
            }
        });
         $('form#webform-client-form-701 select#edit-submitted-services').prepend('<option selected="selected">CHOOSE MEDICAL SERVICE</option>');


         // add new class to the srevices pages price table parent div
        if ($('body').hasClass('page-taxonomy-term-1307')) {
            $('.vocabulary-pakalpojumi #block-views-pakalpojumi-block-1 .views-row-odd table:first').parent().addClass('service_price_list_tabel');

        } else if ($('body').hasClass('page-taxonomy-term-37')) {
            $('.vocabulary-pakalpojumi #block-views-pakalpojumi-block-1 .views-row-even table:first').parent().addClass('service_price_list_tabelOne');

        } else if ($('body').hasClass('page-taxonomy-term-1313')) {
            $('.vocabulary-pakalpojumi #block-views-pakalpojumi-block-1 .views-row-even table:first').wrap("<div class='service_price_list_tabel' />");

        } else {
            $('.vocabulary-pakalpojumi #block-views-pakalpojumi-block-1 table:first').parent().addClass('service_price_list_tabel');

        }
        $('.page-taxonomy-term-1328  #block-views-pakalpojumi-block-1 .view-content div:nth-child(5) > div').addClass('service_price_list_tabel');
        $('.page-taxonomy-term-1328  #block-views-pakalpojumi-block-1 .view-content div:nth-child(3)').addClass('service_price_remove');
        $('.page-taxonomy-term-1328  .service_price_remove .views-field-description-i18n .field-content').removeClass('service_price_list_tabel');



        // Server pages show service related clinics
        $('.view-related-clinics .item-list li').addClass('col-md-6');
        $('.view-related-clinics .views-field-field-bilde .field-content').addClass('server_clicnic_fields');
        $('#block-views-related-clinics-block .view-related-clinics .item-list li .service_clinic_img img').not(':first-child').hide();// hide all the images except first one.

         
        // To check the string if the text is exist in string do somthing
        $('.services_clinic_address_flag').each(function(){

            if ($(this).find('.service_clinic_flags:contains("Latvian")').length > 0)
            {
                $(this).append('<img src="/sites/all/themes/health/img/flags/lv.png" class="sc_flag_img"><br />');
            } 
            if ($(this).find('.service_clinic_flags:contains("English")').length > 0)
            {
                $(this).append('<img src="/sites/all/themes/health/img/flags/en.png" class="sc_flag_img"><br />');
            } 
            if ($(this).find('.service_clinic_flags:contains("Russian")').length > 0)
            {
                $(this).append('<img src="/sites/all/themes/health/img/flags/ru.png" class="sc_flag_img"><br />');
            } 
            if ($(this).find('.service_clinic_flags:contains("French")').length > 0)
            {
                $(this).append('<img src="/sites/all/themes/health/img/flags/fr.png" class="sc_flag_img"><br />');
            } 
            if ($(this).find('.service_clinic_flags:contains("German")').length > 0)
            {
                $(this).append('<img src="/sites/all/themes/health/img/flags/ge.png" class="sc_flag_img"><br />');
            } 
        });
        $('.service_clinic_flags').hide();
        $('.server_clicnis_border_element .services_clinic_address_flag p').not(":nth-child(1)").not(":nth-child(2)").hide();
        $('.server_clicnis_border_element > p:nth-child(1)').addClass('services_clinic_be_description');
        $('.services_clinic_address_flag p:nth-child(2)').addClass('services_clinic_address_address');

        // get text of the field and make in link
        $('#block-views-related-clinics-block .service_clinic_www').each(function(){
            var addressLink = $(this).text();
            $(this).attr("href", "http://" + addressLink);
        });

        // geting href from some other element, wrapping an element(child) in link tag and assign that link to it.
        $('#block-views-related-clinics-block .item-list li').each(function(){

            var clinitLinkTitle = $(this).find('h3 a').attr('href');
            $(this).find(".service_clinic_img img").wrap("<a class='service_clinic_image'> </a>");

            $(this).find('.service_clinic_image').attr('href', clinitLinkTitle);

            $(this).find('.service_clinic_readmore a').attr('href', clinitLinkTitle);
        });

        $('.i18n-lv #block-views-related-clinics-block > h2').text('KLĪNIJAS, KAS PIEDĀVĀ ŠO PAKALPOJUMU');
        $('.i18n-ru #block-views-related-clinics-block > h2').text('КЛИНИКИ, ПРЕДЛАГАЮЩИЕ ЭТУ СЕРВИС');
        $('.i18n-lv #block-views-related-clinics-block .service_clinic_readmore a').text('Lasīt vairāk');
        $('.i18n-ru #block-views-related-clinics-block .service_clinic_readmore a').text('Прочитайте больше');


        // Counting the number of the child element... and allping condition 
        $('#block-views-related-clinics-block .item-list li').each(function(){
            var matched = $(this).find(".services_clinic_address_flag img").length;

            if(matched > 3){
                $(this).addClass('service_clinic_three_lang');
            };

        });











  });





   })(jQuery);

  