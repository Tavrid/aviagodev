moment = require "moment"
module.exports = class
  constructor: (@date, @minDate = moment(), @maxDate) ->
    now = moment()
    @current = if @date then @date.isSame now, 'day' else false
    @selected = false
    @enabled = if @date then @minDate.isSame(@date, 'day') || @date.isAfter(@minDate, 'day') else true
    if @maxDate
      @enabled = if @date then (@maxDate.isSame(@date, 'day') || @date.isBefore(@maxDate, 'day')) && @enabled else @enabled
    @between = false
    @day = ''
    if @date
      @day = @date.format "D"

  ###
  * Set selected
  ###
  setSelectedDate: (date) ->
    @selected = if (date && @date) then @date.isSame date, 'day' else false