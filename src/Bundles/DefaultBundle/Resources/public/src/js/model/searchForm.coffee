
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

  constructor: (attr = {}) ->
    @formValue = attr

  viewAdditionalFields: false
  addComplexField: ->
    @complexFields.push(new ComplexField)

  getUrl: () ->
    if !@isComplexSearch()
      routeParams = {}
      _.each @formValue, (num,key) ->
        if num
          routeParams[key] = num.data

      routeParams.direction = @getSearchDirection()
      return Routing.generate 'api_list_flight', routeParams

module.exports = SearchForm