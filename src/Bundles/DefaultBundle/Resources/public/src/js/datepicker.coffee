moment = require('moment')

module.exports = [
  '$document'
  ($document) ->

    setScopeValues = (scope, attrs) ->
      scope.id = attrs.attrId || ''
      scope.format = attrs.format || 'YYYY-MM-DD'
      scope.viewFormat = attrs.viewFormat || 'Do MMMM YYYY'
      scope.locale = attrs.locale || 'ru'
      scope.firstWeekDaySunday = scope.$eval(attrs.firstWeekDaySunday) || false
      scope.placeholder = attrs.placeholder || ''
      return

    {
      restrict: 'EA'
      require: '?ngModel'
      replace: true
      scope: {}
      link: (scope, element, attrs, ngModel) ->
        setScopeValues scope, attrs
        scope.calendarOpened = false
        scope.days = []
        scope.dayNames = []
        scope.viewValue = null
        scope.dateValue = null
        moment.locale scope.locale
        date = moment()

        generateCalendar = (date) ->
          lastDayOfMonth = date.endOf('month').date()
          month = date.month()
          year = date.year()
          n = 1
          firstWeekDay = date.set('date', 1).day()


          if firstWeekDay == 0
            firstWeekDay = 7

          if firstWeekDay != 1
            n -= firstWeekDay - 1
          scope.dateValue = date.format('MMMM YYYY')
          days = []
          i = n
          while i <= lastDayOfMonth
            if i > 0
              days.push
                day: i
                month: month + 1
                year: year
                enabled: true
            else
              days.push
                day: null
                month: null
                year: null
                enabled: false
            i += 1
          allDays = true
          week = []
          scope.days = []
          d = 0

          lastWeekDay = date.set('date', lastDayOfMonth).day()

          if lastWeekDay == 0
            lastWeekDay = 7
          end = lastDayOfMonth + (7-lastWeekDay)

          if firstWeekDay != 1
            end+= firstWeekDay
          while d < end
            if week.length >= 7 || d == (end-1)
              scope.days.push week
              week = []
            if days[d] != undefined
              week.push days[d]
            else
              week.push
                day: null
                month: null
                year: null
                enabled: false
            d++

          return

        generateDayNames = ->
          date = if scope.firstWeekDaySunday == true then moment('2015-06-07') else moment('2015-06-01')
          i=0
          while i < 7
            scope.dayNames.push date.format('ddd')
            date.add '1', 'd'
            i++
          return

        generateDayNames()

        scope.showCalendar = ->
          scope.calendarOpened = true
          generateCalendar date
          return

        scope.closeCalendar = ->
          scope.calendarOpened = false
          return

        scope.prevYear = ->
          date.subtract 1, 'Y'
          generateCalendar date
          return

        scope.prevMonth = ->
          date.subtract 1, 'M'
          generateCalendar date
          return

        scope.nextMonth = ->
          date.add 1, 'M'
          generateCalendar date
          return

        scope.nextYear = ->
          date.add 1, 'Y'
          generateCalendar date
          return

        scope.selectDate = (event, date) ->
          event.preventDefault()
          selectedDate = moment(date.day + '.' + date.month + '.' + date.year, 'DD.MM.YYYY')
          ngModel.$setViewValue selectedDate.format(scope.format)
          scope.viewValue = selectedDate.format(scope.viewFormat)
          scope.closeCalendar()
          return

        # if clicked outside of calendar
        classList = [
          'ng-datepicker'
          'ng-datepicker-input'
        ]
        if attrs.id != undefined
          classList.push attrs.id
        $document.on 'click', (e) ->
#          if $(e.target).attr('id') != scope.id
#            scope.closeCalendar()
#            scope.$apply()
#          console.log e
#          if !scope.calendarOpened
#            return
#          element = undefined
#          if !e.target
#            return
#          while element
#            id = element.id
#            classNames = element.className
#            if id != undefined
#              i = 0
#              while i < classList.length
#                if id.indexOf(classList[i]) > -1 || classNames.indexOf(classList[i]) > -1
#                  return
#                i += 1
#            element = element.parentNode
#          scope.closeCalendar()
#          scope.$apply()
          return
        return
      templateUrl: 'datepicker.html'
    }
]
