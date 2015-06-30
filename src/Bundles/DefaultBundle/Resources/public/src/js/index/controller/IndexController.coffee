SearchForm = require "../model/searchForm"

module.exports = [
  '$scope',
  '$http',
  '$location',
  'AutoCompleteReplacer',
  (scope, http, location, AutoCompleteReplacer) ->
    scope.$root.appCont = 'index'
    AutoCompleteReplacer.controllerScope = scope;

    scope.reverse = ->
      AutoCompleteReplacer.reverse()
    scope.searchForm = new SearchForm location
    scope.mathes = []
    scope.searchFormOptions = global.searchFormOptions
    scope.search = ->
      location.path scope.searchForm.getUrl().replace '/app_dev.php',''
]
