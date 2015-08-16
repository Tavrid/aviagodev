module.exports = class
  constructor: (@date, @minDate, @maxDate) ->
    @current = false
    @selected = false
    @enabled = true
    @between = false
    @day = ''
    if @date
      @day = @date.format "D"

  ###
  * Set selected
  ###
  setSelected: (flag) ->
