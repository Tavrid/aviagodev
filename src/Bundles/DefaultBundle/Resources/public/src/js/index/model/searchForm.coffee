v = require "validate-obj"
assertions =
  arrivalDate: [v.required, v.isDate]
  departureDate: [v.required, v.isDate]
  direction: [v.required]
  complexFields: {arrivalDate: [[v.required, v.isDate]]}

class ComplexField

class SearchForm
  constructor: () ->
  direction: 2
  viewAdditionalFields: false
  complexFields: [new ComplexField, new ComplexField]
  addComplexField: ->
    @complexFields.push(new ComplexField)


module.exports = SearchForm