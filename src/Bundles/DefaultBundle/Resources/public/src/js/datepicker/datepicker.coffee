moment = require "moment"
calendarGenerator = require "./calendarGenerator"
_ = require "underscore"
module.exports = class
  constructor: (selectedDateString,@scope,@ngModel,@minDate = moment(), @maxDate = null) ->
    @selectedDate = if selectedDateString then moment selectedDateString else moment()
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
  setSelectedDate: (date) ->
    @selectedDate = date
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
    @minDate = date.date
    if @minDate.isAfter @selectedDate, 'day'
      @selectedDate = @minDate.clone()
    @_startDate = @minDate.clone().startOf('month')
    @_endDate = @selectedDate.clone().endOf('month')

  ###
  * set max date
  ###
  setMaxDate: (date) ->
    @maxDate = date.date
    if @maxDate.isBefore @selectedDate, 'day'
      @selectedDate = @maxDate.clone()
    @_startDate = @maxDate.clone().startOf('month')
    @_endDate = @selectedDate.clone().endOf('month')
  ###
  * select date
  ###
  selectDate: (date) ->
    if date.enabled
      _.each @scope.weeks, (week) =>
        _.each week, (d) =>
          d.selected = d == date
          if d.selected
            @selectedDate = date.date