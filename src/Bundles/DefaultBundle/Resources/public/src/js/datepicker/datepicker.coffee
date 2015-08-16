moment = require "moment"
calendarGenerator = require "./calendarGenerator"
module.exports = class
  constructor: (selectedDateString,@scope,@minDate = moment(), @maxDate = null) ->
    @selectedDate = moment selectedDateString
    @_startDate = @selectedDate.clone().startOf('month')
    @_endDate = @selectedDate.clone().endOf('month')

    dayNames = []
    now = moment("2014-12-01")
    i = 0
    while i < 7
      dayNames.push now.format('ddd')
      now.add '1', 'd'
      i++
    @scope.dayNames = dayNames

  ###
  * generate calendar from {startDate} and {endDate}
  ###
  generate: ()->
    calendarGenerator.apply @
  ###
  * next date
  ###
  nextDate: (duration = 'M')->
    @_startDate.add(1, duration).startOf('month')
    @_endDate = @_startDate.clone().endOf('month')
  ###
  * prev date
  ###
  prevDate: (duration = 'M')->
    @_startDate.subtract(1, duration).startOf('month')
    @_endDate = @_startDate.clone().endOf('month')
  ###
  * set min date
  ###
  setMinDate: (date) ->

  ###
  * set max date
  ###
  setMaxDate: (date) ->

  ###
  * select date
  ###
  selectDate: (date) ->