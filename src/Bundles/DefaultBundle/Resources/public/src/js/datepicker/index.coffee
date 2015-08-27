global.moment = global.moment || require('moment')
loc = require('moment/locale/ru')

DatePicker = require "./datepicker"

class DatePickerInterval
  datePickers = []
  add: (name,datePicker,minTo,maxTo) ->
    if typeof datePickers[name] != 'undefined'
      throw new Error "Datepicker with #{name} already exist!"
    datePickers[name] = datePicker
    selectDate = datePicker.selectDate
    datePicker.selectDate = (day) ->
      selectDate.apply datePicker, arguments
      console.log minTo
      if minTo && typeof  datePickers[minTo] != 'undefined'
        datePickers[minTo].setMinDate day
      if maxTo && typeof  datePickers[maxTo] != 'undefined'
        datePickers[maxTo].setMaxDate day

dPickerInterval = new DatePickerInterval
module.exports = [
  '$document'
  ($document) ->
    restrict: 'EA'
    require: '^ngModel'
    replace: true
    scope: {
      ngModel: '='
    }
    link: (scope, element, attr, ngModel) ->
      viewDateFormat = attr.viewFormat || 'D MMMM, dd'
      modelDateFormat = attr.format || 'YYYY-MM-DD 00:00:00'
      scope.$watch 'ngModel', (newValue) ->
        if newValue
          selectedDate =  moment(newValue)
          scope.viewValue =selectedDate.format viewDateFormat
          datePicker.setSelectedDate selectedDate

      datePicker = new DatePicker null, scope, ngModel

      dPickerInterval.add attr.name, datePicker, attr.minTo, attr.maxTo

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
