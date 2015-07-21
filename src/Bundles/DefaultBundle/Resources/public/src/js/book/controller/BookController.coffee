
moment = require "moment"
_ = require "underscore"


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
      http.post Routing.generate 'api_book_post_create', {key: stateParams.requestId}
      .success (res) ->
        console.log res
    http.get Routing.generate 'api_book_get_data', {key: stateParams.requestId}
      .success (res) ->
        viewLoader.hideLoader()
        scope.tickets.push res.data.ticket
        scope.form =  res.form



]
