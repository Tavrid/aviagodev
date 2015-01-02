ko = require "knockout"
_ = require "underscore"
require "./ko_autocomplete"

resolveField = (objList) ->
  retList = []
  defaultMap =
    city_from: null
    city_from_code: null
    city_to: null
    city_to_code: null
    date: null

  _.each objList,(obj)->
    ext = _.extend(defaultMap, obj)
    ext.city_from = ko.observable ext.city_from
    ext.city_from_code = ko.observable ext.city_from_code
    ext.city_to = ko.observable ext.city_to
    ext.city_to_code = ko.observable ext.city_to_code
    ext.date = ko.observable ext.date
    retList.push ext
  return retList


class ViewModel
  constructor: ->
    @direction = ko.observable(searchForm.returnWay)
    @changeDirection= ->

    @disableDateTo = ko.computed =>
      parseInt(@direction()) != 0

    @complexSearch= ko.computed =>
      parseInt(@direction()) == 2

    @complexFields= ko.observableArray(resolveField searchForm.complexFields)
    console.log @complexFields()
$(->
  vm = new ViewModel
  ko.applyBindings vm
  console.log  vm.direction.prototype
)
