module.exports = (secs) ->
  sec_num = parseInt(secs, 10)
  # don't forget the second param
  hours = Math.floor(sec_num / 3600)
  minutes = Math.floor((sec_num - (hours * 3600)) / 60)
  seconds = sec_num - (hours * 3600) - (minutes * 60)
  return {
    h: hours
    m: minutes
    s: seconds
  }