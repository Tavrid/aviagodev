SearchForm = require "../../model/searchForm"
scopePrepare = require "../../util/scopeUtils"
module.exports = [
  '$scope',
  '$http',
  '$location',
  'AutoCompleteReplacer',
  (scope, http, location, AutoCompleteReplacer) ->
    scopePrepare scope
    scope.$root.appCont = 'index'
    AutoCompleteReplacer.controllerScope = scope;

    scope.reverse = ->
      AutoCompleteReplacer.reverse()
    scope.searchForm = new SearchForm global.searchForm
    scope.mathes = []
    scope.searchFormOptions = global.searchFormOptions
    scope.search = ->
      window.location = scope.searchForm.getUrl()
]
