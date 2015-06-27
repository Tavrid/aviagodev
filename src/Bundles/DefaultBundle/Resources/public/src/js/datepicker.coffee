global.moment = require('moment')
loc = require('moment/locale/ru')


module.exports = [
  '$document'
  ($document) ->


    setScopeValues = (scope, attrs) ->
      scope.id = attrs.attrId || ''
      scope.format = attrs.format || 'YYYY-MM-DD'
      scope.viewFormat = attrs.viewFormat || 'D MMMM, dd'
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

      selectedDate = null
      class Day
        constructor: (@day = null, @month = null, @year = null, @enabled = false) ->
          @current = false
          @selected = false
          if @day && @month && @year
            currentDate = moment({y: @year, M: @month, d: @day})
            @current = moment().isSame(currentDate,'days')
            if selectedDate
              @selected = currentDate.isSame(selectedDate,'days')


      setScopeValues scope, attrs
      scope.calendarOpened = false
      scope.days = []
      scope.dayNames = []
      scope.viewValue = null
      scope.dateValue = null
      moment.locale scope.locale, loc
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
            days.push new Day i, month , year, true
          else
            days.push new Day
          i += 1
        week = []
        scope.days = []
        d = 0

        lastWeekDay = date.set('date', lastDayOfMonth).day()

        if lastWeekDay == 0
          lastWeekDay = 7
        end = lastDayOfMonth + (7 - lastWeekDay)

        if firstWeekDay != 1
          end += firstWeekDay
        while d < end
          if week.length >= 7 || d == (end - 1)
            scope.days.push week
            week = []
          if days[d] != undefined
            week.push days[d]
          else
            week.push new Day
          d++

        return

      generateDayNames = ->
        now = moment("2014-12-01")
        i = 0
        while i < 7
          scope.dayNames.push now.format('ddd')
          now.add '1', 'd'
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
        selectedDate = moment({y: date.year, M: date.month, d: date.day})
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
        if ! $(e.target).parents('.ng-datepicker').length && !element.is(e.target) && element.has(e.target).length == 0
          scope.closeCalendar()
          scope.$apply()
#        return
      return
    templateUrl: 'datepicker.html'
    }
]
