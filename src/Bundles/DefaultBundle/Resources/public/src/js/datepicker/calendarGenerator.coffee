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
    d = @_startDate.clone()
    if i > 0
      d.set('date', i)
      day = new Day d
    else
      day = new Day
    day.setSelectedDate(@selectedDate)
    days.push day
    i++
  week = []
  weeks = []
  d = 0

  lastWeekDay = @_endDate.day()

  if lastWeekDay == 0
    lastWeekDay = 7
  end = lastDayOfMonth + (7 - lastWeekDay)

  if firstWeekDay != 1
    end += firstWeekDay
  while d < end
    if week.length >= 7 || d == (end - 1)
      weeks.push week
      week = []
    if days[d] != undefined
      week.push days[d]
    else
      week.push new Day
    d++

  @scope.weeks = weeks
  @scope.monthName = @_startDate.format 'MMMM YYYY'