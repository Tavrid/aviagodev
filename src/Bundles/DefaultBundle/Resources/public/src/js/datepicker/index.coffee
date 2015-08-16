global.moment = global.moment || require('moment')
loc = require('moment/locale/ru')
datePickers = {}
DatePicker = require "./datepicker"

module.exports = [
  '$document'
  ($document) ->
    restrict: 'EA'
    require: 'ngModel'
    replace: true
    scope: {
      ngModel: '='
    }
    link: (scope, element, attr, ngModel) ->
      viewDateFormat = attr.viewFormat || 'D MMMM, dd'
      modelDateFormat = attr.format || 'YYYY-MM-DD'
      scope.$watch 'ngModel', (newValue) ->
        if newValue
          selectedDate =  moment(newValue)
          scope.viewValue =selectedDate.format viewDateFormat
          datePicker.selectedDate = selectedDate

      datePicker = new DatePicker null, scope, ngModel

      updateDate = ->
        ngModel.$setViewValue datePicker.selectedDate.format modelDateFormat

      scope.id = attr.attrId || ''
      ###
      * list of weeks
      ###
      scope.weeks = []

      ###
      * visible calendar in view
      ###
      scope.calendarIsVisible = false

      ###
      * next date
      ###
      scope.nextDate = (duration = 'M')->
        datePicker.nextDate duration
        scope.showCalendar()
      ###
      * prev date
      ###
      scope.prevDate = (duration = 'M')->
        datePicker.prevDate duration
        scope.showCalendar()
      ###
      * show calendar
      ###
      scope.showCalendar = ->
        datePicker.generate()
        scope.calendarIsVisible = true
      ###
      * close calendar
      ###
      scope.closeCalendar = ->
        scope.calendarIsVisible = false
      ###
      * select date
      ###
      scope.selectDate = (day) ->
        datePicker.selectDate(day)
        updateDate()

      $document.on 'click', (e) ->
        if e.target.className.indexOf("ng-datepicker_x_#{ scope.id }") == -1
          scope.closeCalendar()
          scope.$apply()

    templateUrl: 'datepicker.html'

]
