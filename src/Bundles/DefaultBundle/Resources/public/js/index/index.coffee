ko = require "knockout"
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