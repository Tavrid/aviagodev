ko = require "knockout"
_ = require "underscore"
resolveField = (objList) ->
#  objList = if objList instanceof Object then
  objList = if objList && objList.length > 0 then objList else [{},{}]
  retList = []
  _.each objList,(obj)->
    retList.push new ComplexSearch obj
  return retList

class ComplexSearch
  constructor: (o = {}) ->
    @cityFrom = ko.observable o.cityFrom
    @cityFromCode = ko.observable o.cityFromCode
    @cityTo = ko.observable o.cityTo
    @cityToCode = ko.observable o.cityToCode
    @date = ko.observable o.date
    @minDate = 0





module.exports = class ViewModel
  constructor: ->
    @dateFrom = ko.observable(searchForm.date_from)
    @dateTo = ko.observable(if searchForm.date_to && searchForm.date_to!= "0"  then searchForm.date_to)

    @direction = if searchForm.return_way != undefined then ko.observable ""+searchForm.return_way else ko.observable "1"
    @cityFrom = ko.observable searchForm.city_from
    @cityFromCode = ko.observable searchForm.city_from_code

    @cityTo = ko.observable searchForm.city_to
    @cityToCode = ko.observable searchForm.city_to_code

    @adults = ko.observable searchForm.adults
    @children = ko.observable searchForm.children
    @infant = ko.observable searchForm.infant

    @aviaCompany = ko.observable searchForm.avia_company
    @aviaClass = ko.observable searchForm.avia_class
    @bestPrice = ko.observable if searchForm.best_price == undefined then true else searchForm.best_price
    @directFlights = ko.observable searchForm.direct_flights
    @changeDirection= ->

    @disableDateTo = ko.computed =>
      parseInt(@direction()) == 1

    @complexSearch= ko.computed =>
      parseInt(@direction()) == 2

    @complexFields= ko.observableArray(resolveField searchForm.complexFields)
    @addLocation = ->
      if @complexFields().length < global.numComplexFields
        @complexFields.push new ComplexSearch
    @viewAddButton = =>
      @complexFields().length < global.numComplexFields && parseInt(@direction()) == 2
    @viewDeleteButton = =>
      @complexFields().length > 2
    @removeLocation = (o)=>
      if @complexFields().length > 2
        @complexFields.remove o
    @reverseCity = ->
      cityFromTemp = @cityFrom()
      cityFromCodeTemp = @cityFromCode()
      @cityFrom(@cityTo())
      @cityFromCode(@cityToCode())
      @cityTo(cityFromTemp)
      @cityToCode(cityFromCodeTemp)