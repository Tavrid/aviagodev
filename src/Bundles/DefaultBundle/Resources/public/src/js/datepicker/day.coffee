moment = require "moment"
module.exports = class
  constructor: (@date, @minDate = moment(), @maxDate) ->
    now = moment()
    @current = if @date then @date.isSame now, 'day' else false
    @selected = false
    @enabled = true
    @between = false
    @day = ''
    if @date
      @day = @date.format "D"

  ###
  * Set selected
  ###
  setSelectedDate: (date) ->
    @selected = if (date && @date) then @date.isSame date, 'day' else false