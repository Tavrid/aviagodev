module.exports = (scope, attrs, datePickers) ->
  class
    constructor: (@day = null, @month = null, @year = null, minDay) ->
      @current = false
      @selected = false
      @enabled = false
      @between = false
      if @day && @month && @year
        currentDate = moment({y: @year, M: @month, d: @day})
        @current = moment().isSame(currentDate, 'days')
        @enabled = minDay.isBefore(currentDate)

        if scope.highlightBetween
          left = if attrs.maxFrom  then scope else if attrs.minFrom && datePickers[attrs.minFrom] then datePickers[attrs.minFrom]
          right = if attrs.minFrom  then scope else if attrs.maxFrom && datePickers[attrs.maxFrom] then datePickers[attrs.maxFrom]
          if left && left.selectedDate && right && right.selectedDate
            @between = (currentDate.isAfter(left.selectedDate) && currentDate.isBefore(right.selectedDate)) || currentDate.isSame(left.selectedDate) || currentDate.isSame(right.selectedDate)

        if scope.selectedDate
          @selected = currentDate.isSame(scope.selectedDate, 'days')