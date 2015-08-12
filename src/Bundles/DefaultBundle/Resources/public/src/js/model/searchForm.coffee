
_ = require "underscore"


class SearchForm

  isSearchOneWay: () ->
    @getSearchDirection() == 1

  isSearchTwoWay: () ->
    @getSearchDirection() == 2

  isComplexSearch: () ->
    @getSearchDirection() == 3

  getSearchDirection: () ->
    @formValue.direction.data

  constructor: (@formValue = {},@formHelper) ->
    console.log @formValue

  viewAdditionalFields: false
  addComplexField: ->
    @complexFields.push(new ComplexField)

  getUrl: (fn) ->
    console.log @formValue
    @formHelper
      .post(Routing.generate('api_post_flight_url'),@formValue)
      .success (res) ->
        if res.is_valid
          fn res.url

module.exports = [
  '$formHelper'
  (formHelper) ->
    {
      createForm: (attr = {}) ->
        new SearchForm attr, formHelper
    }
]