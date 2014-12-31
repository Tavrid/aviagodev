ko = require "knockout"
class ViewModel
  constructor: ->
    @direction = ko.observable($('input[name="search_form[return_way]"][checked=checked]').val())
    @changeDirection= ->

    @disableDateTo = ko.computed =>
      parseInt(@direction()) != 0

    @complexSearch= ko.computed =>
      console.log @direction(),parseInt(@direction()) != 2
      parseInt(@direction()) == 2

    @complexFields= ko.observableArray([1])

ko.applyBindings new ViewModel