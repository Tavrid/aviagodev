
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
###
###
prepareFormData = (data) ->
  _.each data, (property) ->
    if property && property.errors != undefined
      property.errors = []
    else if property && typeof property != 'string' && typeof property != 'number' && typeof property != 'boolean'
      prepareFormData property
  return

module.exports = [
  '$scope',
  '$http',
  '$location',
  'AutoCompleteReplacer'
  '$viewLoader'
  '$stateParams'
  '$formHelper'
  (scope, http, location, AutoCompleteReplacer,viewLoader,stateParams,formHelper) ->

    scope.tickets = []
    scope.form = {}

    scope.toggleCheckbox= (parent,child) ->
      newChildVal = !child.data
      _.each parent, (ch) ->
        ch.data = false
      child.data = newChildVal

    scope.book = () ->
      viewLoader.showLoader()
      formHelper
        .post(Routing.generate('api_book_post_create', {key: stateParams.requestId}),scope.form)
          .success (res) ->
            prepareFormData scope.form
            Object.deepExtend scope.form, res.form
            viewLoader.hideLoader()
            if res.is_valid
              location.path url
          .error  ->
            viewLoader.hidelLoader()

    http.get Routing.generate 'api_book_get_data', {key: stateParams.requestId}
      .success (res) ->
        viewLoader.hideLoader()
        scope.tickets.push res.data.ticket
        scope.form =  res.form



]
