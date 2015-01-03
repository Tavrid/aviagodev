ko = require "knockout"
_ = require "underscore"
require "./ko_autocomplete"

class ComplexSearch
  constructor: (o) ->
    @city_from = ko.observable o.city_from
    @city_from_code = ko.observable o.city_from_code
    @city_to = ko.observable o.city_to
    @city_to_code = ko.observable o.city_to_code
    @date = ko.observable o.date
resolveField = (objList) ->
  objList = objList || [new ComplexSearch({}),new ComplexSearch({})]
  retList = []


  _.each objList,(obj)->
    retList.push new ComplexSearch obj
  return retList


class ViewModel
  constructor: ->
    @direction = ko.observable(searchForm.returnWay)
    @cityFrom = ko.observable searchForm.cityFrom
    @cityFromCode = ko.observable searchForm.cityFromCode

    @cityTo = ko.observable searchForm.cityTo
    @cityToCode = ko.observable searchForm.cityToCode

    @changeDirection= ->

    @disableDateTo = ko.computed =>
      parseInt(@direction()) != 0

    @complexSearch= ko.computed =>
      parseInt(@direction()) == 2
    @complexFields= ko.observableArray(resolveField searchForm.complexFields)
    @addLocation = ->
      @complexFields.push new ComplexSearch {}

$(->
  vm = new ViewModel
  ko.applyBindings vm
)
