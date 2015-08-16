Day = require "./day"
module.exports = () ->
  lastDayOfMonth = @_endDate.date()
  n = 1
  firstWeekDay = @_startDate.day()


  if firstWeekDay == 0
    firstWeekDay = 7

  if firstWeekDay != 1
    n -= firstWeekDay - 1
  days = []
  i = n
  while i <= lastDayOfMonth
    if i > 0
      days.push new Day i
    else
      days.push new Day
    i += 1
  week = []
  console.log days
  @scope.weeks = []
  d = 0

  lastWeekDay = @_endDate.day()

  if lastWeekDay == 0
    lastWeekDay = 7
  end = lastDayOfMonth + (7 - lastWeekDay)

  if firstWeekDay != 1
    end += firstWeekDay
  while d < end
    if week.length >= 7 || d == (end - 1)
      @scope.weeks.push week
      week = []
    if days[d] != undefined
      week.push days[d]
    else
      week.push new Day
    d++