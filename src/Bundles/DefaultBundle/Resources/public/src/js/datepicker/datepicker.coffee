moment = require "moment"
module.exports = class
  startDate = null
  minDate = null
  constructor: (@selectedDate = moment(),@maxDate = null,@minDate = null) ->

  ###
  * generate calendar from {startDate} and {endDate}
  ###
  generate: ->

  ###
  * next date
  ###
  nextDate: (duration = 'M')->

  ###
  * prev date
  ###
  prevDate: (duration = 'M')->

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