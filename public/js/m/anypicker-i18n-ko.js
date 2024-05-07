/* -----------------------------------------------------------------------------

  AnyPicker - Customizable Picker for Mobile OS
  Version 2.0.9
  Copyright (c)2017 Lajpat Shah
  Contributors : https://github.com/nehakadam/AnyPicker/contributors
  Repository : https://github.com/nehakadam/AnyPicker
  Homepage : https://nehakadam.github.io/AnyPicker

 ----------------------------------------------------------------------------- */

/*

	language: Korean
	file: AnyPicker-i18n-ko

*/

(function ($) {
    $.AnyPicker.i18n["ko"] = $.extend($.AnyPicker.i18n["ko"], {

        // Common

        headerTitle: "선택",
        setButton: "설정",
        clearButton: "지우기",
        nowButton: "지금",
        cancelButton: "취소",
        dateSwitch: "날짜",
        timeSwitch: "시간",

        // DateTime

        veryShortDays: "Su_Mo_Tu_We_Th_Fr_Sa".split("_"),
        shortDays: "Sun_Mon_Tue_Wed_Thu_Fri_Sat".split("_"),
        fullDays: "Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"),
        shortMonths: "Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec".split("_"),
        fullMonths: "1월_2월_3월_4월_5월_6월_7월_8월_9월_10월_11월_12월".split("_"),
        numbers: "0_1_2_3_4_5_6_7_8_9".split("_"),
        meridiem:
            {
                a: ["a", "p"],
                aa: ["am", "pm"],
                A: ["A", "P"],
                AA: ["AM", "PM"]
            },
        componentLabels: {
            date: "Date",
            day: "Day",
            month: "Month",
            year: "Year",
            hours: "Hours",
            minutes: "Minutes",
            seconds: "Seconds",
            meridiem: "Meridiem"
        }

    });

})(jQuery);