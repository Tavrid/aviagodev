v = require "validate-obj"
assertions =
  arrivalDate: [v.required, v.isDate]
  departureDate: [v.required, v.isDate]
  direction: [v.required]
  complexFields: {arrivalDate: [[v.required, v.isDate]]}

class ComplexField

class SearchForm
  defaultOpt = {
    arrivalCode: null
    departureCode: null
    arrivalDate: null
    departureDate: null
    bestPrice: 1
    direction: 1
    adults: '1'
    children: '0'
    infant: '0'
    airline: 'all',
    serviceClass: 'Y'
    directFlights: '0'

  }
  constructor: (attr = {}) ->
    {
    @arrivalCode
    @departureCode
    @arrivalDate
    @departureDate
    @bestPrice
    @direction
    @adults
    @children
    @infant
    @airline
    @serviceClass
    @directFlights
    } = $.extend defaultOpt, attr

  viewAdditionalFields: false
  complexFields: [new ComplexField, new ComplexField]
  addComplexField: ->
    @complexFields.push(new ComplexField)

  getUrl: () ->
#    /flights/{arrivalCode}/{departureCode}/{arrivalDate}/{departureDate}/{bestPrice}/{adults}/{direction}/{children}/{infant}/{serviceClass}/{airline}/{directFlights}
    formValues =  {
      arrivalCode: @arrivalCode
      departureCode: @departureCode
      arrivalDate: @arrivalDate
      departureDate: @departureDate
      bestPrice: @bestPrice
      direction: @direction
      adults: @adults
      children: @children
      infant: @infant
      airline: @airline
      serviceClass: @serviceClass
      directFlights: @directFlights
    }
    Routing.generate 'bundles_default_api_list', formValues
module.exports = SearchForm