#
#v = require "validate-obj"
#assertions =
#  arrivalDate: [v.required, v.isDate]
#  departureDate: [v.required, v.isDate]
#  direction: [v.required]
#  complexFields: {arrivalDate: [[v.required, v.isDate]]}
_ = require "underscore"
class ComplexField

class SearchForm

  defaultOpt = {
    arrivalCode: null
    departureCode: null
    arrivalDate: null
    departureDate: 0
    bestPrice: 1
    direction: 1
    adults: '1'
    children: '0'
    infant: '0'
    airline: 'all',
    serviceClass: 'Y'
    directFlights: 0

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
    } = _.extend defaultOpt, attr

  viewAdditionalFields: false
  complexFields: [new ComplexField, new ComplexField]
  addComplexField: ->
    @complexFields.push(new ComplexField)

  getUrl: () ->
    formValues =  {
      arrivalCode: @arrivalCode
      departureCode: @departureCode
      arrivalDate: @arrivalDate
      departureDate: @departureDate
      bestPrice: @bestPrice
      adults: @adults
      direction: @direction
      children: @children
      infant: @infant
      serviceClass: @serviceClass
      airline: @airline
      directFlights: @directFlights
    }
    Routing.generate 'api_list_flight', formValues
module.exports = SearchForm