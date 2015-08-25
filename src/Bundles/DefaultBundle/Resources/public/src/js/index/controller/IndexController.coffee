scopePrepare = require "../../util/scopeUtils"
module.exports = [
  '$scope',
  '$http',
  '$location',
  'AutoCompleteReplacer',
  'SearchForm'
  '$viewLoader'
  (scope, http, location, AutoCompleteReplacer,searchForm,viewLoader) ->
    scopePrepare scope
    scope.$root.appCont = 'index'
    AutoCompleteReplacer.controllerScope = scope;

    scope.reverse = ->
      AutoCompleteReplacer.reverse()
    scope.searchForm = searchForm.createForm global.searchForm
    scope.mathes = []
    scope.searchFormOptions = global.searchFormOptions
    viewLoader.hideLoader()
    scope.search = ->
      scope.searchForm.getUrl (url) ->
        window.location = url
]
