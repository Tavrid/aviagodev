ko = require "knockout"
_ = require "underscore"
resolveField = (objList) ->
  objList = objList || [{},{}]
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
    @reverseCity = ->
      cityFromTemp = @cityFrom()
      cityFromCodeTemp = @cityFromCode()
      @cityFrom(@cityTo())
      @cityFromCode(@cityToCode())
      @cityTo(cityFromTemp)
      @cityToCode(cityFromCodeTemp)




module.exports = class ViewModel
  constructor: ->
    @dateFrom = ko.observable(searchForm.dateFrom)
    @dateTo = ko.observable(searchForm.dateTo)

    @direction = ko.observable(""+searchForm.returnWay)
    @cityFrom = ko.observable searchForm.cityFrom
    @cityFromCode = ko.observable searchForm.cityFromCode

    @cityTo = ko.observable searchForm.cityTo
    @cityToCode = ko.observable searchForm.cityToCode

    @adults = ko.observable searchForm.adults
    @children = ko.observable searchForm.children
    @infant = ko.observable searchForm.infant

    @aviaCompany = ko.observable searchForm.aviaCompany
    @aviaClass = ko.observable searchForm.aviaClass
    @currency = ko.observable searchForm.currency
    @bestPrice = ko.observable if searchForm.bestPrice == "" then true else searchForm.bestPrice
    @directFlights = ko.observable searchForm.directFlights
    @changeDirection= ->

    @disableDateTo = ko.computed =>
      parseInt(@direction()) != 0

    @complexSearch= ko.computed =>
      parseInt(@direction()) == 2
    @complexFields= ko.observableArray(resolveField searchForm.complexFields)
    @addLocation = ->
      @complexFields.push new ComplexSearch

    @removeLocation = (o)=>
      if @complexFields().length > 2
        @complexFields.remove o