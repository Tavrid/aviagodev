
_ = require "underscore"


class SearchForm

  isSearchOneWay: () ->
    @getSearchDirection() == 1

  isSearchTwoWay: () ->
    @getSearchDirection() == 2

  isComplexSearch: () ->
    @getSearchDirection() == 3

  getSearchDirection: () ->
    res = _.find @formValue.direction, (num)->
      num.data
    if res
      return parseInt res.value
    return 0

  constructor: (@formValue = {},@formHelper) ->
    console.log @formValue

  viewAdditionalFields: false
  addComplexField: ->
    @complexFields.push(new ComplexField)

  getUrl: (fn) ->
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