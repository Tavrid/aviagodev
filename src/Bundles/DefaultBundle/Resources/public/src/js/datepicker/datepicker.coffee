moment = require "moment"
calendarGenerator = require "./calendarGenerator"
module.exports = class
  constructor: (selectedDateString,@scope,@maxDate = null,@minDate = null) ->
    @selectedDate = moment selectedDateString
    @_startDate = @selectedDate.clone().startOf('month')
    @_endDate = @selectedDate.clone().endOf('month')

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
    @_endDate = startDate.clone().endOf('month')
  ###
  * prev date
  ###
  prevDate: (duration = 'M')->
    @_startDate.substract(1, duration).startOf('month')
    @_endDate = startDate.clone().endOf('month')
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