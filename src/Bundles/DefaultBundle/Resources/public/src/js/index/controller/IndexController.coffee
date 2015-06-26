SearchForm = require "../model/searchForm"

module.exports = [
  '$scope',
  '$http',
  'AutoCompleteReplacer',
  (scope,http,AutoCompleteReplacer) ->
    AutoCompleteReplacer.controllerScope = scope;

    scope.reverse = ->
      AutoCompleteReplacer.reverse()
    scope.searchForm = new SearchForm
    scope.mathes = []
]
