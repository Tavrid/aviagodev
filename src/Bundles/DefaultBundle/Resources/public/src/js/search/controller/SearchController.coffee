SearchForm = require "../../model/searchForm"

module.exports = [
  '$scope',
  '$http',
  '$location',
  'AutoCompleteReplacer',
  (scope, http, location, AutoCompleteReplacer) ->
    scope.$root.appCont = 'search'
    scope.searchForm = new SearchForm global.formValues
    http.get Routing.generate 'bundles_default_api_flights_items', global.formValues
      .success (res) ->
        console.log res
    scope.reverse = ->
      AutoCompleteReplacer.reverse()
]
