module.exports = (scope,attrs) ->
  scope.id = attrs.attrId || ''
  scope.format = attrs.format || 'YYYY-MM-DD'
  scope.viewFormat = attrs.viewFormat || 'D MMMM, dd'
  scope.locale = attrs.locale || 'ru'
  scope.placeholder = attrs.placeholder || ''
  scope.calendarOpened = false
  scope.days = []
  scope.dayNames = []
  scope.viewValue = null
  scope.dateValue = null
  scope.date = moment()
  scope.selectedDate = null
  scope.highlightBetween = if attrs.highlightBetween then parseInt attrs.highlightBetween else true
  return