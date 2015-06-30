SearchForm = require "../model/searchForm"

module.exports = [
  '$scope',
  '$http',
  '$location',
  'AutoCompleteReplacer',
  (scope, http, location, AutoCompleteReplacer) ->
    AutoCompleteReplacer.controllerScope = scope;

    scope.reverse = ->
      AutoCompleteReplacer.reverse()
    scope.searchForm = new SearchForm location
    scope.mathes = []
    scope.searchFormOptions = global.searchFormOptions
    scope.search = ->
      console.log scope.searchForm.getUrl()
#      location.path scope.searchForm.getUrl()
]
