
class ComplexField

class SearchForm
  constructor: ->

  direction: 2
  viewAdditionalFields: false
  complexFields: [new ComplexField, new ComplexField]
  addComplexField: ->
    @complexFields.push(new ComplexField)
  search: () ->
    console.log(@)

module.exports = SearchForm