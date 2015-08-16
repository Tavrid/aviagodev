module.exports = class
  constructor: (@date, @minDate, @maxDate) ->
    @current = false
    @selected = false
    @enabled = true
    @between = false
    @day = 1

  ###
  * Set selected
  ###
  setSelected: (flag) ->
