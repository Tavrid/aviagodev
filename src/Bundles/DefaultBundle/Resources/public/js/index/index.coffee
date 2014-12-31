ko = require "knockout"
ko.bindingHandlers.valueWithInit = init: (element, valueAccessor, allBindingsAccessor, data, context) ->
  bindings = valueAccessor()
  Object.keys(bindings).forEach (key) ->
    observable = bindings[key]
    binding = {}
    switch key
      when "value"
        initialValue = element.value
      when "text"
        initialValue = $(element).text()
    spl = observable.split(".")
    if spl.length > 1
      data[spl[0]][spl[1]] = ko.observable()  unless ko.isWriteableObservable(data[spl[0]][spl[1]])
      data[spl[0]][spl[1]] initialValue
      binding[key] = data[spl[0]][spl[1]]
      ko.applyBindingsToNode element, binding, context
    else
      data[spl[0]] = ko.observable()  unless ko.isWriteableObservable(data[spl[0]])
      data[spl[0]] initialValue
      binding[key] = data[spl[0]]
      ko.applyBindingsToNode element, binding, context
    return

  return
class ViewModel
  constructor: ->
    @direction = ko.observable(searchForm.returnWay)
    @changeDirection= ->

    @disableDateTo = ko.computed =>
      parseInt(@direction()) != 0

    @complexSearch= ko.computed =>
      parseInt(@direction()) == 2

    @complexFields= ko.observableArray([1])

ko.applyBindings new ViewModel
console.log searchForm