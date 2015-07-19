
moment = require "moment"
_ = require "underscore"


module.exports = [
  '$scope',
  '$http',
  '$location',
  'AutoCompleteReplacer'
  '$viewLoader'
  (scope, http, location, AutoCompleteReplacer,viewLoader) ->
    viewLoader.hideLoader()
    scope.tickets = []
    http.get Routing.generate 'api_book_get_data', {key: 'db3bfe2e67f026fe28ce4f4ea79236af'}
      .success (res) ->
        scope.tickets.push res.ticket



]
