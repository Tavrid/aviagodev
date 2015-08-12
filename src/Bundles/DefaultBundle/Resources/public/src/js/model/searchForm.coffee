
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

  constructor: (@formValue = {},@formHelper,@viewLoader) ->

  viewAdditionalFields: false
  addComplexField: ->
    @complexFields.push(new ComplexField)

  getUrl: (fn) ->
    viewLoader = @viewLoader
    viewLoader.showLoader()
    @formHelper
      .post(Routing.generate('api_post_flight_url'),@formValue)
      .success (res) ->
        viewLoader.hideLoader()
        if res.is_valid
          fn res.url
      .error () ->
        viewLoader.hideLoader()
module.exports = [
  '$formHelper'
  '$viewLoader'
  (formHelper,viewLoader) ->
    {
      createForm: (attr = {}) ->
        new SearchForm attr, formHelper,viewLoader
    }
]