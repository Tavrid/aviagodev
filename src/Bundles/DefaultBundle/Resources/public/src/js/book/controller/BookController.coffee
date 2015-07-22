
moment = require "moment"
_ = require "underscore"

Object.deepExtend = (destination, source) ->
  for property of source

    if source[property] && (typeof source[property] == 'object' || typeof source[property] == 'function')
      destination[property] = destination[property] or {}
      arguments.callee destination[property], source[property]
    else
      destination[property] = source[property]
  destination

module.exports = [
  '$scope',
  '$http',
  '$location',
  'AutoCompleteReplacer'
  '$viewLoader'
  '$stateParams'
  (scope, http, location, AutoCompleteReplacer,viewLoader,stateParams) ->
    ###
      Create a serialized representation of an array, a plain object
    ###
    getFormParams = ->
      formPar = []
      getRecur = (data) ->
        if data.full_name != undefined
          if data.data
            formPar.push {name: data.full_name, value: data.data}
        else
          _.each data, (num) ->
            getRecur num

      getRecur scope.form
      $.param formPar

    scope.tickets = []
    scope.form = {}
    scope.book = () ->
      viewLoader.showLoader()
      http
        method: 'POST',
        url: Routing.generate('api_book_post_create', {key: stateParams.requestId}),
        data: getFormParams(),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      .success (res) ->
        Object.deepExtend scope.form, res.form
        viewLoader.hideLoader()

    http.get Routing.generate 'api_book_get_data', {key: stateParams.requestId}
      .success (res) ->
        viewLoader.hideLoader()
        scope.tickets.push res.data.ticket
        scope.form =  res.form



]
