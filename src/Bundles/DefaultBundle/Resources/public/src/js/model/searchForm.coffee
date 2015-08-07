
_ = require "underscore"


class SearchForm

  constructor: (attr = {}) ->
    @formValue = attr

  viewAdditionalFields: false
  addComplexField: ->
    @complexFields.push(new ComplexField)

  getUrl: () ->
    Routing.generate 'api_list_flight', @formValue

module.exports = SearchForm