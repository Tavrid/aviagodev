global.moment = require('moment')
loc = require('moment/locale/ru')
scopeValuesSetter = require "./scopeCreator"
datePickers = {}

module.exports = [
  '$document'
  ($document) ->


    {
    restrict: 'EA'
    require: 'ngModel'
    replace: true
    scope: {}
    link: (scope, element, attrs, ngModel) ->
      Day = require("./dayModel")(scope,attrs,datePickers)

      scopeValuesSetter scope, attrs

      moment.locale scope.locale, loc

      if attrs.name
        datePickers[attrs.name] = scope

      generateCalendar = (date = scope.date, minDate = if datePickers[attrs.minFrom] && datePickers[attrs.minFrom].selectedDate then datePickers[attrs.minFrom].selectedDate else moment().subtract(1, 'days')) ->
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
            days.push new Day i, month , year, minDate
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
        generateCalendar()
        return

      scope.closeCalendar = ->
        scope.calendarOpened = false
        return

      scope.prevYear = ->
        scope.date.subtract 1, 'Y'
        generateCalendar()
        return

      scope.prevMonth = ->
        scope.date.subtract 1, 'M'
        generateCalendar()
        return

      scope.nextMonth = ->
        scope.date.add 1, 'M'
        generateCalendar()
        return

      scope.nextYear = ->
        scope.date.add 1, 'Y'
        generateCalendar()
        return
      scope.updateInputValue = ->
        ngModel.$setViewValue scope.selectedDate.format(scope.format)
        scope.viewValue = scope.selectedDate.format(scope.viewFormat)
        return
      scope.selectDate = (event, date) ->
        return if !date.enabled
        event.preventDefault()
        scope.selectedDate = moment({y: date.year, M: date.month, d: date.day})
        scope.updateInputValue()
        #todo this need fix
        if attrs.maxFrom && datePickers[attrs.maxFrom] && (!(datePickers[attrs.maxFrom].selectedDate) || (datePickers[attrs.maxFrom].selectedDate && scope.selectedDate.isAfter(datePickers[attrs.maxFrom].selectedDate)))
          datePickers[attrs.maxFrom].date = scope.selectedDate.clone().add(1,'d')
          datePickers[attrs.maxFrom].selectedDate = datePickers[attrs.maxFrom].date
          datePickers[attrs.maxFrom].updateInputValue()

        scope.date = scope.selectedDate.clone()
        scope.closeCalendar()
        return

      $document.on 'click', (e) ->
        if ! $(e.target).parents('.ng-datepicker').length && !element.is(e.target) && element.has(e.target).length == 0
          scope.closeCalendar()
          scope.$apply()
      #        return
      return
    templateUrl: 'datepicker.html'
    }
]
