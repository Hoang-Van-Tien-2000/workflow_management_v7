moment.locale('vi', {
            months : 'Tháng Giêng_ Tháng Hai _Tháng Ba_ Tháng Tư_ Tháng Năm_ Tháng Sáu_ Tháng Bảy_ Tháng Tám_ Tháng Chín_ Tháng Mười_ Tháng Mười Một _Tháng Mười Hai'.split('_'),
            monthsShort : 'Tháng 1_Tháng 2_Tháng 3_Tháng 4_Tháng 5_Tháng 6_Tháng 7_Tháng 8_Tháng 9_Tháng 10_Tháng 11_Tháng 12'.split('_'),
            monthsParseExact : true,
            weekdays : 'Chủ nhật_Thứ hai_Thứ ba_Thứ tư_Thứ năm_Thứ sáu_Thứ bảy'.split('_'),
            weekdaysShort : '8._2._3._4._5._6._7.'.split('_'),
            weekdaysMin : '8._2._3._4._5._6._7.'.split('_'),
            weekdaysParseExact : true,
            longDateFormat : {
                LT : 'HH:mm',
                LTS : 'HH:mm:ss',
                L : 'DD/MM/YYYY',
                LL : 'D MMMM YYYY',
                LLL : 'D MMMM YYYY HH:mm',
                LLLL : 'dddd D MMMM YYYY HH:mm'
            },
            calendar : {
                sameDay : '[Hôm nay lúc] LT',
                nextDay : '[Ngày mai lúc] LT',
                nextWeek : 'dddd [Tuần tới lúc] LT',
                lastDay : '[Hôm qua lúc] LT',
                lastWeek : 'dddd [Tuần vừa rồi lúc] LT',
                sameElse : 'L'
            },
             relativeTime : {
                future : 'trong %s',
                past : '%s cách đây',
                s : '1 giây',
                ss : '%d giây',
                m : 'một phút',
                mm : '%d phút',
                h : '1 giờ',
                hh : '%d giờ',
                d : '1 ngày',
                dd : '%d ngày',
                M : '1 tháng',
                MM : '%d tháng',
                y : '1 năm',
                yy : '%d năm'
            },
            dayOfMonthOrdinalParse : /\d{1,2}(er|e)/,
            ordinal : function (number) {
                return number + (number === 1 ? 'er' : 'e');
            },
            meridiemParse : /PD|MD/,
            isPM : function (input) {
                return input.charAt(0) === 'M';
            },
            // In case the meridiem units are not separated around 12, then implement
            // this function (look at locale/id.js for an example).
            // meridiemHour : function (hour, meridiem) {
            //     return /* 0-23 hour, given meridiem token and hour 1-12 */ ;
            // },
            meridiem : function (hours, minutes, isLower) {
                return hours < 12 ? 'PD' : 'MD';
            },
            week : {
                dow : 1, // Monday is the first day of the week.
                doy : 4  // Used to determine first week of the year.
            }
        });