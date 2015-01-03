module.exports = class Delay
  timer = null
  setTimeout: (fn,time)->
    clearTimeout(timer)
    timer = setTimeout(fn,time)
    return undefined