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
    link: (scope, element, attr, ngModel) ->

      Day = require("./dayModel")(scope,attr,datePickers)

      scopeValuesSetter scope, attr

      moment.locale scope.locale, loc

      if attr.name
        datePickers[attr.name] = scope

      generateCalendar = (date = scope.date, minDate = if datePickers[attr.minFrom] && datePickers[attr.minFrom].selectedDate then datePickers[attr.minFrom].selectedDate else moment().subtract(1, 'days')) ->
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

      generateDayNames = ->
        now = moment("2014-12-01")
        i = 0
        while i < 7
          scope.dayNames.push now.format('ddd')
          now.add '1', 'd'
          i++

      generateDayNames()

      scope.showCalendar = ->
        scope.calendarOpened = true
        generateCalendar()

      scope.closeCalendar = ->
        scope.calendarOpened = false

      scope.prevYear = ->
        scope.date.subtract 1, 'Y'
        generateCalendar()

      scope.prevMonth = ->
        scope.date.subtract 1, 'M'
        generateCalendar()

      scope.nextMonth = ->
        scope.date.add 1, 'M'
        generateCalendar()

      scope.nextYear = ->
        scope.date.add 1, 'Y'
        generateCalendar()

      scope.updateInputValue = ->
        ngModel.$setViewValue scope.selectedDate.format(scope.format)
        scope.viewValue = scope.selectedDate.format(scope.viewFormat)

      scope.selectDate = (event, date) ->
        return if !date.enabled
        event.preventDefault()
        scope.selectedDate = moment({y: date.year, M: date.month, d: date.day})
        scope.updateInputValue()
        #todo this need fix
        if attr.maxFrom && datePickers[attr.maxFrom] && (!(datePickers[attr.maxFrom].selectedDate) || (datePickers[attr.maxFrom].selectedDate && scope.selectedDate.isAfter(datePickers[attr.maxFrom].selectedDate)))
          datePickers[attr.maxFrom].date = scope.selectedDate.clone().add(1,'d')
          datePickers[attr.maxFrom].selectedDate = datePickers[attr.maxFrom].date
          datePickers[attr.maxFrom].updateInputValue()

        scope.date = scope.selectedDate.clone()
        scope.closeCalendar()

      $document.on 'click', (e) ->
        if e.target.className.indexOf("ng-datepicker_x_#{ scope.id }") == -1
          scope.closeCalendar()
          scope.$apply()
      #        return
    templateUrl: 'datepicker.html'
    }
]
