global.moment = global.moment || require('moment')
loc = require('moment/locale/ru')
scopeValuesSetter = require "./scopeCreator"
datePickers = {}
DatePicker = require "./datepicker"

module.exports = [
  '$document'
  ($document) ->
    restrict: 'EA'
    require: 'ngModel'
    replace: true
    scope: {}
    link: (scope, element, attr, ngModel) ->
      datePicker = new DatePicker moment(), scope
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

    templateUrl: 'datepicker.html'

]
