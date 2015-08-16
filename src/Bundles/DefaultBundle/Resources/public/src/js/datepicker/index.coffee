global.moment = require('moment')
loc = require('moment/locale/ru')
scopeValuesSetter = require "./scopeCreator"
datePickers = {}

module.exports = [
  '$document'
  ($document) ->
    restrict: 'EA'
    require: 'ngModel'
    replace: true
    scope: {}
    link: (scope, element, attr, ngModel) ->
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

      ###
      * prev date
      ###
      scope.prevDate = (duration = 'M')->

      ###
      * show calendar
      ###
      scope.showCalendar = ->

      ###
      * close calendar
      ###
      scope.closeCalendar = ->

]
