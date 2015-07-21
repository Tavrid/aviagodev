
moment = require "moment"
_ = require "underscore"

Object.deepExtend = (destination, source) ->
  for property of source
    if property == 'Sex'
      console.log arguments.callee

    if source[property] and source[property].constructor and source[property].constructor == Object
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
#    console.log stateParams
#    viewLoader.showLoader()
    scope.tickets = []
    scope.form = {}
    scope.book = () ->
      viewLoader.showLoader()
      http.post Routing.generate('api_book_post_create', {key: stateParams.requestId}), {name: {foo:'var'}}
      .success (res) ->
        Object.deepExtend scope.form, res.form
        console.log scope.form
        viewLoader.hideLoader()
    http.get Routing.generate 'api_book_get_data', {key: stateParams.requestId}
      .success (res) ->
        viewLoader.hideLoader()
        scope.tickets.push res.data.ticket
        scope.form =  res.form



]
